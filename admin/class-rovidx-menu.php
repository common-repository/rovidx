<?php
function rovidx_menu()
{
    add_menu_page( 'RoVidX Options', 'RoVidX', 'manage_options', 'rovidx-options', 'rovidx_options_page', plugins_url( 'rovidx/images/smsico.png' ) );
    add_submenu_page( 'rovidx-options', 'RoVidX Options', 'Settings', 'manage_options', 'rovidx-options', 'rovidx_options_page' );	
}
add_action( '_admin_menu', 'rovidx_menu' );

function rovidx_addon_menu()
{
add_submenu_page( 'rovidx-options', 'Add Ons', 'Add Ons', 'manage_options', 'rovidx-addons', 'rovidx_addon_page' );	
}
add_action( 'admin_menu', 'rovidx_addon_menu' );


$noshow = '';
// RoVidX Base Menus

function rovidx_addon_notice() {
	if ( is_plugin_active( 'rovidx-roku-add-on/rovidx-roku.php' ) || is_plugin_active( 'rovidx-roku-pro/rovidx-roku-pro.php' )) { 
		return;
	} else {
	?>
    <div class="error">
        <p><?php _e( 'Please install or activate a <strong><a href="http://rovidx.com/add-ons/" target="_blank">RoVidX output module</a></strong>.', 'rovidx-domain' ); ?></p>
    </div><?php 
	}
}
	add_action( 'admin_notices', 'rovidx_addon_notice' );

//RoVidX Main Options Page
function rovidx_options_page()
{
 	
    global $noshow;
    // Arrays
    $count2 = $noshow;
    wp_enqueue_style( 'thickbox' );
    wp_enqueue_script( 'media-upload' );
    wp_enqueue_script( 'thickbox' );
    while ( $count2 > 0 ) {
        $bleed     = 'catslug' . $count2;
        $earth     = 'rovidx_settings[\'catslug' . $count2 . '\']';
        //Drop Down Metas
        $roCatGrab = array(
             'categories' => array(
                 array(
                     'show_option_all' => '',
                    'show_option_none' => '1',
                    'orderby' => 'ID',
                    'order' => 'ASC',
                    'show_count' => 1,
                    'hide_empty' => 1,
                    'child_of' => 0,
                    'exclude' => '',
                    'echo' => 1,
                    'selected' => 0,
                    'hierarchical' => 0,
                    'name' => 'cat',
                    'id' => $earth,
                    'class' => 'postform',
                    'depth' => 0,
                    'tab_index' => 0,
                    'taxonomy' => 'category',
                    'hide_if_empty' => false,
                    'walker' => '' 
                ) 
            ) 
        );
    }
    // Page Gen
    global $rovidx_options;
    global $video;
    global $user;
    ob_start();
?>
<div class="wrap">
<form id="rovidxform" method="post" action="options.php">
  <?php
    settings_fields( 'rovidx_settings_group' );
    do_settings_sections( 'rovidx_settings_group' );
?>
  <h1>Channel Information</h1>
  <table class="form-table" width="90%" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td width="100px"><label class="title" for="rovidx_settings[noofshow]"><?php _e( 'Number of Shows', 'rovidx_domain' ); ?></label></td>
      <td><input id="rovidx_settings[noofshow]" size="75" name="rovidx_settings[noofshow]" type="text" value="<?php echo $rovidx_options['noofshow']; ?>"/></td>
      <td rowspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><hr /></td>
    </tr>
    <?php
    $counter = 0;
    $noshow  = $rovidx_options['noofshow'];
    while ( $counter < $noshow ) {
        $counter  = $counter + 1;
        $coutit   = 'ctitle' . $counter;
        $titfor1  = 'rovidx_settings[ctitle' . $counter . ']';
        $coudesc  = 'cdesc' . $counter;
        $descfor1 = 'rovidx_settings[cdesc' . $counter . ']';
        $coucats  = 'catslug' . $counter;
        $catfor1  = 'rovidx_settings[catslug' . $counter . ']';
        $coudun   = 'cthumbsd' . $counter;
        $dunfor1  = 'rovidx_settings[cthumbsd' . $counter . ']';
        $coubob   = 'cthumbhd' . $counter;
        $bobfor1  = 'rovidx_settings[cthumbhd' . $counter . ']';
?>
    <tr bordercolor="#000">
      <th><label class="header" for="<?php echo $titfor1; ?>"><?php _e( '<h3><strong>Enter show #' . $counter . ' Title</strong></h3>', 'rovidx_domain' ); ?></label></th>
      <td><input id="<?php echo $titfor1; ?>" size="75" name="<?php echo $titfor1; ?>" type="text" value="<?php echo $rovidx_options[$coutit]; ?>"/></td>
    </tr>
    <tr>
      <td valign="top"><label class="description" for="<?php echo $descfor1; ?>"><?php _e( 'Enter show Description', 'rovidx_domain' ); ?></label></td>
      <td><input id="<?php echo $descfor1; ?>" name="<?php echo $descfor1; ?>" size="75" type="text" value="<?php echo $rovidx_options[$coudesc];?>" /></td>
    </tr>
    <tr>
      <td width="33%"><label class="title" size="75" for="<?php echo $catfor1; ?>"><?php echo "Category"; ?></label></td>
      <td><?php
	    wp_dropdown_categories( array(
             'hide_empty' => 1,
            'show_count' => 1,
            'name' => $catfor1,
            'orderby' => 'name',
            'selected' => $rovidx_options[$coucats],
            'hierarchical' => true,
            'show_option_none' => __( 'None' ) 
        ) );
?></td>
      <td rowspan="4"></td>
    </tr>
    <tr>
      <td><label class="title" for="<?php echo $bobfor1; ?>"><?php _e( 'Show Thumbnail', 'rovidx_domain' ); ?></label></td>
      <td><div class="uploader">
          <input class="foo_<?php
        echo $coubob;
?>" type="text" size="50" name="<?php
        echo $bobfor1;
?>" id="<?php
        echo $bobfor1;
?>" value="<?php
        echo $rovidx_options[$coubob];
?>" />
          <input class="button-primary fobar_<?php
        echo $coubob;
?>" name="<?php
        echo $coubob;
?>" size="15" id="<?php
        echo $coubob;
?>" value="Upload Thumbnail" />
        </div>
        <script type="text/javascript">
		jQuery(document).ready(function($){
	    var custom_uploader;
	    $('.fobar_<?php echo $coubob; ?>').click(function(e) {
	        e.preventDefault();
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
        attachment = custom_uploader.state().get('selection').first().toJSON();
        $('.foo_<?php echo $coubob; ?>').val(attachment.url);
        });
        custom_uploader.open();
    });
});</script></td>
    </tr>
    <tr>
      <td colspan="3"><hr /></td>
    </tr>
    <?php
    }
