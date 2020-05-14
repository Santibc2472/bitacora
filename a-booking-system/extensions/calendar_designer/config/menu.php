<?php
if (!defined('ABSPATH')) exit;
global $ABookingSystemCalendarDesigner;

$ABookingSystemCalendarDesigner['menu']['main'] = array();

$ABookingSystemCalendarDesigner['menu']['main'][] = array('account_type' => array('free', 'pro'), // free, pro, network
                                                          'title' => 'ext_calendar_designer_title_title', // button title translation
                                                          'page' => 'ext-calendar_designer-main', // ext-{extension name}-{page name}
                                                          'used_for' => false,
                                                          'role' => array('admin', 'owner'),
                                                          'enabled' => true);