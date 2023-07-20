/**
 * Live-update changed settings in real time in the Customizer preview.
 */

( function( $ ) {
	"use strict";
	
	var api = wp.customize,
		$head = $('head');

	function hexToRgba( hex, opacity ) {
		var red = parseInt( hex.substring(1, 3), 16 ),
			green = parseInt( hex.substring(3, 5), 16 ),
			blue = parseInt( hex.substring(5, 7), 16 );

		return 'rgba( ' + red + ', ' + green + ', ' + blue + ', ' + opacity + ' )';
	}

	// Site title
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Logo size
	api( 'logo_width', function( value ) {
		value.bind( function( to ) {
      		$( '.custom-logo' ).css( 'max-width', parseFloat( to ) + 'rem' );
		} );
	} );

	// Logo margin bottom
	api( 'logo_margin_bottom', function( value ) {
		value.bind( function( to ) {
      		$( '.custom-logo' ).css( 'margin-bottom', parseFloat( to ) + 'rem' );
		} );
	} );
	
	// Tagline
	api( 'tagline', function( value ) {
		value.bind( function( to ) {
			$( '.tagline' ).html( to );
		} );
	} );

	api( 'site_title_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-site-title-color-css'),
				css = 'color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-site-title-color-css">.sidebar .site-title { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'social_icons_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-social-icons-color-css'),
				css = 'fill: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-social-icons-color-css">.entry-social-profiles .nsafb-social-profiles .nsafb-svg-icon { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'sidebar_background_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-sidebar-background-color-css'),
				css = 'background-color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-sidebar-background-color-css">.sidebar { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'sidebar_divider_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-sidebar-divider-color-css');

			style.remove();
			style = $('<style type="text/css" id="custom-sidebar-divider-color-css">.toggle-wrap { border-color: ' +  to + '; box-shadow: none; } </style>').appendTo( $head );
		} );
	} );

	api( 'sidebar_text_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-sidebar-text-color-css');

			style.remove();
			style = $('<style type="text/css" id="custom-sidebar-text-color-css">.sidebar { color: ' +  to + ';  } .widget_tag_cloud .tagcloud a { color: ' + hexToRgba( to, 0.7 ) + '; border-color: ' + hexToRgba( to, 0.3 ) + '} .sidebar table, .sidebar tr, .sidebar td, .sidebar th { border-color: ' + hexToRgba( to, 0.3 ) + ' }</style>').appendTo( $head );
		} );
	} );

	api( 'sidebar_headings_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-sidebar-heading-color-css'),
				css = 'color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-sidebar-heading-color-css">.sidebar h1, .sidebar h2, .sidebar h3, .sidebar h4, .sidebar h5, .sidebar h6 { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'sidebar_links_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-sidebar-links-color-css'),
				css = 'color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-sidebar-links-color-css">.sidebar a, .sidebar .primary-navigation a:hover, .sidebar .widget_nav_menu a:hover { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'sidebar_links_hover_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-sidebar-links-hover-color-css'),
				css = 'color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-sidebar-links-hover-color-css">.sidebar a:hover { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'link_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-link-color-css'),
				css = 'color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-link-color-css">.page-content a, .entry-content a:not(.wp-block-button__link), .post-meta a, .author-link, .logged-in-as a, .comment-content a, .comment-edit-link, #cancel-comment-reply-link, .comment-navigation a, .image-navigation a { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'link_color_hover', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-link-hover-color-css'),
				css = 'color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-link-hover-color-css">.page-content a:hover, .entry-content a:not(.wp-block-button__link):hover, .post-meta a:hover, .author-link:hover, .logged-in-as a:hover, .comment-content a:hover, .comment-edit-link:hover, #cancel-comment-reply-link:hover, .comment-navigation a:hover, .image-navigation a:hover { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'button_background_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-button-background-color-css'),
				css = 'background-color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-button-background-color-css">button,input[type="button"],input[type="reset"],input[type="submit"],.pagination .page-numbers:hover,.pagination .page-numbers.current { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'button_background_color_hover', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-button-background-hover-color-css'),
				css = 'background-color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-button-background-hover-color-css">button:hover,input[type="button"]:hover,input[type="reset"]:hover,input[type="submit"]:hover { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'button_text_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-button-text-color-css'),
				css = 'color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-button-text-color-css">button,input[type="button"],input[type="reset"],input[type="submit"],.pagination .page-numbers:hover,.pagination .page-numbers.current { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'category_label_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-category-label-color-css'),
				css = 'background-color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-category-label-color-css">.entry-categories a { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

	api( 'selection_color', function( value ) {
		value.bind( function( to ) {
			var style = $('#custom-selection-color-css'),
				css = 'background-color: ' +  to;

			style.remove();
			style = $('<style type="text/css" id="custom-selection-color-css">::selection { ' + css + ' } </style>').appendTo( $head );
		} );
	} );

} )( jQuery );
