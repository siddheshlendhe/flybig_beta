<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package VW Travel
 */
?>
<footer role="contentinfo">
  <div  id="footer" class="copyright-wrapper">
    <div class="container">
      <?php
        $count = 0;
        
        if ( is_active_sidebar( 'footer-1' ) ) {
          $count++;
        }
        if ( is_active_sidebar( 'footer-2' ) ) {
          $count++;
        }
        if ( is_active_sidebar( 'footer-3' ) ) {
          $count++;
        }
        if ( is_active_sidebar( 'footer-4' ) ) {
          $count++;
        }
        // $count == 0 none
        if ( $count == 1 ) {
          $colmd = 'col-md-12 col-sm-12';
        } elseif ( $count == 2 ) {
          $colmd = 'col-md-6 col-sm-6';
        } elseif ( $count == 3 ) {
          $colmd = 'col-md-4 col-sm-4';
        } else {
          $colmd = 'col-md-3 col-sm-3';
        }
      ?>
      <div class="row">
        <div class="<?php if ( !is_active_sidebar( 'footer-1' ) ){ echo "footer_hide"; }else{ echo "$colmd"; } ?> col-xs-12 footer-block">
          <?php dynamic_sidebar('footer-1'); ?>
        </div>
        <div class="<?php if ( is_active_sidebar( 'footer-2' ) ){ echo "$colmd"; }else{ echo "footer_hide"; } ?> col-xs-12 footer-block">
          <?php dynamic_sidebar('footer-2'); ?>
        </div>
        <div class="<?php if ( is_active_sidebar( 'footer-3' ) ){ echo "$colmd"; }else{ echo "footer_hide"; } ?> col-xs-12 col-xs-12 footer-block">
          <?php dynamic_sidebar('footer-3'); ?>
        </div>
        <div class="<?php if ( !is_active_sidebar( 'footer-4' ) ){ echo "footer_hide"; }else{ echo "$colmd"; } ?> col-xs-12 footer-block">
          <?php dynamic_sidebar('footer-4'); ?>
        </div>
      </div>
    </div>
  </div>

  <div id="footer-2">
  	<div class="copyright container">
      <div class="row">
        <div class="col-lg-8 col-lg-8">
          <p><?php vw_travel_credit(); ?> <?php echo esc_html(get_theme_mod('vw_travel_footer_text',__('By VWThemes','vw-travel'))); ?></p>

          <?php if( get_theme_mod( 'vw_travel_hide_show_scroll',true) != '' || get_theme_mod( 'vw_travel_resp_scroll_top_hide_show',true) != '') { ?>
            <?php $vw_travel_theme_lay = get_theme_mod( 'vw_travel_scroll_top_alignment','Right');
            if($vw_travel_theme_lay == 'Left'){ ?>
              <a href="#" class="scrollup left"><i class="<?php echo esc_attr(get_theme_mod('vw_travel_scroll_to_top_icon','fas fa-angle-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'vw-travel' ); ?></span></a>
            <?php }else if($vw_travel_theme_lay == 'Center'){ ?>
              <a href="#" class="scrollup center"><i class="<?php echo esc_attr(get_theme_mod('vw_travel_scroll_to_top_icon','fas fa-angle-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'vw-travel' ); ?></span></a>
            <?php }else{ ?>
              <a href="#" class="scrollup"><i class="<?php echo esc_attr(get_theme_mod('vw_travel_scroll_to_top_icon','fas fa-angle-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'vw-travel' ); ?></span></a>
            <?php }?>
          <?php }?>
        </div>
        <div class="col-lg-4 col-md-4">
          <?php dynamic_sidebar('social-links'); ?>
        </div>
      </div>
  	</div>
  	<div class="clear"></div>
  </div>  
<footer>

  <?php wp_footer(); ?>

  </body>
</html>