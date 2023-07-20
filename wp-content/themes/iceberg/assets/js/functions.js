/**
 * Theme functions file.
 */
(function($) {
  "use strict";

    $(document).ready(function($){

        var $body = $('body');

        $body.imagesLoaded( function() {
            setTimeout(function() {
                $body.addClass('loaded');
            }, 200); 
        });

        // Mobile navigation toggle
        $('#sidebar-toggle').on( 'click', function(e) {
            e.preventDefault();

            $('.toggle-wrap').toggle();
            $body.toggleClass( 'menu-open' );
        });

        $('.widget_nav_menu .menu-item-has-children > a, .primary-navigation .menu-item-has-children > a, .primary-navigation .page_item_has_children > a').on( 'click', function(e) {
            e.preventDefault();
            $(this).next('.sub-menu, .children').slideToggle(200);
        });

        if( $.fn.owlCarousel !== undefined && $.fn.imagesLoaded !== undefined ) {
          $( '.format-gallery-carousel' ).imagesLoaded( function() {  
            $( '.format-gallery-carousel' ).owlCarousel({
              items: 1,
              margin: 0,
              loop: true,
              autoHeight: true,
              smartSpeed: 600,
              nav: true,
              dots: false,
              rtl: $('body').hasClass( 'rtl' ) ? true : false,
              navText : [ icebergOwlVars.prevIcon, icebergOwlVars.nextIcon ]
            });
          });
        }
    });
})(jQuery);