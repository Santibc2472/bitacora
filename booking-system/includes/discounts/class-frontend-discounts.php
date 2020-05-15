<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/discounts/class-frontend-discounts.php
* File Version            : 1.0.4
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end discounts PHP class.
*/

    if (!class_exists('DOPBSPFrontEndDiscounts')){
        class DOPBSPFrontEndDiscounts extends DOPBSPFrontEnd{
            /*
             * Constructor.
             */
            function __construct(){
            }
            
            /*
             * Get selected discount.
             * 
             * @param id (integer): discount ID
             * @param language (string): selected language
             * 
             * @return data array
             */
            function get($id,
                         $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE){
                global $wpdb;
                global $DOPBSP;
                
                $discount = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts.' WHERE id=%d',
                                                          $id));
                $items = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts_items.' WHERE discount_id=%d ORDER BY position', 
                                                           $id));
                
                foreach ($items as $item){
                    $item->translation = $DOPBSP->classes->translation->decodeJSON($item->translation,
                                                                                   $language);
                    
                    $rules = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts_items_rules.' WHERE discount_item_id=%d ORDER BY position',
                                                               $item->id));

                    $item->rules = $rules;
                }
                
                return array('data' => array('discount' => $items,
                                             'extras' => isset($discount->extras) && $discount->extras == 'true' ? true:false,
                                             'id' => $id),
                             'text' => array('byDay' => $DOPBSP->text('DISCOUNTS_FRONT_END_BY_DAY'),
                                             'byHour' => $DOPBSP->text('DISCOUNTS_FRONT_END_BY_HOUR'),
                                             'title' => $DOPBSP->text('DISCOUNTS_FRONT_END_TITLE')));
            }
        }
    }