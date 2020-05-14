<?php
/**
 * Restaurant and Cafe  woocommerce hooks and functions.
 *
 * @link https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 *
 * @package Restaurant_and_Cafe
 */

/**
 * Woocommerce related hooks
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',                 20, 0 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',     10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                10 );

add_action( 'woocommerce_before_main_content',  'restaurant_and_cafe_wc_wrapper',         10 );
add_action( 'woocommerce_after_main_content',   'restaurant_and_cafe_wc_wrapper_end',     10 );
add_action( 'after_setup_theme',                'restaurant_and_cafe_woocommerce_support' );
add_action( 'restaurant_and_cafe_wo_sidebar', 'restaurant_and_cafe_wc_sidebar_cb' );
add_action( 'widgets_init',                     'restaurant_and_cafe_wc_widgets_init' );
add_filter( 'woocommerce_show_page_title' ,     'restaurant_and_cafe_woo_hide_page_title' );

/**
 * Declare Woocommerce Support
*/
function restaurant_and_cafe_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

/**
 * Woocommerce Sidebar
*/
function restaurant_and_cafe_wc_widgets_init(){
    register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'restaurant-and-cafe' ),
		'id'            => 'shop-sidebar',
		'description'   => esc_html__( 'Sidebar displaying only in woocommerce pages.', 'restaurant-and-cafe' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );    
}

/**
 * Before Content
 * Wraps all WooCommerce content in wrappers which match the theme markup
*/
function restaurant_and_cafe_wc_wrapper(){    
    ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
    <?php
}

/**
 * After Content
 * Closes the wrapping divs
*/
function restaurant_and_cafe_wc_wrapper_end(){
    ?>
        </main>
    </div>
    <?php
    if( is_active_sidebar( 'shop-sidebar' ) );
    do_action( 'restaurant_and_cafe_wo_sidebar' );
}

/**
 * Callback function for Shop sidebar
*/
function restaurant_and_cafe_wc_sidebar_cb(){
    if( is_active_sidebar( 'shop-sidebar' ) ){
        echo '<div class="sidebar"><aside id="secondary" class="widget-area" role="complementary">';
        dynamic_sidebar( 'shop-sidebar' );
        echo '</aside></div>'; 
    }
}


/**
 * restaurant_and_cafe_woo_hide_page_title
 *
 * Removes the "shop" title on the main shop page
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
function restaurant_and_cafe_woo_hide_page_title() {
	
	return false;
	
}