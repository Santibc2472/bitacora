<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/api/class-frontend-api.php
* File Version            : 1.0
* Created / Last Modified : 16 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end API PHP class.
*/

    if (!class_exists('DOPBSPFrontEndApi')){
        class DOPBSPFrontEndApi extends DOPBSPFrontEnd{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Init API.
                 */
                add_action('init', array(&$this, 'init'));
            }
            
            /*
             * Initialize front end API requests.
             * 
             * @post key (string): API key
             * 
             * @get dopbsp_api (string): will initilize API calls if it present in the URL
             * @get action (string): API action
             *                       "get": get action
             *                       "set": set action
             * @get data (string): booking system data that will be accessed action
             *                     "reservations": booking system reservations
             */
            function init(){
		global $DOT;
                global $DOPBSP;
                
                if ($DOT->get('dopbsp_api') == 'true'){
                    // ICS
                    if ($DOT->get('type') == 'ics'){
                        $key = $DOT->get('key') ? $DOT->get('key'):'0-0';
//                        header('Content-type: text/calendar; charset=utf-8');
                        if($DOPBSP->classes->backend_api_key->verify($key)) {
                            header('Content-type: text/calendar; charset=iso-8859-1');
                            header('Content-Disposition: inline; filename=calendar.ics');
                            $DOPBSP->classes->backend_reservations->get();
                        } else {
                            echo 'Invalid API key!';
                        }
                        exit;
                    }
                    
                    $key = $DOT->get('key') ? $DOT->get('key'):'0-0';
                    $action = $DOT->get('action') ? $DOT->get('action'):'';
                    $data = $DOT->get('data') ? $DOT->get('data'):'';
                    
                    $response = array();
                    
                    /*
                     * Verify action.
                     */
                    if ($action == ''){
                        $response = array('status' => 'error',
                                          'code' => 10002,
                                          'data' => 'Invalid action!');
                        echo json_encode($response);
                        
                        die();
                    }
                    
                    /*
                     * Verify data.
                     */
                    switch ($data){
                        case 'reservations':
                            if ($key == '0-0'){
                                $response = array('status' => 'error',
                                                  'code' => 10000,
                                                  'data' => 'Empty API key!');
                            }
                            elseif (!$DOPBSP->classes->backend_api_key->verify($key)){
                                $response = array('status' => 'error',
                                                  'code' => 10001,
                                                  'data' => 'Invalid API key!');
                            }
                            else{
                                $response = array('status' => 'success',
                                                  'code' => 10000,
                                                  'data' => $DOPBSP->classes->backend_reservations_list->get());
                            }
                            break;
                        default:
                            $response = array('status' => 'error',
                                              'code' => 10003,
                                              'data' => 'Invalid data!');
                    }
                        
                    echo json_encode($response);
                
                    die();
                }
            }
        }
    }