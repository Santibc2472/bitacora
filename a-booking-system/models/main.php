<?php
if (!defined('ABSPATH')) exit;

class absdMain {
  
    function __construct(){
    }
    
    /*
     * Display
     */ 
    function display() {
        global $ABookingSystem;
        global $absdashboardclasses;

        $absdashboardclasses->display->view('main');
    }
    
    /*
     * Ajax requests
     */
    function connect(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
        $email = $absdashboardclasses->protect->post('email', 'email');
        $password = $absdashboardclasses->protect->post('password');
        $key = $absdashboardclasses->protect->post('key');
        $token = '';

        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                          "connect",
                                          ['user_key' => $key,
                                           'website' => $ABookingSystem['website']],
                                          ['username' => $email,
                                           'password' => md5($password)]);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $data = json_decode($response);
            $token = $data->token;
            $user_type = $data->user_type;
      
            if($token != '') {

                if($user_type == 'network') {
                    // Network token
                    $absdashboardclasses->option->add('network_token',
                                                      $token,
                                                      '0',
                                                      'network');
                }

                $user_id = $ABookingSystem['user_id'];

                // Email
                $absdashboardclasses->option->add('email',
                                          $email,
                                          $user_id);
                // Password
                $password = str_repeat('*', strlen($password));
                $absdashboardclasses->option->add('password',
                                          $password,
                                          $user_id);
                // User key
                $absdashboardclasses->option->add('user_key',
                                          $key,
                                          $user_id);
                // Token
                $absdashboardclasses->option->add('token',
                                          $token,
                                          $user_id);
                // Account type
                $absdashboardclasses->option->add('account_type',
                                          $user_type,
                                          $user_id);

                // Save network settings
                foreach($data->network as $key => $value) {

                    switch($key) {
                      case 'create_at_register':
                        $key = 'calendar_for_each_user';
                        break;
                      case 'create_for_post':
                        $key = 'calendar_for_each_post';
                        break;
                      case 'create_for_custom_post':
                        $key = 'calendar_for_each_custom_post';
                        break;
                      case 'create_for_custom_post_name':
                        $key = 'calendar_for_each_custom_post_name';
                        break;
                      case 'roles_for_owners':
                        $key = 'owners_roles';
                        break;
                      case 'roles_for_customers':
                        $key = 'customers_roles';
                        break;
                    }

                    $absdashboardclasses->option->add($key,
                                                      $value,
                                                      '0',
                                                      'network');
                }

                // Save user data
                foreach($data->user as $key => $value) {

                    $absdashboardclasses->option->add($key,
                                             $value,
                                             $user_id,
                                             'user');

                    if($user_type == 'network'
                      && $key == 'server') {
                        // Network server
                        $absdashboardclasses->option->add('network_server',
                                                  $value,
                                                 '0',
                                                 'network');
                    }

                    if($user_type == 'network'
                      && $key == 'used_for') {
                        // Network server
                        $absdashboardclasses->option->add('used_for',
                                                  $value,
                                                 '0',
                                                 'network');
                    }
                }

                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
        
        exit;
    }
    
    function disconnect(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
        $role = $ABookingSystem['role'];
        
        if($role == 'admin') {
            // Delete all options
            $absdashboardclasses->option->delete_all();
            // Delete all calendars
            $absdashboardclasses->calendar->delete_all();
            // Delete all tickets
            $absdashboardclasses->ticket->delete_all();
            echo 'success';
        } else {
            echo 'not_allowed';
        }
        
        exit;
    }
    
    function register(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
        
        $fullname           = $absdashboardclasses->protect->post('fullname');
        $company           = $absdashboardclasses->protect->post('company');
        $email              = $absdashboardclasses->protect->post('email', 'email');
        $username           = str_replace('@','', $email);
        $username           = str_replace('.','', $username);
        $password           = $absdashboardclasses->protect->post('password');
        $currency           = $absdashboardclasses->protect->post('currency');
        $website            = get_site_url();
        $country            = $absdashboardclasses->protect->post('country');
        $rfid               = $absdashboardclasses->protect->post('referral_id', 'id', 0);
        
        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                                   "registerwp",
                                                   ['fullname' => $fullname,
                                                    'company' => $company,
                                                    'email' => $email,
                                                    'username' => $username,
                                                    'password' => $password,
                                                    'currency' => $currency,
                                                    'website' => $website,
                                                    'country' => isset($country) ? $country:'']);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $data = json_decode($response);
          
            if($data->status == 'success') {
                $user_id = $ABookingSystem['user_id'];
              
                // User key
                $absdashboardclasses->option->add('user_key',
                                                  $data->user_key,
                                                  $user_id);
                // Token
                $absdashboardclasses->option->add('token',
                                                  $data->token,
                                                  $user_id);
                // Email
                $absdashboardclasses->option->add('email',
                                                  $email,
                                                  $user_id);
                // Password
                $absdashboardclasses->option->add('md5_password',
                                                  md5($password),
                                                  $user_id);
                // Password
                $password = str_repeat('*', strlen($password));
                $absdashboardclasses->option->add('password',
                                                  $password,
                                                  $user_id);
                // Account type
                $absdashboardclasses->option->add('account_type',
                                                  $data->user_type,
                                                  $user_id);
                
                // Save user data
                foreach($data->user as $key => $value) {
                    $absdashboardclasses->option->add($key,
                                                      $value,
                                                      $user_id,
                                                      'user');
                }
            }
      
