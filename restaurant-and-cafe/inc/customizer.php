<?php
/**
 * Restaurant and Cafe Theme Customizer.
 *
 * @package Restaurant_and_Cafe
 */


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function restaurant_and_cafe_customize_register( $wp_customize ) {

    if ( version_compare( get_bloginfo('version'),'4.9', '>=') ) {
        $wp_customize->get_section( 'static_front_page' )->title = __( 'Static Front Page', 'restaurant-and-cafe' );
    }

    /* Option list of all post */	
    $restaurant_and_cafe_options_posts = array();
    $restaurant_and_cafe_options_posts_obj = get_posts('posts_per_page=-1');
    $restaurant_and_cafe_options_posts[''] = __( 'Choose Post', 'restaurant-and-cafe' );
    foreach ( $restaurant_and_cafe_options_posts_obj as $restaurant_and_cafe_posts ) {
    	$restaurant_and_cafe_options_posts[$restaurant_and_cafe_posts->ID] = $restaurant_and_cafe_posts->post_title;
    }

    /* Option list of all page */   
    $restaurant_and_cafe_options_pages = array();
    $restaurant_and_cafe_options_pages_obj = get_pages('posts_per_page=-1');
    $restaurant_and_cafe_options_pages[''] = __( 'Choose Page', 'restaurant-and-cafe' );
    foreach ( $restaurant_and_cafe_options_pages_obj as $restaurant_and_cafe_pages ) {
        $restaurant_and_cafe_options_pages[$restaurant_and_cafe_pages->ID] = $restaurant_and_cafe_pages->post_title;
    }
    
    /* Option list of all categories */
    $restaurant_and_cafe_args = array(
	   'type'                     => 'post',
	   'orderby'                  => 'name',
	   'order'                    => 'ASC',
	   'hide_empty'               => 1,
	   'hierarchical'             => 1,
	   'taxonomy'                 => 'category'
    ); 
    $restaurant_and_cafe_option_categories = array();
    $restaurant_and_cafe_category_lists = get_categories( $restaurant_and_cafe_args );
    $restaurant_and_cafe_option_categories[''] = __( 'Choose Category', 'restaurant-and-cafe' );
    foreach( $restaurant_and_cafe_category_lists as $restaurant_and_cafe_category ){
        $restaurant_and_cafe_option_categories[$restaurant_and_cafe_category->term_id] = $restaurant_and_cafe_category->name;
    }

    if( restaurant_and_cafe_woocommerce_activated() ){
    /* Option list of all Woocommerce categories */
    $parentid = get_queried_object_id();
    $restaurant_and_cafe_args = array(
        'parent' => $parentid
    );
    $restaurant_and_cafe_wc_categories = array(); 
    $restaurant_and_cafe_wc_terms = get_terms( 'product_cat', $restaurant_and_cafe_args ); 
    $restaurant_and_cafe_wc_categories[''] = __( 'Choose Category', 'restaurant-and-cafe' );
    if ( $restaurant_and_cafe_wc_terms ) {           
        foreach ( $restaurant_and_cafe_wc_terms as $restaurant_and_cafe_wc_term ) {                                          
             $restaurant_and_cafe_wc_categories[$restaurant_and_cafe_wc_term->term_id] = $restaurant_and_cafe_wc_term->name;                                             
        }
    }
    }

    
    /** Default Settings */    
    $wp_customize->add_panel( 
        'wp_default_panel',
         array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Default Settings', 'restaurant-and-cafe' ),
            'description' => __( 'Default section provided by wordpress customizer.', 'restaurant-and-cafe' ),
        ) 
    );
    
    $wp_customize->get_section( 'title_tagline' )->panel     = 'wp_default_panel';
    $wp_customize->get_section( 'colors' )->panel            = 'wp_default_panel';
    $wp_customize->get_section( 'header_image' )->panel      = 'wp_default_panel';
    $wp_customize->get_section( 'background_image' )->panel  = 'wp_default_panel';
    $wp_customize->get_section( 'static_front_page' )->panel = 'wp_default_panel'; 
    
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
    /** Default Settings Ends */
  
    /** Home Page Settings */
    $wp_customize->add_panel( 
        'restaurant_and_cafe_home_page_settings',
         array(
            'priority' => 40,
            'capability' => 'edit_theme_options',
            'title' => __( 'Home Page Settings', 'restaurant-and-cafe' ),
            'description' => __( 'Customize Home Page Settings', 'restaurant-and-cafe' ),
        ) 
    );
    
    /** Banner Section */
    $wp_customize->add_section(
        'restaurant_and_cafe_banner_settings',
        array(
            'title' => __( 'Banner Section', 'restaurant-and-cafe' ),
            'priority' => 20,
            'panel' => 'restaurant_and_cafe_home_page_settings',
        )
    );
        
    /** Enable/Disable Banner Section */
    $wp_customize->add_setting(
        'restaurant_and_cafe_ed_slider_section',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_ed_slider_section',
        array(
            'label' => __( 'Enable Banner Section', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_banner_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Banner Post */
    $wp_customize->add_setting(
        'restaurant_and_cafe_banner_post',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_banner_post',
        array(
            'label' => __( 'Select Banner Post', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_banner_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_posts,
        )
    );
    
    /** Read More Text */
    $wp_customize->add_setting(
        'restaurant_and_cafe_banner_read_more',
        array(
            'default' => __( 'Get Started', 'restaurant-and-cafe' ),
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_banner_read_more',
        array(
            'label' => __( 'Read More Text', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_banner_settings',
            'type' => 'text',
        )
    );
    /** Banner Section Ends */
    

     /** Featured Block Section */
    $wp_customize->add_section(
        'restaurant_and_cafe_featured_settings',
        array(
            'title' => __( 'Featured Section', 'restaurant-and-cafe' ),
            'priority' => 30,
            'panel' => 'restaurant_and_cafe_home_page_settings',
        )
    );

    /** Enable/Disable Featured Section */
    $wp_customize->add_setting(
        'restaurant_and_cafe_ed_featured_section',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_ed_featured_section',
        array(
            'label' => __( 'Enable Featured Section', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_featured_settings',
            'type' => 'checkbox',
        )
    );
    

    /** Featured Section Page */
    $wp_customize->add_setting(
        'restaurant_and_cafe_featured_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_featured_section_page',
        array(
            'label' => __( 'Select Featured Page', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_featured_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_pages,
        )
    );

    
    /** Featured Post One */
    $wp_customize->add_setting(
        'restaurant_and_cafe_featured_block_one',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_featured_block_one',
        array(
            'label' => __( 'Select Featured Post One', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_featured_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_posts,
        )
    );

    
    /** Featured Post Two */
    $wp_customize->add_setting(
        'restaurant_and_cafe_featured_block_two',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_featured_block_two',
        array(
            'label' => __( 'Select Featured Post Two', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_featured_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_posts,
        )
    );



    /** Featured Post Three */
    $wp_customize->add_setting(
        'restaurant_and_cafe_featured_block_three',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_featured_block_three',
        array(
            'label' => __( 'Select Featured Post Three', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_featured_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_posts,
        )
    );
    
    /** Button Text */
    $wp_customize->add_setting(
        'restaurant_and_cafe_button_text',
        array(
            'default' => __( 'View Full Menu', 'restaurant-and-cafe' ),
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_button_text',
        array(
            'label' => __( 'Button Text', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_featured_settings',
            'type' => 'text',
        )
    );
    
    /** Button Url */
    $wp_customize->add_setting(
        'restaurant_and_cafe_button_url',
        array(
            'default' => '#',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_url',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_button_url',
        array(
            'label' => __( 'Button Url', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_featured_settings',
            'type' => 'url',
        )
    );
    /** Button Ends */

    /** Featured Block Section Ends */

    /** About Section */
    $wp_customize->add_section(
        'restaurant_and_cafe_about_settings',
        array(
            'title' => __( 'About Section', 'restaurant-and-cafe' ),
            'priority' => 30,
            'panel' => 'restaurant_and_cafe_home_page_settings',
        )
    );
    
    /** Enable/Disable About Section */
    $wp_customize->add_setting(
        'restaurant_and_cafe_ed_about_section',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_ed_about_section',
        array(
            'label' => __( 'Enable About Section', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_about_settings',
            'type' => 'checkbox',
        )
    );

    /** About Section Page */
    $wp_customize->add_setting(
        'restaurant_and_cafe_about_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_about_section_page',
        array(
            'label' => __( 'Select About Page', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_about_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_pages,
        )
    );

    /** Background Image */
    $wp_customize->add_setting(
        'restaurant_and_cafe_about_section_bg',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'restaurant_and_cafe_about_section_bg',
           array(
               'label'      => __( 'Background Image', 'restaurant-and-cafe' ),
               'section'    => 'restaurant_and_cafe_about_settings'
           )
       )
    );


    /** About Section Ends */
 
    /** Services Section */
    $wp_customize->add_section(
        'restaurant_and_cafe_service_settings',
        array(
            'title' => __( 'Service Section', 'restaurant-and-cafe' ),
            'priority' => 30,
            'panel' => 'restaurant_and_cafe_home_page_settings',
        )
    );
    
    /** Enable/Disable Service Section */
    $wp_customize->add_setting(
        'restaurant_and_cafe_ed_service_section',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_ed_service_section',
        array(
            'label' => __( 'Enable Service Section', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_service_settings',
            'type' => 'checkbox',
        )
    );

    /** Service Section Page */
    $wp_customize->add_setting(
        'restaurant_and_cafe_service_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_service_section_page',
        array(
            'label' => __( 'Select Service Page', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_service_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_pages,
        )
    );

    
    /** Service Post One */
    $wp_customize->add_setting(
        'restaurant_and_cafe_service_post_one',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_service_post_one',
        array(
            'label' => __( 'Select Service Post One', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_service_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_posts,
        )
    );

    /** Favicon for service one */
    $wp_customize->add_setting(
        'restaurant_and_cafe_favicon_one',
        array(
            'default' => 'calendar',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'restaurant_and_cafe_favicon_one',
        array(
            'label' => __( 'Favicon For Service One', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_service_settings',
            'type' => 'text',
        )
    );

    
    /** Service Post Two */
    $wp_customize->add_setting(
        'restaurant_and_cafe_service_post_two',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_service_post_two',
        array(
            'label' => __( 'Select Service Post Two', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_service_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_posts,
        )
    );

    /** Favicon for service two */
    $wp_customize->add_setting(
        'restaurant_and_cafe_favicon_two',
        array(
            'default' => 'calendar',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'restaurant_and_cafe_favicon_two',
        array(
            'label' => __( 'Favicon For Service Two', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_service_settings',
            'type' => 'text',
        )
    );
    

    /** Service Post Three */
    $wp_customize->add_setting(
        'restaurant_and_cafe_service_post_three',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_service_post_three',
        array(
            'label' => __( 'Select Service Post Three', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_service_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_posts,
        )
    );
    

    /** Favicon for service three */
    $wp_customize->add_setting(
        'restaurant_and_cafe_favicon_three',
        array(
            'default' => 'calendar',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_nohtml',
        )
    );

    $wp_customize->add_control(
        'restaurant_and_cafe_favicon_three',
        array(
            'label' => __( 'Favicon For Service Three', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_service_settings',
            'type' => 'text',
        )
    );
    
    /** service Section Ends */

    /** Testimonial Settings */

    $wp_customize->add_section(
        'restaurant_and_cafe_testimonial_settings',
        array(
            'title' => __( 'Testimonial Section', 'restaurant-and-cafe' ),
            'priority' => 50,
            'panel' => 'restaurant_and_cafe_home_page_settings',
        )
    );

    /** Enable/Disable Testimonial */
    $wp_customize->add_setting(
        'restaurant_and_cafe_ed_testimonial_section',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_ed_testimonial_section',
        array(
            'label' => __( 'Enable Home Page Testimonial', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_testimonial_settings',
            'type' => 'checkbox',
        )
    );

    
   /** Testimonial Section Page */
    $wp_customize->add_setting(
        'restaurant_and_cafe_testimonial_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_testimonial_section_page',
        array(
            'label' => __( 'Select Testimonial Page', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_testimonial_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_pages,
        )
    );

    /** Background Image */
    $wp_customize->add_setting(
        'restaurant_and_cafe_testimonial_section_bg',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'restaurant_and_cafe_testimonial_section_bg',
           array(
               'label'      => __( 'Background Image', 'restaurant-and-cafe' ),
               'section'    => 'restaurant_and_cafe_testimonial_settings'
           )
       )
    );

    
    $wp_customize->add_section(
        'restaurant_and_cafe_testimonial_settings',
        array(
            'title' => __( 'Testimonial Settings', 'restaurant-and-cafe' ),
            'priority' => 30,
            'panel' => 'restaurant_and_cafe_home_page_settings',
        )
    );

    /** Enable/Disable Testimonial Auto Transition */
    $wp_customize->add_setting(
        'restaurant_and_cafe_testimonial_auto',
        array(
            'default' => '1',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_testimonial_auto',
        array(
            'label' => __( 'Enable Slider Auto Transition', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_testimonial_settings',
            'type' => 'checkbox',
        )
    );

    /** Enable/Disable Testimonial slider loop */
    $wp_customize->add_setting(
        'restaurant_and_cafe_testimonial_loop',
        array(
            'default' => '1',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_testimonial_loop',
        array(
            'label' => __( 'Enable Slider Loop', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_testimonial_settings',
            'type' => 'checkbox',
        )
    );
    

    /** Enable/Disable Testimonial Pager */
    $wp_customize->add_setting(
        'restaurant_and_cafe_testimonial_pager',
        array(
            'default' => '1',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_testimonial_pager',
        array(
            'label' => __( 'Enable Slider Pager ', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_testimonial_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Testimonial Caption */
    $wp_customize->add_setting(
        'restaurant_and_cafe_testimonial_caption',
        array(
            'default' => '1',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_testimonial_caption',
        array(
            'label' => __( 'Enable Slider Caption', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_testimonial_settings',
            'type' => 'checkbox',
        )
    );
        
    /** Testimonial Animation */
    $wp_customize->add_setting(
        'restaurant_and_cafe_testimonial_animation',
        array(
            'default' => 'slide',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_testimonial_animation',
        array(
            'label' => __( 'Choose Slider Animation', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_testimonial_settings',
            'type' => 'select',
            'choices' => array(
                'fade' => __( 'Fade', 'restaurant-and-cafe' ),
                'slide' => __( 'Slide', 'restaurant-and-cafe' ),
            )
        )
    );
    
    /** Testimonial Speed */
    $wp_customize->add_setting(
        'restaurant_and_cafe_testimonial_speed',
        array(
            'default' => '1000',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_testimonial_speed',
        array(
            'label' => __( 'Slider Speed', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_testimonial_settings',
            'type' => 'number',
        )
    );
    
    /** Animation Speed */
    $wp_customize->add_setting(
        'restaurant_and_cafe_animation_speed',
        array(
            'default' => '600',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_animation_speed',
        array(
            'label' => __( 'Slider Animation Speed', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_testimonial_settings',
            'type' => 'number',
        )
    );

    
    /** Select Category */
    $wp_customize->add_setting(
        'restaurant_and_cafe_testimonial_section_cat',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_testimonial_section_cat',
        array(
            'label' => __( 'Choose Testimonial Category', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_testimonial_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_option_categories,
        )
    );
    /** Testimonial Settings Ends */
    
 if( restaurant_and_cafe_woocommerce_activated() ){
    
    
    /** Tab Menu Settings */
    $wp_customize->add_section(
        'restaurant_and_cafe_tabmenu_settings',
        array(
            'title'         => __( 'Restaurant Menu Settings', 'restaurant-and-cafe' ),
            'priority'      => 50,
            'panel'         => 'restaurant_and_cafe_home_page_settings',
        )
    );
    
    /** Enable/Disable Tab Menu */
    $wp_customize->add_setting(
        'restaurant_and_cafe_ed_tabmenu_section',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
            'description'   =>'WooCommerce product categories must be created and applied to products before they will show up in the drop down.',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_ed_tabmenu_section',
        array(
            'label' => __( 'Enable Restaurant Menu', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_tabmenu_settings',
            'type' => 'checkbox',
        )
    );

   /** Tabmenu Section Page */
    $wp_customize->add_setting(
        'restaurant_and_cafe_tabmenu_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_tabmenu_section_page',
        array(
            'label' => __( 'Select Restaurant Menu Page', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_tabmenu_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_pages,
        )
    );

    /** Select Category One */
    $wp_customize->add_setting(
        'restaurant_and_cafe_tabmenu_section_cat_one',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_tabmenu_section_cat_one',
        array(
            'label' => __( 'Choose Category One', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_tabmenu_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_wc_categories,
        )
    );

     /** Select Category Two */
    $wp_customize->add_setting(
        'restaurant_and_cafe_tabmenu_section_cat_two',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_tabmenu_section_cat_two',
        array(
            'label' => __( 'Choose Category Two', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_tabmenu_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_wc_categories,
        )
    );

     /** Select Category Three */
    $wp_customize->add_setting(
        'restaurant_and_cafe_tabmenu_section_cat_three',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_tabmenu_section_cat_three',
        array(
            'label' => __( 'Choose Category Three', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_tabmenu_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_wc_categories,
        )
    );


     /** Select Category Four */
    $wp_customize->add_setting(
        'restaurant_and_cafe_tabmenu_section_cat_four',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_tabmenu_section_cat_four',
        array(
            'label' => __( 'Choose Category Four', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_tabmenu_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_wc_categories,
        )
    );


    /** Select Category Five */
    $wp_customize->add_setting(
        'restaurant_and_cafe_tabmenu_section_cat_five',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_tabmenu_section_cat_five',
        array(
            'label' => __( 'Choose Category Five', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_tabmenu_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_wc_categories,
        )
    );
}

    /** Reservation Settings */
    $wp_customize->add_section(
        'restaurant_and_cafe_reservation_settings',
        array(
            'title' => __( 'Reservation Settings', 'restaurant-and-cafe' ),
            'priority' => 50,
            'panel' => 'restaurant_and_cafe_home_page_settings',
        )
    );
    
    /** Enable/Disable Reservation */
    $wp_customize->add_setting(
        'restaurant_and_cafe_ed_reservation_section',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_ed_reservation_section',
        array(
            'label' => __( 'Enable Reservation', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_reservation_settings',
            'type' => 'checkbox',
        )
    );

    /** Reservation Section Page */
    $wp_customize->add_setting(
        'restaurant_and_cafe_reservation_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_reservation_section_page',
        array(
            'label' => __( 'Select Reservation Page', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_reservation_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_pages,
        )
    );
    
    if( restaurant_and_cafe_cf7_activated() ){
        /** Reservation Section Shortcode Text */
        $wp_customize->add_setting(
            'restaurant_and_cafe_reservation_sc_text',
            array(
                'default' => '',
                'sanitize_callback' => 'restaurant_and_cafe_sanitize_shortcode',
            )
        );
        
        $wp_customize->add_control(
            'restaurant_and_cafe_reservation_sc_text',
            array(
                'label' => __( 'Reservation Shortcode Here', 'restaurant-and-cafe' ),
                'section' => 'restaurant_and_cafe_reservation_settings',
                'type' => 'text',
            )
        );
    }

    /**Reservation Section Background Image */
    $wp_customize->add_setting(
        'restaurant_and_cafe_reservation_section_bg',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'restaurant_and_cafe_reservation_section_bg',
           array(
               'label'      => __( 'Reservation Background Image', 'restaurant-and-cafe' ),
               'section'    => 'restaurant_and_cafe_reservation_settings'
           )
       )
    );

    /** Resevation Section Ends */
    
    /** Blog Section */
    $wp_customize->add_section(
        'restaurant_and_cafe_blog_settings',
        array(
            'title' => __( 'Blog Section', 'restaurant-and-cafe' ),
            'priority' => 60,
            'panel' => 'restaurant_and_cafe_home_page_settings',
        )
    );
    
    /** Enable/Disable Blog Section */
    $wp_customize->add_setting(
        'restaurant_and_cafe_ed_blog_section',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_ed_blog_section',
        array(
            'label' => __( 'Enable Blog Section', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_blog_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Blog Section Page */
    $wp_customize->add_setting(
        'restaurant_and_cafe_blog_section_page',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_blog_section_page',
        array(
            'label' => __( 'Select Blog Page', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_blog_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_options_pages,
        )
    );


    /** Select Category */
    $wp_customize->add_setting(
        'restaurant_and_cafe_blog_section_cat',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_blog_section_cat',
        array(
            'label' => __( 'Select Category', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_blog_settings',
            'type' => 'select',
            'choices' => $restaurant_and_cafe_option_categories,
        )
    );
      
    /** Gmap Section Ends */

    
    /** Gmaps Section */
    $wp_customize->add_section(
        'restaurant_and_cafe_gmap_settings',
        array(
            'title' => __( 'Google Map Section', 'restaurant-and-cafe' ),
            'priority' => 100,
            'panel' => 'restaurant_and_cafe_home_page_settings',
        )
    );

    /** Enable/Disable Map Section */
    $wp_customize->add_setting(
        'restaurant_and_cafe_ed_home_map_section',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_ed_home_map_section',
        array(
            'label' => __( 'Enable Map Section', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_gmap_settings',
            'type' => 'checkbox',
        )
    );
       
    /** Gmap Link */
    $wp_customize->add_setting(
        'restaurant_and_cafe_gmap',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_iframe',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_gmap',
        array(
            'label' => __( 'Google Map Iframe Link', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_gmap_settings',
            'type' => 'textarea',
        )
    );

    /** Home Page Settings Ends */
    
    /** BreadCrumb Settings */
    $wp_customize->add_section(
        'restaurant_and_cafe_breadcrumb_settings',
        array(
            'title' => __( 'Breadcrumb Settings', 'restaurant-and-cafe' ),
            'priority' => 50,
            'capability' => 'edit_theme_options',
        )
    );
    
    /** Enable/Disable BreadCrumb */
    $wp_customize->add_setting(
        'restaurant_and_cafe_ed_breadcrumb',
        array(
            'default' => '',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_ed_breadcrumb',
        array(
            'label' => __( 'Enable Breadcrumb', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Show/Hide Current */
    $wp_customize->add_setting(
        'restaurant_and_cafe_ed_current',
        array(
            'default' => '1',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_ed_current',
        array(
            'label' => __( 'Show current', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Home Text */
    $wp_customize->add_setting(
        'restaurant_and_cafe_breadcrumb_home_text',
        array(
            'default' => __( 'Home', 'restaurant-and-cafe' ),
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_breadcrumb_home_text',
        array(
            'label' => __( 'Breadcrumb Home Text', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_breadcrumb_settings',
            'type' => 'text',
        )
    );
    
    /** Breadcrumb Separator */
    $wp_customize->add_setting(
        'restaurant_and_cafe_breadcrumb_separator',
        array(
            'default' => __( '>', 'restaurant-and-cafe' ),
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_nohtml',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_breadcrumb_separator',
        array(
            'label' => __( 'Breadcrumb Separator', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_breadcrumb_settings',
            'type' => 'text',
        )
    );
    /** BreadCrumb Settings Ends */

    /** Custom CSS*/
    if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
    $wp_customize->add_section(
        'restaurant_and_cafe_custom_settings',
        array(
            'title' => __( 'Custom CSS Settings', 'restaurant-and-cafe' ),
            'priority' => 70,
            'capability' => 'edit_theme_options',
        )
    );
    
    $wp_customize->add_setting(
        'restaurant_and_cafe_custom_css',
        array(
            'default' => '',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'restaurant_and_cafe_sanitize_css'
            )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_custom_css',
        array(
            'label' => __( 'Custom Css', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_custom_settings',
            'description' => __( 'Put your custom CSS', 'restaurant-and-cafe' ),
            'type' => 'textarea',
        )
    );
    }
    /** Custom CSS Ends */

    /** Footer Section */
    $wp_customize->add_section(
        'restaurant_and_cafe_footer_section',
        array(
            'title' => __( 'Footer Settings', 'restaurant-and-cafe' ),
            'priority' => 70,
        )
    );
    
    /** Copyright Text */
    $wp_customize->add_setting(
        'restaurant_and_cafe_footer_copyright_text',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'restaurant_and_cafe_footer_copyright_text',
        array(
            'label' => __( 'Copyright Info', 'restaurant-and-cafe' ),
            'section' => 'restaurant_and_cafe_footer_section',
            'type' => 'textarea',
        )
    );
 
	
    /**
     * Sanitization Functions
     * 
     * @link https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php 
     */
     function restaurant_and_cafe_sanitize_checkbox( $checked ){
        // Boolean check.
        return ( ( isset( $checked ) && true == $checked ) ? true : false );
     }
     
     function restaurant_and_cafe_sanitize_nohtml( $nohtml ){
        return wp_filter_nohtml_kses( $nohtml );
     }
     
     function restaurant_and_cafe_sanitize_html( $html ){
        return wp_filter_post_kses( $html );
     }
     
     function restaurant_and_cafe_sanitize_select( $input, $setting ){
        // Ensure input is a slug.
    	$input = sanitize_key( $input );
    	
    	// Get list of choices from the control associated with the setting.
    	$choices = $setting->manager->get_control( $setting->id )->choices;
    	
    	// If the input is a valid key, return it; otherwise, return the default.
    	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
     }
     
     function restaurant_and_cafe_sanitize_url( $url ){
        return esc_url_raw( $url );
     }
     
     function restaurant_and_cafe_sanitize_number_absint( $number, $setting ) {
    	// Ensure $number is an absolute integer (whole number, zero or greater).
    	$number = absint( $number );
    	
    	// If the input is an absolute integer, return it; otherwise, return the default
    	return ( $number ? $number : $setting->default );
     }
     
    function restaurant_and_cafe_sanitize_shortcode( $shortcode ){
    return wp_kses_post( $shortcode ); } 

    function restaurant_and_cafe_sanitize_css( $css ){
        return wp_strip_all_tags( $css );
    }

     function restaurant_and_cafe_sanitize_image( $image, $setting ) {
    	/*
    	 * Array of valid image file types.
    	 *
    	 * The array includes image mime types that are included in wp_get_mime_types()
    	 */
        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif'          => 'image/gif',
            'png'          => 'image/png',
            'bmp'          => 'image/bmp',
            'tif|tiff'     => 'image/tiff',
            'ico'          => 'image/x-icon'
        );
    	// Return an array with file extension and mime_type.
        $file = wp_check_filetype( $image, $mimes );
    	// If $image has a valid mime_type, return it; otherwise, return the default.
        return ( $file['ext'] ? $image : $setting->default );
    }
    
}
add_action( 'customize_register', 'restaurant_and_cafe_customize_register' );

if( class_exists( 'WP_Customize_Section' ) ) :
/**
 * Adding Go to Pro Section in Customizer
 * https://github.com/justintadlock/trt-customizer-pro
 */
class Restaurant_And_Cafe_Customize_Section extends WP_Customize_Section {

    /**
     * The type of customize section being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'pro-section';

    /**
     * Custom button text to output.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $pro_text = '';

    /**
     * Custom pro button URL.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $pro_url = '';

    /**
     * Add custom parameters to pass to the JS via JSON.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function json() {
        $json = parent::json();

        $json['pro_text'] = $this->pro_text;
        $json['pro_url']  = esc_url( $this->pro_url );

        return $json;
    }

    /**
     * Outputs the Underscore.js template.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    protected function render_template() { ?>

        <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

            <h3 class="accordion-section-title">
                {{ data.title }}

                <# if ( data.pro_text && data.pro_url ) { #>
                    <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
                <# } #>
            </h3>
        </li>
    <?php }
}
endif;

add_action( 'customize_register', 'restaurant_and_cafe_sections' );
function restaurant_and_cafe_sections( $manager ) {
    // Register custom section types.
    $manager->register_section_type( 'Restaurant_And_Cafe_Customize_Section' );

    // Register sections.
    $manager->add_section(
        new Restaurant_And_Cafe_Customize_Section(
            $manager,
            'restaurant_and_cafe_view',
            array(
                'title'    => esc_html__( 'Pro Available', 'restaurant-and-cafe' ),
                'priority' => 5, 
                'pro_text' => esc_html__( 'VIEW PRO THEME', 'restaurant-and-cafe' ),
                'pro_url'  => 'https://rarathemes.com/wordpress-themes/restaurant-and-cafe-pro/'
            )
        )
    );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function restaurant_and_cafe_customize_preview_js() {
	// Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    wp_enqueue_script( 'restaurant_and_cafe_customizer', get_template_directory_uri() . '/js' . $build . '/customizer' . $suffix . '.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'restaurant_and_cafe_customize_preview_js' );

function restaurant_and_cafe_customize_controls_scripts() {    
    wp_enqueue_script( 'restaurant-and-cafe-admin-js', get_template_directory_uri().'/inc/js/admin.js', array( 'jquery' ), '', true );
}
add_action( 'customize_controls_enqueue_scripts', 'restaurant_and_cafe_customize_controls_scripts' );