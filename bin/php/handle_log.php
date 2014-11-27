<?php

/**
 * @package nxcVarnish
 * @author  Serhey Dolgushev <serhey.dolgushev@nxc.no>
 * @date    27 Nov 2014
 * */
require 'autoload.php';
$cli = eZCLI::instance();
$cli->setUseStyles( true );

$scriptSettings                   = array();
$scriptSettings['description']    = 'Updates varnish log item for each request';
$scriptSettings['use-session']    = true;
$scriptSettings['use-modules']    = true;
$scriptSettings['use-extensions'] = true;

$script  = eZScript::instance( $scriptSettings );
$script->startup();
$script->initialize();
$options = $script->getOptions(
    '[log_id:][start_time:]', '[response]', array(
    'log_id'     => 'Log item ID',
    'start_time' => 'Start time',
    'response'   => 'Response'
    )
);

$log = nxcVarnishLogItem::fetch( $options['log_id'] );
if( $log instanceof nxcVarnishLogItem === false ) {
    $cli->error( 'There is no #' . $options['log_id'] . ' log item' );
    $script->shutdown( 1 );
}

$response = isset( $options['arguments'][0] ) ? $options['arguments'][0] : null;
// Response is not passed as argument, so we are trying to read it from stdin
if( $response === null ) {
    $f    = fopen( 'php://stdin', 'r' );
    while( $line = fgets( $f ) ) {
        $response .= $line . "\n";
    }
}
$response = trim( $response );

$log->setAttribute( 'is_completed', 1 );
$log->setAttribute( 'response', $response );
$log->setAttribute( 'duration', microtime( true ) - (float) $options['start_time'] );
$log->store();

$script->shutdown( 0 );
