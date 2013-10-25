<?php
/**
 * @package nxcVarnish
 * @author  Serhey Dolgushev <serhey.dolgushev@nxc.no>
 * @date    23 Jan 2013
 **/

$Module = array(
	'name'      => 'NXC Varnish',
	'functions' => array()
);

$ViewList = array(
	'terminal' => array(
		'script'                  => 'terminal.php',
		'functions'               => array( 'terminal' ),
		'params'                  => array(),
		'default_navigation_part' => 'ezsetupnavigationpart',
		'single_post_actions'     => array( 'RequestButton' => 'Request' )
	),
    'clear' => array(
		'script'                  => 'clear.php',
		'functions'               => array( 'terminal' ),
		'params'                  => array(),
		'default_navigation_part' => 'ezsetupnavigationpart'
	)
);

$FunctionList = array(
	'terminal' => array()
);
