<?php
/**
 * Testimonial Section
 * 
 * @package Restaurant_and_Cafe
 */
$restaurant_and_cafe_testimonial_section_page = get_theme_mod( 'restaurant_and_cafe_testimonial_section_page' );
$restaurant_and_cafe_testimonial_section_cat = get_theme_mod( 'restaurant_and_cafe_testimonial_section_cat' );
$restaurant_and_cafe_testimonial_caption = get_theme_mod( 'restaurant_and_cafe_testimonial_caption' );

echo '<div class="container">';

if($restaurant_and_cafe_testimonial_section_page){
    echo '<header class="header">' ;
    $tab_qry = new WP_Query( array( 
        'post_type'             => 'page',
        'post__in'              => array( $restaurant_and_cafe_testimonial_section_page ),
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
       echo '</header>';
   }
}

if( $restaurant_and_cafe_testimonial_section_cat ){
    $testimonial_qry = new WP_Query( array( 'cat' => $restaurant_and_cafe_testimonial_section_cat, 'posts_per_page' => -1, 'ignore_sticky_posts'   => true ) );
    if( $testimonial_qry->have_posts() ){
        ?>
        <div class="testimonial-holder">
          <div class="holder">
             <ul id="testimonial-slider">
                <?php 
                while( $testimonial_qry->have_posts() ){
                    $testimonial_qry->the_post();
                    
                    if ( has_post_thumbnail() ){  ?>
                        <li>          
                        <blockquote>
                           <?php the_content(); ?>
                           <?php if ( $restaurant_and_cafe_testimonial_caption  ) { ?>
                             <cite><?php the_title(); ?></cite>
                         <?php } ?>
                     </blockquote>
                 </li>
                 <?php }

             }
             wp_reset_postdata(); ?>
         </ul>

         <ul id="testimonial-slider-nav">
            <?php 
            while( $testimonial_qry->have_posts() ){
                $testimonial_qry->the_post();
                if ( has_post_thumbnail() ){  ?>
                    <li><img src="<?php the_post_thumbnail_url( 'restaurant-and-cafe-slider' ); ?>"></li>
                <?php }
                else{
                    echo '<li><img src="'. esc_url( get_template_directory_uri() . '/images/fallback-slider.png' ) . '"></li>'; 
                }
            }
            wp_reset_postdata(); ?>
        </ul>
    </div>
</div>
<?php
}
}

echo '</div>';
