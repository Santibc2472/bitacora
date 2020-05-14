<?php
/**
 * Reservation Section
 * 
 * @package Restaurant_and_Cafe
 */
 
 $restaurant_and_cafe_reservation_section_page = get_theme_mod( 'restaurant_and_cafe_reservation_section_page' );
 $restaurant_and_cafe_reservation_sc_text =  get_theme_mod( 'restaurant_and_cafe_reservation_sc_text' );
 echo '<div class="container">';
 	
 	if($restaurant_and_cafe_reservation_section_page){
    echo '<header class="header">';
                $featured_desc_qry = new WP_Query( array( 
                    'post_type'             => 'page',
                    'post__in'              => array( $restaurant_and_cafe_reservation_section_page ),
                    'post_status'           => 'publish',
                    'posts_per_page'        => -1,
                    'ignore_sticky_posts'   => true ) );

                if( $featured_desc_qry->have_posts() ){                
                    while( $featured_desc_qry->have_posts() ){
                        $featured_desc_qry->the_post();
                         the_title( '<h2 class="main-title">', '</h2>' ); 
                         the_excerpt();

                    } 
                    wp_reset_postdata();
                }
    echo '</header>';
    }
	
		if( restaurant_and_cafe_cf7_activated() && $restaurant_and_cafe_reservation_sc_text ){
	 		echo do_shortcode("$restaurant_and_cafe_reservation_sc_text"); 
        } 
 echo '</div>';