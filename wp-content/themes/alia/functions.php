<?php

$themename = "Alia";
define('theme_name', $themename);

$social_networks = array("facebook-square" => "Facebook", "twitter" => "Twitter", "google-plus" =>  "Google Plus", "behance" => "Behance", "dribbble" => "Dribbble", "linkedin" => "Linked In", "youtube" => "Youtube", 'vimeo-square' => 'Vimeo', "vk" => "VK", "vine" => "Vine", "digg" => "Digg", "skype" => "Skype", "instagram" => "Instagram", "pinterest" => "Pinterest", "github" => "Github", "bitbucket" => "Bitbucket", "stack-overflow" => "Stack Overflow", "renren" => "Ren Ren", "flickr" => "Flickr", "soundcloud" => "Soundcloud", "steam" => "Steam", "qq" => "QQ", "slideshare" => "Slideshare", 'discord' => 'Discord', 'telegram' => 'Telegram', 'medium-m' => 'Medium');
add_filter('show_admin_bar', '__return_false');



/* --------
 * Sets up theme defaults and registers support for various WordPress features.
------------------------------------------- */
function alia_setup() {

	global $wp_version;

	load_theme_textdomain( 'alia', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	/* --------
add gutenberg image alignment
------------------------------------------- */
add_theme_support( 'align-wide' );


	global $wp_version;
	if ( version_compare( $wp_version, '3.4', '>=' ) ) :
		add_theme_support( 'custom-background' );
	endif;

	$custom_header_args = array(
		'width'        => 1400,
		'height'        => 280,
		'flex-width'    => true,
		'flex-height'    => true,
		'uploads'       => true,
		'wp-head-callback' => 'alia_custom_header_callback',
	);


	if ( version_compare( $wp_version, '3.4', '>=' ) ) :
		add_theme_support( 'custom-header', $custom_header_args );
	endif;

	add_theme_support( 'custom-header', $custom_header_args );

	function asalah_set_image_sizes_desktops($size_name, $width, $height, $crop) {
		$ratio = $height / $width;
		if (alia_option('asalah_banners_devices_size')) {
				add_image_size( $size_name, $width, $height, $crop);
				if ($size_name == 'alia_full_banner' || $size_name == 'alia_wide_banner') {
					add_image_size( $size_name . '_sidebar', 580, (580 * $ratio), $crop);
				} else {
					add_image_size( $size_name . '_large', 885, (885 * $ratio), $crop);
				}
				add_image_size( $size_name . '_tablet', 768, (768 * $ratio), $crop);
				add_image_size( $size_name . '_lmobile', 500, (500 * $ratio), $crop);
				add_image_size( $size_name . '_smobile', 345, (345 * $ratio), $crop);
		} else {
			add_image_size( $size_name, $width, $height, $crop);
		}
	}

	if (alia_option('asalah_banners_devices_size')) {
		function asalah_content_image_sizes_attr($sizes, $size) {
	    $width = $size[0];

			$sizes = '(min-width: 910px)  '. $width .'px, calc(100vw - 30px)';

			return $sizes;
		}
		add_filter('wp_calculate_image_sizes', 'asalah_content_image_sizes_attr', 10 , 2);

		// define the max_srcset_image_width callback
		function asalah_max_srcset_image_width( $int, $size_array ) {
			$width = $size_array[0];
				if ($width >= 880) {
					return 880;
				}  else {
					return $int;
				}
		};
		// add the filter
		add_filter( 'max_srcset_image_width', 'asalah_max_srcset_image_width', 10, 2 );
	}

	asalah_set_image_sizes_desktops( 'alia_full_banner', 880, 400, false );
	asalah_set_image_sizes_desktops( 'alia_wide_banner', 880, 400, true );
	asalah_set_image_sizes_desktops( 'alia_grid_banner', 420, 230, true );
	asalah_set_image_sizes_desktops( 'alia_grid_banner_uncrop', 420, 230, false );
	if (alia_option('asalah_banners_devices_size')) {
		asalah_set_image_sizes_desktops( 'alia_grid_banner_3col', 275, 152, true );
		asalah_set_image_sizes_desktops( 'alia_grid_banner_3col_uncrop', 275, 152, false );
	}
	add_image_size( 'alia_large_thumbnail', 415, 415, true );
	add_image_size( 'alia_wide_thumbnail', 420, 214, true );
	add_image_size( 'alia_thumbnail_avatar', 100, 100, true );

	// image optimization for better image quality
	if (alia_option('asalah_image_optimization')) {
		function asalah_sharpen_resized_files( $resized_file ) {

		    $size = @getimagesize( $resized_file );
		    if ( !$size )
		        return new WP_Error('invalid_image', __('Could not read image size', 'alia'), $file);
		    list($orig_w, $orig_h, $orig_type) = $size;

		    switch ( $orig_type ) {
		        case IMAGETYPE_JPEG:
		        	$image = imagecreatefromjpeg( $resized_file );
				    if ( !is_resource( $image ) )
				        return new WP_Error( 'error_loading_image', $image, $file );
		            $matrix = array(
		                array(-1, -1, -1),
		                array(-1, 16, -1),
		                array(-1, -1, -1),
		            );

		            $divisor = array_sum(array_map('array_sum', $matrix));
		            $offset = 0;
		            imageconvolution($image, $matrix, $divisor, $offset);
		            imagejpeg($image, $resized_file,apply_filters( 'jpeg_quality', 100, 'edit_image' ));
		            break;
		        case IMAGETYPE_PNG:
		            return $resized_file;
		        case IMAGETYPE_GIF:
		            return $resized_file;
		    }

		    return $resized_file;
		}

		add_filter('image_make_intermediate_size', 'asalah_sharpen_resized_files',900);
	}
	// Set the default content width.
	$GLOBALS['content_width'] = 880;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => esc_attr__( 'Top Menu', 'alia' ),
	) );

	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'post-formats', array(
		'image',
		'video',
		'gallery',
		'audio',
		'status',
		'aside'
	) );


	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// add editor style
	add_editor_style( array( 'assets/css/editor-style.css', alia_custom_fonts_url(), 'assets/css/customstyle.css' ) );
}
add_action( 'after_setup_theme', 'alia_setup' );


