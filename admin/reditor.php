<?php
/**
 *
 * @package   RoVidX Free
 * @author    rob@smokingmanstudios.com
 * @license   GPL-2.0+
 * @link      http://smokingmanstudios.com/rovidx/
 * @copyright 2013 Smoking Man Studios
 *
 **/

$prefix = 'rovidx_';

$meta_box = array(
    'id' => 'rovidx-meta-box',
    'title' => 'RoVidX Options',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Title',
            'id' => $prefix . 'vtitle',
            'type' => 'text',
            'std' => '0-9 and A-Z - Other symbols may cause errors (ex: &amp will error)!'
        ),
        array(
            'name' => 'Description',
            'id' => $prefix . 'vdesc',
            'type' => 'textarea',
            'std' => 'Enter description here'
        ),
		array(
			'name' => 'Length (minutes)',
			'id' => $prefix . 'vlength',
			'type' => 'text',
			'std' => '0',
		),
		array(
			'name' => 'Bitrate (Kbps) (<strong>PRO</strong>)',
			'id' => $prefix . 'PROnly',
			'type' => 'text',
			'std' => 'PRO ONLY'
		),
		array(
			'name' => 'Content Type (<strong>PRO</strong>)',
			'id' => $prefix . 'PROnly',
			'type' => 'text',
			'std' => 'PRO ONLY'
		),
		array(
			'name' => 'Format (<strong>PRO</strong>)',
			'id' => $prefix . 'PROnly',
			'type' => 'text',
			'std' => 'PRO ONLY'
		),
		array(
			'name' => 'MP4 URL',
			'id' => $prefix . 'vurl',
			'type' => 'text',
			'std' => 'http://yourdomain.com/filename.mp4'
			)
    )
);
// Hook Editor and add Meta Box

add_action('admin_menu', 'rovidxtheme_add_box');

// Add meta box

function rovidxtheme_add_box() {
    global $meta_box;
    add_meta_box($meta_box['id'], $meta_box['title'], 'rovidxtheme_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box

function rovidxtheme_show_box() {
    global $meta_box, $post;
    // Use nonce for verification
	echo '<input type="hidden" name="rovidxtheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    echo '<table class="form-table">';
    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
        }
        echo     '</td><td>',
            '</td></tr>';
    }
    echo '</table>';
	echo '<div class="goprorov"><h3>Get all the advanced features and more frequent updates!</h3><a href="http://rovidx.com/downloads/rovidx-roku-edition/"><img src="' . plugins_url( "rovidx/images/gopro.png") .'" /></a></div>';
}

// Save Data

add_action('save_post', 'rovidxtheme_save_data');

// Save data from meta box
function rovidxtheme_save_data($post_id) {
    global $meta_box;
    // verify nonce
    if (!wp_verify_nonce($_POST['rovidxtheme_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}