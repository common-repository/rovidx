<?php

// RoVidX Main Options Page
function rovidx_options_page() {
	
	$options = get_option('rovidx_settings');
	$vimeoconnect = $options["vimeo"];
	?>
    <div class="wrap">
   		<h1><?php _e('RoVidX Media Framework'); ?></h1>
        <hr />Instructions | FAQ | Tech Support<hr />
        <h4>Recommended Themes:</h4>
        <p><a href="http://themeforest.net/item/true-mag-wordpress-theme-for-video-and-magazine/6755267?ref=robdaven" target="_blank">TrueMag</a> | <a href="http://themeforest.net/item/quadrum-multipurpose-newsmagazine-theme/7205094?ref=robdaven" target="_blank">QuadRum</a> | <a href="http://themeforest.net/item/videomag-powerful-video-wordpress-theme/7712718?ref=robdaven" target="_blank">VideoMag</a> | <a href="http://themeforest.net/item/videotube-a-responsive-video-wordpress-theme/7214445?ref=robdaven" target="_blank">VideoTube</a> | More Soon...</p>
        <hr />
        <h2><?php _e('Framework Settings'); ?></h2>
        <form id="rovidxsettingsform" method="post" action="options.php">
        	<?php
  				  settings_fields( 'rovidx_settings_group' );
				  do_settings_sections( 'rovidx_settings_group' );
			?>
            <input type="checkbox" name="rovidx_settings[vimeo]" <?php if($vimeoconnect == 'on') { echo 'checked="checked"'; } ?>>Enable Vimeo Connect</input><br />
        <br /><input type="submit" class="button-primary" value="Save Options" /></form><hr />
        <h4>Setup Tutorial</h4>
        <iframe width="560" height="315" src="//www.youtube.com/embed/tJ8NF2hWerg" frameborder="0" allowfullscreen></iframe>
	</div>
	<?php
}

function rovidx_addon_page()
{
	include_once (ABSPATH . WPINC . '/feed.php');

	ob_start();
?>
<div class="wrap"><h3>Extend RoVidX with Applications</h3>
    <?php // Get RSS Feed(s)
	// Get a SimplePie feed object from the specified feed source.
	$rss = fetch_feed('http://rovidx.com/feed/?post_type=download');
	if (!is_wp_error($rss)): // Checks that the object is created correctly
		// Figure out how many total items there are, but limit it to 5.
		$maxitems = $rss->get_item_quantity(20);
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items(0, $maxitems);
	endif;
?><?php
	foreach($rss_items as $item): ?><div style="border: 1px solid #000000; margin-right: 10px; margin-bottom: 10px; position: relative; width: 300px; height: 300px; float:left;"><table width="90%" height="290px" border="0" cellspacing="5" cellpadding="5">
    <tr valign="top" height="20%">
    <th><h3><a href="<?php
		echo esc_url($item->get_permalink()); ?>" title="<?php
		printf(__('Posted %s', 'my-text-domain') , $item->get_date('j F Y | g:i a')); ?>" target="_blank"><?php
		echo esc_html($item->get_title()); ?></a></h3></th>
  </tr>
  <tr valign="top">
    <td><?php
		echo esc_html($item->get_description()); ?></td>
  </tr>
</table></div><?php
	endforeach; ?>

    </div>

    <?php
	echo ob_get_clean();
}
