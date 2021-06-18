<?php
/**
 * Template Name: Custom Home Page
 */

get_header(); ?>

<main id="maincontent" role="main">
  <?php do_action( 'vw_travel_before_slider' ); ?>

  <?php if( get_theme_mod( 'vw_travel_slider_arrows', false) != '' || get_theme_mod( 'vw_travel_resp_slider_hide_show', false) != '') { ?>
    <section id="slider">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="<?php echo esc_attr(get_theme_mod( 'vw_travel_slider_speed',3000)) ?>"> 
        <?php $vw_travel_pages = array();
          for ( $count = 1; $count <= 4; $count++ ) {
            $mod = intval( get_theme_mod( 'vw_travel_slider_page' . $count ));
            if ( 'page-none-selected' != $mod ) {
              $vw_travel_pages[] = $mod;
            }
          }
          if( !empty($vw_travel_pages) ) :
            $args = array(
              'post_type' => 'page',
              'post__in' => $vw_travel_pages,
              'orderby' => 'post__in'
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              $i = 1;
        ?>     
        <div class="carousel-inner" role="listbox">
          <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
              <?php the_post_thumbnail(); ?>
              <div class="carousel-caption">
                <div class="inner_carousel">
                  <h1><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                  <p><?php $excerpt = get_the_excerpt(); echo esc_html( vw_travel_string_limit_words( $excerpt, esc_attr(get_theme_mod('vw_travel_slider_excerpt_number','30')))); ?></p>
                  <?php if( get_theme_mod('vw_travel_slider_button_text','View Tours') != ''){ ?>
                    <div class="more-btn">
                      <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_theme_mod('vw_travel_slider_button_text',__('View Tours','vw-travel')));?><?php if(get_theme_mod('vw_travel_blog_button_icon',true) ){ ?><i class="<?php echo esc_attr(get_theme_mod('vw_travel_slider_button_icon','fas fa-long-arrow-alt-right')); ?>"></i><?php }?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('vw_travel_slider_button_text',__('View Tours','vw-travel')));?></span></a>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php $i++; endwhile; 
          wp_reset_postdata();?>
        </div>
        <?php else : ?>
            <div class="no-postfound"></div>
        <?php endif;
        endif;?>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
          <span class="screen-reader-text"><?php esc_html_e( 'Previous','vw-travel' );?></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
          <span class="screen-reader-text"><?php esc_html_e( 'Next','vw-travel' );?></span>
        </a>
      </div>
      <div class="clearfix"></div>
    </section>
  <?php } ?>

  <?php do_action( 'vw_travel_after_slider' ); ?>

  <?php if( get_theme_mod( 'vw_travel_post_hide_show') != '') { ?>
    <section id="top-destination">
      <div class="container">
        <?php if( get_theme_mod( 'vw_travel_section_title') != '') { ?>
          <h2><?php echo esc_html(get_theme_mod('vw_travel_section_title',''));?></h2>
        <?php }?>
        <div class="row">
          <?php
            $args = array(
              'post_type' => 'post',
              'posts_per_page' => get_theme_mod('vw_travel_top_destination_number')
            );
            $i=1;
            $query = new WP_Query($args); 
            if ( $query->have_posts() ) :  while ($query->have_posts()) : $query->the_post(); ?>
            <div class="col-md-4 col-sm-6">
              <div class="box">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();?><span class="screen-reader-text"><?php the_title(); ?></span></a>
                <div class="box-content">
                  <div class="content">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a></h3>
                  </div>
                  <?php the_category(); ?>
                </div>
              </div>
            </div>
          <?php $i++;  endwhile; endif;?>
        </div>
      </div>
    </section>
  <?php }?>

  <?php do_action( 'vw_travel_after_second_section' ); ?>

  <div class="content-vw">
    <div class="container">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>
