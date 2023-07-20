<?php
/**
 * Custom template tags for Iceberg
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @since Iceberg 1.0
 */

if ( ! function_exists( 'iceberg_site_identity' ) ) :
    /**
    * Prints HTML with blog title and description.
    *
    * @since Iceberg 1.0
    */
    function iceberg_site_identity() {
        if( has_custom_logo() ) {
            the_custom_logo();
        } 

        if( get_theme_mod( 'display_site_title', 1 ) ) {
            printf( '<%1$s class="site-title"><a href="%2$s" rel="home">%3$s</a></%1$s>', 
            is_front_page() && is_home() ? 'h1' : 'p', 
            esc_url( home_url( '/' ) ), 
            esc_html( get_bloginfo( 'name' ) ) 
            );
        }
}
endif;

if ( ! function_exists( 'iceberg_custom_text' ) ) :
    /**
    * Prints HTML with custom customizer text.
    *
    * @since Iceberg 2.0
    */
    function iceberg_custom_text( $name = '', $before = '', $after = '', $default_text = '' ) {
        if( ! $name )
            return;

        $custom_text = get_theme_mod( $name );

        if( ! $custom_text && ! is_customize_preview() && ! $default_text )
            return;

        $custom_text = wp_kses( $custom_text, array(
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'target' => array()
                ),
                'p'      => array(),
                'b'      => array(),
                'strong' => array(),
                'em'     => array(),
                'i'      => array(),
                'br'     => array(),
                'span'   => array(),
                'img' => array(
                    'src' => array(),
                    'alt' => array(),
                    'title' => array()
                )
            )
        );

        $custom_text = $default_text && ! $custom_text ? $default_text : $custom_text;

        if( $custom_text || is_customize_preview() )
            printf( '%s%s%s', $before, $custom_text, $after );
    }
endif;

if ( ! function_exists( 'iceberg_post_thumbnail' ) ) :
    /**
    * Display an optional post thumbnail.
    *
    * Wraps the post thumbnail in an anchor element on index views, or a div
    * element when on single views.
    *
    * @since Iceberg 1.0
    */
    function iceberg_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail()  ) {
            return;
        }

        if ( is_singular() ) :
        ?>

        <div class="post-thumbnail">
            <?php the_post_thumbnail( 'iceberg-post-thumbnail-crop' ); ?>
        </div><!-- .post-thumbnail -->

        <?php else : ?>

        <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
            <?php the_post_thumbnail( 'iceberg-post-thumbnail-crop', array( 'alt' => get_the_title() ) ); ?>
        </a>

        <?php endif; // End is_singular()
    }
endif;

if ( ! function_exists( 'iceberg_the_post_meta' ) ) :
    /**
    * Prints HTML with meta information for the categories, post date.
    *
    * @since Iceberg 2.0
    */
    function iceberg_the_post_meta( $before = '', $after = '', $display_date = true, $display_author = true ) {

        $output = '';

        $post_type = get_post_type();

        if ( in_array( $post_type, array( 'post', 'attachment' ) ) && $display_date ) {
            $time_string = sprintf( '<span class="entry-date published" datetime="%1$s">%2$s</span>', esc_attr( get_the_date( 'c' ) ), get_the_date() );
            $time_string = sprintf( esc_html_x( 'Posted on %s', 'Post date', 'iceberg' ), $time_string );

            $output .= sprintf( '<span class="posted-on">%s</span>', $time_string );
        }

        if ( 'post' == $post_type && $display_author ) {
            $author_string = sprintf( '<a class="url fn" href="%s">%s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author() );
            $author_string = sprintf( esc_html_x( 'by %s', 'Post author', 'iceberg' ), $author_string );

            $output .= sprintf( '<span class="byline author vcard">%s</span>', $author_string );
        }

        if( $output )
            printf( '%s%s%s', $before, $output, $after );

        return false;
    }
endif;

if ( ! function_exists( 'iceberg_the_category' ) ) :
  /**
   * Prints HTML with post categories list.
   *
   * @since Iceberg 2.0
   */
    function iceberg_the_category( $before = '', $after = '', $display = true ) {
        $post_type = get_post_type();

        $output = '';

        if ( 'post' == $post_type && $display ) {
            $categories = get_the_category();

            if( $categories ) {
                foreach( $categories as $category ) {
                    $output .= sprintf( '<a href="%s" class="category-%d">%s</a>', esc_url( get_category_link( $category->term_id ) ), $category->term_id, esc_attr( $category->cat_name ) );
                }
            }
        }

        if( $output ) {
            printf( '%s%s%s', $before, $output, $after );
        } 
  }
endif;

if ( ! function_exists( 'iceberg_the_post_footer' ) ) :
    /**
    * Prints HTML with post tags and share buttons in post footer
    *
    * @since Iceberg 2.0
    */
    function iceberg_the_post_footer( $display_tags = true, $display_share_buttons = true,  $before = '', $after = '' ) {
        $output = '';

        $post = get_post();

        if ( is_single() && $display_tags ) {
            $output .= get_the_tag_list( '<div class="tags-list">',' ','</div>' );
        }

        if( is_singular() && $display_share_buttons && function_exists( 'nsafb_get_share_buttons' ) ) {
            $output .= sprintf( '<div class="entry-share">%s</div>', nsafb_get_share_buttons() );
        }

        if( $output )
            printf( '%s%s%s', $before, $output, $after );
    }
endif;

if ( ! function_exists( 'iceberg_related_posts' ) ) :
    /**
    * Related posts for current post.
    *
    * @since Iceberg 1.0
    */
    function iceberg_related_posts( $before = '', $after = '' ) {
        global $post;

        if( ! $post )
            return;

        if( $post->post_type !== 'post' )
            return;

        $query_args = array(
            'post__not_in'        => array( $post->ID ),
            'posts_per_page'      => 3,
            'orderby'             => 'rand',
            'ignore_sticky_posts' => true
        );

        $related_by = get_theme_mod( 'related_by', 'none' );

        switch ( $related_by ) {

            case 'category' :
                $categories = get_the_category( $post->ID );

                if ( $categories ) {
                    $category_ids = array();

                    foreach( $categories as $category ) 
                        $category_ids[] = $category->term_id;

                    $query_args['category__in'] = $category_ids;
                }
            break;

            case 'tags' :
                $tags = wp_get_post_tags( $post->ID );

                if ( $tags ) {
                    $tag_ids = array();

                    foreach( $tags as $tag ) 
                        $tag_ids[] = $tag->term_id;

                    $query_args['tag__in'] = $tag_ids;
                }
            break;

            case 'none' :
                $query_args['orderby'] = 'rand';
            break;

        }

        $related_posts = new WP_Query( $query_args );

        $output = '';

        if( $related_posts->have_posts() ) {
            printf( '%s<div class="related-posts">', $before );

            while( $related_posts->have_posts() ) : $related_posts->the_post(); ?>

            <div class="related-post">

                <?php if( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink()?>" class="related-post-thumbnail" rel="bookmark" title="<?php the_title(); ?>">
                    <?php the_post_thumbnail( 'iceberg-medium-square-thumbnail' ); ?>
                </a>
                <?php endif; ?>

                <div class="related-post-content">

                    <a href="<?php the_permalink(); ?>" class="related-post-title" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>

                    <div class="related-post-date">
                        <?php echo get_the_date(); ?>
                    </div>

                </div>

            </div>

            <?php 
            endwhile;

            printf( '</div>%s', $after );
        }

        wp_reset_postdata(); 
    }
endif;
?>