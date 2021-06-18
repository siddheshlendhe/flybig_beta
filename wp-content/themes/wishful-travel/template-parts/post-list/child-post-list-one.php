<?php
/**
 * Template part for displaying post lists
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

$sidebar_position = wishful_blog_sidebar_position();

?>
<div id="content" class="lite-blog-list">
    <div class="container">
        <div class="row justify-content-center">
            <?php

            if( $sidebar_position == 'left' ) {
                get_sidebar();
            }
            ?>
            <div class="col-lg-8 col-12 widget-listing">
                <?php

                if( have_posts() ) :

                    /* Start the Loop */
                    while ( have_posts() ) :

                        the_post();

                        $display_category = wishful_blog_post_list_category_meta();
                        $display_author = wishful_blog_post_list_author_meta();
                        $display_date = wishful_blog_post_list_date_meta();
                        $readmore_text = wishful_blog_post_list_read_text();
                        $post_style = wishful_blog_post_listing_style();
                        $post_style_class = wishful_blog_post_listing_style_class();

                        ?>
                        <div id="post-<?php the_ID(); ?>" class="lite-blog">
                            <div class="entry-cover">
                                <div class="lite-blog-img">
                                    <figure>
                                        <?php

                                        if( has_post_thumbnail() ) {

                                            the_post_thumbnail( 'wishful-blog-thumbnail-two', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) );

                                        } else {

                                            wishful_blog_fallback_image( 'img', 'two' );
                                        }

                                        ?>
                                    </figure>
                                    <?php wishful_blog_posted_date( $display_date ); ?>
                                    <div class="post-meta">
                                       <?php wishful_blog_posted_by( $display_author ); ?>
                                    </div><!--post meta-->
                                </div>
                                <?php wishful_blog_category_list( $display_category ); ?>
                                <div class="lite-content-wrap">
                                    <h3 class="entry-title">
                                       <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'echo' => true ) ); ?>">
                                        <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <?php

                                    the_excerpt();

                                    if( !empty( $readmore_text ) ) {

                                        ?>
                                        <a class="<?php do_action( 'pro_button_style' ); ?>" href="<?php the_permalink(); ?>">
                                            <?php echo esc_html( $readmore_text ); ?></a>
                                        <?php
                                    }
                                    ?>
                                </div><!--lite-content-wrap-->
                            </div>
                        </div><!---// blog listing-->
                        <?php

                    endwhile;

                else :

                    get_template_part( 'template-parts/content', 'none' );

            endif;

            wishful_blog_pagination();

            ?>
            </div>
            <?php

            if( $sidebar_position == 'right' ) {
                get_sidebar();
            }
            ?>
        </div>
    </div><!---// container-->
</div><!---// lite-blog-list-->
