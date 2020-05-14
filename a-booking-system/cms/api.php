<?php
if (!defined('ABSPATH')) exit;

/*
 * Create API for network
 */
class ABookingSystemApi {
  
    function __construct(){
    }
  
    function start() {
        global $ABookingSystem;
        global $absdashboardclasses;
        
        // Network Api
        $api_type = $absdashboardclasses->protect->post('api_type');
      
        switch($api_type) {
          case "delete_calendar":
            $this->delete_calendar();
            break;
          case "create_account":
            $this->create_account();
            break;
        }
        
    }
  
    function delete_calendar(){
        global $absdashboardDB;
        global $ABookingSystem;
        global $abookingsystemdashboard;
        global $absdashboardclasses;
        
        $absdashboardclasses->db->start();
        
        // Network Api
        $calendar_id = $absdashboardclasses->protect->post('calendar_id');
        $calendar_api_key = $absdashboardclasses->protect->post('calendar_api_key');
        $token = $absdashboardclasses->protect->server('HTTP_TOKEN');
        
        $user_data = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->options.' where option_name = "token" AND option_value = %s', array($token)));
        
        if(isset($user_data->user_id)
           && $user_data->user_id != 0) {
            // Server
            $server = $absdashboardclasses->option->get('server',
                                               $user_data->user_id);

            if(isset($server) 
               && $server != '') {
                $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
            }

            $result = $absdashboardclasses->http->delete($ABookingSystem['api_url'],
                                                         "calendar",
                                                        ['calendar_id' => $calendar_id,
                                                         'calendar_api' => $calendar_api_key],
                                                        ['token' => $token],
                                                         'json');
            
            if($result->code == 200 
                || $result->code == 201) {
                $response = $absdashboardclasses->protect->data($result->response, 'json');
                $data = json_decode($response);

                $absdashboardclasses->option->add('no_groups',
                                          $data->no_groups,
                                          $user_data->user_id,
                                          'user');

                $absdashboardclasses->option->add('no_calendars',
                                          $data->no_calendars,
                                          $user_data->user_id,
                                          'user');
                // Delete listing 
                $absdashboardclasses->listing->delete($calendar_id,
                                             $user_data->user_id);

                echo $response;
                exit;
            }
          
          
        } else {
            $data = array('status' => 'error');
        }

        echo json_encode($data);
        exit;
    }
  
    function create_account(){
        global $absdashboardDB;
        global $ABookingSystem;
        global $abookingsystemdashboard;
        global $absdashboardclasses;
        
        $absdashboardclasses->db->start();
        
        // Network Api
        $token = $absdashboardclasses->protect->post('network_token');
        
        $user_data = $absdashboardDB->get_row($absdashboardDB->prepare('SELECT * FROM '.$absdashboardDB->absd_table->options.' where option_name = "network_token" AND option_value = %s', array($token)));
        
        if(isset($user_data->user_id)
           && $user_data->user_id == 0) {
            $email      = $absdashboardclasses->protect->post('email');
            $username   = $absdashboardclasses->protect->post('username');
            $password   = $absdashboardclasses->protect->post('password');
            $user_key   = $absdashboardclasses->protect->post('user_key');
            $user_token = $absdashboardclasses->protect->post('user_token');
            $user_type  = $absdashboardclasses->protect->post('user_type');
            $used_for   = $absdashboardclasses->protect->post('used_for');
            
            // Server
            $server = $absdashboardclasses->option->get('server',
                                               $user_data->user_id);

            if(isset($server) 
               && $server != '') {
                $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
            }
            
            // Create user
            $user_id = $absdashboardclasses->main->create_owner($username,
                                                                $password,
                                                                $email);
              
            // User key
            $absdashboardclasses->option->add('user_key',
                                              $user_key,
                                              $user_id);
            // Token
            $absdashboardclasses->option->add('token',
                                              $user_token,
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
                                              $user_type,
                                              $user_id);
            
            $absdashboardclasses->option->add('used_for',
                                              $used_for,
                                              $user_id,
                                              'user');
            
            $data = array('status' => 'success');
        } else {
            $data = array('status' => 'error');
        }

        echo json_encode($data);
        exit;
    }
}