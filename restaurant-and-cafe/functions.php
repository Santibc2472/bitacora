<?php
/**
 * Restaurant and Cafe functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Restaurant_and_Cafe
 */
 
$theme_data = wp_get_theme();
if( ! defined( 'RESTAURANT_AND_CAFE_THEME_VERSION' ) ) define ( 'RESTAURANT_AND_CAFE_THEME_VERSION', $theme_data->get( 'Version' ) );
if( ! defined( 'RESTAURANT_AND_CAFE_THEME_NAME' ) ) define( 'RESTAURANT_AND_CAFE_THEME_NAME', $theme_data->get( 'Name' ) );

if ( ! function_exists( 'restaurant_and_cafe_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function restaurant_and_cafe_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Restaurant and Cafe, use a find and replace
	 * to change 'restaurant-and-cafe' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'restaurant-and-cafe', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// excerpt support for pages
	add_post_type_support( 'page', 'excerpt' );
	

	// This theme uses wp_nav_menu() in one location.
	
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'restaurant-and-cafe' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
        'gallery',
        'status',
        'audio', 
        'chat'
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'restaurant_and_cafe_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	/* Custom Logo */
    add_theme_support( 'custom-logo', array(    	
    	'header-text' => array( 'site-title', 'site-description' ),
    ) );

	 // Custom Image Size
    add_image_size( 'restaurant-and-cafe-slider', 95, 95, true );
    add_image_size( 'restaurant-and-cafe-blog', 350, 196, true );
    add_image_size( 'restaurant-and-cafe-with-sidebar', 818, 390, true );
    add_image_size( 'restaurant-and-cafe-without-sidebar', 1110, 450, true );
    add_image_size( 'restaurant-and-cafe-featured-post', 275, 275, true );
    add_image_size( 'restaurant-and-cafe-recent-post', 50, 50, true );
    add_image_size( 'restaurant-and-cafe-search-thumbnail',230,158,true );
    add_image_size( 'restaurant-and-cafe-banner',1349,699,true );
    add_image_size( 'restaurant-and-cafe-promotional-block', 230,230,true ); 
    add_image_size( 'restaurant-and-cafe-blog-in-home', 390,310, true);
    add_image_size( 'restaurant-and-cafe-about-section', 540,468, true);
    add_image_size( 'restaurant-and-cafe-service-section', 458, 554, true);
    add_image_size( 'restaurant-and-cafe-schema', 600, 60, true);

}

endif;
add_action( 'after_setup_theme', 'restaurant_and_cafe_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function restaurant_and_cafe_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'restaurant_and_cafe_content_width', 818 );
}
add_action( 'after_setup_theme', 'restaurant_and_cafe_content_width', 0 );

/**
 * Is Woocommerce activated
*/
if ( ! function_exists( 'restaurant_and_cafe_woocommerce_activated' ) ) {
	function restaurant_and_cafe_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}
/**
 * Query Contact Form 7
 * 
 */
function restaurant_and_cafe_cf7_activated() {
	return class_exists( 'WPCF7' ) ? true : false;
}

/**
* Adjust content_width value according to template.
*
* @return void
*/
function restaurant_and_cafe_template_redirect_content_width() {

	// Full Width in the absence of sidebar.
	if( is_page() ){
	   $sidebar_layout = restaurant_and_cafe_sidebar_layout();
       if( ( $sidebar_layout == 'no-sidebar' ) || ! ( is_active_sidebar( 'right-sidebar' ) ) ) $GLOBALS['content_width'] = 1170;
        
	}elseif ( ! ( is_active_sidebar( 'right-sidebar' ) ) ) {
		$GLOBALS['content_width'] = 1170;
	}

}
add_action( 'template_redirect', 'restaurant_and_cafe_template_redirect_content_width' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function restaurant_and_cafe_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'restaurant-and-cafe' ),
		'id'            => 'right-sidebar',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget One', 'restaurant-and-cafe' ),
		'id'            => 'footer-widget-one',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Two', 'restaurant-and-cafe' ),
		'id'            => 'footer-widget-two',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Three', 'restaurant-and-cafe' ),
		'id'            => 'footer-widget-three',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'restaurant_and_cafe_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function restaurant_and_cafe_scripts() {

	// Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    $query_args = array(
		'family' => 'Cardo:400,700|Lato:400,700,400italic',
		);
    wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/css' . $build . '/slick' . $suffix . '.css', array(), '2.2.1'  );
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css' . $build . '/owl.carousel' . $suffix . '.css', array(), '2.2.1'  );
    wp_enqueue_style( 'restaurant-and-cafe-google-fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ) );
    wp_enqueue_style( 'restaurant-and-cafe-style', get_stylesheet_uri(), array(), RESTAURANT_AND_CAFE_THEME_VERSION );
    
    if( restaurant_and_cafe_woocommerce_activated() ) 
    wp_enqueue_style( 'restaurant-and-cafe-woocommerce-style', get_template_directory_uri(). '/css' . $build . '/woocommerce' . $suffix . '.css', array('restaurant-and-cafe-style'), RESTAURANT_AND_CAFE_THEME_VERSION );
	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/js' . $build . '/slick' . $suffix . '.js', array( 'jquery' ), '2.2.1', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js' . $build . '/owl.carousel' . $suffix . '.js', array( 'jquery' ), '2.2.1', true );    
    wp_enqueue_script( 'all', get_template_directory_uri() . '/js' . $build . '/all' . $suffix . '.js', array( 'jquery' ), '5.6.3', true );
    wp_enqueue_script( 'v4-shims', get_template_directory_uri() . '/js' . $build . '/v4-shims' . $suffix . '.js', array( 'jquery' ), '5.6.3', true );
    wp_enqueue_script( 'restaurant-and-cafe-custom', get_template_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array('jquery'), RESTAURANT_AND_CAFE_THEME_VERSION, true );

    $restaurant_and_cafe_testimonial_auto = get_theme_mod( 'restaurant_and_cafe_testimonial_auto', '1' );
    $restaurant_and_cafe_testimonial_loop = get_theme_mod( 'restaurant_and_cafe_testimonial_loop', '1' );
    $restaurant_and_cafe_testimonial_pager = get_theme_mod( 'restaurant_and_cafe_testimonial_pager', '1' );    
    $restaurant_and_cafe_testimonial_animation = get_theme_mod( 'restaurant_and_cafe_testimonial_animation', 'fade' );
    $restaurant_and_cafe_testimonial_speed = get_theme_mod( 'restaurant_and_cafe_testimonial_speed', '1000' );
    $restaurant_and_cafe_animation_speed = get_theme_mod( 'restaurant_and_cafe_animation_speed', '600' );
    
    $restaurant_and_cafe_array = array(
        'auto'      => esc_attr( $restaurant_and_cafe_testimonial_auto ),
        'loop'      => esc_attr( $restaurant_and_cafe_testimonial_loop ),
        'pager'     => esc_attr( $restaurant_and_cafe_testimonial_pager ),
        'animation' => esc_attr( $restaurant_and_cafe_testimonial_animation ),
        'speed'     => absint( $restaurant_and_cafe_testimonial_speed ),
        'a_speed'   => absint( $restaurant_and_cafe_animation_speed ),
        'rtl'       => is_rtl(),
    );
    
 	wp_localize_script( 'restaurant-and-cafe-custom', 'restaurant_and_cafe_data', $restaurant_and_cafe_array );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'restaurant_and_cafe_scripts' );


