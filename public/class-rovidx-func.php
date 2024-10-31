<?php

function rovidx_featured_img_url($rovidx_featured_img_size)
{
    $rovidx_image_id  = get_post_thumbnail_id();
    $rovidx_image_url = wp_get_attachment_image_src($rovidx_image_id, $rovidx_featured_img_size);
    $rovidx_image_url = $rovidx_image_url[0];
    return $rovidx_image_url;
}
