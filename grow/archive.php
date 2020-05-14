<?php
/**
 * The template for displaying Archive pages.
 *
 * @package ThinkUpThemes
 */

get_header(); ?>

			<?php if( have_posts() ): ?>

				<div id="container">

				<?php while( have_posts() ): the_post(); ?>

					<div class="blog-grid element<?php echo thinkup_input_stylelayout(); ?>">

					<article id="post-<?php the_ID(); ?>" <?php post_class('blog-article'); ?>>

						<?php if( has_post_thumbnail() ) { ?>
						<header class="entry-header<?php thinkup_input_stylelayout_class1(); ?>">

							<?php echo thinkup_input_blogimage(); ?>

						</header>
						<?php } ?>

						<div class="entry-content<?php thinkup_input_stylelayout_class2(); ?>">

							<?php thinkup_input_blogtitle(); ?>
							<?php thinkup_input_blogmeta(); ?>
							<?php thinkup_input_blogtext(); ?>

						</div><div class="clearboth"></div>

					</article><!-- #post-<?php get_the_ID(); ?> -->

					</div>

				<?php endwhile; ?>

				</div><div class="clearboth"></div>
				
				<?php the_posts_pagination( array(
					'mid_size' => 2,
					'prev_text' => __( '<i class="fa fa-angle-left"></i>', 'grow' ),
					'next_text' => __( '<i class="fa fa-angle-right"></i>', 'grow' ),
				) ); ?>

			<?php else: ?>

				<?php get_template_part( 'no-results', 'archive' ); ?>		

			<?php endif; ?>

<?php get_footer() ?>