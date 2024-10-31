<?php

function rovidx_menu()
{
	add_menu_page('RoVidX Options', 'RoVidX', 'manage_options', 'rovidx-options', 'rovidx_options_page', plugins_url('rovidx/images/smsico.png'));
	add_submenu_page('rovidx-options', 'Settings', 'Settings', 'manage_options', 'rovidx-options', 'rovidx_options_page');
}
add_action('_admin_menu', 'rovidx_menu');

function rovidx_addon_menu()
{
	add_submenu_page('rovidx-options', 'Add Ons', 'Add Ons', 'manage_options', 'rovidx-addons', 'rovidx_addon_page');
}
add_action('admin_menu', 'rovidx_addon_menu');

function rovidx_register_settings()
{
	register_setting('rovidx_settings_group', 'rovidx_settings', 'rovidx_settings_validate');
}
add_action('admin_init', 'rovidx_register_settings');

function rovidx_settings_validate($input)
{
	if ($input['vimeo'] != 'on' ) {
			$input['vimeo'] = 'off';
		}

	return $input;
}

function rovidx_string_cleaner($input) {
	
	$input = str_replace(array('<', '>', '{', '}', '*','&#038;'), array(''), $input);
   	$input = str_replace(array('&#8211;'), array(':'), $input);
	$input = str_replace(array('&'), array('and'), $input);
	
	return $input;
}

function curl_get($url)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    $return = curl_exec($curl);
    curl_close($curl);
    return $return;
}