<?php

/**
 * @package nxcVarnish
 * @class   nxcVarnish
 * @author  Serhey Dolgushev <serhey.dolgushev@nxc.no>
 * @date    23 Jan 2013
 * */
class nxcVarnish {

    private static $instance       = null;
    private static $installationID = null;
    private $servers               = array();

    private function __construct() {
        $ini = eZINI::instance( 'varnish.ini' );
        if( $ini->hasVariable( 'General', 'VarnishServers' ) === false ) {
            return;
        }

        $servers = $ini->variable( 'General', 'VarnishServers' );
        foreach( $servers as $serverIdentifier ) {
            $serverINIGroup = 'VarnishServer_' . $serverIdentifier;
            if( $ini->hasGroup( $serverINIGroup ) === false ) {
                continue;
            }

            $serverData = array();
            if( $ini->hasVariable( $serverINIGroup, 'Host' ) ) {
                $serverData['host'] = $ini->variable( $serverINIGroup, 'Host' );
            }
            if( $ini->hasVariable( $serverINIGroup, 'Port' ) ) {
                $serverData['port'] = (int) $ini->variable( $serverINIGroup, 'Port' );
            }
            if( $ini->hasVariable( $serverINIGroup, 'Timeout' ) ) {
                $serverData['timeout'] = (int) $ini->variable( $serverINIGroup, 'Timeout' );
            }
            if( $ini->hasVariable( $serverINIGroup, 'SecretFile' ) ) {
                $serverData['secret'] = $ini->variable( $serverINIGroup, 'SecretFile' );
            }

            $this->servers[$serverIdentifier] = $serverData;
        }
    }

    public static function getInstance() {
        if( self::$instance === null ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function cli( $request, $background = false ) {
        $request = "'" . str_replace( "'", "'\\''", trim( $request ) ) . "'";
        $output  = null;

        foreach( $this->servers as $identifier => $server ) {
            $host = null;
            if( isset( $server['host'] ) ) {
                $host = $server['host'];
            }
            if( $host !== null && isset( $server['port'] ) ) {
                $host .= ':' . $server['port'];
            }

            $cmd = 'varnishadm';
            if( $host !== null ) {
                $cmd .= ' -T ' . $host;
            }
            if( isset( $server['timeout'] ) ) {
                $cmd .= ' -t ' . $server['timeout'];
            }
            if( isset( $server['secret'] ) ) {
                $cmd .= ' -S ' . $server['secret'];
            }
            $cmd .= ' ' . $request;

            $log       = new nxcVarnishLogItem();
            $log->setAttribute( 'server', $identifier );
            $log->setAttribute( 'request', $cmd );
            $log->store();
            $startTime = microtime( true );

            if( $background ) {
                exec( $cmd . ' 2>&1 | php extension/nxc_varnish/bin/php/handle_log.php --log_id=' . $log->attribute( 'id' ) . ' --start_time=' . $startTime . ' 2>&1 > /dev/null &' );
                continue;
            }

            exec( $cmd . ' 2>&1', $response );
            $response = trim( implode( "\n", $response ) );
            $log->setAttribute( 'is_completed', 1 );
            $log->setAttribute( 'response', $response );
            $log->setAttribute( 'duration', microtime( true ) - $startTime );
            $log->store();

            $output .= $identifier . ':' . "\n" . str_repeat( '-', 80 ) . "\n" . $response . "\n" . str_repeat( '-', 80 ) . "\n\n";
        }

        return $output;
    }

    static function getInstallationID() {
        if( self::$installationID !== null ) {
            return self::$installationID;
        }
        $db     = eZDB::instance();
        $result = $db->arrayQuery( 'SELECT value FROM ezsite_data WHERE name=\'varnish_site_id\'' );
        if( count( $result ) >= 1 ) {
            self::$installationID = $result[0]['value'];
        } else {
            self::$installationID = md5( time() . '-' . mt_rand() );
            $db->query( 'INSERT INTO ezsite_data ( name, value ) values( \'varnish_site_id\', \'' . self::$installationID . '\' )' );
        }

        return self::$installationID;
    }

    public static function addNodeHeader( $nodeID ) {
        header( 'X-eZPublish-NodeID: ' . $nodeID );
        header( 'X-eZPublish-InstallationID: ' . self::getInstallationID() );
        return $nodeID;
    }

}
