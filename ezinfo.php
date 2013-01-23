<?php
/**
 * @package nxcVarnish
 * @class   nxc_varnishInfo
 * @author  Serhey Dolgushev <serhey.dolgushev@nxc.no>
 * @date    23 Jan 2013
 **/

class nxc_varnishInfo
{
	public static function info() {
		return array(
			'Name'      => 'NXC Varnish',
			'Version'   => '1.0',
			'Author'    => 'SD / NXC International SA',
			'Copyright' => 'Copyright &copy; ' . date( 'Y' ). ' <a href="http://nxc.no" target="blank">NXC Consulting</a>'
		);
	}
}
