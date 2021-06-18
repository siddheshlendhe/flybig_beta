<?php
/**
 * VW Travel: Block Patterns
 *
 * @package VW Travel
 * @since   1.0.0
 */

/**
 * Register Block Pattern Category.
 */
if ( function_exists( 'register_block_pattern_category' ) ) {

	register_block_pattern_category(
		'vw-travel',
		array( 'label' => __( 'VW Travel', 'vw-travel' ) )
	);
}

/**
 * Register Block Patterns.
 */
if ( function_exists( 'register_block_pattern' ) ) {
	register_block_pattern(
		'vw-travel/banner-section',
		array(
			'title'      => __( 'Banner Section', 'vw-travel' ),
			'categories' => array( 'vw-travel' ),
			'content'    => "<!-- wp:cover {\"url\":\"" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/banner.png\",\"id\":6593,\"align\":\"full\",\"className\":\"banner-section\"} -->\n<div class=\"wp-block-cover alignfull has-background-dim banner-section\" style=\"background-image:url(" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/banner.png)\"><div class=\"wp-block-cover__inner-container\"><!-- wp:columns {\"align\":\"full\"} -->\n<div class=\"wp-block-columns alignfull\"><!-- wp:column {\"width\":\"25%\"} -->\n<div class=\"wp-block-column\" style=\"flex-basis:25%\"></div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"verticalAlignment\":\"center\",\"width\":\"50%\"} -->\n<div class=\"wp-block-column is-vertically-aligned-center\" style=\"flex-basis:50%\"><!-- wp:heading {\"textAlign\":\"center\",\"level\":1,\"className\":\"m-0\"} -->\n<h1 class=\"has-text-align-center m-0\">Lorem ipsum dolor sit amet consectetur</h1>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"align\":\"center\",\"className\":\"text-center m-0\"} -->\n<p class=\"has-text-align-center text-center m-0\">Lorem Ipsum has been the industry standard. Lorem Ipsum has been the industrys standard.&nbsp;Lorem Ipsum has been the industry standard.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons {\"align\":\"center\",\"className\":\"mt-2\"} -->\n<div class=\"wp-block-buttons aligncenter mt-2\"><!-- wp:button {\"borderRadius\":50,\"style\":{\"color\":{\"background\":\"#ffe21c\",\"text\":\"#222222\"}}} -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link has-text-color has-background\" style=\"border-radius:50px;background-color:#ffe21c;color:#222222\">View Tours</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"width\":\"25%\"} -->\n<div class=\"wp-block-column\" style=\"flex-basis:25%\"></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns --></div></div>\n<!-- /wp:cover -->",
		)
	);

	register_block_pattern(
		'vw-travel/services-section',
		array(
			'title'      => __( 'Services Section', 'vw-travel' ),
			'categories' => array( 'vw-travel' ),
			'content'    => "<!-- wp:cover {\"overlayColor\":\"white\",\"align\":\"full\",\"className\":\"article-outer-box\"} -->\n<div class=\"wp-block-cover alignfull has-white-background-color has-background-dim article-outer-box\"><div class=\"wp-block-cover__inner-container\"><!-- wp:heading {\"textAlign\":\"center\",\"style\":{\"color\":{\"text\":\"#222222\"}}} -->\n<h2 class=\"has-text-align-center has-text-color\" style=\"color:#222222\">Explore Top Destinations</h2>\n<!-- /wp:heading -->\n\n<!-- wp:columns {\"align\":\"wide\"} -->\n<div class=\"wp-block-columns alignwide\"><!-- wp:column {\"className\":\"article-inner-box\"} -->\n<div class=\"wp-block-column article-inner-box\"><!-- wp:image {\"id\":6603,\"sizeSlug\":\"large\",\"linkDestination\":\"media\"} -->\n<figure class=\"wp-block-image size-large\"><img src=\"" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/services1.png\" alt=\"\" class=\"wp-image-6603\"/></figure>\n<!-- /wp:image -->\n\n<!-- wp:group {\"className\":\"article-box-content\"} -->\n<div class=\"wp-block-group article-box-content\"><div class=\"wp-block-group__inner-container\"><!-- wp:heading {\"level\":3,\"textColor\":\"black\"} -->\n<h3 class=\"has-black-color has-text-color\">Destination Name 01</h3>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color\">Category Title 1</p>\n<!-- /wp:paragraph --></div></div>\n<!-- /wp:group --></div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"className\":\"article-inner-box\"} -->\n<div class=\"wp-block-column article-inner-box\"><!-- wp:image {\"id\":6605,\"sizeSlug\":\"large\",\"linkDestination\":\"media\"} -->\n<figure class=\"wp-block-image size-large\"><img src=\"" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/services2.png\" alt=\"\" class=\"wp-image-6605\"/></figure>\n<!-- /wp:image -->\n\n<!-- wp:group {\"className\":\"article-box-content\"} -->\n<div class=\"wp-block-group article-box-content\"><div class=\"wp-block-group__inner-container\"><!-- wp:heading {\"level\":3,\"textColor\":\"black\"} -->\n<h3 class=\"has-black-color has-text-color\">Destination Name 02</h3>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color\">Category Title 2</p>\n<!-- /wp:paragraph --></div></div>\n<!-- /wp:group --></div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"className\":\"article-inner-box\"} -->\n<div class=\"wp-block-column article-inner-box\"><!-- wp:image {\"id\":6606,\"sizeSlug\":\"large\",\"linkDestination\":\"media\"} -->\n<figure class=\"wp-block-image size-large\"><img src=\"" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/services3.png\" alt=\"\" class=\"wp-image-6606\"/></figure>\n<!-- /wp:image -->\n\n<!-- wp:group {\"className\":\"article-box-content\"} -->\n<div class=\"wp-block-group article-box-content\"><div class=\"wp-block-group__inner-container\"><!-- wp:heading {\"level\":3,\"textColor\":\"black\"} -->\n<h3 class=\"has-black-color has-text-color\">Destination Name 03</h3>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"textColor\":\"black\"} -->\n<p class=\"has-black-color has-text-color\">Category Title 3</p>\n<!-- /wp:paragraph --></div></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns --></div></div>\n<!-- /wp:cover -->",
		)
	);
}