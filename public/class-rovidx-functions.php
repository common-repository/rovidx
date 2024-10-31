<?php

/* RoVidX Functions */

function rovidx_featured_img_url($rovidx_featured_img_size)
{
	$rovidx_image_id = get_post_thumbnail_id();
	$rovidx_image_url = wp_get_attachment_image_src($rovidx_image_id, $rovidx_featured_img_size);
	$rovidx_image_url = $rovidx_image_url[0];
	return $rovidx_image_url;
}

// Enable Meta Data Output
function custom_rest_api_allowed_public_metadata($allowed_meta_keys)
{
	// only run for REST API requests

	if (!defined('REST_API_REQUEST') || !REST_API_REQUEST) return $allowed_meta_keys;
	$allowed_meta_keys[] = 'rovidx_vurl';
	$allowed_meta_keys[] = 'rovidx_vurlhd';
	return $allowed_meta_keys;
}
add_filter('rest_api_allowed_public_metadata', 'custom_rest_api_allowed_public_metadata');

// Flush Rewrite Rules
add_action('wp_loaded', 'my_flush_rules');
function my_flush_rules()
 {
   $rules = get_option('rewrite_rules');
   if (!isset($rules['(project)/(\d*)$']))
    {
      global $wp_rewrite;
      $wp_rewrite->flush_rules();
    }
}

