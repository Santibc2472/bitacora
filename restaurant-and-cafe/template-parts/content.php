<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Restaurant_and_Cafe
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
		?>
	</header><!-- .entry-header -->
	<?php echo ( !is_single() ) ? '<a href="' . esc_url( get_the_permalink() ) . '" class="post-thumbnail">' : '<div class="post-thumbnail">'; ?>
 			<?php ( is_active_sidebar( 'right-sidebar' ) ) ? the_post_thumbnail( 'restaurant-and-cafe-with-sidebar', array( 'itemprop' => 'image' ) ) : the_post_thumbnail( 'restaurant-and-cafe-without-sidebar', array( 'itemprop' => 'image' ) ) ; ?>
    <?php echo ( !is_single() ) ? '</a>' : '</div>' ;?>
		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php restaurant_and_cafe_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	<div class="entry-content" itemprop="text">
		<?php
			if( is_single() ){
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( '<div class="readmore">Read More %s</div>', 'restaurant-and-cafe' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
			}else{
				the_excerpt();
			}
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'restaurant-and-cafe' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if( !is_single() ){ ?>
			
			<footer class="entry-footer"><!-- .entry-footer -->
				 <div class="continue-btn">
				 	<span>
				 		  <a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html__( 'Read More', 'restaurant-and-cafe' ); ?></a>
				 	</span>
				 </div>
			</footer>

		<?php } ?>


	<footer class="entry-footer">
		<?php restaurant_and_cafe_entry_footer(); ?>        		
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
