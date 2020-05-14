<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemMain {
  
    function __construct(){
        $this->load();
    }
    
    /*
     * Autodetect & Load CMS
     */ 
    function load() {
        global $ABookingSystem;
        global $absdashboardclasses;
      
        $ABookingSystem['page_disabled'] = true;
        
        if($ABookingSystem['type'] == 'auto') {

            // Wordpress Detection
            if(defined('WP_CONTENT_DIR')) {
                $ABookingSystem['type'] = 'wordpress';
              
                // Role detect
                add_action('init', array(&$this, 'wpStart'));
                
                // Redirect after plugin is activated
                add_action('admin_init', array(&$this, 'wpAplusBookingSystemToConnect'));
                
                // Inscrease HTTP Request Timeout from 5 seconds to 15 seconds. 
                add_filter( 'http_request_timeout', array(&$this, 'modify_timeout'), 9999 );
              
                // Login autoconnect
                add_action('wp_login',  array(&$this, 'user_login'), 10, 2);
              
                // Logout redirect to affiliate website
//                add_filter('logout_url',  array(&$this, 'user_logout'), 10, 2);
              
                // Insert Post / Custom post
                add_action( 'wp_insert_post', array(&$this, 'custom_post_add_insert'));
              
                $is_ajax_request = $absdashboardclasses->protect->post('is_ajax_request');
                
                if (is_admin() 
                    && $is_ajax_request == ''){
                  
                    // JS vars - Translation, Requests, ...
                    if (!has_action('admin_head', array (&$absdashboardclasses->resources, 'js') )) {
                        add_action('admin_head', array(&$absdashboardclasses->resources, 'js'),10);
                    }
                  
                    // Load Menu
                    add_action('admin_menu', array(&$absdashboardclasses->menu, 'load'));
                    
                    if($this->isBMpage()) {
                        add_filter( 'ajax_query_attachments_args', array(&$this, 'show_current_user_attachments'));
                    }
                  
//                     if($this->isBMpage()) {
                        // Load CSS & JS FILES
                        add_action('admin_enqueue_scripts', array(&$absdashboardclasses->resources, 'backend'));
//                     }
                  
                    // Auto create calendar at custom post creation
                    add_action('admin_init', array(&$this, 'custom_post_add'));
                } else {
                    
                    // JS vars - Translation, Requests, ...
                    if (!has_action('wp_head', array (&$absdashboardclasses->resources, 'js') )) {
                        add_action('wp_head', array(&$absdashboardclasses->resources, 'js'),10);
                    }
                    
                    if($this->isBMpage()) {
                        add_filter( 'ajax_query_attachments_args', array(&$this, 'show_current_user_attachments'));
                    }
                  
//                     if($this->isBMpage()) {
                        // Load CSS & JS FILES
                        add_action('wp_enqueue_scripts', array(&$absdashboardclasses->resources, 'frontend'));
//                     }
//                     }
                  
                    // Add shortcode for show calendar by post id
                    add_shortcode('bookeucom-dashboard', array(&$this, 'shortcode_dashboard'));
                  
                    // Add shortcode for show calendar by post id
                    add_shortcode('bookeucom-post', array(&$this, 'shortcode_for_post_id'));
                  
                    // Add shortcode for show reservations
                    add_shortcode('bookeucom-reservations', array(&$this, 'shortcode_for_reservations'));
                  
                    // Add shortcode for show calendars
                    add_shortcode('bookeucom-calendars', array(&$this, 'shortcode_for_calendars'));
                    
                }
            }
        }
        
        $absdashboardclasses->requests = class_exists('ABookingSystemRequests') ? new ABookingSystemRequests():'Class does not exist!';
      
        do_action('ABookingSystem_main_after_loaded');
    }
  
    function isBMpage(){
        global $ABookingSystem;
        global $absdashboardclasses;
        $isPage = false;
        $page = 'none';
      
        // Wordpress Detection
        if(defined('WP_CONTENT_DIR')) {
          
            if($absdashboardclasses->protect->get('page') != '') {              
                $page = $absdashboardclasses->protect->get('page');
            }
        }
        
        if(strpos($page, 'abookingsystemdashboard') !== false) {
            $isPage = true;
            $ABookingSystem['page'] = str_replace('abookingsystemdashboard-', '', $page);
        }
      
        return $isPage;
    }
  
    /*
     * Wordpress CMS
     */
    // Display dashboard
    function shortcode_dashboard($atts){
        global $post;
        global $absdashboardclasses;
        global $ABookingSystem;
        
        $html = array();
        extract(shortcode_atts(array('class' => 'bookeucom-dashboard'), $atts));
      
        $ABookingSystem['atts'] = $atts;
  
        $account_type = $absdashboardclasses->option->get('account_type',
                                                  $ABookingSystem['user_id']);
        
        ob_start();
        $ABookingSystem['page'] = ($ABookingSystem['role'] == 'admin' ? 'connection':($ABookingSystem['role'] == 'owner' ? ($account_type != 'affiliate' ? 'calendars':'account'):'reservations'));
      
        if($absdashboardclasses->protect->get('abookingsystemdashboard_page') != '') {
            $ABookingSystem['page'] = $absdashboardclasses->protect->get('abookingsystemdashboard_page');
        }
      
        include_once $ABookingSystem['plugin_path'].'views/frontend-main.php';
        return ob_get_clean();
    } 
  
    // Display reservations
    function shortcode_for_reservations($atts){
        global $post;
        global $absdashboardclasses;
        global $ABookingSystem;
        
        $html = array();
        extract(shortcode_atts(array('class' => 'bookeucom-reservations'), $atts));
      
        $ABookingSystem['atts'] = $atts;
        
        ob_start();
        $ABookingSystem['page'] = 'reservations';
        include_once $ABookingSystem['plugin_path'].'views/frontend.php';
        return ob_get_clean();
    } 
  
    // Display calendars
    function shortcode_for_calendars($atts){
        global $post;
        global $absdashboardclasses;
        global $ABookingSystem;
        
        $html = array();
        extract(shortcode_atts(array('class' => 'bookeucom-calendars'), $atts));
      
        $ABookingSystem['atts'] = $atts;
        
        ob_start();
        $ABookingSystem['page'] = 'calendars';
        include_once $ABookingSystem['plugin_path'].'views/frontend.php';
        return ob_get_clean();
    } 
    
    // Display calendar for post id 
    function shortcode_for_post_id($atts){
        global $post;
        global $absdashboardclasses;
        
        $html = array();
        extract(shortcode_atts(array('class' => 'bookeucom-post'), $atts));
      
        if(isset($post->ID)) {
            $listing_data = $absdashboardclasses->listing->get_data('post_id', $post->ID);
            $class = '';
            $language = 'auto';
            
            if(!empty($atts)) {
              
                if (array_key_exists('class', $atts)){
                    $class = $atts['class'];
                }

                if (array_key_exists('language', $atts)){
                    $language = $atts['language'];
                }
            }
          
            if(!empty($listing_data)) {
                $api_key = $listing_data->api_key;
                $server = $listing_data->server;
              
                global $current_user;
                get_currentuserinfo();
                
                array_push($html, '<script type="text/javascript">');
                array_push($html, '   window.BECHookValue_customer_id = '.$current_user->ID.';');
              
                if(isset($current_user->user_email)) {
                    array_push($html, '   window.BECHookValue_email = "'.$current_user->user_email.'";');
                }
                
                $phone = get_user_meta($current_user->ID,'billing_phone',true);
              
                if(isset($phone)) {
                    array_push($html, '   window.BECHookValue_phone  = "'.$phone.'";');
                }
              
                if(isset($current_user->user_firstname) 
                   && isset($current_user->user_lastname)) {
                    array_push($html, '   window.BECHookValue_full_name = "'.$current_user->user_firstname.' '.$current_user->user_lastname.'";');
                }
                
                array_push($html, '</script>');
                array_push($html, '<div class="bookeucom">[bookeucom key="'.$api_key.'-'.$server.'" class="'.$class.'" language="'.$language.'"]</div>');
            }
            
        }
        
        return implode('', $html);
    }
    
    function show_current_user_attachments($query){
        // admins get to see everything
		if ( ! current_user_can( 'manage_options' ) )
			$query['author'] = get_current_user_id();
		return $query;
    }
  
    function custom_post_add_insert($post_id){
        // If this is a revision, don't send the email.
        if ( wp_is_post_revision( $post_id ))
          return;
        $post = get_post($post_id);
        
        if($post->post_type == $post->post_type
           || $post->post_type == 'post') {
            global $ABookingSystem;
            global $abookingsystemdashboard;
            global $absdashboardclasses;
          
          $use_custom_post = $absdashboardclasses->option->get('calendar_for_each_custom_post');
          $custom_post = $absdashboardclasses->option->get('calendar_for_each_custom_post_name');
          // https://codex.wordpress.org/Plugin_API/Action_Reference/wp_insert_post
          // Create calendar for each custom post
          if($use_custom_post == 'true'
            && $custom_post != ''
            && $custom_post == $post->post_type) {
            
                // Check if calendar is created else create it
                if(!$absdashboardclasses->calendar->exist('post_id', $post_id)) {

//                    if($ABookingSystem['role'] == 'admin') { 
//                         $token = $absdashboardclasses->option->get('token');
//                         $user_id = 0;
//                     } else {
                    $token = $absdashboardclasses->option->get('token',
                                                      $ABookingSystem['user_id']);
                    $user_id = $post->post_author;
//                    }
                    
                    $location = '';

                    $default_currency = $absdashboardclasses->option->get('default_currency');
                    $default_category = $absdashboardclasses->option->get('default_category');
                    $default_calendar_type = $absdashboardclasses->option->get('default_calendar_type');
                    $default_reservations_type = $absdashboardclasses->option->get('default_reservations_type');

                    if($custom_post === 'job_listing') {
                        $job_location = get_post_meta($post_id, '_job_location', true);
                        $location = $job_location;
                        $default_category = get_post_meta($post_id, '_job_category', true);
                    }
                    
                    $website = get_site_url();  
                    $website = str_replace('http://', '', $website);  
                    $website = str_replace('https://', '', $website);  

                    $result = $absdashboardclasses->http->post($ABookingSystem['api_url'],
                                                      "calendar",
                                                      ['calendar_type' => $default_calendar_type,
                                                       'category' => $default_category,
                                                       'currency' => $default_currency,
                                                       'description' => $post->excerpt,
                                                       'group_id' => 0,
                                                       'is_group' => 'false',
                                                       'location' => $location,
                                                       'reservations_type' => $default_reservations_type,
                                                       'website' => $website,
                                                       'page' => $post->guid,
                                                       'name' => $post->post_title],
                                                      ['token' => $token],
                                                      'json');

                    if($result->code == 200 
                        || $result->code == 201) {
                        $response = $absdashboardclasses->protect->data($result->response, 'json');
                        $data = json_decode($response);

                        // Save calendar 
                        if($ABookingSystem['role'] == 'admin') { 
                            $absdashboardclasses->calendar->add($post->post_title,
                                                       0,
                                                       'false',
                                                       $data->data[0]->id,
                                                       $data->data[0]->api_key,
                                                       $user_id,
                                                       $post_id);
                        } else { 
                            $absdashboardclasses->calendar->add($post->post_title,
                                                       0,
                                                       'false',
                                                       $data->data[0]->id,
                                                       $data->data[0]->api_key,
                                                       $user_id,
                                                       $post_id);
                        }
                    }
                }
            }
        }
    }
  
    function custom_post_add(){
        global $absdashboardclasses;
        
        if ($this->is_edit_page('edit')){
            
            if($absdashboardclasses->protect->get('post') != '') {
                global $ABookingSystem;
                global $abookingsystemdashboard;
                $post_id = $absdashboardclasses->protect->get('post');
                $post = get_post( $post_id );
              
                $use_custom_post = $absdashboardclasses->option->get('calendar_for_each_custom_post');
                $custom_post = $absdashboardclasses->option->get('calendar_for_each_custom_post_name');
                
                // https://codex.wordpress.org/Plugin_API/Action_Reference/wp_insert_post
                // Create calendar for each custom post
                if($use_custom_post == 'true'
                  && $custom_post != ''
                  && $custom_post == $post->post_type) {
                  
                   // Check if calendar is created else create it
                    if(!$absdashboardclasses->calendar->exist('post_id', $post_id)) {
                       
//                        if($ABookingSystem['role'] == 'admin') { 
//                             $token = $absdashboardclasses->option->get('token');
//                             $user_id = 0;
//                         } else {
                            $token = $absdashboardclasses->option->get('token',
                                                                $ABookingSystem['user_id']);
                            $user_id = $post->post_author;
//                        }
                      
                        $default_currency = $absdashboardclasses->option->get('default_currency');
                        $default_category = $absdashboardclasses->option->get('default_category');
                        $default_calendar_type = $absdashboardclasses->option->get('default_calendar_type');
                        $default_reservations_type = $absdashboardclasses->option->get('default_reservations_type');

                        $website = get_site_url();  
                        $website = str_replace('http://', '', $website);  
                        $website = str_replace('https://', '', $website);  
                      
                        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'],
                                                          "calendar",
                                                          ['calendar_type' => $default_calendar_type,
                                                           'category' => $default_category,
                                                           'currency' => $default_currency,
                                                           'description' => $post->excerpt,
                                                           'group_id' => 0,
                                                           'is_group' => 'false',
                                                           'location' => '',
                                                           'reservations_type' => $default_reservations_type,
                                                           'website' => $website,
                                                           'page' => $post->guid,
                                                           'name' => $post->post_title],
                                                          ['token' => $token],
                                                          'json');

                        if($result->code == 200 
                           || $result->code == 201) {
                            $response = $absdashboardclasses->protect->data($result->response, 'json');
                            $data = json_decode($response);

                            // Save calendar 
                            if($ABookingSystem['role'] == 'admin') { 
                                $absdashboardclasses->calendar->add($post->post_title,
                                                           0,
                                                           'false',
                                                           $data->data[0]->id,
                                                           $data->data[0]->api_key,
                                                           $user_id,
                                                           $post_id);
                            } else { 
                                $absdashboardclasses->calendar->add($post->post_title,
                                                           0,
                                                           'false',
                                                           $data->data[0]->id,
                                                           $data->data[0]->api_key,
                                                           $user_id,
                                                           $post_id);
                            }
                        }
                    }
                }
            }
        }
    }
  
    function is_edit_page($new_edit = null){
        global $pagenow;
        //make sure we are on the backend
        if (!is_admin()) return false;


        if($new_edit == "edit")
            return in_array( $pagenow, array( 'post.php',  ) );
        elseif($new_edit == "new") //check for new post page
            return in_array( $pagenow, array( 'post-new.php' ) );
        else //check for either new or edit
            return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
    }
  
    function wpStart(){
        global $ABookingSystem;
        global $absdashboardclasses;
        
        // Menu hooks
        do_action('aplusbookingsystem_menu_hook');
        
        // Network Api
        if($absdashboardclasses->protect->post('network_api') == true
          || $absdashboardclasses->protect->post('network_api') == 'true') {
            $absdashboardclasses->api->start();
        }
        
        // Default listings
        if($ABookingSystem['listing_save'] == 'default') {
            // Add listings custom posts 
            $this->listings();
        }
        
        // Get Role
        $this->role();
      
        if($ABookingSystem['role'] == 'admin') {
            // Check if is installed & install
            $absdashboardclasses->installation->start();
        }
      
        // Start Database
        $absdashboardclasses->db->start();
      
        // Check if is connected
        $token = $absdashboardclasses->option->get('token',
                                          $ABookingSystem['user_id']);
        
        // Load Extensions from DB
//        $absdashboardclasses->extensions->loadFromDB();
      
        if($token != '') {
            $ABookingSystem['page_disabled'] = false;
        }
        $this->wpGutenbergBlockShortcode();
        
        // Add Shortcode
        if ((current_user_can('edit_posts') 
            || current_user_can('edit_pages'))
            && $this->is_edit_page('edit')){
            $absdashboardclasses->display->view('shortcode');
            $absdashboardclasses->resources->shortcode();
        }

        // Save calendar cors
        add_action( 'save_post', array(&$this, 'save_calendar_page_post_cors'));
    }

    function save_calendar_page_post_cors($post_id) {
        global $ABookingSystem;
        global $absdashboardclasses;
        // If this is a revision, get real post ID
        if ( $parent_id = wp_is_post_revision( $post_id ) ) {
            $post_id = $parent_id;
        }

        $content_post = get_post($post_id);
        $content = $content_post->post_content;

        // Check if exist shortcode
        if(strpos($content, '[bookeucom') !== false){
            $page           = $content_post->guid;
            $data           = explode('bookeucom key=', $content);
            $data           = explode(' ', $data[1]);
            $api_key_data   = explode('-', $data[0]);
            $api_key        = $api_key_data[0];
            $server         = $api_key_data[1];
            $token = $absdashboardclasses->option->get('token',
                                                        $ABookingSystem['user_id']);

            if(isset($server) 
                && $server != '') {
                $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
            }

            // Save cors
            $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                                        "cors",
                                                        ['page' => $page,
                                                         'api_key' => $api_key],
                                                        ['token' => $token]);

        }
    }
    
    function wpGutenbergBlockShortcode() {
        global $ABookingSystem;

        if ( function_exists( 'register_block_type' ) ) {

            wp_register_script( 'aplusbooking-button-gutenberg', $ABookingSystem['plugin_url'].'/js/button-gutenberg.js', array(
                'wp-blocks',
                'wp-element'
            ) );
            wp_register_style( 'aplusbooking-button-gutenberg-editor', $ABookingSystem['plugin_url'].'/css/button-gutenberg.css',
                array( 'wp-edit-blocks' ),
                filemtime( plugin_dir_path( __FILE__ ) . '../../css/button-gutenberg.css' )
            );
            register_block_type( 'bookeucom/bookeucom', array(
                   'editor_script' => 'aplusbooking-button-gutenberg'
                 , 'editor_style'  => 'aplusbooking-button-gutenberg-editor'
            ) );
        }
    }
    
    /*
     * Redirect After Activation
     */
    function wpAplusBookingSystemToConnect(){
        
        if (get_option('wpaplusbookingsystem_activation') == 'true'
           || get_option('wpaplusbookingsystem_activation') == '') {
            update_option('wpaplusbookingsystem_activation', 'false');
            wp_redirect(admin_url('admin.php?page=abookingsystemdashboard-connection'));
        }
    }
    
    function modify_timeout( $timeout ) {
        return 15;
    }
    
    /*
     *  Create listings custom posts
     */ 
    function listings(){
        $taxonomiesALL = array();
        $supportsALL   = array();
      
        // Taxonomies: Categories
        array_push($taxonomiesALL, 'category');

        // Taxonomies: Tags{
        array_push($taxonomiesALL, 'post_tag');

        // Supports: Title
        array_push($supportsALL, 'title');

        // Supports: Editor
        array_push($supportsALL, 'editor');

        // Supports: Author
        array_push($supportsALL, 'author');

        // Supports: Thumbnail
        array_push($supportsALL, 'thumbnail');

        // Supports: Excerpt
        array_push($supportsALL, 'excerpt');
        
        // Spaces
        $data = array('exclude_from_search' => false,
                      'has_archive' => true,
                      'labels' => array('name' => 'Spaces',
                                        'singular_name' => 'Spaces',
                                        'menu_name' => 'Spaces',
                                        'all_items' => 'All spaces',
                                        'add_new' => __( 'Add space'),
                                        'add_new_item' => __( 'Add new space'),
                                        'edit_item' => __( 'Edit space')),
                      'public' => true,
                      'publicly_queryable' => true,
                      'rewrite' => true,
                      'rewrite' => array('slug' => 'spaces'),
                      'show_ui' => true, // UI in admin panel
                      '_builtin' => false, // It's a custom post type, not built in!
                      '_edit_link' => 'post.php?post=%d',
                      'capability_type' => 'post',
                      'hierarchical' => false,
                      'show_in_nav_menus' => true,
                      'taxonomies' => $taxonomiesALL,
                      'supports' => $supportsALL);
        
        register_post_type('absd_spaces',$data);
    }
    
    /*
     *  Autodetect Role & Site url
     */ 
    function role() {
        global $ABookingSystem;
        global $absdashboardclasses;

        // Wordpress Roles
        if($ABookingSystem['type'] == 'wordpress') {
      
            $ABookingSystem['website'] = $absdashboardclasses->protect->data(get_site_url(), 'url');
            $ABookingSystem['website'] = str_replace('http://', '', $ABookingSystem['website']);  
            $ABookingSystem['website'] = str_replace('https://', '', $ABookingSystem['website']);  
            
            global $current_user;
            $current_user = wp_get_current_user();
          
            if(!empty($current_user)) {
                $ABookingSystem['user_id'] = $current_user->ID;
                
                if($current_user->ID != 0) {
                    $ABookingSystem['username'] = $current_user->data->user_login;
                    $ABookingSystem['email'] = $current_user->data->user_email;
                }
            
                if( !empty($current_user->roles) ){
                    foreach ($current_user->roles as $key => $value) {

                        if($value == 'administrator'){
                            $ABookingSystem['role'] = 'admin';
                        } else if($value == 'author'
                                  || $value == 'editor'){
                            $ABookingSystem['role'] = 'owner';
                        } else if($value == 'subscriber'){
                            $ABookingSystem['role'] = 'customer';
                        } else {
                            $ABookingSystem['role'] = 'guest';
                        }
                    }
                }
            } else {
                if($absdashboardclasses->protect->get('ajax_ses') != ''){
                    $user_data = $absdashboardclasses->protect->show($absdashboardclasses->protect->get('ajax_ses'));
                    $user_data = explode('@@@', $user_data);
                    $ABookingSystem['user_id'] = $user_data[0];
                    $ABookingSystem['role'] = $user_data[1];
                    $user_info = get_userdata($ABookingSystem['user_id']);
                    $ABookingSystem['username'] = $user_info->user_login;
                    $ABookingSystem['email'] = $user_info->user_email;
                } else if($absdashboardclasses->protect->post('ajax_ses') != ''){
                    $user_data = $absdashboardclasses->protect->show($absdashboardclasses->protect->post('ajax_ses'));
                    $user_data = explode('@@@', $user_data);
                    $ABookingSystem['user_id'] = $user_data[0];
                    $ABookingSystem['role'] = $user_data[1];
                    $user_info = get_userdata($ABookingSystem['user_id']);
                    $ABookingSystem['username'] = $user_info->user_login;
                    $ABookingSystem['email'] = $user_info->user_email;
                }
            }
        }
    }
    
    /*
     *  Create owner account
     */ 
    function create_owner($username,
                          $password,
                          $email) {
        global $ABookingSystem;
         
        $user_id = 0;
        
        // Wordpress Roles
        if($ABookingSystem['type'] == 'wordpress') {
            $user_id = wp_create_user( $username, $password, $email );

            // Fetch the WP_User object of our user.
            $user_created = new WP_User($user_id);

            // Replace the current role with 'author' role
//             $user_created->set_role('owner');
            $user_created->set_role('author');
        }
      
        return $user_id;
    }
    
    /*
     * User login
     */
    function user_login($user_login, $user){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
        $user_id = $user->data->ID;
        $email = $user->data->user_email;
        $token = '';
        
        $user_key = $absdashboardclasses->option->get('user_key', $user_id);
        $md5_password = $absdashboardclasses->option->get('md5_password', $user_id);

        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'],
                                          "connect",
                                          ['user_key' => $user_key,
                                           'website' => ''],
                                          ['username' => $email,
                                           'password' => $md5_password]);

        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $data = json_decode($response);
            $token = $data->token;
            $user_type = $data->user_type;
        }
        
        if($token != ''
          && $user_type != 'network') {
            // Account type
            $absdashboardclasses->option->add('account_type',
                                      $user_type,
                                      $user_id,
                                      'user');
          
            
            // Save user data
            foreach($data->user as $key => $value) {

//                if($key != 'id') {
                    $absdashboardclasses->option->add($key,
                                             $value,
                                             $user_id,
                                             'user');
//                }
            }
        }
    }
    
    
    /*
     * User logout
     */
    function user_logout($default){
        global $absdashboardclasses;
        global $ABookingSystem;
        
        // Referral
        $referral_website = $absdashboardclasses->option->get('referral_website',
                                                  $ABookingSystem['user_id']);
        $referral_website = $referral_website != '' ? $referral_website:'';
        return $referral_website != '' ? $referral_website : $default;
    }
  
    function is_network(){
        global $absdashboardclasses;
          
        $network_website = $absdashboardclasses->option->get('website');
        $network_website = isset($network_website) && $network_website != '' ? $network_website:'book.eu.com';
        $mod_network_website = str_replace('http://', '', $network_website);  
        $mod_network_website = str_replace('https://', '', $mod_network_website);  

        $current_website = $absdashboardclasses->protect->data(get_site_url(), 'url');
        $current_website = str_replace('http://', '', $current_website);  
        $current_website = str_replace('https://', '', $current_website);
      
        // Check if is on network website or external
        if ($mod_network_website == $current_website
             && $network_website != ''
             && $current_website != '') {
            return true;
        } else {
            return false;
        }
      
        return false;
    }
  
    function sign($code){
        $code = strtoupper($code);

        $currency_symbols = array(
            'AED' => '&#1583;.&#1573;', // ?
            'AFN' => '&#65;&#102;',
            'ALL' => '&#76;&#101;&#107;',
            'AMD' => '',
            'ANG' => '&#402;',
            'AOA' => '&#75;&#122;', // ?
            'ARS' => '&#36;',
            'AUD' => '&#36;',
            'AWG' => '&#402;',
            'AZN' => '&#1084;&#1072;&#1085;',
            'BAM' => '&#75;&#77;',
            'BBD' => '&#36;',
            'BDT' => '&#2547;', // ?
            'BGN' => '&#1083;&#1074;',
            'BHD' => '.&#1583;.&#1576;', // ?
            'BIF' => '&#70;&#66;&#117;', // ?
            'BMD' => '&#36;',
            'BND' => '&#36;',
            'BOB' => '&#36;&#98;',
            'BRL' => '&#82;&#36;',
            'BSD' => '&#36;',
            'BTN' => '&#78;&#117;&#46;', // ?
            'BWP' => '&#80;',
            'BYR' => '&#112;&#46;',
            'BZD' => '&#66;&#90;&#36;',
            'CAD' => '&#36;',
            'CDF' => '&#70;&#67;',
            'CHF' => '&#67;&#72;&#70;',
            'CLF' => '', // ?
            'CLP' => '&#36;',
            'CNY' => '&#165;',
            'COP' => '&#36;',
            'CRC' => '&#8353;',
            'CUP' => '&#8396;',
            'CVE' => '&#36;', // ?
            'CZK' => '&#75;&#269;',
            'DJF' => '&#70;&#100;&#106;', // ?
            'DKK' => '&#107;&#114;',
            'DOP' => '&#82;&#68;&#36;',
            'DZD' => '&#1583;&#1580;', // ?
            'EGP' => '&#163;',
            'ETB' => '&#66;&#114;',
            'EUR' => '&#8364;',
            'FJD' => '&#36;',
            'FKP' => '&#163;',
            'GBP' => '&#163;',
            'GEL' => '&#4314;', // ?
            'GHS' => '&#162;',
            'GIP' => '&#163;',
            'GMD' => '&#68;', // ?
            'GNF' => '&#70;&#71;', // ?
            'GTQ' => '&#81;',
            'GYD' => '&#36;',
            'HKD' => '&#36;',
            'HNL' => '&#76;',
            'HRK' => '&#107;&#110;',
            'HTG' => '&#71;', // ?
            'HUF' => '&#70;&#116;',
            'IDR' => '&#82;&#112;',
            'ILS' => '&#8362;',
            'INR' => '&#8377;',
            'IQD' => '&#1593;.&#1583;', // ?
            'IRR' => '&#65020;',
            'ISK' => '&#107;&#114;',
            'JEP' => '&#163;',
            'JMD' => '&#74;&#36;',
            'JOD' => '&#74;&#68;', // ?
            'JPY' => '&#165;',
            'KES' => '&#75;&#83;&#104;', // ?
            'KGS' => '&#1083;&#1074;',
            'KHR' => '&#6107;',
            'KMF' => '&#67;&#70;', // ?
            'KPW' => '&#8361;',
            'KRW' => '&#8361;',
            'KWD' => '&#1583;.&#1603;', // ?
            'KYD' => '&#36;',
            'KZT' => '&#1083;&#1074;',
            'LAK' => '&#8365;',
            'LBP' => '&#163;',
            'LKR' => '&#8360;',
            'LRD' => '&#36;',
            'LSL' => '&#76;', // ?
            'LTL' => '&#76;&#116;',
            'LVL' => '&#76;&#115;',
            'LYD' => '&#1604;.&#1583;', // ?
            'MAD' => '&#1583;.&#1605;.', //?
            'MDL' => '&#76;',
            'MGA' => '&#65;&#114;', // ?
            'MKD' => '&#1076;&#1077;&#1085;',
            'MMK' => '&#75;',
            'MNT' => '&#8366;',
            'MOP' => '&#77;&#79;&#80;&#36;', // ?
            'MRO' => '&#85;&#77;', // ?
            'MUR' => '&#8360;', // ?
            'MVR' => '.&#1923;', // ?
            'MWK' => '&#77;&#75;',
            'MXN' => '&#36;',
            'MYR' => '&#82;&#77;',
            'MZN' => '&#77;&#84;',
            'NAD' => '&#36;',
            'NGN' => '&#8358;',
            'NIO' => '&#67;&#36;',
            'NOK' => '&#107;&#114;',
            'NPR' => '&#8360;',
            'NZD' => '&#36;',
            'OMR' => '&#65020;',
            'PAB' => '&#66;&#47;&#46;',
            'PEN' => '&#83;&#47;&#46;',
            'PGK' => '&#75;', // ?
            'PHP' => '&#8369;',
            'PKR' => '&#8360;',
            'PLN' => '&#122;&#322;',
            'PYG' => '&#71;&#115;',
            'QAR' => '&#65020;',
            'RON' => '&#108;&#101;&#105;',
            'RSD' => '&#1044;&#1080;&#1085;&#46;',
            'RUB' => '&#1088;&#1091;&#1073;',
            'RWF' => '&#1585;.&#1587;',
            'SAR' => '&#65020;',
            'SBD' => '&#36;',
            'SCR' => '&#8360;',
            'SDG' => '&#163;', // ?
            'SEK' => '&#107;&#114;',
            'SGD' => '&#36;',
            'SHP' => '&#163;',
            'SLL' => '&#76;&#101;', // ?
            'SOS' => '&#83;',
            'SRD' => '&#36;',
            'STD' => '&#68;&#98;', // ?
            'SVC' => '&#36;',
            'SYP' => '&#163;',
            'SZL' => '&#76;', // ?
            'THB' => '&#3647;',
            'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
            'TMT' => '&#109;',
            'TND' => '&#1583;.&#1578;',
            'TOP' => '&#84;&#36;',
            'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
            'TTD' => '&#36;',
            'TWD' => '&#78;&#84;&#36;',
            'TZS' => '',
            'UAH' => '&#8372;',
            'UGX' => '&#85;&#83;&#104;',
            'USD' => '&#36;',
            'UYU' => '&#36;&#85;',
            'UZS' => '&#1083;&#1074;',
            'VEF' => '&#66;&#115;',
            'VND' => '&#8363;',
            'VUV' => '&#86;&#84;',
            'WST' => '&#87;&#83;&#36;',
            'XAF' => '&#70;&#67;&#70;&#65;',
            'XCD' => '&#36;',
            'XDR' => '',
            'XOF' => '',
            'XPF' => '&#70;',
            'YER' => '&#65020;',
            'ZAR' => '&#82;',
            'ZMK' => '&#90;&#75;', // ?
            'ZWL' => '&#90;&#36;',
          );

        return html_entity_decode($currency_symbols[$code]);

      }
  
    function currencies(){
      $currency_symbols = array(
          'AED' => html_entity_decode('&#1583;.&#1573;'), // ?
          'AFN' => html_entity_decode('&#65;&#102;'),
          'ALL' => html_entity_decode('&#76;&#101;&#107;'),
          'AMD' => html_entity_decode(''),
          'ANG' => html_entity_decode('&#402;'),
          'AOA' => html_entity_decode('&#75;&#122;'), // ?
          'ARS' => html_entity_decode('&#36;'),
          'AUD' => html_entity_decode('&#36;'),
          'AWG' => html_entity_decode('&#402;'),
          'AZN' => html_entity_decode('&#1084;&#1072;&#1085;'),
          'BAM' => html_entity_decode('&#75;&#77;'),
          'BBD' => html_entity_decode('&#36;'),
          'BDT' => html_entity_decode('&#2547;'), // ?
          'BGN' => html_entity_decode('&#1083;&#1074;'),
          'BHD' => html_entity_decode('.&#1583;.&#1576;'), // ?
          'BIF' => html_entity_decode('&#70;&#66;&#117;'), // ?
          'BMD' => html_entity_decode('&#36;'),
          'BND' => html_entity_decode('&#36;'),
          'BOB' => html_entity_decode('&#36;&#98;'),
          'BRL' => html_entity_decode('&#82;&#36;'),
          'BSD' => html_entity_decode('&#36;'),
          'BTN' => html_entity_decode('&#78;&#117;&#46;'), // ?
          'BWP' => html_entity_decode('&#80;'),
          'BYR' => html_entity_decode('&#112;&#46;'),
          'BZD' => html_entity_decode('&#66;&#90;&#36;'),
          'CAD' => html_entity_decode('&#36;'),
          'CDF' => html_entity_decode('&#70;&#67;'),
          'CHF' => html_entity_decode('&#67;&#72;&#70;'),
          'CLF' => html_entity_decode(''), // ?
          'CLP' => html_entity_decode('&#36;'),
          'CNY' => html_entity_decode('&#165;'),
          'COP' => html_entity_decode('&#36;'),
          'CRC' => html_entity_decode('&#8353;'),
          'CUP' => html_entity_decode('&#8396;'),
          'CVE' => html_entity_decode('&#36;'), // ?
          'CZK' => html_entity_decode('&#75;&#269;'),
          'DJF' => html_entity_decode('&#70;&#100;&#106;'), // ?
          'DKK' => html_entity_decode('&#107;&#114;'),
          'DOP' => html_entity_decode('&#82;&#68;&#36;'),
          'DZD' => html_entity_decode('&#1583;&#1580;'), // ?
          'EGP' => html_entity_decode('&#163;'),
          'ETB' => html_entity_decode('&#66;&#114;'),
          'EUR' => html_entity_decode('&#8364;'),
          'FJD' => html_entity_decode('&#36;'),
          'FKP' => html_entity_decode('&#163;'),
          'GBP' => html_entity_decode('&#163;'),
          'GEL' => html_entity_decode('&#4314;'), // ?
          'GHS' => html_entity_decode('&#162;'),
          'GIP' => html_entity_decode('&#163;'),
          'GMD' => html_entity_decode('&#68;'), // ?
          'GNF' => html_entity_decode('&#70;&#71;'), // ?
          'GTQ' => html_entity_decode('&#81;'),
          'GYD' => html_entity_decode('&#36;'),
          'HKD' => html_entity_decode('&#36;'),
          'HNL' => html_entity_decode('&#76;'),
          'HRK' => html_entity_decode('&#107;&#110;'),
          'HTG' => html_entity_decode('&#71;'), // ?
          'HUF' => html_entity_decode('&#70;&#116;'),
          'IDR' => html_entity_decode('&#82;&#112;'),
          'ILS' => html_entity_decode('&#8362;'),
          'INR' => html_entity_decode('&#8377;'),
          'IQD' => html_entity_decode('&#1593;.&#1583;'), // ?
          'IRR' => html_entity_decode('&#65020;'),
          'ISK' => html_entity_decode('&#107;&#114;'),
          'JEP' => html_entity_decode('&#163;'),
          'JMD' => html_entity_decode('&#74;&#36;'),
          'JOD' => html_entity_decode('&#74;&#68;'), // ?
          'JPY' => html_entity_decode('&#165;'),
          'KES' => html_entity_decode('&#75;&#83;&#104;'), // ?
          'KGS' => html_entity_decode('&#1083;&#1074;'),
          'KHR' => html_entity_decode('&#6107;'),
          'KMF' => html_entity_decode('&#67;&#70;'), // ?
          'KPW' => html_entity_decode('&#8361;'),
          'KRW' => html_entity_decode('&#8361;'),
          'KWD' => html_entity_decode('&#1583;.&#1603;'), // ?
          'KYD' => html_entity_decode('&#36;'),
          'KZT' => html_entity_decode('&#1083;&#1074;'),
          'LAK' => html_entity_decode('&#8365;'),
          'LBP' => html_entity_decode('&#163;'),
          'LKR' => html_entity_decode('&#8360;'),
          'LRD' => html_entity_decode('&#36;'),
          'LSL' => html_entity_decode('&#76;'), // ?
          'LTL' => html_entity_decode('&#76;&#116;'),
          'LVL' => html_entity_decode('&#76;&#115;'),
          'LYD' => html_entity_decode('&#1604;.&#1583;'), // ?
          'MAD' => html_entity_decode('&#1583;.&#1605;.'), //?
          'MDL' => html_entity_decode('&#76;'),
          'MGA' => html_entity_decode('&#65;&#114;'), // ?
          'MKD' => html_entity_decode('&#1076;&#1077;&#1085;'),
          'MMK' => html_entity_decode('&#75;'),
          'MNT' => html_entity_decode('&#8366;'),
          'MOP' => html_entity_decode('&#77;&#79;&#80;&#36;'), // ?
          'MRO' => html_entity_decode('&#85;&#77;'), // ?
          'MUR' => html_entity_decode('&#8360;'), // ?
          'MVR' => html_entity_decode('.&#1923;'), // ?
          'MWK' => html_entity_decode('&#77;&#75;'),
          'MXN' => html_entity_decode('&#36;'),
          'MYR' => html_entity_decode('&#82;&#77;'),
          'MZN' => html_entity_decode('&#77;&#84;'),
          'NAD' => html_entity_decode('&#36;'),
          'NGN' => html_entity_decode('&#8358;'),
          'NIO' => html_entity_decode('&#67;&#36;'),
          'NOK' => html_entity_decode('&#107;&#114;'),
          'NPR' => html_entity_decode('&#8360;'),
          'NZD' => html_entity_decode('&#36;'),
          'OMR' => html_entity_decode('&#65020;'),
          'PAB' => html_entity_decode('&#66;&#47;&#46;'),
          'PEN' => html_entity_decode('&#83;&#47;&#46;'),
          'PGK' => html_entity_decode('&#75;'), // ?
          'PHP' => html_entity_decode('&#8369;'),
          'PKR' => html_entity_decode('&#8360;'),
          'PLN' => html_entity_decode('&#122;&#322;'),
          'PYG' => html_entity_decode('&#71;&#115;'),
          'QAR' => html_entity_decode('&#65020;'),
          'RON' => html_entity_decode('&#108;&#101;&#105;'),
          'RSD' => html_entity_decode('&#1044;&#1080;&#1085;&#46;'),
          'RUB' => html_entity_decode('&#1088;&#1091;&#1073;'),
          'RWF' => html_entity_decode('&#1585;.&#1587;'),
          'SAR' => html_entity_decode('&#65020;'),
          'SBD' => html_entity_decode('&#36;'),
          'SCR' => html_entity_decode('&#8360;'),
          'SDG' => html_entity_decode('&#163;'), // ?
          'SEK' => html_entity_decode('&#107;&#114;'),
          'SGD' => html_entity_decode('&#36;'),
          'SHP' => html_entity_decode('&#163;'),
          'SLL' => html_entity_decode('&#76;&#101;'), // ?
          'SOS' => html_entity_decode('&#83;'),
          'SRD' => html_entity_decode('&#36;'),
          'STD' => html_entity_decode('&#68;&#98;'), // ?
          'SVC' => html_entity_decode('&#36;'),
          'SYP' => html_entity_decode('&#163;'),
          'SZL' => html_entity_decode('&#76;'), // ?
          'THB' => html_entity_decode('&#3647;'),
          'TJS' => html_entity_decode('&#84;&#74;&#83;'), // ? TJS (guess)
          'TMT' => html_entity_decode('&#109;'),
          'TND' => html_entity_decode('&#1583;.&#1578;'),
          'TOP' => html_entity_decode('&#84;&#36;'),
          'TRY' => html_entity_decode('&#8356;'), // New Turkey Lira (old symbol used)
          'TTD' => html_entity_decode('&#36;'),
          'TWD' => html_entity_decode('&#78;&#84;&#36;'),
          'TZS' => html_entity_decode(''),
          'UAH' => html_entity_decode('&#8372;'),
          'UGX' => html_entity_decode('&#85;&#83;&#104;'),
          'USD' => html_entity_decode('&#36;'),
          'UYU' => html_entity_decode('&#36;&#85;'),
          'UZS' => html_entity_decode('&#1083;&#1074;'),
          'VEF' => html_entity_decode('&#66;&#115;'),
          'VND' => html_entity_decode('&#8363;'),
          'VUV' => html_entity_decode('&#86;&#84;'),
          'WST' => html_entity_decode('&#87;&#83;&#36;'),
          'XAF' => html_entity_decode('&#70;&#67;&#70;&#65;'),
          'XCD' => html_entity_decode('&#36;'),
          'XDR' => html_entity_decode(''),
          'XOF' => html_entity_decode(''),
          'XPF' => html_entity_decode('&#70;'),
          'YER' => html_entity_decode('&#65020;'),
          'ZAR' => html_entity_decode('&#82;'),
          'ZMK' => html_entity_decode('&#90;&#75;'), // ?
          'ZWL' => html_entity_decode('&#90;&#36;'),
        );

      return $currency_symbols;

    }
  
    function vat_dat(){
        $vat_data = '{"AF":{"country":"Afghanistan","rate":0,"name":"VAT"},"AL":{"country":"Albania","rate":20,"name":"VAT"},"DZ":{"country":"Algeria","rate":19,"name":"VAT"},"AS":{"country":"American Samoa","rate":0,"name":"VAT"},"AD":{"country":"Andora","rate":4.5,"name":"VAT"},"AO":{"country":"Angora","rate":10,"name":"VAT"},"AI":{"country":"Anguilla","rate":0,"name":"VAT"},"AR":{"country":"Argentina","rate":21,"name":"VAT"},"AM":{"country":"Armenia","rate":20,"name":"VAT"},"AW":{"country":"Aruba","rate":1.5,"name":"VAT"},"AU":{"country":"Australia","rate":10,"name":"VAT"},"AT":{"country":"Austria","rate":20,"name":"VAT","eu":"true"},"AZ":{"country":"Azerbaijan","rate":18,"name":"VAT"},"BS":{"country":"Bahamas","rate":20,"name":"VAT"},"BD":{"country":"Bangladesh","rate":15,"name":"VAT"},"BB":{"country":"Barbados","rate":17.5,"name":"VAT"},"BH":{"country":"Bahrain","rate":5,"name":"VAT"},"BY":{"country":"Belarus","rate":20,"name":"VAT"},"BE":{"country":"Belgium","rate":21,"name":"VAT","eu":"true"},"BZ":{"country":"Belize","rate":12.5,"name":"VAT"},"BJ":{"country":"Benin","rate":18,"name":"VAT"},"BM":{"country":"Bermuda","rate":0,"name":"VAT"},"BT":{"country":"Bhutan","rate":0,"name":"VAT"},"BO":{"country":"Bolivia","rate":13,"name":"VAT"},"BA":{"country":"Bosnia and Herzegovina","rate":17,"name":"VAT"},"BW":{"country":"Botswana","rate":12,"name":"VAT"},"BR":{"country":"Brazil","rate":25,"name":"VAT"},"BN":{"country":"Brunei","rate":0,"name":"VAT"},"BG":{"country":"Bulgaria","rate":20,"name":"VAT","eu":"true"},"BF":{"country":"Burkina Faso","rate":18,"name":"VAT"},"BI":{"country":"Burundi","rate":18,"name":"VAT"},"KH":{"country":"Cambodia","rate":10,"name":"VAT"},"CM":{"country":"Cameroon","rate":19.25,"name":"VAT"},"CA":{"country":"Canada","rate":15,"name":"VAT"},"CV":{"country":"Cape Verde","rate":15,"name":"VAT"},"KY":{"country":"Cayman Islands","rate":0,"name":"VAT"},"CF":{"country":"Central African Republic","rate":19,"name":"VAT"},"TD":{"country":"Chad","rate":0,"name":"VAT"},"CL":{"country":"Chile","rate":19,"name":"VAT"},"CN":{"country":"China","rate":17,"name":"VAT"},"CO":{"country":"Colombia","rate":19,"name":"VAT"},"KM":{"country":"Comoros","rate":0,"name":"VAT"},"CK":{"country":"Cook Islands","rate":15,"name":"VAT"},"DRC":{"country":"Democratic Republic of the Congo","rate":0,"name":"VAT"},"CG":{"country":"Congo","rate":0,"name":"VAT"},"CR":{"country":"Costa Rica","rate":13,"name":"VAT"},"HR":{"country":"Croatia","rate":25,"name":"VAT","eu":"true"},"CU":{"country":"Cuba","rate":20,"name":"VAT"},"CW":{"country":"Cura\u00e7ao","rate":0,"name":"VAT"},"CY":{"country":"Cyprus","rate":19,"name":"VAT","eu":"true"},"CZ":{"country":"Czech Republic","rate":21,"name":"VAT","eu":"true"},"DK":{"country":"Denmark","rate":25,"name":"VAT","eu":"true"},"DJ":{"country":"Djibouti","rate":0,"name":"VAT"},"DM":{"country":"Dominica","rate":0,"name":"VAT"},"DO":{"country":"Dominican Republic","rate":18,"name":"VAT"},"TP":{"country":"Timor-Leste","rate":0,"name":"VAT"},"EC":{"country":"Ecuador","rate":12,"name":"VAT"},"EG":{"country":"Egypt","rate":14,"name":"VAT"},"SV":{"country":"El Salvador","rate":13,"name":"VAT"},"GQ":{"country":"Equatorial Guinea","rate":0,"name":"VAT"},"ER":{"country":"Eritrea","rate":0,"name":"VAT"},"EE":{"country":"Estonia","rate":20,"name":"VAT","eu":"true"},"ET":{"country":"Ethiopia","rate":0,"name":"VAT"},"FK":{"country":"Falkland Islands","rate":0,"name":"VAT"},"fsm":{"country":"F.S. Micronesia","rate":0,"name":"VAT"},"FJ":{"country":"Fiji","rate":9,"name":"VAT"},"FI":{"country":"Finland","rate":24,"name":"VAT","eu":"true"},"FR":{"country":"France","rate":20,"name":"VAT","eu":"true"},"GA":{"country":"Gabon","rate":18,"name":"VAT"},"GM":{"country":"Gambia","rate":0,"name":"VAT"},"DE":{"country":"Germany","rate":19,"name":"VAT","eu":"true"},"GE":{"country":"Georgia","rate":18,"name":"VAT"},"GH":{"country":"Ghana","rate":0,"name":"VAT"},"GI":{"country":"Gibraltar","rate":0,"name":"VAT"},"GR":{"country":"Greece","rate":24,"name":"VAT","eu":"true"},"GD":{"country":"Grenada","rate":0,"name":"VAT"},"GT":{"country":"Guatemala","rate":12,"name":"VAT"},"GN":{"country":"Guinea","rate":0,"name":"VAT"},"GW":{"country":"Guinea-Bissau","rate":0,"name":"VAT"},"GY":{"country":"Guyana","rate":16,"name":"VAT"},"GG":{"country":"Guernsey","rate":0,"name":"VAT"},"HT":{"country":"Haiti","rate":0,"name":"VAT"},"HN":{"country":"Honduras","rate":0,"name":"VAT"},"HKO":{"country":"Hong Kong","rate":0,"name":"VAT"},"HU":{"country":"Hungary","rate":27,"name":"VAT","eu":"true"},"IS":{"country":"Iceland","rate":24,"name":"VAT"},"IN":{"country":"India","rate":28,"name":"VAT"},"ID":{"country":"Indonesia","rate":10,"name":"VAT"},"IR":{"country":"Iran","rate":9,"name":"VAT"},"IQ":{"country":"Iraq","rate":0,"name":"VAT"},"IE":{"country":"Ireland","rate":13.5,"name":"VAT","eu":"true"},"IM":{"country":"Isle of Man","rate":20,"name":"VAT"},"IL":{"country":"Israel","rate":17,"name":"VAT"},"IT":{"country":"Italy","rate":22,"name":"VAT","eu":"true"},"CI":{"country":"Ivory Coast","rate":0,"name":"VAT"},"JM":{"country":"Jamaica","rate":0,"name":"VAT"},"JP":{"country":"Japan","rate":8,"name":"VAT"},"JE":{"country":"Jersey","rate":5,"name":"VAT"},"JO":{"country":"Jordan","rate":16,"name":"GST"},"KZ":{"country":"Kazakhstan","rate":12,"name":"VAT"},"KE":{"country":"Kenya","rate":16,"name":"VAT"},"KI":{"country":"Kiribati","rate":0,"name":"VAT"},"KW":{"country":"Kuwait","rate":0,"name":"VAT"},"KR":{"country":"South Korea","rate":10,"name":"VAT"},"KP":{"country":"North Korea","rate":4,"name":"VAT"},"KG":{"country":"Kyrgyzstan","rate":0,"name":"VAT"},"LA":{"country":"Laos","rate":0,"name":"VAT"},"LV":{"country":"Latvia","rate":21,"name":"VAT","eu":"true"},"LB":{"country":"Lebanon","rate":10,"name":"VAT"},"LS":{"country":"Lesotho","rate":0,"name":"VAT"},"LR":{"country":"Liberia","rate":0,"name":"VAT"},"LY":{"country":"Libya","rate":0,"name":"VAT"},"LI":{"country":"Liechtenstein","rate":8,"name":"VAT"},"LT":{"country":" Lithuania","rate":21,"name":"VAT","eu":"true"},"LU":{"country":"Luxembourg","rate":17,"name":"VAT","eu":"true"},"MO":{"country":"Macau","rate":0,"name":"VAT"},"MK":{"country":"Macedonia","rate":18,"name":"VAT"},"MG":{"country":"Madagascar","rate":0,"name":"VAT"},"MW":{"country":"Malawi","rate":0,"name":"VAT"},"MY":{"country":"Malaysia","rate":0,"name":"GST"},"MV":{"country":"Maldives","rate":6,"name":"VAT"},"ML":{"country":"Mali","rate":0,"name":"VAT"},"MT":{"country":"Malta","rate":18,"name":"VAT","eu":"true"},"MH":{"country":"Marshall Islands","rate":4,"name":"VAT"},"MR":{"country":"Mauritania","rate":0,"name":"VAT"},"MU":{"country":"Mauritius","rate":15,"name":"VAT"},"MX":{"country":"Mexico","rate":16,"name":"VAT"},"MD":{"country":"Moldova ","rate":20,"name":"VAT"},"MC":{"country":"Monaco","rate":19.6,"name":"VAT"},"MN":{"country":"Mongolia","rate":10,"name":"VAT"},"ME":{"country":"Montenegro","rate":19,"name":"VAT"},"MS":{"country":"Montserrat","rate":0,"name":"VAT"},"MA":{"country":"Morocco","rate":0,"name":"VAT"},"MZ":{"country":"Mozambique","rate":0,"name":"VAT"},"MM":{"country":"Myanmar","rate":0,"name":"VAT"},"NA":{"country":"Namibia","rate":0,"name":"VAT"},"NR":{"country":"Nauru","rate":0,"name":"VAT"},"NP":{"country":"Nepal","rate":13,"name":"VAT"},"NL":{"country":"Netherlands","rate":21,"name":"VAT","eu":"true"},"NZ":{"country":"New Zealand","rate":0,"name":"GST"},"NC":{"country":"New Caledonia","rate":0,"name":"VAT"},"NI":{"country":"Nicaragua","rate":0,"name":"VAT"},"NE":{"country":"Niger","rate":0,"name":"VAT"},"NG":{"country":"Nigeria","rate":5,"name":"VAT"},"NU":{"country":"Niue","rate":12.5,"name":"VAT"},"NF":{"country":"Norfolk Island","rate":0,"name":"VAT"},"NO":{"country":"Norway","rate":10,"name":"VAT"},"OM":{"country":"Oman","rate":5,"name":"VAT"},"PK":{"country":"Pakistan","rate":0,"name":"VAT"},"PW":{"country":"Palau","rate":0,"name":"VAT"},"PS":{"country":"Palestine","rate":14.5,"name":"VAT"},"PA":{"country":"Panama","rate":0,"name":"VAT"},"PG":{"country":"Papua New Guinea","rate":0,"name":"VAT"},"PY":{"country":"Paraguay","rate":10,"name":"VAT"},"PE":{"country":"Peru","rate":18,"name":"VAT"},"PH":{"country":"Philippines","rate":12,"name":"VAT"},"PN":{"country":"Pitcairn Islands","rate":0,"name":"VAT"},"PL":{"country":"Poland","rate":23,"name":"VAT","eu":"true"},"PT":{"country":"Portugal","rate":23,"name":"VAT","eu":"true"},"PR":{"country":"Puerto Rico","rate":11.5,"name":"VAT"},"QA":{"country":"Qatar","rate":0,"name":"VAT"},"RO":{"country":"Romania","rate":19,"name":"VAT","eu":"true"},"Ru":{"country":"Russia","rate":18,"name":"VAT"},"RW":{"country":"Rwanda","rate":0,"name":"VAT"},"KN":{"country":"Saint Kitts and Nevis","rate":0,"name":"VAT"},"LC":{"country":"Saint Lucia","rate":0,"name":"VAT"},"PM":{"country":"Saint Pierre and Miquelon","rate":0,"name":"VAT"},"VC":{"country":"Saint Vincent and the Grenadines","rate":0,"name":"VAT"},"WS":{"country":"Samoa","rate":0,"name":"VAT"},"SM":{"country":"San Marino","rate":0,"name":"VAT"},"ST":{"country":"S\u00e3o Tom\u00e9 and Pr\u00edncipe","rate":0,"name":"VAT"},"SAARK":{"country":"Sark","rate":0,"name":"VAT"},"SA":{"country":"Saudi Arabia","rate":5,"name":"VAT"},"SN":{"country":"Senegal","rate":20,"name":"VAT"},"RS":{"country":"Serbia","rate":20,"name":"VAT"},"SC":{"country":"Seychelles","rate":0,"name":"VAT"},"SL":{"country":"Sierra Leone","rate":0,"name":"VAT"},"SG":{"country":"Singapore","rate":7,"name":"GST"},"SX":{"country":"Sint Maarten","rate":0,"name":"VAT"},"SK":{"country":"Slovakia","rate":20,"name":"VAT","eu":"true"},"SI":{"country":"Slovenia","rate":22,"name":"VAT","eu":"true"},"SB":{"country":"Solomon Islands","rate":0,"name":"VAT"},"SO":{"country":"Somalia","rate":0,"name":"VAT"},"ZA":{"country":"South Africa","rate":15,"name":"VAT"},"SD":{"country":"South Sudan","rate":0,"name":"VAT"},"ES":{"country":"Spain","rate":21,"name":"VAT","eu":"true"},"LK":{"country":"Sri Lanka","rate":12,"name":"VAT"},"SU":{"country":"Sudan","rate":0,"name":"VAT"},"SR":{"country":"Suriname","rate":0,"name":"VAT"},"SZ":{"country":"Swaziland","rate":14,"name":"VAT"},"SE":{"country":"Sweden","rate":25,"name":"VAT","eu":"true"},"CH":{"country":"Switzerland","rate":7.7,"name":"VAT"},"SY":{"country":"Syria","rate":0,"name":"VAT"},"TW":{"country":"Taiwan","rate":5,"name":"VAT"},"TJ":{"country":"Tajikistan","rate":0,"name":"VAT"},"TZ":{"country":"Tanzania","rate":18,"name":"VAT"},"TH":{"country":"Thailand","rate":7,"name":"VAT"},"TG":{"country":"Togo","rate":0,"name":"VAT"},"TK":{"country":"Tokelau","rate":0,"name":"VAT"},"TO":{"country":"Tonga","rate":0,"name":"VAT"},"TT":{"country":"Trinidad and Tobago","rate":12.5,"name":"VAT"},"TN":{"country":"Tunisia","rate":18,"name":"VAT"},"TR":{"country":"Turkey","rate":18,"name":"VAT"},"TM":{"country":"Turkmenistan","rate":0,"name":"VAT"},"TC":{"country":"Turks and Caicos Islands","rate":0,"name":"VAT"},"TV":{"country":"Tuvalu","rate":0,"name":"VAT"},"UG":{"country":"Uganda","rate":0,"name":"VAT"},"UA":{"country":"Ukraine","rate":0,"name":"VAT"},"AE":{"country":"United Arab Emirates","rate":0,"name":"VAT"},"UK":{"country":"United Kingdom","rate":20,"name":"VAT","eu":"true"},"US":{"country":"United States of America","state":{"AL":{"state":"Alabama","rate":4,"name":"GST"},"Ak":{"state":"Alaska","rate":0,"name":"GST"},"Az":{"state":"Arizona","rate":4.54,"name":"GST"},"AR":{"state":"Arkansas","rate":6.5,"name":"GST"},"CA":{"state":"California","rate":7.25,"name":"GST"},"CO":{"state":"Colorado","rate":2.9,"name":"GST"},"CT":{"state":"Connecticut","rate":6.35,"name":"GST"},"DE":{"state":"Delaware","rate":0,"name":"GST"},"DC":{"state":"District Of Columbia","rate":5.75,"name":"GST"},"FL":{"state":"Florida","rate":6,"name":"GST"},"GA":{"state":"Georgia","rate":4,"name":"GST"},"HI":{"state":"Hawaii","rate":4,"name":"GST"},"ID":{"state":"Idaho","rate":6,"name":"GST"},"IL":{"state":"Ilinois","rate":6.25,"name":"GST"},"IN":{"state":"Indiana","rate":7,"name":"GST"},"IA":{"state":"Iowa","rate":6,"name":"GST"},"KS":{"state":"Kansas","rate":6.5,"name":"GST"},"KY":{"state":"Kentucky","rate":6,"name":"GST"},"LA":{"state":"Louisiana","rate":5,"name":"GST"},"ME":{"state":"Maine","rate":5.5,"name":"GST"},"MD":{"state":"Maryland","rate":6,"name":"GST"},"MA":{"state":"Massachusetts","rate":6.25,"name":"GST"},"MI":{"state":"Michigan","rate":6,"name":"GST"},"MN":{"state":"Minnesota","rate":6.875,"name":"GST"},"MS":{"state":"Mississippi","rate":7,"name":"GST"},"MO":{"state":"Missouri","rate":4.225,"name":"GST"},"MT":{"state":"Montana","rate":0,"name":"GST"},"NE":{"state":"Nebraska","rate":5.5,"name":"GST"},"NV":{"state":"Nevada","rate":6.85,"name":"GST"},"NH":{"state":"New Hampshire","rate":0,"name":"GST"},"NJ":{"state":"New Jersey","rate":6.63,"name":"GST"},"NM":{"state":"New Mexico","rate":5.125,"name":"GST"},"NY":{"state":"New York","rate":4,"name":"GST"},"NC":{"state":"North Carolina","rate":4.75,"name":"GST"},"ND":{"state":"North Dakota","rate":5,"name":"GST"},"OH":{"state":"Ohio","rate":5.75,"name":"GST"},"OK":{"state":"Oklahoma","rate":4.5,"name":"GST"},"OR":{"state":"Oregon","rate":0,"name":"GST"},"PA":{"state":"Pennsylvania","rate":6,"name":"GST"},"RI":{"state":"Rhode Island","rate":7,"name":"GST"},"SC":{"state":"South Carolina","rate":6,"name":"GST"},"SD":{"state":"South Dakota","rate":4.5,"name":"GST"},"TN":{"state":"Tennessee","rate":7,"name":"GST"},"TX":{"state":"Texas","rate":6.25,"name":"GST"},"UT":{"state":"Utah","rate":5.95,"name":"GST"},"VT":{"state":"Vermont","rate":6,"name":"GST"},"VA":{"state":"Virginia","rate":5.3,"name":"GST"},"WA":{"state":"Washington","rate":6.5,"name":"GST"},"WV":{"state":"West Virginia","rate":6,"name":"GST"},"WI":{"state":"Wisconsin","rate":5,"name":"GST"},"WY":{"state":"Wyoming","rate":4,"name":"GST"}},"rate":23,"name":"GST"},"UY":{"country":"Uruguay","rate":22,"name":"VAT"},"UZ":{"country":"Uzbekistan","rate":20,"name":"VAT"},"VU":{"country":"Vanuatu","rate":0,"name":"VAT"},"VE":{"country":"Venezuela","rate":9,"name":"VAT"},"VN":{"country":"Vietnam","rate":10,"name":"VAT"},"VG":{"country":"British Virgin Islands","rate":0,"name":"VAT"},"VI":{"country":"U.S. Virgin Islands","rate":0,"name":"VAT"},"YE":{"country":"Yemen","rate":2,"name":"VAT"},"ZM":{"country":"Zambia","rate":16,"name":"VAT"},"ZW":{"country":"Zimbabwe","rate":0,"name":"VAT"}}';
        $vat_data = json_decode($vat_data);
        $vat_data = (array)$vat_data;
        $vat_data['US'] = (array)$vat_data['US'];  
      
        return $vat_data;
    }
	
    function countries(){
        return array('AF'=>'AFGHANISTAN',
                     'AL'=>'ALBANIA',
                    'DZ'=>'ALGERIA',
                    'AS'=>'AMERICAN SAMOA',
                    'AD'=>'ANDORRA',
                    'AO'=>'ANGOLA',
                    'AI'=>'ANGUILLA',
                    'AQ'=>'ANTARCTICA',
                    'AG'=>'ANTIGUA AND BARBUDA',
                    'AR'=>'ARGENTINA',
                    'AM'=>'ARMENIA',
                    'AW'=>'ARUBA',
                    'AC'=>'ASCENSION ISLAND',
                    'AU'=>'AUSTRALIA',
                    'AT'=>'AUSTRIA',
                    'AZ'=>'AZERBAIJAN',
                    'BS'=>'BAHAMAS',
                    'BH'=>'BAHRAIN',
                    'BD'=>'BANGLADESH',
                    'BB'=>'BARBADOS',
                    'BY'=>'BELARUS',
                    'BE'=>'BELGIUM',
                    'BZ'=>'BELIZE',
                    'BJ'=>'BENIN',
                    'BM'=>'BERMUDA',
                    'BT'=>'BHUTAN',
                    'BO'=>'BOLIVIA',
                    'BA'=>'BOSNIA AND HERZEGOWINA',
                    'BW'=>'BOTSWANA',
                    'BV'=>'BOUVET ISLAND',
                    'BR'=>'BRAZIL',
                    'IO'=>'BRITISH INDIAN OCEAN TERRITORY',
                    'BN'=>'BRUNEI DARUSSALAM',
                    'BG'=>'BULGARIA',
                    'BF'=>'BURKINA FASO',
                    'BI'=>'BURUNDI',
                    'KH'=>'CAMBODIA',
                    'CM'=>'CAMEROON',
                    'CA'=>'CANADA',
                    'CV'=>'CAPE VERDE',
                    'KY'=>'CAYMAN ISLANDS',
                    'CF'=>'CENTRAL AFRICAN REPUBLIC',
                    'TD'=>'CHAD',
                    'CL'=>'CHILE',
                    'CN'=>'CHINA',
                    'CX'=>'CHRISTMAS ISLAND',
                    'CC'=>'COCOS (KEELING) ISLANDS',
                    'CO'=>'COLOMBIA',
                    'KM'=>'COMOROS',
                    'CD'=>'CONGO THE DEMOCRATIC REPUBLIC OF THE',
                    'CG'=>'CONGO',
                    'CK'=>'COOK ISLANDS',
                    'CR'=>'COSTA RICA',
                    'CI'=>'COTE D\'IVOIRE',
                    'HR'=>'CROATIA',
                    'CU'=>'CUBA',
                    'CY'=>'CYPRUS',
                    'CZ'=>'CZECH REPUBLIC',
                    'DK'=>'DENMARK',
                    'DJ'=>'DJIBOUTI',
                    'DM'=>'DOMINICA',
                    'DO'=>'DOMINICAN REPUBLIC',
                    'TP'=>'EAST TIMOR',
                    'EC'=>'ECUADOR',
                    'EG'=>'EGYPT',
                    'SV'=>'EL SALVADOR',
                    'GQ'=>'EQUATORIAL GUINEA',
                    'ER'=>'ERITREA',
                    'EE'=>'ESTONIA',
                    'ET'=>'ETHIOPIA',
                    'EU'=>'EUROPEAN UNION',
                    'FK'=>'FALKLAND ISLANDS (MALVINAS)',
                    'FO'=>'FAROE ISLANDS',
                    'FJ'=>'FIJI',
                    'FI'=>'FINLAND',
                    'FX'=>'FRANCE METRO',
                    'FR'=>'FRANCE',
                    'GF'=>'FRENCH GUIANA',
                    'PF'=>'FRENCH POLYNESIA',
                    'TF'=>'FRENCH SOUTHERN TERRITORIES',
                    'GA'=>'GABON',
                    'GM'=>'GAMBIA',
                    'GE'=>'GEORGIA',
                    'DE'=>'GERMANY',
                    'GH'=>'GHANA',
                    'GI'=>'GIBRALTAR',
                    'GR'=>'GREECE',
                    'GL'=>'GREENLAND',
                    'GD'=>'GRENADA',
                    'GP'=>'GUADELOUPE',
                    'GU'=>'GUAM',
                    'GT'=>'GUATEMALA',
                    'GG'=>'GUERNSEY',
                    'GN'=>'GUINEA',
                    'GW'=>'GUINEA-BISSAU',
                    'GY'=>'GUYANA',
                    'HT'=>'HAITI',
                    'HM'=>'HEARD AND MC DONALD ISLANDS',
                    'VA'=>'HOLY SEE (VATICAN CITY STATE)',
                    'HN'=>'HONDURAS',
                    'HK'=>'HONG KONG',
                    'HU'=>'HUNGARY',
                    'IS'=>'ICELAND',
                    'IN'=>'INDIA',
                    'ID'=>'INDONESIA',
                    'IR'=>'IRAN (ISLAMIC REPUBLIC OF)',
                    'IQ'=>'IRAQ',
                    'IE'=>'IRELAND',
                    'IM'=>'ISLE OF MAN',
                    'IL'=>'ISRAEL',
                    'IT'=>'ITALY',
                    'JM'=>'JAMAICA',
                    'JP'=>'JAPAN',
                    'JE'=>'JERSEY',
                    'JO'=>'JORDAN',
                    'KZ'=>'KAZAKHSTAN',
                    'KE'=>'KENYA',
                    'KI'=>'KIRIBATI',
                    'KP'=>'KOREA DEMOCRATIC PEOPLE\'S REPUBLIC OF',
                    'KR'=>'KOREA REPUBLIC OF',
                    'KW'=>'KUWAIT',
                    'KG'=>'KYRGYZSTAN',
                    'LA'=>'LAO PEOPLE\'S DEMOCRATIC REPUBLIC',
                    'LV'=>'LATVIA',
                    'LB'=>'LEBANON',
                    'LS'=>'LESOTHO',
                    'LR'=>'LIBERIA',
                    'LY'=>'LIBYAN ARAB JAMAHIRIYA',
                    'LI'=>'LIECHTENSTEIN',
                    'LT'=>'LITHUANIA',
                    'LU'=>'LUXEMBOURG',
                    'MO'=>'MACAU',
                    'MK'=>'MACEDONIA',
                    'MG'=>'MADAGASCAR',
                    'MW'=>'MALAWI',
                    'MY'=>'MALAYSIA',
                    'MV'=>'MALDIVES',
                    'ML'=>'MALI',
                    'MT'=>'MALTA',
                    'MH'=>'MARSHALL ISLANDS',
                    'MQ'=>'MARTINIQUE',
                    'MR'=>'MAURITANIA',
                    'MU'=>'MAURITIUS',
                    'YT'=>'MAYOTTE',
                    'MX'=>'MEXICO',
                    'FM'=>'MICRONESIA FEDERATED STATES OF',
                    'MD'=>'MOLDOVA REPUBLIC OF',
                    'MC'=>'MONACO',
                    'MN'=>'MONGOLIA',
                    'MS'=>'MONTSERRAT',
                    'MA'=>'MOROCCO',
                    'MZ'=>'MOZAMBIQUE',
                    'MM'=>'MYANMAR',
                    'ME'=>'Montenegro',
                    'NA'=>'NAMIBIA',
                    'NR'=>'NAURU',
                    'NP'=>'NEPAL',
                    'AN'=>'NETHERLANDS ANTILLES',
                    'NL'=>'NETHERLANDS',
                    'NC'=>'NEW CALEDONIA',
                    'NZ'=>'NEW ZEALAND',
                    'NI'=>'NICARAGUA',
                    'NE'=>'NIGER',
                    'NG'=>'NIGERIA',
                    'NU'=>'NIUE',
                    'AP'=>'NON-SPEC ASIA PAS LOCATION',
                    'NF'=>'NORFOLK ISLAND',
                    'MP'=>'NORTHERN MARIANA ISLANDS',
                    'NO'=>'NORWAY',
                    'OM'=>'OMAN',
                    'PK'=>'PAKISTAN',
                    'PW'=>'PALAU',
                    'PS'=>'PALESTINIAN TERRITORY OCCUPIED',
                    'PA'=>'PANAMA',
                    'PG'=>'PAPUA NEW GUINEA',
                    'PY'=>'PARAGUAY',
                    'PE'=>'PERU',
                    'PH'=>'PHILIPPINES',
                    'PN'=>'PITCAIRN',
                    'PL'=>'POLAND',
                    'PT'=>'PORTUGAL',
                    'PR'=>'PUERTO RICO',
                    'QA'=>'QATAR',
                    'ZZ'=>'RESERVED',
                    'RE'=>'REUNION',
                    'RO'=>'ROMANIA',
                    'RU'=>'RUSSIAN FEDERATION',
                    'RW'=>'RWANDA',
                    'KN'=>'SAINT KITTS AND NEVIS',
                    'LC'=>'SAINT LUCIA',
                    'VC'=>'SAINT VINCENT AND THE GRENADINES',
                    'WS'=>'SAMOA',
                    'SM'=>'SAN MARINO',
                    'ST'=>'SAO TOME AND PRINCIPE',
                    'SA'=>'SAUDI ARABIA',
                    'SN'=>'SENEGAL',
                    'SC'=>'SEYCHELLES',
                    'SL'=>'SIERRA LEONE',
                    'SG'=>'SINGAPORE',
                    'SK'=>'SLOVAKIA (SLOVAK REPUBLIC)',
                    'SI'=>'SLOVENIA',
                    'SB'=>'SOLOMON ISLANDS',
                    'SO'=>'SOMALIA',
                    'ZA'=>'SOUTH AFRICA',
                    'GS'=>'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
                    'ES'=>'SPAIN',
                    'LK'=>'SRI LANKA',
                    'SH'=>'ST. HELENA',
                    'PM'=>'ST. PIERRE AND MIQUELON',
                    'SD'=>'SUDAN',
                    'SR'=>'SURINAME',
                    'SJ'=>'SVALBARD AND JAN MAYEN ISLANDS',
                    'SZ'=>'SWAZILAND',
                    'SE'=>'SWEDEN',
                    'CH'=>'SWITZERLAND',
                    'SY'=>'SYRIAN ARAB REPUBLIC',
                    'CS'=>'SERBIA AND MONTENEGRO',
                    'YU'=>'SERBIA AND MONTENEGRO',
                    'RS'=>'Serbia',
                    'TW'=>'TAIWAN; REPUBLIC OF CHINA (ROC)',
                    'TJ'=>'TAJIKISTAN',
                    'TZ'=>'TANZANIA UNITED REPUBLIC OF',
                    'TH'=>'THAILAND',
                    'TL'=>'TIMOR-LESTE',
                    'TG'=>'TOGO',
                    'TK'=>'TOKELAU',
                    'TO'=>'TONGA',
                    'TT'=>'TRINIDAD AND TOBAGO',
                    'TN'=>'TUNISIA',
                    'TR'=>'TURKEY',
                    'TM'=>'TURKMENISTAN',
                    'TC'=>'TURKS AND CAICOS ISLANDS',
                    'TV'=>'TUVALU',
                    'UG'=>'UGANDA',
                    'UA'=>'UKRAINE',
                    'AE'=>'UNITED ARAB EMIRATES',
                    'GB'=>'UNITED KINGDOM',
                    'UK'=>'UNITED KINGDOM',
                    'UM'=>'UNITED STATES MINOR OUTLYING ISLANDS',
                    'US'=>'UNITED STATES',
                    'UY'=>'URUGUAY',
                    'UZ'=>'UZBEKISTAN',
                    'VU'=>'VANUATU',
                    'VE'=>'VENEZUELA',
                    'VN'=>'VIET NAM',
                    'VG'=>'VIRGIN ISLANDS (BRITISH)',
                    'VI'=>'VIRGIN ISLANDS (U.S.)',
                    'WF'=>'WALLIS AND FUTUNA ISLANDS',
                    'EH'=>'WESTERN SAHARA',
                    'YE'=>'YEMEN',
                    'ZM'=>'ZAMBIA',
                    'ZW'=>'ZIMBABWE',
                    'AX'=>'ALAND ISLANDS',
                    'MF'=>'SAINT MARTIN'
                    );
    }	
}