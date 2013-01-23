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

	public function cli( $request ) {
		$request = escapeshellcmd( trim( $request ) );
 		$cmd     = 'varnishadm -T ' . $this->host . ':' . $this->port . ' -t ' . $this->port . ' ' . $request;
 		exec( $cmd, $output );
		return implode( "\n", $output );
	}

	public static function addNodeHeader( $nodeID ) {
		header( 'X-eZP-NodeID: ' . $nodeID );
		return $nodeID;
	}
}
