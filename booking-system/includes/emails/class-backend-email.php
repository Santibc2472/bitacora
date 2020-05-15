<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/emails/class-backend-email.php
* File Version            : 1.0.6
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end email PHP class.
*/

    if (!class_exists('DOPBSPBackEndEmail')){
        class DOPBSPBackEndEmail extends DOPBSPBackEndEmails{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add a email.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                
                $wpdb->insert($DOPBSP->tables->emails, array('user_id' => wp_get_current_user()->ID,
                                                             'name' => $DOPBSP->text('EMAILS_ADD_EMAIL_NAME')));
                $email_id = $wpdb->insert_id;
                
                /*
                 * Simple book.
                 */
                $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => $email_id,
                                                                         'template' => 'book_admin',
                                                                         'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_ADMIN_SUBJECT'),
                                                                         'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_ADMIN')));
                $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => $email_id,
                                                                         'template' => 'book_user',
                                                                         'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_USER_SUBJECT'),
                                                                         'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_USER')));
                /*
                 * Book with approval.
                 */
                $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => $email_id,
                                                                         'template' => 'book_with_approval_admin',
                                                                         'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_ADMIN_SUBJECT'),
                                                                         'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_ADMIN')));
                $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => $email_id,
                                                                         'template' => 'book_with_approval_user',
                                                                         'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_USER_SUBJECT'),
                                                                         'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_USER')));
                /*
                 * Approved
                 */
                $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => $email_id,
                                                                         'template' => 'approved',
                                                                         'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_APPROVED_SUBJECT'),
                                                                         'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_APPROVED')));
                /*
                 * Canceled
                 */
                $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => $email_id,
                                                                         'template' => 'canceled',
                                                                         'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_CANCELED_SUBJECT'),
                                                                         'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_CANCELED')));
                /*
                 * Rejected
                 */
                $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => $email_id,
                                                                         'template' => 'rejected',
                                                                         'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_REJECTED_SUBJECT'),
                                                                         'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_REJECTED')));
                
                /*
                 * Payment gateways.
                 */
                $pg_list = $DOPBSP->classes->payment_gateways->get();

                for ($i=0; $i<count($pg_list); $i++){
                    $pg_id = $pg_list[$i];
                    
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => $email_id,
                                                                             'template' => $pg_id.'_admin',
                                                                             'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_'.strtoupper($pg_id).'_ADMIN_SUBJECT'),
                                                                             'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_'.strtoupper($pg_id).'_ADMIN')));
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => $email_id,
                                                                             'template' => $pg_id.'_user',
                                                                             'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_'.strtoupper($pg_id).'_USER_SUBJECT'),
                                                                             'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_'.strtoupper($pg_id).'_USER')));
                }
                
                echo $DOPBSP->classes->backend_emails->display();

            	die();
            }
            
            /*
             * Prints out the email.
             * 
             * @post id (integer): email ID
             * @post language (string): email current editing language
             * @param template (string): email template key
             * 
             * @return email HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $language = $DOT->post('language');
                $template = $DOT->post('template');
                
                $DOPBSP->views->backend_email->template(array('id' => $id,
                                                      'language' => $language,
                                                      'template' => $template));
                
                die();
            }
            
            /*
             * Get email template and if it does not exist create a new one.
             * 
             * @param id (integer): email ID
             * @param template (string): email template key
             * 
             * @return email template
             */
            function get($id,
                         $template){
                global $wpdb;
                global $DOPBSP;
                
                $template_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->emails_translation.' WHERE email_id=%d AND template="%s"',
                                                               $id, $template));
                
                if ($template_data == ''){
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => $id,
                                                                             'template' => $template,
                                                                             'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_'.strtoupper($template).'_SUBJECT'),
                                                                             'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_'.strtoupper($template))));
                    $template_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->emails_translation.' WHERE email_id=%d AND template="%s"',
                                                                   $id, $template));
                }
                
                return $template_data;
            }
            
            /*
             * Edit email fields.
             * 
             * @post id (integer): email ID
             * @post template (string): email template
             * @post field (string): email field
             * @post value (string): email new value
             * @post language (string): email selected language
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
                    
                    $email_translation = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->emails_translation.' WHERE email_id=%d AND template="%s"',
                                                                       $id, $template));
                    
                    $translation = json_decode($email_translation->$field);
                    $translation->$language = $value;
                    $value = json_encode($translation);
                    
                    $wpdb->update($DOPBSP->tables->emails_translation, array($field => $value), 
                                                                       array('email_id' =>$id,
                                                                             'template' =>$template));
                }
                else{   
                    $wpdb->update($DOPBSP->tables->emails, array($field => $value), 
                                                           array('id' =>$id));
                }
                
            	die();
            }
            
            /*
             * Delete email.
             * 
             * @post id (integer): email ID
             * 
             * @return number of emails left
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');

                /*
                 * Delete email.
                 */
                $wpdb->delete($DOPBSP->tables->emails, array('id' => $id));
                $wpdb->delete($DOPBSP->tables->emails_translation, array('email_id' => $id));
                $emails = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->emails.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
            
            /*
             * Default email template.
             * 
             * @param key (string): translation key
             * 
             * @return default email content
             */
            function defaultTemplate($key = ''){
                global $DOPBSP;
                
                return $DOPBSP->classes->translation->encodeJSON($key,
                                                                 '',
                                                                 '',
                                                                 '<<new-line>><br /><br /><<new-line>>|DETAILS|<<new-line>><br /><br /><<new-line>>|EXTRAS|<<new-line>><br /><br /><<new-line>>|DISCOUNT|<<new-line>><br /><br /><<new-line>>|COUPON|<<new-line>><br /><br /><<new-line>>|FEES|<<new-line>><br /><br /><<new-line>>|FORM|<<new-line>><br /><br /><<new-line>>|BILLING ADDRESS|<<new-line>><br /><br /><<new-line>>|SHIPPING ADDRESS|');
            }
        }
    }