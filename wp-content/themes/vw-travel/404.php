<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package VW Travel
 */

get_header(); ?>

<main id="maincontent" role="main" class="content-vw">
	<div class="container">
		<div class="page-content">
	    	<h1><?php echo esc_html(get_theme_mod('vw_travel_404_page_title',__('404 Not Found','vw-travel')));?></h1>
			<p class="text-404"><?php echo esc_html(get_theme_mod('vw_travel_404_page_content',__('Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.','vw-travel')));?></p>
			<?php if( get_theme_mod('vw_travel_404_page_button_text','Go Back') != ''){ ?>
				<div class="more-btn">
			        <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_theme_mod('vw_travel_404_page_button_text',__('Go Back','vw-travel')));?><?php if(get_theme_mod('vw_travel_404_page_button_icon',true) ){ ?><i class="<?php echo esc_attr(get_theme_mod('vw_travel_404_page_button_icon','fas fa-long-arrow-alt-right')); ?>"></i><?php }?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('vw_travel_404_page_button_text',__('Go Back','vw-travel')));?></span></a>
			    </div>
			<?php } ?>
		</div>
		<div class="clearfix"></div>
	</div>
</main>

<?php get_footer(); ?>