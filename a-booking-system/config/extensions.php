<?php
if (!defined('ABSPATH')) exit;

global $ABookingSystem;

$ABookingSystem['extensions_load'] = array(); // extensions for other plugins
// Network extensions
$ABookingSystem['extensions_load']['search_wp_job_manager'] = array('required' => array('plugins' => array('wp-job-manager'),
                                                                                        'theme' => array()),
                                                                    'enabled' => true,
                                                                    'version' => 1);
$ABookingSystem['extensions_load']['network'] = array('required' => array('plugins' => array(),
                                                                          'theme' => array()),
                                                      'enabled' => true,
                                                      'version' => 1);
$ABookingSystem['extensions_load']['stats'] = array('required' => array('plugins' => array(),
                                                                        'theme' => array()),
                                                    'enabled' => true,
                                                    'version' => 1);

// Your extensions
$ABookingSystem['extensions_load']['calendar_designer'] = array('required' => array('plugins' => array(),
                                                                                    'theme' => array()),
                                                                'enabled' => false,
                                                                'version' => 1);
$ABookingSystem['extensions_load']['live_updates'] = array('required' => array('plugins' => array(),
                                                                               'theme' => array()),
                                                                'enabled' => true,
                                                                'version' => 1);