<?php


// ROVIDX MEDIA FRAMEWORK
$prefix = 'rovidx_';
/* Array data */
$base_meta_box = array(

    'id' => 'rovidx-base-box',
    'title' => 'RoVidX Content Settings',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Cast',
            'id' => $prefix . 'vcast',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Director',
            'id' => $prefix . 'vdirector',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => '<strong>Run Time</strong>',
            'id' => $prefix . 'vlength',
            'type' => 'text',
            'std' => '',
            'desc' => 'In seconds (IE: 3323)'
        ),
        array(
            'name' => 'Content Type',
            'id' => $prefix . 'vtype',
            'type' => 'select',
            'options' => array(
                'option' => 'Podcast',
                'Documentary',
                'TV Show',
                'Film',
                'Lecture' 
            )
        ),
        array(
            'name' => 'Format',
            'id' => $prefix . 'vform',
            'type' => 'select',
            'options' => array(
                'option' => 'MP4', 'HLS', 'MP3'
            )
        ),
        array(
            'name' => 'Available Definitions',
            'id' => $prefix . 'vformat',
            'type' => 'select',
            'options' => array(
                'option' => 'SD',
                'HD'
            )
        ),
        array(
            'name' => 'Content Rating',
            'id' => $prefix . 'vrating',
            'type' => 'select',
            'options' => array(
                'option' => 'G',
                'PG',
                'PG 14+',
                'R'
            )
        ),
        array(
            'name' => 'MP4 URL (SD)',
            'id' => $prefix . 'vurl',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'MP4 URL (HD)',
            'id' => $prefix . 'vurlhd',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Bitrate (Kbps)',
            'id' => $prefix . 'vbitrate',
            'type' => 'text',
            'std' => ''
        )
    )
);

$vimeo_box     = array(
    'id' => 'rovidx-vimeo-box',
    'title' => 'RoVidX Vimeo Pro Add-On',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Vimeo URL',
            'id' => $prefix . 'vimeotitle',
            'type' => 'text',
            'std' => '',
			'desc' => ''
        ),
        array(
			'name' => 'Cast',
			'id' => $prefix . 'vcast',
			'type' => 'text',
			'std' => '',
			'desc' => ''
			),
		array(
			'name' => 'Director',
			'id' => $prefix . 'vdirector',
			'type' => 'text',
			'std'  => '',
			'desc' => ''
			),
        array(
            'name' => '<strong>Run Time</strong>',
            'id' => $prefix . 'vlength',
            'type' => 'text',
            'std' => '',
			'desc' => '',
			'desc' => ''
        ),
        array(
            'name' => 'Content Type',
            'id' => $prefix . 'vtype',
            'type' => 'select',
            'options' => array(
                'option' => 'Podcast',
			                'Documentary',
            			    'TV Show',
			                'Film',
							'Lecture'
            ),
			'desc' => ''
        ),
		array(
            'name' => 'Content Rating',
            'id' => $prefix . 'vrating',
            'type' => 'select',
            'options' => array(
                'option' => 'NR', 'G',
                'PG',
                'PG-13',
                'R'
            ),
			'desc' => ''
        ),
		array(
			'name' => 'Video Format',
			'id' => $prefix . 'vform',
			'type' => 'select',
			'options' => array(
				'option' => 'MP4'
				),
			'desc' => ''
				),
        array(
            'name' => 'Available Definitions',
            'id' => $prefix . 'vformat',
            'type' => 'select',
            'type' => 'select',
            'options' => array(
                'option' => 'SD',
                'HD'
            ),
			'desc' => ''
        ),
        array(
            'name' => 'MP4 URL (SD)',
            'id' => $prefix . 'vurl',
            'type' => 'text',
            'std' => '',
			'desc' => ''
        ),
		array(
            'name' => 'MP4 URL (HD)',
            'id' => $prefix . 'vurlhd',
            'type' => 'text',
            'std' => '',
			'desc' => ''
        ),
        array(
            'name' => 'Bitrate (Kbps)',
            'id' => $prefix . 'vbitrate',
            'type' => 'text',
            'std' => '',
			'desc' => ''
        )
    )
);
$pre_vimeo_box = array(
    'id' => 'rovidx-vimeo-box',
    'title' => 'RoVidX Vimeo Pro Add-On',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Vimeo URL',
            'id' => $prefix . 'vimeotitle',
            'type' => 'text',
            'std' => ''
        )
    )
);