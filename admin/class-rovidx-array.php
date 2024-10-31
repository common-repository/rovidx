<?php
$roSubMenu = array(
     'menus' => array(
         array(
             'id' => '2',
            'menu' => 'rovidx-options',
            'name' => 'FAQ & Help',
            'title' => 'FAQ & Help',
            'lvl' => 'manage_options',
            'slug' => 'rovidx-op-faq',
            'daFunc' => 'rovidx_func_faq' 
        ),
        array(
             'id' => '3',
            'menu' => 'rovidx-options',
            'name' => 'RoVidX Options',
            'title' => 'Settings',
            'lvl' => 'manage_options',
            'slug' => 'rovidx-options',
            'daFunc' => 'rovidx_options_page' 
        ) 
    ) 
);
$prefix        = 'rovidx_';
$base_meta_box = array(
    'id' => 'rovidx-base-box',
    'title' => 'RoVidX Base Editor Add-On',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
            array(
            'name' => 'Title',
            'id' => $prefix . 'vtitle',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Description',
            'id' => $prefix . 'vdesc',
            'type' => 'text',
            'std' => ''
        ),
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
			'std'  => ''
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
			'name' => 'Video Format',
			'id' => $prefix . 'vform',
			'type' => 'select',
			'options' => array(
				'option' => 'MP4'
				)
				),
        array(
            'name' => 'Available Definitions',
            'id' => $prefix . 'vformat',
            'type' => 'select',
			'options' => array(
                'option' => 'SD', 
							'HD'							
             ),
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