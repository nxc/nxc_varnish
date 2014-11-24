<?php
/**
 * @package nxcVarnish
 * @class   nxcVarnish
 * @author  Serhey Dolgushev <serhey.dolgushev@nxc.no>
 * @date    23 Jan 2013
 **/

class nxcVarnish
{
	private static $instance = null;
	private static $installationID = null;

	private $host    = 'localhost';
	private $port    = 8081;
	private $timeout = 10;

	private function __construct() {
		$ini = eZINI::instance( 'varnish.ini' );
		if( $ini->hasVariable( 'VarnishServer', 'Host' ) ) {
			$this->host = $ini->variable( 'VarnishServer', 'Host' );
		}
		if( $ini->hasVariable( 'VarnishServer', 'Port' ) ) {
			$this->port = $ini->variable( 'VarnishServer', 'Port' );
		}
		if( $ini->hasVariable( 'VarnishServer', 'Timeout' ) ) {
			$this->timeout = $ini->variable( 'VarnishServer', 'Timeout' );
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
		$cmd     = 'varnishadm -T ' . $this->host . ':' . $this->port . ' -t ' . $this->timeout . ' ' . $request;
		if( $background ) {
			exec( $cmd . ' > /dev/null 2>&1 &' );
			return true;
		}

 		exec( $cmd, $output );
		return implode( "\n", $output );
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
