<?php
/**
 * The template part for header
 *
 * @package VW Travel 
 * @subpackage vw_travel
 * @since VW Travel 1.0
 */
?>
<?php if( get_theme_mod( 'vw_travel_topbar_hide_show', false) != '' || get_theme_mod( 'vw_travel_resp_topbar_hide_show', false) != '') { ?>
  <div class="container">
    <div class="lower-header">
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <?php if( get_theme_mod( 'vw_travel_location') != '') { ?>
            <p class="email-id"><i class="<?php echo esc_attr(get_theme_mod('vw_travel_location_icon','fas fa-location-arrow')); ?>"></i><?php echo esc_html(get_theme_mod('vw_travel_location',''));?></p>
          <?php }?>
        </div>
        <div class="col-lg-6 col-md-6">
          <?php if( get_theme_mod( 'vw_travel_email_address') != '') { ?>
            <p><i class="<?php echo esc_attr(get_theme_mod('vw_travel_email_addres_icon','far fa-envelope')); ?>"></i><a href="mailto:<?php echo esc_html(get_theme_mod('vw_travel_email_address',''));?>"><?php echo esc_html(get_theme_mod('vw_travel_email_address',''));?></a></p>
          <?php }?>
        </div>      
      </div>
    </div>
  </div>
<?php } ?>