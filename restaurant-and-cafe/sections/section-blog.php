<?php
/**
 * Blog Section
 * 
 * @package Restaurant_and_Cafe
 */

 $restaurant_and_cafe_blog_section_page = get_theme_mod( 'restaurant_and_cafe_blog_section_page' );
 $restaurant_and_cafe_blog_section_cat = get_theme_mod( 'restaurant_and_cafe_blog_section_cat' );
    echo '<div class="container">';
    	if($restaurant_and_cafe_blog_section_page){
			echo '<header class="header">' ;
            $tab_qry = new WP_Query( array( 
                'post_type'             => 'page',
                'post__in'              => array( $restaurant_and_cafe_blog_section_page ),
                'post_status'           => 'publish',
                'posts_per_page'        => -1,
                'ignore_sticky_posts'   => true ) );

            if( $tab_qry->have_posts() ){                
                while( $tab_qry->have_posts() ){
                     $tab_qry->the_post();
                     the_title( '<h2 class="main-title">', '</h2>' ); 
                     the_excerpt();
                }
            }
            wp_reset_postdata();
            echo '</header>';
        }
    	
    	$blog_qry = new WP_Query( array( 
    			'cat' 					=> $restaurant_and_cafe_blog_section_cat,
    			'post_status'           => 'publish',
    			'posts_per_page'		=> 3,
    			'ignore_sticky_posts'   => true ) );

        if( $blog_qry->have_posts() ){
    ?>
    
        <div class="blog-holder">		
            <?php 
        	   while( $blog_qry->have_posts() ){
            	   $blog_qry->the_post();
            ?>

    	   <div class="post">
    		<?php
    			echo '<a href="' . esc_url( get_the_permalink() ) . '" class="post-thumbnail">';
                    if ( has_post_thumbnail() ) {
         			    the_post_thumbnail( 'restaurant-and-cafe-blog-in-home', array( 'itemprop' => 'image' ) );
                    }else{
                        restaurant_and_cafe_get_fallback_svg( 'restaurant-and-cafe-blog-in-home' );
                    }
     			echo  '</a>';
     		 
                if ( 'post' === get_post_type() ) { ?>
	
			     <div class="text-holder">
				    <header class="entry-header">
					   <div class = "entry-meta"><?php restaurant_and_cafe_posted_date(); ?> / <span class="category"><?php the_category(' ');?></span> </div>
						  <h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
				    </header><!-- .entry-meta -->
				    <div class="entry-content">
					<?php
						the_excerpt();
					?>
				    </div><!-- .entry-content -->
	
				    <footer class="entry-footer">
					   <a href="<?php the_permalink(); ?>" class="readmore"><?php echo esc_html__( 'Read More', 'restaurant-and-cafe' ); ?></a>
					   <span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'restaurant-and-cafe' ), esc_html__( '1', 'restaurant-and-cafe' ), esc_html__( '%', 'restaurant-and-cafe' ) ); ?></span>
				    </footer><!-- .entry-footer -->
			     </div> <!--  .text-holder -->
		      <?php } ?>

		        </div>
	           <?php 
                   }
                   wp_reset_postdata(); ?>
	    </div>
    <?php } ?>
</div>