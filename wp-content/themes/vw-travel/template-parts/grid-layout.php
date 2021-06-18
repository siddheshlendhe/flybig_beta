<?php
/**
 * The template part for displaying grid post
 *
 * @package VW Travel
 * @subpackage vw-travel
 * @since VW Travel 1.0
 */
?>

<div class="col-lg-4 col-md-6">
	<article id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
	    <div class="post-main-box">
	      	<div class="box-image">
	          	<?php 
		            if(has_post_thumbnail()) { 
		              the_post_thumbnail(); 
		            }
	          	?>
	        </div>
	        <h2 class="section-title"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title();?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2>
	        <div class="new-text">
	        	<div class="entry-content">
	        		<p> 
			          <?php $excerpt = get_the_excerpt(); echo esc_html( vw_travel_string_limit_words( $excerpt, esc_attr(get_theme_mod('vw_travel_excerpt_number','30')))); ?> <?php echo esc_html( get_theme_mod('vw_travel_excerpt_suffix','') ); ?>
			        </p>
	        	</div>
	        </div>
	        <?php if( get_theme_mod('vw_travel_button_text','READ MORE') != ''){ ?>
	          	<div class="more-btn">
		        	<a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_theme_mod('vw_travel_button_text',__('READ MORE','vw-travel')));?><?php if(get_theme_mod('vw_travel_blog_button_icon',true) ){ ?><i class="<?php echo esc_attr(get_theme_mod('vw_travel_blog_button_icon','fas fa-long-arrow-alt-right')); ?>"></i><?php }?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('vw_travel_button_text',__('READ MORE','vw-travel')));?></span></a>
		      	</div>
	        <?php } ?>
	    </div>
	    <div class="clearfix"></div>
  	</article>
</div>