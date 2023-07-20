<?php

define('WP_USE_THEMES', false);
$wpdir = explode( "wp-content" , __FILE__ );
require $wpdir[0] . "wp-load.php";

if (isset($_POST['cookiesnoticestatus']) && $_POST['cookiesnoticestatus'] == "accepted") {
	if (is_user_logged_in()) {
		update_user_meta(get_current_user_id(), 'alia_cookies_accepted', 1);
	}else{
		setcookie('alia_cookies_accepted', 1, time() + ( 365 * 24 * 60 * 60) );
	}
}elseif (isset($_POST['cookiesnoticestatus']) && $_POST['cookiesnoticestatus'] == "shownotice" && !alia_cookies_accepted() && alia_option('alia_show_cookies_notice', 0) && alia_option('alia_cookies_description_text', '') != '') {
		?>
		<div class="alia_cookies_notice_wrapper">
			<div class="alia_cookies_notice">


				<?php if ( alia_option('alia_show_cookies_icon', 1) ): ?>
					<?php 
						if (alia_option('alia_cookies_icon_class', '') != '') {
							$cookies_icon_class = '<i class="cookies_bar_icon '.alia_option('alia_cookies_icon_class', '').'"></i>';
						}else{
							$cookies_icon_class = '<i class="cookies_bar_icon fas fa-cookie-bite"></i>';
						}
					?>
					<div class="cookies_icons"><?php echo $cookies_icon_class; ?></div>
				<?php endif; ?>	

				<?php if (alia_option('alia_cookies_title', '') != ''): ?>
					<h3 class="title alia_cookies_title"><?php echo alia_option('alia_cookies_title', ''); ?></h3>
				<?php endif; ?>

				<p class="alia_cookis_description"><?php echo alia_option('alia_cookies_description_text', ''); ?></p>
				<div class="alia_cookie_accept_area">

					<?php if (alia_option('alia_cookies_links_text', '') != ''): ?>
						<span class="cookies_accept_links"><?php echo alia_option('alia_cookies_links_text', '');; ?></span>
					<?php endif; ?>

					<span class="cookies_accept_button"><?php esc_attr_e('I Agree', 'alia'); ?></span>
				</div>
			</div>
		</div>
		<?php
}
?>