<?php
/**
 * Plugin Name: List WooCommerce Products by tags
 * Plugin URI: http://www.remicorson.com/list-woocommerce-products-by-tags/
 * Description: List WooCommerce products using a simple shortcode, eg: [woo_products_by_tags tags="shoes,socks"]
 * Version: 1.0
 * Author: David Royo
 * Author URI: https://davidroyo.com
 * Requires at least: 3.5
 * Tested up to: 3.5
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: -
 * Domain Path: -
 *
 *
 * List products by tags is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * List products by tags is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 *
 */

/*
 * List WooCommerce Products by tags
 *
 * ex: [woo_products_by_tags tags="shoes,socks"]
 */
function woo_products_by_tags_shortcode( $atts, $content = null ) {

	// Get attribuets
	extract(shortcode_atts(array(
		"tags" => ''
	), $atts));

	ob_start();

	// Define Query Arguments
	$args = array(
				'post_type' 	 => 'product',
				'posts_per_page' => 5,
				'product_tag' 	 => $tags
				);

	// Create the new query
	$loop = new WP_Query( $args );
    $product = new WC_Product($loop->post->ID);

	// Get products number
	$product_count = $loop->post_count;

	// If results
	if( $product_count > 0 ) :

		echo '<ul class="products">';

			// Start the loop
			while ( $loop->have_posts() ) : $loop->the_post(); global $product;

				global $post;

                echo("<div style='display:inline-block'>");
				if (has_post_thumbnail( $loop->post->ID )) {
                    echo "<a href='".get_permalink($the)."'>";
                    echo  get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
                    echo "</a>";
                }
				else {
                    echo '<img src="'.$woocommerce->plugin_url().'/assets/images/placeholder.png" alt="" width="'.$woocommerce->get_image_size('shop_catalog_image_width').'px" height="'.$woocommerce->get_image_size('shop_catalog_image_height').'px" />';
                }


                echo "<figcaption class='woocom-list-content'>";
                echo "<a href='".get_permalink($the)."'><h4 class='entry-title'>" . $thePostID = $post->post_title. " </h4></a>";
                echo "<span class='price'>" . number_format($product->get_price(), 2, ',', '.');

                echo "€</span>";
                echo "</figcaption>";

                echo("</div>");
			endwhile;

		echo '</ul><!--/.products-->';

	else :

		_e('No product matching your criteria.');

	endif; // endif $product_count > 0

	return ob_get_clean();

}

add_shortcode("woo_products_by_tags", "woo_products_by_tags_shortcode");
