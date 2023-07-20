<?php
/**
 * The Sidebar containing the main widget area
 *
 * @since Iceberg 1.0
 */
?>

<div id="sidebar" class="sidebar">

    <?php 
    $primary_navigation = wp_nav_menu( array( 
        'theme_location'  => 'primary', 
        'menu_class'      => 'nav-menu', 
        'container'       => false,
        'echo'            => false
    ) ); 
    ?>

    <header id="musthead" class="site-header">

        <div class="site-identity">

            <?php iceberg_site_identity(); ?>
            <?php iceberg_custom_text( 'tagline', '<div class="tagline">', '</div>' ); ?>

        </div>

        <?php 
            if( function_exists( 'nsafb_social_profiles' ) ) {
                nsafb_social_profiles( '<div class="entry-social-profiles">', '</div>' ); 
            }
        ?>

        <?php if( $primary_navigation || is_active_sidebar( 'widget-area' ) ) : ?>
            <div class="toggles">
                <a href="#" id="sidebar-toggle" class="sidebar-toggle"><?php iceberg_the_theme_svg( 'menu' ); ?></a>
            </div>
        <?php endif; ?>

    </header>

    <?php if( $primary_navigation || is_active_sidebar( 'widget-area' ) ) : ?>

    <div class="toggle-wrap">

        <?php 
        if( $primary_navigation )
            printf( '<nav id="primary-navigation" class="primary-navigation">%s</nav>', $primary_navigation );
        
        if( is_active_sidebar( 'widget-area' ) ) : ?>

            <div id="widget-area" class="widget-area" role="complementary">
                <?php dynamic_sidebar( 'widget-area' ); ?>
            </div>

        <?php endif; ?>

        <?php 
        iceberg_custom_text( 
            'copyright', 
            '<footer id="colophon" class="site-footer"><div class="site-copyright">', 
            '</div></footer>', 
            sprintf( '&copy; %1$d <a href="%2$s">%3$s</a>', date('Y'), esc_url( home_url( '/' ) ), esc_html( get_bloginfo( 'name' ) ) ) 
        ); 
        ?>

    </div><!-- .toggle-wrap -->

    <?php endif; ?>

</div>