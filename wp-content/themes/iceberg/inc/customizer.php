<?php
/**
 * Iceberg Customizer support
 *
 * @package WordPress
 * @since Iceberg 1.0
 */
 
/**
 * Implement Customizer additions and adjustments.
 *
 * @since Iceberg 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function iceberg_customize_register( $wp_customize ) {
    /*
    * Modify default Wordpress sections and controls
    */
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_control( 'blogdescription' )->label = esc_html__( 'Site Description', 'iceberg' );

    $wp_customize->get_control( 'custom_logo' )->priority = 0;
    $wp_customize->get_control( 'blogname' )->priority = 15;
    $wp_customize->get_control( 'blogdescription' )->priority = 20;
    $wp_customize->get_control( 'site_icon' )->priority = 35;

    $wp_customize->get_control( 'background_color' )->section = 'background_color';
  
    /*
    * Site Title & Tagline
    */   

    $wp_customize->add_setting( 'display_site_title',
        array(
            'default' => 1,
            'sanitize_callback' => 'iceberg_checkbox_sanitize'
        )
    );

    $wp_customize->add_control( 'display_site_title', array(
        'type'     => 'checkbox',
        'priority' => 25,
        'label'    => esc_html__( 'Display Site Title', 'iceberg' ),
        'section'  => 'title_tagline',
    ) );

    $wp_customize->add_setting(
        'tagline',
        array(
            'default' => '',
            'sanitize_callback' => 'iceberg_textarea_sanitize',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'tagline',
        array(
            'type'        => 'textarea',
            'priority'    => 30,
            'label'       => esc_html__( 'Tagline', 'iceberg' ),
            'description' => esc_html__( 'You may use these HTML tags and attributes: a[href,title,target], strong, b, em, i, p, span, br, img[src,title,alt]', 'iceberg' ),
            'section'     => 'title_tagline',
        )
    );
  
    /*
    * Logo
    */

    $wp_customize->add_setting( 'logo_width',
        array(
            'default' => 15,
            'sanitize_callback' => 'iceberg_logo_size_sanitize',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control( 'logo_width', array(
        'type'        => 'range',
        'priority'    => 5,
        'section'     => 'title_tagline',
        'label'       => esc_html__( 'Size', 'iceberg' ),
        'input_attrs' => array(
            'min'   => 5,
            'max'   => 30,
            'step'  => 1
        ),
    ) );
  
    $wp_customize->add_setting( 'logo_margin_bottom',
        array(
            'default' => 2,
            'sanitize_callback' => 'absint',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control( 'logo_margin_bottom', array(
        'type'        => 'range',
        'priority'    => 10,
        'section'     => 'title_tagline',
        'label'       => esc_html__( 'Margin Bottom', 'iceberg' ),
        'input_attrs' => array(
            'min'   => 1,
            'max'   => 20,
            'step'  => 1
        ),
    ) );
  
    /*
    * Layout
    */ 
    $wp_customize->add_section( 'layout',
        array(
            'title' => esc_html__( 'Layout', 'iceberg' )
        )
    );

    $wp_customize->add_setting(
        'basic_layout',
        array(
            'default' => 'sidebar-left',
            'sanitize_callback' => 'iceberg_basic_layout_sanitize',
        )
    );

    $wp_customize->add_control(
        'basic_layout',
        array(
            'type'    => 'select',
            'label'   => esc_html__( 'Sidebar', 'iceberg' ),
            'section' => 'layout',
            'choices' => array(
                'sidebar-left'  => is_rtl() ? esc_html__( 'Right (default)', 'iceberg' ) : esc_html__( 'Left (default)', 'iceberg' ),
                'sidebar-right' => is_rtl() ? esc_html__( 'Left', 'iceberg' ) : esc_html__( 'Right', 'iceberg' )
            )
        )
    );
  
    /*
    * Colors
    */
    $wp_customize->add_panel( 'colors', array(
        'priority' => 10,
        'title'    => esc_html__( 'Colors', 'iceberg' ),
    ) ); 

    $wp_customize->add_section( 'background_color',
        array(
            'title' => esc_html__( 'Background', 'iceberg' ),
            'panel' => 'colors',
            'priority' => 0,
        )
    );

    $wp_customize->add_section( 'site_identity_colors',
        array(
            'title' => esc_html__( 'Site Identity', 'iceberg' ),
            'panel' => 'colors',
            'priority' => 5,
        )
    );  

    $wp_customize->add_setting( 'site_title_color',
        array(
            'default' => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
            'site_title_color',
            array(
                'label' => esc_html__( 'Site Title', 'iceberg' ),
                'section' => 'site_identity_colors',
                'settings' => 'site_title_color',
            )
        )
    ); 

    $wp_customize->add_setting( 'social_icons_color',
        array(
            'default' => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
            'social_icons_color',
            array(
                'label' => esc_html__( 'Social Icons', 'iceberg' ),
                'section' => 'site_identity_colors',
                'settings' => 'social_icons_color',
            )
        )
    ); 

    $wp_customize->add_section( 'sidebar_colors',
        array(
            'title' => esc_html__( 'Sidebar', 'iceberg' ),
            'panel' => 'colors',
            'priority' => 10,
        )
    );  

    $wp_customize->add_setting( 'sidebar_background_color',
        array(
            'default' => '#27282b',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
            'sidebar_background_color',
            array(
                'label' => esc_html__( 'Background', 'iceberg' ),
                'section' => 'sidebar_colors',
                'settings' => 'sidebar_background_color',
            )
        )
    );    

    $wp_customize->add_setting( 'sidebar_divider_color',
        array(
            'default' => '#1d1e21',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
            'sidebar_divider_color',
            array(
                'label' => esc_html__( 'Divider', 'iceberg' ),
                'section' => 'sidebar_colors',
                'settings' => 'sidebar_divider_color',
            )
        )
    );  

    $wp_customize->add_setting( 'sidebar_text_color',
        array(
            'default' => '#c1c1c1',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
            'sidebar_text_color',
            array(
                'label' => esc_html__( 'Text', 'iceberg' ),
                'section' => 'sidebar_colors',
                'settings' => 'sidebar_text_color',
            )
        )
    );   

    $wp_customize->add_setting( 'sidebar_headings_color',
        array(
            'default' => '#d1d1d1',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
            'sidebar_headings_color',
            array(
                'label' => esc_html__( 'Headings', 'iceberg' ),
                'section' => 'sidebar_colors',
                'settings' => 'sidebar_headings_color',
            )
        )
    );  

    $wp_customize->add_setting( 'sidebar_links_color',
        array(
            'default' => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
            'sidebar_links_color',
            array(
                'label' => esc_html__( 'Links', 'iceberg' ),
                'section' => 'sidebar_colors',
                'settings' => 'sidebar_links_color',
            )
        )
    );  

    $wp_customize->add_setting( 'sidebar_links_hover_color',
        array(
            'default' => '#c1c1c1',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
            'sidebar_links_hover_color',
            array(
                'label' => esc_html__( 'Links (hover)', 'iceberg' ),
                'section' => 'sidebar_colors',
                'settings' => 'sidebar_links_hover_color',
            )
        )
    ); 

    $wp_customize->add_section( 'content_area_colors',
        array(
            'title' => esc_html__( 'Content Area', 'iceberg' ),
            'panel' => 'colors',
            'priority' => 15,
        )
    );  

    $wp_customize->add_setting( 'link_color',
        array(
            'default' => '#57ad68',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
            'link_color',
            array(
                'label' => esc_html__( 'Links', 'iceberg' ),
                'section' => 'content_area_colors',
                'settings' => 'link_color',
            )
        )
    ); 

    $wp_customize->add_setting( 'link_color_hover',
        array(
            'default' => '#468c54',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'link_color_hover',
            array(
                'label' => esc_html__( 'Links (hover)', 'iceberg' ),
                'section' => 'content_area_colors',
                'settings' => 'link_color_hover',
            )
        )
    ); 
  
    $wp_customize->add_setting( 'button_background_color',
        array(
            'default' => '#57ad68',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'button_background_color',
            array(
                'label' => esc_html__( 'Buttons', 'iceberg' ),
                'section' => 'content_area_colors',
                'settings' => 'button_background_color',
            )
        )
    ); 
  
    $wp_customize->add_setting( 'button_background_color_hover',
        array(
            'default' => '#468c54',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'button_background_color_hover',
            array(
                'label' => esc_html__( 'Buttons (hover)', 'iceberg' ),
                'section' => 'content_area_colors',
                'settings' => 'button_background_color_hover',
            )
        )
    ); 
  
    $wp_customize->add_setting( 'button_text_color',
        array(
            'default' => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'button_text_color',
            array(
                'label' => esc_html__( 'Buttons Text', 'iceberg' ),
                'section' => 'content_area_colors',
                'settings' => 'button_text_color',
            )
        )
    ); 

    $wp_customize->add_setting( 'category_label_color',
        array(
            'default' => '#71b2e4',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'category_label_color',
            array(
                'label' => esc_html__( 'Category', 'iceberg' ),
                'section' => 'content_area_colors',
                'settings' => 'category_label_color',
            )
        )
    ); 

    $wp_customize->add_section( 'other_colors',
        array(
            'title' => esc_html__( 'Other Colors', 'iceberg' ),
            'panel' => 'colors',
            'priority' => 25,
        )
    ); 

    $wp_customize->add_setting( 'preloader_color',
        array(
            'default' => '#d1d1d1',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'preloader_color',
            array(
                'label' => esc_html__( 'Preloader', 'iceberg' ),
                'section' => 'other_colors',
                'settings' => 'preloader_color',
            )
        )
    ); 

    $wp_customize->add_setting( 'selection_color',
        array(
            'default' => '#3579ce',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'selection_color',
            array(
                'label' => esc_html__( 'Text Selection', 'iceberg' ),
                'section' => 'other_colors',
                'settings' => 'selection_color',
            )
        )
    ); 
  
    /*
    * Titles & Headings
    */  
    $wp_customize->add_section( 'titles_and_headings',
        array(
            'title' => esc_html__( 'Titles & Headings', 'iceberg' )
        )
    );

    $wp_customize->add_setting( 'sticky_post_title',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control( 'sticky_post_title', array(
        'type'        => 'text',
        'priority'    => 0,
        'label'       => esc_html__( 'Sticky post', 'iceberg' ),
        'section'     => 'titles_and_headings',
        'description' => esc_html__( 'Default: &laquo;Featured&raquo;', 'iceberg' )
    ) );


    $wp_customize->add_setting( 'more_link_title',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control( 'more_link_title', array(
        'type'        => 'text',
        'priority'    => 0,
        'label'       => esc_html__( 'Read More', 'iceberg' ),
        'section'     => 'titles_and_headings',
        'description' => esc_html__( 'Default: &laquo;Read More&raquo;', 'iceberg' )
    ) );
   
   /*
   * Post Options
   */
    $wp_customize->add_section( 'post_options',
        array(
            'title' => esc_html__( 'Post Options', 'iceberg' )
        )
    ); 

    $wp_customize->add_setting( 'display_categories',
        array(
            'default' => 1,
            'sanitize_callback' => 'iceberg_checkbox_sanitize',
        )
    );
  
    $wp_customize->add_control( 'display_categories', array(
        'type'     => 'checkbox',
        'priority' => 0,
        'label'    => esc_html__( 'Display categories', 'iceberg' ),
        'section'  => 'post_options',
    ) );

    $wp_customize->add_setting( 'display_date',
        array(
            'default' => 1,
            'sanitize_callback' => 'iceberg_checkbox_sanitize',
        )
    );

    $wp_customize->add_control( 'display_date', array(
        'type'     => 'checkbox',
        'priority' => 0,
        'label'    => esc_html__( 'Display post date', 'iceberg' ),
        'section'  => 'post_options',
    ) );
  
    $wp_customize->add_setting( 'display_tags_list',
        array(
            'default' => 1,
            'sanitize_callback' => 'iceberg_checkbox_sanitize',
        )
    );

    $wp_customize->add_control( 'display_tags_list', array(
        'type'     => 'checkbox',
        'priority' => 0,
        'label'    => esc_html__( 'Display tags list', 'iceberg' ),
        'section'  => 'post_options',
    ) );
  
    $wp_customize->add_setting( 'display_share_buttons',
        array(
            'default' => 1,
            'sanitize_callback' => 'iceberg_checkbox_sanitize',
        )
    );

    $wp_customize->add_control( 'display_share_buttons', array(
        'type'     => 'checkbox',
        'priority' => 0,
        'label'    => esc_html__( 'Display share buttons', 'iceberg' ),
        'section'  => 'post_options',
    ) );

    $wp_customize->add_setting( 'display_author',
        array(
            'default' => 1,
            'sanitize_callback' => 'iceberg_checkbox_sanitize',
        )
    );

    $wp_customize->add_control( 'display_author', array(
        'type'     => 'checkbox',
        'priority' => 0,
        'label'    => esc_html__( 'Display author', 'iceberg' ),
        'section'  => 'post_options',
    ) );
  
    /*
    * Page Options
    */
    $wp_customize->add_section( 'page_options',
        array(
            'title' => esc_html__( 'Page Options', 'iceberg' )
        )
    ); 

    $wp_customize->add_setting( 'display_page_share_buttons',
        array(
            'default' => 1,
            'sanitize_callback' => 'iceberg_checkbox_sanitize',
        )
    );

    $wp_customize->add_control( 'display_page_share_buttons', array(
        'type'     => 'checkbox',
        'priority' => 0,
        'label'    => esc_html__( 'Display share buttons', 'iceberg' ),
        'section'  => 'page_options',
    ) );
  
    /*
    * Footer
    */  
    $wp_customize->add_section( 'footer',
        array(
            'title' => esc_html__( 'Footer', 'iceberg' )
        )
    ); 

    $wp_customize->add_setting(
        'copyright',
        array(
            'default' => '',
            'sanitize_callback' => 'iceberg_textarea_sanitize',
        )
    );

    $wp_customize->add_control(
        'copyright',
        array(
            'type'    => 'textarea',
            'label'   => esc_html__( 'Copyright', 'iceberg' ),
            'description' => esc_html__( 'You may use these HTML tags and attributes: a[href,title,target], strong, b, em, i, p, span, br, img[src,title,alt]', 'iceberg' ),
            'section' => 'footer',
        )
    );
  	
    /*
    * Other Options
    */    
    $wp_customize->add_section( 'other_options',
        array(
        'title' => esc_html__( 'Other Options', 'iceberg' )
        )
    ); 

    $wp_customize->add_setting( 'show_preloader_screen',
        array(
            'default' => 1,
            'sanitize_callback' => 'iceberg_checkbox_sanitize',
        )
    );

    $wp_customize->add_control( 'show_preloader_screen', array(
        'type'     => 'checkbox',
        'priority' => 0,
        'label'    => esc_html__( 'Show preloader', 'iceberg' ),
        'section'  => 'other_options',
    ) );

}
add_action( 'customize_register', 'iceberg_customize_register' );

/**
* Binds JS handlers to make the Customizer preview reload changes asynchronously.
*
* @since Iceberg 1.0
*/
function iceberg_customize_preview_js() {
    wp_enqueue_script( 'iceberg-customize-preview', get_template_directory_uri() . '/assets/js/admin/customize-preview.js', array( 'customize-preview' ), '20191122', true );
}

add_action( 'customize_preview_init', 'iceberg_customize_preview_js' );

if ( ! function_exists( 'iceberg_textarea_sanitize' ) ) :
    /**
    * Sanitization callback for textarea field.
    *
    * @since Iceberg 1.0
    * @return string Textarea value.
    */
    function iceberg_textarea_sanitize( $value ) {
        if ( !current_user_can('unfiltered_html') )
            $value  = stripslashes( wp_filter_post_kses( addslashes( $value ) ) ); // wp_filter_post_kses() expects slashed

        return $value;
    }
endif;

if ( ! function_exists( 'iceberg_logo_size_sanitize' ) ) :
    /**
    * Sanitization callback for logo width range slider.
    *
    * @since Iceberg 2.0
    */
    function iceberg_logo_size_sanitize( $value ) {
        if ( is_numeric( $value ) && $value >= 10 && $value <= 30 )
            return $value;

        return 10;
    }
endif;

if ( ! function_exists( 'iceberg_checkbox_sanitize' ) ) :
    /**
    * Sanitization callback for checkbox.
    *
    * @since Iceberg 1.0
    */
    function iceberg_checkbox_sanitize( $value ) {
        if ( $value == 1 ) {
            return 1;
        } else {
            return '';
        }
    }
endif;

if ( ! function_exists( 'iceberg_basic_layout_sanitize' ) ) :
    /**
    * Sanitization callback for basic layout select.
    *
    * @since Iceberg 1.0
    */
    function iceberg_basic_layout_sanitize( $value ) {
        $layouts = array( 'sidebar-left', 'sidebar-right' );

        if ( in_array( $value, $layouts ) )
            return $value;

        return 'sidebar-left';
    }
endif;

if ( ! function_exists( 'iceberg_email_sanitize' ) ) :
    /**
    * Sanitization callback for email field.
    *
    * @since Iceberg 1.0
    * @return string|null Verified email adress or null.
    */
    function iceberg_email_sanitize( $value ) {
        return ( is_email( $value ) ) ? $value : '';
    }
endif;
?>