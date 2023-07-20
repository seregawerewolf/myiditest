<?php wp_nav_menu( array(
	'container' => false,
	'theme_location' => 'top',
	'menu_id'        => 'top-menu',
	'menu_class' => 'navbar',
	'walker' => new wp_bootstrap_navwalker(),
) ); ?>