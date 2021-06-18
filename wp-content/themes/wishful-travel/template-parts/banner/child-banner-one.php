<?php
/**
 * Template part for displaying banner one
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

$banner_hero_image = get_theme_mod( 'wishful_travel_banner_hero_image', '' );

$banner_hero_image_id = attachment_url_to_postid( $banner_hero_image );

$banner_hero_image_src = wp_get_attachment_image_src( $banner_hero_image_id, 'full' );

$banner_hero_text = get_theme_mod( 'wishful_travel_banner_hero_text', 'Find Your Tour' );

$banner_hero_highlight_text = get_theme_mod( 'wishful_travel_banner_hero_highlight_text', 'Destinations' );

$banner_hero_button_text = get_theme_mod( 'wishful_travel_banner_hero_button_text', 'Explore More' );

$banner_hero_button_text_link = get_theme_mod( 'wishful_travel_banner_hero_button_text_link', '#' );

$display_banner_category = get_theme_mod( 'wishful_blog_display_banner_category', 1 );

?>
<div class="lite-banner-section">
    <div class="container-fluid">
        <div class="banner-lite-slider" style="background-image: url(<?php echo esc_url( $banner_hero_image_src[0] ) ?>);">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">  
                        <div class="lite-slider-caption">
                            <div class="caption-detail">
                                <h2>
                                   <?php
                                    if( !empty( $banner_hero_text ) ) {

                                        echo esc_html( $banner_hero_text );
                                    }
                                    ?>
                                    <span>
                                        <?php
                                        if( !empty( $banner_hero_highlight_text ) ) {

                                            echo esc_html( $banner_hero_highlight_text );
                                        }
                                        ?>
                                    </span>
                                </h2>
                                <?php
                                if( !empty( $banner_hero_button_text ) ) {
                                    ?>
                                     <a href="<?php echo esc_url( $banner_hero_button_text_link ); ?>" class="button-more">
                                         <?php echo esc_html( $banner_hero_button_text ); ?>
                                     </a>
                                     <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-6"> 
                        <div class="lite-slide-wrap">
                            <?php

                            $banner_query = wishful_blog_banner_posts_query();

                            if ( $banner_query -> have_posts() ) {

                                while( $banner_query->have_posts() ) {

                                    $banner_query->the_post();

                                    ?>
                                    <div class="lite-slide">
                                       <div class="lite-content-wrap">
                                            <h3 class="entry-title">
                                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'echo' => true ) ); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>
                                            <?php

                                            the_excerpt();

                                            $button_title = get_theme_mod( 'wishful_blog_banner_button_title', esc_html__( 'Read More', 'wishful-travel' ) );

                                            if( !empty( $button_title ) ) {

                                                ?>
                                                <a href="<?php the_permalink(); ?>" class="button-more">
                                                    <?php echo esc_html( $button_title ); ?>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            wp_reset_postdata();
                            }
                            ?>
                        </div>
                    </div><!--col-lg-1-6-->
                </div>
            </div>
        </div>
    </div><!-- ///container-fluid -->
</div><!-- ///lite-banner-section -->
