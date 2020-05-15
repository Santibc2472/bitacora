<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-amenities.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Amenities translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextAmenities')){
        class DOPBSPTranslationTextAmenities{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize amenities text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'amenities'));
            }

            /*
             * Amenities text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function amenities($text){
                array_push($text, array('key' => 'PARENT_AMENITIES',
                                        'parent' => '',
                                        'text' => 'Amenities'));
                
                array_push($text, array('key' => 'AMENITIES_TITLE',
                                        'parent' => 'PARENT_AMENITIES',
                                        'text' => 'Amenities',
                                        'de' => 'Annehmlichkeiten', // !
                                        'es' => 'Comodidades', // !
                                        'fr' => 'Commodités'));//!
                
                return $text;
            }
        }
    }