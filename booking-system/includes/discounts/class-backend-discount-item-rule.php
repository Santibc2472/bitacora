<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/discounts/class-backend-discount-item-rule.php
* File Version            : 1.0.4
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end discount item rule PHP class.
*/

    if (!class_exists('DOPBSPBackEndDiscountItemRule')){
        class DOPBSPBackEndDiscountItemRule extends DOPBSPBackEndDiscountItemRules{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add discount item rule.
             * 
             * @post item_id (integer): item ID
             * @post position (integer): item rule position
             * @post language (string): current item rule language
             * 
             * @return new item HTML
             */
            function add(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $item_id = $DOT->post('item_id');
                $position = $DOT->post('position');
                $language = $DOT->post('language');
                
                $wpdb->insert($DOPBSP->tables->discounts_items_rules, array('discount_item_id' => $item_id,
                                                                            'position' => $position));
                $id = $wpdb->insert_id;
                $rule = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts_items_rules.' WHERE id=%d',
                                                      $id));
                
                $DOPBSP->views->backend_discount_item_rule->template(array('rule' => $rule,
                                                                   'language' => $language));
                
                die();
            }
            
            /*
             * Edit discount item rule.
             * 
             * @post id (integer): item rule ID
             * @post field (string): item rule field
             * @post value (string): item rule value
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
                    
                    $item_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts_items_rules.' WHERE id=%d',
                                                               $id));
                    
                    $translation = json_decode($item_data->translation);
                    $translation->$language = $value;
                    
                    $value = json_encode($translation);
                    $field = 'translation';
                }
                        
                $wpdb->update($DOPBSP->tables->discounts_items_rules, array($field => $value), 
                                                                      array('id' => $id));
                
                die();
            }
            
            /*
             * Delete discount item rule.
             * 
             * @post id (integer): item rule ID
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                
                $wpdb->delete($DOPBSP->tables->discounts_items_rules, array('id' => $id));
                
                die();
            }
        }
    }