            echo $response;
            exit;
        }
    }
    
    function detect_country(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
        
        $detect_country = $absdashboardclasses->protect->post('detect_country');
        
        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                                   "ip",
                                                   ['detect_country' => $detect_country,
                                                    'ip' => $absdashboardclasses->protect->ip()]);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            echo $response;
        } else {
            $data = array('status' => 'error');
            echo json_encode($data);
        }
        exit;
    }
  
    function calendars(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
        
        $user_key = $absdashboardclasses->option->get('user_key',
                                          $ABookingSystem['user_id']);

        // Check for updates
        $update = $absdashboardclasses->updates->get('calendars',
                                          '',
                                          $ABookingSystem['user_id']);

        $update = json_decode($update);

        if($update->update != 'false') {
            // Save update
            $update_time = $absdashboardclasses->updates->add('calendars',
                                                   '',
                                                   $ABookingSystem['user_id'],
                                                   $update->time);

            // Get calendars
            $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                             "calendars", 
                                             ['user_key' => $user_key]);
            
            if($result->code == 200 
                || $result->code == 201) {
                $response = $absdashboardclasses->protect->data($result->response, 'json');

                // Delete all calendars
                $absdashboardclasses->calendar->delete_all_for($ABookingSystem['user_id']);
                // Save calendars & categories
                $absdashboardclasses->calendar->save_data($response,
                                                 $ABookingSystem['user_id']);
            }
        }

        $categories = $absdashboardclasses->option->get('categories');
        $categories = $categories != '' ? json_decode($categories):array();

        $language = $absdashboardclasses->option->get('language',
                                          $ABookingSystem['user_id']);

        $data = array('calendars' => $absdashboardclasses->calendar->own($ABookingSystem['user_id']),
                      'currency_rate' => $update->currency_rate,
                      'countries' => $absdashboardclasses->main->countries(),
                      'categories' => $categories,
                      'language' => $language,
                      'link' => $ABookingSystem['api_url'],
                      'network' => $absdashboardclasses->option->get_by_type('network', false));

        echo json_encode($data);
        exit;
    }
  
    function add_calendars(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
      
        if(!strlen($absdashboardclasses->protect->post('name'))){
					
            if(!strlen($absdashboardclasses->protect->post('group_id', 'id'))) {
                echo 'error';
                exit;
            }
        }
      
        $token = $absdashboardclasses->option->get('token',
                                          $ABookingSystem['user_id']);
        $user_id = $ABookingSystem['user_id'];
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
        
        if(strlen($absdashboardclasses->protect->post('name'))) {
            $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                              "calendars",
                                              array('rent_type' => $absdashboardclasses->protect->post('rent_type'),
                                                     'type' => $absdashboardclasses->protect->post('type'),
                                                     'name' => $absdashboardclasses->protect->post('name'),
                                                     'cover' => $absdashboardclasses->protect->post('cover'),
                                                     'description' => $absdashboardclasses->protect->post('description'),
                                                     'address' => $absdashboardclasses->protect->post('address'),
                                                     'location_address' => $absdashboardclasses->protect->post('location_address'),
                                                     'location_country' => $absdashboardclasses->protect->post('location_country'),
                                                     'location_country_long' => $absdashboardclasses->protect->post('location_country_long'),
                                                     'location_state' => $absdashboardclasses->protect->post('location_state'),
                                                     'location_state_long' => $absdashboardclasses->protect->post('location_state_long'),
                                                     'location_city' => $absdashboardclasses->protect->post('location_city'),
                                                     'location_city_long' => $absdashboardclasses->protect->post('location_city_long'),
                                                     'location_latitude' => $absdashboardclasses->protect->post('location_latitude'),
                                                     'location_longitude' => $absdashboardclasses->protect->post('location_longitude'),
                                                     'location_timezone' => $absdashboardclasses->protect->post('location_timezone'),
                                                     'address' => $absdashboardclasses->protect->post('address'),
                                                     'category' => $absdashboardclasses->protect->post('category'),
                                                     'no_rooms' => $absdashboardclasses->protect->post('no_rooms', 'int', 1), 
                                                     'mode' => $absdashboardclasses->protect->post('mode'), 
                                                     'check_in' => $absdashboardclasses->protect->post('check_in'), 
                                                     'check_out' => $absdashboardclasses->protect->post('check_out'), 
                                                     'price' => $absdashboardclasses->protect->post('price', 'float'), 
                                                     'vat' => $absdashboardclasses->protect->post('vat', 'float'),
                                                     'website' => $absdashboardclasses->protect->data($ABookingSystem['website'], 'url'), 
                                                     'ip' => $absdashboardclasses->protect->ip(), 
                                                     'language' => $absdashboardclasses->protect->post('language')),
                                                ['token' => $token]);
        } else {
                $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                                  "calendars",
                                                  ['no_rooms' => $absdashboardclasses->protect->post('no_rooms', 'int', 1), 
                                                   'group_id' => $absdashboardclasses->protect->post('group_id','id'), 
                                                   'language' => $absdashboardclasses->protect->post('language')],
                                                  ['token' => $token]);
        }
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $data = json_decode($response);

            if(isset($data->no_groups)) {
                $absdashboardclasses->option->add('no_groups',
                                          $data->no_groups,
                                          $ABookingSystem['user_id'],
                                          'user');
            }

            if(isset($data->no_calendars)) {
                $absdashboardclasses->option->add('no_calendars',
                                          $data->no_calendars,
                                          $ABookingSystem['user_id'],
                                          'user');
            }
          
            if($data->status == 'success') {
                // Save calendars & categories
                $absdashboardclasses->calendar->save_data($response,
                                                 $ABookingSystem['user_id']);
            }
          
            echo $response;
            exit;
        }
    }
  
    function delete_calendar(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
      
        $calendar_id = $absdashboardclasses->protect->post('id', 'id');
        $calendar_api = $absdashboardclasses->protect->post('api_key');
        
        if(!$calendar_id){
            echo 'error';
            exit;
        }

        // Get Token
        $token = $absdashboardclasses->option->get('token', $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server', $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }

        // Check if is on network website or external
        if ($absdashboardclasses->main->is_network()) {

            $result = $absdashboardclasses->http->delete($ABookingSystem['api_url'], 
                                                "calendar",
                                                ['calendar_id' => $calendar_id,
                                                 'calendar_api' => $calendar_api],
                                                ['token' => $token],
                                                'json');
            
            if($result->code == 200 
               || $result->code == 201) {
                $response = $absdashboardclasses->protect->data($result->response, 'json');
                $data = json_decode($response);

                $absdashboardclasses->option->add('no_groups',
                                          $data->no_groups,
                                          $ABookingSystem['user_id'],
                                          'user');

                $absdashboardclasses->option->add('no_calendars',
                                          $data->no_calendars,
                                          $ABookingSystem['user_id'],
                                          'user');
                // Delete listing 
                $absdashboardclasses->listing->delete($calendar_id,
                                             $ABookingSystem['user_id']);

                echo $response;
                exit;
            }
        } else {
            $network_website = $absdashboardclasses->option->get('website');
            $network_website = isset($network_website) && $network_website != '' ? $network_website:'book.eu.com';

            // Delete listing from network api
            $result = $absdashboardclasses->listing->delete_api($calendar_id, 
                                                                $calendar_api,
                                                                $network_website, 
                                                                $token);
            
            if($result->code == 200 
               || $result->code == 201) {
                // Delete calendars 
                $absdashboardclasses->calendar->delete($calendar_id,
                                              $ABookingSystem['user_id']);
                $response = $absdashboardclasses->protect->data($result->response, 'json');
                
                echo $response;
                exit;
            }
        }
    }
  
    function calendar_settings(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
			
        // Server
        $server = $absdashboardclasses->option->get('server', $ABookingSystem['user_id']);

        if(isset($server) 
             && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
      
        $calendar_id = $absdashboardclasses->protect->post('calendar_id', 'id');
        $type = $absdashboardclasses->protect->post('type');
      
        $option_name = 'settings_'.$type.'_'.$calendar_id;
        $update_name = 'settings_update_'.$type.'_'.$calendar_id;
        
      
        // Check for updates
        $update = $absdashboardclasses->updates->get($update_name,
                                            '',
                                            $ABookingSystem['user_id']);
        $update = json_decode($update);
        
        if($update->update != 'false') {
            $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                             "settings",
                                              ['type' => $type,
                                               'calendar_api' => $absdashboardclasses->protect->post('api_key'),
                                               'calendar_id' => $calendar_id,
                                               'is_group' => $absdashboardclasses->protect->post('is_group')]);
            
            if($result->code == 200 
               || $result->code == 201) {
                // Save update
                $update_time = $absdashboardclasses->updates->add($update_name,
                                                         '',
                                                         $ABookingSystem['user_id'],
                                                         $update->time);
                
                $response = $absdashboardclasses->protect->data($result->response, 'json');
                
                // Save settings
                $absdashboardclasses->option->add($option_name,
                                         $response,
                                         $ABookingSystem['user_id'],
                                         'settings');
            }
        }

        $data = $absdashboardclasses->option->get($option_name, $ABookingSystem['user_id']);
//        $data = str_replace('""""', '"\"\""', $data);
        
        echo $data;
        exit;
    }
  
    function calendar_settings_save(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;

        $token = $absdashboardclasses->option->get('token', $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
      
        $calendar_id = $absdashboardclasses->protect->post('calendar_id', 'id');
        $type = $absdashboardclasses->protect->post('type');
      
        $option_name = 'settings_'.$type.'_'.$calendar_id;
        $update_name = 'settings_update_'.$type.'_'.$calendar_id;
        $to_save_data = $absdashboardclasses->protect->post('data', 'json');
        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                          "settings",
                                          ['type' => $type,
                                           'calendar_api' => $absdashboardclasses->protect->post('api_key'),
                                           'calendar_id' => $calendar_id,
                                           'is_group' => $absdashboardclasses->protect->post('is_group'),
                                           'data' => $to_save_data],
                                          ['token' => $token]);
      
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
      
            $update_time = date('Y-m-d H:i:s');

            $data = $to_save_data;
            $data = stripslashes($data);
          
            $response_data = json_decode($response);
          
            $modified_calendars = array();
            
            if(isset($response_data->calendars)) {
              $modified_calendars = $response_data->calendars;
            }
          
            if(!empty($modified_calendars) > 0) {
                
                foreach($modified_calendars as $calendar_id) {
                    $option_name = 'settings_'.$type.'_'.$calendar_id;
                    $update_name = 'settings_update_'.$type.'_'.$calendar_id;

                    // Save update
                    $update_time = $absdashboardclasses->updates->add($update_name,
                                                             '',
                                                             $ABookingSystem['user_id'],
                                                             $update_time);

                    // Save settings
                    $absdashboardclasses->option->add($option_name,
                                             $data,
                                             $ABookingSystem['user_id'],
                                             'settings');
                }
            } else {
                // Save update
                $update_time = $absdashboardclasses->updates->add($update_name,
                                                         '',
                                                         $ABookingSystem['user_id'],
                                                         $update_time);

                // Save settings
                $absdashboardclasses->option->add($option_name,
                                         $data,
                                         $ABookingSystem['user_id'],
                                         'settings');
            }
     
            echo $response;
            exit;
        }
    }
  
    function reservations(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
        
        $token = $absdashboardclasses->option->get('token', $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);

        if(isset($server) 
             && $server != '') {
                $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
      
        $user_key = $absdashboardclasses->option->get('user_key',
                                             $ABookingSystem['user_id']);
      
        $data_reservations = array();
        
        $data_reservations['space'] = $absdashboardclasses->protect->post('space');
        $data_reservations['room'] = $absdashboardclasses->protect->post('room');
      
        if($ABookingSystem['role'] == 'customer') { 
            $data_reservations['customer_id'] = $ABookingSystem['user_id'];
        }
      
        $data_reservations['ip'] = $absdashboardclasses->protect->ip();

        $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                         "reservations",
                                         $data_reservations,
                                         ['token' => $token]);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $data = array();
            $response_data = json_decode($response);
            
            $data['country'] = $response_data->country;
            $data['countries'] = $absdashboardclasses->main->countries();
            $data['reservations'] = $response_data->reservations;
            $data['calendars'] = $absdashboardclasses->calendar->own($ABookingSystem['user_id']);
                    
     
            echo json_encode($data);
            exit;
        }
      
        echo 'error';
        exit;
    }
  
    function add_reservation(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
      
        if(!strlen($absdashboardclasses->protect->post('check_in', 'date'))
            && !strlen($absdashboardclasses->protect->post('check_out', 'date'))
            && !strlen($absdashboardclasses->protect->post('space'))
            && !strlen($absdashboardclasses->protect->post('fullname'))){
            echo 'error';
            exit;
        }
      
        $token = $absdashboardclasses->option->get('token',
                                          $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
        
        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                          "reservation_admin",
                                          ['space' => $absdashboardclasses->protect->post('space'),
                                           'rooms' => $absdashboardclasses->protect->post('rooms'),
                                           'check_in' => $absdashboardclasses->protect->post('check_in', 'date'),
                                           'check_out' => $absdashboardclasses->protect->post('check_out', 'date'),
                                           'items' => 1,
                                           'fullname' => $absdashboardclasses->protect->post('fullname'),
                                           'email' => $absdashboardclasses->protect->post('email', 'email'),
                                           'phone' => $absdashboardclasses->protect->post('phone')],
                                          ['token' => $token]);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            echo $response;
            exit;
        }
    }
  
    function cancel_reservation_by_host(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
      
        $id = $absdashboardclasses->protect->post('id', 'id');
        $api_key = $absdashboardclasses->protect->post('api_key');
        $email = $absdashboardclasses->protect->post('email', 'email');
        
        $token = $absdashboardclasses->option->get('token',
                                                    $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                                    $ABookingSystem['user_id']);

        if(isset($server) 
             && $server != '') {
                $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
      
        if(!isset($id) 
           || !isset($api_key)
           || !isset($email)){
            echo 'error';
        }
        
        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                          "cancel_reservation",
                                          ['id' => $id,
                                           'api_key' => $api_key,
                                           'email' => $email,
                                           'cancelled_by' => 'host'],
                                          ['token' => $token]);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $response_data = json_decode($response);
          
            if($response_data->status == 'success') {
                echo $response;
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
        
        exit;
    }
  
    function extensions(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
			
        // Server
        $server = $absdashboardclasses->option->get('server', $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }

        $token = $absdashboardclasses->option->get('token',
                                                   $ABookingSystem['user_id']);

        $user_key = $absdashboardclasses->option->get('user_key',
                                                      $ABookingSystem['user_id']);

        // Get extensions
        $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                         "extensions", 
                                         ["main_plugin_version" => $ABookingSystem['version']],
                                         ['token' => $token]);
        if($result->code == 200 
         || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            echo $response;
        }
        exit;
    }

    function install_extension(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;

        $id = $absdashboardclasses->protect->post('id');
        $name = $absdashboardclasses->protect->post('name');
        $download_link = $absdashboardclasses->protect->post('download_link');
        
        if(!strlen($download_link)){
            echo 'error';
            exit;
        }
        
        $token = $absdashboardclasses->option->get('token',
                                                    $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                                    $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }

        /*
         * Download
         */
        $tmpName = 'tmp'.uniqid().'.zip';
        $tmpLocationName = $ABookingSystem['plugin_path'].'extensions/'.$tmpName;
        $this->downloadUrlToFile($download_link, $tmpLocationName);

        $zip = new ZipArchive;
        $res = $zip->open($tmpLocationName);
        
        if($res) {
            // Install extension
            $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                                        "extension",
                                                        ['extension_id' => $id,
                                                         'action' => 'install'],
                                                        ['token' => $token]);

            
        
            if($result->code == 200 
                || $result->code == 201) {
                $zip->extractTo($ABookingSystem['plugin_path'].'extensions/');
                $zip->close();
                unlink($tmpLocationName);
            }
        }

        /*
         * Check Loaded Extensions from database
         */
        $db_extensions_loaded = $absdashboardclasses->option->get('extensions_load');
        $db_extensions_loaded = $db_extensions_loaded != '' ? json_decode($db_extensions_loaded):array();
        $db_extensions_loaded = (array)$db_extensions_loaded;
        
        if(!empty($db_extensions_loaded)){
            if(isset($db_extensions_loaded[$name])) {
                $db_extensions_loaded[$name]->enabled = true;
            } else {
                $db_extensions_loaded[$name] = array(
                    'required' => array(
                        'plugins' => array(),
                        'theme' => array()
                    ),
                    'enabled' => true,
                    'version' => 1
                );
            }
        } else {
            $db_extensions_loaded = array(
                $name => array(
                    'required' => array(
                        'plugins' => array(),
                        'theme' => array()
                    ),
                    'enabled' => true,
                    'version' => 1
                )
            );
        }
        $absdashboardclasses->option->add('extensions_load', json_encode($db_extensions_loaded));

        echo 'success';
        exit;
    }


    function downloadUrlToFile($url, $outFileName){   
        if(is_file($url)) {
            copy($url, $outFileName); 
        } else {
            $options = array(
            CURLOPT_FILE    => fopen($outFileName, 'w'),
            CURLOPT_TIMEOUT =>  28800, // set this to 8 hours so we dont timeout on big files
            CURLOPT_URL     => $url
            );

            $ch = curl_init();
            curl_setopt_array($ch, $options);
            curl_exec($ch);
            curl_close($ch);
        }
    }


    function activate_extension(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;

        $id = $absdashboardclasses->protect->post('id');
        $name = $absdashboardclasses->protect->post('name');
        
        if(!strlen($name)){
            echo 'error';
            exit;
        }
        
        $token = $absdashboardclasses->option->get('token',
                                                    $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                                    $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }

        /*
         * Check Loaded Extensions from database
         */
        $db_extensions_loaded = $absdashboardclasses->option->get('extensions_load');
        $db_extensions_loaded = $db_extensions_loaded != '' ? json_decode($db_extensions_loaded):array();
        $db_extensions_loaded = (array)$db_extensions_loaded;
        
        if(!empty($db_extensions_loaded)){
            if(isset($db_extensions_loaded[$name])) {
                $db_extensions_loaded[$name]->enabled = true;
            } else {
                $db_extensions_loaded[$name] = array(
                    'required' => array(
                        'plugins' => array(),
                        'theme' => array()
                    ),
                    'enabled' => true,
                    'version' => 1
                );
            }
        } else {
            $db_extensions_loaded = array(
                $name => array(
                    'required' => array(
                        'plugins' => array(),
                        'theme' => array()
                    ),
                    'enabled' => true,
                    'version' => 1
                )
            );
        }

        // Activate extension
        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                                    "extension",
                                                    ['extension_id' => $id,
                                                    'action' => 'activate'],
                                                    ['token' => $token]);

        if($result->code == 200 
        || $result->code == 201) {
            $absdashboardclasses->option->add('extensions_load', json_encode($db_extensions_loaded));
        }

        echo 'success';
        exit;
    }

    function deactivate_extension(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;

        $id = $absdashboardclasses->protect->post('id');
        $name = $absdashboardclasses->protect->post('name');
        
        if(!strlen($name)){
            echo 'error';
            exit;
        }
        
        $token = $absdashboardclasses->option->get('token',
                                                    $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                                    $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }

        /*
         * Check Loaded Extensions from database
         */
        $db_extensions_loaded = $absdashboardclasses->option->get('extensions_load');
        $db_extensions_loaded = $db_extensions_loaded != '' ? json_decode($db_extensions_loaded):array();
        $db_extensions_loaded = (array)$db_extensions_loaded;
        
        if(!empty($db_extensions_loaded)){
            if(isset($db_extensions_loaded[$name])) {
                $db_extensions_loaded[$name]->enabled = false;
            } else {
                $db_extensions_loaded[$name] = array(
                    'required' => array(
                        'plugins' => array(),
                        'theme' => array()
                    ),
                    'enabled' => false,
                    'version' => 1
                );
            }
        } else {
            $db_extensions_loaded = array(
                $name => array(
                    'required' => array(
                        'plugins' => array(),
                        'theme' => array()
                    ),
                    'enabled' => false,
                    'version' => 1
                )
            );
        }


        // Deactovate extension
        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                                    "extension",
                                                    ['extension_id' => $id,
                                                    'action' => 'deactivate'],
                                                    ['token' => $token]);

        if($result->code == 200 
            || $result->code == 201) {
            $absdashboardclasses->option->add('extensions_load', json_encode($db_extensions_loaded));
        }

        echo 'success';
        exit;
    }
  
    function tickets(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
			
        // Server
        $server = $absdashboardclasses->option->get('server', $ABookingSystem['user_id']);

        if(isset($server) 
             && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }

        $token = $absdashboardclasses->option->get('token',
                                          $ABookingSystem['user_id']);

        $user_key = $absdashboardclasses->option->get('user_key',
                                          $ABookingSystem['user_id']);

        // Check for updates
        $update = $absdashboardclasses->updates->get('tickets',
                                          '',
                                          $ABookingSystem['user_id']);
        $update = json_decode($update);

        if($update->update != 'false') {
            // Save update
            $update_time = $absdashboardclasses->updates->add('tickets',
                                                   '',
                                                   $ABookingSystem['user_id'],
                                                   $update->time);

            // Get calendars
            $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                             "tickets", 
                                             [],
                                             ['token' => $token]);
            if($result->code == 200 
             || $result->code == 201) {
                $response = $absdashboardclasses->protect->data($result->response, 'json');
                // Delete all calendars
                $absdashboardclasses->ticket->delete_all_for($ABookingSystem['user_id']);
                // Save calendars & categories
                $absdashboardclasses->ticket->save_data($response,
                                               $ABookingSystem['user_id']);
            }
        }

        $data = $absdashboardclasses->ticket->own($ABookingSystem['user_id']);

        echo json_encode($data);
        exit;
    }
  
    function add_ticket(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
      
        if(!strlen($absdashboardclasses->protect->post('content'))){
            echo 'error';
            exit;
        }
      
        $token = $absdashboardclasses->option->get('token',
                                            $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                                    $ABookingSystem['user_id']);

        if(isset($server) 
             && $server != '') {
                $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
        
        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                          "ticket",
                                          ['title' => $absdashboardclasses->protect->post('title'),
                                           'content' => $absdashboardclasses->protect->post('content')],
                                          ['token' => $token]);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $data = json_decode($response);
            
            // Save ticket 
            $absdashboardclasses->ticket->add($data->data[0]->title,
                                     $data->data[0]->content,
                                     $data->data[0]->uid,
                                     $data->data[0]->username,
                                     $data->data[0]->id,
                                     $data->data[0]->api_key,
                                     $data->data[0]->status,
                                     $data->data[0]->answered,
                                     $data->data[0]->closed,
                                     $data->data[0]->last_reply_user,
                                     $data->data[0]->update_time);
          
            echo $response;
            exit;
        }
    }
  
    function delete_ticket(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
      
        $ticket_id = $absdashboardclasses->protect->post('id', 'id');
      
        if(!$ticket_id){
            echo 'error';
            exit;
        }

        // Get Token
        $token = $absdashboardclasses->option->get('token', $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                                                             $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }

        $result = $absdashboardclasses->http->delete($ABookingSystem['api_url'], 
                                            "ticket",
                                            ['ticket_id' => $ticket_id,
                                             'ticket_api' => $absdashboardclasses->protect->post('api_key')],
                                            ['token' => $token],
                                            'json');

        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            echo $response;
            exit;
        }
    }
  
    function change_ticket(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
      
        $ticket_data = $absdashboardclasses->protect->post('data');
      
        if(!strlen($ticket_data)){
            echo 'error';
            exit;
        }
      
        $token = $absdashboardclasses->option->get('token',
                                            $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                                                             $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
        
        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                          "ticket",
                                          [$absdashboardclasses->protect->post('field') => $ticket_data,
                                           'ticket_id' =>  $absdashboardclasses->protect->post('ticket_id', 'id', 0)],
                                          ['token' => $token]);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $data = json_decode($response);
            
            // Save ticket 
            $absdashboardclasses->ticket->add($data->data[0]->title,
                                     $data->data[0]->content,
                                     $data->data[0]->uid,
                                     $data->data[0]->username,
                                     $data->data[0]->id,
                                     $data->data[0]->api_key,
                                     $data->data[0]->status,
                                     $data->data[0]->answered,
                                     $data->data[0]->closed,
                                     $data->data[0]->last_reply_user,
                                     $data->data[0]->update_time);
          
            echo $response;
            exit;
        }
    }
  
    function ticket(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
        // Get Token
        $token = $absdashboardclasses->option->get('token', $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);
        $no_replies = $absdashboardclasses->protect->post('no_replies', 'id', 10);
        $skip_replies = $absdashboardclasses->protect->post('skip_replies', 'id', 0);
        $ticket_id = $absdashboardclasses->protect->post('ticket_id', 'id', 0);

        if(isset($server) 
             && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
      
        $update_name = 'ticket_update_'.$ticket_id;
        
      
        // Check for updates
        $update = $absdashboardclasses->updates->get($update_name,
                                            '',
                                            $ABookingSystem['user_id']);
        $update = json_decode($update);
        
        if($update->update != 'false') {
            $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                             "ticket",
                                             ['api_key' => $absdashboardclasses->protect->post('api_key')],
                                             ['token' => $token]);
            
            if($result->code == 200 
               || $result->code == 201) {
                // Save update
                $update_time = $absdashboardclasses->updates->add($update_name,
                                                         '',
                                                         $ABookingSystem['user_id'],
                                                         $update->time);
              
                $response = $absdashboardclasses->protect->data($result->response, 'json');
                $data = json_decode($response);
              
                // Delete ticket
                $absdashboardclasses->ticket->delete($data->id);
                
                // Save ticket & replies
                $tickets = array();
                array_push($tickets, $data);
                
                $tickets = json_encode($tickets);
                $absdashboardclasses->ticket->save_data($tickets,
                                               $ABookingSystem['user_id']);
            }
        }
        
        $data = $absdashboardclasses->ticket->get_ticket($ticket_id,
                                                $absdashboardclasses->protect->post('api_key'));
        
        $data->replies = array();
        $data->no_replies = 0;

        // Get replies
        $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                         "replies", 
                                         ['ticket_id' => $ticket_id,
                                          'skip' => $skip_replies,
                                          'limit' => $no_replies],
                                         ['token' => $token]);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $replies_data = json_decode($response);
            $data->replies = $replies_data->data->replies;
            $data->no_replies = $replies_data->data->no_replies;
        }
      
        echo json_encode($data);
        exit;
    }
  
    function more_replies(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;

        // Get Token
        $token = $absdashboardclasses->option->get('token', $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);
        $no_replies = $absdashboardclasses->protect->post('no_replies', 'id', 10);
        $skip_replies = $absdashboardclasses->protect->post('skip_replies', 'id', 0);
        $ticket_id = $absdashboardclasses->protect->post('ticket_id', 'id', 0);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
      

        $data = array();
        $data['replies'] = array();
        $data['no_replies'] = 0;

        // Get replies
        $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                         "replies", 
                                         ['ticket_id' => $ticket_id,
                                          'skip' => $skip_replies,
                                          'limit' => $no_replies],
                                         ['token' => $token]);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $replies_data = json_decode($response);
            
            if($replies_data->status == 'success') {
                $data['data'] = $replies_data->data;
            }
        }
      
        echo json_encode($data);
        exit;
    }
  
    function add_reply(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
      
        $content = $absdashboardclasses->protect->post('content');
      
        if(!strlen($content)){
            echo 'error';
            exit;
        }
      
        $token = $absdashboardclasses->option->get('token',
                                           $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
        
        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                          "reply",
                                          ['type' => 'private',
                                           'content' => $content,
                                           'ticket_id' => $absdashboardclasses->protect->post('ticket_id', 'id', 0)],
                                          ['token' => $token]);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
          
            echo $response;
            exit;
        }
    }
  
    function delete_reply(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
      
        $reply_id = $absdashboardclasses->protect->post('id', 'id');
        $ticket_id = $absdashboardclasses->protect->post('ticket_id', 'id', 0);
        if(!$reply_id){
            echo 'error';
            exit;
        }

        // Get Token
        $token = $absdashboardclasses->option->get('token', $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }

        $result = $absdashboardclasses->http->delete($ABookingSystem['api_url'], 
                                            "reply",
                                            ['ticket_id' => $ticket_id,
                                             'reply_id' => $reply_id],
                                            ['token' => $token],
                                            'json');
        

        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $data = json_decode($response);
            
            // Delete reply 
            $absdashboardclasses->reply->delete($reply_id,
                                       $ticket_id,
                                       $ABookingSystem['user_id']);
            // Save update date
            $absdashboardclasses->updates->add('ticket_update_'.$ticket_id, 
                                      '',
                                      $ABookingSystem['user_id'],
                                      $data->update_time);
            echo $response;
            exit;
        }
    }
  
    function withdraws(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;

        // Get Token
        $token = $absdashboardclasses->option->get('token', 
                                          $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);
        $days = $absdashboardclasses->protect->post('days', 'id', 7);
        $skip_days = $absdashboardclasses->protect->post('skip_days', 'id', 0);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }

        $user_key = $absdashboardclasses->option->get('user_key',
                                             $ABookingSystem['user_id']);

        // Check for updates
        $update = $absdashboardclasses->updates->get('withdraws_or_stats',
                                            '',
                                            $ABookingSystem['user_id']);
        $update = json_decode($update);

