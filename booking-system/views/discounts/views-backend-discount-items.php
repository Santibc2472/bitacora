<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/discounts/views-backend-discount-items.php
* File Version            : 1.0.6
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end discount items views class.
*/

    if (!class_exists('DOPBSPViewsBackEndDiscountItems')){
        class DOPBSPViewsBackEndDiscountItems extends DOPBSPViewsBackEndDiscount{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns discount items template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): discount ID
             *                      * language (string): discount language
             * 
             * @return discount items HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
?>
                <div class="dopbsp-discount-items-header">
                    <a href="javascript:DOPBSPBackEndDiscountItem.add(<?php echo $id; ?>, '<?php echo $language; ?>')" class="dopbsp-button dopbsp-add"><span class="dopbsp-info"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ADD_ITEM_SUBMIT'); ?></span></a>
                    <h3><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEMS'); ?></h3>
                </div>
                <ul id="DOPBSP-discount-items" class="dopbsp-discount-items">
<?php
                $items = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts_items.' WHERE discount_id=%d ORDER BY position ASC',
                                                           $id));
                
                if ($wpdb->num_rows > 0){
                    foreach($items as $item){
                        $DOPBSP->views->backend_discount_item->template(array('item' => $item,
                                                                      'language' => $language));
                    }
                }
?>    
                </ul>
<?php                    
            }
        }
    }