<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/forms/class-backend-form.php
* File Version            : 1.0.3
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end form PHP class.
*/

    if (!class_exists('DOPBSPBackEndForm')){
        class DOPBSPBackEndForm extends DOPBSPBackEndForms{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add a form.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                                
                $wpdb->insert($DOPBSP->tables->forms, array('user_id' => wp_get_current_user()->ID,
                                                            'name' => $DOPBSP->text('FORMS_ADD_FORM_NAME'))); 
                echo $DOPBSP->classes->backend_forms->display();

            	die();
            }
            
            /*
             * Prints out the form.
             * 
             * @post id (integer): form ID
             * @post language (string): form current editing language
             * 
             * @return form HTML
             */
            function display(){
		global $DOT;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                $language = $DOT->post('language');
                
                $DOPBSP->views->backend_form->template(array('id' => $id,
                                                     'language' => $language));
                $DOPBSP->views->backend_form_fields->template(array('id' => $id,
                                                            'language' => $language));
                
                die();
            }
            
            /*
             * Edit form fields.
             * 
             * @post id (integer): form ID
             * @post field (string): form field
             * @post value (string): field new value
             */
            function edit(){
		global $DOT;
                global $wpdb;  
                global $DOPBSP;
                
                $wpdb->update($DOPBSP->tables->forms, array($DOT->post('field') => $DOT->post('value')), 
                                                      array('id' => $DOT->post('id', 'int')));
                
            	die();
            }
            
            /*
             * Delete form.
             * 
             * @post id (integer): form ID
             * 
             * @return number of forms left
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');

                /*
                 * Delete form.
                 */
                $wpdb->delete($DOPBSP->tables->forms, array('id' => $id));
                
                /*
                 * Delete form fields.
                 */
                $fields = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->forms_fields.' WHERE form_id=%d', 
                                                            $id));
                $wpdb->delete($DOPBSP->tables->forms_fields, array('form_id' => $id));
                
                /*
                 * Delete form fields select options.
                 */
                foreach($fields as $field){
                    $wpdb->delete($DOPBSP->tables->forms_fields_options, array('field_id' => $field->id));
                }
                
                $forms = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->forms.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
        }
    }