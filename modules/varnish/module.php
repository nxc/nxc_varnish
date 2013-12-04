<?php
/**
 * @package nxcVarnish
 * @author  Serhey Dolgushev <serhey.dolgushev@nxc.no>
 * @date    23 Jan 2013
 **/

$Module = array(
	'name'      => 'NXC Varnish',
	'functions' => array( 'terminal', 'clear_class', 'clear_node' )
);

$ViewList = array(
    'terminal' => array(
		'script'                  => 'terminal.php',
		'functions'               => array( 'terminal' ),
		'params'                  => array(),
		'default_navigation_part' => 'ezsetupnavigationpart',
		'single_post_actions'     => array( 'RequestButton' => 'Request' )
	),
    'clear_class' => array(
		'script'                  => 'clear.php',
		'functions'               => array( 'clear_class' ),
		'params'                  => array(),
		'default_navigation_part' => 'ezsetupnavigationpart'
	),
    'clear_node' => array(
		'script'                  => 'clear.php',
		'functions'               => array( 'clear_node' ),
		'params'                  => array(),
		'default_navigation_part' => 'ezsetupnavigationpart'
	)
);

$FunctionList = array(
	'terminal' => array(),
	'clear_class' => array(),
	'clear_node' => array()
);
