<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Restaurant_and_Cafe
 */


?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?> >
	<?php 
	echo '<a href="' . esc_url( get_the_permalink() ) . '" class="post-thumbnail">'; 
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'restaurant-and-cafe-search-thumbnail', array( 'itemprop' => 'image' ) ); 
		}else{
			restaurant_and_cafe_get_fallback_svg( 'restaurant-and-cafe-search-thumbnail' );
		}
	echo '</a>' ?>
	<div class="text-holder">
		<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php restaurant_and_cafe_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content" itemprop="text">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php echo '<a href="' . esc_url( get_the_permalink() ) . '" class="btn-green">'; ?>
		<?php esc_html_e( 'Read More', 'restaurant-and-cafe' );?>
		<?php echo'</a>' ;?> 
		<?php restaurant_and_cafe_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</div>
</article><!-- #post-## -->
