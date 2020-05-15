<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-addons.php
* File Version            : 1.0.4
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Addons translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextAddons')){
        class DOPBSPTranslationTextAddons{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize addons text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'addons'));
            }

            /*
             * Addons text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function addons($text){
                array_push($text, array('key' => 'PARENT_ADDONS',
                                        'parent' => '',
                                        'text' => 'Add-ons'));
                
                array_push($text, array('key' => 'ADDONS_TITLE',
                                        'parent' => 'PARENT_ADDONS',
                                        'text' => 'Add-ons',
                                        'de' => 'Add-ons',
                                        'es' => 'Complementos', // !
                                        'fr' => 'Add-ons'));
                array_push($text, array('key' => 'ADDONS_HELP',
                                        'parent' => 'PARENT_ADDONS',
                                        'text' => 'Increase and improve booking system functionalities with one of the following addons.',
                                        'de' => 'Erweitern und verbessern Sie die Funktionen des Buchungssystems mit einem der folgenden Erweiterungen.', // !
                                        'es' => 'Incremente y mejore las funcionalidades del sistema de reservas con uno de los siguientes complementos.', // !
                                        'fr' => 'Augmentez et améliorez les fonctionnalités du système de réservation avec l<<single-quote>>un des addons suivants.'));//!
                
                array_push($text, array('key' => 'ADDONS_LOAD_SUCCESS',
                                        'parent' => 'PARENT_ADDONS',
                                        'text' => 'Add-ons list loaded.',
                                        'de' => 'Add-ons-Liste geladen.', // !
                                        'es' => 'La lista de complementos cargó.', // !
                                        'fr' => 'Liste d<<single-quote>>add-ons chargée.'));//!
                array_push($text, array('key' => 'ADDONS_LOAD_ERROR',
                                        'parent' => 'PARENT_ADDONS',
                                        'text' => 'Add-ons list failed to load. Please refresh the page to try again.',
                                        'de' => 'Liste der Add-Ons konnte nicht geladen werden. Aktualisieren Sie die Seite, um es erneut zu versuchen.', // !
                                        'es' => 'Lista de complementos no pudo cargar. Por favor, actualice la página para intentarlo de nuevo.', // !
                                        'fr' => 'La liste des add-ons n<<single-quote>>a pas été chargée. Veuillez rafraîchir la page pour réessayer.'));//!
                
                array_push($text, array('key' => 'ADDONS_FILTERS_SEARCH',
                                        'parent' => 'PARENT_ADDONS',
                                        'text' => 'Search',
                                        'de' => 'Suche', // !
                                        'es' => 'Busca', // !
                                        'fr' => 'Recherche'));
                array_push($text, array('key' => 'ADDONS_FILTERS_SEARCH_TERMS',
                                        'parent' => 'PARENT_ADDONS',
                                        'text' => 'Enter search terms',
                                        'de' => 'Geben Sie Suchbegriffe', // !
                                        'es' => 'Entre en términos de búsqueda', // !
                                        'fr' => 'Entrez les termes de recherche'));//!
                array_push($text, array('key' => 'ADDONS_FILTERS_CATEGORIES',
                                        'parent' => 'PARENT_ADDONS',
                                        'text' => 'Categories',
                                        'de' => 'Kategorien', // !
                                        'es' => 'Categorías', // !
                                        'fr' => 'Catégories'));
                array_push($text, array('key' => 'ADDONS_FILTERS_CATEGORIES_ALL',
                                        'parent' => 'PARENT_ADDONS',
                                        'text' => 'All',
                                        'de' => 'Alle', // !
                                        'es' => 'Todo', // !
                                        'fr' => 'Toutes'));
                
                array_push($text, array('key' => 'ADDONS_ADDON_PRICE',
                                        'parent' => 'PARENT_ADDONS',
                                        'text' => 'Price:',
                                        'de' => 'Preis', // 
                                        'es' => 'Precio', // !
                                        'fr' => 'Prix:'));
                array_push($text, array('key' => 'ADDONS_ADDON_GET_IT_NOW',
                                        'parent' => 'PARENT_ADDONS',
                                        'text' => 'Get it now',
                                        'de' => 'Es jetzt nehmen', // !
                                        'es' => 'Conseguir ahora', // !
                                        'fr' => 'Obtenez-le maintenant'));//!
                
                return $text;
            }
        }
    }