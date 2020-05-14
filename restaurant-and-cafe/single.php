<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Restaurant_and_Cafe
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			the_posts_pagination( array(
   			 'mid_size' => 2,
  			  'prev_text' => __( '<<', 'restaurant-and-cafe' ),
   			 'next_text' => __( '>>', 'restaurant-and-cafe' ),
			) ); 

			do_action( 'restaurant_and_cafe_author_info_box' ); 

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		



		?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
