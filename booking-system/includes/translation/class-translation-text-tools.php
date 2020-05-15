<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-tools.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Tools translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextTools')){
        class DOPBSPTranslationTextTools{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize tools text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'tools'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'toolsHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'toolsRepairCalendarsSettings'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'toolsRepairDatabaseText'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'toolsRepairSearchSettings'));
            }

            /*
             * Tools text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function tools($text){
                array_push($text, array('key' => 'PARENT_TOOLS',
                                        'parent' => '',
                                        'text' => 'Tools'));
                
                array_push($text, array('key' => 'TOOLS_TITLE',
                                        'parent' => 'PARENT_TOOLS',
                                        'text' => 'Tools',
                                        'de' => 'Werkzeuge', // !
                                        'es' => 'Herramientas', // !
                                        'fr' => 'Outils')); //!
                
                return $text;
            }
            
            /*
             * Tools help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function toolsHelp($text){
                array_push($text, array('key' => 'PARENT_TOOLS_HELP',
                                        'parent' => '',
                                        'text' => 'Tools - Help'));
                
                array_push($text, array('key' => 'TOOLS_HELP',
                                        'parent' => 'PARENT_TOOLS_HELP',
                                        'text' => 'Tools to help you with some of the booking system needs.',
                                        'de' => 'Werkzeuge, die Ihnen bei einigen Anforderungen des Buchungssystems helfen.', // !
                                        'es' => 'Herramientas para ayudarle con algunas de las necesidades del sistema de reservas.', //!
                                        'fr' => 'Outils pour vous aider avec certains des besoins du système de réservation.')); //!
                
                return $text;
            }

            /*
             * Tools repair calendars settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function toolsRepairCalendarsSettings($text){
                array_push($text, array('key' => 'PARENT_TOOLS_REPAIR_CALENDARS_SETTINGS',
                                        'parent' => '',
                                        'text' => 'Tools - Repair calendars settings'));
                
                array_push($text, array('key' => 'TOOLS_REPAIR_CALENDARS_SETTINGS_TITLE',
                                        'parent' => 'PARENT_TOOLS_REPAIR_CALENDARS_SETTINGS',
                                        'text' => 'Repair calendars settings',
                                        'de' => 'Kalender Einstellungen reparieren', // !
                                        'es' => 'Ajustes de calendarios de reparación', //!
                                        'fr' => 'Paramètres de calendriers de réparation')); //!
                
                array_push($text, array('key' => 'TOOLS_REPAIR_CALENDARS_SETTINGS_CONFIRMATION',
                                        'parent' => 'PARENT_TOOLS_REPAIR_CALENDARS_SETTINGS',
                                        'text' => 'Are you sure you want to start calendars settings repairs?',
                                        'de' => 'Möchten Sie die Reparatur der Kalendereinstellungen wirklich starten?', // !
                                        'es' => '¿Seguro que quieres empezar a reparar los calendarios?', //!
                                        'fr' => 'Êtes-vous sûr de vouloir commencer les réparations des paramètres des calendriers?')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_CALENDARS_SETTINGS_REPAIRING',
                                        'parent' => 'PARENT_TOOLS_REPAIR_CALENDARS_SETTINGS',
                                        'text' => 'Repairing calendars settings ...',
                                        'de' => 'Kalendereinstellungen werden repariert...', // !
                                        'es' => 'Reparar ajustes de calendarios...', //!
                                        'fr' => 'Réparation de paramètres de calendriers ...')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_CALENDARS_SETTINGS_SUCCESS',
                                        'parent' => 'PARENT_TOOLS_REPAIR_CALENDARS_SETTINGS',
                                        'text' => 'The settings have been repaired.',
                                        'de' => 'Die Einstellungen wurden repariert.', // !
                                        'es' => 'Los ajustes han sido reparados.', //!
                                        'fr' => 'Les réglages ont été réparés.')); //!
                
                array_push($text, array('key' => 'TOOLS_REPAIR_CALENDARS_SETTINGS_CALENDARS',
                                        'parent' => 'PARENT_TOOLS_REPAIR_CALENDARS_SETTINGS',
                                        'text' => 'Calendars',
                                        'de' => 'Kalendern', // !
                                        'es' => 'Calendarios', //!
                                        'fr' => 'Calendriers')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_CALENDARS_SETTINGS_SETTINGS_DATABASE',
                                        'parent' => 'PARENT_TOOLS_REPAIR_CALENDARS_SETTINGS',
                                        'text' => 'Settings database',
                                        'de' => 'Einstellungsdatenbank', // !
                                        'es' => 'Base de datos de ajustes', //!
                                        'fr' => 'Base de données de paramètres')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_CALENDARS_SETTINGS_NOTIFICATIONS_DATABASE',
                                        'parent' => 'PARENT_TOOLS_REPAIR_CALENDARS_SETTINGS',
                                        'text' => 'Notifications database',
                                        'de' => 'Benachrichtigungs Datenbank', // !
                                        'es' => 'Notifications database', //!
                                        'fr' => 'Base de données de notifications')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_CALENDARS_SETTINGS_PAYMENT_DATABASE',
                                        'parent' => 'PARENT_TOOLS_REPAIR_CALENDARS_SETTINGS',
                                        'text' => 'Payment database',
                                        'de' => 'Zahlungsdatenbank', // !
                                        'es' => 'Base de datos de pago', //!
                                        'fr' => 'Base de données de paiement')); //!
                
                array_push($text, array('key' => 'TOOLS_REPAIR_CALENDARS_SETTINGS_UNCHANGED',
                                        'parent' => 'PARENT_TOOLS_REPAIR_CALENDARS_SETTINGS',
                                        'text' => 'Unchanged',
                                        'de' => 'Unverändert', // !
                                        'es' => 'Sin modificar', //!
                                        'fr' => 'Inchangé')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_CALENDARS_SETTINGS_REPAIRED',
                                        'parent' => 'PARENT_TOOLS_REPAIR_CALENDARS_SETTINGS',
                                        'text' => 'Repaired',
                                        'de' => 'Repariert', // !
                                        'es' => 'Reparado', //!
                                        'fr' => 'Réparé')); //!
                
                return $text;
            }

            /*
             * Tools repair database & text text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function toolsRepairDatabaseText($text){
                array_push($text, array('key' => 'PARENT_TOOLS_REPAIR_DATABASE_TEXT',
                                        'parent' => '',
                                        'text' => 'Tools - Repair database & text'));
                
                array_push($text, array('key' => 'TOOLS_REPAIR_DATABASE_TEXT_TITLE',
                                        'parent' => 'PARENT_TOOLS_REPAIR_DATABASE_TEXT',
                                        'text' => 'Repair database & text',
                                        'de' => 'Datenbank und Text reparieren', // !
                                        'es' => 'Reparación de base de datos y texto', //!
                                        'fr' => 'Réparer base de données & texte')); //!
                
                array_push($text, array('key' => 'TOOLS_REPAIR_DATABASE_TEXT_CONFIRMATION',
                                        'parent' => 'PARENT_TOOLS_REPAIR_DATABASE_TEXT',
                                        'text' => 'Are you sure you want to verify the database & the text and repair them if needed?',
                                        'de' => 'Sind Sie sicher, dass Sie die Datenbank und den Text überprüfen und bei Bedarf reparieren möchten?', // !
                                        'es' => '¿Estás seguro de que quieres verificar la base de datos y el texto y repararlos si es necesario?', //!
                                        'fr' => 'Êtes-vous sûr de vouloir vérifier la base de données et le texte et de les réparer si nécessaire?')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_DATABASE_TEXT_REPAIRING',
                                        'parent' => 'PARENT_TOOLS_REPAIR_DATABASE_TEXT',
                                        'text' => 'Verifying and repairing the database & the text ...',
                                        'de' => 'Überprüfen und Reparieren der Datenbank & des Textes ...', // !
                                        'es' => 'Verificación y reparación de la base de datos y el texto ...', //!
                                        'fr' => 'Vérifier et réparer la base de données et le texte...')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_DATABASE_TEXT_SUCCESS',
                                        'parent' => 'PARENT_TOOLS_REPAIR_DATABASE_TEXT',
                                        'text' => 'The database & the text have been verified and repaired. The page will redirect shortly to Dashboard.',
                                        'de' => 'Die Datenbank und der Text wurden überprüft und repariert. Die Seite wird in Kürze zum Dashboard weitergeleitet.', // !
                                        'es' => 'La base de datos y el texto han sido verificados y reparados. La página se redirigirá en breve a Dashboard.', //!
                                        'fr' => 'La base de données et le texte ont été vérifiés et réparés. La page sera redirigée sous peu vers le tableau de bord.')); //!
                
                return $text;
            }

            /*
             * Tools repair search settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function toolsRepairSearchSettings($text){
                array_push($text, array('key' => 'PARENT_TOOLS_REPAIR_SEARCH_SETTINGS',
                                        'parent' => '',
                                        'text' => 'Tools - Repair search settings'));
                
                array_push($text, array('key' => 'TOOLS_REPAIR_SEARCH_SETTINGS_TITLE',
                                        'parent' => 'PARENT_TOOLS_REPAIR_SEARCH_SETTINGS',
                                        'text' => 'Repair search settings',
                                        'de' => 'Sucheinstellungen reparieren', // !
                                        'es' => 'Ajustes de búsqueda de reparación', //!
                                        'fr' => 'Fixations de recherche de réparation')); //!
                
                array_push($text, array('key' => 'TOOLS_REPAIR_SEARCH_SETTINGS_CONFIRMATION',
                                        'parent' => 'PARENT_TOOLS_REPAIR_SEARCH_SETTINGS',
                                        'text' => 'Are you sure you want to start search settings repairs?',
                                        'de' => 'Möchten Sie die Reparatur der Sucheinstellungen wirklich starten?', // !
                                        'es' => '¿Estás seguro de que quieres empezar a buscar la configuración de reparaciones?', //!
                                        'fr' => 'Êtes-vous sûr que vous voulez commencer à rechercher des réparations de paramètres?')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_SEARCH_SETTINGS_REPAIRING',
                                        'parent' => 'PARENT_TOOLS_REPAIR_SEARCH_SETTINGS',
                                        'text' => 'Repairing search settings ...',
                                        'de' => 'Sucheinstellungen werden repariert...', // !
                                        'es' => 'Reparar ajustes de búsqueda...', //!
                                        'fr' => 'Réparation de paramètres de recherche ...')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_SEARCH_SETTINGS_SUCCESS',
                                        'parent' => 'PARENT_TOOLS_REPAIR_SEARCH_SETTINGS',
                                        'text' => 'The settings have been repaired.',
                                        'de' => 'Die Einstellungen wurden repariert.', // !
                                        'es' => 'Los ajustes han sido reparados.', //!
                                        'fr' => 'Les réglages ont été réparés.')); //!
                
                array_push($text, array('key' => 'TOOLS_REPAIR_SEARCH_SETTINGS_SEARCHES',
                                        'parent' => 'PARENT_TOOLS_REPAIR_SEARCH_SETTINGS',
                                        'text' => 'Searches',
                                        'de' => 'Suchen', // !
                                        'es' => 'Búsquedas', //!
                                        'fr' => 'Recherches')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_SEARCH_SETTINGS_SETTINGS_DATABASE',
                                        'parent' => 'PARENT_TOOLS_REPAIR_SEARCH_SETTINGS',
                                        'text' => 'Settings database',
                                        'de' => 'Einstellungsdatenbank', // !
                                        'es' => 'Base de datos de ajustes', //!
                                        'fr' => 'Base de données de fixations')); //!
                
                array_push($text, array('key' => 'TOOLS_REPAIR_SEARCH_SETTINGS_UNCHANGED',
                                        'parent' => 'PARENT_TOOLS_REPAIR_SEARCH_SETTINGS',
                                        'text' => 'Unchanged',
                                        'de' => 'Unverändert', // !
                                        'es' => 'Inalterado', //!
                                        'fr' => 'Inchangé')); //!
                array_push($text, array('key' => 'TOOLS_REPAIR_SEARCH_SETTINGS_REPAIRED',
                                        'parent' => 'PARENT_TOOLS_REPAIR_SEARCH_SETTINGS',
                                        'text' => 'Repaired',
                                        'de' => 'Repariert', // !
                                        'es' => 'Reparado', //!
                                        'fr' => 'Réparé')); //!
                
                return $text;
            }
        }
    }