//        if($update->update != 'false') {
              // Save update
              $update_time = $absdashboardclasses->updates->add('withdraws_or_stats',
                                                       '',
                                                       $ABookingSystem['user_id'],
                                                       $update->time);

              // Get withdraws
              $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                               "withdraws", 
                                               [],
                                               ['token' => $token]);

              if($result->code == 200 
                 || $result->code == 201) {
                    $response = $absdashboardclasses->protect->data($result->response, 'json');
                    // Delete all withdraws
                    $absdashboardclasses->withdraw->delete_all_for($ABookingSystem['user_id']);
                    // Delete all invoices
                    $absdashboardclasses->invoices->delete_all_for($ABookingSystem['user_id']);
                    // Save withdraws, stats & invoices
                    $absdashboardclasses->withdraw->save_data($response,
                                                     $ABookingSystem['user_id']);
              }
//        }
    
        $data = array();
        $data['withdraws'] = $absdashboardclasses->withdraw->own($ABookingSystem['user_id']);
        $data['invoices'] = array();
        $data['no_invoices'] = 0;

        // Get invoices
        $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                         "invoices", 
                                         ['days' => $days,
                                          'skip_days' => $skip_days],
                                         ['token' => $token]);

        if($result->code == 200 
            || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $invoices_data = json_decode($response);
            $data['invoices'] = $invoices_data->invoices;
            $data['no_invoices'] = $invoices_data->no_invoices;
        }
        $stats = $absdashboardclasses->stats->own($ABookingSystem['user_id'], 0, 'users');

        if(count($stats) > 0) {
            $stats = $stats[0];

            if($stats->data != '') {
                $stats = json_decode($stats->data);
            }
        }

        $data['stats'] = $stats;
        $data['user'] = array('user_key' => $user_key,
                            'endpoint' => $ABookingSystem['api_url']);
        $data['currencies'] = $absdashboardclasses->main->currencies();
        $currency = $absdashboardclasses->option->get('currency',
                                          $ABookingSystem['user_id']);
        $data['currency'] = $currency;

        echo json_encode($data);
        exit;
    }
  
    function more_invoices(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;

        // Get Token
        $token = $absdashboardclasses->option->get('token', 
                                          $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);
        $days = $absdashboardclasses->protect->post('days', 'id', 7);
        $skip_days = $absdashboardclasses->protect->post('skip_days', 'id', 0);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }

        $user_key = $absdashboardclasses->option->get('user_key',
                                             $ABookingSystem['user_id']);
        $data = array();

        // Get invoices
        $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                         "invoices", 
                                         ['days' => $days,
                                          'skip_days' => $skip_days],
                                         ['token' => $token]);

        if($result->code == 200 
            || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $data = json_decode($response);
        }

        echo json_encode($data);
        exit;
    }
  
    function download_invoice(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;

        // Get Token
        $token = $absdashboardclasses->option->get('token', 
                                          $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);
        $invoice_id = $absdashboardclasses->protect->post('invoice_id', 'id', 0);
        $invoice_user_id = $absdashboardclasses->protect->post('user_id', 'id', 0);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }

        $user_key = $absdashboardclasses->option->get('user_key',
                                             $ABookingSystem['user_id']);
        $data = array();

        // Get invoices
        $result = $absdashboardclasses->http->get($ABookingSystem['api_url'], 
                                         "invoice", 
                                         ['id' => $invoice_id,
                                          'from_uid' => $invoice_user_id],
                                         ['token' => $token]);

        if($result->code == 200 
            || $result->code == 201) {
            echo $result->response;
        }

        exit;
    }
  
    function add_withdraw(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
      
        $fullname = $absdashboardclasses->protect->post('fullname');
        
        if(!strlen($fullname)){
            echo 'error';
            exit;
        }
      
        $token = $absdashboardclasses->option->get('token',
                                          $ABookingSystem['user_id']);
			
        // Server
        $server = $absdashboardclasses->option->get('server',
                                           $ABookingSystem['user_id']);

        if(isset($server) 
            && $server != '') {
            $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
        }
        
        $language = $absdashboardclasses->option->get('language',
                                             $ABookingSystem['user_id']);
        
        $result = $absdashboardclasses->http->post($ABookingSystem['api_url'], 
                                          "withdraw",
                                          ['fullname' => $fullname,
                                           'company' => $absdashboardclasses->protect->post('company'),
                                           'bank_name' => $absdashboardclasses->protect->post('bank_name'),
                                           'bank_iban' => $absdashboardclasses->protect->post('bank_iban'),
                                           'bank_swift' => $absdashboardclasses->protect->post('bank_swift'),
                                           'amount' => $absdashboardclasses->protect->post('amount', 'float'),
                                           'currency' => $absdashboardclasses->protect->post('currency'),
                                           'stripe_account_id' => $absdashboardclasses->protect->post('stripe_account_id'),
                                           'type' => $absdashboardclasses->protect->post('type'),
                                           'language' => $language],
                                          ['token' => $token]);
        
        if($result->code == 200 
           || $result->code == 201) {
            $response = $absdashboardclasses->protect->data($result->response, 'json');
            $data = json_decode($response);
          
            if($data->status == 'success') {
                $withdraws = $data->data->withdraws;
                $stats = $data->data->stats;

                // Save withdraw 
                $absdashboardclasses->withdraw->add($withdraws[0]->id,
                                           $withdraws[0]->uid,
                                           $withdraws[0]->api_key,
                                           $withdraws[0]->fullname,
                                           $withdraws[0]->company,
                                           $withdraws[0]->bank_name,
                                           $withdraws[0]->bank_iban,
                                           $withdraws[0]->bank_swift,
                                           $withdraws[0]->stripe_account_id,
                                           $withdraws[0]->amount,
                                           $withdraws[0]->currency,
                                           $absdashboardclasses->main->sign($withdraws[0]->currency),
                                           $withdraws[0]->type,
                                           $withdraws[0]->status,
                                           $withdraws[0]->update_time);
            } else if($data->status == 'error_amount') {
								// Save stats
                $stats = $data->data->stats;
								$absdashboardclasses->stats->add($stats,
                                                        $stats->uid,
                                                        0,
                                                        'users',
                                                        '0000-00-00 00:00:00',
                                                        'true');
            }
          
            echo $response;
            exit;
        }
    }
  
    function save_customer(){
        global $abookingsystemdashboard;
        global $ABookingSystem;
        global $absdashboardclasses;
        
        $user_id = $ABookingSystem['user_id'];
        $customer_token = $absdashboardclasses->protect->post('customer_token');
        
        // Customer Token
        $absdashboardclasses->option->add('customer_token',
                                 $customer_token,
                                 $user_id);
      
        echo 'success';
        exit;
    }
}