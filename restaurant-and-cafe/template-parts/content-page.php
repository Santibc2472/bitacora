<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Restaurant_and_Cafe
 */

 $sidebar_layout = restaurant_and_cafe_sidebar_layout();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<?php echo ( !is_single() ) ? '<a href="' . esc_url( get_the_permalink() ) . '" class="post-thumbnail">' : '<div class="post-thumbnail">'; ?>
		<?php ( is_active_sidebar( 'right-sidebar' ) && ( $sidebar_layout == 'right-sidebar' ) ) ? the_post_thumbnail( 'restaurant-and-cafe-with-sidebar', array( 'itemprop' => 'image' ) ) : the_post_thumbnail( 'restaurant-and-cafe-without-sidebar', array( 'itemprop' => 'image' ) ) ; ?>
 	<?php echo ( !is_single() ) ? '</a>' : '</div>' ;?>
	<div class="entry-content" itemprop="text">
		<?php
		
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'restaurant-and-cafe' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'restaurant-and-cafe' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