/* --------
start TGM activating plugins
------------------------------------------- */
if ( ! function_exists( 'alia_register_required_plugins' ) ) :
function alia_register_required_plugins() {

    $plugins = array(
        array(
            'name' => esc_attr__('Alia Core', 'alia'), // The plugin name
            'slug' => 'alia-core', // The plugin slug (typically the folder name)
            'source' => esc_url('https://ahmad.works/alia/plugins/alia-core-1-17.zip'), // The plugin source
            'required' => true, // If false, the plugin is only 'recommended' instead of required
            'version' => '1.17', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
						'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url' => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name' => esc_attr__('Alia AMP', 'alia'), // The plugin name
            'slug' => 'amp', // The plugin slug (typically the folder name)
            'required' => false, // If false, the plugin is only 'recommended' instead of required
            'version' => '1.0.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'source' => esc_url('https://ahmad.works/alia/plugins/alia-amp.zip'), // If set, overrides default API URL and points to an external URL
        ),
        // Envato Market to the installation progress (required)
        array(
            'name' => esc_attr__('Envato Market', 'alia'), // The plugin name
            'slug' => 'envato-market', // The plugin slug (typically the folder name)
            'source' => esc_url('https://ahmad.works/alia/plugins/envato-market.zip'), // The plugin source
            'required' => true, // If false, the plugin is only 'recommended' instead of required
            'version' => '2.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name' => esc_attr__('One Click Demo Import', 'alia'),
            'slug' => 'one-click-demo-import',
            'required' => false,
						'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
        ),
        array(
            'name' => esc_attr__('Contact Form 7', 'alia'),
            'slug' => 'contact-form-7',
            'required' => false,
						'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
        ),
        array(
            'name' => esc_attr__('MailChimp for WordPress', 'alia'),
            'slug' => 'mailchimp-for-wp',
            'required' => false,
						'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
        ),

    );


    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                    // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_attr__( 'Install Required Plugins', 'alia' ),
            'menu_title'                      => esc_attr__( 'Install Plugins', 'alia' ),
            'installing'                      => esc_attr__( 'Installing Plugin: %s', 'alia' ), // %s = plugin name.
            'oops'                            => esc_attr__( 'Something went wrong with the plugin API.', 'alia' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'alia' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'alia' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'alia' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'alia' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'alia' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'alia' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'alia' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'alia' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'alia' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'alia' ),
            'return'                          => esc_attr__( 'Return to Required Plugins Installer', 'alia' ),
            'plugin_activated'                => esc_attr__( 'Plugin activated successfully.', 'alia' ),
            'complete'                        => esc_attr__( 'All plugins installed and activated successfully. %s', 'alia' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );
}
endif;
add_action('tgmpa_register', 'alia_register_required_plugins');

/* --------
end TGM activating plugins
------------------------------------------- */


/* --------
 * Add custom header css.
------------------------------------------- */
if ( ! function_exists( 'alia_custom_header_callback' ) ) :
function alia_custom_header_callback() {
	$header_text_color = get_header_textcolor();
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}
	?>
	<style id="alia-custom-header-styles">
	<?php if ( 'blank' != $header_text_color ) : ?>
		.header_tagline {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
		.social_icons_list.header_social_icons .social_icon {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;

/* --------
 * Remove hentry from post_class
------------------------------------------- */
function alia_remove_hentry( $classes ) {

	// remove hentry from all body classes, this will remove it even if you add it to body_class() function

    // check if hentry_added class exist then don't remove the hentry
    if (!in_array("customhentry", $classes)) {
        $classes = array_diff( $classes, array( 'hentry' ) );
    }
	return $classes;


}
add_filter( 'post_class','alia_remove_hentry' );


/* --------
 * Register widget area.
------------------------------------------- */
function alia_widgets_init() {
	register_sidebar(array(
	    'name' => esc_attr__('Default sidebar', 'alia'),
	    'id' => 'sidebar-1',
	    'description' => esc_attr__('This is the default sidebar in your blog, add widgets here and it will appear on all pages have this sidebar.'  , 'alia'),
	    'before_widget' => '<div id="%1$s" class="widget_container widget_content widget %2$s clearfix">',
	    'after_widget' => "</div>",
	    'before_title' => '<h4 class="widget_title title"><span class="page_header_title">',
	    'after_title' => '</span></h4>',
	));

	register_sidebar(array(
	    'name' => esc_attr__('Intro Sidebar', 'alia'),
	    'id' => 'sidebar-intro',
	    'description' => esc_attr__('This is intro sidebar, all content in this sidebar will appear in your homepage before blog posts.'  , 'alia'),
	    'before_widget' => '<div id="%1$s" class="widget_container widget_content intro_widget_content widget %2$s clearfix">',
	    'after_widget' => "</div>",
	    'before_title' => '<h4 class="widget_title title"><span class="page_header_title">',
	    'after_title' => '</span></h4>',
	));

	register_sidebar(array(
	    'name' => esc_attr__('Sliding Sidebar', 'alia'),
	    'id' => 'sidebar-sliding',
	    'description' => esc_attr__('This is the sliding sidebar, all the contents in this sidebar will appear in the sliding section activated by the triple bar hamburger icon in the main menu.'  , 'alia'),
	    'before_widget' => '<div id="%1$s" class="widget_container widget_content widget %2$s clearfix">',
	    'after_widget' => "</div>",
	    'before_title' => '<h4 class="widget_title title"><span class="page_header_title">',
	    'after_title' => '</span></h4>',
	));

	register_sidebar(array(
	    'name' => esc_attr__('Footer Sidebar 1', 'alia'),
	    'id' => 'footer-1',
	    'before_widget' => '<div id="%1$s" class="widget_container widget_content widget %2$s clearfix">',
	    'after_widget' => "</div>",
	    'before_title' => '<h4 class="widget_title title"><span class="page_header_title">',
	    'after_title' => '</span></h4>',
	));

	register_sidebar(array(
	    'name' => esc_attr__('Footer Sidebar 2', 'alia'),
	    'id' => 'footer-2',
	    'before_widget' => '<div id="%1$s" class="widget_container widget_content widget %2$s clearfix">',
	    'after_widget' => "</div>",
	    'before_title' => '<h4 class="widget_title title"><span class="page_header_title">',
	    'after_title' => '</span></h4>',
	));

	register_sidebar(array(
	    'name' => esc_attr__('Footer Sidebar 3', 'alia'),
	    'id' => 'footer-3',
	    'before_widget' => '<div id="%1$s" class="widget_container widget_content widget %2$s clearfix">',
	    'after_widget' => "</div>",
	    'before_title' => '<h4 class="widget_title title"><span class="page_header_title">',
	    'after_title' => '</span></h4>',
	));

}
add_action( 'widgets_init', 'alia_widgets_init' );

/* --------
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
------------------------------------------- */
function alia_excerpt_more( $link ) {

	return '&hellip;';
}
add_filter( 'excerpt_more', 'alia_excerpt_more' );

if ( ! function_exists( 'alia_excerpt' ) ) :
function alia_excerpt($limit = 80) {

	$excerpt_text = ' &hellip; ';

	$content = get_the_excerpt();
	//check if its chinese character input
	$chinese_output = preg_match_all("/\p{Han}+/u", $content, $matches);
	if($chinese_output) {
		$content = mb_substr( $content, 0, ($limit * 4) ) . '&hellip;';
	}
	return wp_trim_words($content, $limit, $excerpt_text);
}
endif;

/* --------
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
------------------------------------------- */
function alia_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'alia_javascript_detection', 0 );

/* --------
 * Add a pingback url auto-discovery header for singularly identifiable articles.
------------------------------------------- */
function alia_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'alia_pingback_header' );


/* --------
 * Enqueue scripts and styles.
------------------------------------------- */
function alia_scripts() {

	// Theme stylesheet.
	wp_enqueue_style( 'alia-style', get_stylesheet_uri(), array(), '1.43' );
	if ( is_rtl() ) {
		wp_style_add_data( 'alia-style', 'rtl', 'replace' );
	}

	wp_enqueue_style( 'fontawesome', get_theme_file_uri('/inc/frameworks/fontawesome/css/all.min.css'), array(), '1.0' );


	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'alia-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'alia-style' ), '1.0' );
		wp_style_add_data( 'alia-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'alia-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'alia-style' ), '1.0' );
	wp_style_add_data( 'alia-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'alia-global-script', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.43	', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// define js vars
	$alia_variables_array = array(
	    'ajax_accept_cookies' => get_theme_file_uri( '/acceptcookies.php', __FILE__ ),
	);

	wp_localize_script( 'alia-global-script', 'alia_vars', $alia_variables_array );

}
add_action( 'wp_enqueue_scripts', 'alia_scripts' );

