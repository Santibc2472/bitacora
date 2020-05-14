<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Restaurant_and_Cafe
 */

    $ed_section = restaurant_and_cafe_get_sections();

    if( is_home() || ! $ed_section || ! ( is_front_page()  || is_page_template( 'template-home.php' ) ) ){ ?>
        		</div>
        	</div><!-- #content -->
        </div>
    <?php } ?>

	<footer id="colophon" class="site-footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
      		<div class="widget-area">
				<div class="container">
					<div class="footer-t">
                        <div class="row">
					   <?php 
                            echo '<div class= "col-3">';
                                if( is_active_sidebar( 'footer-widget-one') ) dynamic_sidebar( 'footer-widget-one' ); 
                            echo '</div>';
                        ?>
                        <?php 
                            echo '<div class= "col-3">';
                                if( is_active_sidebar( 'footer-widget-two') ) dynamic_sidebar( 'footer-widget-two' ); 
                            echo '</div>';
                        ?>
                        <?php 
                            echo '<div class= "col-3">';
                                if( is_active_sidebar( 'footer-widget-three') ) dynamic_sidebar( 'footer-widget-three' ); 
                            echo '</div>';
                        ?>
                    </div>
				</div>
			</div>	
		</div>
        <?php do_action( 'restaurant_and_cafe_footer' ); ?>
		
	</footer><!-- #colophon -->
    <div class="overlay"></div>

</div><!-- #acc-content -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
