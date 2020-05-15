<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-templates.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Templates translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextTemplates')){
        class DOPBSPTranslationTextTemplates{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize templates text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'templates'));
            }

            /*
             * Templates text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function templates($text){
                array_push($text, array('key' => 'PARENT_TEMPLATES',
                                        'parent' => '',
                                        'text' => 'Templates'));
                
                array_push($text, array('key' => 'TEMPLATES_TITLE',
                                        'parent' => 'PARENT_TEMPLATES',
                                        'text' => 'Templates',
                                        'de' => 'Vorlagen', // !
                                        'es' => 'Modelos', //!
                                        'fr' => 'Modèles')); //!
                
                return $text;
            }
        }
    }