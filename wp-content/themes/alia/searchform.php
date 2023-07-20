<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	<label for="<?php echo esc_attr($unique_id); ?>">
		<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'alia' ); ?></span>
	</label>

	<input type="search" id="<?php echo esc_attr($unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'alia' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
	<input type="hidden" name="post_type" value="post" />
	<input type="submit" class="search_submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit', 'alia' ); ?>" />
</form>
