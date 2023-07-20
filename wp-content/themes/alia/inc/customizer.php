<?php
function alia_customize_partial_blogname() {
	bloginfo( 'name' );
}

// Sanitize heading control
function alia_sanitize_heading( $input, $setting ) {
    return 0;
}
function alia_customize_register( $wp_customize ) {

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.header_nav .text_logo',
		'render_callback' => 'alia_customize_partial_blogname',
	) );

	$wp_customize->selective_refresh->add_partial( 'headertagline', array(
		'selector' => '.gray_header .header_tagline',
		'settings' => 'alia_header_description'
	) );

	$wp_customize->selective_refresh->add_partial( 'footercredits', array(
		'selector' => '.site_footer .footer_credits',
		'settings' => 'alia_footer_credits'
	) );

	$wp_customize->selective_refresh->add_partial( 'paginationstyle', array(
		'selector' => '.navigation.pagination',
		'settings' => 'alia_pagination_style'
	) );

	$wp_customize->selective_refresh->add_partial( 'blogindexlayout', array(
		'selector' => '.blog_index_area',
		'settings' => 'alia_blog_layout'
	) );

	$wp_customize->selective_refresh->add_partial( 'footerstaticbar', array(
		'selector' => '.footer_static_bar',
		'settings' => 'alia_sticky_footer_content'
	) );

	$wp_customize->selective_refresh->add_partial( 'socialsharebuttons', array(
		'selector' => '.post_share_container',
		'settings' => 'alia_facebook_share'
	) );

	$wp_customize->selective_refresh->add_partial( 'headersocialicons', array(
		'selector' => '.header_social_icons',
		'settings' => 'alia_show_header_social_icons'
	) );

	$wp_customize->selective_refresh->add_partial( 'footerstoriestitle', array(
		'selector' => '.static_footer_title',
		'settings' => 'alia_sticky_footer_title'
	) );


	$wp_customize->selective_refresh->add_partial( 'headerlogo', array(
		'selector' => '.header_square_logo',
		'settings' => 'alia_default_logo'
	) );





	/* --------
	Start define sections
	------------------------------------------- */
	$wp_customize->add_section( 'general_settings_section' , array(
	   'title'      => esc_attr__( 'General Settings', 'alia' ),
	   'priority' => 81
	) );

	$wp_customize->add_section( 'header_settings_section' , array(
	   'title'      => esc_attr__( 'Header Settings', 'alia' ),
	   'priority' => 82
	) );


	$wp_customize->add_section( 'post_settings_section' , array(
	   'title'      => esc_attr__( 'Post Settings', 'alia' ),
	   'priority' => 83
	) );

	$wp_customize->add_section( 'page_settings_section' , array(
	   'title'      => esc_attr__( 'Page Settings', 'alia' ),
	   'priority' => 84
	) );

	$wp_customize->add_section( 'social_settings_section' , array(
	   'title'      => esc_attr__( 'Social Settings', 'alia' ),
	   'priority' => 85
	) );

	$wp_customize->add_section( 'footer_settings_section' , array(
	   'title'      => esc_attr__( 'Footer Settings', 'alia' ),
	   'priority' => 86
	) );
	/* --------
	end define sections
	------------------------------------------- */

	/* --------
	start title and tagline section title_tagline
	------------------------------------------- */
	function alia_sanitize_minimal_decoration( $input ) {
        $allowed_html = array(
		    'a' => array(
		        'href' => array(),
		        'title' => array()
		    ),
		    'br' => array(),
		    'em' => array(),
		    'strong' => array(),
		    'img' => array(),
		    'i' => array(),

		);

        return wp_kses( $input, $allowed_html );
    }

	/* --------
	end title and tagline section title_tagline
	------------------------------------------- */

	/* --------
	Start header section
	------------------------------------------- */
	$wp_customize->add_setting(
	   'alia_default_logo',
	   array(
	       'default'     => '',
	       'sanitize_callback' => 'esc_url',
	   )
	);

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'alia_default_logo', array(
	   'label'      => esc_attr__('Site Logo', 'alia'),
	   'section'    => 'header_image',
	   'settings'   => 'alia_default_logo',
	   'priority' => 0
	)));

	$wp_customize->add_setting(
	   'alia_default_logo_retina',
	   array(
	       'default'     => '',
	       'sanitize_callback' => 'esc_url',
	   )
	);

	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'alia_default_logo_retina', array(
	   'label'      => esc_attr__('Retina Logo ( Double size as default logo )', 'alia'),
	   'section'    => 'header_image',
	   'settings'   => 'alia_default_logo_retina',
	   'priority' => 1
	)));

	/* set logo width */
	$option = 'alia_logo_width';
	$section = 'header_image';
	$max = 500;
	$min = 0;
	$direction = 'left';
	if (is_rtl()) {
		$direction = 'right';
	}
	$wp_customize->add_setting( $option,
		array(
			'default' => 0,
			'sanitize_callback' => 'esc_attr',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control( $option,
		array(
			'label' => esc_attr__('Logo Width (0 for auto width)', 'alia'),
			'section' => $section,
			'settings' => $option,
			'type' => 'range',
			'description' => '<style>.customize-control-range { position:relative;}</style><input type="number" data-customize-setting-link="'.$option.'" oninput="rangeInput'.$option.'.value=this.value" name="amountInput'.$option.'" min="'.$min.'" max="'.$max.'" value="'.esc_attr( $wp_customize->get_setting($option)->value() ).'" style="width: 50px;position: absolute;'.$direction.': 145px;bottom: 6px;" />',
				'input_attrs' => array(
					'min'   => $min,
					'max'   => $max,
					'step'  => 1,
					'class' => 'test-class test',
					'style' => 'width: 140px',
					'oninput' => 'amountInput'.$option.'.value=this.value',
					'name' => 'rangeInput'.$option.'',
			 ),
			'priority' => 2
		)
	);
	/* set logo width */


	/* set lgoo height */
	$option = 'alia_logo_height';
	$section = 'header_image';
	$max = 500;
	$min = 0;
	$wp_customize->add_setting( $option,
		array(
			'default' => 0,
			'sanitize_callback' => 'esc_attr',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control( $option,
		array(
			'label' => esc_attr__('Logo Height (0 for auto Height)', 'alia'),
			'section' => $section,
			'settings' => $option,
			'type' => 'range',
			'description' => '<style>.customize-control-range { position:relative;}</style><input type="number" data-customize-setting-link="'.$option.'" oninput="rangeInput'.$option.'.value=this.value" name="amountInput'.$option.'" min="'.$min.'" max="'.$max.'" value="'.esc_attr( $wp_customize->get_setting($option)->value() ).'" style="width: 50px;position: absolute;'.$direction.': 145px;bottom: 6px;" />',
			'input_attrs' => array(
				'min'   => $min,
				'max'   => $max,
				'step'  => 1,
				'class' => 'test-class test',
				'style' => 'width: 140px',
				'oninput' => 'amountInput'.$option.'.value=this.value',
				'name' => 'rangeInput'.$option.'',
			),
			'priority' => 3
		)
	);
	/* set lgoo height */

	$wp_customize->add_setting(
	    'alia_round_logo_image',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);

	$wp_customize->add_control('alia_round_logo_image', array(
	    'label'      => esc_attr__('Make logo image rounded', 'alia'),
	    'description' => esc_attr__('This option is useful if you upload your personal photo as a logo, but you need to upload a square image for the best result.', 'alia'),
	    'section'    => 'header_image',
	    'settings'   => 'alia_round_logo_image',
	    'type'       => 'checkbox',
	    'priority' => 4
	));

	$wp_customize->add_setting(
    	'alia_header_bg_title',
			array(
				'sanitize_callback' => 'alia_sanitize_heading',
			)
    );
	$wp_customize->add_control( new Alia_Customizer_Heading_Text(
		$wp_customize,
		'alia_header_bg_title',
		array(
			'label'	=> esc_attr__( 'Header background image', 'alia' ),
			'section' => 'header_image',
			'settings' => 'alia_header_bg_title',
			'priority' => 5
		)
	));


    /* show gray header area */
    $wp_customize->add_setting(
        'alia_show_top_header_area',
        array(
        	'sanitize_callback' => 'absint',
            'default'     => 1,
        )
    );

    $wp_customize->add_control('alia_show_top_header_area', array(
        'label'      => esc_attr__('Show Top Header Area', 'alia'),
        'section'    => 'header_settings_section',
        'settings'   => 'alia_show_top_header_area',
        'type'       => 'checkbox'
    ));
    /* end show gray header area */


    /* show enable sticky header */
    $wp_customize->add_setting(
        'alia_enable_sticky_header',
        array(
        	'sanitize_callback' => 'absint',
            'default'     => 0
        )
    );

    $wp_customize->add_control('alia_enable_sticky_header', array(
        'label'      => esc_attr__('Enable Sticky Header', 'alia'),
        'section'    => 'header_settings_section',
        'settings'   => 'alia_enable_sticky_header',
        'type'       => 'checkbox'
    ));
    /* show enable sticky header */

    /* show logo in site header */
    $wp_customize->add_setting(
        'alia_show_header_logo',
        array(
        	'sanitize_callback' => 'absint',
            'default'     => 1,
        )
    );

    $wp_customize->add_control('alia_show_header_logo', array(
        'label'      => esc_attr__('Show Logo in Site Header', 'alia'),
        'section'    => 'header_settings_section',
        'settings'   => 'alia_show_header_logo',
        'type'       => 'checkbox'
    ));
    /* show logo in site header */

    /* show description in site header */
    $wp_customize->add_setting(
        'alia_show_header_description',
        array(
        	'sanitize_callback' => 'absint',
            'default'     => 1,
        )
    );

    $wp_customize->add_control('alia_show_header_description', array(
        'label'      => esc_attr__('Show Description in Site Header', 'alia'),
        'section'    => 'header_settings_section',
        'settings'   => 'alia_show_header_description',
        'type'       => 'checkbox'
    ));
    /* show description in site header */

    /* show site title in site header */
    $wp_customize->add_setting(
        'alia_show_header_site_title',
        array(
        	'sanitize_callback' => 'absint',
            'default'     => 1,
        )
    );

    $wp_customize->add_control('alia_show_header_site_title', array(
        'label'      => esc_attr__('Show Site Title in Menu Area', 'alia'),
        'section'    => 'header_settings_section',
        'settings'   => 'alia_show_header_site_title',
        'type'       => 'checkbox'
    ));
    /* show site title in site header */

    /* show dot after site title in site header */
    $wp_customize->add_setting(
        'alia_show_site_title_dot',
        array(
        	'sanitize_callback' => 'absint',
            'default'     => 1,
        )
    );

    $wp_customize->add_control('alia_show_site_title_dot', array(
        'label'      => esc_attr__('Show Dot after site title in header', 'alia'),
        'section'    => 'header_settings_section',
        'settings'   => 'alia_show_site_title_dot',
        'type'       => 'checkbox'
    ));
    /* show dot after site title in site header */

    /* custom header description text */
	$wp_customize->add_setting(
        'alia_header_description',
        array(
            'sanitize_callback' => 'alia_sanitize_minimal_decoration',
			'default' => '',
        )
    );

    $wp_customize->add_control('alia_header_description', array(
        'label'      => esc_attr__('Header Description', 'alia'),
        'description' => esc_attr__( 'Allowed HTML Tags: a, em, br, strong, img, i.', 'alia' ),
        'section'    => 'header_settings_section',
        'settings'   => 'alia_header_description',
        'type' => 'textarea'
    ));
    /* custom header description text */

	/* --------
	end header section header_settings_section
	------------------------------------------- */


	/* --------
	Start general section
	------------------------------------------- */
	/* pagination style */

	// Header Code
	$wp_customize->add_setting(
			'asalah_custom_header_code',
			array(
					'default'     => '',
					'transport' => 'postMessage',
					'sanitize_callback' => 'balanceTags'
			)
	);

	$wp_customize->add_control('asalah_custom_header_code', array(
		'label'      => __('Code to add before </head> - ex. Google Analytics', 'alia'),
		'section'    => 'general_settings_section',
		'settings'   => 'asalah_custom_header_code',
		'type'       => 'textarea',
	));

	/* Load Google Fonts locally */
	$wp_customize->add_setting(
			'alia_load_fonts_locally',
			array(
				'sanitize_callback' => 'absint',
					'default'     => 0,
			)
	);

	$wp_customize->add_control('alia_load_fonts_locally', array(
			'label'      => esc_attr__('Load fonts locally (recommended for performance)', 'alia'),
			'section'    => 'general_settings_section',
			'settings'   => 'alia_load_fonts_locally',
			'type'       => 'checkbox'
	));

	// fonts array to select from
	// all available fonts should be added and styled in functions.php -> alia_custom_fonts_url() -> $fonts_array

	$alia_custom_fonts_array = alia_custom_fonts_collection();

	$fonts_options = array('default' => esc_attr__('Safe Sans-Serif Fonts', 'alia') );

	$fonts_options['system'] = esc_attr__('System UI Fonts', 'alia');

	foreach ($alia_custom_fonts_array as $key => $atts) {
		$fonts_options[$key] = $atts['name'];
	}

	$wp_customize->add_setting(
	    'alia_main_font',
	    array(
	        'default'     => 'roboto',
	        'sanitize_callback' => 'esc_attr',
	    )
	);

	$wp_customize->add_control('alia_main_font', array(
	    'label'      => esc_attr__('Main Font', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_main_font',
	    'type'       => 'select',
	    'choices'    => $fonts_options,
	));

	$wp_customize->add_setting(
	    'alia_title_font',
	    array(
	        'default'     => 'poppins',
	        'sanitize_callback' => 'esc_attr',
	    )
	);

	$wp_customize->add_control('alia_title_font', array(
	    'label'      => esc_attr__('Titles Font', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_title_font',
	    'type'       => 'select',
	    'choices'    => $fonts_options,
	));
	/* pagination style */

	$wp_customize->add_setting(
			'alia_main_color',
			array(
					'default'     => '#ff374a',
					'sanitize_callback' => 'sanitize_hex_color',
			)
	);

	$wp_customize->add_control(
			new WP_Customize_Color_Control(
					$wp_customize,
					'alia_main_color',
					array(
							'label'      => __( 'Site main color', 'alia' ),
							'section'    => 'colors',
							'settings'   => 'alia_main_color',
							'priority' => 0
					)
			)
	);

	/* pagination style */
	$wp_customize->add_setting(
	    'alia_pagination_style',
	    array(
	        'default'     => 'num',
	        'sanitize_callback' => 'esc_attr',
	    )
	);

	$wp_customize->add_control('alia_pagination_style', array(
	    'label'      => esc_attr__('Pagination Style', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_pagination_style',
	    'type'       => 'select',
	    'choices'    => array(
	        'nav' => esc_attr__('Older/Newer Links', 'alia'),
	        'num' => esc_attr__('Numerical', 'alia')
	    ),
	));
	/* pagination style */

	/* blog layout style */
	$wp_customize->add_setting(
	    'alia_blog_layout',
	    array(
	        'default'     => 'flist',
	        'sanitize_callback' => 'esc_attr',
	    )
	);

	$wp_customize->add_control('alia_blog_layout', array(
	    'label'      => esc_attr__('Blog Layout', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_blog_layout',
	    'type'       => 'select',
	    'choices'    => array(
	        'flist' => esc_attr__('Full Width List', 'alia'),
	        'list' => esc_attr__('List', 'alia'),
	        'firstflist' => esc_attr__('Full Width then List', 'alia'),
	        'grid' => esc_attr__('2 Column Grid', 'alia'),
	        'grid3col' => esc_attr__('3 Column Grid', 'alia'),
	        'fullsidebar' => esc_attr__('Sidebar Default List', 'alia'),
	        'gridsidebar' => esc_attr__('Sidebar Grid', 'alia'),
	    ),
	));
	/* Show Featured on First Page only */

	$wp_customize->add_setting(
	    'alia_featured_first_page',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);
	$wp_customize->add_control('alia_featured_first_page', array(
	    'label'      => esc_attr__('Show Featured Post On First Page Only', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_featured_first_page',
	    'type'       => 'checkbox'
	));

	/* blog layout style */

	$wp_customize->add_setting(
	    'alia_enable_masonry',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);
	$wp_customize->add_control('alia_enable_masonry', array(
	    'label'      => esc_attr__('Enable Masonry Effect on Grid Layouts', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_enable_masonry',
	    'type'       => 'checkbox'
	));

	$wp_customize->add_setting(
	    'alia_totop_button',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);
	$wp_customize->add_control('alia_totop_button', array(
	    'label'      => esc_attr__('Enable Go To Top button', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_totop_button',
	    'type'       => 'checkbox'
	));

	/* show full content in homepage */
	$wp_customize->add_setting(
	    'alia_blog_show_all_content',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);

	$wp_customize->add_control('alia_blog_show_all_content', array(
	    'label'      => esc_attr__('Show full content in homepage.', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_blog_show_all_content',
	    'type'       => 'checkbox'
	));
	/* show full content in homepage */

	/* show border around text only posts */
	$wp_customize->add_setting(
	    'alia_border_text_posts',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);

	$wp_customize->add_control('alia_border_text_posts', array(
	    'label'      => esc_attr__('Show border around excerpt of text only posts.', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_border_text_posts',
	    'type'       => 'checkbox'
	));

	$wp_customize->add_setting(
	    'alia_menu_circle_idicator',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);
	$wp_customize->add_control('alia_menu_circle_idicator', array(
	    'label'      => esc_attr__('Show small circle to indicate current menu', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_menu_circle_idicator',
	    'type'       => 'checkbox'
	));
	/* show border around text only posts */

	if (function_exists('alia_create_stories')):
		/* stories page URL */
		$wp_customize->add_setting(
		    'alia_stories_slug',
		    array(
						'default' => '',
		        'sanitize_callback' => 'esc_attr',
		    )
		);

		$wp_customize->add_control('alia_stories_slug', array(
		    'label'      => esc_attr__('Stories slug at permalinks (Default is story)', 'alia'),
				'description' => sprintf( __('When changed/added, please go to <a href="%s">Permalinks</a> to refresh links.', 'alia'), admin_url("options-permalink.php")),
		    'section'    => 'general_settings_section',
		    'settings'   => 'alia_stories_slug',
		));
		/* stories page URL */

		/* stories page URL */
		$wp_customize->add_setting(
		    'alia_stories_page_url',
		    array(

		        'sanitize_callback' => 'esc_url',
		    )
		);

		$wp_customize->add_control('alia_stories_page_url', array(
		    'label'      => esc_attr__('Stories Page URL', 'alia'),
		    'section'    => 'general_settings_section',
		    'settings'   => 'alia_stories_page_url',
		));
		/* stories page URL */

		/* stories page URL */
		$wp_customize->add_setting(
		    'alia_stories_cdn_url',
		    array(

		        'sanitize_callback' => 'esc_url',
		    )
		);

		$wp_customize->add_control('alia_stories_cdn_url', array(
		    'label'      => esc_attr__('Stories CDN URL', 'alia'),
		    'decription' => esc_attr__("Add CDN URL if you want to load images from CDN like AWS, this cdn url will replace your site URL, don't use this option unless you know what you do.", 'alia'),
		    'section'    => 'general_settings_section',
		    'settings'   => 'alia_stories_cdn_url',
		));
		/* stories page URL */

		/* show stories circles in author box */
		$wp_customize->add_setting(
		    'alia_stories_author_box',
		    array(
		    	'sanitize_callback' => 'absint',
		        'default'     => 1,
		    )
		);

		$wp_customize->add_control('alia_stories_author_box', array(
		    'label'      => esc_attr__('Show stories circles in author box', 'alia'),
		    'section'    => 'general_settings_section',
		    'settings'   => 'alia_stories_author_box',
		    'type'       => 'checkbox'
		));


	endif; // end check for alia_create_stories function exists

	/* show border around text only posts */
	$wp_customize->add_setting(
	    'alia_disable_images_rounded_corners',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);

	$wp_customize->add_control('alia_disable_images_rounded_corners', array(
	    'label'      => esc_attr__('Disable rounded corners for images', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_disable_images_rounded_corners',
	    'type'       => 'checkbox'
	));

	/* Banners settings */
	$wp_customize->add_setting(
    	'alia_banners_quality_optimization',
			array(
				'sanitize_callback' => 'alia_sanitize_heading',
			)
    );
	$wp_customize->add_control( new Alia_Customizer_Heading_Text(
		$wp_customize,
		'alia_banners_quality_optimization',
		array(
			'label'	=> esc_attr__( 'Options related to Featured Images/Banners quality', 'alia' ),
			'description'	=> esc_attr__( 'Use <a target="_blank" href="https://wordpress.org/plugins/regenerate-thumbnails/">Regenerate Thumbnails</a> plugin after changing the options.', 'alia' ),
			'section' => 'general_settings_section',
			'settings' => 'alia_banners_quality_optimization',
		)
	));

	$wp_customize->add_setting(
	    'asalah_banners_devices_size',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);
	$wp_customize->add_control('asalah_banners_devices_size', array(
	    'label'      => esc_attr__('Enable different sizes for different screens', 'alia'),
	    'description'      => esc_attr__('Recommended for better performance and speed', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'asalah_banners_devices_size',
	    'type'       => 'checkbox'
	));

	$wp_customize->add_setting(
	    'asalah_image_optimization',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);
	$wp_customize->add_control('asalah_image_optimization', array(
	    'label'      => esc_attr__('Optimize Featured Images Quality to 100%', 'alia'),
	    'description'      => esc_attr__('disable default Wordpress quality compressing action.', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'asalah_image_optimization',
	    'type'       => 'checkbox'
	));

	/* what to show in meta area */
	$wp_customize->add_setting(
    	'alia_meta_info_items',
			array(
				'sanitize_callback' => 'alia_sanitize_heading',
			)
    );
	$wp_customize->add_control( new Alia_Customizer_Heading_Text(
		$wp_customize,
		'alia_meta_info_items',
		array(
			'label'	=> esc_attr__( 'Info shown in meta area', 'alia' ),
			'description'	=> esc_attr__( 'Select what information you want to show in meta area for posts & pages. Alia theme hide some info in narrow width layouts even if you enable them to keep the design clean.', 'alia' ),
			'section' => 'general_settings_section',
			'settings' => 'alia_meta_info_items',
		)
	));

	$wp_customize->add_setting(
	    'alia_show_author_avatar',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);
	$wp_customize->add_control('alia_show_author_avatar', array(
	    'label'      => esc_attr__('Author Avatar', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_show_author_avatar',
	    'type'       => 'checkbox'
	));

	$wp_customize->add_setting(
	    'alia_show_author',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);
	$wp_customize->add_control('alia_show_author', array(
	    'label'      => esc_attr__('Author Name', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_show_author',
	    'type'       => 'checkbox'
	));

	$wp_customize->add_setting(
	    'alia_show_categories',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);
	$wp_customize->add_control('alia_show_categories', array(
	    'label'      => esc_attr__('Categories', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_show_categories',
	    'type'       => 'checkbox'
	));

	$wp_customize->add_setting(
	    'alia_show_date',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);
	$wp_customize->add_control('alia_show_date', array(
	    'label'      => esc_attr__('Date', 'alia'),
	    'section'    => 'general_settings_section',
	    'settings'   => 'alia_show_date',
	    'type'       => 'checkbox'
	));


	/* --------
	end general section
	------------------------------------------- */

	/* --------
	start posts section
	------------------------------------------- */

	/* post layout */
	$wp_customize->add_setting(
	    'alia_post_layout',
	    array(
	        'default'     => 'fullwidth',
	        'sanitize_callback' => 'esc_attr',
	    )
	);

	$wp_customize->add_control('alia_post_layout', array(
	    'label'      => esc_attr__('Post Layout', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'alia_post_layout',
	    'type'       => 'select',
	    'choices'    => array(
	        'fullwidth' => esc_attr__('No Sidebar', 'alia'),
	        'sidebar_l' => esc_attr__('Sidebar Post', 'alia')
	    ),
	));
	/* post layout */


	/* show banner inside standard post */
	$wp_customize->add_setting(
	    'alia_show_banner_inside_standard_posts',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_show_banner_inside_standard_posts', array(
	    'label'      => esc_attr__('Show banner inside standard post', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'alia_show_banner_inside_standard_posts',
	    'type'       => 'checkbox'
	));
	/* show banner inside standard post */



	/* crop banner images in post lists */
	$wp_customize->add_setting(
	    'alia_crop_banner_post_list',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_crop_banner_post_list', array(
	    'label'      => esc_attr__('Crop featured image in posts lists', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'alia_crop_banner_post_list',
	    'type'       => 'checkbox'
	));
	/* crop banner image in post lists */

	/* crop banner images inside post */
	$wp_customize->add_setting(
	    'alia_crop_banner_inside_post',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);

	$wp_customize->add_control('alia_crop_banner_inside_post', array(
	    'label'      => esc_attr__('Crop featured image inside posts', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'alia_crop_banner_inside_post',
	    'type'       => 'checkbox'
	));
	/* crop banner images inside post */

	/* show meta info in posts */
	$wp_customize->add_setting(
	    'alia_meta_info_posts',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_meta_info_posts', array(
	    'label'      => esc_attr__('Show meta info in posts', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'alia_meta_info_posts',
	    'type'       => 'checkbox'
	));
	/* show meta info in posts */

	/* show tags in posts */
	$wp_customize->add_setting(
	    'alia_show_tags_posts',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_show_tags_posts', array(
	    'label'      => esc_attr__('Show tags below post content', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'alia_show_tags_posts',
	    'type'       => 'checkbox'
	));
	/* show tags in posts */

	/* show share buttons in posts */
	$wp_customize->add_setting(
	    'alia_show_share_buttons_posts',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_show_share_buttons_posts', array(
	    'label'      => esc_attr__('Show share buttons below post content', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'alia_show_share_buttons_posts',
	    'type'       => 'checkbox'
	));
	/* show share buttons in posts */

	/* show author box in posts */
	$wp_customize->add_setting(
	    'alia_show_author_box_posts',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_show_author_box_posts', array(
	    'label'      => esc_attr__('Show author box in posts', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'alia_show_author_box_posts',
	    'type'       => 'checkbox'
	));
	/* show author box in posts */

	/* show next post */
	$wp_customize->add_setting(
	    'alia_show_next_post',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_show_next_post', array(
	    'label'      => esc_attr__('Show next post', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'alia_show_next_post',
	    'type'       => 'checkbox'
	));
	/* show next post */

	/* show related posts */
	$wp_customize->add_setting(
	    'alia_show_related_post',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_show_related_post', array(
	    'label'      => esc_attr__('Show related post', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'alia_show_related_post',
	    'type'       => 'checkbox'
	));
	/* show related posts */

	// Related Posts Relation Type
	$wp_customize->add_setting(
	    'asalah_relation_posts',
	    array(
	        'default'     => 'category',
	        'sanitize_callback' => 'esc_attr',
	    )
	);

	$wp_customize->add_control('asalah_relation_posts', array(
	    'label'      => esc_attr__('Related Posts According to', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'asalah_relation_posts',
	    'type'       => 'select',
	    'choices'    => array(
				'category' => __('Categories', 'alia'),
				'tag' => __('Tags', 'alia'),
				'author' => __('Author', 'alia'),
	    ),
	));

	/* allow counting post views for views count option at posts list widget */
	$wp_customize->add_setting(
	    'alia_hits_counter',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);

	$wp_customize->add_control('alia_hits_counter', array(
	    'label'      => esc_attr__('Allow counting post views for posts list order', 'alia'),
	    'section'    => 'post_settings_section',
	    'settings'   => 'alia_hits_counter',
	    'type'       => 'checkbox'
	));
	/* allow counting post views for views count option at posts list widget */

	/* --------
	start posts section
	------------------------------------------- */

	/* --------
	start pages section
	------------------------------------------- */

	/* post layout */
	$wp_customize->add_setting(
	    'alia_page_layout',
	    array(
	        'default'     => 'fullwidth',
	        'sanitize_callback' => 'esc_attr',
	    )
	);

	$wp_customize->add_control('alia_page_layout', array(
	    'label'      => esc_attr__('Post Layout', 'alia'),
	    'section'    => 'page_settings_section',
	    'settings'   => 'alia_page_layout',
	    'type'       => 'select',
	    'choices'    => array(
	        'fullwidth' => esc_attr__('No Sidebar', 'alia'),
	        'sidebar_l' => esc_attr__('Sidebar Post', 'alia')
	    ),
	));
	/* post layout */

	/* show meta info in pages */
	$wp_customize->add_setting(
	    'alia_meta_info_pages',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);

	$wp_customize->add_control('alia_meta_info_pages', array(
	    'label'      => esc_attr__('Show meta info in Pages', 'alia'),
	    'section'    => 'page_settings_section',
	    'settings'   => 'alia_meta_info_pages',
	    'type'       => 'checkbox'
	));
	/* show meta info in pages */

	/* show share buttons in pages */
	$wp_customize->add_setting(
	    'alia_show_share_buttons_pages',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_show_share_buttons_pages', array(
	    'label'      => esc_attr__('Show share buttons below page content', 'alia'),
	    'section'    => 'page_settings_section',
	    'settings'   => 'alia_show_share_buttons_pages',
	    'type'       => 'checkbox'
	));
	/* show share buttons in pages */

	/* show author box in pages */
	$wp_customize->add_setting(
	    'alia_show_author_box_pages',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_show_author_box_pages', array(
	    'label'      => esc_attr__('Show author box in pages', 'alia'),
	    'section'    => 'page_settings_section',
	    'settings'   => 'alia_show_author_box_pages',
	    'type'       => 'checkbox'
	));
	/* show author box in pages */

	/* show full width content */
	$wp_customize->add_setting(
	    'alia_show_fullwidth_text',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);

	$wp_customize->add_control('alia_show_fullwidth_text', array(
	    'label'      => esc_attr__('Show wide text content for pages', 'alia'),
	    'section'    => 'page_settings_section',
	    'settings'   => 'alia_show_fullwidth_text',
	    'type'       => 'checkbox'
	));
	/* show full width content */

	/* --------
	start pages section
	------------------------------------------- */

	/* --------
	start social section
	------------------------------------------- */

	/* Mailchimp newsletter form code */
	$wp_customize->add_setting(
	    'alia_mailchimp_code',
	    array(

	        'sanitize_callback' => 'balanceTags',
	    )
	);

	$wp_customize->add_control('alia_mailchimp_code', array(
	    'label'      => esc_attr__('Add MailChimp Embeded Form Code', 'alia'),
	    'description' => esc_attr__('For best results copy the naked code from MailChimp', 'alia'),
	    'section'    => 'social_settings_section',
	    'settings'   => 'alia_mailchimp_code',
	    'type'       => 'textarea',
	));
	/* Mailchimp newsletter form code */

	/* enable facebook js */
	$wp_customize->add_setting(
	    'alia_fb_sdk',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_fb_sdk', array(
	    'label'      => esc_attr__('Load Facebook SDK', 'alia'),
	    'description' => esc_attr__("You need to disable this option if you are using a plugin who already loads FB SDK, or you just don't want to use Facebook features.", 'alia'),
	    'section'    => 'social_settings_section',
	    'settings'   => 'alia_fb_sdk',
	    'type'       => 'checkbox'
	));


	/* Social Share buttons */
	$share_buttons = array('facebook' => 'Facebook', 'twitter' => 'Twitter', 'gplus' => 'Google+', 'pinterest' => 'Pinterest', 'linkedin' => 'Linkedin', 'vk' => 'VK', 'tumblr' => 'Tumblr', 'reddit' => 'Reddit', 'pocket' => 'Pocket', 'stumbleupon' => 'Stumbleupon', 'whatsapp' => "Whatsapp", 'telegram' => 'Telegram');

	/* show social icons in site header */
	$wp_customize->add_setting(
	    'alia_show_header_social_icons',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);

	$wp_customize->add_control('alia_show_header_social_icons', array(
	    'label'      => esc_attr__('Show Social Icons in Site Header', 'alia'),
	    'section'    => 'social_settings_section',
	    'settings'   => 'alia_show_header_social_icons',
	    'type'       => 'checkbox'
	));
	/* show social icons in site header */

	$wp_customize->add_setting(
    	'alia_blog_list_share_title',
			array(
				'sanitize_callback' => 'alia_sanitize_heading',
			)
    );
	$wp_customize->add_control( new Alia_Customizer_Heading_Text(
		$wp_customize,
		'alia_blog_list_share_title',
		array(
			'label'	=> esc_attr__( 'Share buttons in blog lists', 'alia' ),
			'description'	=> esc_attr__( 'Select which share buttons you want to show in blog lists in homepage and archives, try not to select to many buttons to keep your blog list clean.', 'alia' ),
			'section' => 'social_settings_section',
			'settings' => 'alia_blog_list_share_title',
		)
	));

	foreach ($share_buttons as $network=>$social) {
		$wp_customize->add_setting(
        'alia_blog_list_'.$network.'_share',
	        array(
	        	'default' => 0,
	           'sanitize_callback' => 'absint',
	        )
	    );

		$wp_customize->add_control('alia_blog_list_'.$network.'_share', array(
	        'label'      => $social,
	        'section'    => 'social_settings_section',
	        'settings'   => 'alia_blog_list_'.$network.'_share',
	        'type'       => 'checkbox',
		));
	}


	$wp_customize->add_setting(
    	'alia_single_share_title',
			array(
				'sanitize_callback' => 'alia_sanitize_heading',
			)
    );
	$wp_customize->add_control( new Alia_Customizer_Heading_Text(
		$wp_customize,
		'alia_single_share_title',
		array(
			'label'	=> esc_attr__( 'Share buttons inside post', 'alia' ),
			'description'	=> esc_attr__( 'Select which share buttons you want to show inside the blog post.', 'alia' ),
			'section' => 'social_settings_section',
			'settings' => 'alia_single_share_title',
		)
	));

	foreach ($share_buttons as $network=>$social) {
		if ($network == "whatsapp") {
			$default = 0;
		} else {
			$default = 1;
		}
		$wp_customize->add_setting(
        'alia_'.$network.'_share',
	        array(
	        	'default' => $default,
	            'sanitize_callback' => 'absint',
	        )
	    );

		$wp_customize->add_control('alia_'.$network.'_share', array(
	        'label'      => $social,
	        'section'    => 'social_settings_section',
	        'settings'   => 'alia_'.$network.'_share',
	        'type'       => 'checkbox',
		));
	}


	$wp_customize->add_setting(
    	'alia_social_profiles_urls',
			array(
				'sanitize_callback' => 'alia_sanitize_heading',
			)
    );
	$wp_customize->add_control( new Alia_Customizer_Heading_Text(
		$wp_customize,
		'alia_social_profiles_urls',
		array(
			'label'	=> esc_attr__( 'Add your social profiles links', 'alia' ),
			'section' => 'social_settings_section',
			'settings' => 'alia_social_profiles_urls',
		)
	));
    /* social profiles */
    global $social_networks;
    foreach ($social_networks as $network => $social ) {
        $wp_customize->add_setting(
            'alia_'.$network.'_url',
            array(

                'sanitize_callback' => 'esc_url',
            )
        );

        $wp_customize->add_control('alia_'.$network.'_url', array(
            'label'      => $social.' URL',
            'section'    => 'social_settings_section',
            'settings'   => 'alia_'.$network.'_url',
        ));
    }
	/* --------
	end social section
	------------------------------------------- */

	/* --------
	start footer section
	------------------------------------------- */

	/* sticky footer content */
	$wp_customize->add_setting(
	    'alia_sticky_footer_content',
	    array(
	    	'sanitize_callback' => 'esc_attr',
	        'default'     => '0',
	    )
	);

	$sticky_footer_options_array = array( 0 => esc_attr__('Hide', 'alia') );

	// add stories option if core plugin exists.
	if (function_exists('alia_create_stories')) {
		$sticky_footer_options_array['stories_circle'] = esc_attr__('Show Stories Circles', 'alia');
	}

	$sticky_footer_options_array['custom_footer_content'] = esc_attr__('Show Custom Footer Content', 'alia');

	$wp_customize->add_control('alia_sticky_footer_content', array(
	    'label'      => esc_attr__('Static Footer Bar', 'alia'),
	    'section'    => 'footer_settings_section',
	    'settings'   => 'alia_sticky_footer_content',
	    'type'       => 'select',
	    'choices'    => $sticky_footer_options_array,
	));
	/* sticky footer content */

	/* sticky footer title */
	$wp_customize->add_setting(
	    'alia_sticky_footer_title',
	    array(
	        'sanitize_callback' => 'esc_attr',
	        'default' => esc_attr__('Recent Stories', 'alia'),
	    )
	);

	$wp_customize->add_control('alia_sticky_footer_title', array(
	    'label'      => esc_attr__('Sticky Footer Title', 'alia'),
	    'description' => esc_attr__('Use title with 2 words only like Alia Stories', 'alia'),
	    'section'    => 'footer_settings_section',
	    'settings'   => 'alia_sticky_footer_title',
	    'type'       => 'textarea',
	));
	/* sticky footer title  */

	/* footer custom content */
	$wp_customize->add_setting(
	    'alia_sticky_footer_custom_content',
	    array(
	        'sanitize_callback' => 'alia_sanitize_minimal_decoration',
	        'default' => ''
	    )
	);

	$wp_customize->add_control('alia_sticky_footer_custom_content', array(
	    'label'      => esc_attr__('Footer Custom Content', 'alia'),
	    'description' => esc_attr__( 'Allowed HTML Tags: a, em, br, strong, img, i.', 'alia' ),
	    'section'    => 'footer_settings_section',
	    'settings'   => 'alia_sticky_footer_custom_content',
	    'type'       => 'textarea',
	));
	/* footer custom content */

	/* footer credits */
	$wp_customize->add_setting(
	    'alia_footer_credits',
	    array(
	        'sanitize_callback' => 'alia_sanitize_minimal_decoration',
	        'default' => '&copy; ' . date('Y') . ' ' . get_bloginfo( 'name' )
	    )
	);

	$wp_customize->add_control('alia_footer_credits', array(
	    'label'      => esc_attr__('Footer Credits Text', 'alia'),
	    'description' => esc_attr__( 'Allowed HTML Tags: a, em, br, strong, img, i.', 'alia' ),
	    'section'    => 'footer_settings_section',
	    'settings'   => 'alia_footer_credits',
	    'type'       => 'textarea',
	));
	/* footer credits */

	/* show cookies notice */
	$wp_customize->add_setting(
	    'alia_show_cookies_notice',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 0,
	    )
	);
	$wp_customize->add_control('alia_show_cookies_notice', array(
	    'label'      => esc_attr__('Show a notice to tell site visitors that this site is using cookies, after you activate this option you still need to add cookies description text for notice to appear.', 'alia'),
	    'section'    => 'footer_settings_section',
	    'settings'   => 'alia_show_cookies_notice',
	    'type'       => 'checkbox'
	));

	$wp_customize->add_setting(
	    'alia_show_cookies_icon',
	    array(
	    	'sanitize_callback' => 'absint',
	        'default'     => 1,
	    )
	);
	$wp_customize->add_control('alia_show_cookies_icon', array(
	    'label'      => esc_attr__('Show cookies box icon', 'alia'),
	    'section'    => 'footer_settings_section',
	    'settings'   => 'alia_show_cookies_icon',
	    'type'       => 'checkbox'
	));

	$wp_customize->add_setting(
        'alia_cookies_icon_class',
        array(
            'sanitize_callback' => 'esc_attr',
			'default' => '',
        )
    );
    $wp_customize->add_control('alia_cookies_icon_class', array(
        'label'  => esc_attr__('Cookies Font Awesome icon class', 'alia'),
        'description'  => esc_attr__('If you want to change cookies icon, you can choose other icon from Font Awesome library and add the full class of desired icon here to replace it.', 'alia'),
        'section'    => 'footer_settings_section',
        'settings'   => 'alia_cookies_icon_class',
        'type' => 'text'
    ));

	$wp_customize->add_setting(
        'alia_cookies_title',
        array(
            'sanitize_callback' => 'esc_attr',
			'default' => '',
        )
    );
    $wp_customize->add_control('alia_cookies_title', array(
        'label'      => esc_attr__('Cookies notice title', 'alia'),
        'section'    => 'footer_settings_section',
        'settings'   => 'alia_cookies_title',
        'type' => 'textarea'
    ));

    $wp_customize->add_setting(
        'alia_cookies_description_text',
        array(
            'sanitize_callback' => 'alia_sanitize_minimal_decoration',
			'default' => '',
        )
    );
    $wp_customize->add_control('alia_cookies_description_text', array(
        'label'      => esc_attr__('Cookies notice description text', 'alia'),
        'description' => esc_attr__( 'This text is used to tell your visitors that this site is using cookies, Allowed HTML Tags: a, em, br, strong, img, i.', 'alia' ),
        'section'    => 'footer_settings_section',
        'settings'   => 'alia_cookies_description_text',
        'type' => 'textarea'
    ));

    $wp_customize->add_setting(
        'alia_cookies_links_text',
        array(
            'sanitize_callback' => 'alia_sanitize_minimal_decoration',
			'default' => '',
        )
    );
    $wp_customize->add_control('alia_cookies_links_text', array(
        'label'      => esc_attr__('Cookies notice links area', 'alia'),
        'description' => esc_attr__( 'This text will appear just before the agree button to show your policies pages links, Allowed HTML Tags: a, em, br, strong, img, i.', 'alia' ),
        'section'    => 'footer_settings_section',
        'settings'   => 'alia_cookies_links_text',
        'type' => 'textarea'
    ));
    /* end cookies notice */

	/* footer custom code */
	$wp_customize->add_setting(
	    'alia_custom_footer_code',
	    array(

	        'sanitize_callback' => 'balanceTags',
	    )
	);

	$wp_customize->add_control('alia_custom_footer_code', array(
	    'label'      => esc_attr__('Add custom code to footer', 'alia'),
	    'section'    => 'footer_settings_section',
	    'settings'   => 'alia_custom_footer_code',
	    'type'       => 'textarea',
	));
	/* footer custom code */

	/* --------
	end footer section
	------------------------------------------- */

}
add_action( 'customize_register', 'alia_customize_register' );


/**
 * Custom control for options heading, extend the WP customizer
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	class Alia_Customizer_Heading_Text extends WP_Customize_Control {

	    /**
	     * Render the control's content.
	     */
	    public function render_content() {

	    	echo '<br />';
	        echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
	        echo '<p class="description">' . wp_specialchars_decode($this->description) . '</p>';
	        echo '<hr />';

	    }

	}
}

function alia_de_register_defaults( $wp_customize ) {
    $wp_customize->remove_control('display_header_text');
}
add_action( 'customize_register', 'alia_de_register_defaults', 11 );

?>