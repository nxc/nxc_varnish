<?php
/**
 * @package nxcVarnish
 * @author  Alex Pilyavskiy
 * @date    25 Oct 2013
 **/

$http     = eZHTTPTool::instance();
$Module = $Params['Module'];
$viewParams = $Params['UserParameters'];
$request = false;

if ( isset($viewParams['node']) && (int)$viewParams['node'] > 0 ) {
    $request = "ban obj.http.X-eZPublish-NodeID == ".(int)$viewParams['node'];
}
else if ( isset($viewParams['class']) && (int)$viewParams['class'] > 0 ) {
    $request = "ban obj.http.X-Class-ID == ".(int)$viewParams['class'];
}

if ( $request ) {
    $varnish  = nxcVarnish::getInstance();
    try{
        $response = $varnish->cli( $request );
    } catch( Exception $e ) {
        $response = $e->getMessage();
    }
}

if ( $http->hasGetVariable( 'curr_url' ) && $http->getVariable( 'curr_url' ) != "" ) {
    $Module->redirectTo( $http->getVariable( 'curr_url' ) );
}
else {
    $Module->redirectTo( '/' );
}

