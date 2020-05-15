<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/discounts/views-backend-discount-item.php
* File Version            : 1.0.8
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end discount item views class.
*/

    if (!class_exists('DOPBSPViewsBackEndDiscountItem')){
        class DOPBSPViewsBackEndDiscountItem extends DOPBSPViewsBackEndDiscountItems{
            /*
             * Constructor
             */
            function __construct(){
            }
          
            /*
             * Returns item template.
             * 
             * @param args (array): function arguments
             *                      * item (integer): item data
             *                      * language (string): item language
             * 
             * @return item HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $item = $args['item'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
                
                $rules = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts_items_rules.' WHERE discount_item_id=%d ORDER BY position ASC',
                                                           $item->id));  
?>
                <li id="DOPBSP-discount-item-<?php echo $item->id; ?>" class="dopbsp-item-wrapper">
<?php
                    /*
                     * Preview
                     */
                    $this->displayPreview(array('item' => $item,
                                                'language' => $language));
?>
                    <div class="dopbsp-settings-wrapper">
<?php

                    /*
                     * Label
                     */
                    $this->displayTextInput(array('id' => 'label',
                                                  'label' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_LABEL_LABEL'),
                                                  'value' => $DOPBSP->classes->translation->decodeJSON($item->translation, $language),
                                                  'discount_item_id' => $item->id,
                                                  'help' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_LABEL_HELP')));
                    /*
                     * Start time lapse.
                     */
                    $this->displayTextInput(array('id' => 'start_time_lapse',
                                                  'label' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_START_TIME_LAPSE_LABEL'),
                                                  'value' => $item->start_time_lapse,
                                                  'discount_item_id' => $item->id,
                                                  'help' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_START_TIME_LAPSE_HELP'),
                                                  'container_class' => '',
                                                  'input_class' => 'dopbsp-time-lapse DOPBSP-input-discount-item-time-lapse'));
                    /*
                     * End time lapse.
                     */
                    $this->displayTextInput(array('id' => 'end_time_lapse',
                                                  'label' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_END_TIME_LAPSE_LABEL'),
                                                  'value' => $item->end_time_lapse,
                                                  'discount_item_id' => $item->id,
                                                  'help' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_END_TIME_LAPSE_HELP'),
                                                  'container_class' => '',
                                                  'input_class' => 'dopbsp-time-lapse DOPBSP-input-discount-item-time-lapse'));
                    /*
                     * Operation
                     */
                    $this->displaySelectInput(array('id' => 'operation',
                                                    'label' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_OPERATION_LABEL'),
                                                    'value' => $item->operation,
                                                    'discount_item_id' => $item->id,
                                                    'help' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_OPERATION_HELP'),
                                                    'options' => '+;;-',
                                                    'options_values' => '+;;-',
                                                    'container_class' => '',
                                                    'input_class' => 'dopbsp-small'));
                    /*
                     * Price
                     */
                    $this->displayTextInput(array('id' => 'price',
                                                  'label' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_PRICE_LABEL'),
                                                  'value' => $item->price,
                                                  'discount_item_id' => $item->id,
                                                  'help' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_PRICE_HELP'),
                                                  'container_class' => '',
                                                  'input_class' => 'dopbsp-small DOPBSP-input-discount-item-price'));
                    /*
                     * Price type.
                     */
                    $this->displaySelectInput(array('id' => 'price_type',
                                                    'label' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_PRICE_TYPE_LABEL'),
                                                    'value' => $item->price_type,
                                                    'discount_item_id' => $item->id,
                                                    'help' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_PRICE_TYPE_HELP'),
                                                    'options' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_TYPE_FIXED').';;'.$DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_TYPE_PERCENT'),
                                                    'options_values' => 'fixed;;percent'));
                    /*
                     * Price by.
                     */
                    $this->displaySelectInput(array('id' => 'price_by',
                                                    'label' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_PRICE_BY_LABEL'),
                                                    'value' => $item->price_by,
                                                    'discount_item_id' => $item->id,
                                                    'help' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_PRICE_BY_HELP'),
                                                    'options' => $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_BY_ONCE').';;'.$DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_BY_PERIOD'),
                                                    'options_values' => 'once;;period'));
?>
                        <div class="dopbsp-input-wrapper dopbsp-last">
                            <label><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_LABEL'); ?></label>
                            <div class="dopbsp-rules-wrapper">
                                <div class="dopbsp-buttons">
                                    <a href="javascript:DOPBSPBackEndDiscountItemRule.add(<?php echo $item->id; ?>, '<?php echo $language; ?>')" class="dopbsp-button dopbsp-small dopbsp-add"><span class="dopbsp-info"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_ADD_RULE_SUBMIT'); ?></span></a>
                                    <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="dopbsp-button dopbsp-small dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                </div>   
                                <ul class="dopbsp-rules" id="DOPBSP-discount-item-rules-<?php echo $item->id; ?>">
<?php
                    foreach ($rules as $rule){
                        $DOPBSP->views->backend_discount_item_rule->template(array('rule' => $rule, 
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
 * Default templates.
 */            
            /*
             * Create a discount item preview.
             * 
             * @param args (array): function arguments
             *                      * item (integer): item data
             *                      * language (string): item language
             * 
             * @return discount item preview HTML
             */
            function displayPreview($args = array()){
                global $DOPBSP;
                
                $item = $args['item'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
?>
                    <div class="dopbsp-preview-wrapper">
                        <div class="dopbsp-preview dopbsp-input-wrapper">
                            <label id="DOPBSP-discount-item-label-preview-<?php echo $item->id; ?>" for="DOPBSP-discount-item-preview-<?php echo $item->id; ?>"><?php echo $DOPBSP->classes->translation->decodeJSON($item->translation, $language); ?> </label>
                        </div>
                        <div class="dopbsp-buttons-wrapper">
                            <a href="javascript:DOPBSPBackEndDiscountItem.toggle(<?php echo $item->id; ?>)" class="dopbsp-button dopbsp-toggle"><span class="dopbsp-info"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_SHOW_SETTINGS'); ?></span></a>
                            <a href="javascript:DOPBSPBackEnd.confirmation('DISCOUNTS_DISCOUNT_DELETE_ITEM_CONFIRMATION', 'DOPBSPBackEndDiscountItem.delete(<?php echo $item->id; ?>)')" class="dopbsp-button dopbsp-delete"><span class="dopbsp-info"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_DELETE_ITEM_SUBMIT'); ?></span></a>
                            <a href="javascript:void(0)" class="dopbsp-button dopbsp-handle"><span class="dopbsp-info"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_SORT'); ?></span></a>
                        </div>
                        <br class="dopbsp-clear" />
                    </div>
<?php                
            }
            
/*
 * Inputs.
 */         
            
            /*
             * Create a text input item for discount items.
             * 
             * @param args (array): function arguments
             *                      * id (integer): item ID
             *                      * label (string): item label
             *                      * value (string): item current value
             *                      * discount_item_id (integer): discount item ID
             *                      * help (string): item help
             *                      * container_class (string): container class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $discount_item_id = $args['discount_item_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-discount-item-'.$id.'-'.$discount_item_id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-discount-item-'.$id.'-'.$discount_item_id.'"  class="dopbsp-left '.$input_class.'" id="DOPBSP-discount-item-'.$id.'-'.$discount_item_id.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndDiscountItem.edit('.$discount_item_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPBackEndDiscountItem.edit('.$discount_item_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPBackEndDiscountItem.edit('.$discount_item_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');

                echo implode('', $html);
            }
                     
            /*
             * Create a select select item for discount items.
             * 
             * @param args (array): function arguments
             *                      * id (integer): item ID
             *                      * label (string): item label
             *                      * value (string): item current value
             *                      * discount_item_id (integer): discount rule ID
             *                      * help (string): item help
             *                      * options (string): options
             *                      * options_values (string): options_values class
             *                      * container_class (string): container class
             *                      * input_class (string): input_class class
             * 
             * @return text input HTML
             */
            function displaySelectInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $discount_item_id = $args['discount_item_id'];
                $help = $args['help'];
                $options = $args['options'];
                $options_values = $args['options_values'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                
                $html = array();
                $options_data = explode(';;', $options);
                $options_values_data = explode(';;', $options_values);

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-discount-item-'.$id.'-'.$discount_item_id.'">'.$label.'</label>');
                array_push($html, '     <select type="text" name="DOPBSP-discount-item-'.$id.'-'.$discount_item_id.'" class="dopbsp-left '.$input_class.'" id="DOPBSP-discount-item-'.$id.'-'.$discount_item_id.'" value="'.$value.'" onchange="DOPBSPBackEndDiscountItem.edit('.$discount_item_id.', \'select\', \''.$id.'\', this.value);" >');
                
                for ($i=0; $i<count($options_data); $i++){
                    if ($value == $options_values_data[$i]){
                        array_push($html, '     <option value="'.$options_values_data[$i].'" selected="selected">'.$options_data[$i].'</option>');
                    }
                    else{
                        array_push($html, '     <option value="'.$options_values_data[$i].'">'.$options_data[$i].'</option>');
                    }
                }
                array_push($html, '     </select>');
                array_push($html, '     <script type="text/JavaScript">');
                array_push($html, '         jQuery("#DOPBSP-discount-item-'.$id.'-'.$discount_item_id.'").DOPSelect();');
                array_push($html, '     </script>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
            
            /*
             * Create a switch item for discount items.
             * 
             * @param args (array): function arguments
             *                      * id (integer): item ID
             *                      * label (string): item label
             *                      * value (string): item current value
             *                      * discount_item_id (integer): discount item ID
             *                      * help (string): item help
             *                      * container_class (string): container class
             * 
             * @return switch HTML
             */
            function displaySwitchInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $discount_item_id = $args['discount_item_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label class="dopbsp-for-switch">'.$label.'</label>');
                array_push($html, '     <div class="dopbsp-switch">');
                array_push($html, '         <input type="checkbox" name="DOPBSP-discount-item-'.$id.'-'.$discount_item_id.'" id="DOPBSP-discount-item-'.$id.'-'.$discount_item_id.'" class="dopbsp-switch-checkbox" onchange="DOPBSPBackEndDiscountItem.edit('.$discount_item_id.', \'switch\', \''.$id.'\')"'.($value == 'true' ? ' checked="checked"':'').' />');
                array_push($html, '         <label class="dopbsp-switch-label" for="DOPBSP-discount-item-'.$id.'-'.$discount_item_id.'">');
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