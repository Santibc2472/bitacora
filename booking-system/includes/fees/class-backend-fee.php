<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/fees/class-backend-fee.php
* File Version            : 1.0.3
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end fee PHP class.
*/

    if (!class_exists('DOPBSPBackEndFee')){
        class DOPBSPBackEndFee extends DOPBSPBackEndFees{
            private $views;
            
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add a fee.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                
                $wpdb->insert($DOPBSP->tables->fees, array('user_id' => wp_get_current_user()->ID,
                                                           'name' => $DOPBSP->text('FEES_ADD_FEE_NAME'),
                                                           'translation' => $DOPBSP->classes->translation->encodeJSON('FEES_ADD_FEE_LABEL'))); 
                
                echo $DOPBSP->classes->backend_fees->display();

            	die();
            }
            
            /*
             * Prints out the fee.
             * 
             * @post id (integer): fee ID
             * @post language (string): fee current editing language
             * 
             * @return fee HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $language = $DOT->post('language');
                
                $DOPBSP->views->backend_fee->template(array('id' => $id,
                                                    'language' => $language));
                
                die();
            }
            
            /*
             * Edit fee fields.
             * 
             * @post id (integer): fee ID
             * @post field (string): fee field
             * @post value (string): fee new value
             * @post language (string): fee selected language
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
                    
                    $fee_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->fees.' WHERE id=%d', 
                                                              $id));
                    
                    $translation = json_decode($fee_data->translation);
                    $translation->$language = $value;
                    
                    $value = json_encode($translation);
                    $field = 'translation';
                }
                        
                $wpdb->update($DOPBSP->tables->fees, array($field => $value), 
                                                     array('id' =>$id));
                
            	die();
            }
            
            /*
             * Delete fee.
             * 
             * @post id (integer): fee ID
             * 
             * @return number of fees left
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');

                /*
                 * Delete fee.
                 */
                $wpdb->delete($DOPBSP->tables->fees, array('id' => $id));
                $fees = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->fees.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
        }
    }