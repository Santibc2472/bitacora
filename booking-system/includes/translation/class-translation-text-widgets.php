<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-widgets.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Widgets translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextWidgets')){
        class DOPBSPTranslationTextWidgets{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize widgets text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'widget'));
            }
            
            /*
             * Widget text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function widget($text){
                array_push($text, array('key' => 'PARENT_WIDGET',
                                        'parent' => '',
                                        'text' => 'Widget'));
                
                array_push($text, array('key' => 'WIDGET_TITLE',
                                        'parent' => 'PARENT_WIDGET',
                                        'text' => 'Pinpoint Booking System',
                                        'de' => 'Pinpoint Buchungssystem', // !
                                        'es' => 'Sistema de Reservas Pinpoint', //!
                                        'fr' => 'Pinpoint Booking System')); //!
                array_push($text, array('key' => 'WIDGET_DESCRIPTION',
                                        'parent' => 'PARENT_WIDGET',
                                        'text' => 'Select option you want to appear in the widget and ID(s) of the calendar(s).',
                                        'de' => 'Wählen Sie die Option aus, die im Widget und in den IDs der Kalender angezeigt werden soll.', // !
                                        'es' => 'Seleccione la opción que desea que aparezca en el widget e ID(s) del calendario(s).', //!
                                        'fr' => 'Sélectionnez l<<single-quote>>option que vous voulez afficher dans le widget et ID(s) du calendrier(s).')); //!
                array_push($text, array('key' => 'WIDGET_TITLE_LABEL',
                                        'parent' => 'PARENT_WIDGET',
                                        'text' => 'Title:',
                                        'de' => 'Titel:', // !
                                        'es' => 'Título:', //!
                                        'fr' => 'Titre')); //!
                array_push($text, array('key' => 'WIDGET_SELECTION_LABEL',
                                        'parent' => 'PARENT_WIDGET',
                                        'text' => 'Select action:',
                                        'de' => 'Aktion auswählen:', // !
                                        'es' => 'Acción escogida:', //!
                                        'fr' => 'Action de sélection :')); //!
                array_push($text, array('key' => 'WIDGET_SELECTION_ADD_CALENDAR',
                                        'parent' => 'PARENT_WIDGET',
                                        'text' => 'Add calendar',
                                        'de' => 'Kalender hinzufügen', // !
                                        'es' => 'Añada calendario', //!
                                        'fr' => 'Ajoutez le calendrier')); //!
                array_push($text, array('key' => 'WIDGET_SELECTION_ADD_SIDEBAR',
                                        'parent' => 'PARENT_WIDGET',
                                        'text' => 'Add calendar sidebar',
                                        'de' => 'Kalenderleiste hinzufügen', // !
                                        'es' => 'Añada el calendario sidebar', //!
                                        'fr' => 'Ajoutez l<<single-quote>>encadré de calendrier')); //!
                array_push($text, array('key' => 'WIDGET_ID_LABEL',
                                        'parent' => 'PARENT_WIDGET',
                                        'text' => 'Select calendar ID:',
                                        'de' => 'Kalender-ID auswählen:', // !
                                        'es' => 'Seleccione el calendario ID:', //!
                                        'fr' => 'Choisissez l<<single-quote>>ID de calendrier:')); //!
                array_push($text, array('key' => 'WIDGET_NO_CALENDARS',
                                        'parent' => 'PARENT_WIDGET',
                                        'text' => 'No calendars.',
                                        'de' => 'Keine Kalender.', // !
                                        'es' => 'Ningunos calendarios.', //!
                                        'fr' => 'Aucun calendrier.')); //!
                array_push($text, array('key' => 'WIDGET_LANGUAGE_LABEL',
                                        'parent' => 'PARENT_WIDGET',
                                        'text' => 'Select language:',
                                        'de' => 'Sprache auswählen:', // !
                                        'es' => 'Lengua escogida:', //!
                                        'fr' => 'Langue de sélection :')); //!
                
                return $text;
            }
        }
    }