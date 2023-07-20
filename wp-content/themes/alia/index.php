<?php get_header(); ?>

<?php if (is_author()): ?>
	<?php if ( have_posts() ) : ?>
		<?php if (get_the_author_meta('description')): ?>
			<section class="container author_info_container author_page_box">
				<div class="row">
					<div class="author_avatar_col col">
						<?php echo get_avatar(get_the_author_meta('ID'), 220) ?>
					</div>
					<div class="author_info_col col">
						<div class="author_box_info_header">
							<h2 class="author_display_name title entry-title section_title"><?php printf(__("Hi, I am %s", "alia"), get_the_author_meta("display_name")); ?></h2>
							<?php
							// show author social icons in header only if no story circles shown
							if (function_exists('alia_create_stories') && alia_option('alia_stories_author_box', 1) && function_exists( 'alia_author_social_icons' ) && alia_author_social_icons() != '' ) {
								if (function_exists( 'alia_author_social_icons' )) {
									echo alia_author_social_icons();
								}
							}
							?>
						</div>

						<div class="author_description">
							<?php the_author_meta('description'); ?>
						</div>
						<?php
						if ( function_exists('alia_create_stories') && alia_option('alia_stories_author_box', 1) ) {
							echo alia_stories_circles(5, '', get_the_author_meta('ID'));
						}else{
							// if no stories, show social icons below text
							if (function_exists( 'alia_author_social_icons' )) {
								echo alia_author_social_icons();
							}
						}
						?>
					</div>
				</div>

			</section><!-- #author_info_container -->
		<?php else: ?>
			<div class="container archive_header page-header">
				<?php
					the_archive_title( '<h1 class="page-title section_title title">', '</h1>' );
				?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
<?php elseif (is_archive()): ?>
	<div class="container archive_header page-header">
		<?php
			the_archive_title( '<h1 class="page-title section_title title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description clearfix">', '</div>' );
		?>
	</div>
<?php elseif (is_search()): ?>

<?php if ( have_posts() ) : ?>
	<div class="container archive_header page-header search_header">
		<h1 class="page-title section_title title"><?php printf( esc_attr__( 'Search Results for: %s', 'alia' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	</div>
<?php endif; ?>


<?php else: ?>

	<?php if ( !is_paged() && is_active_sidebar( 'sidebar-intro' ) ) : ?>
		<section class="container intro_widgets_container">
			<div id="intro_sidebar_widget" class="widget_area">
				<?php dynamic_sidebar( 'sidebar-intro' ); ?>
			</div>
		</section><!-- #intro_widgets_container -->
	<?php endif; ?>

<?php endif; ?>


<section id="primary" class="container main_content_area blog_index_area <?php echo alia_option('alia_blog_layout', 'flist') ?>_main_content_container">
			<h4 class="page-title screen-reader-text entry-title"><?php  printf( esc_html__( '%1$s Articles.', 'alia' ), get_bloginfo( 'name' ) );; ?></h4>
			<?php
			if ( have_posts() ) :
				get_template_part( 'template-parts/page/blog', 'layout' );
			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif;
			?>
			<!-- <div class="loadmore_wrapper">
				<span class="loadmore_button">More Topics</span>
			</div> -->

</section><!-- #primary -->

<?php get_footer();
