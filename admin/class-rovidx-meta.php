<?php
/**
 *
 * @package   RoVidX
 * @author    rob@smokingmanstudios.com
 * @license   GPL-2.0+
 * @link      http://smokingmanstudios.com/rovidx/
 * @copyright 2013 Smoking Man Studios
 *
 **/
 
add_action('admin_menu', 'rovidx_editor_add_box');
function rovidx_editor_add_box()
{
	global $base_meta_box;
	global $vimeo_box;

	$options = get_option('rovidx_settings');

	if ($options["vimeo"] <> 'on')
	{
		add_meta_box($base_meta_box['id'], $base_meta_box['title'], 'rovidx_editor_show_box', $base_meta_box['page'], $base_meta_box['context'], $base_meta_box['priority']);
	} else {
		add_meta_box($vimeo_box['id'], $vimeo_box['title'], 'rovidxvimeo_show_box', $vimeo_box['page'], $vimeo_box['context'], $vimeo_box['priority']);
	}
}

function rovidx_editor_show_box()
{
	global $base_meta_box, $post;
	echo '<input type="hidden" name="rovidx_editor_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)) , '" />';
	echo '<table class="form-table">';
	foreach($base_meta_box['fields'] as $field)
	{
		$meta = get_post_meta($post->ID, $field['id'], true);
		echo '<tr>', '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>', '<td>';
		switch ($field['type'])
		{
		case 'text':
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
			break;

		case 'textarea':
			echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
			break;

		case 'select':
			echo '<select name="', $field['id'], '" id="', $field['id'], '">';
			foreach($field['options'] as $option)
			{
				echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
			}
			echo '</select>';
			echo '<em> ' . $field['desc'] . '</em>';
			break;

		case 'radio':
			foreach($field['options'] as $option)
			{
				echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
			}
			break;

		case 'checkbox':
			echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
			break;
		}
		echo '</td><td>', '</td></tr>';
	}
	echo '</table>';
}
add_action('save_post', 'rovidx_editor_save_data');

function rovidxvimeo_show_box()
{
    global $pre_vimeo_box, $vimeo_box, $post;
    $video_url       = get_post_meta(get_the_ID(), 'rovidx_vimeotitle', true);
    $oembed_endpoint = 'http://vimeo.com/api/oembed';
    $xml_url         = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url) . '&width=640';
    $oembed          = simplexml_load_string(curl_get($xml_url));
	
	echo '<input type="hidden" name="rovidxvimeo_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    echo '<table class="form-table">';
    if ($video_url) {
        foreach ($vimeo_box['fields'] as $field) {
            $meta = get_post_meta($post->ID, $field['id'], true);
            echo '<tr>', '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>', '<td>';
            
           	    $title = $oembed->title;
				$desc  = $oembed->description;
			    $dura  = $oembed->duration;

			if ($dura != 0) {
                $init    = $dura;
                $roTime  = date("G:i:s", mktime(0,0, round($init) % (24*3600)));
            }
			
			
			switch ($field['id']) {
                case 'rovidx_vtitle':
                    echo $title , '<input type="hidden" name="', $field['id'], '" id="', $field['id'], '" value="', $title ? $title : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                    break;
                case 'rovidx_vimeotitle':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                    break;
                case 'rovidx_vdesc':
                    echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $desc ? $desc : $field['std'], '</textarea>', '<br />', $field['desc'];
                    break;
                case 'rovidx_vlength':
                    echo $field['desc'], '<strong>' , $roTime , '</strong>' , '<input type="hidden" name="', $field['id'], '" id="', $field['id'], '" value="', $dura ? $dura : $field['std'], '" size="30" style="width:97%" />';
                    break;
                case 'rovidx_vbitrate':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                    break;
				case 'rovidx_vcast':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                    break;
				case 'rovidx_vdirector':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                    break;
                case 'rovidx_vformat':
                    echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                    foreach ($field['options'] as $option) {
                        echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                    }
                    echo '</select>';
                    break;
				 case 'rovidx_vrating':
                    echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                    foreach ($field['options'] as $option) {
                        echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                    }
                    echo '</select>';
                    break;
				case 'rovidx_vform':
                    echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                    foreach ($field['options'] as $option) {
                        echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';

                    }
                    echo '</select>';
                    break;
                case 'rovidx_vtype':
                    echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                    foreach ($field['options'] as $option) {
                        echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                    }
                    echo '</select>';
                    break;
                case 'rovidx_vurlhd':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                    break;
				case 'rovidx_vurl':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                    break;
            }
            echo '</td></tr>';
        }
        echo '</table>';
    } else
    // No Video Added Yet... ***********************************************************************************************************************
        foreach ($pre_vimeo_box['fields'] as $field) {
            $meta = get_post_meta($post->ID, $field['id'], true);
            echo '<tr>', '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>', '<td>'; {
                switch ($field['type']) {
                    case 'text':
                        echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                        break;
                }
                echo '</td></tr>';
            }
            echo '</table>';
        }
}
add_action('save_post', 'rovidxvimeo_save_data');
function rovidxvimeo_save_data($post_id)
{
    global $vimeo_box;
    if (!wp_verify_nonce($_POST['rovidxvimeo_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    foreach ($vimeo_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}


function rovidx_editor_save_data($post_id)
{
	global $base_meta_box;
	if (!wp_verify_nonce($_POST['rovidx_editor_meta_box_nonce'], basename(__FILE__)))
	{
		return $post_id;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
	{
		return $post_id;
	}
	if ('page' == $_POST['post_type'])
	{
		if (!current_user_can('edit_page', $post_id))
		{
			return $post_id;
		}
	}
	elseif (!current_user_can('edit_post', $post_id))
	{
		return $post_id;
	}
	foreach($base_meta_box['fields'] as $field)
	{
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old)
		{
			update_post_meta($post_id, $field['id'], $new);
		}
		elseif ('' == $new && $old)
		{
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}