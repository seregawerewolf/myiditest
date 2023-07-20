<?php get_header(); ?>

<section id="primary" class="container main_content_area">

			<div class="row full_width_list">
				<div class="col12">
				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
					$story_bg_image = get_the_post_thumbnail_url(get_the_ID(), 'alia_story_image', array( 'class' => 'img-responsive' ));
					if (alia_option('alia_stories_cdn_url') ) {
						// cdn url
						$story_bg_image = str_replace(get_site_url(), alia_option('alia_stories_cdn_url'), $story_bg_image );
					}
					?>
					<div class='story_single_row row'>
						<div class="col7 alia_story_view">
							<img src="<?php echo esc_url($story_bg_image); ?>">
						</div>
						<div class="col5 alia_story_comments">
							<?php
							$author_id = get_the_author_meta('ID');
							$output = '';
							$output .= '<div class="story_view_info clearfix">';

								$output .= '<span class="story_item_author_avatar"><a class="meta_author_avatar_url" href="'.esc_url( get_author_posts_url($author_id) ).'">'.get_avatar($author_id, 40).'</a></span>';

								$output .= '<div class="story_meta">';
									$output .= '<span class="story_item_author"><a class="meta_author_name url fn n" href="'.esc_url( get_author_posts_url($author_id) ).'">'.get_the_author_meta('display_name', $author_id).'</a></span>';
									$output .= '<span class="story_date">'.get_the_date('').'</span>';
								$output .= '</div>'; // close story_meta

								
							$output .= '</div>'; //story_content
							echo $output;
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								echo '<div class="story_comment_container">';
									comments_template();
								echo '</div>';
							endif;
							?>
						</div>
					</div><!-- close .story_single_row -->
					<?php

					$prev_post = get_previous_post();
					if (!empty( $prev_post )) {
						$story_bg_image = get_the_post_thumbnail_url($prev_post->ID, 'alia_thumbnail_avatar', array( 'class' => 'img-responsive' ));
						if (alia_option('alia_stories_cdn_url') ) {
							// cdn url
							$story_bg_image = str_replace(get_site_url(), alia_option('alia_stories_cdn_url'), $story_bg_image );
						}
						echo '<div class="story_single_prev story_single_nav">';
							echo '<div class="alia_prev_view"><a href="'.get_permalink($prev_post->ID).'"><img src="'.esc_url($story_bg_image).'"></a></div>';
						echo '</div>';
						wp_reset_postdata();
					}

					$next_post = get_next_post();
					if (!empty( $next_post )) {
						$story_bg_image = get_the_post_thumbnail_url($next_post->ID, 'alia_thumbnail_avatar', array( 'class' => 'img-responsive' ));
						if (alia_option('alia_stories_cdn_url') ) {
							// cdn url
							$story_bg_image = str_replace(get_site_url(), alia_option('alia_stories_cdn_url'), $story_bg_image );
						}
						echo '<div class="story_single_next story_single_nav">';
							echo '<div class="alia_prev_view"><a href="'.get_permalink($next_post->ID).'"><img src="'.esc_url($story_bg_image).'"></a></div>';
						echo '</div>';
						wp_reset_postdata();
					}



				endwhile; // End of the loop.
				?>

				</div><!-- close col12 just inside .full_width_list -->
			</div> <!-- close .full_width_list -->


</section><!-- #primary -->
<?php get_footer();
