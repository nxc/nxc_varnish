<?php
/**
 * @package nxcDNA
 * @author  Serhey Dolgushev <serhey.dolgushev@nxc.no>
 * @date    23 Jan 2013
 **/

$http     = eZHTTPTool::instance();
$request  = $http->hasVariable( 'request' ) ? $http->variable( 'request' ) : false;
$response = false;

if( $Params['Module']->isCurrentAction( 'Request' ) ) {
	$varnish  = nxcVarnish::getInstance();
	try{
		$response = $varnish->cli( $request );
	} catch( Exception $e ) {
		$response = $e->getMessage();
	}
	if( strlen( $response ) == 0 ) {
		$response = ezpI18n::tr( 'extension/nxc_varnish', 'Empty response' );
	}
}

$tpl = eZTemplate::factory();
$tpl->setVariable( 'request', $request );
$tpl->setVariable( 'response', $response );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:varnish/terminal.tpl' );
$Result['path']    = array(
	array(
		'text' => ezpI18n::tr( 'extension/nxc_varnish', 'Varnish Terminal' ),
		'url'  => false
	)
);
