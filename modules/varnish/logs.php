<?php

/**
 * @package nxcVarnish
 * @author  Serhey Dolgushev <serhey.dolgushev@nxc.no>
 * @date    27 Nov 2014
 * */
$http          = eZHTTPTool::instance();
$defaultFilter = array(
    'server'   => null,
    'error'    => null,
    'request'  => null,
    'respones' => null
);
$filter        = $http->sessionVariable( 'varnish_logs_filter', $defaultFilter );

if( $http->hasVariable( 'filter' ) ) {
    $filter = array_merge( $filter, (array) $http->variable( 'filter' ) );
}
$http->setSessionVariable( 'varnish_logs_filter', $filter );

$conditions = array();
if( strlen( $filter['server'] ) !== 0 ) {
    $conditions['server'] = array( '=', $filter['server'] );
}
if( strlen( $filter['error'] ) !== 0 ) {
    if( (bool) $filter['error'] ) {
        $conditions['response'] = array( '<>', '' );
    } else {
        $conditions['response'] = array( '=', '' );
    }
}
if( strlen( $filter['request'] ) !== 0 ) {
    $conditions['request'] = array( 'like', '%' . $filter['request'] . '%' );
}
if( strlen( $filter['response'] ) !== 0 ) {
    $conditions['response'] = array( 'like', '%' . $filter['response'] . '%' );
}

if( count( $conditions ) === 0 ) {
    $conditions = null;
}

$params      = $Params['Module']->UserParameters;
$offset      = isset( $params['offset'] ) ? (int) $params['offset'] : 0;
$limit       = isset( $params['limit'] ) ? (int) $params['limit'] : 20;
$limitations = array(
    'limit'  => $limit,
    'offset' => $offset
);

$tpl = eZTemplate::factory();
$tpl->setVariable( 'logs', nxcVarnishLogItem::fetchList( $conditions, $limitations, $customConds ) );
$tpl->setVariable( 'filter', $filter );
$tpl->setVariable( 'offset', $offset );
$tpl->setVariable( 'limit', $limit );
$tpl->setVariable( 'total_count', nxcVarnishLogItem::countAll( $conditions ) );
$tpl->setVariable( 'servers', nxcVarnishLogItem::getPossibleServers() );

$Result['content'] = $tpl->fetch( 'design:varnish/logs/show.tpl' );
$Result['path']    = array(
    array(
        'text' => ezpI18n::tr( 'extension/nxc_varnish', 'Varnish Logs' ),
        'url'  => false
    )
);
