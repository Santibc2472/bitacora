<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : views/themes/views-backend-themes-filters.php
* File Version            : 1.0.2
* Created / Last Modified : 11 October 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end themes filters views class.
*/

    if (!class_exists('DOPBSPViewsBackEndThemesFilters')){
        class DOPBSPViewsBackEndThemesFilters extends DOPBSPViewsBackEndThemes{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns themes filters template.
             * 
             * @param args (array): function arguments
             * 
             * @return themes filters HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $themes = $args['themes'];
                
                if (count($themes->themes) == 0){
                    return false;
                }
?>
                                <!--
                                    Search
                                -->
                                <div class="dopbsp-inputs-header dopbsp-hide">
                                    <h3><?php echo $DOPBSP->text('THEMES_FILTERS_SEARCH'); ?></h3>
                                    <a href="javascript:DOPBSPBackEnd.toggleInputs('themes-filters-search')" id="DOPBSP-inputs-button-themes-filters-search" class="dopbsp-button"></a>
                                </div>
                                <div id="DOPBSP-inputs-themes-filters-search" class="dopbsp-inputs-wrapper">
                                    <div class="dopbsp-input-wrapper ">     
                                        <label for="DOPBSP-themes-search"><?php echo $DOPBSP->text('THEMES_FILTERS_SEARCH_TERMS'); ?></label>     
                                        <input type="text" name="DOPBSP-themes-search" id="DOPBSP-themes-search" class="dopbsp-left " value="" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndThemes.search();}" onpaste="DOPBSPBackEndThemes.search()" onblur="DOPBSPBackEndThemes.search()" />     
                                    </div>
                                </div>
                                
                                <!--
                                    Tags
                                -->
                                <div class="dopbsp-inputs-header dopbsp-hide dopbsp-last">
                                    <h3><?php echo $DOPBSP->text('THEMES_FILTERS_TAGS'); ?></h3>
                                    <a href="javascript:DOPBSPBackEnd.toggleInputs('themes-filters-tags')" id="DOPBSP-inputs-button-themes-filters-tags" class="dopbsp-button"></a>
                                </div>
                                <div id="DOPBSP-inputs-themes-filters-tags" class="dopbsp-inputs-wrapper dopbsp-last">
                                    <div class="dopbsp-input-wrapper dopbsp-last dopbsp-selected" data-filter=".dopbsp-all">
                                        <input type="checkbox" name="DOPBSP-themes-tag-all" id="DOPBSP-themes-tag-all" checked="checked" />
                                        <label class="dopbsp-for-checkbox" for="DOPBSP-themes-tag-all"><?php echo $DOPBSP->text('THEMES_FILTERS_TAGS_ALL'); ?></label>
                                    </div>
<?php           
                foreach ($themes->filters as $key => $filter){
?>
                                    <div class="dopbsp-input-wrapper dopbsp-last" data-filter=".dopbsp-<?php echo $key; ?>">
                                        <input type="checkbox" name="DOPBSP-themes-tag-<?php echo $key; ?>" id="DOPBSP-themes-tag-<?php echo $key; ?>" />
                                        <label class="dopbsp-for-checkbox" for="DOPBSP-themes-tag-<?php echo $key; ?>"><?php echo $filter; ?></label>
                                    </div>
<?php                
                }
?>
                                </div>
<?php                
            }
        }
    }