<?php
/**
 * The template part for top header
 *
 * @package VW Travel 
 * @subpackage vw_travel
 * @since VW Travel 1.0
 */
?>

<div id="topbar">
  <div class="header-menu <?php if( get_theme_mod( 'vw_travel_sticky_header', false) != '' || get_theme_mod( 'vw_travel_stickyheader_hide_show', false) != '') { ?> header-sticky"<?php } else { ?>close-sticky <?php } ?>">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-2 col-md-3">
          <div class="logo">
            <?php if ( has_custom_logo() ) : ?>
              <div class="site-logo"><?php the_custom_logo(); ?></div>
            <?php endif; ?>
            <?php $blog_info = get_bloginfo( 'name' ); ?>
              <?php if ( ! empty( $blog_info ) ) : ?>
                <?php if ( is_front_page() && is_home() ) : ?>
                <?php if( get_theme_mod('vw_travel_logo_title_hide_show',true) != ''){ ?>
                  <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php } ?>
                <?php else : ?>
                  <?php if( get_theme_mod('vw_travel_logo_title_hide_show',true) != ''){ ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                  <?php } ?>
                <?php endif; ?>
              <?php endif; ?>
              <?php
                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) :
              ?>
              <?php if( get_theme_mod('vw_travel_tagline_hide_show',true) != ''){ ?>
                <p class="site-description">
                  <?php echo esc_html($description); ?>
                </p>
              <?php } ?>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-lg-8 col-md-6">
          <?php get_template_part( 'template-parts/header/navigation' ); ?>
        </div>
        <div class="col-lg-2 col-md-3">
          <?php if( get_theme_mod( 'vw_travel_phone_number') != '') { ?>
            <h6 class="phone-no"><a href="tel:<?php echo esc_url( get_theme_mod('vw_travel_phone_number','') ); ?>"><?php echo esc_html(get_theme_mod('vw_travel_phone_number',''));?></a></h6>
          <?php }?>
        </div>
      </div>
    </div>
  </div>
</div>