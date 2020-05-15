<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : views/models/views-backend-model.php
* File Version            : 1.0
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2016 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end model views class.
*/

    if (!class_exists('DOPBSPViewsBackEndModel')){
        class DOPBSPViewsBackEndModel extends DOPBSPViewsBackEndModels{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns model.
             * 
             * @param args (array): function arguments
             *                      * id (integer): model ID
             *                      * language (string): model language
             * 
             * @return model HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
                
                $model = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->models.' WHERE id=%d',
                                                       $id));
?>
                <div class="dopbsp-inputs-wrapper dopbsp-last">
<?php                    
                /*
                 * Name
                 */
                $this->displayTextInput(array('id' => 'name',
                                              'label' => $DOPBSP->text('MODELS_MODEL_NAME'),
                                              'value' => $model->name,
                                              'model_id' => $model->id,
                                              'help' => $DOPBSP->text('MODELS_MODEL_NAME_HELP')));
?>
                
                    <!--
                        Language
                    -->
                    <div class="dopbsp-input-wrapper">
                        <label for="DOPBSP-model-language"><?php echo $DOPBSP->text('MODELS_MODEL_LANGUAGE'); ?></label>
<?php
                echo $this->getLanguages('DOPBSP-model-language',
                                         'DOPBSPBackEndModel.display('.$model->id.', undefined, false)',
                                         $language,
                                         'dopbsp-left');
?>
                        <a href="javascript:void()" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('MODELS_MODEL_LANGUAGE_HELP'); ?></span></a>
                    </div>
<?php           
                /*
                 * Use this model.
                 */
                $this->displaySwitchInput(array('id' => 'enabled',
                                                'label' => $DOPBSP->text('MODELS_MODEL_ENABLED'),
                                                'value' => $model->enabled,
                                                'model_id' => $model->id,
                                                'help' => $DOPBSP->text('MODELS_MODEL_ENABLED_HELP')));
                /*
                 * Label
                 */ 
                $this->displayTextInput(array('id' => 'label',
                                              'label' => $DOPBSP->text('MODELS_MODEL_LABEL'),
                                              'value' => $DOPBSP->classes->translation->decodeJSON($model->translation, $language),
                                              'model_id' => $model->id,
                                              'help' => $DOPBSP->text('MODELS_MODEL_LABEL_HELP')));
                /*
                 * Use multiple calendars.
                 */
                $this->displaySwitchInput(array('id' => 'multiple_calendars',
                                                'label' => $DOPBSP->text('MODELS_MODEL_MULTIPLE_CALENDARS'),
                                                'value' => $model->multiple_calendars,
                                                'model_id' => $model->id,
                                                'help' => $DOPBSP->text('MODELS_MODEL_MULTIPLE_CALENDARS_HELP')));
                /*
                 * Calendar label.
                 */ 
                $this->displayTextInput(array('id' => 'label_calendar',
                                              'label' => $DOPBSP->text('MODELS_MODEL_CALENDAR_LABEL'),
                                              'value' => $DOPBSP->classes->translation->decodeJSON($model->translation_calendar, $language),
                                              'model_id' => $model->id,
                                              'help' => $DOPBSP->text('MODELS_MODEL_CALENDAR_LABEL_HELP'),
                                              'container_class' => 'dopbsp-last'));
?>
                </div>
<?php 
            }

/*
 * Inputs.
 */         
            /*
             * Create a text input for models.
             * 
             * @param args (array): function arguments
             *                      * id (integer): model field ID
             *                      * label (string): model label
             *                      * value (string): model current value
             *                      * model_id (integer): model ID
             *                      * help (string): model help
             *                      * container_class (string): container class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $model_id = $args['model_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-model-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-model-'.$id.'" id="DOPBSP-model-'.$id.'" class="'.$input_class.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndModel.edit('.$model_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPBackEndModel.edit('.$model_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPBackEndModel.edit('.$model_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');                        
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
            /*
             * Create a drop down field for models.
             * 
             * @param args (array): function arguments
             *                      * id (integer): model field ID
             *                      * label (string): model label
             *                      * value (string): model current value
             *                      * model_id (integer): model ID
             *                      * help (string): model help
             *                      * options (string): options labels
             *                      * options_values (string): options values
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return drop down HTML
             */
            function displaySelectInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $model_id = $args['model_id'];
                $help = $args['help'];
                $options = $args['options'];
                $options_values = $args['options_values'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                
                $html = array();
                $options_data = explode(';;', $options);
                $options_values_data = explode(';;', $options_values);
                
                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-model-'.$id.'">'.$label.'</label>');
                array_push($html, '     <select name="DOPBSP-model-'.$id.'" id="DOPBSP-model-'.$id.'" class="dopbsp-left '.$input_class.'" onchange="DOPBSPBackEndModel.edit('.$model_id.', \'select\', \''.$id.'\', this.value)">');
                
                for ($i=0; $i<count($options_data); $i++){
                    if ($value == $options_values_data[$i]){
                        array_push($html, '     <option value="'.$options_values_data[$i].'" selected="selected">'.$options_data[$i].'</option>');
                    }
                    else{
                        array_push($html, '     <option value="'.$options_values_data[$i].'">'.$options_data[$i].'</option>');
                    }
                }
                array_push($html, '     </select>');
                array_push($html, '     <script type="text/JavaScript">jQuery(\'#DOPBSP-model-'.$id.'\').DOPSelect();</script>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');
                
                echo implode('', $html);
            }
            
            
            /*
             * Create a switch item for models.
             * 
             * @param args (array): function arguments
             *                      * id (integer): model field ID
             *                      * label (string): model label
             *                      * value (string): model current value
             *                      * model_id (integer): model ID
             *                      * help (string): model help
             *                      * container_class (string): container class
             * 
             * @return switch HTML
             */
            function displaySwitchInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $model_id = $args['model_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label class="dopbsp-for-switch">'.$label.'</label>');
                array_push($html, '     <div class="dopbsp-switch">');
                array_push($html, '         <input type="checkbox" name="DOPBSP-model-'.$id.'-'.$model_id.'" id="DOPBSP-model-'.$id.'-'.$model_id.'" class="dopbsp-switch-checkbox" onchange="DOPBSPBackEndModel.edit('.$model_id.', \'switch\', \''.$id.'\')"'.($value == 'true' ? ' checked="checked"':'').' />');
                array_push($html, '         <label class="dopbsp-switch-label" for="DOPBSP-model-'.$id.'-'.$model_id.'">');
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