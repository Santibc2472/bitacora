<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/discounts/class-backend-discount-item.php
* File Version            : 1.0.5
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end discount item PHP class.
*/

    if (!class_exists('DOPBSPBackEndDiscountItem')){
        class DOPBSPBackEndDiscountItem extends DOPBSPBackEndDiscountItems{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add discount item.
             * 
             * @post discount_id (integer): discount ID
             * @post position (integer): item position
             * @post language (string): current item language
             * 
             * @return new item HTML
             */
            function add(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $discount_id = $DOT->post('discount_id', 'int');
                $position = $DOT->post('position', 'int');
                $language = $DOT->post('language');
                
                $wpdb->insert($DOPBSP->tables->discounts_items, array('discount_id' => $discount_id,
                                                                      'position' => $position,
                                                                      'translation' => $DOPBSP->classes->translation->encodeJSON('DISCOUNTS_DISCOUNT_ADD_ITEM_LABEL')));
                $id = $wpdb->insert_id;
                $item = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts_items.' WHERE id=%d',
                                                      $id));
                
                $DOPBSP->views->backend_discount_item->template(array('item' => $item,
                                                                      'language' => $language));
                
                die();
            }
            
            /*
             * Edit discount item.
             * 
             * @post id (integer): discount item ID
             * @post field (string): discount item field
             * @post value (string): discount item value
             * @post language (string): discount selected language
             */
            function edit(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $field = $DOT->post('field');
                $value = $DOT->post('value');
                $language = $DOT->post('language');
                
                if ($field == 'label'){
                    $value = str_replace("\n", '<<new-line>>', $value);
                    $value = str_replace("\'", '<<single-quote>>', $value);
                    $value = utf8_encode($value);
                    
                    $item_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts_items.' WHERE id=%d',
                                                               $id));
                    
                    $translation = json_decode($item_data->translation);
                    $translation->$language = $value;
                    
                    $value = json_encode($translation);
                    $field = 'translation';
                }
                        
                $wpdb->update($DOPBSP->tables->discounts_items, array($field => $value), 
                                                                array('id' =>$id));
                
                die();
            }
            
            /*
             * Delete discount item.
             * 
             * @post id (integer): discount item ID
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                
                $wpdb->delete($DOPBSP->tables->discounts_items, array('id' => $id));
                $wpdb->delete($DOPBSP->tables->discounts_items_rules, array('discount_item_id' => $id));
                
                die();
            }
        }
    }