<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/forms/class-frontend-forms.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Front end forms PHP class.
*/

    if (!class_exists('DOPBSPFrontEndForms')){
        class DOPBSPFrontEndForms extends DOPBSPFrontEnd{
            /*
             * Constructor.
             */
            function __construct(){
            }
            
            /*
             * Get selected form.
             * 
             * @param id (integer): form ID
             * @param language (string): selected language
             * 
             * @return data array
             */
            function get($id,
                         $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE){
                global $wpdb;
                global $DOPBSP;
                
                $fields = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->forms_fields.' WHERE form_id=%d ORDER BY position',
                                                            $id));
                
                foreach ($fields as $field){
                    $field->translation = $DOPBSP->classes->translation->decodeJSON($field->translation,
                                                                                    $language);
                    
                    if ($field->type == 'select'){
                        $options = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->forms_fields_options.' WHERE field_id=%d ORDER BY position',
                                                                     $field->id));
                        
                        foreach ($options as $option){
                            $option->translation = $DOPBSP->classes->translation->decodeJSON($option->translation,
                                                                                             $language);
                        }
                        $field->options = $options;
                    }
                }
                
                return array('data' => array('form' => $fields,
                                             'id' => $id),
                             'text' => array('checked' => $DOPBSP->text('FORMS_FORM_FIELD_TYPE_CHECKBOX_CHECKED_LABEL'),
                                             'invalidEmail' => $DOPBSP->text('FORMS_FRONT_END_INVALID_EMAIL'),
                                             'required' => $DOPBSP->text('FORMS_FRONT_END_REQUIRED'),
                                             'title' => $DOPBSP->text('FORMS_FRONT_END_TITLE'),
                                             'unchecked' => $DOPBSP->text('FORMS_FORM_FIELD_TYPE_CHECKBOX_UNCHECKED_LABEL')));
            }
        }
    }