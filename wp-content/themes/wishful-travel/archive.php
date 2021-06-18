<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Wishful_Travel
 */

get_header();

    /*
    * Hook for active pro archive top widget area - 10
    */
    do_action( 'is_active_pro_archive_top_widget_area' );

    ?>
   <!-- archive-title -->
     <div class="container">
        <div class="block-title container-fluid archive-block">
        <?php

        the_archive_title( '<h1 class="page-title">', '</h1>' );

        the_archive_description( '<div class="archive-description">', '</div>' );

        ?>
        </div><!-- archive-title /-->
    </div><!-- container /-->

    <?php

    $enable_child_theme_post_listing = get_theme_mod( 'wishful_travel_enable_child_theme_archive_post_listing', true );

    if( $enable_child_theme_post_listing ) {

        get_template_part( 'template-parts/post-list/child-post-list', 'one' );

    } else {

        wishful_blog_post_layout_template();
    }

get_footer();
