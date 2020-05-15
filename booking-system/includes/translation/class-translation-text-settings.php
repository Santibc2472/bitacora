<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.2.4
* File                    : includes/translation/class-translation-text-settings.php
* File Version            : 1.2.1
* Created / Last Modified : 07 May 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Settings translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextSettings')){
        class DOPBSPTranslationTextSettings{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize settings text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settings'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsCalendar'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsCalendarHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsNotifications'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsNotificationsHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsPaymentGateways'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsPaymentGatewaysHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsSearch'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsSearchHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsUsers'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsUsersHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsLicences'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsLicencesHelp'));
            }
            
            /*
             * Settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settings($text){
                array_push($text, array('key' => 'PARENT_SETTINGS',
                                        'parent' => '',
                                        'text' => 'Settings'));
                
                array_push($text, array('key' => 'SETTINGS_TITLE',
                                        'parent' => 'PARENT_SETTINGS',
                                        'text' => 'Settings',
                                        'de' => 'Einstellungen', // !
                                        'es' => 'Configuración', //!
                                        'fr' => 'Paramètres')); //!
                
                array_push($text, array('key' => 'SETTINGS_ENABLED',
                                        'parent' => 'PARENT_SETTINGS',
                                        'text' => 'Enabled',
                                        'de' => 'Aktiviert', // !
                                        'es' => 'Activado', //!
                                        'fr' => 'Activé')); //!
                array_push($text, array('key' => 'SETTINGS_DISABLED',
                                        'parent' => 'PARENT_SETTINGS',
                                        'text' => 'Disabled',
                                        'de' => 'Deaktiviert', // !
                                        'es' => 'Desactivado', //!
                                        'fr' => 'Désactivé')); //!
                
                array_push($text, array('key' => 'SETTINGS_GENERAL_TITLE',
                                        'parent' => 'PARENT_SETTINGS',
                                        'text' => 'General settings',
                                        'de' => 'Allgemeine Einstellungen', // !
                                        'es' => 'Configuración General', //!
                                        'fr' => 'Paramètres généraux')); //!
                
                array_push($text, array('key' => 'SETTINGS_GENERAL_TITLE',
                                        'parent' => 'PARENT_SETTINGS',
                                        'text' => 'General settings',
                                        'de' => 'Allgemeine Einstellungen', // !
                                        'es' => 'Configuración General', //!
                                        'fr' => 'Paramètres généraux')); //!
                
                array_push($text, array('key' => 'SETTINGS_GENERAL_GOOGLE_MAP_API_KEY',
                                        'parent' => 'PARENT_SETTINGS',
                                        'text' => 'Google Map API key',
                                        'de' => 'Google Map API-Schlüssel', // !
                                        'es' => 'Tecla API de Google Map', //!
                                        'fr' => 'Clé API Google Map')); //!
                
                array_push($text, array('key' => 'SETTINGS_GENERAL_REFERRAL_ID',
                                        'parent' => 'PARENT_SETTINGS',
                                        'text' => 'Referral ID',
                                        'de' => 'Empfehlung-ID', // !
                                        'es' => 'Remisión ID', //!
                                        'fr' => 'ID de référence')); //!
                
                array_push($text, array('key' => 'SETTINGS_GENERAL_REFERRAL_DISPLAY',
                                        'parent' => 'PARENT_SETTINGS',
                                        'text' => 'Referral display',
                                        'de' => 'Anzeige der Empfehlung', // !
                                        'es' => 'Demostración de remisión', //!
                                        'fr' => 'Affichage de référence')); //!
                
                return $text;
            }
            
            /*
             * Settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsHelp($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Help'));
                
                array_push($text, array('key' => 'SETTINGS_HELP',
                                        'parent' => 'PARENT_SETTINGS_HELP',
                                        'text' => 'Edit booking system settings.',
                                        'de' => 'Bearbeiten Sie die Einstellungen des Buchungssystems.', // !
                                        'es' => 'Editar la configuración del sistema de reservas.', //!
                                        'fr' => 'Modifier les paramètres du système de réservation.')); //!
                
                array_push($text, array('key' => 'SETTINGS_GENERAL_GOOGLE_MAP_API_KEY_HELP',
                                        'parent' => 'PARENT_SETTINGS_HELP',
                                        'text' => 'Enter Google Map API key.',
                                        'de' => 'Geben Sie den Google Map API-Schlüssel ein.', // !
                                        'es' => 'Introduzca la tecla API de Google Map.', //!
                                        'fr' => 'Entrez la clé API Google Map.')); //!
                
                array_push($text, array('key' => 'SETTINGS_GENERAL_REFERRAL_ID_HELP',
                                        'parent' => 'PARENT_SETTINGS_HELP',
                                        'text' => 'Enter your referral ID.You can find it in your account on pinpoint.world in the Affiliate program section. ',
                                        'de' => 'Geben Sie Ihre Empfehlungs-ID ein.Sie können es in Ihrem Konto auf pinpoint.world im Teilnehmer-Programmabschnitt finden.', // !
                                        'es' => 'Introduzca su identificación de referencia.Puede encontrarlo en su cuenta en pinpoint.world en la sección del programa de afiliados.', //!
                                        'fr' => 'Entrez votre numéro de référence.Vous pouvez le trouver dans votre compte sur pinpoint.world dans la section Programme d’affiliation.')); //!
                
                array_push($text, array('key' => 'SETTINGS_GENERAL_REFERRAL_DISPLAY_HELP',
                                        'parent' => 'PARENT_SETTINGS_HELP',
                                        'text' => 'Enable if you want to display a link with the referral code in front-end.',
                                        'de' => 'Aktivieren Sie diese Option, wenn Sie einen Link mit dem Empfehlungscode im Front-End anzeigen möchten', // !
                                        'es' => 'Activar si desea mostrar un enlace con el código de referencia en front-end.', //!
                                        'fr' => 'Activez si vous voulez afficher un lien avec le code de référence à front end.')); //!
                
                return $text;
            }
            
            /*
             * Calendar settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsCalendar($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_CALENDAR',
                                        'parent' => '',
                                        'text' => 'Settings - Calendar'));
                
                array_push($text, array('key' => 'SETTINGS_CALENDAR_TITLE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Calendar settings',
                                        'de' => 'Kalendereinstellungen', // !
                                        'es' => 'Ajustes calendarios', //!
                                        'fr' => 'Paramètres de calendrier')); //!
                
                array_push($text, array('key' => 'SETTINGS_CALENDAR_NAME',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Name',
                                        'de' => 'Name', // !
                                        'es' => 'Nombre', //!
                                        'fr' => 'Nom')); //!
                /*
                 * General settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'General settings',
                                        'de' => 'Allgemeine Einstellungen', // !
                                        'es' => 'Configuración General', //!
                                        'fr' => 'Paramètres généraux')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_DATE_TYPE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Date type',
                                        'de' => 'Datentyp', // !
                                        'es' => 'Tipo de fecha', //!
                                        'fr' => 'Type de date')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_DATE_TYPE_AMERICAN',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'American (mm dd, yyyy)',
                                        'de' => 'Amerikanisch (MM.TT.JJJJ)', // !
                                        'es' => 'Americano (mm dd, aaaa)', //!
                                        'fr' => 'Américain (mm jj, aaaa)')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_DATE_TYPE_EUROPEAN',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'European (dd mm yyyy)',
                                        'de' => 'Europa (TT MM JJJJ)', // !
                                        'es' => 'Europea (dd mm aa)', //!
                                        'fr' => 'Européen (jj mm aaaa)')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_TEMPLATE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Style template',
                                        'de' => 'Stilvorlage', // !
                                        'es' => 'Plantilla de estilo', //!
                                        'fr' => 'Modèle de style')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_BOOKING_STOP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Stop booking x minutes in advance',
                                        'de' => 'Buchung x Minuten im Voraus beenden', // !
                                        'es' => 'Detener la reserva x minutos de antelación', //!
                                        'fr' => 'Arrêter la réservation x minutes à l<<single-quote>>avance')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_MONTHS_NO',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Number of months displayed',
                                        'de' => 'Anzahl der angezeigten Monate', // !
                                        'es' => 'Número de meses mostrados', //!
                                        'fr' => 'Nombre de mois affichés')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_VIEW_ONLY',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'View only info',
                                        'de' => 'Nur Informationen anzeigen', // !
                                        'es' => 'Vea sólo la información', //!
                                        'fr' => 'Voyez seulement des infos')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_SERVER_TIME',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable server time',
                                        'de' => 'Serverzeit aktivieren', // !
                                        'es' => 'Permita el tiempo de servidor', //!
                                        'fr' => 'Permettez le temps de serveur')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_TIMEZONE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Timezone',
                                        'de' => 'Zeitzone', // !
                                        'es' => 'Huso horario', //!
                                        'fr' => 'Fuseau horaire')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_HIDE_PRICE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Hide price',
                                        'de' => 'Preis ausblenden', // !
                                        'es' => 'Precio de puesto', //!
                                        'fr' => 'Prix de cachette')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_HIDE_NO_AVAILABLE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Hide No available',
                                        'de' => 'Nr ausblenden verfügbar', // !
                                        'es' => 'Ocultar el número disponible', //!
                                        'fr' => 'Masquer le nombre disponible')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_MINIMUM_NO_AVAILABLE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Minimum no available',
                                        'de' => 'Mindestanzahl verfügbar', // !
                                        'es' => 'Número mínimo disponible', //!
                                        'fr' => 'Nombre minimal disponible')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_POST_ID',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Post ID',
                                        'de' => 'Beitrag ID', // !
                                        'es' => 'ID de la publicación', //!
                                        'fr' => 'Post ID')); //!
                /*
                 * Currency settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CURRENCY_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Currency settings',
                                        'de' => 'Währungseinstellungen', // !
                                        'es' => 'Ajustes monetarios', //!
                                        'fr' => 'Paramètres de monnaie')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CURRENCY',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Currency',
                                        'de' => 'Währung', // !
                                        'es' => 'Moneda', //!
                                        'fr' => 'Monnaie')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CURRENCY_POSITION',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Currency position',
                                        'de' => 'Währungsposition', // !
                                        'es' => 'Posición monetaria', //!
                                        'fr' => 'Position de monnaie')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CURRENCY_POSITION_BEFORE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Before',
                                        'de' => 'Vorher', // !
                                        'es' => 'Antes', //!
                                        'fr' => 'Avant')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CURRENCY_POSITION_BEFORE_WITH_SPACE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Before with space',
                                        'de' => 'Vorher mit Leerzeichen', // !
                                        'es' => 'Antes con espacio', //!
                                        'fr' => 'Auparavant avec espace')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CURRENCY_POSITION_AFTER',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'After',
                                        'de' => 'Nachher', // !
                                        'es' => 'Después', //!
                                        'fr' => 'Après')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CURRENCY_POSITION_AFTER_WITH_SPACE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'After with space',
                                        'de' => 'Nachher, mit Leerzeichen', // !
                                        'es' => 'Después con espacio', //!
                                        'fr' => 'Après avec espace')); //!
                /*
                 * Days settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Days settings',
                                        'de' => 'Einstellungen für Tage', // !
                                        'es' => 'Ajustes de días', //!
                                        'fr' => 'Fixations de jours')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_AVAILABLE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Available days',
                                        'de' => 'Verfügbare Tage', // !
                                        'es' => 'Días disponibles', //!
                                        'fr' => 'Jours disponibles')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_FIRST',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'First weekday',
                                        'de' => 'Erster Wochentag', // !
                                        'es' => 'Primer día laborable', //!
                                        'fr' => 'Premier jour ouvrable')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_FIRST_DISPLAYED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'First day displayed',
                                        'de' => 'Der erste Tag wird angezeigt', // !
                                        'es' => 'Primer día mostrado', //!
                                        'fr' => 'Premier jour montré')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_MULTIPLE_SELECT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Use Check in/Check out',
                                        'de' => 'Verwenden Sie Ein-/Auschecken ', // !
                                        'es' => 'Uso Check in/Check out', //!
                                        'fr' => 'Utiliser Check in/Check out')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_MORNING_CHECK_OUT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Morning check out',
                                        'de' => 'Morgendlicher Auschecken ', // !
                                        'es' => 'La mañana comprueba', //!
                                        'fr' => 'Matin depart')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_DETAILS_FROM_HOURS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Use hours details to set day details',
                                        'de' => 'Verwenden Sie die Stunden Details, um Tagesdetails festzulegen', // !
                                        'es' => 'Utilice los detalles de las horas para establecer los detalles del día', //!
                                        'fr' => 'Utiliser les détails des heures pour définir les détails du jour')); //!
                /*
                 * Hours settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Hours settings',
                                        'de' => 'Stundeneinstellungen', // !
                                        'es' => 'Ajustes de horas', //!
                                        'fr' => 'Paramètres d<<single-quote>>heures')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Use hours',
                                        'de' => 'Verwenden stunden', // !
                                        'es' => 'Horas de empleo', //!
                                        'fr' => 'Utilisez les heures')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_INFO_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable hours info',
                                        'de' => 'Stundeninformationen aktivieren', // !
                                        'es' => 'Permita la información de horas', //!
                                        'fr' => 'Permettez des infos d<<single-quote>>heures')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_DEFINITIONS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Define hours',
                                        'de' => 'Stunden definieren', // !
                                        'es' => 'Defina horas', //!
                                        'fr' => 'Définissez des heures')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_MULTIPLE_SELECT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Use start/finish hours',
                                        'de' => 'Verwenden Sie Start-/End stunden', // !
                                        'es' => 'Use horas de inicio/finalización', //!
                                        'fr' => 'Utiliser les heures de début et de fin')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_AMPM',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable AM/PM format',
                                        'de' => 'Aktivieren Sie das AM/PM-Format', // !
                                        'es' => 'Habilitar formato AM/PM', //!
                                        'fr' => 'Activer le format AM/PM')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_ADD_LAST_HOUR_TO_TOTAL_PRICE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Add last selected hour price to total price',
                                        'de' => 'Zuletzt ausgewählten Stundenpreis zum Gesamtpreis hinzufügen', // !
                                        'es' => 'Añadir el último precio de hora seleccionado al precio total', //!
                                        'fr' => 'Ajouter le prix de la dernière heure sélectionnée au prix total')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_INTERVAL_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable hours interval',
                                        'de' => 'Stundenintervall aktivieren', // !
                                        'es' => 'Permita el intervalo de horas', //!
                                        'fr' => 'Permettez l<<single-quote>>intervalle d<<single-quote>>heures')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_INTERVAL_AUTOBREAK_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable breaks for hours interval',
                                        'de' => 'Pausen für das Stundenintervall aktivieren', // !
                                        'es' => 'Habilitar descansos para intervalos de horas', //!
                                        'fr' => 'Activer les pauses pendant des heures')); //!
                /*
                 * Sidebar settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_SIDEBAR_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Sidebar settings',
                                        'de' => 'Seitenleiste Einstellungen', // !
                                        'es' => 'Sidebar ajustes', //!
                                        'fr' => 'Paramètres de sidebar')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_SIDEBAR_STYLE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Sidebar style',
                                        'de' => 'Stil der Seitenleiste', // !
                                        'es' => 'Sidebar estilo', //!
                                        'fr' => 'Style de sidebar')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_SIDEBAR_NO_ITEMS_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable number of items select',
                                        'de' => 'Aktivieren Sie die Anzahl der ausgewählten Elemente', // !
                                        'es' => 'Habilitar el número de elementos seleccionados', //!
                                        'fr' => 'Activer le nombre d<<single-quote>>éléments sélection')); //!
                /*
                 * Rules settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_RULES_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Rules settings',
                                        'de' => 'Regeleinstellungen', // !
                                        'es' => 'Ajustes de reglas', //!
                                        'fr' => 'Paramètres de règles')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_RULES',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select rule',
                                        'de' => 'Regel auswählen', // !
                                        'es' => 'Seleccione la regla', //!
                                        'fr' => 'Choisissez la règle')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_RULES_NONE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'None',
                                        'de' => 'Keine', // !
                                        'es' => 'Ninguno', //!
                                        'fr' => 'Aucun')); //!
                /*
                 * Extras settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_EXTRAS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Extras settings',
                                        'de' => 'Einstellungen für Extras', // !
                                        'es' => 'Ajustes de suplementos', //!
                                        'fr' => 'Paramètres de suppléments')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_EXTRAS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select extra',
                                        'de' => 'Wählen Sie Extra', // !
                                        'es' => 'Seleccione el suplementario', //!
                                        'fr' => 'Choisir le supplément')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_EXTRAS_NONE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'None',
                                        'de' => 'Keine', // !
                                        'es' => 'Ninguno', //!
                                        'fr' => 'Aucun')); //!
                /*
                 * Cart settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CART_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Cart settings',
                                        'de' => 'Warenkorb einstellungen', // !
                                        'es' => 'Ajustes de carro', //!
                                        'fr' => 'Paramètres de chariot')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CART_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable cart',
                                        'de' => 'Warenkorb aktivieren', // !
                                        'es' => 'Permita carro', //!
                                        'fr' => 'Permettez le chariot')); //!
                /*
                 * Discounts settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DISCOUNTS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Discounts settings',
                                        'de' => 'Rabatt Einstellungen', // !
                                        'es' => 'Ajustes de descuentos', //!
                                        'fr' => 'Paramètres de remises')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DISCOUNTS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select discount',
                                        'de' => 'Wählen Sie Rabatt', // !
                                        'es' => 'Seleccione el descuento', //!
                                        'fr' => 'Sélectionner le remis')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DISCOUNTS_NONE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'None',
                                        'de' => 'Keine', // !
                                        'es' => 'Ninguno', //!
                                        'fr' => 'Aucun')); //!
                /*
                 * Taxes & fees settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_FEES_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Taxes & fees settings',
                                        'de' => 'Einstellungen für Steuern und Gebühren', // !
                                        'es' => 'Ajustes de impuestos y tasas', //!
                                        'fr' => 'Paramètres des taxes et des frais')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_FEES',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select taxes and/or fees',
                                        'de' => 'Wählen Sie Steuern und/oder Gebühren aus', // !
                                        'es' => 'Seleccione impuestos y/o tarifas', //!
                                        'fr' => 'Choisir des taxes et/ou des frais')); //!
                /*
                 * Coupons settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_COUPONS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Coupons settings',
                                        'de' => 'Einstellungen für Coupons', // !
                                        'es' => 'Ajustes de cupones', //!
                                        'fr' => 'Paramètres de coupons')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_COUPONS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select coupons',
                                        'de' => 'Wählen Sie Coupons aus', // !
                                        'es' => 'Cupones escogidos', //!
                                        'fr' => 'Sélectionnez des coupons')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_COUPONS_NONE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'None',
                                        'de' => 'Keine', // !
                                        'es' => 'Ninguno', //!
                                        'fr' => 'Aucun')); //!
                /*
                 * Deposit settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Deposit settings',
                                        'de' => 'Einzahlung Einstellungen', // !
                                        'es' => 'Ajustes de depósito', //!
                                        'fr' => 'Paramètres de dépôt')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DEPOSIT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Deposit value',
                                        'de' => 'Einzahlungswert', // !
                                        'es' => 'Valor de depósito', //!
                                        'fr' => 'Valeur de dépôt')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_TYPE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Deposit type',
                                        'de' => 'Einzahlungs art', // !
                                        'es' => 'Tipo de depósito', //!
                                        'fr' => 'Type de dépôt')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_TYPE_FIXED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Fixed',
                                        'de' => 'Fest', // !
                                        'es' => 'Fijo', //!
                                        'fr' => 'Fixé')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_TYPE_PERCENT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Percent',
                                        'de' => 'Prozent', // !
                                        'es' => 'Por ciento', //!
                                        'fr' => 'Pour cent')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_PAY_FULL_AMOUNT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable Pay full amount.',
                                        'de' => 'Aktivieren Sie die Option "Vollständige Zahlung".', // !
                                        'es' => 'Habilitar Pagar cantidad completa.', //!
                                        'fr' => 'Activer Payer le plein montant.')); //!
                /*
                 * Forms ssettings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_FORMS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Forms settings',
                                        'de' => 'Formulareinstellungen', // !
                                        'fr' => 'Ajustes de formas')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_FORMS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select form',
                                        'de' => 'Formular auswählen', // !
                                        'es' => 'Forma escogida', //!
                                        'fr' => 'Sélectionnez le formulaire')); //!
                /*
                 * Order settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_ORDER_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Order settings',
                                        'de' => 'Auftragseinstellungen', // !
                                        'es' => 'Ajustes de orden', //!
                                        'fr' => 'Les paramètres d<<single-quote>>ordre')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable Terms & Conditions',
                                        'de' => 'Aktivieren Sie die Geschäftsbedingungen', // !
                                        'es' => 'Habilitar los Términos y Condiciones', //!
                                        'fr' => 'Activer les Termes et Conditions')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_LINK',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Terms & Conditions link',
                                        'de' => 'Link "Geschäftsbedingungen"', // !
                                        'es' => 'Términos y Condiciones de Uso', //!
                                        'fr' => 'Activer les Termes et Conditions')); //!
                /*
                 * Google Calendar Sync settings.
                 */
                
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_SYNC_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Google Calendar Sync settings',
                                        'de' => 'Google Kalender Sync-Einstellungen', // !
                                        'es' => 'Configuración de Google Calendar Sync', //!
                                        'fr' => 'Paramètres Google Calendar Sync')); //!
                
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable Google Calendar Sync',
                                        'de' => 'Google Kalender Sync aktivieren', // !
                                        'es' => 'Activar la sincronización de Google Calendar', //!
                                        'fr' => 'Activer Google Calendar Sync')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_CLIENT_ID',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Client ID',
                                        'de' => 'Kunden-ID', // !
                                        'es' => 'Cliente ID', //!
                                        'fr' => 'ID de client')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_CLIENT_SECRET',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Client secret',
                                        'de' => 'Kunden geheimnis', // !
                                        'es' => 'Secreto de cliente', //!
                                        'fr' => 'Secret de client')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_CALENDAR_ID',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Calendar ID',
                                        'de' => 'Kalender-ID', // !
                                        'es' => 'Calendario ID', //!
                                        'fr' => 'ID de calendrier')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_FEED_URL',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Feed URL',
                                        'de' => 'Feed URL', // !
                                        'es' => 'URL del feed', //!
                                        'fr' => 'URL du flux')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_SYNC_TIME',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Sync time',
                                        'de' => 'Synchronisierungszeit', // !
                                        'es' => 'Tiempo de sincronización', //!
                                        'fr' => 'Temps synchro')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_SYNC_TIMEOUT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Sync timeout',
                                        'de' => 'Synchronisierungszeitlimit', // !
                                        'es' => 'Interrupción de sincronización', //!
                                        'fr' => 'Sync timeout')); //!
                
                /*
                 * iCAL Sync settings.
                 */
                
                array_push($text, array('key' => 'SETTINGS_CALENDAR_SYNC_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'iCalendar - Synchronization',
                                        'de' => 'ICalendar - Synchronisierung', // !
                                        'es' => 'iCalendar - Sincronización', //!
                                        'fr' => 'ICalendar - Synchronisation')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_ICAL_URL',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'iCalendar URL',
                                        'de' => 'iCalendar URL', // !
                                        'es' => 'iCalendar URL', //!
                                        'fr' => 'iCalendar URL')); //!
                
                /*
                 * Airbnb Sync settings.
                 */
                
                array_push($text, array('key' => 'SETTINGS_CALENDAR_AIRBNB_SYNC_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Airbnb Sync settings',
                                        'de' => 'Airbnb Sync-Einstellungen', // !
                                        'es' => 'Airbnb ajustes de Sincronización', //!
                                        'fr' => 'Airbnb Synchronisent fixations')); //!
                
                array_push($text, array('key' => 'SETTINGS_CALENDAR_AIRBNB_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable Airbnb Sync',
                                        'de' => 'Airbnb Sync aktivieren', // !
                                        'es' => 'Permita Sincronización Airbnb', //!
                                        'fr' => 'Permettez la Synchronisation d<<single-quote>>Airbnb')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_AIRBNB_FEED_URL',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Feed URL',
                                        'de' => 'Feed URL', // !
                                        'es' => 'URL del feed', //!
                                        'fr' => 'URL du flux')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_AIRBNB_SYNC_TIME',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Sync time',
                                        'de' => 'Synchronisierungszeit', // !
                                        'es' => 'Tiempo de sincronización', //!
                                        'fr' => 'Sync temps')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_AIRBNB_SYNC_TIMEOUT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Sync timeout',
                                        'de' => 'Synchronisierungszeitlimit', // !
                                        'es' => 'Interrupción de sincronización', //!
                                        'fr' => 'Sync timeout')); //!
                
                return $text;
            }
            
            /*
             * Calendar settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsCalendarHelp($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Calendar - Help'));
                
                array_push($text, array('key' => 'SETTINGS_CALENDAR_NAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Change calendar name.',
                                        'de' => 'Ändern Sie den Kalendernamen.', // !
                                        'es' => 'Cambie el nombre calendario.', //!
                                        'fr' => 'Changez le nom de calendrier.')); //!
                /*
                 * General settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_DATE_TYPE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: American. Select date format: American (mm dd, yyyy) or European (dd mm yyyy).',
                                        'de' => 'Standardwert: Amerikanisch. Datumsformat auswählen: Amerikanisch (MM.TT.JJJJ) oder europäisch (TT.MM.JJJJ).', // !
                                        'es' => 'Valor predeterminado: Americano. Seleccione el formato de fecha: Americano (mm dd, aaaa) o Europeo (dd mm aa).', //!
                                        'fr' => 'Changez le nom de calendrier.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_TEMPLATE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: default. Select styles template.',
                                        'de' => 'Standardwert: Standard. Wählen Sie eine Stilvorlage aus.', // !
                                        'es' => 'Valor predeterminado: predeterminado. Seleccione plantilla de estilos.', //!
                                        'fr' => 'Valeur par défaut : par défaut. Sélectionner le modèle de styles.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_BOOKING_STOP_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Default value: 0. Set the number of minutes before the booking is stopped in advance. For 1 hour you have 60 minutes, for 1 day you have 1440 minutes.',
                                        'de' => 'Standardwert 0. Geben Sie eine Zahl ein, um Ihre Kunden daran zu hindern, x Minuten vorher zu buchen. Für 1 Stunde haben Sie 60 Minuten, für 1 Tag haben Sie 1440 Minuten.', // !
                                        'es' => 'Valor predeterminado: 0. Establezca el número de minutos antes de que se detenga la reserva con antelación. Por 1 hora tiene 60 minutos, por 1 día tiene 1440 minutos.', //!
                                        'fr' => 'Valeur par défaut : 0. Définissez le nombre de minutes avant l<<single-quote>>arrêt de la réservation à l<<single-quote>>avance. Pour 1 heure vous avez 60 minutes, pour 1 jour vous avez 1440 minutes.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_MONTHS_NO_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: 1. Set the number of months initially displayed. Maximum number allowed is 6.',
                                        'de' => 'Standardwert: 1. Geben Sie an, wie viele Monate gleichzeitig angezeigt werden sollen. Die maximal zulässige Anzahl beträgt 6.', // !
                                        'es' => 'Valor predeterminado: 1. Establecer el número de meses inicialmente mostrados. El número máximo permitido es 6.', //!
                                        'fr' => 'Valeur par défaut : 1. Définissez le nombre de mois initialement affiché. Le nombre maximum autorisé est de 6.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_VIEW_ONLY_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Set to display only booking information in front end.',
                                        'de' => 'Standardwert: Aktiviert. Legen Sie fest, dass nur Buchungsinformationen im Front-End angezeigt werden', // !
                                        'es' => 'Valor predeterminado: Activado. Configure para mostrar sólo la información de reserva en el extremo frontal.', //!
                                        'fr' => 'Valeur par défaut : Activé. Défini pour afficher uniquement les informations de réservation à l<<single-quote>>avant.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_SERVER_TIME_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Use server time.',
                                        'de' => 'Standardwert: Deaktiviert. Serverzeit verwenden.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Utilice el tiempo del servidor.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Utilisez le temps du serveur.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_TIMEZONE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select your timezone.',
                                        'de' => 'Wählen Sie Ihre Zeitzone aus.', // !
                                        'es' => 'Seleccione su timezone.', //!
                                        'fr' => 'Choisissez votre timezone.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_HIDE_PRICE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: false. Enable to hide price from calendar ( frontend ).',
                                        'de' => 'Standardwert: False. Aktivieren Sie diese Option, um den Preis im Kalender auszublenden ( Frontend ).', // !
                                        'es' => 'Valor predeterminado: falso. Permite ocultar el precio del calendario ( frontend ).', //!
                                        'fr' => 'Valeur par défaut : false. Permet de cacher le prix du calendrier ( frontend ).')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_HIDE_NO_AVAILABLE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: false. Enable to hide number of days/hours available from calendar ( frontend ).',
                                        'de' => 'Standardwert: False. Aktivieren Sie diese Option, um die Anzahl der im Kalender verfügbaren Tage/Stunden auszublenden ( Frontend ).', // !
                                        'es' => 'Valor predeterminado: falso. Permite ocultar el número de días/horas disponibles en el calendario ( frontend ).', //!
                                        'fr' => 'Valeur par défaut : false. Permet de masquer le nombre de jours/heures disponibles dans le calendrier ( frontend ).')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_MINIMUM_NO_AVAILABLE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: 1. Set minimum no available from sidebar ( frontend ).',
                                        'de' => 'Standardwert: 1. Legen Sie die Mindestanzahl fest, die in der Seitenleiste ( Frontend ) verfügbar ist.', // !
                                        'es' => 'Valor predeterminado: 1. Establecer mínimo no disponible en la barra lateral ( frontend ).', //!
                                        'fr' => 'Valeur par défaut : 1. Définissez le nombre minimum de non disponible dans la barre latérale ( frontend ).')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GENERAL_POST_ID_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Set post ID where the calendar will be added. It is mandatory if you create a searching system through some calendars.',
                                        'de' => 'Geben Sie die Beitrags-ID ein, in der der Kalender hinzugefügt werden soll. Es ist obligatorisch, wenn Sie ein Suchsystem über einige Kalender erstellen.', // !
                                        'es' => 'Establezca el ID de entrada donde se añadirá el calendario. Es obligatorio si crea un sistema de búsqueda a través de algunos calendarios.', //!
                                        'fr' => 'Set post ID where the calendar will be added. It is mandatory if you create a searching system through some calendars.')); //!
                /*
                 * Currency settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CURRENCY_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: United States Dollar ($, USD). Select calendar currency.',
                                        'de' => 'Standardwert: US-Dollar ($, USD). Wählen Sie die Kalenderwährung aus.', // !
                                        'es' => 'Valor predeterminado: Dólar de los Estados Unidos ($, USD). Seleccione la moneda del calendario.', //!
                                        'fr' => 'Valeur par défaut : Dollar des États-Unis ($, USD). Sélectionnez la devise du calendrier.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CURRENCY_POSITION_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Before. Select currency position.',
                                        'de' => 'Standardwert: Vorher. Währungsposition auswählen.', // !
                                        'es' => 'Valor predeterminado: Antes. Seleccione la posición de la moneda.', //!
                                        'fr' => 'Valeur par défaut : Avant. Sélectionnez la position de la devise.')); //!
                /*
                 * Days settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_MULTIPLE_SELECT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Use Check in/Check out or select only one day.',
                                        'de' => 'Standardwert: Aktiviert. Verwenden Sie Ein-/Auschecken oder wählen Sie nur einen Tag aus.', // !
                                        'es' => 'Valor predeterminado: Activado. Utilice Check in/Check out o seleccione sólo un día.', //!
                                        'fr' => 'Valeur par défaut : Activé. Utilisez Check in/Check out ou sélectionnez seulement un jour.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_AVAILABLE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: all available. Select available weekdays.',
                                        'de' => 'Standardwert: Alle verfügbar. Wählen Sie verfügbare Wochentage aus.', // !
                                        'es' => 'Valor predeterminado: todos disponibles. Seleccione los días laborables disponibles.', //!
                                        'fr' => 'Valeur par défaut : tous disponibles. Sélectionnez les jours de semaine disponibles.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_FIRST_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Monday. Select calendar first weekday.',
                                        'de' => 'Standardwert: Montag. Wählen Sie den ersten Wochentag des Kalenders aus.', // !
                                        'es' => 'Valor predeterminado: Lunes. Seleccione el primer día de semana del calendario.', //!
                                        'fr' => 'Valeur par défaut : Lundi. Sélectionner le calendrier premier jour de semaine.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_FIRST_DISPLAYED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Format: YYYY-MM-DD. Default value: today. Select the day to be first displayed when the calendar calendar is loaded.',
                                        'de' => 'Format: JJJJ-MM-TT. Standardwert: Heute. Wählen Sie den Tag aus, der beim Laden des Kalenders zuerst angezeigt werden soll.', // !
                                        'es' => 'Formato: AAAA-MM-DD. Valor predeterminado: hoy. Seleccione el día que se mostrará por primera vez cuando se carga el calendario.', //!
                                        'fr' => 'Format : AAAA-MM-JJ. Valeur par défaut : aujourd<<single-quote>>hui. Sélectionnez le jour à afficher en premier lorsque le calendrier est chargé.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_MORNING_CHECK_OUT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. This option enables "Check in" in the afternoon of first day and "Check out" in the morning of the day after last day.',
                                        'de' => 'Standardwert: Deaktiviert. Diese Option aktiviert "Check-in" am Nachmittag des ersten Tages und "Check-out" am Morgen des Tages nach dem letzten Tag.', // !
                                        'es' => 'Valor predeterminado: Discapacitado. Esta opción permite "Check in" en la tarde del primer día y "Check out" en la mañana del día después del último día.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Cette option permet "Check in" dans l<<single-quote>>après-midi du premier jour et "Check out" le matin du jour suivant le dernier jour.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DAYS_DETAILS_FROM_HOURS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Check this option, when hours are enabled, if you want for days details to be updated (calculated) from hours details or disable it if you want to have complete control of day details.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn Stunden aktiviert sind, wenn Sie möchten, dass die Tagesdetails aus den Stundendetails aktualisiert (berechnet) werden, oder deaktivieren Sie sie, wenn Sie die vollständige Kontrolle über die Tagesdetails haben möchten.', // !
                                        'es' => 'Valor por defecto: Activado. Marque esta opción, cuando las horas están habilitadas, si desea que los detalles de los días sean actualizados (calculados) de los detalles de las horas o inhabilitarlos si desea tener el control completo de los detalles del día.', //!
                                        'fr' => 'Valeur par défaut : Activé. Cochez cette option, lorsque les heures sont activées, si vous voulez que les détails des jours soient mis à jour (calculés) à partir des détails des heures ou désactivez-le si vous voulez avoir le contrôle complet des détails des jours.')); //!
                /*
                 * Hours settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Enable hours for the calendar.',
                                        'de' => 'Standardwert: Deaktiviert. Stunden für den Kalender aktivieren.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Habilitar horas para el calendario.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Activer les heures pour le calendrier.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_INFO_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Display hours info when you hover a day in calendar.',
                                        'de' => 'Standardwert: Aktiviert. Zeigen Sie die Stundeninformationen an, wenn Sie den Mauszeiger über einen Tag im Kalender halten.', // !
                                        'es' => 'Valor predeterminado: Activado. Mostrar información de horas cuando pasa un día en el calendario.', //!
                                        'fr' => 'Valeur par défaut : Activé. Afficher les heures d<<single-quote>>information lorsque vous passez un jour dans le calendrier.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_DEFINITIONS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Enter hh:mm ... add one per line. Changing the definitions will overwrite any previous hours data. Use only 24 hours format.',
                                        'de' => 'Geben Sie hh:mm ein ... fügen Sie eine pro Zeile hinzu. Wenn Sie die Definitionen ändern, werden alle Daten der vorherigen Stunden überschrieben. Verwenden Sie nur das 24-Stunden-Format.', // !
                                        'es' => 'Introduzca hh:mm ... añada uno por línea. Cambiar las definiciones sobreescribirá cualquier dato de horas anteriores. Utilice solamente el formato de 24 horas.', //!
                                        'fr' => 'Entrer hh:mm ... ajouter un par ligne. Changer les définitions écrasera toutes les données des heures précédentes. N<<single-quote>>utiliser que le format de 24 heures.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_MULTIPLE_SELECT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Use Start/Finish Hours or select only one hour.',
                                        'de' => 'Standardwert: Aktiviert. Verwenden Sie Start-/End Stunden, oder wählen Sie nur eine Stunde aus.', // !
                                        'es' => 'Valor predeterminado: Activado. Utilice Horas de Inicio/Finalización o seleccione sólo una hora.', //!
                                        'fr' => 'Valeur par défaut : Activé. Utilisez Heures de début/fin ou sélectionnez seulement une heure.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_AMPM_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Display hours in AM/PM format. NOTE: Hours definitions still need to be in 24 hours format.',
                                        'de' => 'Standardwert: Deaktiviert. Stunden im AM/PM-Format anzeigen. Hinweis: Die Stundendefinitionen müssen immer noch im 24-Stunden-Format vorliegen.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Horas de visualización en formato AM/PM. NOTA: Las definiciones de horas todavía tienen que estar en formato de 24 horas.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Affichage des heures en format AM/PM. REMARQUE : Les définitions des heures doivent toujours être en format 24 heures.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_ADD_LAST_HOUR_TO_TOTAL_PRICE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. It calculates the total price before the last hours selected if Disabled. It calculates the total price including the last hour selected if Enabled. <br /><br /><strong>Warning: </strong> In administration area the last hours from your definitions list will not be displayed.',
                                        'de' => 'Standardwert: Aktiviert. Er berechnet den Gesamtpreis vor den letzten Stunden, die bei Deaktiviert ausgewählt wurden. Er berechnet den Gesamtpreis einschließlich der letzten ausgewählten Stunde, sofern aktiviert. <br /><br /><strong>Warning: </strong> Im Administrationsbereich werden die letzten Stunden aus Ihrer Definitionsliste nicht angezeigt.', // !
                                        'es' => 'Valor predeterminado: Activado. Calcula el precio total antes de las últimas horas seleccionadas en caso de discapacidad. Calcula el precio total incluyendo la última hora seleccionada si está habilitado. <br /><br /><strong>Advertencia: /strong> En el área de administración no se mostrarán las últimas horas de su lista de definiciones.', //!
                                        'fr' => 'Valeur par défaut : Activé. Il calcule le prix total avant les dernières heures sélectionnées si désactivé. Il calcule le prix total incluant la dernière heure sélectionnée si Activé. <br /><br /><strong>Attention : </strong> Dans la zone d<<single-quote>>administration, les dernières heures de votre liste de définitions ne seront pas affichées.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_INTERVAL_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Show hours interval from the current hour to the next one.',
                                        'de' => 'Standardwert: Deaktiviert. Zeigt das Stundenintervall zwischen der aktuellen und der nächsten Stunde an.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Mostrar intervalo de horas de la hora actual a la siguiente.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Afficher l<<single-quote>>intervalle d<<single-quote>>heures de l<<single-quote>>heure courante à la prochaine.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_HOURS_INTERVAL_AUTOBREAK_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Put a break before each interval.Hours interval must be enabled.',
                                        'de' => 'Standardwert: Deaktiviert. Legen Sie vor jedem Intervall eine Pause ein. Das Stundenintervall muss aktiviert sein.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Ponga una pausa antes de cada intervalo.Horas debe estar habilitado.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Mettez une pause avant chaque intervalle.Hours doit être activé.')); //!
                /*
                 * Sidebar settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_SIDEBAR_STYLE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Set sidebar position and number of columns.',
                                        'de' => 'Festlegen der Position und Anzahl der Spalten in der Seitenleiste.', // !
                                        'es' => 'Establecer la posición lateral y el número de columnas.', //!
                                        'fr' => 'Définir la position de la barre latérale et le nombre de colonnes.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_SIDEBAR_NO_ITEMS_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Set to display number of items you want to book in front end.',
                                        'de' => 'Standardwert: Aktiviert. Stellen Sie diese Option ein, um die Anzahl der Elemente anzuzeigen, die im Front-End gebucht werden sollen', // !
                                        'es' => 'Valor predeterminado: Activado. Establecer para mostrar el número de artículos que desea reservar en el extremo frontal.', //!
                                        'fr' => 'Valeur par défaut : Activé. Défini pour afficher le nombre d<<single-quote>>articles que vous voulez réserver à l<<single-quote>>avant.')); //!
                /*
                 * Rules settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_RULES_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar rules.',
                                        'de' => 'Wählen Sie Kalenderregeln aus.', // !
                                        'es' => 'Seleccione reglas calendarias.', //!
                                        'fr' => 'Choisissez des règles de calendrier.')); //!
                /*
                 * Extras settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_EXTRAS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar extras.',
                                        'de' => 'Wählen Sie Kalender Extras aus.', // !
                                        'es' => 'Seleccione suplementos calendarios.', //!
                                        'fr' => 'Choisissez des dépenses supplémentaires de calendrier.')); //!
                /*
                 * Cart settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_CART_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Use a shopping cart in calendar.',
                                        'de' => 'Standardwert: Deaktiviert. Verwenden Sie einen Warenkorb im Kalender.', // !
                                        'es' => 'Default value: Disabled. Use a shopping cart in calendar.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Utilisez un panier dans le calendrier.')); //!
                /*
                 * Discounts settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DISCOUNTS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar discount.',
                                        'de' => 'Wählen Sie Kalenderrabatt.', // !
                                        'es' => 'Seleccione el descuento calendario.', //!
                                        'fr' => 'Choisissez la remise de calendrier.')); //!
                /*
                 * Taxes & fees settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_FEES_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar taxes and/or fees.',
                                        'de' => 'Wählen Sie Kalendersteuern und/oder -gebühren aus.', // !
                                        'es' => 'Seleccione los impuestos y/o tarifas del calendario.', //!
                                        'fr' => 'Sélectionnez les taxes et/ou frais du calendrier.')); //!
                /*
                 * Coupons settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_COUPONS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar coupons.',
                                        'de' => 'Wählen Sie Kalender coupons aus.', // !
                                        'es' => 'Seleccione cupones calendarios.', //!
                                        'fr' => 'Choisissez des coupons de calendrier.')); //!
                /*
                 * Deposit settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: 0. Set calendar deposit value.',
                                        'de' => 'Standardwert: 0. Legen Sie den Einzahlungswert für den Kalender fest.', // !
                                        'es' => 'Valor predeterminado: 0. Establecer el valor del depósito del calendario.', //!
                                        'fr' => 'Valeur par défaut : 0. Définir la valeur du dépôt dans le calendrier.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_TYPE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Percent. Set deposit value type.',
                                        'de' => 'Standardwert: Prozent. Einzahlungswerttyp festlegen.', // !
                                        'es' => 'Valor predeterminado: por ciento. Fije la calidad de valor de depósito.', //!
                                        'fr' => 'Valeur par défaut : Pourcentage. Définir le type de valeur du dépôt.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_PAY_FULL_AMOUNT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Enable Pay full amount option.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie die Option "Vollständigen Betrag zahlen".', // !
                                        'es' => 'Valor predeterminado: Activado. Activar opción Pagar cantidad completa.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activer l<<single-quote>>option Payer le plein montant.')); //!
                /*
                 * Forms settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_FORMS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar form.',
                                        'de' => 'Kalenderformular auswählen.', // !
                                        'es' => 'Seleccione la forma calendaria.', //!
                                        'fr' => 'Choisissez le formulaire de calendrier.')); //!
                /*
                 * Order settings help.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Enable Terms & Conditions check box.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie das Kontrollkästchen "Geschäftsbedingungen".', // !
                                        'es' => 'Valor predeterminado: Discapacitado. Habilite la casilla Términos y Condiciones.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Case à cocher Activer les modalités')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_LINK_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Enter the link to Terms & Conditions page.',
                                        'de' => 'Geben Sie den Link zur Seite "Geschäftsbedingungen" ein.', // !
                                        'es' => 'Introduzca el enlace a la página Términos y Condiciones.', //!
                                        'fr' => 'Entrez le lien vers la page Conditions générales.')); //!
                /*
                 * Google Calendar Sync settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Enable Google Calendar Sync.',
                                        'de' => 'Standardwert: Deaktiviert. Google Kalender Sync aktivieren.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Habilitar Google Calendar Sync.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Activer Google Calendar Sync.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_CLIENT_ID_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Enter Google Client ID.',
                                        'de' => 'Geben Sie die Google Kunden-ID ein.', // !
                                        'es' => 'Introduzca Google Client ID.', //!
                                        'fr' => 'Entrez Google Client ID.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_CLIENT_SECRET_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Enter Google Client secret.',
                                        'de' => 'Geben Sie den Geheimschlüssel für den Google-Kunden ein.', // !
                                        'es' => 'Escriba el secreto del cliente de Google.', //!
                                        'fr' => 'Entrez le secret du client Google.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_CALENDAR_ID_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Enter Google Calendar ID.',
                                        'de' => 'Geben Sie die Google Kalender-ID ein.', // !
                                        'es' => 'Introduzca el ID del calendario de Google.', //!
                                        'fr' => 'Entrez Google Calendar ID.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_FEED_URL_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Enter Google iCalendar feed URL.',
                                        'de' => 'Geben Sie die Google iCalendar-Feed-URL ein.', // !
                                        'es' => 'Introduzca la URL de alimentación de Google iCalendar.', //!
                                        'fr' => 'Entrez l<<single-quote>>URL du fil iCalendar de Google.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_SYNC_TIME_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Sync calendar at every x seconds.',
                                        'de' => 'Synchronisieren Sie den Kalender alle x Sekunden.', // !
                                        'es' => 'Calendario de sincronización cada x segundos.', //!
                                        'fr' => 'Synchroniser le calendrier toutes les x secondes.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_SYNC_TIMEOUT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Stop sync after x seconds if is not finished.',
                                        'de' => 'Beenden Sie die Synchronisierung nach x Sekunden, wenn nicht abgeschlossen ist.', // !
                                        'es' => 'Deje de sincronizar después de x segundos si no está terminado.', //!
                                        'fr' => 'Arrêter la synchronisation après x secondes si elle n<<single-quote>>est pas terminée.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_GOOGLE_CALENDAR_SYNC_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Synchronize',
                                        'de' => 'Synchronisieren', // !
                                        'es' => 'Sincronizar', //!
                                        'fr' => 'Synchroniser')); //!
                
                /*
                 * iCAL Sync settings.
                 */
                
                array_push($text, array('key' => 'SETTINGS_CALENDAR_ICAL_URL_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Copy the iCalendar URL and paste it in the import URL field.',
                                        'de' => 'Kopieren Sie die iCalendar-URL, und fügen Sie sie in das Feld "Import-URL" ein.', // !
                                        'es' => 'Copie la URL de iCalendar y péguela en el campo URL de importación', //!
                                        'fr' => 'Copiez l<<single-quote>>URL iCalendar et collez-la dans le champ URL d<<single-quote>>importation.')); //!
                /*
                 * Airbnb Sync settings.
                 */
                array_push($text, array('key' => 'SETTINGS_CALENDAR_AIRBNB_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Enable Airbnb Sync.',
                                        'de' => 'Standardwert: Deaktiviert. Airbnb Sync aktivieren.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Activar Airbnb Sync.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Activer Airbnb Sync.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_AIRBNB_FEED_URL_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Enter Airbnb ICAL feed URL.',
                                        'de' => 'Geben Sie die URL für den ICAL-Feed von Airbnb ein.', // !
                                        'es' => 'Introduzca la URL de alimentación ICAL de Airbnb.', //!
                                        'fr' => 'Entrez l<<single-quote>>URL du flux iCAL d<<single-quote>>Airbnb.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_AIRBNB_SYNC_TIME_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Sync calendar at every x seconds.',
                                        'de' => 'Synchronisieren Sie den Kalender alle x Sekunden.', // !
                                        'es' => 'Calendario de sincronización cada x segundos.', //!
                                        'fr' => 'Synchroniser le calendrier toutes les x secondes.')); //!
                array_push($text, array('key' => 'SETTINGS_CALENDAR_AIRBNB_SYNC_TIMEOUT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Stop sync after x seconds if is not finished.',
                                        'de' => 'Beenden Sie die Synchronisierung nach x Sekunden, wenn nicht abgeschlossen ist.', // !
                                        'es' => 'Deje de sincronizar después de x segundos si no está terminado.', //!
                                        'fr' => 'Arrêter la synchronisation après x secondes si elle n<<single-quote>>est pas terminée.')); //!
                
                return $text;
            }
            
            /*
             * Notifications settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsNotifications($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'parent' => '',
                                        'text' => 'Settings - Notifications'));
                
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TITLE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notifications',
                                        'de' => 'Benachrichtigungen', // !
                                        'es' => 'Notificaciones', //!
                                        'fr' => 'Notifications')); //!
                
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEMPLATES',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Email templates',
                                        'de' => 'E-Mail-Vorlagen', // !
                                        'es' => 'Plantillas de Email', //!
                                        'fr' => 'Modèles de courrier électronique')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_METHOD_ADMIN',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Admin notifications method',
                                        'de' => 'Methode für Administrator Benachrichtigungen', // !
                                        'es' => 'Método de notificaciones de admón', //!
                                        'fr' => 'Méthode de notifications d<<single-quote>>administration')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_METHOD_USER',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'User notifications method',
                                        'de' => 'Methode für Benutzerbenachrichtigungen', // !
                                        'es' => 'Método de notificaciones de usuario', //!
                                        'fr' => 'Méthode de notifications d<<single-quote>>utilisateur')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notifications email',
                                        'de' => 'Benachrichtigungen-E-Mail', // !
                                        'es' => 'Correo electrónico de notificaciones', //!
                                        'fr' => 'Courriel électronique de notification')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_ADMIN_EMAIL_SENDER',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Admin email sender',
                                        'de' => 'Administrator E-Mail-Absender', // !
                                        'es' => 'Remitente de correo electrónico de admón', //!
                                        'fr' => 'Expéditeur de courrier électronique d<<single-quote>>administration')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_REPLY',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Reply email',
                                        'de' => 'Antwort-E-Mail', // !
                                        'es' => 'Email de respuesta', //!
                                        'fr' => 'Courrier électronique de réponse')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_NAME',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Email name',
                                        'de' => 'E-Mail-Name', // !
                                        'es' => 'Nombre del email', //!
                                        'fr' => 'Nom de courrier électronique')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_CC',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notifications Cc email(s)',
                                        'de' => 'Benachrichtigungen Cc-E-Mail(en)', // !
                                        'es' => 'Notificaciones Cc email(s)', //!
                                        'fr' => 'Avis Cc courriel(s)')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_CC_NAME',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notifications Cc name(s)',
                                        'de' => 'Benachrichtigungen Cc-Name(n)', // !
                                        'es' => 'Notificaciones Cc nombre(s)', //!
                                        'fr' => 'Notifications Cc nom(s)')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_BCC',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notifications Bcc email(s)',
                                        'de' => 'Benachrichtigungen Bcc-E-Mail(en)', // !
                                        'es' => 'Notificaciones Bcc email(s)', //!
                                        'fr' => 'Avis Bcc email(s)')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_BCC_NAME',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notifications Bcc name(s)',
                                        'de' => 'Benachrichtigungen Bcc-Name(n)', // !
                                        'es' => 'Notificaciones Nombre(s) Bcc', //!
                                        'fr' => 'Notifications Nom(s) de la CB')); //!
                /*
                 * Send notifications.
                 */
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_TITLE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Enable notifications',
                                        'de' => 'Benachrichtigungen aktivieren', // !
                                        'es' => 'Permita notificaciones', //!
                                        'fr' => 'Permettez des notifications')); //!
                
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_ADMIN',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify admin on book request',
                                        'de' => 'Benachrichtigen Sie den Administrator auf Buchanfrage', // !
                                        'es' => 'Notificar a la administración a petición del libro', //!
                                        'fr' => 'Informer l<<single-quote>>administrateur sur demande de livre')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_USER',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify user on book request',
                                        'de' => 'Benutzer auf Buchanfrage benachrichtigen', // !
                                        'es' => 'Notificar al usuario a petición del libro', //!
                                        'fr' => 'Notifier l<<single-quote>>utilisateur sur demande de livre')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_ADMIN',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify admin on approved book request',
                                        'de' => 'Administrator bei genehmigter Buchanforderung benachrichtigen', // !
                                        'es' => 'Notificar a admin sobre solicitud de libro aprobada', //!
                                        'fr' => 'Informer l<<single-quote>>administration de la demande de livre approuvée')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_USER',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify user on approved book request',
                                        'de' => 'Benutzer bei genehmigter Buchanforderung benachrichtigen', // !
                                        'es' => 'Notificar al usuario sobre la solicitud de libro aprobada', //!
                                        'fr' => 'Informer l<<single-quote>>utilisateur de la demande de livre approuvée')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_APPROVED',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify user when reservation is approved',
                                        'de' => 'Benutzer benachrichtigen, wenn Reservierung genehmigt wurde', // !
                                        'es' => 'Notificar al usuario cuando la reserva es aprobada', //!
                                        'fr' => 'Informer l<<single-quote>>utilisateur lorsque la réservation est approuvée')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_CANCELED',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify user when reservation is canceled',
                                        'de' => 'Benutzer benachrichtigen, wenn Reservierung storniert wird', // !
                                        'es' => 'Notificar al usuario cuando se cancela la reserva', //!
                                        'fr' => 'Informer l<<single-quote>>utilisateur lorsque la réservation est annulée')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_REJECTED',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify user when reservation is rejected',
                                        'de' => 'Benutzer benachrichtigen, wenn Reservierung abgelehnt wird', // !
                                        'es' => 'Notificar al usuario cuando la reserva es rechazada', //!
                                        'fr' => 'Informer l<<single-quote>>utilisateur lorsque la réservation est rejetée')); //!
                /*
                 * SMTP settings.
                 */
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_TITLE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP settings',
                                        'de' => 'SMTP-Einstellungen', // !
                                        'es' => 'SMTP ajustes', //!
                                        'fr' => 'Paramètres de SMTP')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_SECOND_TITLE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Second SMTP settings',
                                        'de' => 'Zweite SMTP-Einstellungen', // !
                                        'es' => 'Segundo SMTP ajustes', //!
                                        'fr' => 'Deuxièmes paramètres de SMTP')); //!
                
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_HOST_NAME',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP host name',
                                        'de' => 'SMTP-Hostnamen', // !
                                        'es' => 'SMTP reciben el nombre', //!
                                        'fr' => 'Nom d<<single-quote>>hôte de SMTP')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_HOST_PORT',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP host port',
                                        'de' => 'SMTP-Host-Port', // !
                                        'es' => 'SMTP reciben el puerto', //!
                                        'fr' => 'Port d<<single-quote>>hôte de SMTP')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_SSL',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP SSL connection',
                                        'de' => 'SMTP-SSL-Verbindung', // !
                                        'es' => 'SMTP SSL conexión', //!
                                        'fr' => 'SMTP SSL connexion')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_TLS',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP TLS connection',
                                        'de' => 'SMTP-TLS-Verbindung', // !
                                        'es' => 'SMTP TLS conexión', //!
                                        'fr' => 'SMTP connexion TLS')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_USER',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP host user',
                                        'de' => 'SMTP-Host-Benutzer', // !
                                        'es' => 'SMTP reciben al usuario', //!
                                        'fr' => 'Utilisateur d<<single-quote>>hôte de SMTP')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_PASSWORD',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP host password',
                                        'de' => 'SMTP-Host-Kennwort', // !
                                        'es' => 'SMTP reciben la contraseña', //!
                                        'fr' => 'Mot de passe d<<single-quote>>hôte de SMTP')); //!
                /*
                 * Test
                 */
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_TITLE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Test notification methods',
                                        'de' => 'Test Benachrichtigung Methoden', // !
                                        'es' => 'Métodos de notificación de prueba', //!
                                        'fr' => 'Méthodes de notification de test')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_METHOD',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Select notifications method',
                                        'de' => 'Wählen Sie die Benachrichtigungsmethode aus', // !
                                        'es' => 'Seleccione el método de notificaciones', //!
                                        'fr' => 'Choisissez la méthode de notifications')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_EMAIL',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Test email',
                                        'de' => 'Test-E-Mail', // !
                                        'es' => 'Email de prueba', //!
                                        'fr' => 'Courrier électronique de test')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_SUBMIT',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Send test',
                                        'de' => 'Test senden', // !
                                        'es' => 'Envíe prueba', //!
                                        'fr' => 'Envoyez le test')); //!
                
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_SENDING',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Sending notification test email ...',
                                        'de' => 'E-Mail für Benachrichtigungstest wird gesendet...', // !
                                        'es' => 'Envío de notificaciones por correo electrónico ...', //!
                                        'fr' => 'Envoi d<<single-quote>>un email de test de notification...')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_SUCCESS',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notification test email has been sent.',
                                        'de' => 'E-Mail für Benachrichtigungstest wurde gesendet.', // !
                                        'es' => 'Se ha enviado un correo electrónico de notificación.', //!
                                        'es' => 'Le courriel du test de notification a été envoyé.', //!
                                        'fr' => 'Le courriel du test de notification a été envoyé.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_ERROR',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notification test email could not be sent.',
                                        'de' => 'E-Mail für Benachrichtigungstest konnte nicht gesendet werden.', // !
                                        'es' => 'Notificación de correo electrónico de prueba no se pudo enviar.', //!
                                        'fr' => 'Le courriel du test de notification n<<single-quote>>a pas pu être envoyé.')); //!
                
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_MAIL_SUBJECT',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Pinpoint Booking System - PHP mail notification test',
                                        'de' => 'Pinpoint Buchungssystem - PHP-Mail Benachrichtigung Test', // !
                                        'es' => 'Pinpoint Booking System - Prueba de notificación de correo PHP', //!
                                        'fr' => 'Pinpoint Booking System - Test de notification de courrier PHP')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_MAIL_MESSAGE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Pinpoint Booking System notification test sent with PHP mail function.',
                                        'de' => 'Pinpoint Buchungssystem - Benachrichtigung Test mit PHP-Mail-Funktion gesendet.', // !
                                        'es' => 'Ensayo de notificación del sistema de reservas con la función de correo PHP.', //!
                                        'fr' => 'Test de notification Pinpoint Booking System envoyé avec la fonction de messagerie PHP.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_MAILER_SUBJECT',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Pinpoint Booking System - PHPMailer notification test',
                                        'de' => 'Pinpoint Buchungssystem - PHPmailer Benachrichtigung Test', // !
                                        'es' => 'Pinpoint Booking System - prueba de notificación de phpmailer', //!
                                        'fr' => 'Pinpoint Booking System - Test de notification Phpmailer')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_MAILER_MESSAGE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Pinpoint Booking System notification test sent with PHPMailer class.',
                                        'de' => 'Pinpoint Buchungssystem - Benachrichtigung Test mit PHPmailer-Klasse gesendet.', // !
                                        'es' => 'Ensayo de notificación del sistema de reservas con clase phpmailer.', //!
                                        'fr' => 'Test de notification Pinpoint Booking System envoyé avec la classe Phpmailer.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_SMTP_SUBJECT',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Pinpoint Booking System - SMTP notification test',
                                        'de' => 'Pinpoint Buchungssystem - SMPT Benachrichtigung Test', // !
                                        'es' => 'Sistema de Reservas - Prueba de notificación SMTP', //!
                                        'fr' => 'Système de réservation Pinpoint - test de notification SMTP')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_SMTP_MESSAGE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Pinpoint Booking System notification test sent with PHPMailer SMTP.',
                                        'de' => 'Pinpoint Buchungssystem - Benachrichtigung Test mit PHPmailer-SMTP gesendet.', // !
                                        'es' => 'Ensayo de notificación del sistema de reservas con phpmailer SMTP.', //!
                                        'fr' => 'Test de notification Pinpoint Booking System envoyé avec Phpmailer SMTP.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_SMTP2_SUBJECT',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Pinpoint Booking System - Second SMTP notification test',
                                        'de' => 'Pinpoint Buchungssystem - Zweiter SMTP-Benachrichtigung Test', // !
                                        'es' => 'Sistema de Reservas Pinpoint - Segunda prueba de notificación SMTP', //!
                                        'fr' => 'Système de réservation Pinpoint - Deuxième test de notification SMTP')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_SMTP2_MESSAGE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Pinpoint Booking System notification test sent with second SMTP.',
                                        'de' => 'Pinpoint Buchungssystem - Benachrichtigung Test mit zweitem SMTP gesendet.', // !
                                        'es' => 'Ensayo de notificación del sistema de reservas Pinpoint con el segundo SMTP.', //!
                                        'fr' => 'Test de notification Pinpoint Booking System envoyé avec le second SMTP.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_WP_SUBJECT',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Pinpoint Booking System - WordPress mail notification test',
                                        'de' => 'Pinpoint Buchungssystem - WordPress E-Mail Benachrichtigung Test', // !
                                        'es' => 'Sistema de Reservas Pinpoint - Prueba de notificación de correo de WordPress', //!
                                        'fr' => 'Pinpoint Booking System - Test de notification de mail Wordpress')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_WP_MESSAGE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Pinpoint Booking System notification test sent with WordPress mail function.',
                                        'de' => 'Pinpoint Buchungssystem - Benachrichtigung Test mit WordPress Mail Funktion gesendet.', // !
                                        'es' => 'Sistema de Reservas Pinpoint - notification test sent with WordPress mail function.', //!
                                        'fr' => 'Pinpoint Booking System notification test envoyé avec la fonction de messagerie Wordpress.')); //!
                
                /*
                 * SMS notifications - Clickatell.com
                 */                
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_TITLE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMS notifications - Clickatell.com',
                                        'de' => 'SMS-Benachrichtigungen - Clickatell.com', // !
                                        'es' => 'Notificaciones SMS - Clickatell.com', //!
                                        'fr' => 'Notifications par SMS - Clickatell.com')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_ACCOUNT_TYPE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Account type',
                                        'de' => 'Kontotyp', // !
                                        'es' => 'Tipo de cuenta', //!
                                        'fr' => 'Type de compte')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_USERNAME',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Username',
                                        'de' => 'Benutzername', // !
                                        'es' => 'Nombre de usuario', //!
                                        'fr' => 'Nom d<<single-quote>>utilisateur')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_PASSWORD',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Password',
                                        'de' => 'Kennwort', // !
                                        'es' => 'Contraseña', //!
                                        'fr' => 'Mot de passe')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_API_ID',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'API',
                                        'de' => 'API', // !
                                        'es' => 'API', //!
                                        'fr' => 'API')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_FROM',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'From',
                                        'de' => 'Von', // !
                                        'es' => 'De', //!
                                        'fr' => 'De')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_ADMIN_PHONE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notifications phone',
                                        'de' => 'Benachrichtigung Telefon', // !
                                        'es' => 'Teléfono de notificaciones', //!
                                        'fr' => 'Téléphone de notifications')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_TEMPLATES',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMS templates',
                                        'de' => 'SMS-Vorlagen', // !
                                        'es' => 'Plantillas de SMS', //!
                                        'fr' => 'Modèles SMS')); //!
                
                
                
                return $text;
            }
            
            /*
             * Notifications settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsNotificationsHelp($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Notifications - Help'));
                
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEMPLATES_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Select email templates.',
                                        'de' => 'Wählen Sie E-Mail-Vorlagen aus.', // !
                                        'es' => 'Seleccione plantillas de email.', //!
                                        'fr' => 'Choisissez des modèles de courrier électronique.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_METHOD_ADMIN_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Select notifications method used to send emails to admins. You can use PHP mail function, PHPMailer class, SMTP, second SMTP or WordPress wp_mail function.',
                                        'de' => 'Wählen Sie die Benachrichtigung methode aus, die zum Senden von E-Mails an Administratoren verwendet wird. Sie können PHP Mail Funktion, PHPmailer Klasse, SMTP, zweite SMTP oder WordPress wp_mail Funktion.', // !
                                        'es' => 'Seleccione el método de notificaciones utilizado para enviar emails a los administradores. Puede utilizar la función de correo PHP, clase phpmailer, SMTP, segunda función SMTP o wp_mail de WordPress.', //!
                                        'fr' => 'Sélectionnez la méthode de notification utilisée pour envoyer des courriels aux administrateurs. Vous pouvez utiliser PHP mail function, Phpmailer class, SMTP, second SMTP ou Wordpress wp_mail function.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_METHOD_USER_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Select notifications method used to send emails to users. You can use PHP mail function, PHPMailer class, SMTP, second SMTP or WordPress wp_mail function.',
                                        'de' => 'Wählen Sie die Benachrichtigung methode aus, die zum Senden von E-Mails an Benutzer verwendet wird.. Sie können PHP Mail Funktion, PHPmailer Klasse, SMTP,  zweite SMTP oder WordPress wp_mail Funktion.', // !
                                        'es' => 'Seleccione el método de notificaciones utilizado para enviar correos electrónicos a los usuarios. Puede utilizar la función de correo PHP, clase phpmailer, SMTP, segunda función SMTP o wp_mail de WordPress.', //!
                                        'fr' => 'Sélectionnez la méthode de notification utilisée pour envoyer des courriels aux utilisateurs. Vous pouvez utiliser PHP mail function, Phpmailer class, SMTP, second SMTP ou Wordpress wp_mail function.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter the email where you will be notified about booking requests or you will use to notify users. Enter other emails that will be notified in Cc & Bcc fields.',
                                        'de' => 'Geben Sie die E-Mail-Adresse ein, über die Sie über Buchungsanfragen benachrichtigt werden, oder verwenden Sie, um Benutzer zu benachrichtigen. Geben Sie weitere E-Mails ein, die in den Feldern Cc und Bcc benachrichtigt werden.', // !
                                        'es' => 'Introduzca el correo electrónico donde se le notificará acerca de las solicitudes de reserva o se utilizará para notificar a los usuarios. Introduzca otros correos electrónicos que serán notificados en los campos Cc & Bcc.', //!
                                        'fr' => 'Saisissez le courriel où vous serez informé des demandes de réservation ou que vous utiliserez pour informer les utilisateurs. Entrez les autres courriels qui seront notifiés dans les champs Cc et Bcc.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_REPLY_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter the reply email that will appear in the email the user will receive.',
                                        'de' => 'Geben Sie die Antwort-E-Mail ein, die in der E-Mail angezeigt wird, die der Benutzer erhält.', // !
                                        'es' => 'Introduzca el email de respuesta que aparecerá en el email que el usuario recibirá.', //!
                                        'fr' => 'Entrez le courriel de réponse qui apparaîtra dans le courriel que l<<single-quote>>utilisateur recevra.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_ADMIN_EMAIL_SENDER_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Add the same email (or a different one) as for admin in order to create a filter in your webclient. Recommended if your notifications end up in the spam folder.',
                                        'de' => 'Fügen Sie die gleiche E-Mail (oder eine andere) wie für admin hinzu, um einen Filter in Ihrem Webclient zu erstellen. Empfohlen, wenn Ihre Benachrichtigungen im Spam-Ordner landen.', // !
                                        'es' => 'Añada el mismo correo electrónico (o uno diferente) que admin para crear un filtro en su cliente web. Recomendado si sus notificaciones terminan en la carpeta de spam.', //!
                                        'fr' => 'Ajoutez le même courrier électronique  (ou un autre) que pour admin afin de créer un filtre dans votre webclient. Recommandé si vos notifications aboutissent dans le dossier spam.')); //!             
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_NAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter the name that will appear in the email the user will receive.',
                                        'de' => 'Geben Sie den Namen ein, der in der E-Mail angezeigt wird, die der Benutzer erhält.', // !
                                        'es' => 'Introduzca el nombre que aparecerá en el correo electrónico que recibirá el usuario.', //!
                                        'fr' => 'Entrez le nom qui apparaîtra dans le courriel que l<<single-quote>>utilisateur recevra.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_CC_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter the email(s) for Cc field, where others be notified about booking requests or they will use to notify users. Add an email per line.',
                                        'de' => 'Geben Sie die E-Mail-Adresse(n) für das Feld Cc ein, in der andere über Buchungsanfragen benachrichtigt werden oder die Benutzer benachrichtigen sollen. Fügen Sie eine E-Mail pro Zeile hinzu.', // !
                                        'es' => 'Introduzca el email(s) para el campo Cc, donde otras personas serán notificadas acerca de las solicitudes de reserva o usarán para notificar a los usuarios. Agregue un correo electrónico por línea.', //!
                                        'fr' => 'Entrez le ou les courriels dans le champ Cc, où d<<single-quote>>autres personnes sont avisées des demandes de réservation ou qu<<single-quote>>elles utiliseront pour informer les utilisateurs. Ajoutez un courriel par ligne.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_CC_NAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter the name(s) for Cc field, equivalent to Cc email(s). Add a name per line, like emails.',
                                        'de' => 'Geben Sie den/die Name(n) für das Feld Cc ein, der/die Cc-E-Mail entspricht. Fügen Sie einen Namen pro Zeile hinzu.', // !
                                        'es' => 'Introduzca el nombre(s) para el campo Cc, equivalente a Cc email(s). Agregue un nombre por línea, como correos electrónicos.', //!
                                        'fr' => 'Entrez le ou les nom(s) du champ Cc, équivalent au ou aux courriels Cc. Ajoutez un nom par ligne, comme les courriels.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_BCC_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter the email(s) for Bcc field, where others be notified about booking requests or they will use to notify users. Add an email per line.',
                                        'de' => 'Geben Sie die E-Mail-Adresse(n) für das Feld Bcc ein, in der andere über Buchungsanfragen benachrichtigt werden oder die Benutzer benachrichtigen sollen. Fügen Sie eine E-Mail pro Zeile hinzu.', // !
                                        'es' => 'Introduzca el email(s) para el campo Bcc, donde otros serán notificados acerca de las solicitudes de reserva o usarán para notificar a los usuarios. Agregue un email por línea.', //!
                                        'fr' => 'Entrez le ou les courriels dans le champ Bcc, où d<<single-quote>>autres personnes sont avisées des demandes de réservation ou qu<<single-quote>>elles utiliseront pour informer les utilisateurs. Ajoutez un courriel par ligne.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_BCC_NAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter the name(s) for Bcc field, equivalent to Bcc email(s). Add a name per line, like emails.',
                                        'de' => 'Geben Sie den/die Name(n) für das Feld Bcc ein, der/die Bcc-E-Mail-Adresse(n) entspricht. Fügen Sie einen Namen pro Zeile hinzu.', // !
                                        'es' => 'Introduzca el nombre(s) para el campo Bcc, equivalente a Bcc email(s). Agregue un nombre por línea, como correos electrónicos.', //!
                                        'fr' => 'Entrez le ou les nom(s) du champ Bcc, équivalent au ou aux courriels Bcc. Ajoutez un nom par ligne, comme les courriels.')); //!
                /*
                 * Send notifications.
                 */
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_ADMIN_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to admin on book request.',
                                        'de' => 'Aktivieren Sie diese Option, um eine E-Mail-Benachrichtigung an den Administrator auf Buchanforderung zu senden.', // !
                                        'es' => 'Habilitar para enviar una notificación por correo electrónico a la administración a petición del libro.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification par email à l<<single-quote>>administrateur sur demande de livre.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_USER_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to user on book request.',
                                        'de' => 'Aktivieren Sie diese Option, um eine E-Mail-Benachrichtigung an den Benutzer auf Buchanforderung zu senden.', // !
                                        'es' => 'Permite enviar una notificación por correo electrónico al usuario a petición del libro.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer un email de notification à l<<single-quote>>utilisateur sur demande de livre.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_ADMIN_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to admin on book request and reservation is approved.',
                                        'de' => 'Aktivieren Sie diese Option, um eine E-Mail-Benachrichtigung an den Administrator auf Buchungsanfrage zu senden, und die Reservierung wird genehmigt.', // !
                                        'es' => 'Habilitar para enviar una notificación por correo electrónico a la administración en la solicitud de libro y la reserva está aprobada.', //!
                                        'fr' => 'Permettre d<<single-quote>>envoyer un avis par courriel à l<<single-quote>>administration sur demande de réservation et la réservation est approuvée.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_USER_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to user on book request and reservation is approved.',
                                        'de' => 'Ermöglicht das Senden einer E-Mail-Benachrichtigung an den Benutzer auf Buchungsanfrage, und die Reservierung wird genehmigt.', // !
                                        'es' => 'Habilitar para enviar una notificación por correo electrónico al usuario en la solicitud de libro y la reserva está aprobada.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification par email à l<<single-quote>>utilisateur sur demande de réservation et la réservation est approuvée.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_APPROVED_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to user when reservation is approved.',
                                        'de' => 'Aktivieren Sie diese Option, um eine E-Mail-Benachrichtigung an den Benutzer zu senden, wenn die Reservierung genehmigt wurde.', // !
                                        'es' => 'Permite enviar una notificación por correo electrónico al usuario cuando se aprueba la reserva.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification par email à l<<single-quote>>utilisateur lorsque la réservation est approuvée.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_CANCELED_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to user when reservation is canceled.',
                                        'de' => 'Aktivieren Sie diese Option, um eine E-Mail-Benachrichtigung an den Benutzer zu senden, wenn die Reservierung storniert wird.', // !
                                        'es' => 'Permite enviar una notificación por correo electrónico al usuario cuando se cancela la reserva.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification par email à l<<single-quote>>utilisateur lorsque la réservation est annulée.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_REJECTED_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to user when reservation is rejected.',
                                        'de' => 'Aktivieren Sie diese Option, um eine E-Mail-Benachrichtigung an den Benutzer zu senden, wenn die Reservierung abgelehnt wird.', // !
                                        'es' => 'Permite enviar una notificación por correo electrónico al usuario cuando la reserva es rechazada.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification par email à l<<single-quote>>utilisateur lorsque la réservation est rejetée.')); //!
                /*
                 * SMTP
                 */
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_HOST_NAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter SMTP host name.',
                                        'de' => 'Geben Sie den SMTP-Hostnamen ein.', // !
                                        'es' => 'Introduzca el nombre del host SMTP.', //!
                                        'fr' => 'Entrez le nom d<<single-quote>>hôte SMTP.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_HOST_PORT_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter SMTP host port.',
                                        'de' => 'Geben Sie den SMTP-Host-Port ein.', // !
                                        'es' => 'Introduzca el puerto host SMTP.', //!
                                        'fr' => 'Entrez le port hôte SMTP.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_SSL_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Use a  SSL connection.',
                                        'de' => 'Verwenden Sie eine SSL-Verbindung.', // !
                                        'es' => 'Utilice una conexión SSL.', //!
                                        'fr' => 'Utilisez une connexion SSL.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_TLS_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Use a TLS connection.',
                                        'de' => 'Verwenden Sie eine TLS-Verbindung.', // !
                                        'es' => 'Utilice una conexión TLS.', //!
                                        'fr' => 'Utilisez une connexion TLS.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_USER_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter SMTP host username.',
                                        'de' => 'Geben Sie den SMTP-Host-Benutzernamen ein.', // !
                                        'es' => 'Introduzca el nombre de usuario del host SMTP.', //!
                                        'fr' => 'Entrez le nom d<<single-quote>>utilisateur de l<<single-quote>>hôte SMTP.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_PASSWORD_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter SMTP host password.',
                                        'de' => 'Geben Sie das SMTP-Host-Kennwort ein.', // !
                                        'es' => 'Introduzca la contraseña del host SMTP.', //!
                                        'fr' => 'Saisissez le mot de passe hôte SMTP.')); //!
                /*
                 * Test
                 */
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_METHOD_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Select the notifications method for which the test will be performed.',
                                        'de' => 'Wählen Sie die Benachrichtigung methode aus, für die der Test durchgeführt werden soll.', // !
                                        'es' => 'Seleccione el método de notificaciones para el que se realizará el ensayo.', //!
                                        'fr' => 'Sélectionnez la méthode de notification pour laquelle le test sera effectué.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_TEST_EMAIL_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Enter the email to which the test notification will be sent.',
                                        'de' => 'Geben Sie die E-Mail ein, an die die Testbenachrichtigung gesendet werden soll.', // !
                                        'es' => 'Introduzca el correo electrónico al que se enviará la notificación de prueba.', //!
                                        'fr' => 'Entrez le courriel auquel la notification de test sera envoyée.')); //!
                
                /*
                 * SMS notifications - Clickatell.com
                 */
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_ACCOUNT_TYPE_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Select the type of account you own on clickatell.com.',
                                        'de' => 'Wählen Sie den Kontotyp aus, den Sie besitzen auf clickatell.com', // !
                                        'es' => 'Seleccione el tipo de cuenta que posee en Clickatell.com.', //!
                                        'fr' => 'Sélectionnez le type de compte que vous possédez sur clickatell.com.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_USERNAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Enter the username from clickatell.com. Mandatory for Central type accounts.',
                                        'de' => 'Geben Sie den Benutzernamen von clickatell.com. Obligatorisch für Konten des Typs "Zentrale".', // !
                                        'es' => 'Introduzca el nombre de usuario de Clickatell.com. Obligatorio para cuentas de tipo Central.', //!
                                        'fr' => 'Entrez le nom d<<single-quote>>utilisateur de clickatell.com. Obligatoire pour les comptes de type central.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_PASSWORD_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Enter the password from clickatell.com. Mandatory for Central type accounts.',
                                        'de' => 'Geben Sie den Kennwort von clickatell.com. Obligatorisch für Konten des Typs "Zentrale".', // !
                                        'es' => 'Introduzca la contraseña de Clickatell.com. Obligatorio para cuentas de tipo Central.', //!
                                        'fr' => 'Entrez le mot de passe de clickatell.com. Obligatoire pour les comptes de type central.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_API_ID_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Enter the API ID for Central accounts or API Key for Platform (from clickatell.com). Mandatory',
                                        'de' => 'Geben Sie die API-ID für Zentrale Konten oder den API-Schlüssel für Plattform (von clickatell.com). Obligatorisch', // !
                                        'es' => 'Introduzca el ID de la API para cuentas centrales o clave de la API para la plataforma (de Clickatell.com).', //!
                                        'fr' => 'Entrez l<<single-quote>>ID de l<<single-quote>>API pour les comptes centraux ou la clé de l<<single-quote>>API pour la plateforme (à partir de clickatell.com). Obligatoire')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_FROM_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Enter the text from message header.',
                                        'de' => 'Geben Sie den Text aus dem Nachrichtenkopf ein.', // !
                                        'es' => 'Introduzca el texto desde el encabezado del mensaje.', //!
                                        'fr' => 'Entrez le texte de l<<single-quote>>en-tête du message.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_ADMIN_PHONE_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Enter the admin phone.',
                                        'de' => 'Geben Sie das Admin-Telefon ein.', // !
                                        'es' => 'Entra al teléfono administrativo.', //!
                                        'fr' => 'Entrez le téléphone de l<<single-quote>>administration.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_ADMIN_PHONE_ADD_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Add phone number.',
                                        'de' => 'Telefonnummer hinzufügen.', // !
                                        'es' => 'Añada el número de teléfono.', //!
                                        'fr' => 'Ajoutez le numéro de téléphone.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_CLICKATELL_TEMPLATES_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMS templates',
                                        'de' => 'SMS-Vorlagen', // !
                                        'es' => 'Plantillas de SMS', //!
                                        'fr' => 'Modèles SMS')); //!

                /*
                 * Send notifications.
                 */
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_SEND_BOOK_ADMIN_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an SMS notification to admin on book request.',
                                        'de' => 'Aktivieren Sie diese Option, um eine SMS-Benachrichtigung an den Administrator auf Buchanforderung zu senden.', // !
                                        'es' => 'Posibilidad de enviar una notificación SMS a la administración a petición del libro.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification SMS à l<<single-quote>>administrateur sur demande de livre.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_SEND_BOOK_USER_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an SMS notification to user on book request.',
                                        'de' => 'Aktivieren Sie diese Option, um eine SMS-Benachrichtigung an den Benutzer auf Buchanforderung zu senden.', // !
                                        'es' => 'Permite enviar una notificación SMS al usuario a petición del libro.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification SMS à l<<single-quote>>utilisateur sur demande de livre.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_SEND_BOOK_WITH_APPROVAL_ADMIN_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an SMS notification to admin on book request and reservation is approved.',
                                        'de' => 'Aktivieren Sie diese Option, um eine SMS-Benachrichtigung an den Administrator auf Buchungsanfrage zu senden, und die Reservierung wird genehmigt.', // !
                                        'es' => 'Habilitar para enviar una notificación de SMS a la administración en la solicitud de libro y la reserva está aprobada.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification SMS à l<<single-quote>>administration sur demande de réservation et la réservation est approuvée.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_SEND_BOOK_WITH_APPROVAL_USER_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an SMS notification to user on book request and reservation is approved.',
                                        'de' => 'Ermöglicht das Senden einer SMS-Benachrichtigung an den Benutzer auf Buchungsanfrage, und die Reservierung wird genehmigt.', // !
                                        'es' => 'Habilitar para enviar una notificación de SMS al usuario a petición de libro y la reserva está aprobada.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification SMS à l<<single-quote>>utilisateur sur demande de réservation et la réservation est approuvée.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_SEND_APPROVED_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an SMS notification to user when reservation is approved.',
                                        'de' => 'Aktivieren Sie diese Option, um eine SMS-Benachrichtigung an den Benutzer zu senden, wenn die Reservierung genehmigt wurde.', // !
                                        'es' => 'Permite enviar una notificación de SMS al usuario cuando la reserva es aprobada.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification SMS à l<<single-quote>>utilisateur lorsque la réservation est approuvée.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_SEND_CANCELED_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an SMS notification to user when reservation is canceled.',
                                        'de' => 'Aktivieren Sie diese Option, um eine SMS-Benachrichtigung an den Benutzer zu senden, wenn die Reservierung storniert wird.', // !
                                        'es' => 'Permite enviar una notificación de SMS al usuario cuando se cancela la reserva.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification SMS à l<<single-quote>>utilisateur lorsque la réservation est annulée.')); //!
                array_push($text, array('key' => 'SETTINGS_NOTIFICATIONS_SMS_SEND_REJECTED_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an SMS notification to user when reservation is rejected.',
                                        'de' => 'Aktivieren Sie diese Option, um eine SMS-Benachrichtigung an den Benutzer zu senden, wenn die Reservierung abgelehnt wird.', // !
                                        'es' => 'Permite enviar una notificación SMS al usuario cuando la reserva es rechazada.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification SMS à l<<single-quote>>utilisateur lorsque la réservation est rejetée.')); //!
                
                return $text;
            }
            
            /*
             * Payment gateways settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsPaymentGateways($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'parent' => '',
                                        'text' => 'Settings - Payment gateways'));
                
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_TITLE',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Payment gateways',
                                        'de' => 'Zahlungs-Gateways', // !
                                        'es' => 'pasarelas de pago', //!
                                        'fr' => 'Passerelles de paiement')); //!
                
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Enable payment on arrival',
                                        'de' => 'Aktivieren Sie die Zahlung bei Ankunft', // !
                                        'es' => 'Habilitar el pago a la llegada', //!
                                        'fr' => 'Permettre le paiement à l<<single-quote>>arrivée')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_WITH_APPROVAL_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Enable instant approval',
                                        'de' => 'Sofortige Genehmigung aktivieren', // !
                                        'es' => 'Permita la aprobación inmediata', //!
                                        'fr' => 'Permettez l<<single-quote>>approbation instantanée')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_REDIRECT',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Redirect after book',
                                        'de' => 'Umleitung nach der Buchung', // !
                                        'es' => 'Remita después de la reserva', //!
                                        'fr' => 'Faites suivre après la réservation')); //!
                
                /*
                 * Add-ons redirection
                 */
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDONS_REDIRECT',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'If you need more payment options please visit the',
                                        'de' => 'Wenn Sie weitere Zahlungsmöglichkeiten benötigen, besuchen Sie bitte die', // !
                                        'es' => 'Si necesita más opciones de pago por favor visite el', //!
                                        'fr' => 'Si vous avez besoin de plus d<<single-quote>>options de paiement s<<single-quote>>il vous plaît visitez le')); //!
                
                /*
                 * Billing address.
                 */
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Billing address',
                                        'de' => 'Rechnungsadresse', // !
                                        'es' => 'Dirección de facturación', //!
                                        'fr' => 'Adresse de facturation')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Enable billing address',
                                        'de' => 'Rechnungsadresse aktivieren', // !
                                        'es' => 'Permita la dirección de facturación', //!
                                        'fr' => 'Permettez l<<single-quote>>adresse de facturation')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_FIRST_NAME_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'First name (enable)',
                                        'de' => 'Vorname (aktivieren)', // !
                                        'es' => 'El nombre de pila (permite)', //!
                                        'fr' => 'Le prénom (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_FIRST_NAME_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'First name (required)',
                                        'de' => 'Vorname (erforderlich)', // !
                                        'es' => 'Nombre de pila (requerido)', //!
                                        'fr' => 'Prénom (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_LAST_NAME_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Last name (enable)',
                                        'de' => 'Nachname (aktivieren)', // !
                                        'es' => 'El apellido (permite)', //!
                                        'fr' => 'Le nom (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_LAST_NAME_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Last name (required)',
                                        'de' => 'Nachname (erforderlich)', // !
                                        'es' => 'Apellido (requerido)', //!
                                        'fr' => 'Nom (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COMPANY_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Company (enable)',
                                        'de' => 'Unternehmen (aktivieren)', // !
                                        'es' => 'La empresa (permite)', //!
                                        'fr' => 'L<<single-quote>>entreprise (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COMPANY_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Company (required)',
                                        'de' => 'Unternehmen (erforderlich)', // !
                                        'es' => 'La empresa (requirió)', //!
                                        'fr' => 'L<<single-quote>>entreprise (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_EMAIL_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Email (enable)',
                                        'de' => 'E-Mail (aktivieren)', // !
                                        'es' => 'Email (permite)', //!
                                        'fr' => 'Email (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_EMAIL_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Email (required)',
                                        'de' => 'E-Mail (erforderlich)', // !
                                        'es' => 'Email (requerido)', //!
                                        'fr' => 'Email (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_PHONE_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Phone number (enable)',
                                        'de' => 'Telefonnummer (aktivieren)', // !
                                        'es' => 'El número de teléfono (permite)', //!
                                        'fr' => 'Le numéro de téléphone (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_PHONE_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Phone number (required)',
                                        'de' => 'Telefonnummer (erforderlich)', // !
                                        'es' => 'Número de teléfono (requerido)', //!
                                        'fr' => 'Numéro de téléphone (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COUNTRY_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Country (enable)',
                                        'de' => 'Land (aktivieren)', // !
                                        'es' => 'El país (permite)', //!
                                        'fr' => 'Le pays (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COUNTRY_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Country (required)',
                                        'de' => 'Land (erforderlich)', // !
                                        'es' => 'País (requerido)', //!
                                        'fr' => 'Le pays (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_FIRST_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Address line 1 (enable)',
                                        'de' => 'Adresszeile 1 (aktivieren)', // !
                                        'es' => 'Línea de dirección 1 (habilitar)', //!
                                        'fr' => 'Adresse ligne 1 (activer)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_FIRST_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Address line 1 (required)',
                                        'de' => 'Adresszeile 1 (erforderlich)', // !
                                        'es' => 'Línea de dirección 1 (requerido)', //!
                                        'fr' => 'Adresse ligne 1 (obligatoire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_SECOND_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Address line 2 (enable)',
                                        'de' => 'Adresszeile 2 (aktivieren)', // !
                                        'es' => 'Línea de dirección 2 (habilitar)', //!
                                        'fr' => 'Adresse ligne 2 (activer)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_SECOND_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Address line 2 (required)',
                                        'de' => 'Adresszeile 2 (erforderlich)', // !
                                        'es' => 'Línea de dirección 2 (requerido)', //!
                                        'fr' => 'Adresse ligne 2 (obligatoire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_CITY_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'City (enable)',
                                        'de' => 'Stadt (aktivieren)', // !
                                        'es' => 'La ciudad (permite)', //!
                                        'fr' => 'La ville (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_CITY_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'City (required)',
                                        'de' => 'Stadt (erforderlich)', // !
                                        'es' => 'Ciudad (requerida)', //!
                                        'fr' => 'La ville (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_STATE_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'State (enable)',
                                        'de' => 'Staat (aktivieren)', // !
                                        'es' => 'El estado (permite)', //!
                                        'fr' => 'L<<single-quote>>état (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_STATE_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'State (required)',
                                        'de' => 'Staat (erforderlich)', // !
                                        'es' => 'Estado (requerido)', //!
                                        'fr' => 'État (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ZIP_CODE_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Zip code (enable)',
                                        'de' => 'Postleitzahl (aktivieren)', // !
                                        'es' => 'El código postal (permite)', //!
                                        'fr' => 'Le code postal (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ZIP_CODE_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Zip code (required)',
                                        'de' => 'Postleitzahl (erforderlich)', // !
                                        'es' => 'Código postal (requerido)', //!
                                        'fr' => 'Zip code (nécessaire)')); //!
                
                /*
                 * Shipping address.
                 */
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Shipping address',
                                        'de' => 'Lieferadresse', // !
                                        'es' => 'Dirección de envío', //!
                                        'fr' => 'Adresse de livraison')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Enable shipping address',
                                        'de' => 'Lieferadresse aktivieren', // !
                                        'es' => 'Permita la dirección de embarque(transporte)', //!
                                        'fr' => 'Permettez l<<single-quote>>adresse de livraison')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_FIRST_NAME_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'First name (enable)',
                                        'de' => 'Vorname (aktivieren)', // !
                                        'es' => 'El nombre de pila (permite)', //!
                                        'fr' => 'Le prénom (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_FIRST_NAME_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'First name (required)',
                                        'de' => 'Vorname (erforderlich)', // !
                                        'es' => 'Nombre de pila (requerido)', //!
                                        'fr' => 'Prénom (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_LAST_NAME_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Last name (enable)',
                                        'de' => 'Nachname (aktivieren)', // !
                                        'es' => 'El apellido (permite)', //!
                                        'fr' => 'Nom (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_LAST_NAME_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Last name (required)',
                                        'de' => 'Nachname (erforderlich)', // !
                                        'es' => 'Apellido (requerido)', //!
                                        'fr' => 'Nom (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COMPANY_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Company (enable)',
                                        'de' => 'Firma (aktivieren)', // !
                                        'es' => 'La empresa (permite)', //!
                                        'fr' => 'L<<single-quote>>entreprise (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COMPANY_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Company (required)',
                                        'de' => 'Firma (erforderlich)', // !
                                        'es' => 'La empresa (requirió)', //!
                                        'fr' => 'L<<single-quote>>entreprise (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_EMAIL_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Email (enable)',
                                        'de' => 'E-Mail (aktivieren)', // !
                                        'es' => 'El email (permite)', //!
                                        'fr' => 'Email (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_EMAIL_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Email (required)',
                                        'de' => 'E-Mail (erforderlich)', // !
                                        'es' => 'Email (requerido)', //!
                                        'fr' => 'Email (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_PHONE_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Phone number (enable)',
                                        'de' => 'Telefonnummer (aktivieren)', // !
                                        'es' => 'El número de teléfono (permite)', //!
                                        'fr' => 'Le numéro de téléphone (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_PHONE_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Phone number (required)',
                                        'de' => 'Telefonnummer (erforderlich)', // !
                                        'es' => 'Número de teléfono (requerido)', //!
                                        'fr' => 'Numéro de téléphone (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COUNTRY_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Country (enable)',
                                        'de' => 'Land (aktivieren)', // !
                                        'es' => 'El país (permite)', //!
                                        'fr' => 'Le pays (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COUNTRY_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Country (required)',
                                        'de' => 'Land (erforderlich)', // !
                                        'es' => 'País (requerido)', //!
                                        'fr' => 'Pays (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_FIRST_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Address line 1 (enable)',
                                        'de' => 'Adresszeile 1 (aktivieren)', // !
                                        'es' => 'Línea de dirección 1 (permite)', //!
                                        'fr' => 'Adresse ligne 1 (activer)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_FIRST_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Address line 1 (required)',
                                        'de' => 'Adresszeile 1 (erforderlich)', // !
                                        'es' => 'Línea de dirección 1 (requerido)', //!
                                        'fr' => 'Adresse ligne 1 (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_SECOND_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Address line 2 (enable)',
                                        'de' => 'Adresszeile 2 (aktivieren)', // !
                                        'es' => 'Línea de dirección 2 (habilitar)', //!
                                        'fr' => 'Adresse ligne 2 (activer)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_SECOND_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Address line 2 (required)',
                                        'de' => 'Adresszeile 2 (erforderlich)', // !
                                        'es' => 'Línea de dirección 2 (requerido)', //!
                                        'fr' => 'Adresse ligne 2 (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_CITY_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'City (enable)',
                                        'de' => 'Stadt (aktivieren)', // !
                                        'es' => 'La ciudad (permite)', //!
                                        'fr' => 'La ville (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_CITY_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'City (required)',
                                        'de' => 'Stadt (erforderlich)', // !
                                        'es' => '', //!
                                        'fr' => 'La ville (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_STATE_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'State (enable)',
                                        'de' => 'Staat (aktivieren)', // !
                                        'es' => 'Ciudad (requerida)', //!
                                        'fr' => 'L<<single-quote>>état (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_STATE_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'State (required)',
                                        'de' => 'Staat (erforderlich)', // !
                                        'es' => 'Estado (requerido)', //!
                                        'fr' => 'L<<single-quote>>état (nécessaire)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ZIP_CODE_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Zip code (enable)',
                                        'de' => 'Postleitzahl (aktivieren)', // !
                                        'es' => 'El código postal (permite)', //!
                                        'fr' => 'Le code postal (permet)')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ZIP_CODE_REQUIRED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Zip code (required)',
                                        'de' => 'Postleitzahl (erforderlich)', // !
                                        'es' => 'Código postal (requerido)', //!
                                        'fr' => 'Le code postal (nécessaire)')); //!
                
                return $text;
            }
            
            /*
             * Payment gateways settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsPaymentGatewaysHelp($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Payment gateways - Help'));
                
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Allow user to pay on arrival. Need approval.',
                                        'de' => 'Standardwert: Aktiviert. Erlauben Sie dem Benutzer, bei der Ankunft zu zahlen. Genehmigung erforderlich.', // !
                                        'es' => 'Valor predeterminado: Activado. Permitir que el usuario pague a la llegada. Necesidad de aprobación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Permet à l<<single-quote>>utilisateur de payer à l<<single-quote>>arrivée. Besoin d<<single-quote>>approbation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_WITH_APPROVAL_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Disabled. Instantly approve the reservation once the request to pay on arrival has been submitted.',
                                        'de' => 'Standardwert: Deaktiviert. Genehmigen Sie die Reservierung sofort, sobald die Anfrage zur Zahlung bei der Ankunft eingereicht wurde.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Aprueba instantáneamente la reserva una vez presentada la solicitud de pago a la llegada.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Approuver instantanément la réservation une fois que la demande de paiement à l<<single-quote>>arrivée a été soumise.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_REDIRECT_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Enter the URL where to redirect after the booking request has been sent. Leave it blank to not redirect.',
                                        'de' => 'Geben Sie die URL ein, unter der Sie nach dem Senden der Buchungsanfrage umleiten möchten. Lassen Sie es leer, um nicht umzuleiten.', // !
                                        'es' => 'Introduzca la dirección URL donde redirigir después de que la solicitud de reserva ha sido enviada. Deje en blanco para no redireccionar.', //!
                                        'fr' => 'Entrez l<<single-quote>>URL où rediriger après que la demande de réservation a été envoyée. Laissez vide pour ne pas rediriger.')); //!
                
                /*
                 * Billing address.
                 */
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Disabled. Enable it if you want the billing address form to be visible.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie diese Option, wenn das Formular für die Rechnungsadresse angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Activar si desea que el formulario de dirección de facturación sea visible.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Activez-le si vous voulez que le formulaire d<<single-quote>>adresse de facturation soit visible.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_FIRST_NAME_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "First name" field to be visible in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Vorname" im Formular "Rechnungsadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Nombre" sea visible en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Prénom" soit visible dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_FIRST_NAME_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "First name" field to be mandatory in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Vorname" im Formular "Rechnungsadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Nombre" sea obligatorio en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Prénom" soit obligatoire dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_LAST_NAME_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Last name" field to be visible in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Nachname" im Formular "Rechnungsadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Apellido" sea visible en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Nom" soit visible dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_LAST_NAME_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Last name" field to be mandatory in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Nachname" im Formular "Rechnungsadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Apellido" sea obligatorio en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Nom" soit obligatoire dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COMPANY_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Company" field to be visible in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Firma" im Formular "Rechnungsadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Empresa" sea visible en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Société" soit visible dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COMPANY_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Disabled. Enable it if you want the "Company" field to be mandatory in billing address form.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie diese Option, wenn das Feld "Firma" im Formular "Rechnungsadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Activar si desea que el campo "Empresa" sea obligatorio en el formulario de facturación de dirección.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Activez-le si vous voulez que le champ "Société" soit obligatoire dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_EMAIL_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Email" field to be visible in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "E-Mail" im Formular "Rechnungsadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Habilite si desea que el campo "Email" sea visible en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Email" soit visible dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_EMAIL_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Email" field to be mandatory in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "E-Mail" im Formular "Rechnungsadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Habilite si desea que el campo "Email" sea obligatorio en el formulario de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Email" soit obligatoire dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_PHONE_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Phone number" field to be visible in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Telefonnummer" im Formular "Rechnungsadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Número de teléfono" sea visible en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Numéro de téléphone" soit visible dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_PHONE_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Phone number" field to be mandatory in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Telefonnummer" in der Form der Rechnungsadresse obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Número de teléfono" sea obligatorio en forma de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Numéro de téléphone" soit obligatoire dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COUNTRY_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Country" field to be visible in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Land" im Formular "Rechnungsadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "País" sea visible en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Pays" soit visible dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_COUNTRY_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Country" field to be mandatory in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Land" im Formular "Rechnungsadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "País" sea obligatorio en el formulario de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Pays" soit obligatoire dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_FIRST_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Address line 1" field to be visible in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Adresszeile 1" im Formular "Rechnungsadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Línea de dirección 1" sea visible en forma de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Adresse ligne 1" soit visible dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_FIRST_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Address line 1" field to be mandatory in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Adresszeile 1" im Formular "Rechnungsadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Línea de dirección 1" sea obligatorio en forma de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Adresse ligne 1" soit obligatoire dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_SECOND_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Address line 2" field to be visible in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Adresszeile 2" im Formular "Rechnungsadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Línea de dirección 2" sea visible en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Adresse ligne 2" soit visible dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ADDRESS_SECOND_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Disabled. Enable it if you want the "Address line 2" field to be mandatory in billing address form.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie diese Option, wenn das Feld "Adresszeile 2" im Formular "Rechnungsadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Activar si desea que el campo "Línea de dirección 2" sea obligatorio en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Activez-le si vous voulez que le champ "Adresse ligne 2" soit obligatoire dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_CITY_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "City" field to be visible in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Stadt" im Formular "Rechnungsadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "City" sea visible en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Ville" soit visible dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_CITY_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "City" field to be mandatory in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Stadt" im Formular "Rechnungsadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "City" sea obligatorio en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Ville" soit obligatoire dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_STATE_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "State" field to be visible in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Status" in der Form der Rechnungsadresse angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Estado" sea visible en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "État" soit visible dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_STATE_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "State" field to be mandatory in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Bundesland" in der Form der Rechnungsadresse obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Estado" sea obligatorio en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "État" soit obligatoire dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ZIP_CODE_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Zip code" field to be visible in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Postleitzahl" im Formular "Rechnungsadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Código Zip" sea visible en el formulario de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Code postal" soit visible dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_BILLING_ZIP_CODE_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Zip code" field to be mandatory in billing address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Postleitzahl" im Formular "Rechnungsadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Código Zip" sea obligatorio en forma de dirección de facturación.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Code postal" soit obligatoire dans le formulaire d<<single-quote>>adresse de facturation.')); //!
                
                /*
                 * Shipping address.
                 */
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Disabled. Enable it if you want the shipping address form to be visible.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie diese Option, wenn das Formular für die Lieferadresse angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Activar si desea que el formulario de dirección de envío sea visible.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Activez-le si vous voulez que le formulaire d<<single-quote>>adresse d<<single-quote>>expédition soit visible.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_FIRST_NAME_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "First name" field to be visible in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Vorname" im Formular "Lieferadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Nombre" sea visible en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Prénom" soit visible dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_FIRST_NAME_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "First name" field to be mandatory in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Vorname" im Formular "Lieferadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Nombre" sea obligatorio en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Prénom" soit obligatoire dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_LAST_NAME_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Last name" field to be visible in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Nachname" im Formular "Lieferadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Apellido" sea visible en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Nom" soit visible dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_LAST_NAME_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Last name" field to be mandatory in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Nachname" im Formular "Lieferadresse" obligatorisch sein soll.', // !
                                        'es' => 'Default value: Enabled. Enable it if you want the "Last name" field to be mandatory in shipping address form.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Nom" soit obligatoire dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COMPANY_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Company" field to be visible in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Firma" im Formular "Lieferadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Compañía" sea visible en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Entreprise" soit visible dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COMPANY_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Disabled. Enable it if you want the "Company" field to be mandatory in shipping address form.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie diese Option, wenn das Feld "Firma" im Formular "Lieferadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Activar si desea que el campo "Compañía" sea obligatorio en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Activez-le si vous voulez que le champ "Entreprise" soit obligatoire dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_EMAIL_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Email" field to be visible in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "E-Mail" im Formular "Lieferadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Habilite si desea que el campo "Email" sea visible en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Email" soit visible dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_EMAIL_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Email" field to be mandatory in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "E-Mail" im Formular "Lieferadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Email" sea obligatorio en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Email" soit obligatoire dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_PHONE_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Phone number" field to be visible in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Telefonnummer" im Formular "Lieferadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Número de teléfono" sea visible en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Numéro de téléphone" soit visible dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_PHONE_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Phone number" field to be mandatory in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Telefonnummer" in der Form der Lieferadresse obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Número de teléfono" sea obligatorio en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Numéro de téléphone" soit obligatoire dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COUNTRY_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Country" field to be visible in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Land" im Formular "Lieferadresse" angezeigt werden soll.', // !
                                        'es' => 'Default value: Enabled. Enable it if you want the "Country" field to be visible in shipping address form.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Pays" soit visible dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_COUNTRY_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Country" field to be mandatory in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Land" im Formular "Lieferadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "País" sea obligatorio en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Pays" soit obligatoire dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_FIRST_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Address line 1" field to be visible in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Adresszeile 1" im Formular "Lieferadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Línea de dirección 1" sea visible en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Adresse ligne 1" soit visible dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_FIRST_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Address line 1" field to be mandatory in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Adresszeile 1" im Formular "Lieferadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Línea de dirección 1" sea obligatorio en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Adresse ligne 1" soit obligatoire dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_SECOND_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Address line 2" field to be visible in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Adresszeile 2" im Formular "Lieferadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Línea de dirección 2" sea visible en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Adresse ligne 2" soit visible dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ADDRESS_SECOND_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Disabled. Enable it if you want the "Address line 2" field to be mandatory in shipping address form.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie diese Option, wenn das Feld "Adresszeile 2" im Formular "Lieferadresse" obligatorisch sein soll.', // !
                                        'es' => 'Default value: Disabled. Enable it if you want the "Address line 2" field to be mandatory in shipping address form.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Activez-le si vous voulez que le champ "Adresse ligne 2" soit obligatoire dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_CITY_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "City" field to be visible in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Stadt" im Formular "Lieferadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "City" sea visible en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Ville" soit visible dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_CITY_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "City" field to be mandatory in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Stadt" im Formular "Lieferadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Ciudad" sea obligatorio en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Ville" soit obligatoire dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_STATE_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "State" field to be visible in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Status" in der Form der Lieferadresse angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Estado" sea visible en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "État" soit visible dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_STATE_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "State" field to be mandatory in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Bundesland" in der Form der Lieferadresse obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Estado" sea obligatorio en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "État" soit obligatoire dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ZIP_CODE_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Zip code" field to be visible in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Postleitzahl" im Formular "Lieferadresse" angezeigt werden soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Código Zip" sea visible en el formulario de dirección de envío.', //!
                                        'fr' => 'Valeur par défaut : Activé. Activez-le si vous voulez que le champ "Code postal" soit visible dans le formulaire d<<single-quote>>adresse d<<single-quote>>expédition.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_ADDRESS_SHIPPING_ZIP_CODE_REQUIRED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Enable it if you want the "Zip code" field to be mandatory in shipping address form.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, wenn das Feld "Postleitzahl" im Formular "Lieferadresse" obligatorisch sein soll.', // !
                                        'es' => 'Valor predeterminado: Activado. Activar si desea que el campo "Código Zip" sea obligatorio en el formulario de dirección de envío.', //!
                                        'fr' => 'Default value: Enabled. Enable it if you want the "Zip code" field to be mandatory in shipping address form.')); //!
                
                return $text;
            }
            
            /*
             * Search settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsSearch($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_SEARCH',
                                        'parent' => '',
                                        'text' => 'Settings - Search'));
                
                array_push($text, array('key' => 'SETTINGS_SEARCH_TITLE',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Search settings',
                                        'de' => 'Sucheinstellungen', // !
                                        'es' => 'Configuración de búsqueda', //!
                                        'fr' => 'Paramètres de recherche')); //!
                
                /*
                 * General settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_GENERAL_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'General settings',
                                        'de' => 'Allgemeine Einstellungen', // !
                                        'es' => 'Configuración General', //!
                                        'fr' => 'Paramètres générales')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_GENERAL_DATE_TYPE',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Date type',
                                        'de' => 'Datentyp', // !
                                        'es' => 'Tipo de fecha', //!
                                        'fr' => 'Type de date')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_GENERAL_DATE_TYPE_AMERICAN',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'American (mm dd, yyyy)',
                                        'de' => 'Amerikanisch (MM.TT.JJJJ)', // !
                                        'es' => 'Americano (mm dd, aaaa)', //!
                                        'fr' => 'Américain (mm jj, aaaa)')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_GENERAL_DATE_TYPE_EUROPEAN',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'European (dd mm yyyy)',
                                        'de' => 'Europa (TT MM JJJJ)', // !
                                        'es' => 'Europea (dd mm aa)', //!
                                        'fr' => 'Européen (jj mm aaaa)')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_GENERAL_TEMPLATE',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Style template',
                                        'de' => 'Stilvorlage', // !
                                        'es' => 'Plantilla de estilo', //!
                                        'fr' => 'Modèle de style')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_GENERAL_SEARCH_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Enable search input',
                                        'de' => 'Sucheingabe aktivieren', // !
                                        'es' => 'Permita la entrada de búsqueda', //!
                                        'fr' => 'Permettez l<<single-quote>>apport de recherche')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_GENERAL_PRICE_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Filter results by price',
                                        'de' => 'Ergebnisse nach Preis filtern', // !
                                        'es' => 'Filtrar resultados por precio', //!
                                        'fr' => 'Filtrer les résultats par prix')); //!
                /*
                 * View Settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'View settings',
                                        'de' => 'Ansicht Einstellungen', // !
                                        'es' => 'Ajustes de vista', //!
                                        'fr' => 'Paramètres de vue')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_DEFAULT',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Default view',
                                        'de' => 'Standardansicht', // !
                                        'es' => 'Vista de falta', //!
                                        'fr' => 'Vue par défaut')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_DEFAULT_LIST',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'List',
                                        'de' => 'Liste', // !
                                        'es' => 'Lista', //!
                                        'fr' => 'Liste')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_DEFAULT_GRID',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Grid',
                                        'de' => 'Raster', // !
                                        'es' => 'Rejilla', //!
                                        'fr' => 'Grille')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_DEFAULT_MAP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Map',
                                        'de' => 'Karte', // !
                                        'es' => 'Mapa', //!
                                        'fr' => 'Carte')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_LIST_VIEW_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'List view',
                                        'de' => 'Listenansicht', // !
                                        'es' => 'Vista de lista', //!
                                        'fr' => 'Vue de liste')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_GRID_VIEW_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Grid view',
                                        'de' => 'Rasteransicht', // !
                                        'es' => 'Vista de rejilla', //!
                                        'fr' => 'Vue de grille')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_MAP_VIEW_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Map view',
                                        'de' => 'Kartenansicht', // !
                                        'es' => 'Vista de mapa', //!
                                        'fr' => 'Vue de carte')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_RESULTS_PAGE',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Results per page',
                                        'de' => 'Ergebnisse pro Seite', // !
                                        'es' => 'Resultados por página', //!
                                        'fr' => 'Résultats par page')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_SIDEBAR_POSITION',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Sidebar position',
                                        'de' => 'Position der Seitenleiste', // !
                                        'es' => 'Sidebar posición', //!
                                        'fr' => 'Position de sidebar')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_SIDEBAR_POSITION_LEFT',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Left',
                                        'de' => 'Links', // !
                                        'es' => 'Izquierdo', //!
                                        'fr' => 'Gauche')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_SIDEBAR_POSITION_RIGHT',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Right',
                                        'de' => 'Rechte', // !
                                        'es' => 'Derecho', //!
                                        'fr' => 'Droit')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_SIDEBAR_POSITION_TOP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Top',
                                        'de' => 'Oben', // !
                                        'es' => 'Arriba', //!
                                        'fr' => 'Sommet')); //!
                /*
                 * Currency settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_CURRENCY_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Currency settings',
                                        'de' => 'Währungseinstellungen', // !
                                        'es' => 'Ajustes monetarios', //!
                                        'fr' => 'Paramètres de monnaie')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_CURRENCY',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Currency',
                                        'de' => 'Währung', // !
                                        'es' => 'Moneda', //!
                                        'fr' => 'Monnaie')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_CURRENCY_POSITION',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Currency position',
                                        'de' => 'Währungsposition', // !
                                        'es' => 'Posición monetaria', //!
                                        'fr' => 'Position de monnaie')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_CURRENCY_POSITION_BEFORE',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Before',
                                        'de' => 'Vorher', // !
                                        'es' => 'Antes', //!
                                        'fr' => 'Auparavant')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_CURRENCY_POSITION_BEFORE_WITH_SPACE',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Before with space',
                                        'de' => 'Vorher mit Leerzeich', // !
                                        'es' => 'Antes con espacio', //!
                                        'fr' => 'Auparavant avec espace')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_CURRENCY_POSITION_AFTER',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'After',
                                        'de' => 'Nachher', // !
                                        'es' => 'después', //!
                                        'fr' => 'Après')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_CURRENCY_POSITION_AFTER_WITH_SPACE',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'After with space',
                                        'de' => 'Nachher, mit Leerzeich', // !
                                        'es' => 'Después con espacio', //!
                                        'fr' => 'Après avec espace')); //!
                /*
                 * Days settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_DAYS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Days settings',
                                        'de' => 'Einstellungen für Tage', // !
                                        'es' => 'Ajustes de días', //!
                                        'fr' => 'Paramètres de jours')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_DAYS_FIRST',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'First weekday',
                                        'de' => 'Erster Wochentag', // !
                                        'es' => 'Primer día laborable', //!
                                        'fr' => 'Premier jour ouvrable')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_DAYS_MULTIPLE_SELECT',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Search start/end days',
                                        'de' => 'Suchen der Start-/Endtage', // !
                                        'es' => 'Días de inicio/final de la búsqueda', //!
                                        'fr' => 'Jours de début/fin de recherche')); //!
                /*
                 * Hours settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_HOURS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Hours settings',
                                        'de' => 'Stundeneinstellungen', // !
                                        'es' => 'Ajustes de horas', //!
                                        'fr' => 'Fixations d<<single-quote>>heures')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_HOURS_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Search hours',
                                        'de' => 'Suchzeiten', // !
                                        'es' => 'Horas de búsqueda', //!
                                        'fr' => 'Heures de recherche')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_HOURS_DEFINITIONS',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Define hours',
                                        'de' => 'Stunden definieren', // !
                                        'es' => 'Defina horas', //!
                                        'fr' => 'Définissez heures')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_HOURS_MULTIPLE_SELECT',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Search start/end hours',
                                        'de' => 'Start-/End Stunden suchen', // !
                                        'es' => 'Horas de inicio/fin de la búsqueda', //!
                                        'fr' => 'Rechercher les heures de début et de fin')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_HOURS_AMPM',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Enable AM/PM format',
                                        'de' => 'Aktivieren Sie das AM/PM-Format', // !
                                        'es' => 'Habilitar formato AM/PM', //!
                                        'fr' => 'Activer le format AM/PM')); //!
                /*
                 * Availability settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_AVAILABILITY_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Availability settings',
                                        'de' => 'Verfügbarkeits Einstellungen', // !
                                        'es' => 'Ajustes de disponibilidad', //!
                                        'fr' => 'Paramètres de disponibilité')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_AVAILABILITY_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Filter results by no of items available',
                                        'de' => 'Filtern Sie die Ergebnisse nach der Anzahl der verfügbaren Elemente', // !
                                        'es' => 'Resultados del filtro por no de artículos disponibles', //!
                                        'fr' => 'Filtrer les résultats par nombre d<<single-quote>>articles disponibles')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_AVAILABILITY_MIN',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Minimum availability value',
                                        'de' => 'Minimaler Verfügbarkeitswert', // !
                                        'es' => 'Valor de disponibilidad mínimo', //!
                                        'fr' => 'Valeur de disponibilité minimale')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_AVAILABILITY_MAX',
                                        'parent' => 'PARENT_SETTINGS_SEARCH',
                                        'text' => 'Maximum availability value',
                                        'de' => 'Maximaler Verfügbarkeitswert', // !
                                        'es' => 'Valor de disponibilidad máximo', //!
                                        'fr' => 'Valeur de disponibilité maximale')); //!
                
                return $text;
            }
            
            /*
             * Search settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsSearchHelp($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Search - Help'));
                
                /*
                 * General settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_GENERAL_DATE_TYPE_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: American. Select date format: American (mm dd, yyyy) or European (dd mm yyyy).',
                                        'de' => 'Standardwert: Amerikanisch. Datumsformat auswählen: Amerikanisch (MM.TT.JJJJ) oder europäisch (TT.MM.JJJJ).', // !
                                        'es' => 'Valor predeterminado: Americano. Seleccione el formato de fecha: Americano (mm dd, aaaa) o Europeo (dd mm aa).', //!
                                        'fr' => 'Valeur par défaut : Américain. Sélectionner le format de la date : Américain (mm jj, aaaa) ou européen (jj mm aaaa).')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_GENERAL_TEMPLATE_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: default. Select styles template.',
                                        'de' => 'Standardwert: Standard. Wählen Sie eine Stilvorlage aus.', // !
                                        'es' => 'Valor predeterminado: predeterminado. Seleccione plantilla de estilos.', //!
                                        'fr' => 'Valeur par défaut : par défaut. Sélectionner le modèle de styles.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_GENERAL_SEARCH_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Disabled. Enable the option to search by name or location (a location needs to be created).',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie die Option, nach Namen oder Ort zu suchen (ein Ort muss erstellt werden).', // !
                                        'es' => 'Valor predeterminado: Desactivado. Habilite la opción de buscar por nombre o ubicación (una ubicación necesita ser creada).', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Activer l<<single-quote>>option de recherche par nom ou emplacement (un emplacement doit être créé).')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_GENERAL_PRICE_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Disabled. Enable the option to filter results by price.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie die Option, um die Ergebnisse nach Preis zu filtern.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Habilite la opción de filtrar los resultados por precio.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Permet de filtrer les résultats par prix.')); //!
                /*
                 * View Settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_DEFAULT_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: List. Select the default view that the search results will first display.',
                                        'de' => 'Standardwert: Liste. Wählen Sie die Standardansicht aus, die die Suchergebnisse zuerst anzeigen sollen.', // !
                                        'es' => 'Valor predeterminado: Lista. Seleccione la vista predeterminada que los resultados de búsqueda se mostrarán primero.', //!
                                        'fr' => 'Valeur par défaut : Liste. Sélectionnez la vue par défaut que les résultats de la recherche afficheront en premier.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_LIST_VIEW_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Enabled. Enable to display results in list view.',
                                        'de' => 'Standardwert: Aktiviert. Aktivieren Sie diese Option, um die Ergebnisse in der Listenansicht anzuzeigen.', // !
                                        'es' => 'Valor predeterminado: Activado. Permite mostrar los resultados en la vista de lista.', //!
                                        'fr' => 'Valeur par défaut : Activé. Permet d<<single-quote>>afficher les résultats en vue de la liste.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_GRID_VIEW_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Disabled. Enable to display results in grid view.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie diese Option, um die Ergebnisse in der Rasteransicht anzuzeigen.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Permite mostrar los resultados en la vista de la cuadrícula.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Permet d<<single-quote>>afficher les résultats en vue de la grille.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_MAP_VIEW_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Disabled. Enable to display results on a google map.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie diese Option, um Ergebnisse auf einer Google-Map anzuzeigen.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Permite visualizar los resultados en un mapa de Google.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Permet d<<single-quote>>afficher les résultats sur une carte Google.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_RESULTS_PAGE_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: 10. Set the number of results to display on a page.',
                                        'de' => 'Standardwert: 10. Legen Sie die Anzahl der Ergebnisse fest, die auf einer Seite angezeigt werden sollen.', // !
                                        'es' => 'Valor predeterminado: 10. Establezca el número de resultados para mostrar en una página.', //!
                                        'fr' => 'Valeur par défaut : 10. Définissez le nombre de résultats à afficher sur une page.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_VIEW_SIDEBAR_POSITION_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Left. Set filters sidebar position: Left, Right & Top.',
                                        'de' => 'Standardwert: Links. Festlegen der Seitenleistenposition für Filter: Links, Rechts und Oben.', // !
                                        'es' => 'Valor predeterminado: Izquierda. Establecer filtros en la posición lateral: Izquierda, Derecha y Arriba.', //!
                                        'fr' => 'Valeur par défaut : Gauche. Définir la position de la barre latérale des filtres : Gauche, Droite et Haut.')); //!
                /*
                 * Currency settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_CURRENCY_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: United States Dollar ($, USD). Select search default currency.',
                                        'de' => 'Standardwert: US-Dollar ($, USD). Wählen Sie die Standardwährung für die Suche aus.', // !
                                        'es' => 'Valor predeterminado: Dólar de los Estados Unidos ($, USD). Seleccione la moneda predeterminada de búsqueda.', //!
                                        'fr' => 'Valeur par défaut : Dollar des États-Unis ($, USD). Sélectionnez la devise par défaut de la recherche.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_CURRENCY_POSITION_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Before. Select currency position.',
                                        'de' => 'Standardwert: Vorher. Währungsposition auswählen.', // !
                                        'es' => 'Valor predeterminado: Antes. Seleccione la posición de la moneda.', //!
                                        'fr' => 'Valeur par défaut : Avant. Sélectionnez la position de la devise.')); //!
                /*
                 * Days settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_DAYS_MULTIPLE_SELECT_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Enabled. Use start/end days or select only one day to filter results.',
                                        'de' => 'Standardwert: Aktiviert. Verwenden Sie Start-/Enddatum oder wählen Sie nur einen Tag aus, um die Ergebnisse zu filtern.', // !
                                        'es' => 'Valor predeterminado: Activado. Utilice días de inicio/final o seleccione sólo un día para filtrar los resultados.', //!
                                        'fr' => 'Valeur par défaut : Activé. Utilisez les jours de début/fin ou sélectionnez seulement un jour pour filtrer les résultats.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_DAYS_FIRST_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Monday. Select search first weekday.',
                                        'de' => 'Standardwert: Montag. Wählen Sie den ersten Wochentag für die Suche aus.', // !
                                        'es' => 'Valor predeterminado: Lunes. Seleccione la primera búsqueda entre semana.', //!
                                        'fr' => 'Valeur par défaut : Lundi. Sélectionner la recherche premier jour de semaine.')); //!
                /*
                 * Hours settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_HOURS_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Disabled. Enable hours to use them to filter results.',
                                        'de' => 'Standardwert: Deaktiviert. Geben Sie Stunden an, um die Ergebnisse zu filtern.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Habilite horas para usarlos para filtrar resultados.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Permet aux heures de les utiliser pour filtrer les résultats.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_HOURS_DEFINITIONS_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Enter hh:mm ... add one per line.',
                                        'de' => 'Geben Sie hh:mm ein ... fügen Sie eine pro Zeile hinzu.', // !
                                        'es' => 'Introduzca hh:mm ... añadir uno por línea.', //!
                                        'fr' => 'Entrer hh:mm ... ajouter un par ligne.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_HOURS_MULTIPLE_SELECT_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Enabled. Use start/end hours or select only one hour to filter results.',
                                        'de' => 'Standardwert: Aktiviert. Verwenden Sie Start-/End Stunden, oder wählen Sie nur eine Stunde, um die Ergebnisse zu filtern.', // !
                                        'es' => 'Valor predeterminado: Activado. Utilice las horas de inicio/final o seleccione sólo una hora para filtrar los resultados.', //!
                                        'fr' => 'Valeur par défaut : Activé. Utilisez les heures de début/fin ou sélectionnez seulement une heure pour filtrer les résultats.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_HOURS_AMPM_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Disabled. Display hours in AM/PM format. NOTE: Hours definitions still need to be in 24 hours format.',
                                        'de' => 'Standardwert: Deaktiviert. Stunden im AM/PM-Format anzeigen. Hinweis: Die Stundendefinitionen müssen immer noch im 24-Stunden-Format vorliegen.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Horas de visualización en formato AM/PM. NOTA: Las definiciones de horas todavía tienen que estar en formato de 24 horas.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Affichage des heures en format AM/PM. REMARQUE : Les définitions des heures doivent toujours être en format 24 heures.')); //!
                /*
                 * Hours settings.
                 */
                array_push($text, array('key' => 'SETTINGS_SEARCH_AVAILABILITY_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: Disabled. Enable the option to filter results by the number of items available to book.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie die Option, um die Ergebnisse nach der Anzahl der verfügbaren Elemente zu filtern.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Habilite la opción de filtrar los resultados por el número de artículos disponibles para reservar.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Permet de filtrer les résultats par le nombre d<<single-quote>>articles disponibles pour réserver.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_AVAILABILITY_MIN_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: 1. Set minimum availability value to filter results.',
                                        'de' => 'Standardwert: 1. Legen Sie den minimalen Verfügbarkeitswert fest, um die Ergebnisse zu filtern.', // !
                                        'es' => 'Valor predeterminado: 1. Establecer el valor mínimo de disponibilidad para filtrar los resultados.', //!
                                        'fr' => 'Valeur par défaut : 1. Définissez la valeur de disponibilité minimale pour filtrer les résultats.')); //!
                array_push($text, array('key' => 'SETTINGS_SEARCH_AVAILABILITY_MAX_HELP',
                                        'parent' => 'PARENT_SETTINGS_SEARCH_HELP',
                                        'text' => 'Default value: 10. Set maximum availability value to filter results.',
                                        'de' => 'Standardwert: 10. Legen Sie den maximalen Verfügbarkeitswert fest, um die Ergebnisse zu filtern.', // !
                                        'es' => 'Valor predeterminado: 10. Establezca el valor máximo de disponibilidad para filtrar los resultados.', //!
                                        'fr' => 'Valeur par défaut : 10. Définissez la valeur de disponibilité maximale pour filtrer les résultats.')); //!
                
                return $text;
            }
            
            /*
             * Users settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsUsers($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_USERS',
                                        'parent' => '',
                                        'text' => 'Settings - Users permissions'));
                
                array_push($text, array('key' => 'SETTINGS_USERS_TITLE',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Users permissions',
                                        'de' => 'Benutzern Berechtigungen', // !
                                        'es' => 'Permisos de usuarios', //!
                                        'fr' => 'Permissions d<<single-quote>>utilisateurs')); //!
                /*
                 * Users permissions.
                 */
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Set users permissions to use the booking system.',
                                        'de' => 'Legen Sie Benutzer Berechtigungen für die Verwendung des Buchungssystems fest.', // !
                                        'es' => 'Configure los permisos de uso del sistema de reservas.', //!
                                        'fr' => 'Définissez les autorisations des utilisateurs pour utiliser le système de réservation.')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_ADMINISTRATORS_LABEL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Allow %s users to view all the calendars from all the users and/or individually add/edit them.',
                                        'de' => 'Ermöglicht %s Benutzern alle Kalender aller Benutzer anzuzeigen und/oder sie einzeln hinzuzufügen/zu bearbeiten.', // !
                                        'es' => 'Permite que los usuarios de %s vean todos los calendarios de todos los usuarios y/o los agreguen/editen individualmente.', //!
                                        'fr' => 'Permettre aux utilisateurs de %s de visualiser tous les calendriers de tous les utilisateurs et/ou de les ajouter/modifier individuellement.')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_LABEL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Allow %s users to view the plugin and individually edit only their own calendars.',
                                        'de' => 'Ermöglicht %s Benutzern können das Plugin anzeigen und nur ihre eigenen Kalender einzeln bearbeiten.', // !
                                        'es' => 'Permite a los usuarios de %s ver el plugin y editar individualmente sólo sus propios calendarios.', //!
                                        'fr' => 'Permettre aux utilisateurs de %s de visualiser le plugin et d<<single-quote>>éditer individuellement seulement leurs propres calendriers.')); //!
                /*
                 * Users custom posts permissions.
                 */
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_CUSTOM_POSTS',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Set users permissions to use custom posts',
                                        'de' => 'Legen Sie Benutzerberechtigungen fest, um benutzerdefinierte Beiträge zu verwenden', // !
                                        'es' => 'Configure los permisos de los usuarios para utilizar mensajes personalizados', //!
                                        'fr' => 'Définir les permissions des utilisateurs pour utiliser les messages personnalisés')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_CUSTOM_POSTS_LABEL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Allow %s users to use custom posts.',
                                        'de' => 'Benutzern %s erlauben, benutzerdefinierte Beiträge zu verwenden', // !
                                        'es' => 'Permite que los usuarios de %s utilicen mensajes personalizados.', //!
                                        'fr' => 'Permettre aux utilisateurs de %s d<<single-quote>>utiliser des messages personnalisés.')); //!
                /*
                 * Individual users permissions.
                 */
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_INDIVIDUAL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Set permissions on individual users',
                                        'de' => 'Legen Sie Berechtigungen für einzelne Benutzer fest', // !
                                        'es' => 'Establecer permisos para usuarios individuales', //!
                                        'fr' => 'Définir les permissions sur les utilisateurs individuels')); //!
                /*
                 * Search filters.
                 */
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ROLE',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Change role to',
                                        'de' => 'Ändern Sie die Rolle in', // !
                                        'es' => 'Papel de cambio', //!
                                        'fr' => 'Rôle de changement')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ROLE_ALL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'All',
                                        'de' => 'Alle', // !
                                        'es' => 'Todo', //!
                                        'fr' => 'Tout')); //!
                
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Order by',
                                        'de' => 'Sortieren nach', // !
                                        'es' => 'Orden por', //!
                                        'fr' => 'Ordre par')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_EMAIL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Email',
                                        'de' => 'E-Mail', // !
                                        'es' => 'Email', //!
                                        'fr' => 'Email')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_ID',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'ID',
                                        'de' => 'ID', // !
                                        'es' => 'id', //!
                                        'fr' => 'ID')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_USERNAME',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Username',
                                        'de' => 'Benutzername', // !
                                        'es' => 'Nombre de Usuario', //!
                                        'fr' => 'Nom d<<single-quote>>utilisateur')); //!
                
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Order',
                                        'de' => 'Reihenfolge', // !
                                        'es' => 'Orden', //!
                                        'fr' => 'Ordre')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_ASCENDING',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Ascending',
                                        'de' => 'Aufsteigender', // !
                                        'es' => 'Ascendente', //!
                                        'fr' => 'Ascendant')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_DESCENDING',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Descending',
                                        'de' => 'Absteigender', // !
                                        'es' => 'Descendente', //!
                                        'fr' => 'Descendant')); //!
                
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_SEARCH',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Search',
                                        'de' => 'Suche', // !
                                        'es' => 'Búsqueda', //!
                                        'fr' => 'Recherche')); //!
                /*
                 * Users list.
                 */
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_LIST_ID',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'ID',
                                        'de' => 'ID', // !
                                        'es' => 'ID', //!
                                        'fr' => 'ID')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_USERNAME',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Username',
                                        'de' => 'Benutzername', // !
                                        'es' => 'Nombre de Usuario', //!
                                        'fr' => 'Nom d<<single-quote>>utilisateur')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_EMAIL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Email',
                                        'de' => 'E-Mail', // !
                                        'es' => 'Email', //!
                                        'fr' => 'Email')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_ROLE',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Role',
                                        'de' => 'Rolle', // !
                                        'es' => 'Papel', //!
                                        'fr' => 'Rôle')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_VIEW',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'View all calendars',
                                        'de' => 'Alle Kalender anzeigen', // !
                                        'es' => 'Vea todos los calendarios', //!
                                        'fr' => 'Voyez tous les calendriers')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_USE',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Use booking system',
                                        'de' => 'Buchungssystem verwenden', // !
                                        'es' => 'Utilizar el sistema de reservas', //!
                                        'fr' => 'Utiliser le système de réservation')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_USE_CUSTOM_POSTS',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Use custom posts',
                                        'de' => 'Verwenden Sie benutzerdefinierte Beiträge', // !
                                        'es' => 'Utilice los mensajes personalizados', //!
                                        'fr' => 'Utilisez des postes personnalisés')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_USE_CALENDAR',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Use calendar',
                                        'de' => 'Kalender verwenden', // !
                                        'es' => 'Utiliza el calendario', //!
                                        'fr' => 'Utilisez le calendrier')); //!
                
                return $text;
            }
            
            /*
             * Users settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsUsersHelp($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_USERS_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Users Permissions - Help'));
                
                array_push($text, array('key' => 'SETTINGS_USERS_PERMISSIONS_HELP',
                                        'parent' => 'PARENT_SETTINGS_USERS_HELP',
                                        'text' => 'Allow administrators to edit/view all calendars and other users to use the plugin.',
                                        'de' => 'Administratoren können alle Kalender und andere Benutzer bearbeiten/anzeigen, um das Plugin zu verwenden.', // !
                                        'es' => 'Permita que los administradores editen/vean todos los calendarios y otros usuarios para usar el plugin.', //!
                                        'fr' => 'Permettre aux administrateurs de modifier/visualiser tous les calendriers et autres utilisateurs pour utiliser le plugin.')); //!
                array_push($text, array('key' => 'SETTINGS_USERS_CUSTOM_POSTS_PERMISSIONS_HELP',
                                        'parent' => 'PARENT_SETTINGS_USERS_HELP',
                                        'text' => 'Allow users to use custom posts.',
                                        'de' => 'Benutzern erlauben, benutzerdefinierte Beiträge zu verwenden.', // !
                                        'es' => 'Permita a los usuarios utilizar mensajes personalizados.', //!
                                        'fr' => 'Permettre aux utilisateurs d<<single-quote>>utiliser des messages personnalisés.')); //!
                
                return $text;
            }
            
            /*
             * Licences settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsLicences($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_LICENCES',
                                        'parent' => '',
                                        'text' => 'Settings - Licences'));
                
                array_push($text, array('key' => 'SETTINGS_LICENCES_TITLE',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'Licences',
                                        'de' => 'Lizenzen', // !
                                        'es' => 'Licencias', //!
                                        'fr' => 'Licences')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_TITLE_PRO',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'Pinpoint Booking System PRO licence',
                                        'de' => 'Pinpoint Buchungssystem Pro-Lizenz', // !
                                        'es' => 'Pinpoint Sistema de Reservas PRO licencia', //!
                                        'fr' => 'Pinpoint Booking System PRO licence')); //!
                
                array_push($text, array('key' => 'SETTINGS_LICENCES_STATUS',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'Status',
                                        'de' => 'Status', // !
                                        'es' => 'Estado', //!
                                        'fr' => 'Statut')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_STATUS_ACTIVATE',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'Activate',
                                        'de' => 'Aktivieren', // !
                                        'es' => 'Activar', //!
                                        'fr' => 'Activez')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_STATUS_DEACTIVATE',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'Deactivate',
                                        'de' => 'Deaktivieren', // !
                                        'es' => 'Desactivar', //!
                                        'fr' => 'Désactiver')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_STATUS_ACTIVATED',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'Activated',
                                        'de' => 'Aktiviert', // !
                                        'es' => 'Activado', //!
                                        'fr' => 'Activé')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_STATUS_ACTIVATED_SUCCESS',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'The item was successfully activated.',
                                        'de' => 'Das Element wurde erfolgreich aktiviert.', // !
                                        'es' => 'El objeto fue activado con éxito.', //!
                                        'fr' => 'L<<single-quote>>élément a été activé avec succès.')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_STATUS_ACTIVATED_ERROR',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'There is an error when trying to activate the item. Please try again.',
                                        'de' => 'Beim Versuch, das Element zu aktivieren, ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.', // !
                                        'es' => 'Hay un error al intentar activar el ítem. Inténtelo de nuevo.', //!
                                        'fr' => 'Il y a une erreur lorsque vous essayez d<<single-quote>>activer l<<single-quote>>élément. Veuillez réessayer.')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_STATUS_DEACTIVATED',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'Deactivated',
                                        'de' => 'Deaktiviert', // !
                                        'es' => 'Desactivado', //!
                                        'fr' => 'Désactivé')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_STATUS_DEACTIVATED_SUCCESS',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'The item was successfully deactivated.',
                                        'de' => 'Das Element wurde erfolgreich deaktiviert.', // !
                                        'es' => 'El artículo fue desactivado con éxito.', //!
                                        'fr' => 'L<<single-quote>>article a été désactivé avec succès.')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_STATUS_DEACTIVATED_ERROR',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'There is an error when trying to deactivate the item. Please try again.',
                                        'de' => 'Beim Versuch, das Element zu deaktivieren, ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.', // !
                                        'es' => 'Hay un error al tratar de desactivar el elemento. Por favor, intente de nuevo.', //!
                                        'fr' => 'There is an error when trying to deactivate the item. Please try again.')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_STATUS_TIMEOUT_ERROR',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'The connection to the server timed out. Please try again later.',
                                        'de' => 'Zeitüberschreitung bei der Verbindung zum Server. Bitte versuchen Sie es später wieder.', // !
                                        'es' => 'La conexión al servidor está desactivada. Inténtelo de nuevo más tarde.', //!
                                        'fr' => 'La connexion au serveur est terminée. Veuillez réessayer plus tard.')); //!
		
                array_push($text, array('key' => 'SETTINGS_LICENCES_KEY',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'Licence key',
                                        'de' => 'Lizenzschlüssel', // !
                                        'es' => 'Clave de licencia', //!
                                        'fr' => 'Clé de licence')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_EMAIL',
                                        'parent' => 'PARENT_SETTINGS_LICENCES',
                                        'text' => 'Licence email',
                                        'de' => 'Lizenz-E-Mail', // !
                                        'es' => 'Email de licencia', //!
                                        'fr' => 'Courrier électronique de licence')); //!
                
                return $text;
            }
            
            /*
             * Licences settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsLicencesHelp($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_LICENCES_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Licences - Help'));
                
                array_push($text, array('key' => 'SETTINGS_LICENCES_HELP',
                                        'parent' => 'PARENT_SETTINGS_LICENCES_HELP',
                                        'text' => 'Activate the plugin and add-ons to check and receive automatic updates. Activation is not required to use the items.',
                                        'de' => 'Aktivieren Sie das Plugin und die Add-Ons, um automatische Updates zu prüfen und zu erhalten. Eine Aktivierung ist für die Verwendung der Elemente nicht erforderlich.', // !
                                        'es' => 'Activar el plugin y add-ons para comprobar y recibir actualizaciones automáticas. La activación no es necesaria para utilizar los elementos.', //!
                                        'fr' => 'Activez le plugin et les add-ons pour vérifier et recevoir les mises à jour automatiques. L<<single-quote>>activation n<<single-quote>>est pas nécessaire pour utiliser les éléments.')); //!
                
                array_push($text, array('key' => 'SETTINGS_LICENCES_KEY_HELP',
                                        'parent' => 'PARENT_SETTINGS_LICENCES_HELP',
                                        'text' => 'Enter the licence key which you received with your order confirmation email. You can also find it in %s',
                                        'de' => 'Geben Sie den Lizenzschlüssel ein, den Sie mit Ihrer Bestätigungs-E-Mail erhalten haben. Sie finden ihn auch in %s', // !
                                        'es' => 'Introduzca la clave de licencia que recibió con su email de confirmación de pedido. También se puede encontrar en %s', //!
                                        'fr' => 'Saisissez la clé de licence que vous avez reçue avec votre email de confirmation de commande. Vous pouvez également la trouver en %s')); //!
                array_push($text, array('key' => 'SETTINGS_LICENCES_EMAIL_HELP',
                                        'parent' => 'PARENT_SETTINGS_LICENCES_HELP',
                                        'text' => 'Enter the email you are using on %s',
                                        'de' => 'Geben Sie die E-Mail-Adresse ein, die Sie verwenden', // !
                                        'es' => 'Introduzca el email que está utilizando en %s', //!
                                        'fr' => 'Entrez l<<single-quote>>email que vous utilisez sur %s')); //!
                
                return $text;
            }
        }
    }