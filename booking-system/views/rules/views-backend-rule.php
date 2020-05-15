<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : views/views-backend-rules.php
* File Version            : 1.0.7
* Created / Last Modified : 16 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end rules views class.
*/

    if (!class_exists('DOPBSPViewsBackEndRule')){
        class DOPBSPViewsBackEndRule extends DOPBSPViewsBackEndRules{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns rule template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): rule ID
             *                      * language (string): rule language
             * 
             * @return rule HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                
                $rule = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->rules.' WHERE id=%d',
                                                      $id));
?>
                <div class="dopbsp-inputs-wrapper dopbsp-last">
<?php                    
                /*
                 * Name
                 */
                $this->displayTextInput(array('id' => 'name',
                                              'label' => $DOPBSP->text('RULES_RULE_NAME'),
                                              'value' => $rule->name,
                                              'rule_id' => $rule->id,
                                              'help' => $DOPBSP->text('RULES_RULE_NAME_HELP')));
                /*
                 * Time lapse min.
                 */
                $this->displayTextInput(array('id' => 'time_lapse_min',
                                              'label' => $DOPBSP->text('RULES_RULE_TIME_LAPSE_MIN'),
                                              'value' => $rule->time_lapse_min,
                                              'rule_id' => $rule->id,
                                              'help' => $DOPBSP->text('RULES_RULE_TIME_LAPSE_MIN_HELP'),
                                              'container_class' => '',
                                              'input_class' => 'dopbsp-small'));
                /*
                 * Time lapse max.
                 */
                $this->displayTextInput(array('id' => 'time_lapse_max',
                                              'label' => $DOPBSP->text('RULES_RULE_TIME_LAPSE_MAX'),
                                              'value' => $rule->time_lapse_max,
                                              'rule_id' => $rule->id,
                                              'help' => $DOPBSP->text('RULES_RULE_TIME_LAPSE_MAX_HELP'),
                                              'container_class' => 'dopbsp-last',
                                              'input_class' => 'dopbsp-small'));
?>
                </div>
<?php 
            }

/*
 * Inputs.
 */         
            /*
             * Create a text input for rules.
             * 
             * @param args (array): function arguments
             *                      * id (integer): rule field ID
             *                      * label (string): rule label
             *                      * value (string): rule current value
             *                      * rule_id (integer): rule ID
             *                      * help (string): rule help
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $rule_id = $args['rule_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-rule-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-rule-'.$id.'" id="DOPBSP-rule-'.$id.'" class="'.$input_class.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndRule.edit('.$rule_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPBackEndRule.edit('.$rule_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPBackEndRule.edit('.$rule_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');

                echo implode('', $html);
            }
        }
    }