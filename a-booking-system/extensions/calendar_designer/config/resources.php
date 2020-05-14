<?php
if (!defined('ABSPATH')) exit;

global $ABookingSystem;

$ABookingSystem['resources_ext_calendar_designer'] = array();

/*
 * JAVASCRIPT
 */
$ABookingSystem['resources_ext_calendar_designer']['js'] = array();

/*
 * JAVASCRIPT FILES
 */

$ABookingSystem['resources_ext_calendar_designer']['js'][0] = array('name' => 'Pickr - colorpicker',
                                                                    'file' => 'libs/pickr/js/pickr.es5.min.js',
                                                                    'load' => 'file', // link, file
                                                                    'type' => 'both', // frontend, backend, both 
                                                                    'page' => 'ext-calendar_designer-main', // set custom page or leave blank 
                                                                    'role' => 'admin'); // set admin, owner, guest, customer or leave blank for all roles

$ABookingSystem['resources_ext_calendar_designer']['js'][1] = array('name' => 'Booking Everything Unlimited - Calendar Designer',
                                                                    'file' => 'js/calendar.designer.js',
                                                                    'load' => 'file', // link, file
                                                                    'type' => 'both', // frontend, backend, both 
                                                                    'page' => 'ext-calendar_designer-main', // set custom page or leave blank 
                                                                    'role' => 'admin'); // set admin, owner, guest, customer or leave blank for all roles

/*
 * CSS
 */
$ABookingSystem['resources_ext_calendar_designer']['css'] = array();

/*
 * CSS FILES
 */
$ABookingSystem['resources_ext_calendar_designer']['css'][0] = array('name' => 'Bootstrap',
                                                                    'file' => 'libs/bootstrap/css/bootstrap.min.css',
                                                                    'type' => 'both', // frontend, backend, both 
                                                                    'load' => 'file', // link, file
                                                                    'page' => 'ext-calendar_designer-main', // set custom page or leave blank 
                                                                    'role' => 'admin'); // set custom page or leave blank
$ABookingSystem['resources_ext_calendar_designer']['css'][1] = array('name' => 'Pickr',
                                                                    'file' => 'libs/pickr/css/pickr.monolith.min.css',
                                                                    'type' => 'both', // frontend, backend, both 
                                                                    'load' => 'file', // link, file
                                                                    'page' => 'ext-calendar_designer-main', // set custom page or leave blank 
                                                                    'role' => 'admin'); // set custom page or leave blank
$ABookingSystem['resources_ext_calendar_designer']['css'][2] = array('name' => 'Booking Everything Unlimited - Calendar Designer',
                                                                    'file' => 'css/calendar.designer.css',
                                                                    'type' => 'both', // frontend, backend, both 
                                                                    'load' => 'file', // link, file
                                                                    'page' => 'ext-calendar_designer-main', // set custom page or leave blank 
                                                                    'role' => 'admin'); // set custom page or leave blank