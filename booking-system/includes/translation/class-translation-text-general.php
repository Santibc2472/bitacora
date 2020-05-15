<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/translation/class-translation-text-general.php
* File Version            : 1.0.6
* Created / Last Modified : 20 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : General translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextGeneral')){
        class DOPBSPTranslationTextGeneral{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize general text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'general'));
            }
            
            /*
             * General text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function general($text){
                array_push($text, array('key' => 'TITLE',
                                        'parent' => 'none',
                                        'text' => 'Pinpoint Booking System',
                                        'de' => 'Pinpoint Buchungssystem', // !
                                        'es' => 'Sistema de Reservas Pinpoint', // !
                                        'fr' => 'Pinpoint Booking System')); // !
                /*
                 * Messages
                 */
                array_push($text, array('key' => 'PARENT_MESSAGES',
                                        'parent' => '',
                                        'text' => 'Messages'));
                
                array_push($text, array('key' => 'MESSAGES_LOADING',
                                        'parent' => 'PARENT_MESSAGES',
                                        'text' => 'Loading data ...',
                                        'de' => 'Daten werden geladen...', // !
                                        'es' => 'Carga de datos...', // !
                                        'fr' => 'Chargement de données ...'));//!
                array_push($text, array('key' => 'MESSAGES_LOADING_SUCCESS',
                                        'parent' => 'PARENT_MESSAGES',
                                        'text' => 'Data has been loaded.',
                                        'de' => 'Daten wurden geladen.', // !
                                        'es' => 'Los datos han sido cargados.', // !
                                        'fr' => 'Les données ont été chargées.'));//!
                array_push($text, array('key' => 'MESSAGES_SAVING',
                                        'parent' => 'PARENT_MESSAGES',
                                        'text' => 'Saving data ...',
                                        'de' => 'Daten werden gespeichert ...', // !
                                        'es' => 'Ahorro de datos...', // !
                                        'fr' => 'Sauvegarder des données ...'));//!
                array_push($text, array('key' => 'MESSAGES_SAVING_SUCCESS',
                                        'parent' => 'PARENT_MESSAGES',
                                        'text' => 'Data has been saved.',
                                        'de' => 'Daten wurden gespeichert.', // !
                                        'es' => 'Los datos han sido guardados.', // !
                                        'fr' => 'Les données ont été sauvegardées.'));//!
                
                array_push($text, array('key' => 'MESSAGES_CONFIRMATION_YES',
                                        'parent' => 'PARENT_MESSAGES',
                                        'text' => 'Yes',
                                        'de' => 'Ja', // !
                                        'es' => 'Sí', // !
                                        'fr' => 'Oui'));//!
                array_push($text, array('key' => 'MESSAGES_CONFIRMATION_NO',
                                        'parent' => 'PARENT_MESSAGES',
                                        'text' => 'No',
                                        'de' => 'Nein', // !
                                        'es' => 'No', // !
                                        'fr' => 'No'));//!
                
                /*
                 * PRO
                 */
                array_push($text, array('key' => 'MESSAGES_PRO_TITLE',
                                        'parent' => 'PARENT_MESSAGES',
                                        'text' => 'PRO',
                                        'de' => 'PRO', // !
                                        'es' => 'PRO', // !
                                        'fr' => 'PRO'));//!
                array_push($text, array('key' => 'MESSAGES_PRO_INFO',
                                        'parent' => 'PARENT_PRO_VERSION',
                                        'text' => 'only in PRO',
                                        'de' => 'nur in PRO', // !
                                        'es' => 'sólo en PRO', // !
                                        'fr' => 'seulement dans PRO'));//!
                array_push($text, array('key' => 'MESSAGES_PRO_TEXT',
                                        'parent' => 'PARENT_PRO_VERSION',
                                        'text' => 'This feature is only available in PRO version.',
                                        'de' => 'Diese Funktion ist nur in PRO-Version verfügbar.', // !
                                        'es' => 'Esta función sólo está disponible en versión PRO.', // !
                                        'fr' => 'Cette fonction est disponible uniquement en version PRO.'));//!
                array_push($text, array('key' => 'MESSAGES_PRO_REMOVE_TEXT1',
                                        'parent' => 'PARENT_PRO_VERSION',
                                        'text' => 'Permanently remove any reference to Pinpoint Booking System PRO version by clicking the close button. This action cannot be undone.',
                                        'de' => 'Entfernen Sie alle Verweise auf die Pinpoint Booking System PRO-Version dauerhaft, indem Sie auf die Schaltfläche "Schließen" klicken. Diese Aktion kann nicht rückgängig gemacht werden.', // !
                                        'es' => 'Elimina permanentemente cualquier referencia a la versión PRO del Sistema de Reservas puntual haciendo clic en el botón de cierre. Esta acción no se puede deshacer.', // !
                                        'fr' => 'Supprimez définitivement toute référence à la version Pinpoint Booking System PRO en cliquant sur le bouton de fermeture. Cette action ne peut pas être annulée.'));//!
                array_push($text, array('key' => 'MESSAGES_PRO_REMOVE_TEXT2',
                                        'parent' => 'PARENT_PRO_VERSION',
                                        'text' => 'You can also remove any information about PRO version if you set the constant %s value to %s in file %s.',
                                        'de' => 'Sie können auch alle Informationen zur PRO-Version entfernen, wenn Sie in der Datei %s den konstanten Wert %s auf %s setzen.', // !
                                        'es' => 'También puede eliminar cualquier información sobre la versión PRO si establece el valor constante %s a %s en el archivo %s.', // !
                                        'fr' => 'Vous pouvez également supprimer toute information sur la version PRO si vous définissez la valeur constante %s à %s dans le fichier %s.'));//!

                /*
                 * Months & week days
                 */
                array_push($text, array('key' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'parent' => '',
                                        'text' => 'Months & Week Days'));
                
                array_push($text, array('key' => 'MONTH_JANUARY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'January',
                                        'de' => 'Januar',
                                        'es' => 'Enero', // !
                                        'fr' => 'Janvier',
                                        'nl' => 'Januari',
                                        'pl' => 'Styczeń',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'MONTH_FEBRUARY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'February',
                                        'de' => 'Februar',
                                        'es' => 'Febrero', // !
                                        'fr' => 'Février',
                                        'nl' => 'Februari',
                                        'pl' => 'Luty',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'MONTH_MARCH',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'March',
                                        'de' => 'März',
                                        'es' => 'Marzo', // !
                                        'fr' => 'Mars',
                                        'nl' => 'Maart',
                                        'pl' => 'Marzec',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'MONTH_APRIL',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'April',
                                        'de' => 'April',
                                        'es' => 'Abril', // !
                                        'fr' => 'Avril',
                                        'nl' => 'April',
                                        'pl' => 'Kwiecień',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'MONTH_MAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'May',
                                        'de' => 'Mai',
                                        'es' => 'Mayo', // !
                                        'fr' => 'Mai',
                                        'nl' => 'Mei',
                                        'pl' => 'Maj',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'MONTH_JUNE',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'June',
                                        'de' => 'Juni',
                                        'es' => 'Junio', // !
                                        'fr' => 'Juin',
                                        'nl' => 'Juni',
                                        'pl' => 'Czerwiec',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'MONTH_JULY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'July',
                                        'de' => 'Juli',
                                        'es' => 'Julio', // !
                                        'fr' => 'Juillet',
                                        'nl' => 'Juli',
                                        'pl' => 'Lipiec',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'MONTH_AUGUST',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'August',
                                        'de' => 'August',
                                        'es' => 'Agosto', // !
                                        'fr' => 'Août',
                                        'nl' => 'Augustus',
                                        'pl' => 'Sierpień',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'MONTH_SEPTEMBER',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'September',
                                        'de' => 'September',
                                        'es' => 'Septiembre', // !
                                        'fr' => 'Septembre',
                                        'nl' => 'September',
                                        'pl' => 'Wrzesień',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'MONTH_OCTOBER',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'October',
                                        'de' => 'Oktober',
                                        'es' => 'Octubre', // !
                                        'fr' => 'Octobre',
                                        'nl' => 'Oktober',
                                        'pl' => 'Październik',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'MONTH_NOVEMBER',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'November',
                                        'de' => 'November',
                                        'es' => 'Noviembre', // !
                                        'fr' => 'Novembre',
                                        'nl' => 'November',
                                        'pl' => 'Listopad',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'MONTH_DECEMBER',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'December',
                                        'de' => 'Dezember',
                                        'es' => 'Diciembre', // !
                                        'fr' => 'Décembre',
                                        'nl' => 'December',
                                        'pl' => 'Grudzień',
                                        'location' => 'calendar'));
    
                array_push($text, array('key' => 'SHORT_MONTH_JANUARY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Jan',
                                        'de' => 'Jan',
                                        'es' => 'Ene', // !
                                        'fr' => 'Jan',
                                        'nl' => 'Jan',
                                        'pl' => 'Sty',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_MONTH_FEBRUARY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Feb',
                                        'de' => 'Feb',
                                        'es' => 'Feb', // !
                                        'fr' => 'Fev',
                                        'nl' => 'Feb',
                                        'pl' => 'Lut',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_MONTH_MARCH',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Mar',
                                        'de' => 'Mär',
                                        'es' => 'Mar', // !
                                        'fr' => 'Mar',
                                        'nl' => 'Mar',
                                        'pl' => 'Mar',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_MONTH_APRIL',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Apr',
                                        'de' => 'Apr',
                                        'es' => 'Abr', // !
                                        'fr' => 'Avr',
                                        'nl' => 'Apr',
                                        'pl' => 'Kwi',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_MONTH_MAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'May',
                                        'de' => 'Mai',
                                        'es' => 'May', // !
                                        'fr' => 'Mai',
                                        'nl' => 'Mei',
                                        'pl' => 'Maj',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_MONTH_JUNE',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Jun',
                                        'de' => 'Jun',
                                        'es' => 'Jun', // !
                                        'fr' => 'Jun',
                                        'nl' => 'Jun',
                                        'pl' => 'Cze',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_MONTH_JULY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Jul',
                                        'de' => 'Jul',
                                        'es' => 'Jul', // !
                                        'fr' => 'Jui',
                                        'nl' => 'Jul',
                                        'pl' => 'Lip',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_MONTH_AUGUST',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Aug',
                                        'de' => 'Aug',
                                        'es' => 'Ago', // !
                                        'fr' => 'Aou',
                                        'nl' => 'Aug',
                                        'pl' => 'Sie',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_MONTH_SEPTEMBER',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Sep',
                                        'de' => 'Sep',
                                        'es' => 'Sep', // !
                                        'fr' => 'Sep',
                                        'nl' => 'Sep',
                                        'pl' => 'Wrz',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_MONTH_OCTOBER',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Oct',
                                        'de' => 'Okt',
                                        'es' => 'Oct', // !
                                        'fr' => 'Oct',
                                        'nl' => 'Okt',
                                        'pl' => 'Paź',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_MONTH_NOVEMBER',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Nov',
                                        'de' => 'Nov',
                                        'es' => 'Nov', // !
                                        'fr' => 'Nov',
                                        'nl' => 'Nov',
                                        'pl' => 'Lis',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_MONTH_DECEMBER',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Dec',
                                        'de' => 'Dez',
                                        'es' => 'Dic', // !
                                        'fr' => 'Dec',
                                        'nl' => 'Dec',
                                        'pl' => 'Gru',
                                        'location' => 'calendar'));
                
                array_push($text, array('key' => 'DAY_MONDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Monday',
                                        'de' => 'Montag',
                                        'es' => 'Lunes', // !
                                        'fr' => 'Lundi',
                                        'nl' => 'Maandag',
                                        'pl' => 'Poniedziałek',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'DAY_TUESDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Tuesday',
                                        'de' => 'Dienstag',
                                        'es' => 'Martes', // !
                                        'fr' => 'Mardi',
                                        'nl' => 'Dinsdag',
                                        'pl' => 'Wtorek',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'DAY_WEDNESDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Wednesday',
                                        'de' => 'Mittwoch',
                                        'es' => 'Miércoles', // !
                                        'fr' => 'Mercredi',
                                        'nl' => 'Woensdag',
                                        'pl' => 'Środa',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'DAY_THURSDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Thursday',
                                        'de' => 'Donnerstag',
                                        'es' => 'Jueves', // !
                                        'fr' => 'Jeudi',
                                        'nl' => 'Donderdag',
                                        'pl' => 'Czwartek',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'DAY_FRIDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Friday',
                                        'de' => 'Freitag',
                                        'es' => 'Viernes', // !
                                        'fr' => 'Vendredi',
                                        'nl' => 'Vrijdag',
                                        'pl' => 'Piątek',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'DAY_SATURDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Saturday',
                                        'de' => 'Samstag',
                                        'es' => 'Sábado', // !
                                        'fr' => 'Samedi',
                                        'nl' => 'Zaterdag',
                                        'pl' => 'Sobota',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'DAY_SUNDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Sunday',
                                        'de' => 'Sonntag',
                                        'es' => 'Domingo', // !
                                        'fr' => 'Dimanche',
                                        'nl' => 'Zondag',
                                        'pl' => 'Niedziela',
                                        'location' => 'calendar'));
    
                array_push($text, array('key' => 'SHORT_DAY_MONDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Mo',
                                        'de' => 'Mo',
                                        'es' => 'Lu', // !
                                        'fr' => 'Lu',
                                        'nl' => 'Ma',
                                        'pl' => 'Pon',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_DAY_TUESDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Tu',
                                        'de' => 'Di',
                                        'es' => 'Ma', // !
                                        'fr' => 'Ma',
                                        'nl' => 'Di',
                                        'pl' => 'Wt',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_DAY_WEDNESDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'We',
                                        'de' => 'Mi',
                                        'es' => 'Mi', // !
                                        'fr' => 'Me',
                                        'nl' => 'Wo',
                                        'pl' => 'Śr',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_DAY_THURSDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Th',
                                        'de' => 'Do',
                                        'es' => 'Ju', // !
                                        'fr' => 'Je',
                                        'nl' => 'Do',
                                        'pl' => 'Czw',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_DAY_FRIDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Fr',
                                        'de' => 'Fr',
                                        'es' => 'Vi', // !
                                        'fr' => 'Ve',
                                        'nl' => 'Vr',
                                        'pl' => 'Pt',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_DAY_SATURDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Sa',
                                        'de' => 'Sa',
                                        'es' => 'Sá', // !
                                        'fr' => 'Sa',
                                        'nl' => 'Za',
                                        'pl' => 'Sob',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'SHORT_DAY_SUNDAY',
                                        'parent' => 'PARENT_MONTHS_WEEK_DAYS',
                                        'text' => 'Su',
                                        'de' => 'So',
                                        'es' => 'Do', // !
                                        'fr' => 'Di',
                                        'nl' => 'Zo',
                                        'pl' => 'Niedz',
                                        'location' => 'calendar'));
                /*
                 * TinyMCE
                 */
                array_push($text, array('key' => 'PARENT_TINYMCE',
                                        'parent' => '',
                                        'text' => 'TinyMCE'));
                array_push($text, array('key' => 'TINYMCE_ADD',
                                        'parent' => 'PARENT_TINYMCE',
                                        'text' => 'Add Calendar',
                                        'de' => 'Kalender hinzufügen', // !
                                        'es' => 'Añada Calendario', // !
                                        'fr' => 'Ajoutez le calendrier'));//!
                /*
                 * Documentation
                 */
                array_push($text, array('key' => 'PARENT_DOCUMENTATION',
                                        'parent' => '',
                                         'text' => 'Documentation'));
                
                array_push($text, array('key' => 'HELP_DOCUMENTATION',
                                        'parent' => 'PARENT_DOCUMENTATION',
                                        'text' => 'Documentation',
                                        'de' => 'Dokumentation', // !
                                        'es' => 'Documentación', // !
                                        'fr' => 'Documentation'));//!
                array_push($text, array('key' => 'HELP_VIEW_DOCUMENTATION',
                                        'parent' => 'PARENT_DOCUMENTATION',
                                        'text' => 'Click this to view the documentation for more informations.',
                                        'de' => 'Klicken Sie auf diese Schaltfläche, um die Dokumentation für weitere Informationen anzuzeigen.', // !
                                        'es' => 'Haga clic aquí para ver la documentación para más información.', // !
                                        'fr' => 'Cliquez ici pour voir la documentation pour plus d<<single-quote>>informations.'));//!
                
                /*
                 * Development
                 */
                array_push($text, array('key' => 'BETA',
                                        'parent' => 'none',
                                        'text' => 'beta',
                                        'de' => 'beta', // !
                                        'es' => 'beta', // !
                                        'fr' => 'beta'));
                array_push($text, array('key' => 'BETA_TITLE',
                                        'parent' => 'none',
                                        'text' => 'Beta',
                                        'de' => 'Beta', // !
                                        'es' => 'Beta', // !
                                        'fr' => 'Bêta'));//!
                array_push($text, array('key' => 'SOON',
                                        'parent' => 'none',
                                        'text' => 'soon',
                                        'de' => 'bald', // !
                                        'es' => 'pronto', // !
                                        'fr' => 'bientôt'));//!
                array_push($text, array('key' => 'SOON_TITLE',
                                        'parent' => 'none',
                                        'text' => 'Coming soon',
                                        'de' => 'In Kürze verfügbar', // !
                                        'es' => 'Viene pronto', // !
                                        'fr' => 'Prochainement'));//!
                
                return $text;
            }
        }
    }