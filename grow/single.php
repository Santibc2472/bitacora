<?php
/**
 * The Template for displaying all single posts.
 *
 * @package ThinkUpThemes
 */

get_header(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'grow' ), 'after'  => '</div>', ) ); ?>

				<?php thinkup_input_nav( 'nav-below' ); ?>

				<?php /* Add Author Bio */ thinkup_input_postauthorbio(); ?>

				<?php /* Add comments */ thinkup_input_allowcomments(); ?>

			<?php endwhile; ?>

<?php get_footer(); ?>