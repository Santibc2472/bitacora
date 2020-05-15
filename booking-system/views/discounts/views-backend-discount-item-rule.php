<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/discounts/views-backend-discount-item-rule.php
* File Version            : 1.0.4
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end discount item rule views class.
*/

    if (!class_exists('DOPBSPViewsBackEndDiscountItemRule')){
        class DOPBSPViewsBackEndDiscountItemRule extends DOPBSPViewsBackEndDiscountItem{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns item rule template.
             * 
             * @param args (array): function arguments
             *                      * rule (integer): select data
             *                      * language (string): item language
             * 
             * @return select item HTML
             */
            function template($args = array()){
                global $DOPBSP;
                
                $rule = $args['rule'];
                
                $hours = $DOPBSP->classes->prototypes->getHours();
?>
                <li id="DOPBSP-discount-item-rule-<?php echo $rule->id; ?>" class="dopbsp-item-rule-wrapper">
                    <div class="dopbsp-input-wrapper">
                        <!--
                            Buttons
                        -->
                        <a href="javascript:void(0)" class="dopbsp-button dopbsp-small dopbsp-handle"><span class="dopbsp-info"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULE_SORT'); ?></span></a>
                        <a href="javascript:DOPBSPBackEnd.confirmation('DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE_CONFIRMATION', 'DOPBSPBackEndDiscountItemRule.delete(<?php echo $rule->id; ?>)')" class="dopbsp-button dopbsp-small dopbsp-delete"><span class="dopbsp-info"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE_SUBMIT'); ?></span></a>
                        
                        <!--
                            Start date
                        -->
                        <input type="text" name="DOPBSP-discount-item-rule-start-date-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-start-date-<?php echo $rule->id; ?>" class="DOPBSP-discount-item-rule-start-date dopbsp-date" value="<?php echo $rule->start_date; ?>" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'start_date', this.value); DOPBSPBackEndDiscountItemRule.init();}" onchange="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'start_date', this.value); DOPBSPBackEndDiscountItemRule.init()" onpaste="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'start_date', this.value); DOPBSPBackEndDiscountItemRule.init()" onblur="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'start_date', this.value, true); DOPBSPBackEndDiscountItemRule.init()" />
                        
                        <!--
                            End date
                        -->
                        <input type="text" name="DOPBSP-discount-item-rule-end-date-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-end-date-<?php echo $rule->id; ?>" class="DOPBSP-discount-item-rule-end-date dopbsp-date" value="<?php echo $rule->end_date; ?>" style="margin-left:5px;" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'end_date', this.value);}" onchange="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'end_date', this.value)" onpaste="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'end_date', this.value)" onblur="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'end_date', this.value, true)" />                        
                        <br class="dopbsp-clear" />
                        
                        <!--
                            Start Hour
                        -->
                        <select name="DOPBSP-discount-item-rule-start-hour-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-start-hour-<?php echo $rule->id; ?>" class="dopbsp-no-margin dopbsp-hour" onchange="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'select', 'start_hour', this.value)">
                            <option value=""></option>
<?php
                for ($i=0; $i<count($hours); $i++){
?>
                            <option value="<?php echo $hours[$i]; ?>"<?php echo $rule->start_hour == $hours[$i] ? ' selected="selected"':''; ?>><?php echo $hours[$i]; ?></option>
<?php
                }
?>
                        </select>
                        <script>
                            jQuery('#DOPBSP-discount-item-rule-start-hour-<?php echo $rule->id; ?>').DOPSelect();
                        </script>
                        
                        <!--
                            End Hour
                        -->
                        <select name="DOPBSP-discount-item-rule-end-hour-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-end-hour-<?php echo $rule->id; ?>" class="dopbsp-hour" onchange="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'select', 'end_hour', this.value)">
                            <option value=""></option>
<?php
                for ($i=0; $i<count($hours); $i++){
?>
                            <option value="<?php echo $hours[$i]; ?>"<?php echo $rule->end_hour == $hours[$i] ? ' selected="selected"':''; ?>><?php echo $hours[$i]; ?></option>
<?php
                }
?>
                        </select>
                        <script>
                            jQuery('#DOPBSP-discount-item-rule-end-hour-<?php echo $rule->id; ?>').DOPSelect();
                        </script>
                        
                        <br class="dopbsp-clear" />
                        
                        <!--
                            Operation
                        -->
                        <label for="DOPBSP-discount-item-rule-operation-<?php echo $rule->id; ?>" class="dopbsp-no-margin"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_OPERATION'); ?></label>
                        <select name="DOPBSP-discount-item-rule-operation-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-operation-<?php echo $rule->id; ?>" class="dopbsp-small" onchange="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'select', 'operation', this.value)">
                            <option value="+"<?php echo $rule->operation == '+' ? ' selected="selected"':''; ?>>+</option>
                            <option value="-"<?php echo $rule->operation == '-' ? ' selected="selected"':''; ?>>-</option>
                        </select>
                        <script>
                            jQuery('#DOPBSP-discount-item-rule-operation-<?php echo $rule->id; ?>').DOPSelect();
                        </script>
                        
                        <!--
                            Price
                        -->
                        <label for="DOPBSP-discount-item-rule-price-<?php echo $rule->id; ?>"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_PRICE'); ?></label>
                        <input type="text" name="DOPBSP-discount-item-rule-price-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-price-<?php echo $rule->id; ?>" class="dopbsp-small DOPBSP-input-discount-item-rule-price" value="<?php echo $rule->price; ?>" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'price', this.value);}" onpaste="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'price', this.value)" onblur="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'price', this.value, true)" />
                        
                        <!--
                            Price type
                        -->
                        <label for="DOPBSP-discount-item-rule-price_type-<?php echo $rule->id; ?>"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_PRICE_TYPE'); ?></label>
                        <select name="DOPBSP-discount-item-rule-price_type-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-price_type-<?php echo $rule->id; ?>" class="dopbsp-small" onchange="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'select', 'price_type', this.value)">
                            <option value="fixed"<?php echo $rule->price_type == 'fixed' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_TYPE_FIXED'); ?></option>
                            <option value="percent"<?php echo $rule->price_type == 'percent' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_TYPE_PERCENT'); ?></option>
                        </select>
                        <script>
                            jQuery('#DOPBSP-discount-item-rule-price_type-<?php echo $rule->id; ?>').DOPSelect();
                        </script>
                        
                        <!--
                            Price by
                        -->
                        <label for="DOPBSP-discount-item-rule-price_by-<?php echo $rule->id; ?>"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_PRICE_BY'); ?></label>
                        <select name="DOPBSP-discount-item-rule-price_by-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-price_by-<?php echo $rule->id; ?>" class="dopbsp-small" onchange="DOPBSPBackEndDiscountItemRule.edit(<?php echo $rule->id; ?>, 'select', 'price_by', this.value)">
                            <option value="once"<?php echo $rule->price_by == 'once' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_BY_ONCE'); ?></option>
                            <option value="period"<?php echo $rule->price_by == 'period' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_BY_PERIOD'); ?></option>
                        </select>
                        <script>
                            jQuery('#DOPBSP-discount-item-rule-price_by-<?php echo $rule->id; ?>').DOPSelect();
                        </script>
                    </div>
                </li>
<?php
            }
        }
    }