<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 */
?><!doctype html>

    <html <?php language_attributes(); ?>>

        <head>

          <meta charset="<?php bloginfo( 'charset' ); ?>" />
          <meta name="viewport" content="width=device-width, initial-scale=1" />
          <link rel="profile" href="https://gmpg.org/xfn/11" />
          <?php wp_head(); ?>

        </head>

        <body <?php body_class(); ?>>

            <?php wp_body_open(); ?>

            <div class="preloader">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>

            <div id="page" class="hfeed site container">

                <div class="wrapper">

                    <?php get_sidebar(); ?>

                    <div id="content" class="site-content">