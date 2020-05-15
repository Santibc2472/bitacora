<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/addons/views-backend-addons-filters.php
* File Version            : 1.0.2
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end addons filters views class.
*/

    if (!class_exists('DOPBSPViewsBackEndAddonsFilters')){
        class DOPBSPViewsBackEndAddonsFilters extends DOPBSPViewsBackEndAddons{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns addons filters template.
             * 
             * @param args (array): function arguments
             * 
             * @return addons filters HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $addons = $args['addons'];
                
                if (count($addons) == 0){
                    return false;
                }
?>
                                <!--
                                    Search
                                -->
                                <div class="dopbsp-inputs-header dopbsp-hide">
                                    <h3><?php echo $DOPBSP->text('ADDONS_FILTERS_SEARCH'); ?></h3>
                                    <a href="javascript:DOPBSPBackEnd.toggleInputs('addons-filters-search')" id="DOPBSP-inputs-button-addons-filters-search" class="dopbsp-button"></a>
                                </div>
                                <div id="DOPBSP-inputs-addons-filters-search" class="dopbsp-inputs-wrapper">
                                    <div class="dopbsp-input-wrapper ">     
                                        <label for="DOPBSP-addons-search"><?php echo $DOPBSP->text('ADDONS_FILTERS_SEARCH_TERMS'); ?></label>     
                                        <input type="text" name="DOPBSP-addons-search" id="DOPBSP-addons-search" class="dopbsp-left " value="" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndAddons.search();}" onpaste="DOPBSPBackEndAddons.search()" onblur="DOPBSPBackEndAddons.search()">     
                                    </div>
                                </div>
                                
                                <!--
                                    Categories
                                -->
                                <div class="dopbsp-inputs-header dopbsp-hide dopbsp-last">
                                    <h3><?php echo $DOPBSP->text('ADDONS_FILTERS_CATEGORIES'); ?></h3>
                                    <a href="javascript:DOPBSPBackEnd.toggleInputs('addons-filters-categories')" id="DOPBSP-inputs-button-addons-filters-categories" class="dopbsp-button"></a>
                                </div>
                                <div id="DOPBSP-inputs-addons-filters-categories" class="dopbsp-inputs-wrapper dopbsp-last">
<?php                
                foreach ($addons as $key => $category){
?>
                                    <div class="dopbsp-input-wrapper dopbsp-last">
                                        <input type="checkbox" name="DOPBSP-addons-category-<?php echo $key; ?>" id="DOPBSP-addons-category-<?php echo $key; ?>" checked="checked" onchange="DOPBSPBackEndAddons.category('<?php echo $key; ?>')">
                                        <label class="dopbsp-for-checkbox" for="DOPBSP-addons-category-<?php echo $key; ?>"><?php echo $category->name; ?></label>
                                    </div>
<?php                
                }
?>
                                </div>
<?php                
            }
        }
    }