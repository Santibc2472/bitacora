<?php
/**
 * Featured Section 
 * 
 * @package Restaurant_and_Cafe
 */
 
 $restaurant_and_cafe_featured_section_page = get_theme_mod( 'restaurant_and_cafe_featured_section_page' );
 $restaurant_and_cafe_featured_block_one = get_theme_mod( 'restaurant_and_cafe_featured_block_one' );
 $restaurant_and_cafe_featured_block_two = get_theme_mod( 'restaurant_and_cafe_featured_block_two' );
 $restaurant_and_cafe_featured_block_three = get_theme_mod( 'restaurant_and_cafe_featured_block_three' );
 $restaurant_and_cafe_button_text = get_theme_mod( 'restaurant_and_cafe_button_text', __('View Full Menu', 'restaurant-and-cafe') );
 $restaurant_and_cafe_button_url = get_theme_mod( 'restaurant_and_cafe_button_url','#' );
 ?>
 <div class= "promotional-block" >
    <div class="container">
        <?php 
            if($restaurant_and_cafe_featured_section_page){
                echo '<header class="header">';
                $featured_desc_qry = new WP_Query( array( 
                    'post_type'             => 'page',
                    'post__in'              => array( $restaurant_and_cafe_featured_section_page ),
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
        ?>
        
        <?php 
    
             if( $restaurant_and_cafe_featured_block_one && $restaurant_and_cafe_featured_block_two && $restaurant_and_cafe_featured_block_three ){
                $restaurant_and_cafe_featured_blocks = array( $restaurant_and_cafe_featured_block_one, $restaurant_and_cafe_featured_block_two, $restaurant_and_cafe_featured_block_three );
                $restaurant_and_cafe_featured_blocks = array_filter( $restaurant_and_cafe_featured_blocks );
                $featured_qry = new WP_Query( array( 
                    'post_type'             => 'post',
                    'posts_per_page'        => -1,
                    'post__in'              => $restaurant_and_cafe_featured_blocks,
                    'orderby'               => 'post__in',
                    'ignore_sticky_posts'   => true ) );

                $count = 0;
            
                if( $featured_qry->have_posts() ){
                    echo '<div class="row">';
                
                    while( $featured_qry->have_posts() ){
                        $featured_qry->the_post();
                ?>
                    <div class="col">
                        <?php
                             echo '<div class="img-holder">';
                                echo '<a href="'.  esc_url( get_permalink() )  .'" >';
                                    if( has_post_thumbnail() ){ 
                                        the_post_thumbnail( 'restaurant-and-cafe-promotional-block', array( 'itemprop' => 'image' ) ); 
                                    }else{
                                        restaurant_and_cafe_get_fallback_svg( 'restaurant-and-cafe-promotional-block' );
                                    } 
                                echo '</a>';
                            echo'</div>';
                        ?>
              
                        <div class="text-holder">
                            <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
                            <?php the_excerpt(); ?>
                        </div>
                    </div> 
                <?php
                     $count ++;
                     }
                    wp_reset_postdata();
                    echo '</div>';
                }   
            }
        ?>
    <?php  if($restaurant_and_cafe_button_url && $restaurant_and_cafe_button_text ){ ?>
        <a href="<?php echo esc_url( $restaurant_and_cafe_button_url ); ?>" class="btn-green"><?php echo esc_html( $restaurant_and_cafe_button_text ); ?></a>
    <?php } ?>
    </div>
</div>