/* --------
 * Add Facebook SDK
------------------------------------------- */
if ( ! function_exists( 'alia_fbsdk_head' ) ) :
function alia_fbsdk_head() {
	if (alia_option('alia_fb_sdk', 1)) {
		?>
		 <!-- Load facebook SDK -->
		 <script>
			(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) { return; }
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/<?php echo get_locale(); ?>/sdk.js#xfbml=1&version=v2.11";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		 </script>
		 <!-- End Load facebook SDK -->
		<?php
	}
}
endif;


add_action( 'wp_head', 'alia_fbsdk_head' );


/* --------
 * Custom fonts collection.
------------------------------------------- */
if ( ! function_exists( 'alia_custom_fonts_collection' ) ) :
function alia_custom_fonts_collection() {
	$alia_custom_fonts_array = array(
		'roboto' => array(
			'name' => "Roboto",
			'family' => "400,400i,700,700i",
			'css' => "'Roboto', sans-serif"
		),
		'lato' => array(
			'name' => "Lato",
			'family' => "400,400i,700,700i",
			'css' => "'Lato', sans-serif"
		),
		'ptsans' => array(
			'name' => "PT Sans",
			'family' => "400,400i,700,700i",
			'css' => "'PT Sans', sans-serif"
		),
		'worksans' => array(
			'name' => "Work Sans",
			'family' => "400,700",
			'css' => "'Work Sans', sans-serif"
		),
		'opensans' => array(
			'name' => "Open Sans",
			'family' => "400,400i,700,700i",
			'css' => "'Open Sans', sans-serif"
		),
		'sourcesanspro' => array(
			'name' => "Source Sans Pro",
			'family' => "400,400i,700,700i",
			'css' => "'Source Sans Pro', sans-serif"
		),
		'poppins' => array(
			'name' => "Poppins",
			'family' => "400,400i,700,700i",
			'css' => "'Poppins', sans-serif"
		),
		'robotoslab' => array(
			'name' => "Roboto Slab",
			'family' => "100,300,400,700",
			'css' => "'Roboto Slab', serif"
		),
		'notosans' => array(
			'name' => "Noto Sans",
			'family' => "400,400i,700,700i",
			'css' => "'Noto Sans', sans-serif"
		),
		'ubuntu' => array(
			'name' => "Ubuntu",
			'family' => "400,400i,700,700i",
			'css' => "'Ubuntu', sans-serif"
		),
		'ibmplexsans' => array(
			'name' => "IBM Plex Sans",
			'family' => "400,400i,700,700i",
			'css' => "'IBM Plex Sans', sans-serif"
		),
		'lora' => array(
			'name' => "Lora",
			'family' => "400,400i,700,700i",
			'css' => "'Lora', serif"
		),
		'ptserif' => array(
			'name' => "PT Serif",
			'family' => "400,400i,700,700i",
			'css' => "'PT Serif', serif"
		),
		'arvo' => array(
			'name' => "Arvo",
			'family' => "400,400i,700,700i",
			'css' => "'Arvo', serif"
		),
		'sourceserifpro' => array(
			'name' => "Source Serif Pro",
			'family' => "400,700",
			'css' => "'Source Serif Pro', serif"
		),
		'kameron' => array(
			'name' => "Kameron",
			'family' => "400,700",
			'css' => "'Kameron', serif"
		),
		'merriweather' => array(
			'name' => "Merriweather",
			'family' => "400,700",
			'css' => "'Merriweather', serif"
		),
		'notoserif' => array(
			'name' => "Noto Serif",
			'family' => "400,400i,700,700i",
			'css' => "'Noto Serif', serif"
		),
	);

	return $alia_custom_fonts_array;
}
endif;

/* --------
 * Register custom fonts.
------------------------------------------- */
function alia_custom_fonts_url() {

	$fonts_url = '';

	$alia_custom_fonts_array = alia_custom_fonts_collection();

	$font_families = array();

	if ( alia_option('alia_main_font', 'roboto') && alia_option('alia_main_font', 'roboto') != 'default' && alia_option('alia_main_font', 'roboto') != 'system' ) {
		$main_font_id = alia_option('alia_main_font', 'roboto');
		$main_custom_font = $alia_custom_fonts_array[$main_font_id];
		$font_families[] = $main_custom_font['name'] . ':' . $main_custom_font['family'];
	}

	if ( alia_option('alia_title_font', 'poppins') && alia_option('alia_title_font', 'poppins') != 'default' && alia_option('alia_title_font', 'poppins') != 'system' ) {
		$title_font_id = alia_option('alia_title_font', 'poppins');
		$title_custom_font = $alia_custom_fonts_array[$title_font_id];
		$font_families[] = $title_custom_font['name'] . ':' . $title_custom_font['family'];
	}


	if (!empty($font_families)) {
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}


	return esc_url_raw( $fonts_url );
}

