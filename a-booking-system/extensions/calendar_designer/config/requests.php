<?php
if (!defined('ABSPATH')) exit;

global $ABookingSystem;

$ABookingSystem['requests_ext_calendar_designer'] = array();

/*
 * Requests
 */

$ABookingSystem['requests_ext_calendar_designer'][0] = array('name' => 'save',
                                                             'function' => 'save',
                                                             'class' => 'main',
                                                             'type' => 'both'); // frontend / backend

$ABookingSystem['requests_ext_calendar_designer'][1] = array('name' => 'reset',
                                                             'function' => 'reset',
                                                             'class' => 'main',
                                                             'type' => 'both'); // frontend / backend

