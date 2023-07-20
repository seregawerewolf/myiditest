<section class="container main_content_area no-results not-found">

	<div class="row full_width_list">
		<div class="col12">
			<div class="error_icon"><i class="fas fa-exclamation"></i></div>
			<header class="page-header">
				<h1 class="page-title title"><?php esc_attr_e( 'Nothing Found', 'alia' ); ?></h1>
			</header><!-- .page-header -->
			<div class="page-content">
				<?php
				if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

					<p><?php esc_attr_e( 'Ready to publish your first post?', 'alia' ); ?></p>

				<?php else : ?>

					<p><?php esc_attr_e( 'Nothing was found at this page. But we still have other interesting stuff for you!', 'alia' ); ?></p>

					<?php get_search_form(); ?>

				<?php endif; ?>

			</div><!-- .page-content -->
		</div><!-- close col12 just inside .full_width_list -->
	</div> <!-- close .full_width_list -->

</section><!-- .no-results -->


