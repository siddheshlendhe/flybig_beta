<?php
/**
 * The template part for header
 *
 * @package VW Travel 
 * @subpackage vw_travel
 * @since VW Travel 1.0
 */
?>

<div id="header">
	<div class="row">
		<div class="<?php if( get_theme_mod( 'vw_travel_header_search',true) != '') { ?>col-lg-11 col-md-9 col-6"<?php } else { ?>col-lg-12 col-md-12 <?php } ?>">
			<?php if(has_nav_menu('primary')){ ?>
				<div class="toggle-nav mobile-menu">
				    <button role="tab" onclick="vw_travel_menu_open_nav()" class="responsivetoggle"><i class="<?php echo esc_attr(get_theme_mod('vw_travel_res_open_menu_icon','fas fa-bars')); ?>"></i><span class="screen-reader-text"><?php esc_html_e('Open Button','vw-travel'); ?></span></button>
				</div>
			<?php } ?>
			<div id="mySidenav" class="nav sidenav">
	          	<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'vw-travel' ); ?>">
		            <?php 
						if(has_nav_menu('primary')){
							wp_nav_menu( array( 
								'theme_location' => 'primary',
								'container_class' => 'main-menu clearfix' ,
								'menu_class' => 'clearfix',
								'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
								'fallback_cb' => 'wp_page_menu',
							) ); 
						} 
					?>
		            <a href="javascript:void(0)" class="closebtn mobile-menu" onclick="vw_travel_menu_close_nav()"><i class="<?php echo esc_attr(get_theme_mod('vw_travel_res_close_menus_icon','fas fa-times')); ?>"></i><span class="screen-reader-text"><?php esc_html_e('Close Button','vw-travel'); ?></span></a>
	          	</nav>
        	</div>
		</div>
		<div class="col-lg-1 col-md-3 col-6">
	        <?php if( get_theme_mod( 'vw_travel_header_search',true) != '') { ?>
		        <div class="search-box">
                  <span><a href="#"><i class="<?php echo esc_attr(get_theme_mod('vw_travel_search_icon','fas fa-search')); ?>"></i></a></span>
                </div>
	        <?php }?>
	    </div>
	</div>
	<div class="serach_outer">
      <div class="closepop"><a href="#maincontent"><i class="<?php echo esc_attr(get_theme_mod('vw_travel_search_close_icon','fa fa-window-close')); ?>"></i></a></div>
      <div class="serach_inner">
        <?php get_search_form(); ?>
      </div>
    </div>
</div>