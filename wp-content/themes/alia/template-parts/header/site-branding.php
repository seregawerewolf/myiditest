<?php if (alia_cross_option('alia_show_header_logo', '', 1)): ?>
<div class="header_square_logo">
	<?php if ( alia_option('alia_default_logo') ):

		$is_retina_logo = " no_retina_logo";

		// logo size
		$logo_width = 'auto';
		$logo_height = 'auto';
		$logo_size_att = '';
		$logo_style_att = '';

		if (alia_option('alia_logo_width') && alia_option('alia_logo_width') != 0) {
			$logo_width = strval(alia_option('alia_logo_width'));
			$logo_size_att .= ' width='.strval(alia_option('alia_logo_width')).'';
			$logo_style_att .= '.site_logo_image { width : '.$logo_width.'px; }';
		}

		if (alia_option('alia_logo_height') && alia_option('alia_logo_height') != 0) {
			$logo_height = strval(alia_option('alia_logo_height'));
			$logo_size_att .= ' height='.strval(alia_option('alia_logo_height')).'';
			$logo_style_att .= '.site_logo_image { height : '.$logo_height.'px; }';
		}

		if ($logo_style_att != '') {
			echo '<style>';
				echo esc_attr($logo_style_att);
			echo '</style>';
		}
	?>
		<?php
		if (alia_option('alia_default_logo_retina')) {
			$is_retina_logo = " has_retina_logo";
		?>
			<a class="alia_logo retina_logo" title="<?php bloginfo( 'name' ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img <?php echo esc_attr($logo_size_att); ?> src="<?php echo alia_option('alia_default_logo_retina'); ?>" class="site_logo img-responsive site_logo_image clearfix" alt="<?php bloginfo( 'name' ); ?>" />
			</a>
		<?php } // end alia_default_logo_retina ?>

		<a class="alia_logo default_logo <?php echo esc_attr($is_retina_logo); ?>" title="<?php bloginfo( 'name' ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img <?php echo esc_attr($logo_size_att); ?> src="<?php echo alia_option('alia_default_logo'); ?>" class="site_logo img-responsive site_logo_image clearfix" alt="<?php bloginfo( 'name' ); ?>" />
		</a>
		<h1 class="screen-reader-text site_logo site-title clearfix"><?php bloginfo( 'name' ); ?></h1>

	<?php else: ?>

		<a class="square_letter_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php bloginfo( 'name' ); ?>"><?php echo mb_substr(get_bloginfo( 'name' ), 0, 1) ?></a>

	<?php endif; // end if alia_default_logo ?>
</div>
<?php endif; ?>

<?php if (alia_cross_option('alia_show_header_description', '', 1)): ?>
<div class="header_tagline">

	<?php 
		if (alia_cross_option('alia_header_description')) {
			echo alia_cross_option('alia_header_description');
		}else{
			
			$description = get_bloginfo( 'description', 'display' );

			if ( $description || is_customize_preview() ) :

				echo esc_attr($description);
			endif;
		}
	?>
</div>
<?php endif; ?>


<?php if (alia_cross_option('alia_show_header_social_icons', '', 1)): ?>
	<?php echo alia_social_icons_list('header_social_icons'); ?>
<?php endif; ?>