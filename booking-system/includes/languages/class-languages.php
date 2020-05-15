<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/languages/class-languages.php
* File Version            : 1.0.1
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Languages PHP class.
*/

    if (!class_exists('DOPBSPLanguages')){
        class DOPBSPLanguages{
            /*
             * Languages list.
             */
            public $languages = array();
            
            /*
             * Constructor
             */
            function __construct(){
                add_filter('dopbsp_filter_languages', array(&$this, 'set'));
                add_action('init', array(&$this, 'init'));
            }
            
            /*
             * Initialize languages.
             */
            function init(){
                $this->languages = apply_filters('dopbsp_filter_languages', $this->languages);
            }
            
            /*
             * Get language name.
             * 
             * @param code (string): language code
             * @param field (string): data field
             * 
             * @return field value or an error message
             */
            function get($code,
                         $field = 'name'){
                for ($i=0; $i<count($this->languages); $i++){
                    if ($this->languages[$i]['code'] == $code){
                        return $this->languages[$i][$field];
                    }
                }
                
                return 'Invalid language code: '.$code;
            }
            
            /*
             * Set languages.
             * 
             * @param languages (array): initial languages list 
             * 
             * @return languages array
             */
            function set($languages){
                array_push($languages, array('code' => 'af',
                                             'name' => 'Afrikaans (Afrikaans)'));
                array_push($languages, array('code' => 'sq',
                                             'name' => 'Albanian (Shqiptar)'));
                array_push($languages, array('code' => 'ar',
                                             'name' => 'Arabic (>العربية)'));
                array_push($languages, array('code' => 'az',
                                             'name' => 'Azerbaijani (Azərbaycan)'));
                array_push($languages, array('code' => 'eu',
                                             'name' => 'Basque (Euskal)'));
                array_push($languages, array('code' => 'be',
                                             'name' => 'Belarusian (Беларускай)'));
                array_push($languages, array('code' => 'bg',
                                             'name' => 'Bulgarian (Български)'));
                array_push($languages, array('code' => 'ca',
                                             'name' => 'Catalan (Català)'));
                array_push($languages, array('code' => 'zh',
                                             'name' => 'Chinese (中国的)'));
                array_push($languages, array('code' => 'hr',
                                             'name' => 'Croatian (Hrvatski)'));
                array_push($languages, array('code' => 'cs',
                                             'name' => 'Czech (Český)'));
                array_push($languages, array('code' => 'da',
                                             'name' => 'Danish (Dansk)'));
                array_push($languages, array('code' => 'nl',
                                             'name' => 'Dutch (Nederlands)'));
                array_push($languages, array('code' => 'en',
                                             'name' => 'English'));
                array_push($languages, array('code' => 'eo',
                                             'name' => 'Esperanto (Esperanto)'));
                array_push($languages, array('code' => 'et',
                                             'name' => 'Estonian (Eesti)'));
                array_push($languages, array('code' => 'fl',
                                             'name' => 'Filipino (na Filipino)'));
                array_push($languages, array('code' => 'fi',
                                             'name' => 'Finnish (Suomi)'));
                array_push($languages, array('code' => 'fr',
                                             'name' => 'French (Français)'));
                array_push($languages, array('code' => 'gl',
                                             'name' => 'Galician (Galego)'));
                array_push($languages, array('code' => 'de',
                                             'name' => 'German (Deutsch)'));
                array_push($languages, array('code' => 'el',
                                             'name' => 'Greek (Ɛλληνικά)'));
                array_push($languages, array('code' => 'ht',
                                             'name' => 'Haitian Creole (Kreyòl Ayisyen)'));
                array_push($languages, array('code' => 'he',
                                             'name' => 'Hebrew (עברית)'));
                array_push($languages, array('code' => 'hi',
                                             'name' => 'Hindi (हिंदी)'));
                array_push($languages, array('code' => 'hu',
                                             'name' => 'Hungarian (Magyar)'));
                array_push($languages, array('code' => 'is',
                                             'name' => 'Icelandic (Íslenska)'));
                array_push($languages, array('code' => 'id',
                                             'name' => 'Indonesian (Indonesia)'));
                array_push($languages, array('code' => 'ga',
                                             'name' => 'Irish (Gaeilge)'));
                array_push($languages, array('code' => 'it',
                                             'name' => 'Italian (Italiano)'));
                array_push($languages, array('code' => 'ja',
                                             'name' => 'Japanese (日本の)'));
                array_push($languages, array('code' => 'ko',
                                             'name' => 'Korean (한국의)'));
                array_push($languages, array('code' => 'lv',
                                             'name' => 'Latvian (Latvijas)'));
                array_push($languages, array('code' => 'lt',
                                             'name' => 'Lithuanian (Lietuvos)'));
                array_push($languages, array('code' => 'mk',
                                             'name' => 'Macedonian (македонски)'));
                array_push($languages, array('code' => 'ms',
                                             'name' => 'Malay (Melayu)'));
                array_push($languages, array('code' => 'mt',
                                             'name' => 'Maltese (Maltija)'));
                array_push($languages, array('code' => 'no',
                                             'name' => 'Norwegian (Norske)'));
                array_push($languages, array('code' => 'fa',
                                             'name' => 'Persian (فارسی)'));
                array_push($languages, array('code' => 'pl',
                                             'name' => 'Polish (Polski)'));
                array_push($languages, array('code' => 'pt',
                                             'name' => 'Portuguese (Português)'));
                array_push($languages, array('code' => 'ro',
                                             'name' => 'Romanian (Română)'));
                array_push($languages, array('code' => 'ru',
                                             'name' => 'Russian (Pусский)'));
                array_push($languages, array('code' => 'sr',
                                             'name' => 'Serbian (Cрпски)'));
                array_push($languages, array('code' => 'sk',
                                             'name' => 'Slovak (Slovenských)'));
                array_push($languages, array('code' => 'sl',
                                             'name' => 'Slovenian (Slovenski)'));
                array_push($languages, array('code' => 'es',
                                             'name' => 'Spanish (Español)'));
                array_push($languages, array('code' => 'sw',
                                             'name' => 'Swahili (Kiswahili)'));
                array_push($languages, array('code' => 'sv',
                                             'name' => 'Swedish (Svenskt)'));
                array_push($languages, array('code' => 'th',
                                             'name' => 'Thai (ภาษาไทย)'));
                array_push($languages, array('code' => 'tr',
                                             'name' => 'Turkish (Türk)'));
                array_push($languages, array('code' => 'uk',
                                             'name' => 'Ukrainian (Український)'));
                array_push($languages, array('code' => 'ur',
                                             'name' => 'Urdu (اردو)'));
                array_push($languages, array('code' => 'vi',
                                             'name' => 'Vietnamese (Việt)'));
                array_push($languages, array('code' => 'cy',
                                             'name' => 'Welsh (Cymraeg)'));
                array_push($languages, array('code' => 'yi',
                                             'name' => 'Yiddish (ייִדיש)'));
                
                return $languages;
            }
        }
    }