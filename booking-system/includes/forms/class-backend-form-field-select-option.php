<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/forms/class-backend-form-field-select-option.php
* File Version            : 1.0.4
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end form field select option PHP class.
*/

    if (!class_exists('DOPBSPBackEndFormFieldSelectOption')){
        class DOPBSPBackEndFormFieldSelectOption extends DOPBSPBackEndFormFieldSelectOptions{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add form field select option.
             * 
             * @post field_id (integer): field ID
             * @post position (integer): select option position
             * @post language (string): current select option language
             * 
             * @return new field HTML
             */
            function add(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $field_id = $DOT->post('field_id', 'int');
                $position = $DOT->post('position', 'int');
                $language = $DOT->post('language');
                
                $wpdb->insert($DOPBSP->tables->forms_fields_options, array('field_id' => $field_id,
                                                                           'position' => $position,
                                                                           'translation' => $DOPBSP->classes->translation->encodeJSON('FORMS_FORM_FIELD_SELECT_ADD_OPTION_LABEL')));
                $id = $wpdb->insert_id;
                $select_option = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->forms_fields_options.' WHERE id=%d',
                                                               $id));
                
                $DOPBSP->views->backend_form_field_select_option->template(array('select_option' => $select_option,
                                                                         'language' => $language));
                
                die();
            }
            
            /*
             * Edit form field select option.
             * 
             * @post id (integer): select option ID
             * @post field (string): select option field
             * @post value (string): select option value
             * @post language (string): form selected language
             * 
             * @return option field ID
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
                    
                    $field_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->forms_fields_options.' WHERE id=%d',
                                                                $id));
                    
                    $translation = json_decode($field_data->translation);
                    $translation->$language = $value;
                    
                    $value = json_encode($translation);
                    $field = 'translation';
                }
                        
                $select_option = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->forms_fields_options.' WHERE id=%d',
                                                               $id));
                $wpdb->update($DOPBSP->tables->forms_fields_options, array($field => $value), 
                                                                     array('id' => $id));
                
                echo $select_option->field_id;
                
                die();
            }
            
            /*
             * Delete form field select option.
             * 
             * @post id (integer): select option ID
             * 
             * @return option field ID
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                
                $select_option = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->forms_fields_options.' WHERE id=%d',
                                                               $id));
                $wpdb->delete($DOPBSP->tables->forms_fields_options, array('id' => $id));
                
                echo $select_option->field_id;
                
                die();
            }
        }
    }