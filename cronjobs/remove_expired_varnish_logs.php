<?php

/**
 * @package nxcVarnish
 * @author  Serhey Dolgushev <serhey.dolgushev@nxc.no>
 * @date    27 Nov 2014
 * */
$cli->output( 'Starting removing expired varnish logs' );

$p = array(
    'date' => array( '<=', time() - nxcVarnishLogItem::getExpiryTime() )
);
eZPersistentObject::removeObject( nxcVarnishLogItem::definition(), $p );

$cli->output( 'Expired logs are removed' );
