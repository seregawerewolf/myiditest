<form class="search clearfix animated searchHelperFade" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<input class="col-md-12 search_text" id="appendedInputButton" placeholder="<?php esc_attr_e( 'Hit enter to search', 'alia' ); ?>" type="text" name="s" autocomplete="off">
	<div class="search_form_icon">
		<i class="fa fa-search header_control_icon"></i>
		<input type="hidden" name="post_type" value="post" />
		<input type="submit" class="search_submit" id="searchsubmit" value="" />
	</div>
</form>
