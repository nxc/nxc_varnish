<?php
/**
 * @package nxcVarnish
 * @author  Alex Pilyavskiy
 * @date    25 Oct 2013
 **/

$http     = eZHTTPTool::instance();
$Module = $Params['Module'];
$viewParams = $Params['UserParameters'];
$requests = $responses =  array();
$redirectUrl = '/';
$tpl = eZTemplate::factory();

if ( $http->hasGetVariable( 'curr_url' ) && $http->getVariable( 'curr_url' ) != "" ) {
    $redirectUrl = $http->getVariable( 'curr_url' );
}

if ( isset($viewParams['node']) && (int)$viewParams['node'] > 0 ) {
    $requests[] = "ban obj.http.X-eZPublish-NodeID == ".(int)$viewParams['node'];
}
else if ( isset($viewParams['class']) && (int)$viewParams['class'] > 0 ) {
    $requests[] = "ban obj.http.X-Class-ID == ".(int)$viewParams['class'];
}
else if ( $http->hasPostVariable( 'ClearArray' ) && $http->hasPostVariable( 'ClearSelected' )) {
    foreach( $http->postVariable( 'ClearArray' ) as $var) {
        $requests[] = 'ban obj.http.X-Url ~ "'.$var.'"';
    }
    $redirectUrl = "varnish/terminal";
}

if ( !empty( $requests ) ) {
    $varnish  = nxcVarnish::getInstance();
    foreach( $requests as $request ) {
        try{
            $responses[] = $varnish->cli( $request );
        } catch( Exception $e ) {
            $responses[] = $e->getMessage();
        }
    }
}

$tpl->setVariable( 'response', join("<br>", $responses ) );

$Module->redirectTo( $redirectUrl );