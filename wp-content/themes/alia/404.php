<?php get_header(); ?>

<section id="primary" class="container main_content_area error-404 not-found">

			<div class="row full_width_list">
				<div class="col12">
					<div class="error_icon"><i class="fas fa-exclamation"></i></div>
					<header class="page-header">
						<h1 class="page-title title"><?php esc_attr_e( 'Sorry! Page not found.', 'alia' ); ?></h1>
					</header><!-- .page-header -->
					<div class="page-content">
						<p><?php esc_attr_e( 'Nothing was found at this location. But we still have other interesting stuff for you!', 'alia' ); ?></p>

						<?php get_search_form(); ?>

					</div><!-- .page-content -->
				</div><!-- close col12 just inside .full_width_list -->
			</div> <!-- close .full_width_list -->

</section><!-- #primary -->
<?php get_footer(); ?>


