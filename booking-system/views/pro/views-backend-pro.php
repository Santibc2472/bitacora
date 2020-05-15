<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : views/pro/views-backend-pro.php
* File Version            : 1.0.4
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end pro views class.
*/

    if (!class_exists('DOPBSPViewsBackEndPRO')){
        class DOPBSPViewsBackEndPRO extends DOPBSPViewsBackEnd{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns pro template.
             * 
             * @param args (array): function arguments
             * 
             * @return pro HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!-- 
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE'), $DOPBSP->text('WORDPRESS_BOOKING_FEATURES_MAIN_TITLE')); ?>

<!--
    Content
-->
        <div class="dopbsp-main dopbsp-hidden">
<?php
                /*
                 * PRO features template.
                 */
                $DOPBSP->views->backend_pro_features->template();
?>
        </div>
    </div>       
<?php
            }
        }
    }