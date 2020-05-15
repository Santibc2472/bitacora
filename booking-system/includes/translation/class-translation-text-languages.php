<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-languages.php
* File Version            : 1.0.2
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Languages translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextLanguages')){
        class DOPBSPTranslationTextLanguages{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize languages text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'languages'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'languagesHelp'));
            }
            
            /*
             * Languages text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function languages($text){
                array_push($text, array('key' => 'PARENT_LANGUAGES',
                                        'parent' => '',
                                        'text' => 'Languages'));
                
                array_push($text, array('key' => 'LANGUAGES_MANAGE',
                                        'parent' => 'PARENT_LANGUAGES',
                                        'text' => 'Manage languages',
                                        'de' => 'Sprachen verwalten', // !
                                        'es' => 'Administrar idiomas', // !
                                        'fr' => 'Gérez des langues')); //!
                array_push($text, array('key' => 'LANGUAGES_LOADED',
                                        'parent' => 'PARENT_LANGUAGES',
                                        'text' => 'Languages have been loaded.',
                                        'de' => 'Sprachen wurden geladen.', // !
                                        'es' => 'Los idiomas han sido cargados.', // !
                                        'fr' => 'Les langues ont été chargées.')); //!
                array_push($text, array('key' => 'LANGUAGES_SETTING',
                                        'parent' => 'PARENT_LANGUAGES',
                                        'text' => 'The language is being configured ...',
                                        'de' => 'Die Sprache wird konfiguriert ...', // !
                                        'es' => 'La idioma está siendo configurado ...', // !
                                        'fr' => 'La langue est en cours de configuration ...')); //!
                array_push($text, array('key' => 'LANGUAGES_SET_SUCCESS',
                                        'parent' => 'PARENT_LANGUAGES',
                                        'text' => 'The language has been added. The page will refresh shortly.',
                                        'de' => 'Die Sprache wurde hinzugefügt. Die Seite wird in Kürze aktualisiert.', // !
                                        'es' => 'Se ha añadido el idioma. La página se actualizará en breve.', // !
                                        'fr' => 'La langue a été ajouté. La page sera mise à jour sous peu.')); //!
                array_push($text, array('key' => 'LANGUAGES_REMOVE_CONFIGURATION',
                                        'parent' => 'PARENT_LANGUAGES',
                                        'text' => 'Are you sure you want to remove this language? Data will be deleted only when you reset the translation!',
                                        'de' => 'Möchten Sie diese Sprache wirklich entfernen? Daten werden nur gelöscht, wenn Sie die Übersetzung zurücksetzen!', // !
                                        'es' => '¿Está seguro de que desea eliminar este idioma? ¡Los datos se eliminarán sólo cuando reinicie la traducción!', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer cette langue? Les données seront supprimées seulement lorsque vous réinitialisez la traduction!')); //!
                array_push($text, array('key' => 'LANGUAGES_REMOVING',
                                        'parent' => 'PARENT_LANGUAGES',
                                        'text' => 'The language is being removed ...',
                                        'de' => 'Die Sprache wird entfernt ...', // !
                                        'es' => 'El lenguaje está siendo eliminado ...', // !
                                        'fr' => 'La langue est supprimé...')); //!
                array_push($text, array('key' => 'LANGUAGES_REMOVE_SUCCESS',
                                        'parent' => 'PARENT_LANGUAGES',
                                        'text' => 'The language has been removed. The page will refresh shortly.',
                                        'de' => 'Die Sprache wurde entfernt. Die Seite wird in Kürze aktualisiert.', // !
                                        'es' => 'El idioma ha sido eliminado. La página se actualizará en breve.', // !
                                        'fr' => 'La langue a été supprimé. La page sera mise à jour sous peu.')); //!
                
                return $text;
            }            
            
            /*
             * Languages - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function languagesHelp($text){
                array_push($text, array('key' => 'PARENT_LANGUAGES_HELP',
                                        'parent' => '',
                                        'text' => 'Languages - Help'));
                
                array_push($text, array('key' => 'LANGUAGES_HELP',
                                        'parent' => 'PARENT_LANGUAGES_HELP',
                                        'text' => 'If you need to use more language with the plugin go to "Manage languages" section and enable them.',
                                        'de' => 'Wenn Sie mehr Sprache mit dem Plugin verwenden möchten, gehen Sie zum Abschnitt "Sprachen verwalten" und aktivieren Sie sie.', // !
                                        'es' => 'Si necesita utilizar más lenguaje con el plugin vaya a la sección "Administrar idiomas" y habilitarlos.', // !
                                        'fr' => 'Si vous avez besoin d<<single-quote>>utiliser plus de langue avec le plugin aller à la section "Gérer les langues" et les activer.')); //!
                
                return $text;
            }
        }
    }