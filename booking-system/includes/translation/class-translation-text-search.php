<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/translation/class-translation-text-search.php
* File Version            : 1.1.2
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Search translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextSearch')){
        class DOPBSPTranslationTextSearch{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize search text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'searches'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'searchesSearch'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'searchesAddSearch'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'searchesEditSearch'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'searchesDeleteSearch'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'searchesHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'searchesFrontEnd'));
            }

            /*
             * Search text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function searches($text){
                array_push($text, array('key' => 'PARENT_SEARCHES',
                                        'parent' => '',
                                        'text' => 'Search'));
                
                array_push($text, array('key' => 'SEARCHES_TITLE',
                                        'parent' => 'PARENT_SEARCHES',
                                        'text' => 'Search',
                                        'de' => 'Suche', // !
                                        'es' => 'Búsqueda', // !
                                        'fr' => 'Recherche')); //!
                
                array_push($text, array('key' => 'SEARCHES_CREATED_BY',
                                        'parent' => 'PARENT_SEARCHES',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von', // !
                                        'es' => 'Creada por', // !
                                        'fr' => 'Créé par')); //!
                array_push($text, array('key' => 'SEARCHES_LOAD_SUCCESS',
                                        'parent' => 'PARENT_SEARCHES',
                                        'text' => 'Search list loaded.',
                                        'de' => 'Suchliste geladen.', // !
                                        'es' => 'La lista de búsqueda cargó.', // !
                                        'fr' => 'La liste de recherche a chargé.')); //!
                array_push($text, array('key' => 'SEARCHES_NO_SEARCHES',
                                        'parent' => 'PARENT_SEARCHES',
                                        'text' => 'No searches. Click the above "plus" icon to add a new one.',
                                        'de' => 'Keine Suche. Klicken Sie auf das obige "Plus"-Symbol, um ein neues hinzuzufügen.', // !
                                        'es' => 'No hay búsquedas. Haga clic en el icono "plus" de arriba para agregar uno nuevo.', // !
                                        'fr' => 'Aucune recherche. Cliquez sur l<<single-quote>>icône "plus" ci-dessus pour en ajouter une nouvelle.')); //!
                
                return $text;
            }
            
            /*
             * Search - Search text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function searchesSearch($text){
                array_push($text, array('key' => 'PARENT_SEARCHES_SEARCH',
                                        'parent' => '',
                                        'text' => 'Search'));
                
                array_push($text, array('key' => 'SEARCHES_SEARCH_NAME',
                                        'parent' => 'PARENT_SEARCHES_SEARCH',
                                        'text' => 'Name'));
                
                array_push($text, array('key' => 'SEARCHES_SEARCH_LOADED',
                                        'parent' => 'PARENT_SEARCHES_SEARCH',
                                        'text' => 'Search loaded.'));
                
                return $text;
            }
            
            /*
             * Search - Add search text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function searchesAddSearch($text){
                array_push($text, array('key' => 'PARENT_SEARCHES_ADD_SEARCH',
                                        'parent' => '',
                                        'text' => 'Search - Add search'));
                
                array_push($text, array('key' => 'SEARCHES_ADD_SEARCH_NAME',
                                        'parent' => 'PARENT_SEARCHES_ADD_SEARCH',
                                        'text' => 'New search'));
                
                array_push($text, array('key' => 'SEARCHES_ADD_SEARCH_SUBMIT',
                                        'parent' => 'PARENT_SEARCHES_ADD_SEARCH',
                                        'text' => 'Add search'));
                array_push($text, array('key' => 'SEARCHES_ADD_SEARCH_ADDING',
                                        'parent' => 'PARENT_SEARCHES_ADD_SEARCH',
                                        'text' => 'Adding a new search ...'));
                array_push($text, array('key' => 'SEARCHES_ADD_SEARCH_SUCCESS',
                                        'parent' => 'PARENT_SEARCHES_ADD_SEARCH',
                                        'text' => 'You have succesfully added a new search.'));
                
                return $text;
            }
            
            /*
             * Search - Edit search text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function searchesEditSearch($text){
                array_push($text, array('key' => 'PARENT_SEARCHES_EDIT_SEARCH',
                                        'parent' => '',
                                        'text' => 'Search - Edit search'));
                
                array_push($text, array('key' => 'SEARCHES_EDIT_SEARCH',
                                        'parent' => 'PARENT_SEARCHES_EDIT_SEARCH',
                                        'text' => 'Edit search details'));
                array_push($text, array('key' => 'SEARCHES_EDIT_SEARCH_SETTINGS',
                                        'parent' => 'PARENT_SEARCHES_EDIT_SEARCH',
                                        'text' => 'Edit search settings'));
                
                array_push($text, array('key' => 'SEARCHES_EDIT_SEARCH_EXCLUDED_CALENDARS_DAYS',
                                        'parent' => 'PARENT_SEARCHES_EDIT_SEARCH',
                                        'text' => 'Exclude calendars from search [hours filters disabled]'));
                array_push($text, array('key' => 'SEARCHES_EDIT_SEARCH_EXCLUDED_CALENDARS_HOURS',
                                        'parent' => 'PARENT_SEARCHES_EDIT_SEARCH',
                                        'text' => 'Exclude calendars from search [hours filters enabled]'));
                
                array_push($text, array('key' => 'SEARCHES_EDIT_SEARCH_NO_CALENDARS',
                                        'parent' => 'PARENT_SEARCHES_EDIT_SEARCH',
                                        'text' => 'There are no calendars created. Go to <a href="%s">calendars</a> page to create one.'));
                
                return $text;
            }
            
            /*
             * Search - Delete search text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function searchesDeleteSearch($text){
                array_push($text, array('key' => 'PARENT_SEARCHES_DELETE_SEARCH',
                                        'parent' => '',
                                        'text' => 'Search - Delete search'));
                
                array_push($text, array('key' => 'SEARCHES_DELETE_SEARCH_CONFIRMATION',
                                        'parent' => 'PARENT_SEARCHES_DELETE_SEARCH',
                                        'text' => 'Are you sure you want to delete this search?'));
                array_push($text, array('key' => 'SEARCHES_DELETE_SEARCH_SUBMIT',
                                        'parent' => 'PARENT_SEARCHES_DELETE_SEARCH',
                                        'text' => 'Delete search'));
                array_push($text, array('key' => 'SEARCHES_DELETE_SEARCH_DELETING',
                                        'parent' => 'PARENT_SEARCHES_DELETE_SEARCH',
                                        'text' => 'Deleting search ...'));
                array_push($text, array('key' => 'SEARCHES_DELETE_SEARCH_SUCCESS',
                                        'parent' => 'PARENT_SEARCHES_DELETE_SEARCH',
                                        'text' => 'You have succesfully deleted the search.'));
                
                return $text;
            }
            
            /*
             * Search - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function searchesHelp($text){
                array_push($text, array('key' => 'PARENT_SEARCHES_HELP',
                                        'parent' => '',
                                        'text' => 'Search - Help'));
                
                array_push($text, array('key' => 'SEARCHES_HELP',
                                        'parent' => 'PARENT_SEARCHES_HELP',
                                        'text' => 'Click on a search item to open the editing area.'));
                array_push($text, array('key' => 'SEARCHES_ADD_SEARCH_HELP',
                                        'parent' => 'PARENT_SEARCHES_HELP',
                                        'text' => 'Click on the "plus" icon to add a search.'));
                
                array_push($text, array('key' => 'SEARCHES_EDIT_SEARCH_HELP',
                                        'parent' => 'PARENT_SEARCHES_HELP',
                                        'text' => 'Click on the "search" icon to edit search details.'));
                array_push($text, array('key' => 'SEARCHES_EDIT_SEARCH_SETTINGS_HELP',
                                        'parent' => 'PARENT_SEARCHES_HELP',
                                        'text' => 'Click on the "gear" icon to edit search settings.'));
                array_push($text, array('key' => 'SEARCHES_EDIT_SEARCH_DELETE_HELP',
                                        'parent' => 'PARENT_SEARCHES_HELP',
                                        'text' => 'Click the "trash" icon to delete the search.'));
                array_push($text, array('key' => 'SEARCHES_EDIT_SEARCH_EXCLUDED_CALENDARS_HELP',
                                        'parent' => 'PARENT_SEARCHES_HELP',
                                        'text' => 'If hours filters are enabled only calendars that have availability set for hours are included in search, else only calendar that have availability set for days are included.'));
                
                array_push($text, array('key' => 'SEARCHES_SEARCH_NAME_HELP',
                                        'parent' => 'PARENT_SEARCHES_HELP',
                                        'text' => 'Change search name.'));
                
                return $text;
            }
            
            /*
             * Search front end text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function searchesFrontEnd($text){
                array_push($text, array('key' => 'PARENT_SEARCH_FRONT_END',
                                        'parent' => '',
                                        'text' => 'Search - Front end'));
                     
                array_push($text, array('key' => 'SEARCH_FRONT_END_TITLE',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Search',
                                        'location' => 'all'));
                     
                array_push($text, array('key' => 'SEARCH_FRONT_END_CHECK_IN',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Check in',
                                        'de' => 'Anreise',
                                        'nl' => 'Check in',
                                        'fr' => 'Arrivée',
                                        'pl' => 'Przyjazd',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_CHECK_OUT',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Check out',
                                        'de' => 'Abreise',
                                        'nl' => 'Check uit',
                                        'fr' => 'Départ',
                                        'pl' => 'Wyjazd',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_START_HOUR',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Start at',
                                        'de' => 'Start um',
                                        'nl' => 'Start op',
                                        'fr' => 'Arrivée à',
                                        'pl' => 'Rozpoczęcie',
                                        'location' => 'all')); 
                array_push($text, array('key' => 'SEARCH_FRONT_END_END_HOUR',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Finish at',
                                        'de' => 'Ende um',
                                        'nl' => 'Eindigd op',
                                        'fr' => 'Départ à',
                                        'pl' => 'Zakończenie',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_NO_ITEMS',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'No book items',
                                        'de' => 'No book items',
                                        'nl' => '# Accomodaties',
                                        'fr' => 'Aucun élément de réservation',
                                        'pl' => 'Brak rezerwacji',
                                        'location' => 'all'));
                /*
                 * No data.
                 */
                array_push($text, array('key' => 'SEARCH_FRONT_END_NO_AVAILABILITY',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Nothing available.',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_NO_SERVICES_AVAILABLE',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'There are no services available for the period you selected.',
                                        'de' => 'There are no services available for the period you selected.',
                                        'nl' => 'Er zijn geen er zijn geen diensten beschikbaar voor de periode die u hebt geselecteerd.',
                                        'fr' => 'Il n<<single-quote>>y a pas de services disponibles pour la période que vous avez sélectionné.',
                                        'pl' => 'W wybranych terminie nie posiadamy wolnych miejsc.',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_NO_SERVICES_AVAILABLE_SPLIT_GROUP',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'You cannot add divided groups to a reservation.',
                                        'location' => 'all'));
                /*
                 * Sort
                 */
                array_push($text, array('key' => 'SEARCH_FRONT_END_SORT_TITLE',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Sort by',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_SORT_NAME',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Name',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_SORT_PRICE',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Price',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_SORT_ASC',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Ascending',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_SORT_DESC',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Descending',
                                        'location' => 'all'));
                /*
                 * View
                 */
                array_push($text, array('key' => 'SEARCH_FRONT_END_VIEW_GRID',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Grid view',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_VIEW_LIST',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'List view',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_VIEW_MAP',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Map view',
                                        'location' => 'all'));
                /*
                 * Results
                 */
                array_push($text, array('key' => 'SEARCH_FRONT_END_RESULTS_PRICE',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'Start at %s',
                                        'location' => 'all'));
                array_push($text, array('key' => 'SEARCH_FRONT_END_RESULTS_VIEW',
                                        'parent' => 'PARENT_SEARCH_FRONT_END',
                                        'text' => 'View',
                                        'location' => 'all'));
                
                return $text;
            }
        }
    }