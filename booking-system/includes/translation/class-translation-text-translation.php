<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-translation.php
* File Version            : 1.0.4
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Translation translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextTranslation')){
        class DOPBSPTranslationTextTranslation{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize translation text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'translation'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'translationHelp'));
            }
            
            /*
             * Translation text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function translation($text){
                array_push($text, array('key' => 'PARENT_TRANSLATION',
                                        'parent' => '',
                                        'text' => 'Translation'));
                
                array_push($text, array('key' => 'TRANSLATION_TITLE',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Translation',
                                        'de' => 'Übersetzung', // !
                                        'es' => 'Traducción', //!
                                        'fr' => 'Traduction')); //!
                array_push($text, array('key' => 'TRANSLATION_SUBMIT',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Manage translation',
                                        'de' => 'Übersetzung verwalten', // !
                                        'es' => 'Maneje traducción', //!
                                        'fr' => 'Gérez la traduction')); //!
                array_push($text, array('key' => 'TRANSLATION_LOADED',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Translation has been loaded.',
                                        'de' => 'Übersetzung wurde geladen.', // !
                                        'es' => 'La traducción ha sido cargada.', //!
                                        'fr' => 'La traduction a été chargée.')); //!
                array_push($text, array('key' => 'TRANSLATION_LANGUAGE',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Select language',
                                        'de' => 'Sprache wählen', // !
                                        'es' => 'Lengua escogida', //!
                                        'fr' => 'Langue de sélection')); //!
                array_push($text, array('key' => 'TRANSLATION_TEXT_GROUP',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Select text group',
                                        'de' => 'Textgruppe auswählen', // !
                                        'es' => 'Seleccione el grupo de texto', //!
                                        'fr' => 'Choisissez le groupe de texte')); //!
                array_push($text, array('key' => 'TRANSLATION_TEXT_GROUP_ALL',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'All',
                                        'de' => 'Alle', // !
                                        'es' => 'Todo', //!
                                        'fr' => 'Tout')); //!
                array_push($text, array('key' => 'TRANSLATION_SEARCH',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Search',
                                        'de' => 'Suche', // !
                                        'es' => 'Búsqueda', //!
                                        'fr' => 'Recherche')); //!
                
                array_push($text, array('key' => 'TRANSLATION_RESET',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Reset translation',
                                        'de' => 'Übersetzung zurücksetzen', // !
                                        'es' => 'Reinicializar Traducción', //!
                                        'fr' => 'Traduction remise')); //!
                array_push($text, array('key' => 'TRANSLATION_RESET_CONFIRMATION',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Are you sure you want to reset all translation data? All your modifications are going to be overwritten.',
                                        'de' => 'Möchten Sie wirklich alle Übersetzungsdaten zurücksetzen? Alle Änderungen werden überschrieben.', // !
                                        'es' => '¿Está seguro de que desea restablecer todos los datos de traducción? Todas sus modificaciones van a ser sobreescritas.', //!
                                        'fr' => 'Êtes-vous sûr de vouloir réinitialiser toutes les données de traduction? Toutes vos modifications vont être écrasées.')); //!
                array_push($text, array('key' => 'TRANSLATION_RESETING',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Translation is resetting ...',
                                        'de' => 'Übersetzung wird zurückgesetzt ...', // !
                                        'es' => 'La traducción reinicializa...', //!
                                        'fr' => 'La traduction remet ...')); //!
                array_push($text, array('key' => 'TRANSLATION_RESET_SUCCESS',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'The translation has reset. The page will refresh shortly.',
                                        'de' => 'Die Übersetzung wurde zurückgesetzt. Die Seite wird in Kürze aktualisiert.', // !
                                        'es' => 'La traducción se ha reiniciado. La página se actualizará en breve.', //!
                                        'fr' => 'La traduction a été réinitialisée. La page sera mise à jour sous peu.')); //!
                
                return $text;
            }            
            
            /*
             * Translation - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function translationHelp($text){
                array_push($text, array('key' => 'PARENT_TRANSLATION_HELP',
                                        'parent' => '',
                                        'text' => 'Translation - Help'));
                
                array_push($text, array('key' => 'TRANSLATION_HELP',
                                        'parent' => 'PARENT_TRANSLATION_HELP',
                                        'text' => 'Select the language & text group you want to translate.',
                                        'de' => 'Wählen Sie die Sprache und Textgruppe aus, die Sie übersetzen möchten.', // !
                                        'es' => 'Seleccione el idioma y el grupo de texto que desea traducir.', //!
                                        'fr' => 'Sélectionnez la langue et le groupe de texte que vous souhaitez traduire.')); //!
                array_push($text, array('key' => 'TRANSLATION_SEARCH_HELP',
                                        'parent' => 'PARENT_TRANSLATION_HELP',
                                        'text' => 'Use the search field to look & display the text you want.',
                                        'de' => 'Verwenden Sie das Suchfeld, um den gewünschten Text anzuzeigen.', // !
                                        'es' => 'Utilice el campo de búsqueda para ver y mostrar el texto que desea.', //!
                                        'fr' => 'Utilisez le champ de recherche pour regarder et afficher le texte que vous voulez.')); //!
                array_push($text, array('key' => 'TRANSLATION_RESET_HELP',
                                        'parent' => 'PARENT_TRANSLATION_HELP',
                                        'text' => 'If you want to use the translation that came with the plugin click "Reset translation" button. Note that all your modifications will be overwritten.',
                                        'de' => 'Wenn Sie die mit dem Plugin gelieferte Übersetzung verwenden möchten, klicken Sie auf die Schaltfläche "Übersetzung zurücksetzen". Beachten Sie, dass alle Änderungen überschrieben werden.', // !
                                        'es' => 'Si desea utilizar la traducción que viene con el plugin haga clic en "Reiniciar la traducción" botón. Tenga en cuenta que todas sus modificaciones se sobrescribirán.', //!
                                        'fr' => 'Si vous voulez utiliser la traduction qui est venu avec le plugin, cliquez sur "Réinitialiser la traduction" bouton. Notez que toutes vos modifications seront écrasées.')); //!
                
                return $text;
            }
        }
    }