/* --------
 * add custom css.
------------------------------------------- */
if ( ! function_exists( 'alia_custom_css' ) ) :
function alia_custom_css() {

	$main_font_css = '';
	$title_font_css = '';
	$alia_custom_fonts_array = alia_custom_fonts_collection();

	if ( alia_option('alia_main_font', 'roboto') && alia_option('alia_main_font', 'roboto') != 'default') {
		if (alia_option('alia_main_font', 'roboto') == 'system') {
			$main_font_css = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';

		}else{
			$main_font_id = alia_option('alia_main_font', 'roboto');
			$main_custom_font = $alia_custom_fonts_array[$main_font_id];
			$main_font_css = $main_custom_font['css'];
		}
	}

	if ( alia_option('alia_title_font', 'poppins') && alia_option('alia_title_font', 'poppins') != 'default') {
		if (alia_option('alia_title_font', 'poppins') == 'system') {
			$title_font_css = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
		}else{
			$title_font_id = alia_option('alia_title_font', 'poppins');
			$title_custom_font = $alia_custom_fonts_array[$title_font_id];
			$title_font_css = $title_custom_font['css'];
		}

	}

	if (alia_option('alia_load_fonts_locally') == true) {
		// Load Google Fonts locally
		if ((alia_option('alia_main_font', 'roboto') == 'roboto') && (alia_option('alia_title_font', 'poppins') == 'poppins')) {
			wp_enqueue_style( 'alia-fonts', get_theme_file_uri('/assets/fonts/default-google-fonts.css'), array(), null );
		} else {
			if ( alia_option('alia_main_font', 'roboto') && alia_option('alia_main_font', 'roboto') != 'default' && alia_option('alia_main_font', 'roboto') != 'system' ) {
				wp_enqueue_style( 'alia-font-main', get_theme_file_uri('/assets/fonts/'.alia_option('alia_main_font', 'roboto').'.css'), array(), null );
			}

			if ( alia_option('alia_title_font', 'poppins') && alia_option('alia_title_font', 'poppins') != 'default' && alia_option('alia_title_font', 'poppins') != 'system' ) {
				wp_enqueue_style( 'alia-font-titles', get_theme_file_uri('/assets/fonts/'.alia_option('alia_title_font', 'poppins').'.css'), array(), null );
			}
		}
	} else {
		// Add custom fonts URL
		wp_enqueue_style( 'alia-fonts', alia_custom_fonts_url(), array(), null );
	}

	// Add custom fonts to style
    wp_enqueue_style(
        'alia-customstyle', get_theme_file_uri('/assets/css/customstyle.css')
    );

    $custom_css = "";

    if ($main_font_css) {
    	$custom_css .= "body { font-family: {$main_font_css}; }";
    }

    if ($title_font_css) {
    	$custom_css .= "h1, h2, h3, h4, h5, h6, .title, .text_logo, .comment-reply-title, .header_square_logo a.square_letter_logo { font-family: {$title_font_css}; }";
    }

    $main_color = "";
    if (alia_option('alia_main_color', '#ff374a')) {

    	$main_color = alia_option('alia_main_color', '#ff374a');

    	$custom_css .= "a { color: {$main_color}; }";

    	$custom_css .= "input[type='submit']:hover { background-color: {$main_color}; }";

    	$custom_css .= ".main_color_bg { background-color: {$main_color}; }";

    	$custom_css .= ".main_color_text { color: {$main_color}; }";

    	$custom_css .= ".social_icons_list.header_social_icons .social_icon:hover { color: {$main_color}; }";

    	$custom_css .= ".header_square_logo a.square_letter_logo { background-color: {$main_color}; }";

    	$custom_css .= ".header_nav .text_logo a span.logo_dot { background-color: {$main_color}; }";

    	$custom_css .= ".header_nav .main_menu .menu_mark_circle { background-color: {$main_color}; }";

    	$custom_css .= ".full_width_list .post_title a:hover:before { background-color: {$main_color}; }";

    	if ( is_rtl() ) {

	    	$custom_css .= ".full_width_list .post_title a:hover:after { background: linear-gradient(to left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%);
	  background: -ms-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -o-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%); background: -moz-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-gradient(linear,right top,left top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,#FFF));; }";

	 		$custom_css .= ".grid_list .post_title a:hover:before { background-color: {$main_color}; }";

	 		$custom_css .= ".grid_list .post_title a:hover:after { background: linear-gradient(to left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%);
	  background: -ms-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -o-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%); background: -moz-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-gradient(linear,right top,left top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,#FFF));; }";

			$custom_css .= ".two_coloumns_list .post_title a:hover:before { background-color: {$main_color}; }";

			$custom_css .= ".two_coloumns_list .post_title a:hover:after { background: linear-gradient(to left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%);
	 background: -ms-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -o-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%); background: -moz-linear-gradient(right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-gradient(linear,right top,left top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,#FFF));; }";
 		}else{
 			$custom_css .= ".full_width_list .post_title a:hover:after { background: linear-gradient(to right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%);
	  background: -ms-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -o-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%); background: -moz-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-gradient(linear,left top,right top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,#FFF));; }";

	 		$custom_css .= ".grid_list .post_title a:hover:before { background-color: {$main_color}; }";

	 		$custom_css .= ".grid_list .post_title a:hover:after { background: linear-gradient(to right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%);
	  background: -ms-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -o-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%); background: -moz-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-gradient(linear,left top,right top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,#FFF));; }";

			$custom_css .= ".two_coloumns_list .post_title a:hover:before { background-color: {$main_color}; }";

			$custom_css .= ".two_coloumns_list .post_title a:hover:after { background: linear-gradient(to right,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%);
	 background: -ms-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -o-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#FFF 100%); background: -moz-linear-gradient(left,{$main_color} 0,{$main_color} 35%,{$main_color} 65%,#fff 100%); background: -webkit-gradient(linear,left top,right top,color-stop(0%,{$main_color}),color-stop(35%,{$main_color}),color-stop(65%,{$main_color}),color-stop(100%,#FFF));; }";
 		}
 		$custom_css .= ".post_meta_container a:hover { color: {$main_color}; }";

 		$custom_css .= ".post.sticky .blog_meta_item.sticky_post { color: {$main_color}; }";

 		$custom_css .= ".blog_post_readmore a:hover .continue_reading_dots .continue_reading_squares > span { background-color: {$main_color}; }";

 		$custom_css .= ".blog_post_readmore a:hover .continue_reading_dots .readmore_icon { color: {$main_color}; }";

 		$custom_css .= ".comment-list .reply a:hover { color: {$main_color}; }";

 		$custom_css .= ".comment-list .reply a:hover .comments_reply_icon { color: {$main_color}; }";

 		$custom_css .= "form.comment-form .form-submit input:hover { background-color: {$main_color}; }";

 		if ( is_rtl() ) {
 			$custom_css .= ".comment-list .comment.bypostauthor .comment-content:before { border-top-color: {$main_color}; border-right-color: {$main_color}; }";
 		}else{
 			$custom_css .= ".comment-list .comment.bypostauthor .comment-content:before { border-top-color: {$main_color}; border-left-color: {$main_color}; }";
 		}

 		$custom_css .= ".comments-area a:hover { color: {$main_color}; }";

 		$custom_css .= ".newsletter_susbcripe_form label .asterisk { color: {$main_color}; }";

 		$custom_css .= ".newsletter_susbcripe_form .mce_inline_error { color: {$main_color}!important; }";

 		$custom_css .= ".newsletter_susbcripe_form input[type='submit']:hover { background-color: {$main_color}; }";
 		$custom_css .= ".widget_content #mc_embed_signup input[type='submit']:hover { background-color: {$main_color}; }";

 		$custom_css .= ".social_icons_list .social_icon:hover { color: {$main_color}; }";

 		$custom_css .= ".alia_post_list_widget .post_info_wrapper .title a:hover { color: {$main_color}; }";

 		$custom_css .= ".tagcloud a:hover { color: {$main_color}; }";

 		$custom_css .= ".navigation.pagination .nav-links .page-numbers.current { background-color: {$main_color}; }";

 		$custom_css .= ".navigation_links a:hover { background-color: {$main_color}; }";

 		$custom_css .= ".page-links > a:hover, .page-links > span { background-color: {$main_color}; }";

 		$custom_css .= ".story_circle:hover { border-color: {$main_color}; }";

 		$custom_css .= ".see_more_circle:hover { border-color: {$main_color}; }";

 		$custom_css .= ".main_content_area.not-found .search-form .search_submit { background-color: {$main_color}; }";

 		$custom_css .= ".blog_list_share_container .social_share_item_wrapper a.share_item:hover { color: {$main_color}; }";

 		$custom_css .= ".widget_content ul li a:hover { color: {$main_color}; }";

 		$custom_css .= ".footer_widgets_container .social_icons_list .social_icon:hover { color: {$main_color}; }";

 		$custom_css .= ".footer_widgets_container .widget_content ul li a:hover { color: {$main_color}; }";

 		$custom_css .= ".cookies_accept_button { background-color: {$main_color}; }";

 		$custom_css .= ".alia_gototop_button > i { background-color: {$main_color}; }";

    }


    wp_add_inline_style( 'alia-customstyle', $custom_css );

}
endif;
add_action( 'wp_enqueue_scripts', 'alia_custom_css', 55 );
if (!function_exists('alia_editor_custom_font_loader')) {
	function alia_editor_custom_font_loader() {
		$main_font_css = '';
		$title_font_css = '';
		$alia_custom_fonts_array = alia_custom_fonts_collection();

		if ( alia_option('alia_main_font', 'roboto') && alia_option('alia_main_font', 'roboto') != 'default') {
			if (alia_option('alia_main_font', 'roboto') == 'system') {
				$main_font_css = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';

			}else{
				$main_font_id = alia_option('alia_main_font', 'roboto');
				$main_custom_font = $alia_custom_fonts_array[$main_font_id];
				$main_font_css = $main_custom_font['css'];
			}
		}

		if ( alia_option('alia_title_font', 'poppins') && alia_option('alia_title_font', 'poppins') != 'default') {
			if (alia_option('alia_title_font', 'poppins') == 'system') {
				$title_font_css = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
			}else{
				$title_font_id = alia_option('alia_title_font', 'poppins');
				$title_custom_font = $alia_custom_fonts_array[$title_font_id];
				$title_font_css = $title_custom_font['css'];
			}

		}

		if (alia_option('alia_load_fonts_locally') == true) {
			// Load Google Fonts locally
			if ((alia_option('alia_main_font', 'roboto') == 'roboto') && (alia_option('alia_title_font', 'poppins') == 'poppins')) {
				wp_enqueue_style( 'alia-fonts', get_theme_file_uri('/assets/fonts/default-google-fonts.css'), array(), null );
			} else {
				if ( alia_option('alia_main_font', 'roboto') && alia_option('alia_main_font', 'roboto') != 'default' && alia_option('alia_main_font', 'roboto') != 'system' ) {
					wp_enqueue_style( 'alia-font-main', get_theme_file_uri('/assets/fonts/'.alia_option('alia_main_font', 'roboto').'.css'), array(), null );
				}

				if ( alia_option('alia_title_font', 'poppins') && alia_option('alia_title_font', 'poppins') != 'default' && alia_option('alia_title_font', 'poppins') != 'system' ) {
					wp_enqueue_style( 'alia-font-titles', get_theme_file_uri('/assets/fonts/'.alia_option('alia_title_font', 'poppins').'.css'), array(), null );
				}
			}
		} else {
			// Add custom fonts URL
			wp_enqueue_style( 'alia-fonts', alia_custom_fonts_url(), array(), null );
		}
	}
}
add_action( 'enqueue_block_editor_assets', 'alia_editor_custom_font_loader', 55 );


/* --------
 * Customize OEmbed output.
------------------------------------------- */
if ( ! function_exists( 'alia_custom_embed_oembed_html' ) ) :
function alia_custom_embed_oembed_html($html, $url, $attr, $post_id) {

  $host = wp_parse_url($url, PHP_URL_HOST);

	$html = '<!--ALIA start embed content-->'.$html.'<!--AliA end embed content-->';

  if (strpos($host, 'twitter.com') !== false) {
      $html = '<div class="twitter_widget_wrapper alia_embed_wrapper"><div class="twitter_widget_border">' . $html . '</div></div>';
  }

  if (strpos($host, 'youtu.be') !== false || strpos($host, 'youtube.com') !== false) {
      $html = '<div class="youtube_embed_wrapper alia_embed_wrapper">' . $html . '</div>';
  }

  if (strpos($host, 'fb.com') !== false || strpos($host, 'facebook.com') !== false) {
      $html = '<div class="facebook_embed_wrapper alia_embed_wrapper">' . $html . '</div>';
  }

  if (strpos($host, 'instagram.com') !== false) {
      $html = '<div class="instagram_embed_wrapper alia_embed_wrapper">' . $html . '</div>';
  }

  if (strpos($host, 'vimeo.com') !== false) {
      $html = '<div class="vimeo_embed_wrapper alia_embed_wrapper">' . $html . '</div>';
  }

  if (strpos($host, 'soundcloud.com') !== false) {
      $html = '<div class="soundcloud_embed_wrapper alia_embed_wrapper">' . $html . '</div>';
  }

  if (strpos($host, 'flickr.com') !== false) {
      $html = '<div class="flickr_embed_wrapper alia_embed_wrapper">' . $html . '</div>';
  }

  if (strpos($host, 'gettyimages.com') !== false) {
      $html = '<div class="gettyimages_embed_wrapper alia_embed_wrapper">' . $html . '</div>';
  }

  return $html;
}
endif;

add_filter('embed_oembed_html', 'alia_custom_embed_oembed_html', 99, 4);

/* --------
set body classes
------------------------------------------- */
if ( ! function_exists( 'alia_body_class' ) ) :
function alia_body_class($classes) {

	if (alia_cross_option('alia_enable_sticky_header', '', 0)) {
		$classes[] = 'sticky_header';
	}

	if (alia_option('alia_sticky_footer_content', '0')) {
		$classes[] = 'has_static_footer';
	}

	if (alia_option('alia_disable_images_rounded_corners', 0)) {
		$classes[] = 'image_no_rounded_corners';
	}

	if (alia_option('alia_round_logo_image', 0)) {
		$classes[] = 'header_logo_rounded';
	}

	if ( alia_cross_option('alia_blog_show_all_content', '', 0) || !alia_cross_option('alia_border_text_posts', '', 0) ) {
		$classes[] = 'text_posts_unbordered';
	}else{
		$classes[] = 'text_posts_bordered';
	}

	if (!alia_cross_option('alia_show_header_site_title', '', 1)) {
		$classes[] = 'no_sitetitle_in_menu';
	}

	if (alia_cross_option('alia_show_fullwidth_text', '', 0)) {
		$classes[] = 'pages_wide_text_content';
	}

	if (alia_option('alia_enable_masonry', 1)) {
		$classes[] = 'masonry_effect_enabled';
	}

	if (alia_option('alia_menu_circle_idicator', 1)) {
		$classes[] = 'show_menu_circle_idicator';
	}else{
		$classes[] = 'hide_menu_circle_idicator';
	}

	if(get_custom_header() && get_header_image()) {
		$classes[] = 'has_header_image';
		// $classes[] = 'has_site_width_max';
	}

	if ( !is_active_sidebar( 'sidebar-sliding' ) ) {
		$classes[] = 'sliding_sidebar_inactive';
	}

    return $classes;
}
endif;

	add_filter( 'body_class', 'alia_body_class' );



/* --------
* options getters functions
------------------------------------------- */
if ( ! function_exists( 'alia_option' ) ) :
function alia_option($id, $default = false) {
    if (!$id) {
    	return;
    }

    return get_theme_mod($id, $default);
}
endif;

if ( !function_exists( 'alia_post_option' ) ) :
function alia_post_option($id, $postid = '') {
    global $post;

    if ($post && $postid == '') {
        $post_id = $post->ID;
    } else {
        $post_id = $postid;
    }
    $post_meta = get_post_meta($post_id, $id, true);
    if (isset($post_meta)) {
        return $post_meta;
    }
}
endif;

if ( ! function_exists( 'alia_cross_option' ) ) :
function alia_cross_option($id, $postid = '', $default = false) {
    global $post;

    if ($post && $postid == '') {
        $post_id = $post->ID;
    } else {
        $post_id = $postid;
    }

    if (alia_option($id, $default) && !alia_post_option($id, $post_id)) {
        $output = alia_option($id, $default);
    }elseif(alia_post_option($id, $post_id)) {
        $output = alia_post_option($id, $post_id);
    }else{
    	$output = null;
    }
    return $output;
}
endif;

if ( ! function_exists( 'alia_pagination' ) ) :
function alia_pagination($id = '') {
    global $post;
    global $paged;
    if ($post && $id == '') {
        $id = $post->ID;
    }

    $next_arrow = '<i class="fa fa-angle-right"></i>';
    $prev_arrow = '<i class="fa fa-angle-left"></i>';

    if ( is_rtl() ) {
    	$next_arrow = '<i class="fa fa-angle-left"></i>';
    	$prev_arrow = '<i class="fa fa-angle-right"></i>';
    }
    if (alia_cross_option('alia_pagination_style', $id, 'num') == 'num') {
		the_posts_pagination( array(
			'mid_size' => 2,
			'prev_text'          => $prev_arrow,
			'next_text'          => $next_arrow,
			'before_page_number' => '',
		) );
    }else{
    	if (get_next_posts_link() || get_next_posts_link()) {
    		echo '<div class="next_prev_nav pagination">';
		    	if ( get_next_posts_link() ):
					echo '<div class="navigation_links navigation_next">';
					next_posts_link(__('Older Posts', 'alia'));
					echo '</div>';
				endif;

				if ( get_previous_posts_link() ):
					echo '<div class="navigation_links navigation_prev">';
					previous_posts_link(__('Newer Posts', 'alia'));
					echo '</div>';
				endif;
			echo '</div>';
    	}

    }
}
endif;

/* --------
bootstrap navwalker class
------------------------------------------- */
class wp_bootstrap_navwalker extends Walker_Nav_Menu {
	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		/**
		 * Dividers, Headers or Disabled
	     * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 */
		if (strcasecmp($item->attr_title, 'divider') == 0 && $depth === 1) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if (strcasecmp($item->attr_title, 'dropdown-header') == 0 && $depth === 1) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} else if (strcasecmp($item->attr_title, 'disabled') == 0) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		}
                else {

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

			if($args->has_children && $depth === 0) { $class_names .= ' dropdown'; }
                        elseif($args->has_children && $depth > 0) { $class_names .= ' dropdown-submenu'; }


            /*******************************************************************************/
            /*******************************************************************************/
            /*******************************************************************************/
            /************************ Start alia mega menu options ***********************/
            /*******************************************************************************/
            /*******************************************************************************/
            /*******************************************************************************/
            $check_mega_menu = "";
            if($depth === 0 && $item->megamenu != ''){
                $class_names .= ' mega_menu';
                $class_names .= ' mega_menu_'.$item->megamenu;
            }else{
            	$class_names .= ' default_menu';
            }

            if ($depth === 0 && $item->cols_nums ){
            	$class_names .= ' '.$item->cols_nums;
            }

            if($depth === 1 && $item->menutitle != ''){
                $class_names .= ' menu_title';
                $class_names .= ' menu_title'.$item->menutitle;
            }

            if($depth > 0 && $item->columntype == "text") {
            	$class_names .= ' text_mega_menu';
            }

            /*******************************************************************************/
            /*******************************************************************************/
            /*******************************************************************************/
            /************************  end alia mega menu options  ***********************/
            /*******************************************************************************/
            /*******************************************************************************/
            /*******************************************************************************/

			if(in_array('current-menu-item', $classes)) { $class_names .= ' active'; }

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';
			if($depth > 0 && $item->columntype == "text") {
				$output .= do_shortcode($item->text);;
			}else {
				$atts = array();
				$atts['title']  = '';
	                        /*if(!empty($item->title)):
	                            if(strpos($item->title, 'icon-') === 0):
	                                $atts['title'] = '<i class="' . $item->title . '"></i>';
	                            endif;
	                        else:
	                            $atts['title'] = '';
	                        endif;*/

				$atts['target'] = ! empty( $item->target ) ? $item->target : '';
				$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';

				//If item has_children add atts to a
				if($args->has_children && $depth === 0) {
					/* $atts['href'] = '#'; */
					/* $atts['data-toggle']	= 'dropdown'; */
	                                $atts['href'] = ! empty( $item->url ) ? $item->url : '#';
					$atts['data-hover'] = 'dropdown';
					$atts['class'] = 'dropdown-toggle';
				} else {
					$atts['href'] = ! empty( $item->url ) ? $item->url : '';
				}

				$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

				$attributes = '';
				foreach ( $atts as $attr => $value ) {
	                            if ( ! empty( $value ) ) {
	                                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );

	                                if($value !== 'srp-icon'){
	                                    $attributes .= ' ' . $attr . '="' . $value . '"';
	                                }
	                            }
				}

				$item_output = $args->before;

				/*
				 * Glyphicons
				 * ===========
				 * Since the the menu item is NOT a Divider or Header we check the see
				 * if there is a value in the attr_title property. If the attr_title
				 * property is NOT null we apply it as the class name for the glyphicon.
				 */

				if(! empty( $item->attr_title )){
	                            if( $item->title === 'srp-icon' ){
	                                $item_output .= '<a'. $attributes . '><i class=" ' . esc_attr( $item->attr_title ) . '"></i>';
	                            }
	                            else{
	                                $item_output .= '<a'. $attributes .'><i class=" ' . esc_attr( $item->attr_title ) . '"></i>';
	                            }

				} else {
	                            $item_output .= '<a'. $attributes .'>';
				}

				if (! empty($item->icon)) {
					$item_output .= '<i class=" ' . esc_attr( $item->icon ) . '"></i>';
				}

	            if( $item->title === 'srp-icon' ){
	                $item_output .= $args->link_before . $args->link_after;
	            }
				else{
	                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
	            }

	            //$item_output .= ($args->has_children) ? ' <span class="mobile_menu_arrow"><i class="fa fa-chevron-right"></i></span></a>' : '</a>';
	            $item_output .= '</a>';

	            $item_output .= $args->after;

				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}
	}

	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( !$element ) {
            return;
        }

        $id_field = $this->db_fields['id'];

        //display this element
        if ( is_object( $args[0] ) ) {
           $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}

