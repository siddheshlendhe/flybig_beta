<?php
/**
 * Template part for displaying child header one
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */
?>
<header>
    <div class="lite-topbar">
        <div class="container-fluid top-header">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="topbar-info">
                        <?php

                        $email = get_theme_mod( 'wishful_travel_child_theme_email', 'youremail@domain.com' );

                        if( !empty( $email ) ) {

                            ?>
                            <a href="<?php esc_url( 'mailto:' . sanitize_email( $email ) ); ?>"><?php echo sanitize_email( $email ); ?></a>
                            <?php
                        }

                        $phone_number = get_theme_mod( 'wishful_travel_child_theme_number', '666 6666 666' );

                        if( !empty( $phone_number ) ) {

                            ?>
                            <a href="tel:<?php echo esc_attr( $phone_number ); ?>"><?php echo esc_html( $phone_number ); ?></a>
                            <?php
                        }

                        $address = get_theme_mod( 'wishful_travel_child_theme_address', 'Street, Country' );
                        $address_link = get_theme_mod( 'wishful_travel_child_theme_address_link', '#' );

                        if( !empty( $address ) ) {

                            ?>
                            <a href="<?php echo esc_url( $address_link ); ?>"><?php echo esc_html( $address ); ?></a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <?php
                    //template-functions for social links
                    wishful_blog_header_social_links_template('header');
                    ?>
                </div>
            </div>
        </div><!-- Container /- -->
    </div><!-- lite-topbar /- -->
    <div class="lite-menu">
        <div class="container-fluid  menu-block"> 
            <div class="row">
                <div class="col-lg-4 logo-block"> 
                    <?php
                    the_custom_logo();
                    if ( is_front_page() && is_home() ) :
                        ?>
                        <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php
                    else :
                        ?>
                        <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title"><?php bloginfo( 'name' ); ?></a></p>
                        <?php
                    endif;
                    $wishful_blog_description = get_bloginfo( 'description', 'display' );
                    if ( $wishful_blog_description || is_customize_preview() ) :
                        ?>
                        <p class="site-description"><?php echo $wishful_blog_description; /* WPCS: xss ok. */ ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-8"> 
                    <div class="primary-navigation-wrap">
                    <button class="menu-toggle"> 
                        <span class="hamburger-bar"></span> 
                        <span class="hamburger-bar"></span> 
                        <span class="hamburger-bar"></span>
                    </button><!-- .menu-toggle -->
                        <nav id="site-navigation" class="site-navigation">
                            <?php
                            wp_nav_menu( array(
                                'theme_location' => 'menu-1',
                                'container'      => '',
                                'menu_class'     => 'primary-menu nav-menu',
                                'depth'          => 3,
                                'fallback_cb'    => 'wishful_blog_navigation_fallback',
                            ) );
                            ?>
                        </nav>
                    </div><!-- // primary-navigation-wrap -->
                </div>
            </div><!-- Container /- -->
        </div>
    </div>
</header>

