<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : views/forms/views-backend-form-fields.php
* File Version            : 1.0.7
* Created / Last Modified : 16 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end form fields views class.
*/

    if (!class_exists('DOPBSPViewsBackEndFormFields')){
        class DOPBSPViewsBackEndFormFields extends DOPBSPViewsBackEndForm{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns form fields tempalte.
             * 
             * @param args (array): function arguments
             *                      * id (integer): form ID
             *                      * language (string): form language
             * 
             * @return form fields HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
?>
                <div class="dopbsp-form-fields-header">
                    <div class="dopbsp-form-fields-types-wrapper">
                        <a href="javascript:void(0)" class="dopbsp-button dopbsp-add"></a>
                        <ul class="dopbsp-form-fields-types">
                            <li>
                                <a href="javascript:DOPBSPBackEndFormField.add(<?php echo $id; ?>, 'text', '<?php echo $language; ?>')">
                                    <span class="dopbsp-icon dopbsp-text"></span>
                                    <span class="dopbsp-label"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_TYPE_TEXT_LABEL'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:DOPBSPBackEndFormField.add(<?php echo $id; ?>, 'textarea', '<?php echo $language; ?>')">
                                    <span class="dopbsp-icon dopbsp-textarea"></span>
                                    <span class="dopbsp-label"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_TYPE_TEXTAREA_LABEL'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:DOPBSPBackEndFormField.add(<?php echo $id; ?>, 'checkbox', '<?php echo $language; ?>')">
                                    <span class="dopbsp-icon dopbsp-checkbox"></span>
                                    <span class="dopbsp-label"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_TYPE_CHECKBOX_LABEL'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:DOPBSPBackEndFormField.add(<?php echo $id; ?>, 'select', '<?php echo $language; ?>')">
                                    <span class="dopbsp-icon dopbsp-select"></span>
                                    <span class="dopbsp-label"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_TYPE_SELECT_LABEL'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <h3><?php echo $DOPBSP->text('FORMS_FORM_FIELDS'); ?></h3>
                </div>
                <ul id="DOPBSP-form-fields" class="dopbsp-form-fields">
<?php
                $fields = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->forms_fields.' WHERE form_id=%d ORDER BY position ASC',
                                                            $id));
                
                if ($wpdb->num_rows > 0){
                    foreach($fields as $field){
                        switch ($field->type){
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
                    }
                }
?>    
                </ul>
<?php                    
            }
        }
    }