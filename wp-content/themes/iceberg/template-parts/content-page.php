<?php
/**
 * The template used for displaying page content
 *
 * @since Iceberg 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php iceberg_post_thumbnail(); ?>
  
  <div class="inner-box">
    <div class="content-container">
      <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
      </header><!-- .entry-header -->

      <div class="entry-content">
        <?php 
          the_content();
          
          wp_link_pages( array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'iceberg' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
            'pagelink'    => ' %',
            'separator'   => ', ',
          ) );
        ?>
      </div><!-- .entry-content -->
      
      <?php iceberg_the_post_footer( false, get_theme_mod( 'display_page_share_buttons', 1 ), '<footer class="entry-footer">', '</footer>' ); ?>
    </div>
  </div>
</article><!-- #post-## -->
