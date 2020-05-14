<?php
if (!defined('ABSPATH')) exit;
global $ABookingSystemLiveUpdates;

$ABookingSystemLiveUpdates['menu']['right_top'] = array();

$ABookingSystemLiveUpdates['menu']['right_top'][] = array('account_type' => array('free', 'pro'), // free, pro, network
                                                            'title' => 'ext_live_updates_title_title', // button title translation
                                                            'page' => '', // ext-{extension name}-{page name}
                                                            'used_for' => false,
                                                            'css_class' => 'absd-abookinsystem-live-updates',
                                                            'image' => 'extensions/live_updates/images/updates.svg',
                                                            'role' => array('admin', 'owner'),
                                                            'enabled' => true);