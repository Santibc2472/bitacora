<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.3
* File                    : includes/translation/class-translation-text-custom-posts.php
* File Version            : 1.0.4
* Created / Last Modified : 17 December 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Custom posts translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextCustomPosts')){
        class DOPBSPTranslationTextCustomPosts{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize custom posts text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'customPosts'));
            }
            
            /*
             * Custom posts text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function customPosts($text){
                array_push($text, array('key' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'parent' => '',
                                        'text' => 'Custom posts'));
                
                array_push($text, array('key' => 'CUSTOM_POSTS_BOOKING_SYSTEM',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'Pinpoint Booking System',
                                        'de' => 'Pinpoint Buchungssystem', // !
                                        'es' => 'Sistema de Reservas Pinpoint', // !
                                        'fr' => 'Pinpoint Booking System'));
                
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_NAME',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'Pinpoint posts',
                                        'de' => 'Pinpoint Beiträge',// !
                                        'es' => 'Pinpoint postes', // !
                                        'fr' => 'Postes de Pinpoint'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_SINGULAR_NAME',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'Pinpoint post',
                                        'de' => 'Pinpoint Beitrag',// !
                                        'es' => 'Pinpoint poste', // !
                                        'fr' => 'Postes de Pinpoint'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_MENU_NAME',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'Pinpoint posts',
                                        'de' => 'Pinpoint beiträge',// !
                                        'es' => 'Pinpoint postes', // !
                                        'fr' => 'Postes de Pinpoint'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_NAME_ADMIN_BAR',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'Add post',
                                        'de' => 'Beitrag hinzufügen',// !
                                        'es' => 'Añada poste', // !
                                        'fr' => 'Ajoutez un poste'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_ALL_ITEMS',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'Pinpoint posts',
                                        'de' => 'Pinpoint Beiträge',// !
                                        'es' => 'Pinpoint postes', // !
                                        'fr' => 'Postes de Pinpoint'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_ADD_NEW',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'Add post',
                                        'de' => 'Beitrag hinzufügen',// !
                                        'es' => 'Añada poste', // !
                                        'fr' => 'Ajoutez un poste'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_ADD_NEW_ITEM',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'Add post',
                                        'de' => 'Beitrag hinzufügen',// !
                                        'es' => 'Añada poste', // !
                                        'fr' => 'Ajoutez un poste'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_EDIT_ITEM',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'Edit post',
                                        'de' => 'Beitrag bearbeiten',// !
                                        'es' => 'Poste de revisión', // !
                                        'fr' => 'Éditez le poste'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_NEW_ITEM',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'New post',
                                        'de' => 'Neuen Beitrag',// !
                                        'es' => 'Nuevo poste', // !
                                        'fr' => 'Nouveau post'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_VIEW_ITEM',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'View post',
                                        'de' => 'Beitrag anzeigen',// !
                                        'es' => 'Ver el poste', // !
                                        'fr' => 'Afficher le post'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_SEARCH_ITEMS',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'Search posts',
                                        'de' => 'Suche nach Beiträgen',// !
                                        'es' => 'Postes de búsqueda', // !
                                        'fr' => 'Recherchez dans les postes'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_NOT_FOUND',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'No post(s) found.',
                                        'de' => 'Keine Beiträge gefunden.',// !
                                        'es' => 'Ningún poste(s) encontrado.', // !
                                        'fr' => 'Aucun poste(s) trouvé.'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_NOT_FOUND_IN_TRASH',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'No post(s) found in trash.',
                                        'de' => 'Keine Beiträge im Papierkorb gefunden.',// !
                                        'es' => 'Ningún poste(s) encontrado en la basura.', // !
                                        'fr' => 'Aucun poste(s) trouvé(s) dans la poubelle.'));//!
                array_push($text, array('key' => 'CUSTOM_POSTS_DEFAULT_PARENT_ITEM_COLON',
                                        'parent' => 'PARENT_CUSTOM_POSTS_DEFAULT',
                                        'text' => 'Parent post',
                                        'de' => 'Übergeordneter Beitrag', // !
                                        'es' => 'Poste padre', // !
                                        'fr' => 'Poste parental'));//!
                
                return $text;
            }
        }
    }