?>
    <tr>
      <td></td>
      <td><input type="submit" class="button-primary" value="Save Options" /></td>
    </tr>
  </table>
</form>
<?php
    echo ob_get_clean();
}
function rovidx_register_settings()
{
    register_setting( 'rovidx_settings_group', 'rovidx_settings', 'rovidx_settings_validate' );
}
add_action( 'admin_init', 'rovidx_register_settings' );
function rovidx_settings_validate( $input )
{
    // Our first value is either 0 or 1
    //$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );
    // Say our second option must be safe text with no HTML tags
    //$input['sometext'] =  wp_filter_nohtml_kses($input['sometext']);
    return $input;
}


function rovidx_addon_page() {
	include_once( ABSPATH . WPINC . '/feed.php' );
	ob_start();
	?>
    <div class="wrap"><h3>Extend RoVidX with Applications</h3>
    <?php // Get RSS Feed(s)
	// Get a SimplePie feed object from the specified feed source.
	$rss = fetch_feed( 'http://rovidx.com/feed/?post_type=download' );
	
if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

    // Figure out how many total items there are, but limit it to 5. 
    $maxitems = $rss->get_item_quantity( 20 ); 

    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items( 0, $maxitems );

endif;
?><?php foreach ( $rss_items as $item ) : ?><div style="border: 1px solid #000000; margin-right: 10px; margin-bottom: 10px; position: relative; width: 300px; height: 300px; float:left;"><table width="90%" height="290px" border="0" cellspacing="5" cellpadding="5">

  <tr valign="top" height="20%">
    <th><h3><a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>" target="_blank"><?php echo esc_html( $item->get_title() ); ?></a></h3></th>
  </tr>
  <tr valign="top">
    <td><?php echo esc_html( $item->get_description() ); ?></td>
  </tr>
    </table></div><?php endforeach; ?>
    </div>
    <?php
	echo ob_get_clean();
	}