function restaurant_and_cafe_admin_scripts() {
	wp_enqueue_style( 'restaurant-and-cafe-admin-style',get_template_directory_uri().'/inc/css/admin.css', '',RESTAURANT_AND_CAFE_THEME_VERSION );	
}
add_action( 'admin_enqueue_scripts', 'restaurant_and_cafe_admin_scripts' );

if( ! function_exists( 'restaurant_and_cafe_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function restaurant_and_cafe_change_comment_form_default_fields( $fields ){    
    // get the current commenter if available
    $commenter = wp_get_current_commenter();
 
    // core functionality
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $required = ( $req ? " required" : '' );
    $author   = ( $req ? __( 'Name*', 'restaurant-and-cafe' ) : __( 'Name', 'restaurant-and-cafe' ) );
    $email    = ( $req ? __( 'Email*', 'restaurant-and-cafe' ) : __( 'Email', 'restaurant-and-cafe' ) );
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><label class="screen-reader-text" for="author">' . esc_html__( 'Name', 'restaurant-and-cafe' ) . '<span class="required">*</span></label><input id="author" name="author" placeholder="' . esc_attr( $author ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $required . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email', 'restaurant-and-cafe' ) . '<span class="required">*</span></label><input id="email" name="email" placeholder="' . esc_attr( $email ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . $required. ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'restaurant-and-cafe' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'restaurant-and-cafe' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;    
}
endif;
add_filter( 'comment_form_default_fields', 'restaurant_and_cafe_change_comment_form_default_fields' );

if( ! function_exists( 'restaurant_and_cafe_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function restaurant_and_cafe_change_comment_form_defaults( $defaults ){    
    $defaults['comment_field'] = '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . esc_html__( 'Comment', 'restaurant-and-cafe' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'restaurant-and-cafe' ) . '" cols="45" rows="8" aria-required="true" required></textarea></p>';
    
    return $defaults;    
}
endif;
add_filter( 'comment_form_defaults', 'restaurant_and_cafe_change_comment_form_defaults' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extra.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load plugin for right and no sidebar
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Load widget featured post.
 */
require get_template_directory() . '/inc/widget-featured-post.php';

/**
 * Load widget recent post.
 */
require get_template_directory() . '/inc/widget-recent-post.php';

/**
 * Load widget social link.
 */
require get_template_directory() . '/inc/widget-social-links.php';

/**
 * Load widget popular post
 */
require get_template_directory() . '/inc/widget-popular-post.php';

/**
 * Load woocommerce
 */
require get_template_directory() . '/inc/woocommerce-functions.php';

/**
 * Load info
 */
require get_template_directory() . '/inc/info.php';

/**
 * Plugin Recommendation
*/
require get_template_directory() . '/inc/tgmpa/recommended-plugins.php';

/**
 * Getting Started
*/
require get_template_directory() . '/inc/getting-started/getting-started.php';