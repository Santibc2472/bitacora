<?php
/**
 * Service Section
 * 
 * @package Restaurant_and_Cafe
 */

 $restaurant_and_cafe_service_section_page = get_theme_mod('restaurant_and_cafe_service_section_page');
 $restaurant_and_cafe_service_post_one = get_theme_mod('restaurant_and_cafe_service_post_one');
 $restaurant_and_cafe_service_post_two =  get_theme_mod('restaurant_and_cafe_service_post_two');
 $restaurant_and_cafe_service_post_three = get_theme_mod('restaurant_and_cafe_service_post_three');

 $restaurant_and_cafe_favicon_one = get_theme_mod( 'restaurant_and_cafe_favicon_one',  __( 'calendar', 'restaurant-and-cafe' ) );
 $restaurant_and_cafe_favicon_two = get_theme_mod( 'restaurant_and_cafe_favicon_two',  __( 'calendar', 'restaurant-and-cafe' ) );
 $restaurant_and_cafe_favicon_three = get_theme_mod( 'restaurant_and_cafe_favicon_three',  __( 'calendar', 'restaurant-and-cafe' ) );

 ?>

 <div class="container">
	<div class="row">
		<div class="text-holder">

 		<?php 
                         
            if($restaurant_and_cafe_service_section_page){
                $service_qry = new WP_Query( array( 
                    'post_type'             => 'page',
                    'post__in'              => array( $restaurant_and_cafe_service_section_page ),
                    'post_status'           => 'publish',
                    'posts_per_page'        => -1,
                    'ignore_sticky_posts'   => true ) );

                if( $service_qry->have_posts() ){                
                    while( $service_qry->have_posts() ){
                         $service_qry->the_post();
                         the_title( '<h2 class="main-title">', '</h2>' ); 
                         the_excerpt();

                        }
                        wp_reset_postdata();
                    }
                    
                }


if( $restaurant_and_cafe_service_post_one || $restaurant_and_cafe_service_post_two || $restaurant_and_cafe_service_post_three ){

                $service_posts = array( $restaurant_and_cafe_service_post_one, $restaurant_and_cafe_service_post_two, $restaurant_and_cafe_service_post_three );
                $service_posts = array_diff( array_unique( $service_posts ), array('') );

                $restaurant_and_cafe_favicon = array( $restaurant_and_cafe_favicon_one, $restaurant_and_cafe_favicon_two, $restaurant_and_cafe_favicon_three );
                $restaurant_and_cafe_favicon = array_filter( $restaurant_and_cafe_favicon );
                
                     $service_post_qry = new WP_Query( array( 
                        'post_type'             => 'post',
                        'posts_per_page'        => -1,
                        'post__in'              => $service_posts,
                        'orderby'               => 'post__in',
                        'ignore_sticky_posts'   => true 
                    ) );
                     $x = 0;
                        if( $service_post_qry->have_posts() ){ 
                             while( $service_post_qry->have_posts() ){
                                 $service_post_qry->the_post();
                                    
                                    echo '<div class="services-holder">';
                                    
                                        echo '<div class="services">';
                                            if( isset($restaurant_and_cafe_favicon[$x] ) ){ 
                                                echo '<div class="icon-holder">';
                                                    echo '<i class ="fa fa-' . esc_attr( $restaurant_and_cafe_favicon[$x] ) .' "></i>';
                                                echo '</div>';
                                            }
                                            echo '<div class="text">';
                                                the_title( '<h3>', '</h3>' ); 
                                                the_excerpt();
                                            echo '</div>';
                                        echo '</div>';
                                      
                                    echo '</div>';

                                    $x++;
                                }
                                    wp_reset_postdata();
                              
                                }
                        }


                ?>
       
            </div>
    <?php

        if($restaurant_and_cafe_service_section_page){
                $service_qry = new WP_Query( array( 
                    'post_type'             => 'page',
                    'post__in'              => array( $restaurant_and_cafe_service_section_page ),
                    'post_status'           => 'publish',
                    'posts_per_page'        => -1,
                    'ignore_sticky_posts'   => true ) );

                if( $service_qry->have_posts() ){                
                    while( $service_qry->have_posts() ){
                         $service_qry->the_post();
                         echo '<div class="img-holder">';
                         if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'restaurant-and-cafe-service-section', array( 'itemprop' => 'image' ) );
                         }else{
                            restaurant_and_cafe_get_fallback_svg( 'restaurant-and-cafe-service-section' );
                         }
                         echo '</div>';

                        }
                    }
                    wp_reset_postdata();
                }

     ?> 
</div>
</div>
