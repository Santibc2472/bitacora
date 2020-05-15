<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/forms/views-backend-form-field-select-option.php
* File Version            : 1.0.5
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end form field select option views class.
*/

    if (!class_exists('DOPBSPViewsBackEndFormFieldSelectOption')){
        class DOPBSPViewsBackEndFormFieldSelectOption extends DOPBSPViewsBackEndFormField{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns select field option template.
             * 
             * @param args (array): function arguments
             *                      * select_option (integer): select data
             *                      * language (string): field language
             * 
             * @return select field HTML
             */
            function template($args = array()){
                global $DOPBSP;
                
                $select_option = $args['select_option'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
?>
                <li id="DOPBSP-form-field-select-option-<?php echo $select_option->id; ?>">
                    <div class="dopbsp-input-wrapper">
                        <input type="text" name="DOPBSP-form-field-select-option-label-<?php echo $select_option->id; ?>" id="DOPBSP-form-field-select-option-label-<?php echo $select_option->id; ?>" value="<?php echo $DOPBSP->classes->translation->decodeJSON($select_option->translation, $language); ?>" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndFormFieldSelectOption.edit(<?php echo $select_option->id; ?>, 'text', 'label', this.value);}" onpaste="DOPBSPBackEndFormFieldSelectOption.edit(<?php echo $select_option->id; ?>, 'text', 'label', this.value)" onblur="DOPBSPBackEndFormFieldSelectOption.edit(<?php echo $select_option->id; ?>, 'text', 'label', this.value, true)" />
                        <a href="javascript:DOPBSPBackEnd.confirmation('FORMS_FORM_FIELD_SELECT_DELETE_OPTION_CONFIRMATION', 'DOPBSPBackEndFormFieldSelectOption.delete(<?php echo $select_option->id; ?>)')" class="dopbsp-button dopbsp-small dopbsp-delete"><span class="dopbsp-info"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_SELECT_DELETE_OPTION_SUBMIT'); ?></span></a>
                        <a href="javascript:void(0)" class="dopbsp-button dopbsp-small dopbsp-handle"><span class="dopbsp-info"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_SELECT_OPTION_SORT'); ?></span></a>
                    </div>
                </li>
<?php
            }
        }
    }