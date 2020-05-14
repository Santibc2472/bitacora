<?php
/**
 * Tabmenu Section
 * 
 * @package Restaurant_and_Cafe
 */


 $restaurant_and_cafe_tabmenu_section_page = get_theme_mod( 'restaurant_and_cafe_tabmenu_section_page' );
 $restaurant_and_cafe_tabmenu_section_cat_one = get_theme_mod( 'restaurant_and_cafe_tabmenu_section_cat_one' );
 $restaurant_and_cafe_tabmenu_section_cat_two = get_theme_mod( 'restaurant_and_cafe_tabmenu_section_cat_two' );
 $restaurant_and_cafe_tabmenu_section_cat_three = get_theme_mod( 'restaurant_and_cafe_tabmenu_section_cat_three' );
 $restaurant_and_cafe_tabmenu_section_cat_four = get_theme_mod( 'restaurant_and_cafe_tabmenu_section_cat_four' );
 $restaurant_and_cafe_tabmenu_section_cat_five = get_theme_mod( 'restaurant_and_cafe_tabmenu_section_cat_five' );

 if( restaurant_and_cafe_woocommerce_activated() && ( $restaurant_and_cafe_tabmenu_section_cat_one || $restaurant_and_cafe_tabmenu_section_cat_two || $restaurant_and_cafe_tabmenu_section_cat_three || $restaurant_and_cafe_tabmenu_section_cat_four || $restaurant_and_cafe_tabmenu_section_cat_five ) ){
    
     $product_categories = array( $restaurant_and_cafe_tabmenu_section_cat_one, $restaurant_and_cafe_tabmenu_section_cat_two, $restaurant_and_cafe_tabmenu_section_cat_three, $restaurant_and_cafe_tabmenu_section_cat_four, $restaurant_and_cafe_tabmenu_section_cat_five );
     $product_categories = array_diff( array_unique( $product_categories ), array('') );

 
 echo '<div class="container">';
 	
	if($restaurant_and_cafe_tabmenu_section_page){
		echo '<header class="header">';
            $tab_qry = new WP_Query( array( 
                'post_type'             => 'page',
                'post__in'              => array( $restaurant_and_cafe_tabmenu_section_page ),
                'post_status'           => 'publish',
                'posts_per_page'        => -1,
                'ignore_sticky_posts'   => false ) );

            if( $tab_qry->have_posts() ){                
                while( $tab_qry->have_posts() ){
                 $tab_qry->the_post();
                 the_title( '<h2 class="main-title">', '</h2>' ); 
                 the_excerpt();

                }
                wp_reset_postdata();
                }
                
        echo'</header>';
    }
    

	$counter = 1;
	$args = array(
      'orderby' => 'include',
    	'number'  => 5,
	    'include' => $product_categories,
	);
	$terms = get_terms( 'product_cat', $args ); 

    	echo '<ul class="tabs">';
    	foreach ( $terms as $t ) {     
			if($counter == 1){
				echo '<button id="tab-'. esc_attr( $counter ) . ' " class = "active">' . esc_html( $t->name ) . '</button>';
			}else{
 				echo '<button id="tab-'. esc_attr( $counter ) .' ">' . esc_html( $t->name ) . '</button>';
			}
			$counter++;
     	}
     	echo '</ul>';
	wp_reset_postdata();

	/******************* for tabber body ***************************/

  
  	$product_categories = get_terms( 'product_cat', $args );
  	$counter1 = 0;
	foreach ( $product_categories as $product_category ) {
  		$args = array(
        'posts_per_page' => 10,
        'tax_query' => array(
          	array(
              	'taxonomy' => 'product_cat',
              	'field' => 'slug',
              	'terms' => $product_category->slug
          	)
        ),
        'post_type' => 'product',
        'orderby' => 'title',
      );
		
		$counter1++;
		$products = new WP_Query( $args ); ?>
		<div class="tab-content" id="content-<?php echo esc_attr( $counter1 );  ?>">
			<div class="row">
			<?php 
				 while ( $products->have_posts() ) {
            $products->the_post(); ?>
					<div class="col">
						<div class="holder">
							<div class="img-holder">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php 
                  if (has_post_thumbnail( $products->post->ID )){
                      the_post_thumbnail('thumbnail', array( 'itemprop' => 'image' ));
                  }else{ ?>
                      <img src="<?php echo esc_url( wc_placeholder_img_src() ); ?> " alt="<?php the_title_attribute(); ?>" itemprop="image" />
                  <?php } ?>
                </a>
							</div>
							<div class="text-holder">
								<div class="heading">
									<h3><a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
									<?php 
                    global $product;
                    if ( $price_html = $product->get_price_html() ) : ?>
                    <span class="price"><?php echo wp_kses_post( $price_html ); ?></span>
									<?php endif;?>
								</div>
                  <?php the_excerpt(); ?>
							</div>
							<?php woocommerce_template_loop_add_to_cart( $products->post, $product ); ?>
					   </div><!-- /span3 -->
					</div>
			<?php 
				 } 
				 wp_reset_postdata(); 
			?>
			</div>
 		</div>
	<?php } 
echo '</div>';

}


