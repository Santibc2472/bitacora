<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/forms/class-backend-form-field.php
* File Version            : 1.0.5
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end form field PHP class.
*/

    if (!class_exists('DOPBSPBackEndFormField')){
        class DOPBSPBackEndFormField extends DOPBSPBackEndFormFields{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Add form field.
             * 
             * @post form_id (integer): form ID
             * @post type (string): field type
             * @post position (integer): field position
             * @post language (string): current field language
             * 
             * @return new field HTML
             */
            function add(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $form_id = $DOT->post('form_id', 'int');
                $type = $DOT->post('type');
                $position = $DOT->post('position', 'int');
                $language = $DOT->post('language');
                $key = '';
                
                switch ($type){
                    case 'checkbox':
                        $key = 'FORMS_FORM_ADD_FIELD_CHECKBOX_LABEL';
                        break;
                    case 'select':
                        $key = 'FORMS_FORM_ADD_FIELD_SELECT_LABEL';
                        break;
                    case 'text':
                        $key = 'FORMS_FORM_ADD_FIELD_TEXT_LABEL';
                        break;
                    case 'textarea':
                        $key = 'FORMS_FORM_ADD_FIELD_TEXTAREA_LABEL';
                        break;
                }
                $wpdb->insert($DOPBSP->tables->forms_fields, array('form_id' => $form_id,
                                                                   'type' => $type,
                                                                   'position' => $position,
                                                                   'allowed_characters' => '',
                                                                   'translation' => $DOPBSP->classes->translation->encodeJSON($key)));
                $id = $wpdb->insert_id;
                $field = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->forms_fields.' WHERE id=%d',
                                                       $id));
                
                switch ($type){
                    case 'checkbox':
                        $DOPBSP->views->backend_form_field->templateCheckbox(array('field' => $field,
                                                                           'language' => $language));
                        break;
                    case 'select':
                        $DOPBSP->views->backend_form_field->templateSelect(array('field' => $field,
                                                                         'language' => $language));
                        break;
                    case 'text':
                        $DOPBSP->views->backend_form_field->templateText(array('field' => $field,
                                                                       'language' => $language));
                        break;
                    case 'textarea':
                        $DOPBSP->views->backend_form_field->templateTextarea(array('field' => $field,
                                                                           'language' => $language));
                        break;
                }
                
                die();
            }
            
            /*
             * Edit form field.
             * 
             * @post id (integer): form field ID
             * @post field (string): form field
             * @post value (string): form field value
             * @post language (string): form selected language
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
                    
                    $field_data = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->forms_fields.' WHERE id=%d',
                                                                $id));
                    
                    $translation = json_decode($field_data->translation);
                    $translation->$language = $value;
                    
                    $value = json_encode($translation);
                    $field = 'translation';
                }
                        
                $wpdb->update($DOPBSP->tables->forms_fields, array($field => $value), 
                                                             array('id' => $id));
                
                die();
            }
            
            /*
             * Delete form field.
             * 
             * @post id (integer): form field ID
             */
            function delete(){
		global $DOT;
                global $wpdb;
                global $DOPBSP;
                
                $id = $DOT->post('id', 'int');
                
                $wpdb->delete($DOPBSP->tables->forms_fields, array('id' => $id));
                $wpdb->delete($DOPBSP->tables->forms_fields_options, array('field_id' => $id));
                
                die();
            }
        }
    }