/* --------
post meta tags
------------------------------------------- */
if ( ! function_exists( 'alia_post_meta' ) ) :
function alia_post_meta($post_position = '') {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		printf( '<span class="blog_meta_item sticky_post">%s</span>', '<i class="fas fa-bookmark"></i>' );
	}

	$format = get_post_format();
	$standard_format_icon = 'fas fa-align-left standardpost_format_icon';

	#if ( current_theme_supports( 'post-formats', $format ) ) {

	switch ($format) {
		case 'audio':
			$format_icon = 'fas fa-headphones-alt';
			break;
		case 'video':
			$format_icon = 'fas fa-film';
			break;
		case 'image':
			$format_icon = 'far fa-image';
			break;
		case 'aside':
			$format_icon = 'far fa-sticky-note';
			break;
		case 'quote':
			$format_icon = 'fa-quote-left';
			break;
		case 'link':
			$format_icon = 'fa-external-link';
			break;
		case 'gallery':
			$format_icon = 'far fa-images';
			break;
		case 'status':
			$format_icon = 'far fa-clipboard';
			break;
		case 'chat':
			$format_icon = 'far fa-sticky-note';
			break;
		default:
			$format_icon = $standard_format_icon;
	}

	if (get_post_format() != '' ) {
		$post_format_link = '<a class="post_format_icon_link" href="'.get_post_format_link( $format ).'"><i class="'.$format_icon.' post_meta_icon '.$format.'post_fromat_icon"></i></a>';
	}else{
		$post_format_link = '<i class="'.$format_icon.' post_meta_icon '.$format.'post_fromat_icon"></i>';
	}


	if (alia_cross_option('alia_show_author_avatar', '', 1) && get_avatar(get_the_author_meta('ID')) ) {
		if ( in_array( get_post_type(), array( 'page', 'post' ) ) ) {
			//if ( is_multi_author() ) {
			printf( '<span class="post_meta_item meta_item_author_avatar"><a class="meta_author_avatar_url" href="%1$s">%2$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_avatar(get_the_author_meta('ID'), 40)
			);
			//}
		}
	}
	#}

	echo '<div class="post_meta_info post_meta_row clearfix">';

	if (alia_cross_option('alia_show_author', '', 1)) {
		if ( in_array( get_post_type(), array( 'page', 'post' ) ) ) {
			//if ( is_multi_author() ) {
				if ($post_position == 'normalhentry') {
					printf( '<span class="post_meta_item meta_item_author"><span class="author vcard author_name"><span class="fn"><a class="meta_author_name url" href="%1$s">%2$s</a></span></span></span>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author()
					);
				}else{
					printf( '<span class="post_meta_item meta_item_author"><span class="author author_name"><span><a class="meta_author_name" href="%1$s">%2$s</a></span></span></span>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author()
					);
				}

			//}
		}
	}

	if (alia_cross_option('alia_show_categories', '', 1) ) {
		$categories_list = get_the_category_list( '<span>'.esc_attr_x( ', ', 'Used between list items, there is a space after the comma.', 'alia' ).'</span>' );

		if ( $categories_list ) {

			printf( '<span class="post_meta_item meta_item_category">%1$s%2$s</span>',
				$post_format_link,
				$categories_list
			);
		}
	}

	if (alia_cross_option('alia_show_date', '', 1)) {
		if ( in_array( get_post_type(), array( 'page', 'post', 'attachment' ) ) ) {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date()
			);

			echo '<a class="post_date_link" href="'.get_permalink().'">';
				printf( '<span class="post_meta_item meta_item_date"><span class="screen-reader-text"></span>%1$s</span>', $time_string );
			echo '</a>';
		}
	}

	echo '</div>';

}
endif;

