<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Restaurant_and_Cafe
 */


get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'restaurant-and-cafe' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					<?php
						get_search_form();
					?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_pagination( array(
   			 'mid_size' => 2,
  			  'prev_text' => __( '<span class="fa fa-angle-double-left"></span>', 'restaurant-and-cafe' ),
   			 'next_text' => __( '<span class="fa fa-angle-double-right"></span>', 'restaurant-and-cafe' ),
			) ); 

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
