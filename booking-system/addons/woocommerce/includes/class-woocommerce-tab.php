<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : addons/woocommerce/includes/class-woocommerce-tab.php
* File Version            : 1.0
* Created / Last Modified : 04 December 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : WooCommerce back end tab PHP class.
*/

    if (!class_exists('DOPBSPWooCommerceTab')){
        class DOPBSPWooCommerceTab{
            /*
             * Constructor.
             */
            function __construct(){
                /*
                 * Add tab.
                 */
                add_action('woocommerce_product_write_panel_tabs', array(&$this, 'add'));
                
                /*
                 * Add content to tab.
                 */
                add_action('woocommerce_product_data_panels', array(&$this, 'display'));
                
                /*
                 * Save tab data.
                 */
                add_action('woocommerce_process_product_meta', array(&$this, 'set'));
            }
            
            /*
             * Add booking system in product tabs list.
             * 
             * @return HTML tab button
             */
            function add(){
                global $DOPBSP;
      
                echo '<li class="dopbsp_tab"><a href="#dopbsp_tab_data">'.$DOPBSP->text('WOOCOMMERCE_TAB').'</a></li>';
            }
            
            /*
             * Display tab content.
             * 
             * @return HTML form
             */
            function display(){
                global $post;
                global $DOPBSP;
                
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($post->ID, 'dopbsp_woocommerce_calendar', true),
                                                    'language' => get_post_meta($post->ID, 'dopbsp_woocommerce_language', true) == '' ? DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE:get_post_meta($post->ID, 'dopbsp_woocommerce_language', true),
                                                    'position' => get_post_meta($post->ID, 'dopbsp_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'dopbsp_woocommerce_position', true),
                                                    'add_to_cart' => get_post_meta($post->ID, 'dopbsp_woocommerce_add_to_cart', true) == '' ? 'false':get_post_meta($post->ID, 'dopbsp_woocommerce_add_to_cart', true));	
?>
    <div id="dopbsp_tab_data" class="panel woocommerce_options_panel">
        <div class="options_group">
            <p class="form-field">
<?php 
                woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_calendar',
                                            'options' => $this->getCalendars(),
                                            'label' => $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR'),
                                            'description' => $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR_HELP')));
                woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_language',
                                            'options' => $this->getLanguages(),
                                            'label' => $DOPBSP->text('WOOCOMMERCE_TAB_LANGUAGE'),
                                            'description' => $DOPBSP->text('WOOCOMMERCE_TAB_LANGUAGE_HELP'),
                                            'value' => $dopbsp_woocommerce_options['language']));
                woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_position',
                                            'options' => array('summary' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_SUMMARY'),
                                                               'tabs' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_TABS'),
                                                               'summary-tabs' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_SUMMARY_AND_TABS')),
                                            'label' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION'),
                                            'description' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_HELP'),
                                            'value' => $dopbsp_woocommerce_options['position']));
                woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_add_to_cart',
                                            'options' => array('false' => 'WooCommerce',
                                                               'true' => $DOPBSP->text('TITLE')),
                                            'label' => $DOPBSP->text('WOOCOMMERCE_TAB_ADD_TO_CART'),
                                            'description' => $DOPBSP->text('WOOCOMMERCE_TAB_ADD_TO_CART_HELP'),
                                            'value' => $dopbsp_woocommerce_options['add_to_cart']));
?>
            </p>
        </div>	
    </div>
<?php
            }
            
            /*
             * Set booking system options for selected product.
             * 
             * @param post_id (integer): product ID
             * 
             * @post dopbsp_woocommerce_calendar (integer): calendar ID
             * @post dopbsp_woocommerce_language (string): calendar language
             * @post dopbsp_woocommerce_position (integer): calendar position
             */
            function set($post_id){
		global $DOT;
		
                update_post_meta($post_id, 'dopbsp_woocommerce_calendar', $DOT->post('dopbsp_woocommerce_calendar', 'int'));
                update_post_meta($post_id, 'dopbsp_woocommerce_language', $DOT->post('dopbsp_woocommerce_language'));
                update_post_meta($post_id, 'dopbsp_woocommerce_position', $DOT->post('dopbsp_woocommerce_position'));
                update_post_meta($post_id, 'dopbsp_woocommerce_add_to_cart', $DOT->post('dopbsp_woocommerce_add_to_cart'));
            }
            
            /*
             * Get calendars list.
             * 
             * @return calendars list
             */
            function getCalendars(){
                global $DOPBSP;
                
                $calendars_list = array();
                $calendars = $DOPBSP->classes->backend_calendars->get();
                
                if (count($calendars) > 0){
                    $calendars_list[0] = $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR_SELECT');
                    
                    foreach ($calendars as $calendar){
                        $calendars_list[$calendar->id] = 'ID '.$calendar->id.': '.$calendar->name;
                    }
                }
                else{
                    $calendars_list[0] = $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR_NO_CALENDARS');
                }
                
                return $calendars_list;
            }
            
            /*
             * Get languages list.
             * 
             * @return enabled languages 
             */
            function getLanguages(){
                global $wpdb;
                global $DOPBSP;
                
                $languages_list = array();
                
                $languages = $DOPBSP->classes->languages->languages;
                $languages_enabled = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE enabled="true"');
                
                foreach ($languages_enabled as $language_enabled){
                    for ($i=0; $i<count($languages); $i++){
                        if ($language_enabled->code == $languages[$i]['code']){
                            $languages_list[$languages[$i]['code']] = $languages[$i]['name'];
                        }
                    }
                }
                
                return $languages_list;
            }
        }
    }