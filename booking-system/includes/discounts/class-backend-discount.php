<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/discounts/class-backend-discount.php
* File Version            : 1.0.3
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end discount PHP class.
*/

    if (!class_exists('DOPBSPBackEndDiscount')){
        class DOPBSPBackEndDiscount extends DOPBSPBackEndDiscounts{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add a discount.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                                
                $wpdb->insert($DOPBSP->tables->discounts, array('user_id' => wp_get_current_user()->ID,
                                                                'name' => $DOPBSP->text('DISCOUNTS_ADD_DISCOUNT_NAME'))); 
                echo $DOPBSP->classes->backend_discounts->display();

            	die();
            }
            
            /*
             * Prints out the discount.
             * 
             * @post id (integer): discount ID
             * @post language (string): discount current editing language
             * 
             * @return discount HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $language = $DOT->post('language');
                
                $DOPBSP->views->backend_discount->template(array('id' => $id,
                                                         'language' => $language));
                $DOPBSP->views->backend_discount_items->template(array('id' => $id,
                                                               'language' => $language));
                
                die();
            }
            
            /*
             * Edit discount fields.
             * 
             * @post id (integer): discount ID
             * @post field (string): discount field
             * @post value (string): item new value
             */
            function edit(){
		global $DOT;
                global $wpdb; 
                global $DOPBSP; 
                
                $wpdb->update($DOPBSP->tables->discounts, array($DOT->post('field') => $DOT->post('value')), 
                                                          array('id' => $DOT->post('id', 'int')));
                
            	die();
            }
            
            /*
             * Delete discount.
             * 
             * @post id (integer): discount ID
             * 
             * @return number of discounts left
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');

                /*
                 * Delete discount.
                 */
                $wpdb->delete($DOPBSP->tables->discounts, array('id' => $id));
                
                /*
                 * Delete discount items.
                 */
                $items = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts_items.' WHERE discount_id=%d',
                                                           $id));
                $wpdb->delete($DOPBSP->tables->discounts_items, array('discount_id' => $id));
                
                /*
                 * Delete discount items rules.
                 */
                foreach($items as $item){
                    $wpdb->delete($DOPBSP->tables->discounts_items_rules, array('discount_item_id' => $item->id));
                }
                
                $discounts = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->discounts.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
        }
    }