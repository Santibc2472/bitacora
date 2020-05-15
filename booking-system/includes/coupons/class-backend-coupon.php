<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/coupons/class-backend-coupon.php
* File Version            : 1.0.4
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end coupon PHP class.
*/

    if (!class_exists('DOPBSPBackEndCoupon')){
        class DOPBSPBackEndCoupon extends DOPBSPBackEndCoupons{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add a coupon.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                
                $wpdb->insert($DOPBSP->tables->coupons, array('user_id' => wp_get_current_user()->ID,
                                                              'name' => $DOPBSP->text('COUPONS_ADD_COUPON_NAME'),
                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('COUPONS_ADD_COUPON_LABEL'))); 
                
                echo $DOPBSP->classes->backend_coupons->display();

            	die();
            }
            
            /*
             * Prints out the coupon.
             * 
             * @post id (integer): coupon ID
             * @post language (string): coupon current editing language
             * 
             * @return coupon HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $language = $DOT->post('language');
                
                $DOPBSP->views->backend_coupon->template(array('id' => $id,
                                                       'language' => $language));
                
                die();
            }
            
            /*
             * Edit coupon fields.
             * 
             * @post id (integer): coupon ID
             * @post field (string): coupon field
             * @post value (string): coupon new value
             * @post language (string): coupon selected language
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
                    
                    $coupon_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->coupons.' WHERE id=%d',
                                                                 $id));
                    
                    $translation = json_decode($coupon_data->translation);
                    $translation->$language = $value;
                    
                    $value = json_encode($translation);
                    $field = 'translation';
                }
                        
                $wpdb->update($DOPBSP->tables->coupons, array($field => $value), 
                                                        array('id' =>$id));
                
            	die();
            }
            
            /*
             * Delete coupon.
             * 
             * @post id (integer): coupon ID
             * 
             * @return number of coupons left
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');

                /*
                 * Delete coupon.
                 */
                $wpdb->delete($DOPBSP->tables->coupons, array('id' => $id));
                $coupons = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->coupons.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
            
            /*
             * Update coupon availability.
             * 
             * @param id (integer): coupon ID
             * @param action (string): "use" or "restore" coupon
             */
            function update($id,
                            $action){
                global $wpdb;
                global $DOPBSP;
                
                $coupon = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->coupons.' WHERE id=%d ORDER BY id',
                                                        $id));
                
                if ($coupon->no_coupons != ''){
                    if ($action == 'use'){
                        $no_coupons = (int)$coupon->no_coupons-1;
                    }
                    else{
                        $no_coupons = (int)$coupon->no_coupons+1;
                    }
                    $wpdb->update($DOPBSP->tables->coupons, array('no_coupons' => $no_coupons), 
                                                            array('id' =>$id));
                }
            }
            
            /*
             * Check if coupon is still available.
             * 
             * @param id (integer): coupon ID
             * 
             * @return true/false
             */
            function validate($id){
                global $wpdb;
                global $DOPBSP;
                
                $coupon = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->coupons.' WHERE id=%d ORDER BY id',
                                                        $id));
                
                if (($coupon->no_coupons == ''
                                || (int)$coupon->no_coupons > 0)
                        && (int)$coupon->price > 0){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }