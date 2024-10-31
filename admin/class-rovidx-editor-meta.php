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
		add_action('admin_menu', 'rovidx_editor_add_box');

function rovidx_editor_add_box()
			{
				global $base_meta_box;
				
				if (!is_plugin_active( 'rovidx-vimeo-pro/rovidx-vimeo-pro.php') ) {
					add_meta_box($base_meta_box['id'], $base_meta_box['title'], 'rovidx_editor_show_box', $base_meta_box['page'], $base_meta_box['context'], $base_meta_box['priority']);
					}
			}

function rovidx_editor_show_box()
			{
			global $base_meta_box, $post;
			echo '<input type="hidden" name="rovidx_editor_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
			echo '<table class="form-table">';
			foreach ($base_meta_box['fields'] as $field)
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
												foreach ($field['options'] as $option)
															{
															echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
															}
												echo '</select>';
												echo '<em> ' . $field['desc'] . '</em>';
												break;
									case 'radio':
												foreach ($field['options'] as $option)
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
			foreach ($base_meta_box['fields'] as $field)
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