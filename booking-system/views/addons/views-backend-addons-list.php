<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/addons/views-backend-addons-list.php
* File Version            : 1.0.2
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end addons list views class.
*/

    if (!class_exists('DOPBSPViewsBackEndAddonsList')){
        class DOPBSPViewsBackEndAddonsList extends DOPBSPViewsBackEndAddons{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns addons list template.
             * 
             * @param args (array): function arguments
             * 
             * @return addons list HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $addons = $args['addons'];
                $i = 0;
                $no_categories = count((array)$addons);
                
                if (count($addons) == 0){
?>
                                <div class="dopbsp-inputs-wrapper dopbsp-last">
                                    <ul id="DOPBSP-themes-list" class="dopbsp-themes-list">
                                        <li class="dopbsp-no-data"><?php echo $DOPBSP->text('SOON_TITLE'); ?>.</li>
                                    </ul>
                                </div>
<?php
                }
                else{
                    foreach ($addons as $key => $category){
                        $i++;
?>
                                <div class="dopbsp-inputs-header dopbsp-hide<?php echo $no_categories == $i ? ' dopbsp-last':''; ?>">
                                    <h3><?php echo $category->name; ?></h3>
                                    <a href="javascript:DOPBSPBackEndAddons.category('<?php echo $key; ?>')" id="DOPBSP-inputs-button-addons-category-<?php echo $key; ?>" class="dopbsp-button"></a>
                                </div>
                                <div id="DOPBSP-inputs-addons-category-<?php echo $key; ?>" class="dopbsp-inputs-wrapper<?php echo $no_categories == $i ? ' dopbsp-last':''; ?>">
                                    <ul class="dopbsp-addons-list">
<?php
                    
                        foreach ($category->addons as $addon){
?>
                                        <li class="dopbsp-addon">
                                            <span class="dopbsp-price"><?php echo $DOPBSP->text('ADDONS_ADDON_PRICE'); ?> <?php echo $addon->price; ?></span>
                                            <h5><?php echo $addon->title; ?></h5>
                                            <p><?php echo $addon->description; ?></p>
                                            <a href="<?php echo $addon->link; ?>" target="_blank" title="<?php echo $DOPBSP->text('ADDONS_ADDON_GET_IT_NOW'); ?>" class="dopbsp-get-it"><?php echo $DOPBSP->text('ADDONS_ADDON_GET_IT_NOW'); ?></a>
                                        </li>
<?php
                        }
?>
                                    </ul>
                                </div>
<?php
                    }
                }
            }
        }
    }