/* --------
story content overlay
------------------------------------------- */
if ( ! function_exists( 'alia_story_content_overlay' ) ) :
function alia_story_content_overlay($story_post = '') {
	$author_id = $story_post->post_author;
	$output = '';

	if ($story_post) {
		$output .= '<div class="story_black_overlay"></div>';

		$output .= '<div class="story_content">';

			$output .= '<span class="story_item_author_avatar"><a class="meta_author_avatar_url" href="'.esc_url( get_author_posts_url($author_id) ).'">'.get_avatar($author_id, 36).'</a></span>';

			$output .= '<div class="story_meta">';
				$output .= '<span class="story_item_author"><a class="meta_author_name url fn n" href="'.esc_url( get_author_posts_url($author_id) ).'">'.get_the_author_meta('display_name', $author_id).'</a></span>';
				$output .= '<a href="'.get_permalink($story_post).'" class="story_date">'.get_the_date('', $story_post).'</a>';
			$output .= '</div>'; // close story_meta

		$output .= '</div>'; //story_content

	}

	return $output;
}
endif;

/* --------
stories circles
------------------------------------------- */
if (!function_exists('alia_stories_circles')):
function alia_stories_circles($num = 4, $page_url = '', $author_id = 0) {
	global $post;

	if ($page_url != '') {
		$stories_page = $page_url;
	}else{
		$stories_page = alia_option('alia_stories_page_url');
	}

	$args = array('post_type' => 'story', 'orderby' => 'date', 'posts_per_page' => $num);
	if ($author_id != 0) {
		$args['author'] = $author_id;
	}

	$wp_query = new WP_Query($args);

	$output = '';
	if ( $wp_query ) :

		$output .= '<div class="stories_circles_wrapper">';
			while ( $wp_query->have_posts() ) : $wp_query->the_post();
    		$output .= '<span data-postid="'.get_the_ID().'" data-author="'.$author_id.'" class="story_circle story_hotlink">';
    		$output .= get_the_post_thumbnail($post->ID, 'alia_large_thumbnail', array( 'class' => 'img-responsive' ));
    		$output .= '</span>';
			endwhile;

			if ( $wp_query->max_num_pages > 1 && $stories_page != '' && $author_id == 0) {
				$output .= '<span class="see_more_circle">';
					$output .= '<a href="'.$stories_page.'"><i class="fas fa-plus"></i></a>';
				$output .= '</span>';
			}

		$output .= '</div>';

	endif;

	wp_reset_query();
	return $output;
}
endif;

