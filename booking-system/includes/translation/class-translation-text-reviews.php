<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-reviews.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Reviews translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextReviews')){
        class DOPBSPTranslationTextReviews{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize reviews text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'reviews'));
            }

            /*
             * Reviews text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function reviews($text){
                array_push($text, array('key' => 'PARENT_REVIEWS',
                                        'parent' => '',
                                        'text' => 'Reviews'));
                
                array_push($text, array('key' => 'REVIEWS_TITLE',
                                        'parent' => 'PARENT_REVIEWS',
                                        'text' => 'Reviews',
                                        'de' => 'Bewertungen', // !
                                        'es' => 'Revisiones', // !
                                        'fr' => 'Examens')); //!
                
                return $text;
            }
        }
    }