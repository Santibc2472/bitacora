<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-themes.php
* File Version            : 1.0.4
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Themes translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextThemes')){
        class DOPBSPTranslationTextThemes{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize themes text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'themes'));
            }

            /*
             * Themes text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function themes($text){
                array_push($text, array('key' => 'PARENT_THEMES',
                                        'parent' => '',
                                        'text' => 'Themes'));
                
                array_push($text, array('key' => 'THEMES_TITLE',
                                        'parent' => 'PARENT_THEMES',
                                        'text' => 'Themes',
                                        'de' => 'Themes', // !
                                        'es' => 'Temas', //!
                                        'fr' => 'Thèmes')); //!
                array_push($text, array('key' => 'THEMES_HELP',
                                        'parent' => 'PARENT_THEMES',
                                        'text' => 'A collection of themes specially created to be used with the Pinpoint Booking System. PRO version is included with each.',
                                        'de' => 'Eine Sammlung von Themen, die speziell für die Verwendung mit dem Pinpoint Buchungssystem erstellt wurden. Die Pro-Version ist jeweils im Lieferumfang enthalten.', // !
                                        'es' => 'Una colección de temas especialmente creados para ser utilizados con el sistema de reservas de punto. La versión PRO se incluye con cada uno.', //!
                                        'fr' => 'Une collection de thèmes spécialement créés pour être utilisés avec le système de réservation Pinpoint. La version PRO est incluse avec chacun.')); //!
                
                array_push($text, array('key' => 'THEMES_LOAD_SUCCESS',
                                        'parent' => 'PARENT_THEMES',
                                        'text' => 'Themes list loaded.',
                                        'de' => 'Themenliste geladen.', // !
                                        'es' => 'La lista de temas cargó.', //!
                                        'fr' => 'La liste de thèmes a chargé.')); //!
                array_push($text, array('key' => 'THEMES_LOAD_ERROR',
                                        'parent' => 'PARENT_THEMES',
                                        'text' => 'Themes list failed to load. Please refresh the page to try again.',
                                        'de' => 'Die Themenliste konnte nicht geladen werden. Aktualisieren Sie die Seite, um es erneut zu versuchen.', // !
                                        'es' => 'La lista de temas no se pudo cargar. Por favor, actualice la página para intentarlo de nuevo.', //!
                                        'fr' => 'La liste des thèmes n<<single-quote>>a pas pu se charger. Veuillez rafraîchir la page pour réessayer.')); //!
                
                array_push($text, array('key' => 'THEMES_FILTERS_SEARCH',
                                        'parent' => 'PARENT_THEMES',
                                        'text' => 'Search',
                                        'de' => 'Suche', // !
                                        'es' => 'Búsqueda', //!
                                        'fr' => 'Recherche')); //!
                array_push($text, array('key' => 'THEMES_FILTERS_SEARCH_TERMS',
                                        'parent' => 'PARENT_THEMES',
                                        'text' => 'Enter search terms',
                                        'de' => 'Geben Sie Suchbegriffe', // !
                                        'es' => 'Entre en términos de búsqueda', //!
                                        'fr' => 'Entrez dans des termes de recherche')); //!
                array_push($text, array('key' => 'THEMES_FILTERS_TAGS',
                                        'parent' => 'PARENT_THEMES',
                                        'text' => 'Tags',
                                        'de' => 'Tags', // !
                                        'es' => 'Etiquetas', //!
                                        'fr' => 'Mots-clés')); //!
                array_push($text, array('key' => 'THEMES_FILTERS_TAGS_ALL',
                                        'parent' => 'PARENT_THEMES',
                                        'text' => 'All',
                                        'de' => 'Alle', // !
                                        'es' => 'Todo', //!
                                        'fr' => 'Tout')); //!
                
                array_push($text, array('key' => 'THEMES_THEME_PRICE',
                                        'parent' => 'PARENT_THEMES',
                                        'text' => 'Price:',
                                        'de' => 'Preis:', // !
                                        'es' => 'Precio', //!
                                        'fr' => 'Prix:')); //!
                array_push($text, array('key' => 'THEMES_THEME_GET_IT_NOW',
                                        'parent' => 'PARENT_THEMES',
                                        'text' => 'Get it now',
                                        'de' => 'Es jetzt nehmen', // !
                                        'es' => 'Consígalo ahora', //!
                                        'fr' => 'Obtenez-le maintenant')); //!
                array_push($text, array('key' => 'THEMES_THEME_VIEW_DEMO',
                                        'parent' => 'PARENT_THEMES',
                                        'text' => 'View demo',
                                        'de' => 'Demo ansehen', // !
                                        'es' => 'Ver demo', //!
                                        'fr' => 'Voir la démo')); //!
                
                return $text;
            }
        }
    }