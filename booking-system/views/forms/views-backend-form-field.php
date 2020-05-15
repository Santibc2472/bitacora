<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/forms/views-backend-form-field.php
* File Version            : 1.0.9
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end form field views class.
*/

    if (!class_exists('DOPBSPViewsBackEndFormField')){
        class DOPBSPViewsBackEndFormField extends DOPBSPViewsBackEndFormFields{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns checkbox field template.
             * 
             * @param args (array): function arguments
             *                      * field (integer): field data
             *                      * language (string): field language
             * 
             * @return checkbox field HTML
             */
            function templateCheckbox($args = array()){
                global $DOPBSP;
                
                $field = $args['field'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
?>
                <li id="DOPBSP-form-field-<?php echo $field->id; ?>" class="dopbsp-field-wrapper">
<?php
                    /*
                     * Preview
                     */
                    $this->displayPreview(array('field' => $field,
                                                'language' => $language));
?>
                    <div class="dopbsp-settings-wrapper">
<?php
                    /*
                     * Label
                     */
                    $this->displayTextInput(array('id' => 'label',
                                                  'label' => $DOPBSP->text('FORMS_FORM_FIELD_LABEL_LABEL'),
                                                  'value' => $DOPBSP->classes->translation->decodeJSON($field->translation, $language),
                                                  'form_field_id' => $field->id,
                                                  'help' => $DOPBSP->text('FORMS_FORM_FIELD_LABEL_HELP')));
                    /*
                     * Required
                     */
                    $this->displaySwitchInput(array('id' => 'required',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_REQUIRED_LABEL'),
                                                    'value' => $field->required,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_REQUIRED_HELP')));
                    /*
                     * Add to info.
                     */
                    $this->displaySwitchInput(array('id' => 'add_to_day_hour_info',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_INFO_LABEL'),
                                                    'value' => $field->add_to_day_hour_info,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_INFO_HELP')));
                    /*
                     * Add to body.
                     */
                    $this->displaySwitchInput(array('id' => 'add_to_day_hour_body',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_BODY_LABEL'),
                                                    'value' => $field->add_to_day_hour_body,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_BODY_HELP'),
                                                    'dopbsp-last'));
?>
                    </div>
                </li>
<?php           
            }
            
            /*
             * Returns select field template.
             * 
             * @param args (array): function arguments
             *                      * field (integer): field data
             *                      * language (string): field language
             * 
             * @return select field HTML
             */
            function templateSelect($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $field = $args['field'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
                
                $select_options = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->forms_fields_options.' WHERE field_id=%d ORDER BY position ASC',
                                                                    $field->id));                    
?>
                <li id="DOPBSP-form-field-<?php echo $field->id; ?>" class="dopbsp-field-wrapper">
<?php
                    /*
                     * Preview
                     */
                    $this->displayPreview(array('field' => $field,
                                                'language' => $language,
                                                'select_options' => $select_options));
?>
                    <div class="dopbsp-settings-wrapper">
<?php
                    /*
                     * Label
                     */
                    $this->displayTextInput(array('id' => 'label',
                                                  'label' => $DOPBSP->text('FORMS_FORM_FIELD_LABEL_LABEL'),
                                                  'value' => $DOPBSP->classes->translation->decodeJSON($field->translation, $language),
                                                  'form_field_id' => $field->id,
                                                  'help' => $DOPBSP->text('FORMS_FORM_FIELD_LABEL_HELP')));
                    /*
                     * Multiple select.
                     */
                    $this->displaySwitchInput(array('id' => 'multiple_select',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_MULTIPLE_SELECT_LABEL'),
                                                    'value' => $field->multiple_select,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_MULTIPLE_SELECT_HELP')));
                    /*
                     * Required
                     */
                    $this->displaySwitchInput(array('id' => 'required',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_REQUIRED_LABEL'),
                                                    'value' => $field->required,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_REQUIRED_HELP')));
                    /*
                     * Add to info.
                     */
                    $this->displaySwitchInput(array('id' => 'add_to_day_hour_info',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_INFO_LABEL'),
                                                    'value' => $field->add_to_day_hour_info,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_INFO_HELP')));
                    /*
                     * Add to body.
                     */
                    $this->displaySwitchInput(array('id' => 'add_to_day_hour_body',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_BODY_LABEL'),
                                                    'value' => $field->add_to_day_hour_body,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_BODY_HELP')));
?>
                        <div class="dopbsp-input-wrapper dopbsp-last">
                            <label><?php echo $DOPBSP->text('FORMS_FORM_FIELD_SELECT_OPTIONS_LABEL'); ?></label>
                            <div class="dopbsp-select-options-wrapper">
                                <div class="dopbsp-buttons">
                                    <a href="javascript:DOPBSPBackEndFormFieldSelectOption.add(<?php echo $field->id; ?>, '<?php echo $language; ?>')" class="dopbsp-button dopbsp-small dopbsp-add"><span class="dopbsp-info"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_SELECT_ADD_OPTION_SUBMIT'); ?></span></a>
                                    <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-small dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_SELECT_OPTIONS_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                </div>
                                <ul class="dopbsp-select-options" id="DOPBSP-form-field-select-options-<?php echo $field->id; ?>">
<?php
                    foreach ($select_options as $select_option){
                        $DOPBSP->views->backend_form_field_select_option->template(array('select_option' => $select_option, 
                                                                                 'language' => $language));
                    }
?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
<?php
            }
           
            
            /*
             * Returns text field template.
             * 
             * @param args (array): function arguments
             *                      * field (integer): field data
             *                      * language (string): field language
             * 
             * @return text field HTML
             */
            function templateText($args = array()){
                global $DOPBSP;
                
                $field = $args['field'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
?>
                <li id="DOPBSP-form-field-<?php echo $field->id; ?>" class="dopbsp-field-wrapper">
<?php
                    /*
                     * Preview
                     */
                    $this->displayPreview(array('field' => $field,
                                                'language' => $language));
?>
                    <div class="dopbsp-settings-wrapper">
<?php
                    /*
                     * Label
                     */
                    $this->displayTextInput(array('id' => 'label',
                                                  'label' => $DOPBSP->text('FORMS_FORM_FIELD_LABEL_LABEL'),
                                                  'value' => $DOPBSP->classes->translation->decodeJSON($field->translation, $language),
                                                  'form_field_id' => $field->id,
                                                  'help' => $DOPBSP->text('FORMS_FORM_FIELD_LABEL_HELP')));
                    /*
                     * Allowed characters.
                     */
                    $this->displayTextInput(array('id' => 'allowed_characters',
                                                  'label' => $DOPBSP->text('FORMS_FORM_FIELD_ALLOWED_CHARACTERS_LABEL'),
                                                  'value' => $field->allowed_characters,
                                                  'form_field_id' => $field->id,
                                                  'help' => $DOPBSP->text('FORMS_FORM_FIELD_ALLOWED_CHARACTERS_HELP')));
                    /*
                     * Size
                     */
                    $this->displayTextInput(array('id' => 'size',
                                                  'label' => $DOPBSP->text('FORMS_FORM_FIELD_SIZE_LABEL'),
                                                  'value' => $field->size < 1 ? '':$field->size,
                                                  'form_field_id' => $field->id,
                                                  'help' => $DOPBSP->text('FORMS_FORM_FIELD_SIZE_HELP')));
                    /*
                     * Is email.
                     */
                    $this->displaySwitchInput(array('id' => 'is_email',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_EMAIL_LABEL'),
                                                    'value' => $field->is_email,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_EMAIL_HELP')));
                    /*
                     * Is phone.
                     */
                    $this->displaySwitchInput(array('id' => 'is_phone',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_PHONE_LABEL'),
                                                    'value' => $field->is_phone,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_PHONE_HELP')));
                    /*
                     * Default country.
                     */
                    $this->displayDropdownInput(array('id' => 'default_country',
                                                      'label' => $DOPBSP->text('FORMS_FORM_FIELD_DEFAULT_COUNTRY_LABEL'),
                                                      'phone' =>$field->is_phone,
                                                      'value' => $field->default_country,
                                                      'form_field_id' => $field->id,
                                                      'help' => $DOPBSP->text('FORMS_FORM_FIELD_DEFAULT_COUNTRY')));
                    /*
                     * Required
                     */
                    $this->displaySwitchInput(array('id' => 'required',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_REQUIRED_LABEL'),
                                                    'value' => $field->required,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_REQUIRED_HELP')));
                    /*
                     * Add to info.
                     */
                    $this->displaySwitchInput(array('id' => 'add_to_day_hour_info',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_INFO_LABEL'),
                                                    'value' => $field->add_to_day_hour_info,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_INFO_HELP')));
                    /*
                     * Add to body.
                     */
                    $this->displaySwitchInput(array('id' => 'add_to_day_hour_body',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_BODY_LABEL'),
                                                    'value' => $field->add_to_day_hour_body,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_BODY_HELP'),
                                                    'dopbsp-last'));
?>
                    </div>
                </li>
<?php
            }
            
            /*
             * Returns textarea field template.
             * 
             * @param args (array): function arguments
             *                      * field (integer): field data
             *                      * language (string): field language
             * 
             * @return textarea field HTML
             */
            function templateTextarea($args = array()){
                global $DOPBSP;
                
                $field = $args['field'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
?>
                <li id="DOPBSP-form-field-<?php echo $field->id; ?>" class="dopbsp-field-wrapper">
<?php
                    /*
                     * Preview
                     */
                    $this->displayPreview(array('field' => $field,
                                                'language' => $language));
?>
                    <div class="dopbsp-settings-wrapper">
<?php
                    /*
                     * Label
                     */
                    $this->displayTextInput(array('id' => 'label',
                                                  'label' => $DOPBSP->text('FORMS_FORM_FIELD_LABEL_LABEL'),
                                                  'value' => $DOPBSP->classes->translation->decodeJSON($field->translation, $language),
                                                  'form_field_id' => $field->id,
                                                  'help' => $DOPBSP->text('FORMS_FORM_FIELD_LABEL_HELP')));
                    /*
                     * Allowed characters.
                     */
                    $this->displayTextInput(array('id' => 'allowed_characters',
                                                  'label' => $DOPBSP->text('FORMS_FORM_FIELD_ALLOWED_CHARACTERS_LABEL'),
                                                  'value' => $field->allowed_characters,
                                                  'form_field_id' => $field->id,
                                                  'help' => $DOPBSP->text('FORMS_FORM_FIELD_ALLOWED_CHARACTERS_HELP')));
                    /*
                     * Size
                     */
                    $this->displayTextInput(array('id' => 'size',
                                                  'label' => $DOPBSP->text('FORMS_FORM_FIELD_SIZE_LABEL'),
                                                  'value' => $field->size < 1 ? '':$field->size,
                                                  'form_field_id' => $field->id,
                                                  'help' => $DOPBSP->text('FORMS_FORM_FIELD_SIZE_HELP')));
                    /*
                     * Required
                     */
                    $this->displaySwitchInput(array('id' => 'required',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_REQUIRED_LABEL'),
                                                    'value' => $field->required,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_REQUIRED_HELP')));
                    /*
                     * Add to info.
                     */
                    $this->displaySwitchInput(array('id' => 'add_to_day_hour_info',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_INFO_LABEL'),
                                                    'value' => $field->add_to_day_hour_info,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_INFO_HELP')));
                    /*
                     * Add to body.
                     */
                    $this->displaySwitchInput(array('id' => 'add_to_day_hour_body',
                                                    'label' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_BODY_LABEL'),
                                                    'value' => $field->add_to_day_hour_body,
                                                    'form_field_id' => $field->id,
                                                    'help' => $DOPBSP->text('FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_BODY_HELP'),
                                                    'dopbsp-last'));
?>
                    </div>
                </li>
<?php
            }
            
/*
 * Default templates.
 */            
            /*
             * Create a form field preview.
             * 
             * @param args (array): function arguments
             *                      * field (integer): field data
             *                      * language (string): field language
             *                      * select_options (object): select field options
             * 
             * @return form field preview HTML
             */
            function displayPreview($args = array()){
                global $DOPBSP;
                
                $field = $args['field'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
                $select_options = isset($args['select_options']) ? $args['select_options']:'';
?>
                    <div class="dopbsp-preview-wrapper">
                        <div class="dopbsp-preview dopbsp-input-wrapper">
<?php
                if ($field->type != 'checkbox'){
                    echo '<label id="DOPBSP-form-field-label-preview-'.$field->id.'" for="DOPBSP-form-field-preview-'.$field->id.'">'.$DOPBSP->classes->translation->decodeJSON($field->translation, $language).' <span class="dopbsp-required">'.($field->required == 'true' ? '*':'').'</span></label>';
                }
                        
                switch ($field->type){
                    case 'checkbox':
?>                        
                        <input type="checkbox" name="DOPBSP-form-field-preview-<?php echo $field->id; ?>" id="DOPBSP-form-field-preview-<?php echo $field->id; ?>" disabled="disabled" />
                        <label id="DOPBSP-form-field-label-preview-<?php echo $field->id; ?>" for="DOPBSP-form-field-preview-<?php echo $field->id; ?>" class="dopbsp-left"><?php echo $DOPBSP->classes->translation->decodeJSON($field->translation, $language); ?> <span class="dopbsp-required"><?php echo $field->required == 'true' ? '*':''; ?></span></label>
<?php
                        break;
                    case 'select':
?>                        
                        <select name="DOPBSP-form-field-preview-<?php echo $field->id; ?>" id="DOPBSP-form-field-preview-<?php echo $field->id; ?>" value="" disabled="disabled"<?php echo $field->multiple_select == 'true' ? ' multiple="multiple"':''; ?>>
<?php
                        $i = 0;
                        
                        foreach ($select_options as $select_option){
                            $i++;
                            echo '<option value="'.$i.'">'.$DOPBSP->classes->translation->decodeJSON($select_option->translation, $language).'</option>';
                        }
?>
                        </select>
                        <script type="text/JavaScript">
                            jQuery('#DOPBSP-form-field-preview-<?php echo $field->id; ?>').DOPSelect();
                        </script>
<?php                        
                        break;
                    case 'text':
                        echo '<input type="text" name="DOPBSP-form-field-preview-'.$field->id.'" id="DOPBSP-form-field-preview-'.$field->id.'" value="" disabled="disabled" />';
                        break;
                    case 'textarea':
                        echo '<textarea name="DOPBSP-form-field-preview-'.$field->id.'" id="DOPBSP-form-field-preview-'.$field->id.'" value="" disabled="disabled"></textarea>';
                        break;
                }
?>
                        </div>
                        <div class="dopbsp-buttons-wrapper">
                            <a href="javascript:DOPBSPBackEndFormField.toggle(<?php echo $field->id; ?>)" class="dopbsp-button dopbsp-toggle"><span class="dopbsp-info"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_SHOW_SETTINGS'); ?></span></a>
                            <a href="javascript:DOPBSPBackEnd.confirmation('FORMS_FORM_DELETE_FIELD_CONFIRMATION', 'DOPBSPBackEndFormField.delete(<?php echo $field->id; ?>)')" class="dopbsp-button dopbsp-delete"><span class="dopbsp-info"><?php echo $DOPBSP->text('FORMS_FORM_DELETE_FIELD_SUBMIT'); ?></span></a>
                            <a href="javascript:void(0)" class="dopbsp-button dopbsp-handle"><span class="dopbsp-info"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_SORT'); ?></span></a>
                        </div>
                        <br class="dopbsp-clear" />
                    </div>
<?php                
            }
            
/*
 * Inputs.
 */         
            /*
             * Create a text input field for form fields.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field current value
             *                      * form_field_id (integer): form field ID
             *                      * help (string): field help
             *                      * container_class (string): container class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $form_field_id = $args['form_field_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-form-field-'.$id.'-'.$form_field_id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-form-field-'.$id.'-'.$form_field_id.'" id="DOPBSP-form-field-'.$id.'-'.$form_field_id.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndFormField.edit('.$form_field_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPBackEndFormField.edit('.$form_field_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPBackEndFormField.edit('.$form_field_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
            /*
             * Create a dropdown input field for the country form field.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field current value
             *                      * form_field_id (integer): form field ID
             *                      * help (string): field help
             *                      * container_class (string): container class
             * 
             * @return text input HTML
             */
            function displayDropdownInput($args = array()){
                global $DOPBSP;

                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $form_field_id = $args['form_field_id'];
                $help = $args['help'];
                $phone = $args['phone'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $countries = $DOPBSP->classes->countries->countries;
                $html = array();
                
                if($phone === 'true'){
                    array_push($html, ' <div class="dopbsp-input-wrapper visible" id="'.$id.'-'.$form_field_id.'" >');
                }
                else{
                    array_push($html, ' <div class="dopbsp-input-wrapper hidden" id="'.$id.'-'.$form_field_id.'" >');
                }
                array_push($html, '     <label for="DOPBSP-form-field-'.$id.'-'.$form_field_id.'">'.$label.'</label>');
                array_push($html, '     <select name="DOPBSP-form-field-'.$id.'-'.$form_field_id.'" id="DOPBSP-form-field-'.$id.'-'.$form_field_id.'" class="DOPSelect dopselect-single dopselect-select dopbsp-left "  value="'.$value.'" onChange="{DOPBSPBackEndFormField.edit('.$form_field_id.', \'text\', \''.$id.'\', this.value);}" onblur="DOPBSPBackEndFormField.edit('.$form_field_id.', \'text\', \''.$id.'\', this.value, true)" >');
                
                for ($i=0; $i<count($countries); $i++){
                    if ($value != $countries[$i]['code2']){
                        array_push($html, '     <option value="'.$countries[$i]['code2'].'">'.$countries[$i]['name'].'</option>');
                    }
                    else{
                        array_push($html, '     <option value="'.$countries[$i]['code2'].'" selected="selected">'.$countries[$i]['name'].'</option>');
                    }
                }
                array_push($html, '     </select>');
                array_push($html, '     <script type="text/JavaScript">jQuery(\'#DOPBSP-form-field-'.$id.'-'.$form_field_id.'\').DOPSelect();</script>');          
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help" disabled="disabled"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');
                
                echo implode('', $html);
            }
            
            /*
             * Create a switch field for form fields.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field current value
             *                      * form_field_id (integer): form field ID
             *                      * help (string): field help
             *                      * container_class (string): container class
             * 
             * @return switch HTML
             */
            function displaySwitchInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $form_field_id = $args['form_field_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label class="dopbsp-for-switch">'.$label.'</label>');
                array_push($html, '     <div class="dopbsp-switch">');
                array_push($html, '         <input type="checkbox" name="DOPBSP-form-field-'.$id.'-'.$form_field_id.'" id="DOPBSP-form-field-'.$id.'-'.$form_field_id.'" class="dopbsp-switch-checkbox" onchange="DOPBSPBackEndFormField.edit('.$form_field_id.', \'switch\', \''.$id.'\')"'.($value == 'true' ? ' checked="checked"':'').' />');
                array_push($html, '         <label class="dopbsp-switch-label" for="DOPBSP-form-field-'.$id.'-'.$form_field_id.'">');
                array_push($html, '             <div class="dopbsp-switch-inner"></div>');
                array_push($html, '             <div class="dopbsp-switch-switch"></div>');
                array_push($html, '         </label>');
                array_push($html, '     </div>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help dopbsp-switch-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');
                array_push($html, ' <style type="text/css">');
                array_push($html, '     .DOPBSP-admin .dopbsp-input-wrapper .dopbsp-switch .dopbsp-switch-inner:before{content: "'.$DOPBSP->text('SETTINGS_ENABLED').'";}');
                array_push($html, '     .DOPBSP-admin .dopbsp-input-wrapper .dopbsp-switch .dopbsp-switch-inner:after{content: "'.$DOPBSP->text('SETTINGS_DISABLED').'";}');
                array_push($html, ' </style>');
                
                echo implode('', $html);
            }
        }
    }