<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : views/themes/views-backend-themes-list.php
* File Version            : 1.0.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end themes list views class.
*/

    if (!class_exists('DOPBSPViewsBackEndThemesList')){
        class DOPBSPViewsBackEndThemesList extends DOPBSPViewsBackEndThemes{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns themes list template.
             * 
             * @param args (array): function arguments
             * 
             * @return themes list HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $themes = $args['themes'];
?>
                                <div class="dopbsp-inputs-wrapper dopbsp-last">
                                    <ul id="DOPBSP-themes-list" class="dopbsp-themes-list">
<?php
                if (count($themes->themes) == 0){
                    echo '<li class="dopbsp-no-data">'.$DOPBSP->text('SOON_TITLE').'.</li>';
                }
                else{
                    $i = 0;

                    foreach ($themes->themes as $theme){
                        $tags = array();

                        $i++;

                        $tags = explode(',', strtolower(str_replace(' ', '-', $theme->tags)));
                        array_push($tags, 'all');
                        array_push($tags, 'theme-'.$i);
?>
                                        <li class="dopbsp-theme <?php echo 'dopbsp-'.implode(' dopbsp-', $tags); ?>">
                                            <div class="dopbsp-thumbnail" style="background-image: url(<?php echo $theme->image; ?>);"></div>
                                            <span class="dopbsp-price"><?php echo $DOPBSP->text('THEMES_THEME_PRICE'); ?> <?php echo $theme->price; ?></span>
                                            <h5><?php echo $theme->title; ?></h5>
                                            <p><?php echo $theme->description; ?></p>
                                            <a href="<?php echo $theme->link_buy; ?>" target="_blank" title="<?php echo $DOPBSP->text('THEMES_THEME_GET_IT_NOW'); ?>" class="dopbsp-get-it"><?php echo $DOPBSP->text('THEMES_THEME_GET_IT_NOW'); ?></a>
                                            <a href="<?php echo $theme->link_buy; ?>" target="_blank" title="<?php echo $DOPBSP->text('THEMES_THEME_VIEW_DEMO'); ?>" class="dopbsp-demo"><?php echo $DOPBSP->text('THEMES_THEME_VIEW_DEMO'); ?></a>
                                        </li>
<?php
                    }
                }
?>
                                    </ul>
                                </div>
<?php
            }
        }
    }