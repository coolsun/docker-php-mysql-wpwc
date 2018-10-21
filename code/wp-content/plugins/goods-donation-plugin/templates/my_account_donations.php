<?php
	//$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	global $wp;
	$paged = end(explode("/", home_url( $wp->request )));
    // echo $paged;
	global $wp_query; 
	$original_query = $wp_query;

	$current_user = wp_get_current_user();
	$donee = $current_user->user_login;
	$args = array( 
			'post_type' => 'product',
			'orderby' => 'date',
            'order' => 'DESC',	
			'posts_per_page' => 20,
			'paged' => $paged
			);
	$loop = new WP_Query( $args );
	$wp_query = $loop;
	add_filter('woocommerce_product_add_to_cart_text', 
				function() {return __('Donate This', 'woocommerce');}, 11); ?>

	<h2>Donate Products</h2>
	<table><tr><th>Sale</th><th>Image</th><th>Name</th><th class="text-center">Price</th><th class="text-center">Actions</th></tr>
	<?php 
	if ( $loop->have_posts() ) :
		while ( $loop->have_posts() ) : $loop->the_post(); global $product;  ?>
				<?php //echo "<a href=\"" . get_permalink( $loop->post->ID ) . "\" title=\"" . esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID) . "\">"; ?>
				<tr>
					<td><?php woocommerce_show_product_sale_flash( $loop->post, $product );?>
					</td>
					<td><?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, array(45, 45));
							else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="45px" height="45px" />'; ?>
					</td>
					<td><?php the_title( '<h4>', '</h4>' ); ?>
					</td>
					<td class="text-center"><span class="price"><?php echo $product->get_price_html(); ?></span></td>
					<?php /* if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); */ ?>
					<?php // echo "</a>"; ?>
					<td class="text-center"><input type="checkbox" id="<?php echo $loop->post->ID; ?>" value="<?php echo $donee;?>"
				     <?php echo (has_term($donee, "Donees", $loop->post)?"checked":"");?> onClick="<?php echo "toggleCheckbox(this)";?>" /> Accept Donations
					</td>
		
		<?php endwhile; ?>
				<tr>
					<td colspan="5" class="text-center"><?php 	the_posts_pagination(); ?>
					</td>
				</tr>
		</table>	
		<!-- End of the main loop -->
	<?php else : ?>
		 <?php _e('Sorry, no products are found.'); ?> 
	<?php endif; ?>	
	<?php 
	wp_reset_postdata();
	$wp_query = $original_query;
	remove_filter( 'woocommerce_product_add_to_cart_text', function(){} );

	
