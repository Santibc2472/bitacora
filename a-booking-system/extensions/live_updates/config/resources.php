<?php
if (!defined('ABSPATH')) exit;

global $ABookingSystem;

$ABookingSystem['resources_ext_live_updates'] = array();

/*
 * JAVASCRIPT
 */
$ABookingSystem['resources_ext_live_updates']['js'] = array();

$ABookingSystem['resources_ext_live_updates']['js'][0] = array('name' => 'Booking Everything Unlimited - Live Updates',
                                                                    'file' => 'js/live.updates.js',
                                                                    'load' => 'file', // link, file
                                                                    'type' => 'both', // frontend, backend, both 
                                                                    'page' => '', // set custom page or leave blank 
                                                                    'role' => 'admin'); // set admin, owner, guest, customer or leave blank for all roles

/*
 * CSS
 */
$ABookingSystem['resources_ext_live_updates']['css'] = array();

/*
 * CSS FILES
 */
$ABookingSystem['resources_ext_live_updates']['css'][0] = array('name' => 'Booking Everything Unlimited - Live Updates',
                                                                    'file' => 'css/live.updates.css',
                                                                    'type' => 'both', // frontend, backend, both 
                                                                    'load' => 'file', // link, file
                                                                    'page' => '', // set custom page or leave blank 
                                                                    'role' => 'admin'); // set custom page or leave blank