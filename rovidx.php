<?php
/**
* Plugin Name: RoVidX Media Framework
* Plugin URI: http://rovidx.com
* Description: Manage Video Content and output to web, mobile or Internet TV Devices (Roku, Amazon TV, etc).
* Version: 2.0.8
* Author: RoVidX Media Solutions
* Author URI: http://RoVidX.com/
* License: GPL2
**/



if ( !defined( 'WPINC' ) ) {
    die;
}

if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-rovidx-meta.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-rovidx-admin.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-rovidx-admin-func.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/data/ar-rovidx-meta.php' );
	
	if ( !class_exists( 'RoVidX_Updater' ) ) {
    	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-rovidx-updater.php' );
	}
}

require_once( plugin_dir_path(__FILE__) . 'public/class-rovidx-functions.php' );