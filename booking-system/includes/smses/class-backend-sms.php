<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Author                  : PINPOINT.WORLD
* Copyright               : © 2018 PINPOINT.WORLD
* Website                 : http://www.pinpoint.world
* Description             : Back end sms PHP class.
*/

    if (!class_exists('DOPBSPBackEndSms')){
        class DOPBSPBackEndSms extends DOPBSPBackEndSmses{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add a SMS.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                
                $wpdb->insert($DOPBSP->tables->smses, array('user_id' => wp_get_current_user()->ID,
                                                            'name' => $DOPBSP->text('SMSES_ADD_SMS_NAME')));
                $sms_id = $wpdb->insert_id;
                
                /*
                 * Simple book.
                 */
                $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => $sms_id,
                                                                         'template' => 'book_admin',
                                                                         'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_BOOK_ADMIN')));
                $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => $sms_id,
                                                                         'template' => 'book_user',
                                                                         'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_BOOK_USER')));
                /*
                 * Book with approval.
                 */
                $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => $sms_id,
                                                                         'template' => 'book_with_approval_admin',
                                                                         'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_BOOK_WITH_APPROVAL_ADMIN')));
                $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => $sms_id,
                                                                         'template' => 'book_with_approval_user',
                                                                         'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_BOOK_WITH_APPROVAL_USER')));
                /*
                 * Approved
                 */
                $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => $sms_id,
                                                                         'template' => 'approved',
                                                                         'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_APPROVED')));
                /*
                 * Canceled
                 */
                $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => $sms_id,
                                                                         'template' => 'canceled',
                                                                         'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_CANCELED')));
                /*
                 * Rejected
                 */
                $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => $sms_id,
                                                                         'template' => 'rejected',
                                                                         'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_REJECTED')));
                
                /*
                 * Payment gateways.
                 */
                $pg_list = $DOPBSP->classes->payment_gateways->get();

                for ($i=0; $i<count($pg_list); $i++){
                    $pg_id = $pg_list[$i];
                    
                    $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => $sms_id,
                                                                             'template' => $pg_id.'_admin',
                                                                             'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_'.strtoupper($pg_id).'_ADMIN')));
                    $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => $sms_id,
                                                                             'template' => $pg_id.'_user',
                                                                             'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_'.strtoupper($pg_id).'_USER')));
                }
                
                echo $DOPBSP->classes->backend_smses->display();

            	die();
            }
            
            /*
             * Prints out the SMS.
             * 
             * @post id (integer): SMS ID
             * @post language (string): Current SMS editing language
             * @param template (string): SMS template key
             * 
             * @return SMS HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $language = $DOT->post('language');
                $template = $DOT->post('template');
                
                $DOPBSP->views->backend_sms->template(array('id' => $id,
                                                      'language' => $language,
                                                      'template' => $template));
                
                die();
            }
            
            /*
             * Get SMS template and if it does not exist create a new one.
             * 
             * @param id (integer): SMS ID
             * @param template (string): SMS template key
             * 
             * @return SMS template
             */
            function get($id,
                         $template){
                global $wpdb;
                global $DOPBSP;
                
                $template_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->smses_translation.' WHERE sms_id=%d AND template="%s"',
                                                               $id, $template));
                
                if ($template_data == ''){
                    $wpdb->insert($DOPBSP->tables->smses_translation, array('sms_id' => $id,
                                                                             'template' => $template,
                                                                             'message' => $DOPBSP->classes->backend_sms->defaultTemplate('SMSES_DEFAULT_'.strtoupper($template))));
                    $template_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->smses_translation.' WHERE sms_id=%d AND template="%s"',
                                                                   $id, $template));
                }
                
                return $template_data;
            }
            
            /*
             * Edit SMS fields.
             * 
             * @post id (integer): SMS ID
             * @post template (string): SMS template
             * @post field (string): SMS field
             * @post value (string): SMS new value
             * @post language (string): SMS selected language
             */
            function edit(){
		global $DOT;
                global $wpdb;  
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $template = $DOT->post('template');
                $field = $DOT->post('field');
                $value = $DOT->post('value', false);
                $language = $DOT->post('language');
                
                if ($field != 'name'){
                    $value = str_replace("\n", '<<new-line>>', $value);
                    $value = str_replace("\'", '<<single-quote>>', $value);
                    $value = utf8_encode($value);
                    
                    $sms_translation = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->smses_translation.' WHERE sms_id=%d AND template="%s"',
                                                                       $id, $template));
                    
                    $translation = json_decode($sms_translation->$field);
                    $translation->$language = $value;
                    $value = json_encode($translation);
                    
                    $wpdb->update($DOPBSP->tables->smses_translation, array($field => $value), 
                                                                       array('sms_id' =>$id,
                                                                             'template' =>$template));
                }
                else{   
                    $wpdb->update($DOPBSP->tables->smses, array($field => $value), 
                                                           array('id' =>$id));
                }
                
            	die();
            }
            
            /*
             * Delete SMS.
             * 
             * @post id (integer): SMS ID
             * 
             * @return number of SMSes left
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');

                /*
                 * Delete sms.
                 */
                $wpdb->delete($DOPBSP->tables->smses, array('id' => $id));
                $wpdb->delete($DOPBSP->tables->smses_translation, array('sms_id' => $id));
                $smses = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->smses.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;
            	die();
            }
            
            /*
             * Default SMS template.
             * 
             * @param key (string): translation key
             * 
             * @return default SMS content
             */
            function defaultTemplate($key = ''){
                global $DOPBSP;
                
                return $DOPBSP->classes->translation->encodeJSON($key,
                                                                 '',
                                                                 '',
                                                                 '|DETAILS|');
            }
        }
    }