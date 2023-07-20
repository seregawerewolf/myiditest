<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive.
 *
 * @since Iceberg 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php iceberg_post_thumbnail(); ?>

    <div class="inner-box">

        <div class="content-container">

            <header class="entry-header">

            <?php 
                if( is_sticky() && is_home() && ! is_paged() ) {
                    printf( '<div class="sticky-badge">%s</div>', iceberg_get_theme_svg( 'star' ) );
                }

                iceberg_the_category( 
                    sprintf( '<div class="entry-categories"><div class="entry-categories-inner"><span class="screen-reader-text">%s</span>', esc_html__( 'Categories', 'iceberg' ) ), 
                    '</div></div>', 
                    get_theme_mod( 'display_categories', 1 )
                );

                if ( is_single() ) {
                    the_title( '<h1 class="entry-title">', '</h1>' );
                } else {
                    the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
                }

                iceberg_the_post_meta( '<div class="post-meta">', '</div>', get_theme_mod( 'display_date', 1 ), get_theme_mod( 'display_author', 1 ) ); 
            ?>

            </header><!-- .entry-header -->

            <?php if( is_search() ) : ?>

                <div class="entry-summary">

                    <?php the_excerpt(); ?>

                </div><!-- .entry-summary -->

            <?php else : ?>

                <div class="entry-content">

                <?php
                the_content( esc_html__( 'Continue reading', 'iceberg' ) );

                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'iceberg' ) . '</span>',
                    'after'       => '</div>',
                    'pagelink'    => '%',
                    'separator'   => ' ',
                ) );
                ?>  

                </div><!-- .entry-content -->

            <?php endif; ?>

            <?php iceberg_the_post_footer( get_theme_mod( 'display_tags_list', 1 ), get_theme_mod( 'display_share_buttons', 1 ), '<footer class="entry-footer">', '</footer>' ); ?>

        </div><!-- .content-container -->

    </div><!-- .inner-box -->

</article><!-- #post-## -->
