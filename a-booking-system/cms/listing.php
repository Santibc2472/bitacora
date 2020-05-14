<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemListing {
  
    function __construct(){
    }
    
    /*
     *  Get listing data by field & value
     */ 
    function get_data($field,
                      $value) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->listings.' where '.$field.' = %s', array($value)));
            
            return $row;
        }
    }
    
    /*
     *  Get listing posts id
     */ 
    function get_posts($calendars) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            
            if(count($calendars) > 1) {
                $rows = $absdashboardDB->get_results('SELECT post_id,calendar_id FROM '.$absdashboardDB->absd_table->listings.' where calendar_id IN('.$absdashboardclasses->db->escape_array($calendars).')');
            } else {
                $rows = $absdashboardDB->get_results($absdashboardDB->prepare('SELECT post_id,calendar_id FROM '.$absdashboardDB->absd_table->listings.' where calendar_id = %d', array($calendars[0])));
            }
            $listings = array();
          
            foreach($rows as $row) {
                array_push($listings, $row->post_id);
            }
          
            return $listings;
        }
    }
    
    /*
     *  Add listing
     */ 
    function add($data,
                 $user_key) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        global $absdashboardlanguages;
        
        $update_time = date('Y-m-d H:i:s');
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->listings.' where calendar_id = %d AND user_id = %d', array($data['calendar_id'], $data['user_id'])));
            
            if($absdashboardDB->num_rows > 0) {
                $absdashboardDB->update($absdashboardDB->absd_table->listings, $data, array(
                    'calendar_id' => $data['calendar_id'],
                    'user_id' => $data['user_id'],
                    'post_id' => $row->post_id
                ));
            } else {

                if($ABookingSystem['listing_save'] == 'job_listing') {
                    $category = get_term_by('name', $data['category'], 'job_listing_category');
                    $space = get_term_by('name', 'Spaces', 'job_listing_type');
                  
                    if($category != FALSE
                       && $category != null) {
                        $category_id = $category->term_id;
                    } else {
                        $category = wp_insert_term($data['category'], 'job_listing_category');
                        $category_id = $category['term_id'];
                    }
                  
                    if($space != FALSE
                       && $space != null) {
                        $space_id = $space->term_id;
                    } else {
                        $space = wp_insert_term('Spaces', 'job_listing_type');
                        $space_id = $space['term_id'];
                    }
                } else {
                    $category = term_exists($data['category'], 'category' );
                    
                    if ($category == 0 && $category == null) {
                      $category_id = wp_create_category($data['category'], 0);
                    } else {
                      $category_id = get_cat_ID($data['category']);
                    }
                    $space_id = 0;
                }
                
                $user_data = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->options.' where option_name = "user_key" AND option_value = %s', array($user_key)));
                $wp_user_id = $user_data->user_id;
                $saved_posts = array();
                
                foreach($absdashboardlanguages['languages'] as $language) {
                    // Save Post
                    $post_id_translated = $this->save($data,
                                                      $wp_user_id,
                                                      $category_id,
                                                      $space_id,
                                                      $language);
                    $saved_posts[$language] = $post_id_translated;
                }
                
                if(function_exists('pll_save_post_translations')) {
                    pll_save_post_translations($saved_posts);
                }
            }
        }
    }
    
    function save($data,
                  $wp_user_id,
                  $category_id,
                  $space_id,
                  $language = 'en'){
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        $description = $data['description'];

        $add_listing = array(
            'post_title'    => wp_strip_all_tags($data['title']),
            'post_content'  => $description,
            'post_status'   => 'publish',
            'post_author'   => isset($wp_user_id) ? $wp_user_id:0,
            'post_category' => array($category_id),
            'post_type' => $ABookingSystem['listing_save'] == 'default' ? 'absd_'.$data['used_for'].'s':'job_listing',
        );

        $post_id = wp_insert_post( $add_listing );
        
        // Save to pollylang
        if(function_exists('pll_set_post_language')) {
            pll_set_post_language($post_id, $language);
        }
        
        $data['post_id'] = $post_id;
        $categories = array();
        array_push($categories, $category_id);

        // Add category to post
        wp_set_post_categories($post_id, $categories);
        wp_set_post_terms($post_id, $categories, 'job_listing_category');

        if($space_id > 0) {
            $spaces = array();
            array_push($spaces, $space_id);
            wp_set_post_terms($post_id, $spaces, 'job_listing_type');
        }


        $absdashboardDB->insert($absdashboardDB->absd_table->listings, $data);

        if($ABookingSystem['listing_save'] == 'job_listing') {
            // Save meta

            // City
            if ($data['location_city_long'] != '') { 
                if ( ! add_post_meta($post_id, 'geolocation_city', $data['location_city_long'], true ) ) { 
                   update_post_meta($post_id, 'geolocation_city', $data['location_city_long']);
                }
            }

            // Country long
            if ($data['location_country_long'] != '') { 
                if ( ! add_post_meta($post_id, 'geolocation_country_long', $data['location_country_long'], true ) ) { 
                   update_post_meta($post_id, 'geolocation_country_long', $data['location_country_long']);
                }
            }

            // Country
            if ($data['location_country'] != '') { 
                if ( ! add_post_meta($post_id, 'geolocation_country_short', $data['location_country'], true ) ) { 
                   update_post_meta($post_id, 'geolocation_country_short', $data['location_country']);
                }
            }

            $address = $data['location_name'] != '' ? $data['location_name']:$data['address'];

            // Address
            if ($address != '') { 
                if ( ! add_post_meta($post_id, 'geolocation_formatted_address', $address, true ) ) { 
                   update_post_meta($post_id, 'geolocation_formatted_address', $address);
                }

                if ( ! add_post_meta($post_id, '_job_location', $address, true ) ) { 
                   update_post_meta($post_id, '_job_location', $address);
                }
            }

            // Latitude
            if ($data['location_lat'] != '') { 
                if ( ! add_post_meta($post_id, 'geolocation_lat', $data['location_lat'], true ) ) { 
                   update_post_meta($post_id, 'geolocation_lat', $data['location_lat']);
                }
            }

            // Longitude
            if ($data['location_lng'] != '') { 
                if ( ! add_post_meta($post_id, 'geolocation_long', $data['location_lng'], true ) ) { 
                   update_post_meta($post_id, 'geolocation_long', $data['location_lng']);
                }
            }

            // Postal code
            if ($data['location_postal_code'] != '') { 
                if ( ! add_post_meta($post_id, 'geolocation_postcode', $data['location_postal_code'], true ) ) { 
                   update_post_meta($post_id, 'geolocation_postcode', $data['location_postal_code']);
                }
            }

            // State long
            if ($data['location_state_long'] != '') { 
                if ( ! add_post_meta($post_id, 'geolocation_state_long', $data['location_state_long'], true ) ) { 
                   update_post_meta($post_id, 'geolocation_state_long', $data['location_state_long']);
                }
            }

            // State
            if ($data['location_state'] != '') { 
                if ( ! add_post_meta($post_id, 'geolocation_state_short', $data['location_state'], true ) ) { 
                   update_post_meta($post_id, 'geolocation_state_short', $data['location_state']);
                }
            }

            // Street
            if ($data['location_street'] != '') { 
                if ( ! add_post_meta($post_id, 'geolocation_street', $data['location_street'], true ) ) { 
                   update_post_meta($post_id, 'geolocation_street', $data['location_street']);
                }
            }

            // Street
            if ($data['location_street_no'] != '') { 
                if ( ! add_post_meta($post_id, 'geolocation_street_number', $data['location_street_no'], true ) ) { 
                   update_post_meta($post_id, 'geolocation_street_number', $data['location_street_no']);
                }
            }

            // Featured
            $account_type = $absdashboardclasses->option->get('account_type',
                                                      $wp_user_id);
            $featured = $account_type == 'pro' ? 1:0;

            if ( ! add_post_meta($post_id, '_featured', $featured, true ) ) { 
               update_post_meta($post_id, '_featured', $featured);
            }
        }
        
        return $post_id;
    }
    
    /*
     *  Delete listing
     */ 
    function delete($cid,
                    $user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        global $absdashboardlanguages;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $post_id = 0;
            
            if($user_id == 0) {
                $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->listings.' where calendar_id = %d', array($cid)));
              
                if(count($row) > 0) {
                    $post_id = $row->post_id;
                }
            } else {
                $row = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->listings.' where calendar_id = %d AND user_id = %d', array($cid, $user_id)));
              
                if(count($row) > 0) {
                    $post_id = $row->post_id;
                }
            }
                
            // Delete calendars 
            $absdashboardclasses->calendar->delete($cid, $user_id);
            
          
            if($post_id != 0) {
                $delete_posts = array();
                
                if(function_exists('pll_get_post')){
                    // Delete posts for languages
                    foreach($absdashboardlanguages['languages'] as $language) {
                        $post_id_translated = pll_get_post($post_id, $language);
                        $delete_posts[$language] = $post_id_translated;
                    }
                    
                    // Delete posts for languages
                    foreach($delete_posts as $delete_post_id) {
                        wp_delete_post($delete_post_id, true );
                    }
                } else {
                    // Delete post
                    wp_delete_post( $post_id, true );
                }

                // Delete listing
                $absdashboardDB->delete($absdashboardDB->absd_table->listings, array(
                    'calendar_id' => $cid
                ));
              
                return true;
            } else {
                return false;
            }
        }
    }
  
    function delete_api($calendar_id, 
                        $calendar_api_key,
                        $network_website, 
                        $token){
        global $absdashboardclasses;
        
        $result = $absdashboardclasses->http->post("https://".$network_website."/", 
                                          "",
                                         ['network_api' => 'true',
                                          'api_type' => 'delete_calendar',
                                          'calendar_id' => $calendar_id,
                                          'calendar_api_key' => $calendar_api_key],
                                         ['token' => $token]);
        return $result;
    }
    
    /*
     *  Delete listings
     */ 
    function delete_all() {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          $delete = $absdashboardDB->query("TRUNCATE TABLE `".$absdashboardDB->absd_table->listings."`");
        }
    }
    
    /*
     *  Delete listings
     */ 
    function delete_all_for($user_id = 0) {
        global $ABookingSystem;
        global $absdashboardclasses;
        global $absdashboardDB;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
            $absdashboardDB->delete($absdashboardDB->absd_table->listings, array(
                'user_id' => $user_id
            ));
        }
    }
}