/* --------
author social profiles
------------------------------------------- */
if (!function_exists('alia_author_social_profiles')):
function alia_author_social_profiles($contactmethods) {
	global $social_networks;

    foreach ($social_networks as $network => $social ) {
        $contactmethods[$network] = sprintf(esc_attr__('%s URL', 'alia'), $social);
    }
    return $contactmethods;
}
endif;

/* --------
social networks list
------------------------------------------- */
if ( ! function_exists( 'alia_social_icons_list' ) ) :
function alia_social_icons_list($class = '') {
    global $social_networks;

    $activated = 0;

    $wrapper_class = '';
    if ($class) {
    	$wrapper_class = $class;
    }

    $output = "";
    foreach ($social_networks as $network => $social ) {
        $id = "alia_" . $network . "_url";
        if (alia_option($id, '') != "") {
            $activated++;
            if ($activated == 1) {
                $output .= '<div class="social_icons_list '.$wrapper_class.'">';
            }
            $social_url = alia_option($id, '');

            $output .= '<a rel="nofollow" target="_blank" href="'.esc_url($social_url).'" title="'.$social.'" class="social_icon widget_social_icon social_' . $network . ' social_icon_' . $network . '"><i class="fab fa-' . $network . '"></i></a>';
        }
    }
    if ($activated != "0") {
        $output .= '</div>'; // end social_icons_list in case it's already opened
    }

    if ($output != '') {
        return $output;
    }
}
endif;

/* --------
AJAX hits counter
------------------------------------------- */
if (alia_cross_option('alia_hits_counter')) {
	// Run this code on 'after_theme_setup', when plugins have already been loaded.
	add_action('after_setup_theme', 'alia_hits_counter');
	// This function loads the plugin.
	function alia_hits_counter() {

		if (!class_exists('AJAX_Hits_Counter')) {
			// load Social if not already loaded
			include_once(TEMPLATEPATH.'/inc/ajax-hits-counter/ajax-hits-counter.php');
		}
	}
}

/* --------
get plog posts list
------------------------------------------- */
if ( ! function_exists( 'alia_return_blogposts_list' ) ) :
function alia_return_blogposts_list($num = "3", $thumb = 'thumbnail', $orderby = 'date', $cat = '', $tag_ids = '', $ignore_sticky = false) {
    global $post;

    $args = array('posts_per_page' => $num);
		if ($orderby == 'most_views') {
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'hits';
		} else {
			$args['orderby'] = $orderby;
		}

    if ($tag_ids != '') {
        $tags = explode(',', $tag_ids);
        $tags_array = array();
        if (count($tags) > 0) {
            foreach ($tags as $tag) {
                if (!empty($tag)) {
                    $tags_array[] = $tag;
                }
            }
        }
        $args['tag_slug__in'] = $tags_array;
    }
		if ($cat != '') {
	    $box_cat = get_category_by_slug($cat);
	    if ($box_cat) {
	      $cat = $box_cat->term_id;
	      $args['cat'] = $cat;
	    }
	  }
		if ($ignore_sticky) {
			$args['ignore_sticky_posts'] = 1;
		}
    $wp_query = new WP_Query($args);

    $output = '';
    if ($wp_query->have_posts()) :
        $output .= '<ul class="post_list">';
        while ($wp_query->have_posts()) : $wp_query->the_post();
            $output .= '<li class="post_item clearfix">';

                $output .= '<div class="post_thumbnail_wrapper">';
                	$output .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">';
                		if (!has_post_thumbnail()) {
                			$post_title = get_the_title();
                			$output .= '<span class="post_text_thumbnail title">'.mb_substr($post_title, 0, 1,"utf-8").'</span>';
                		}else{
                			$output .= get_the_post_thumbnail($post->ID, $thumb, array('class' => 'img-responsive'));
                		}
                	$output .= '</a>';
                $output .= '</div>'; // end post_thumnail and a

	            $output .= '<div class="post_info_wrapper">';
		            $output .= '<h5 class="title post_title"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h5>';

		            $output .= '<span class="post_meta_item post_meta_time post_time">' . get_the_time(get_option('date_format')) . '</span>';
	            $output .= '</div>'; // end post_info
            $output .= '</li>'; // end post_item
        endwhile;
        $output .= '</ul>';
    endif;
    return $output;
}
endif;

