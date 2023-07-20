<?php
$post_classes = array('blog_post_container');
$post_position = '';
if (!isset($alia_post_position) || $alia_post_position != 'related_posts') {
	// add customhentry not hentry, because the hentry class will be deleted in the filter
	// later in alia_remove_hentry() function will check for customentry first then decide to remove hentry or not
	$post_classes[] = 'customhentry';
	$post_position = 'normalhentry';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
	
	<?php if (is_single(get_the_ID())): ?>
		<div class="single_post_body">
			<div class="post_header post_header_single">
				<?php
				the_title( '<h1 class="entry-title title post_title">', '</h1>' );
				?>
			</div>

			<div class="post_meta_container post_meta_container_single clearfix">

				<?php
					alia_post_meta($alia_post_position);
				?>
			</div>
		</div>
	<?php endif ?>

	<div class="post_body">
		
		<div class="post_header">
			<?php
			if ( is_single(get_the_ID()) ) {
				the_title( '<h1 class="entry-title title post_title">', '</h1>' );
			} elseif ( is_front_page() && is_home() ) {
				the_title( '<h3 class="entry-title title post_title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			} else {
				the_title( '<h2 class="entry-title title post_title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
			?>
		</div>

		<div class="post_meta_container clearfix">
			<?php
				alia_post_meta($post_position);
			?>
		</div>
		<div class="post_info_wrapper">
			<div class="entry-summary blog_post_text blog_post_description">
				<?php
					echo alia_excerpt(40);
				?>
			</div>

			<div class="blog_post_control_item blog_post_readmore">
				<a href="#">Continue Reading <span class="continue_reading_dots">...</span></a>
			</div> <!-- end blog_post_control_item & blog_post_readmore -->
		</div> <!-- end post_info_wrapper -->
	</div> <!-- end post_body -->
</article>