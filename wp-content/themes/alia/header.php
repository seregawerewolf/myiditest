<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<?php echo alia_option('asalah_custom_header_code'); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<?php if (alia_option('alia_enable_sticky_header')) { ?>
		<div class="sticky_header_nav_wrapper header_nav_wrapper">
			<div class="header_nav">
				<?php
					get_template_part( 'template-parts/header/header_bar' );
				?>
			</div><!-- end .header_nav -->
		</div><!-- end .header_nav_wrapper -->
	<?php } ?>
	<div class="site_main_container">

		<header class="site_header">

			<?php if (alia_cross_option('alia_show_top_header_area', '', 1)): ?>

				<?php
				$custom_header_attr = '';
				if(get_custom_header() && get_header_image()) {
					$custom_header_attr .= ' style=background-image:url('.get_header_image().')';
				}
				?>
			<div class="gray_header" <?php echo esc_attr($custom_header_attr); ?> >
				<div class="container site_header">
					<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="header_nav_wrapper unsticky_header_nav_wrapper">
				<div class="header_nav">
					<?php
						get_template_part( 'template-parts/header/header_bar' );
					?>
				</div><!-- end .header_nav -->
			</div><!-- end .header_nav_wrapper -->
		</header>

		<main id="content" class="site-content">
