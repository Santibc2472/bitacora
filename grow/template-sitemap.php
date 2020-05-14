<?php
/**
 * Template Name: Sitemap
 *
 * @package ThinkUpThemes
 */

get_header(); ?>

			<div class="one_half">
				<h3 class="page-title"><?php _e( 'Pages', 'grow' ); ?>:</h3>
				<ul class="sitemap-pages">
					<?php wp_list_pages('title_li='); ?>
				</ul> 

				<h3 class="page-title"><?php _e( 'Author(s)', 'grow' ); ?>:</h3>
				<ul class="sitemap-authors">
					<?php wp_list_authors( 'optioncount=1' ); ?>
				</ul>
			</div> 
		 
			<div class="one_half last">
				<h3 class="page-title"><?php _e( 'Posts', 'grow' ); ?>:</h3>
				<ul class="sitemap-posts">
					<?php $args=array(
					           'orderby'    => 'name',
					           'pad_counts' => '1'
						  );

					$cats = get_categories( $args );
					foreach ( $cats as $cat ) {

					 $loop = new WP_Query('posts_per_page=-1&cat='.$cat->cat_ID);

					  echo '<li class="category"><a href="' . esc_url( get_category_link($cat->term_id) ) . '">' . __( 'Category:', 'grow' ) . ' ' . esc_html( $cat->cat_name ) . ' (' . esc_html( $cat->category_count ) . ')' . "\n";
					  echo '<ul class="children">'."\n";
					  while($loop->have_posts() ) : $loop->the_post();
						 $category = get_the_category();
					?>
							<li><a href="<?php the_permalink() ?>"  title="<?php esc_attr_e( 'Permanent Link to', 'grow' ); ?>: <?php the_title(); ?>">
							<?php the_title(); ?></a></li>
					   <?php endwhile; ?>
					  </ul>
					  </li>
					<?php } ?>
				</ul>

				<h3 class="page-title"><?php _e( 'Archives', 'grow' ); ?>:</h3>
				<ul class="sitemap-archives">
					<?php wp_get_archives('type=monthly&show_post_count=true'); ?>
				</ul>
			</div><div class="clearboth"></div>

<?php get_footer(); ?>