<?php
$post_classes = array('blog_post_container');
$post_position = '';
if (!isset($alia_post_position) || $alia_post_position != 'related_posts') {
	// add customhentry not hentry, because the hentry class will be deleted in the filter
	// later in alia_remove_hentry() function will check for customentry first then decide to remove hentry or not
	$post_classes[] = 'customhentry';
	$post_position = 'normalhentry';
}
if ( !is_single() && alia_cross_option('alia_blog_show_all_content', '', 0) && isset($alia_content_width) && $alia_content_width == "wide" ) {
	$post_classes[] = 'show_all_content_blog';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>

	<?php
		$post_banner_class = 'no_post_banner';

		if (( alia_cross_option('alia_show_banner_inside_standard_posts', '', 1) || !is_single(get_the_ID()) ) && has_post_thumbnail() ) {
			$post_banner_class = 'has_post_banner';
		}

		if ( isset($alia_content_width) && ($alia_content_width == 'two_coloumns_list' || $alia_content_width == 'grid') ) {
			$alia_post_banner = 'alia_grid_banner';
			if (
				!alia_cross_option('alia_crop_banner_post_list', '', 1) && !is_single(get_the_ID())
				|| !alia_cross_option('alia_crop_banner_inside_post', '', 0) && is_single(get_the_ID())
				) {
					$alia_post_banner = 'alia_grid_banner_uncrop';
			}
		} else if (isset($alia_content_width) && $alia_content_width == 'grid3col') {
			$alia_post_banner = 'alia_grid_banner_3col';
			if (
				!alia_cross_option('alia_crop_banner_post_list', '', 1) && !is_single(get_the_ID())
				|| !alia_cross_option('alia_crop_banner_inside_post', '', 0) && is_single(get_the_ID())
				) {
					$alia_post_banner = 'alia_grid_banner_3col_uncrop';
			}
		} else {
			$alia_post_banner = 'alia_wide_banner';
			if (
				!alia_cross_option('alia_crop_banner_post_list', '', 1) && !is_single(get_the_ID())
				|| !alia_cross_option('alia_crop_banner_inside_post', '', 0) && is_single(get_the_ID())
				) {
					$alia_post_banner = 'full';
			}
			if (is_single() && alia_cross_option('alia_post_layout', '', 'fullwidth') == 'sidebar_l'
					||
					(isset($alia_sidebar_position) && $alia_sidebar_position == 'sidebar_l')) {
				$alia_post_banner = 'alia_wide_banner_sidebar';
				if (!alia_cross_option('alia_crop_banner_inside_post', '', 0)) {
					$alia_post_banner = 'alia_full_banner_sidebar';
				}
			}
		}
	?>
	<?php if (is_single(get_the_ID())): ?>

		<div class="single_post_body <?php echo esc_attr($post_banner_class); ?>">

			<?php
			if ( function_exists('yoast_breadcrumb') ) {
			  yoast_breadcrumb( '
			<p class="single_breadcrumbs" id="breadcrumbs">','</p>
			' );
			}
			?>

			<div class="post_header post_header_single">
				<?php
				the_title( '<h1 class="entry-title title post_title">', '</h1>' );
				?>
			</div>

			<?php if (alia_cross_option('alia_meta_info_posts', '', 1)): ?>
			<div class="post_meta_container post_meta_container_single clearfix">

				<?php
					alia_post_meta($post_position);
				?>
			</div>
			<?php endif; ?>

		</div>
	<?php endif ?>

	<?php if (( alia_cross_option('alia_show_banner_inside_standard_posts', '', 1) || !is_single(get_the_ID()) ) && has_post_thumbnail() ): ?>
		<figure class="post_banner">

			<?php if ( !is_single(get_the_ID()) ): ?>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( $alia_post_banner ); ?>
			</a>
			<?php else: ?>
				<?php the_post_thumbnail( $alia_post_banner ); ?>
			<?php endif; ?>
		</figure>
		<?php $post_banner_class = 'has_post_banner'; ?>
	<?php endif; ?>

	<div class="post_body <?php echo esc_attr($post_banner_class); ?>">
		<?php if (!is_single(get_the_ID())): ?>
			<div class="post_header">
				<?php
				if ( is_front_page() && is_home() ) {
					the_title( '<h3 class="entry-title title post_title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
				} else {
					the_title( '<h2 class="entry-title title post_title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				}
				?>
			</div>

			<?php if (alia_cross_option('alia_meta_info_posts', '', 1)): ?>
			<div class="post_meta_container clearfix">

				<?php
					alia_post_meta($post_position);
				?>
			</div>
			<?php endif; ?>
		<?php endif ?>

		<div class="post_info_wrapper">
			<?php if ( is_single(get_the_ID()) ||
				( alia_cross_option('alia_blog_show_all_content', '', 0) && isset($alia_content_width) && $alia_content_width == "wide" )
			) {
				echo '<div class="entry-content blog_post_text blog_post_description clearfix">';
					// Only show content if is a single post, or if there's no featured image.
					/* translators: %s: Name of current post */
					the_content( sprintf( '<div class="blog_post_control_item blog_post_readmore"><a href="%1$s" class="more-link">%2$s<span class="continue_reading_dots"><span class="continue_reading_squares"><span></span><span></span><span></span><span></span></span><i class="fas fa-chevron-right readmore_icon"></i></span></a></div>',
						esc_url( get_permalink( get_the_ID() ) ),
						esc_attr__( 'Continue reading', 'alia' )

					) );

					wp_link_pages( array(
						'before'      => '<div class="single_post_pagination"><div class="page-links">' . esc_attr__( 'Pages:', 'alia' ),
						'after'       => '</div></div>',
						'link_before' => '<span class="page-number">',
						'link_after'  => '</span>',
					) );
					if (is_single() || !strpos($post->post_content, '<!--more-->')) {
						if ( alia_cross_option('alia_show_tags_posts', '', 1) && get_the_tags() ) {
							echo '<div class="tagcloud single_tagcloud clearfix">';
							the_tags('', '', '');
							echo '</div>';
						}
					}

					if (( alia_cross_option('alia_blog_show_all_content', '', 0) && isset($alia_content_width) && $alia_content_width == "wide" ) && !strpos($post->post_content, '<!--more-->')) {
						echo '<div class="blog_post_control_item blog_post_readmore">';
							if ( !post_password_required() && comments_open(get_the_ID()) ) {
								echo '<span class="blog_list_comment_link">';
									$comments_num = '';
									if (get_comments_number() != 0) {
										$comments_num = '<span class="comment_num">'.get_comments_number().'</span>';
									}
									printf('<a href="%1$s">%2$s%3$s</a>',
											get_comments_link(),
											'<i class="far fa-comment-alt"></i>',
											$comments_num
									);

								echo '</span>';
							}

							if (function_exists('alia_blog_list_share_icons') ) {
								alia_blog_list_share_icons();
							}
						echo '</div>'; // end blog_post_control_item
					}

				echo '</div>'; // close .entry-content
			} elseif (!isset($alia_content_layout) || $alia_content_layout != 'layout_with_sidebar' || $post_banner_class == 'no_post_banner') {
				echo '<div class="entry-summary blog_post_text blog_post_description">';
					if ($alia_content_width == 'two_coloumns_list' && has_post_thumbnail()) {
						echo alia_excerpt(20);
					}else{
						echo alia_excerpt(40);
					}

					echo '<div class="blog_post_control_item blog_post_readmore">';
						// read more link
						echo sprintf( '<a href="%1$s" class="more-link">%2$s<span class="continue_reading_dots"><span class="continue_reading_squares"><span></span><span></span><span></span><span></span></span><i class="fas fa-chevron-right readmore_icon"></i></span></a>',
							esc_url( get_permalink( get_the_ID() ) ),
							esc_attr__( 'Continue reading', 'alia' )

						);

						if ( !post_password_required() && comments_open(get_the_ID()) ) {
							echo '<span class="blog_list_comment_link">';
								$comments_num = '';
								if (get_comments_number() != 0) {
									$comments_num = '<span class="comment_num">'.get_comments_number().'</span>';
								}
								printf('<a href="%1$s">%2$s%3$s</a>',
										get_comments_link(),
										'<i class="far fa-comment-alt"></i>',
										$comments_num
								);

							echo '</span>';
						}

						if (function_exists('alia_blog_list_share_icons') ) {
							alia_blog_list_share_icons();
						}

					echo '</div>'; // end blog_post_control_item
				echo '</div>'; // close .entry-summary
			}
			?>


		</div> <!-- end post_info_wrapper -->
	</div> <!-- end post_body -->
</article>