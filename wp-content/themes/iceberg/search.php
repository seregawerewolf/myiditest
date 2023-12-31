<?php
/**
 * The template for displaying search results pages.
 *
 * @since Iceberg 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header inner-box-small">

				<div class="content-container">

					<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'iceberg' ), get_search_query() ); ?></h1>
					<?php get_search_form(); ?>
					
				</div>

			</header><!-- .page-header -->

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => is_rtl() ? iceberg_get_theme_svg( 'chevron-right' ) : iceberg_get_theme_svg( 'chevron-left' ),
				'next_text'          => is_rtl() ? iceberg_get_theme_svg( 'chevron-left' ) : iceberg_get_theme_svg( 'chevron-right' ),
				'before_page_number' => ''
			) );
			
		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>

		</main><!-- .site-main -->

	</div><!-- .content-area -->

<?php get_footer(); ?>
