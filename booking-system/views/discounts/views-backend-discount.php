<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/discounts/views-backend-discount.php
* File Version            : 1.0.9
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end discount views class.
*/

    if (!class_exists('DOPBSPViewsBackEndDiscount')){
        class DOPBSPViewsBackEndDiscount extends DOPBSPViewsBackEndDiscounts{
            /*
             * Constructor
             */
            function __construct(){
            }
            
             /*
             * Returns discount template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): discount ID
             *                      * language (string): discount language
             * 
             * @return discount HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
                
                $discount = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts.' WHERE id=%d',
                                                          $id));
?>
                <div class="dopbsp-inputs-wrapper">
<?php                    
                /*
                 * Name
                 */
                $this->displayTextInput(array('id' => 'name', 
                                              'label' => $DOPBSP->text('DISCOUNTS_DISCOUNT_NAME'), 
                                              'value' => $discount->name, 
                                              'discount_id' => $discount->id, 
                                              'help' => $DOPBSP->text('DISCOUNTS_DISCOUNT_NAME_HELP')));
?>
                
                    <!--
                        Language
                    -->
                    <div class="dopbsp-input-wrapper">
                        <label for="DOPBSP-discount-language"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_LANGUAGE'); ?></label>
<?php
                echo $this->getLanguages('DOPBSP-discount-language',
                                         'DOPBSPBackEndDiscount.display('.$discount->id.', undefined, false)',
                                         $language,
                                         'dopbsp-left');
?>
                        <a href="javascript:void()" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_LANGUAGE_HELP'); ?></span></a>
                    </div>
<?php
                /*
                 * Include extras.
                 */
                $this->displaySwitchInput(array('id' => 'extras',
                                                'label' => $DOPBSP->text('DISCOUNTS_DISCOUNT_EXTRAS'),
                                                'value' => $discount->extras,
                                                'discount_id' => $discount->id,
                                                'help' => $DOPBSP->text('DISCOUNTS_DISCOUNT_EXTRAS_HELP'),
                                                'container_class' => ' dopbsp-last'));
?>
                </div>
<?php 
            }
            
/*
 * Inputs.
 */         
            /*
             * Create a text input item for discount.
             * 
             * @param args (array): function arguments
             *                      * id (integer): item ID
             *                      * label (string): item label
             *                      * value (string): item current value
             *                      * discount_id (integer): discount ID
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
                $discount_id = $args['discount_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();
                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-discount-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-discount-'.$id.'" id="DOPBSP-discount-'.$id.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndDiscount.edit('.$discount_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPBackEndDiscount.edit('.$discount_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPBackEndDiscount.edit('.$discount_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');                        
                array_push($html, ' </div>');
                echo implode('', $html);
            }
            
            
            /*
             * Create a switch item for discounts.
             * 
             * @param args (array): function arguments
             *                      * id (integer): discount field ID
             *                      * label (string): discount label
             *                      * value (string): discount current value
             *                      * discount_id (integer): discount ID
             *                      * help (string): discount help
             *                      * container_class (string): container class
             * 
             * @return switch HTML
             */
            function displaySwitchInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $discount_id = $args['discount_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();
                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label class="dopbsp-for-switch">'.$label.'</label>');
                array_push($html, '     <div class="dopbsp-switch">');
                array_push($html, '         <input type="checkbox" name="DOPBSP-discount-'.$id.'-'.$discount_id.'" id="DOPBSP-discount-'.$id.'-'.$discount_id.'" class="dopbsp-switch-checkbox" onchange="DOPBSPBackEndDiscount.edit('.$discount_id.', \'switch\', \''.$id.'\')"'.($value == 'true' ? ' checked="checked"':'').' />');
                array_push($html, '         <label class="dopbsp-switch-label" for="DOPBSP-discount-'.$id.'-'.$discount_id.'">');
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