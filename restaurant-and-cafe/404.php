<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Restaurant_and_Cafe
 */

get_header(); ?>

		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found error-holder">
				<h1><img src="<?php echo esc_url( get_template_directory_uri() ) ?><?php esc_html_e( '/images/error-img.png', 'restaurant-and-cafe') ; ?>" alt=""></h1>
					<h2><?php esc_html_e( 'Page not found', 'restaurant-and-cafe' ); ?></h2>
				<div class="page-content">
					<p><?php esc_html_e( 'Sorry, We couldn&rsquo;t find the page you&rsquo;re looking for. Why not try a search instead?', 'restaurant-and-cafe' ); ?></p>

					<?php
						get_search_form();
					?>
					<a class="btn-green" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back To Home Page', 'restaurant-and-cafe' ); ?></a>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->

<?php
get_footer();