if (!function_exists('alia_find_image_id')):
function alia_find_image_id($post_id) {
    if (!$img_id = get_post_thumbnail_id ($post_id)) {
        $attachments = get_children(array(
            'post_parent' => $post_id,
            'post_type' => 'attachment',
            'numberposts' => 1,
            'post_mime_type' => 'image'
        ));
        if (is_array($attachments)) foreach ($attachments as $a)
            $img_id = $a->ID;
    }
    if ($img_id)
        return $img_id;
    return false;
}
endif;

if (!function_exists('alia_get_first_image')):
function alia_get_first_image($postid = '', $size = 'thumbnail') {
	global $post;

	if ($post && $postid == '') {
	    $post_id = $post->ID;
	} else {
	    $post_id = $postid;
	}

    if (!$img = alia_find_image_id($post->ID)) {
        if ($img = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches)) {
            $img = $matches[1][0];
        }
    }

    if (is_int($img)) {
        $img = wp_get_attachment_image_src($img, $size);
        $img = $img[0];
    }
    return $img;
}
endif;

if (!function_exists('alia_cookies_accepted')):
	function alia_cookies_accepted() {
		if (is_user_logged_in() ) {
			if (get_user_meta(get_current_user_id(), 'alia_cookies_accepted', true) == 1) {
				return true;
			}
		}elseif(isset($_COOKIE['alia_cookies_accepted']) && $_COOKIE['alia_cookies_accepted'] == 1) {
			return true;
		}else{
			return;
		}
	}
endif;

if (!function_exists('alia_update_cookies_meta')):
	function alia_update_cookies_meta($login) {

		$user = get_user_by('login',$login);
		$user_ID = $user->ID;

	    if(isset($_COOKIE['alia_cookies_accepted']) && $_COOKIE['alia_cookies_accepted'] == 1 && get_user_meta($user_ID, 'alia_cookies_accepted', true) != 1 ) {

		    	update_user_meta($user_ID, 'alia_cookies_accepted', 1);
		}
	}
endif;
add_action('wp_login', 'alia_update_cookies_meta');

/* --------
Add custom style to admin panel
------------------------------------------- */
function alia_admin_fonts() {
  echo '<link rel="stylesheet" href="'.get_theme_file_uri('/assets/css/admin.css').'" type="text/css" media="all" />';
}
add_action('admin_head', 'alia_admin_fonts');

require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/postoptions.php';
require get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

// OCDI plugin support
if (class_exists('OCDI_Plugin')) {
	// identify demo files
  function alia_ocdi_import_files() {
	  return array(
	    array(
	      'import_file_name'             => 'Alia',
	      'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo_import/alia.xml',
				'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo_import/widgets.wie',
				'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo_import/customizer.dat',
	    ),
	  );
	}
	add_filter( 'pt-ocdi/import_files', 'alia_ocdi_import_files' );

	// set demo ajax call, for faster import
	function alia_ocdi_change_time_of_single_ajax_call() {
		return 15;
	}
	add_action( 'pt-ocdi/time_for_one_ajax_call', 'alia_ocdi_change_time_of_single_ajax_call' );

	// hide plugin notice after Import
	add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

	// after import actions, set main menu
  function alia_ocdi_after_import() {
    // Import Demo Menu Items
    $menus = wp_get_nav_menus();
    $locations = get_theme_mod( 'nav_menu_locations' );
    if ($menus) {
        foreach($menus as $menu) {
            if ($menu->name == "Main Menu") {
                $locations['top'] = $menu->term_id;
            }
        }
    }
    set_theme_mod( 'nav_menu_locations', $locations );
  }
  add_action( 'pt-ocdi/after_import', 'alia_ocdi_after_import' );

} else {
	/* Demo plugin install Notice */
	if (!alia_option('ignore_install_ocdi_plugin_notice')) {

		function alia_install_ocdi_plugin() {
			?>
			<div class="notice hidden_gutenberg_editor notice-info is-dismissible" style="position:relative;">
					<p><b>For importing the demo, you'll need to install <a href="https://wordpress.org/plugins/one-click-demo-import/">One Click Demo Import</a> plugin :)</b></p>
					<p><a href="https://wordpress.org/plugins/one-click-demo-import/">Install Plugin</a>   |   <a href="?ignore_install_ocdi_plugin_notice=1">No Thanks</a></p>
					<a class="notice-dismiss" href="?ignore_install_ocdi_plugin_notice=1"><span class="screen-reader-text">Dismiss this notice</span></a>
			</div>
			<?php
		}
		add_action( 'admin_notices', 'alia_install_ocdi_plugin' );

		function alia_install_ocdi_plugin_notice() {
			/* If user clicks to ignore the notice, add that to their user meta */
			if ( isset($_GET['ignore_install_ocdi_plugin_notice']) && '1' == $_GET['ignore_install_ocdi_plugin_notice'] ) {
				set_theme_mod( 'ignore_install_ocdi_plugin_notice', true );
			}
		}
		add_action('admin_init', 'alia_install_ocdi_plugin_notice');
	}
}

/**
 * A get_post_gallery() polyfill for Gutenberg
 *
 * @param string $gallery The current gallery html that may have already been found (through shortcodes).
 * @param int $post The post id.
 * @return string The gallery html.
 */
function alia_get_post_gallery( $gallery, $post ) {
	// Already found a gallery so lets quit.
	if ( $gallery ) {
		return $gallery;
	}
	// Check the post exists.
	$post = get_post( $post );
	if ( ! $post ) {
		return $gallery;
	}
	// Not using Gutenberg so let's quit.
	if ( ! function_exists( 'has_blocks' ) ) {
		return $gallery;
	}
	// Not using blocks so let's quit.
	if ( ! has_blocks( $post->post_content ) ) {
		return $gallery;
	}
	/**
	 * Search for gallery blocks and then, if found, return the html from the
	 * first gallery block.
	 *
	 * Thanks to Gabor for help with the regex:
	 * https://twitter.com/javorszky/status/1043785500564381696.
	 */
	$pattern = "/<!--\ wp:gallery.*-->([\s\S]*?)<!--\ \/wp:gallery -->/i";
	preg_match_all( $pattern, $post->post_content, $the_galleries );
	// Check a gallery was found and if so change the gallery html.
	if ( ! empty( $the_galleries[1] ) ) {
		$gallery = reset( $the_galleries[1] );
	}
	return $gallery;
}
add_filter( 'get_post_gallery', 'alia_get_post_gallery', 10, 2 );