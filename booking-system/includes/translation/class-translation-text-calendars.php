<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/translation/class-translation-text-calendars.php
* File Version            : 1.0.5
* Created / Last Modified : 15 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Calendars translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextCalendars')){
        class DOPBSPTranslationTextCalendars{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize calendars text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'calendars'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'calendarsCalendar'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'calendarsCalendarForm'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'calendarsAddCalendar'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'calendarsEditCalendar'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'calendarsDeleteCalendar'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'calendarsHelp'));
            }

            /*
             * Calendars text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function calendars($text){
                array_push($text, array('key' => 'PARENT_CALENDARS',
                                        'parent' => '',
                                        'text' => 'Calendars'));
                
                array_push($text, array('key' => 'CALENDARS_TITLE',
                                        'parent' => 'PARENT_CALENDARS',
                                        'text' => 'Calendars',
                                        'de' => 'Kalender', // !
                                        'es' => 'Calendarios', // !
                                        'fr' => 'Calendriers'));   
                array_push($text, array('key' => 'CALENDARS_CREATED_BY',
                                        'parent' => 'PARENT_CALENDARS',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von', // !
                                        'es' => 'Creada por', // !
                                        'fr' => 'Créé par'));//!
                array_push($text, array('key' => 'CALENDARS_NO_PENDING_RESERVATIONS',
                                        'parent' => 'PARENT_CALENDARS',
                                        'text' => 'pending reservations',
                                        'de' => 'Ausstehende Reservierungen', // !
                                        'es' => 'reservas pendientes', // !
                                        'fr' => 'Réservations en suspens'));//!
                array_push($text, array('key' => 'CALENDARS_NO_APPROVED_RESERVATIONS',
                                        'parent' => 'PARENT_CALENDARS',
                                        'text' => 'approved reservations',
                                        'de' => 'Genehmigte Reservierungen', // !
                                        'es' => 'reservas aprobadas', // !
                                        'fr' => 'réservations approuvées'));
                array_push($text, array('key' => 'CALENDARS_NO_REJECTED_RESERVATIONS',
                                        'parent' => 'PARENT_CALENDARS',
                                        'text' => 'rejected reservations',
                                        'de' => 'Abgelehnte Reservierungen', // !
                                        'es' => 'reservas rechazadas', // !
                                        'fr' => 'réservations rejetées'));//!
                array_push($text, array('key' => 'CALENDARS_NO_CANCELED_RESERVATIONS',
                                        'parent' => 'PARENT_CALENDARS',
                                        'text' => 'canceled reservations',
                                        'de' => 'Stornierte Reservierungen', // !
                                        'es' => 'reservas canceladas', // !
                                        'fr' => 'réservations annulées'));//!
                array_push($text, array('key' => 'CALENDARS_LOAD_SUCCESS',
                                        'parent' => 'PARENT_CALENDARS',
                                        'text' => 'Calendars list loaded.',
                                        'de' => 'Kalenderliste geladen.', // !
                                        'es' => 'La lista de calendarios cargó.', // !
                                        'fr' => 'Liste de calendriers chargée.'));//!
                array_push($text, array('key' => 'CALENDARS_NO_CALENDARS',
                                        'parent' => 'PARENT_CALENDARS',
                                        'text' => 'No calendars. Click the above "plus" icon to add a new one.',
                                        'de' => 'Keine Kalender. Klicken Sie auf das obige "Plus"-Symbol, um ein neues hinzuzufügen.', // !
                                        'es' => 'No hay calendarios. Haga clic en el icono "plus" de arriba para agregar uno nuevo.', // !
                                        'fr' => 'Aucun calendrier. Cliquez sur l<<single-quote>>icône "plus" ci-dessus pour en ajouter une nouvelle.'));//!
                
                return $text;
            }
            
            /*
             * Calendars - Calendar text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function calendarsCalendar($text){
                array_push($text, array('key' => 'PARENT_CALENDARS_CALENDAR',
                                        'parent' => '',
                                        'text' => 'Calendars - Calendar'));
                
                array_push($text, array('key' => 'CALENDARS_CALENDAR_LOAD_SUCCESS',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR',
                                        'text' => 'Calendar loaded.',
                                        'de' => 'Kalender geladen.', // !
                                        'es' => 'El calendario cargó.', // !
                                        'fr' => 'Les calendriers ont chargé.'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_SAVING_SUCCESS',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR',
                                        'text' => 'Schedule saved.',
                                        'de' => 'Zeitplan gespeichert.', // !
                                        'es' => 'El programa ahorró.', // !
                                        'fr' => 'Le calendrier a sauvé.'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_ADD_MONTH_VIEW',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR',
                                        'text' => 'Add month view',
                                        'de' => 'Füge monatsansicht hinzu',
                                        'es' => 'Añada la vista de mes', // !
                                        'fr' => 'Ajouter la vue du mois suivant',
                                        'nl' => 'Voeg extra maand toe',
                                        'pl' => 'Dodaj widok miesiąca',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'CALENDARS_CALENDAR_REMOVE_MONTH_VIEW',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR',
                                        'text' => 'Remove month view',
                                        'de' => 'Entferne monatsansicht',
                                        'es' => 'Quite la vista de mes', // !
                                        'fr' => 'Supprimer la vue du mois suivant',
                                        'nl' => 'Verwijder extra maand',
                                        'pl' => 'Usuń widok miesiąca',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'CALENDARS_CALENDAR_PREVIOUS_MONTH',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR',
                                        'text' => 'Previous month',
                                        'de' => 'Voriger monat',
                                        'es' => 'Mes anterior', // !
                                        'fr' => 'Mois précédent',
                                        'nl' => 'Vorige maand',
                                        'pl' => 'Poprzedni miesiąc',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'CALENDARS_CALENDAR_NEXT_MONTH',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR',
                                        'text' => 'Next month',
                                        'de' => 'Nächster monat',
                                        'es' => 'Próximo mes', // !
                                        'fr' => 'Mois suivant',
                                        'nl' => 'Volgende maand',
                                        'pl' => 'Następny miesiąc',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'CALENDARS_CALENDAR_AVAILABLE_ONE_TEXT',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR',
                                        'text' => 'available',
                                        'de' => 'verfügbar',
                                        'es' => 'disponible', // !
                                        'fr' => 'disponible',
                                        'nl' => 'beschikbaar',
                                        'pl' => 'dostępne',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'CALENDARS_CALENDAR_AVAILABLE_TEXT',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR',
                                        'text' => 'available',
                                        'de' => 'verfügbar',
                                        'es' => 'disponible', // !
                                        'fr' => 'disponible',
                                        'nl' => 'beschikbaar',
                                        'pl' => 'dostępne',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'CALENDARS_CALENDAR_BOOKED_TEXT',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR',
                                        'text' => 'booked',
                                        'de' => 'belegt',
                                        'es' => 'reservado', // !
                                        'fr' => 'réservé',
                                        'nl' => 'bezet',
                                        'pl' => 'zajęte',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'CALENDARS_CALENDAR_UNAVAILABLE_TEXT',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR',
                                        'text' => 'unavailable',
                                        'de' => 'nicht verfügbar',
                                        'es' => 'no disponible', // !
                                        'fr' => 'indisponible',
                                        'nl' => 'niet beschikbaar',
                                        'pl' => 'zajęte',
                                        'location' => 'calendar'));
                
                return $text;
            }
            
            /*
             * Calendars - Calendar form text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function calendarsCalendarForm($text){
                array_push($text, array('key' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'parent' => '',
                                        'text' => 'Calendars - Calendar form',));
                
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_DATE_START_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Start date',
                                        'de' => 'Startdatum', // !
                                        'es' => 'Fecha de inicio', // !
                                        'fr' => 'Date de début'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_DATE_END_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'End date',
                                        'de' => 'Enddatum', // !
                                        'es' => 'Fecha final', // !
                                        'fr' => 'Date de fin'));  //!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_HOURS_START_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Start hour',
                                        'de' => 'Startstunde', // !
                                        'es' => 'Hora de principio', // !
                                        'fr' => 'Heure de début')); //!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_HOURS_END_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'End hour',
                                        'de' => 'Endstunde', // !
                                        'es' => 'Hora de final', // !
                                        'fr' => 'Heure de fin'));//!
                
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_SET_DAYS_AVAILABILITY_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Set days availability',
                                        'de' => 'Festlegen der Verfügbarkeit von Tagen', // !
                                        'es' => 'Fije días disponibles', // !
                                        'fr' => 'Définir la disponibilité pour les jours'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_SET_HOURS_DEFINITIONS_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Set hours definitions',
                                        'de' => 'Festlegen von Stundendefinitionen', // !
                                        'es' => 'Establecer definiciones de horas', // !
                                        'fr' => 'Définir les définitions des heures'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_SET_HOURS_AVAILABILITY_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Set hours availability',
                                        'de' => 'Legen Sie die Verfügbarkeit der Stunden fest', // !
                                        'es' => 'Fije horas disponibles', // !
                                        'fr' => 'Définir la disponibilité des heures'));//!
                
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_STATUS_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Status',
                                        'de' => 'Status', // !
                                        'es' => 'Estado', // !
                                        'fr' => 'Statut'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_STATUS_AVAILABLE_TEXT',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Available',
                                        'de' => 'Verfügbar', // !
                                        'es' => 'Disponible', // !
                                        'fr' => 'Disponible'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_STATUS_BOOKED_TEXT',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Booked',
                                        'de' => 'Gebucht', // !
                                        'es' => 'Reservado', // !
                                        'fr' => 'Réservé'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_STATUS_SPECIAL_TEXT',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Special',
                                        'de' => 'Besondere', // !
                                        'es' => 'Especial', // !
                                        'fr' => 'Spécial'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_STATUS_UNAVAILABLE_TEXT',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Unavailable',
                                        'de' => 'Nicht verfügbar', // !
                                        'es' => 'No disponible', // !
                                        'fr' => 'Indisponible'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_PRICE_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Price',
                                        'de' => 'Preis', // !
                                        'es' => 'Precio', // !
                                        'fr' => 'Prix'));//!    
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_PROMO_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Promo price',
                                        'de' => 'Promo preis', // !
                                        'es' => 'Promo precio', // !
                                        'fr' => 'Prix promotionnel'));//!               
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_AVAILABLE_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Number available',
                                        'de' => 'Verfügbare Anzahl', // !
                                        'es' => 'Número disponible', // !
                                        'fr' => 'Numéro disponible'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_HOURS_DEFINITIONS_CHANGE_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Change hours definitions (changing the definitions will overwrite any previous hours data)',
                                        'de' => 'Ändern von Stundendefinitionen (durch Ändern der Definitionen werden alle vorherigen Stundendaten überschrieben)', // !
                                        'es' => 'Cambiar definiciones de horas (cambiar las definiciones sobreescribirá cualquier dato de horas anteriores)', // !
                                        'fr' => 'Modifier les définitions des heures (modifier les définitions écrasera toutes les données sur les heures précédentes)'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_HOURS_DEFINITIONS_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Hours definitions (hh:mm add one per line). Use only 24 hours format.',
                                        'de' => 'Stundendefinitionen (hh:mm pro Zeile hinzufügen). Verwenden Sie nur das 24-Stunden-Format.', // !
                                        'es' => 'Definiciones de horas (hh:mm añadir una por línea). Utilice sólo la formato de 24 horas.', // !
                                        'fr' => 'Définitions des heures (hh:mm ajouter une par ligne). Utiliser seulement le format de 24 heures.'));//!  
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_HOURS_SET_DEFAULT_DATA_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Set default hours values for this day(s). This will overwrite any existing data.',
                                        'de' => 'Legen Sie die Standardstundenwerte für diesen Tag(e) fest. Dadurch werden alle vorhandenen Daten überschrieben.', // !
                                        'es' => 'Establecer valores de horas predeterminadas para este día(s). Esto sobrescribirá cualquier dato existente.', // !
                                        'fr' => 'Définissez les valeurs par défaut des heures pour ce jour(s). Cela écrasera toutes les données existantes.')); //!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_HOURS_INFO_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Information (users will see this message)',
                                        'de' => 'Informationen (Benutzer sehen diese Nachricht)', // !
                                        'es' => 'Información (los usuarios verán este mensaje)', // !
                                        'fr' => 'Information (les utilisateurs verront ce message)'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_HOURS_NOTES_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Notes (only administrators will see this message)',
                                        'de' => 'Hinweise (diese Meldung wird nur von Administratoren angezeigt)', // !
                                        'es' => 'Notas (sólo los administradores verán este mensaje)', // !
                                        'fr' => 'Notes (seuls les administrateurs verront ce message)'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_GROUP_DAYS_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Group days',
                                        'de' => 'Gruppentage', // !
                                        'es' => 'Agrupe los días', // !
                                        'fr' => 'Groupez les jours'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_GROUP_HOURS_LABEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Group hours',
                                        'de' => 'Gruppenstunden', // !
                                        'es' => 'Agrupe las horas', // !
                                        'fr' => 'Groupez les heures'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_RESET_CONFIRMATION',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Are you sure you want to reset the data? If you reset the days, hours data from those days will reset too.',
                                        'de' => 'Möchten Sie die Daten wirklich zurücksetzen? Wenn Sie die Tage zurücksetzen, werden die Stundendaten dieser Tage auf zurückgesetzt.', // !
                                        'es' => '¿Está seguro de que desea restablecer los datos? Si reinicia los días, horas de datos de esos días se restablecerá también.', // !
                                        'fr' => 'Êtes-vous sûr de vouloir réinitialiser les données? Si vous réinitialisez les jours, les données sur les heures de ces jours seront réinitialisées.'));//!
                
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_SUBMIT',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Submit',
                                        'de' => 'Bestätigen', // !
                                        'es' => 'Someter', // !
                                        'fr' => 'Soumettre'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_RESET',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Reset',
                                        'de' => 'Zurücksetzen', // !
                                        'es' => 'Restablecer', // !
                                        'fr' => 'Réinitialiser'));//!
                array_push($text, array('key' => 'CALENDARS_CALENDAR_FORM_CANCEL',
                                        'parent' => 'PARENT_CALENDARS_CALENDAR_FORM',
                                        'text' => 'Cancel',
                                        'de' => 'Abbrechen', // !
                                        'es' => 'Cancelar', // !
                                        'fr' => 'Fermer'));//!
                
                return $text;
            }
            
            /*
             * Calendars - Add caledar text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function calendarsAddCalendar($text){
                array_push($text, array('key' => 'PARENT_CALENDARS_ADD_CALENDAR',
                                        'parent' => '',
                                        'text' => 'Calendars - Add calendar'));
                
                array_push($text, array('key' => 'CALENDARS_ADD_CALENDAR_NAME',
                                        'parent' => 'PARENT_CALENDARS_ADD_CALENDAR',
                                        'text' => 'New calendar',
                                        'de' => 'Neuen Kalender', // !
                                        'es' => 'Nuevo calendario', // !
                                        'fr' => 'Nouveau calendrier'));//!
                array_push($text, array('key' => 'CALENDARS_ADD_CALENDAR_SUBMIT',
                                        'parent' => 'PARENT_CALENDARS_ADD_CALENDAR',
                                        'text' => 'Add calendar',
                                        'de' => 'Kalender hinzufügen', // !
                                        'es' => 'Añada calendario', // !
                                        'fr' => 'Ajoutez le calendrier'));//!
                array_push($text, array('key' => 'CALENDARS_DUPLICATE_CALENDAR_SUBMIT',
                                        'parent' => 'PARENT_CALENDARS_ADD_CALENDAR',
                                        'text' => 'Duplicate calendar',
                                        'de' => 'Doppelter Kalender', // !
                                        'es' => 'Duplicar calendario', // !
                                        'fr' => 'Dupliquez du calendrier'));//!
                array_push($text, array('key' => 'CALENDARS_ADD_CALENDAR_ADDING',
                                        'parent' => 'PARENT_CALENDARS_ADD_CALENDAR',
                                        'text' => 'Adding a new calendar ...',
                                        'de' => 'Hinzufügen eines neuen Kalenders', // !
                                        'es' => 'Añadir un nuevo calendario ...', // !
                                        'fr' => 'Ajout d<<single-quote>>un nouveau calendrier...'));//!
                array_push($text, array('key' => 'CALENDARS_ADD_CALENDAR_SUCCESS',
                                        'parent' => 'PARENT_CALENDARS_ADD_CALENDAR',
                                        'text' => 'You have successfully added a new calendar.',
                                        'de' => 'Sie haben einen neuen Kalender hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito un nuevo calendario.', // !
                                        'fr' => 'Vous avez réussi à ajouter un nouveau calendrier.'));//!
                
                return $text;
            }
            
            /*
             * Calendars - Edit calendar text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function calendarsEditCalendar($text){
                array_push($text, array('key' => 'PARENT_CALENDARS_EDIT_CALENDAR',
                                        'parent' => '',
                                        'text' => 'Calendars - Edit calendar'));
                
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR',
                                        'parent' => 'PARENT_CALENDARS_EDIT_CALENDAR',
                                        'text' => 'Edit calendar availability',
                                        'de' => 'Kalenderverfügbarkeit bearbeiten', // !
                                        'es' => 'Editar la disponibilidad de calendario', // !
                                        'fr' => 'Éditez la disponibilité de calendrier'));//!
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR_SETTINGS',
                                        'parent' => 'PARENT_CALENDARS_EDIT_CALENDAR',
                                        'text' => 'Edit calendar settings',
                                        'de' => 'Bearbeiten Sie die Kalendereinstellungen', // !
                                        'es' => 'Editar ajustes de calendario', // !
                                        'fr' => 'Modifier les paramètres du calendrier'));//!
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR_NOTIFICATIONS',
                                        'parent' => 'PARENT_CALENDARS_EDIT_CALENDAR',
                                        'text' => 'Edit calendar notifications',
                                        'de' => 'Kalender Benachrichtigungen bearbeiten', // !
                                        'es' => 'Editar notificaciones de calendario', // !
                                        'fr' => 'Modifier les notifications du calendrier'));//!
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR_PAYMENT_GATEWAYS',
                                        'parent' => 'PARENT_CALENDARS_EDIT_CALENDAR',
                                        'text' => 'Edit calendar payment gateways',
                                        'de' => 'Bearbeiten von Kalender-Zahlungs-Gateways', // !
                                        'es' => 'Editar pasarelas de pago de calendario', // !
                                        'fr' => 'Modifier les passerelles de paiement du calendrier'));//!
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR_USERS_PERMISSIONS',
                                        'parent' => 'PARENT_CALENDARS_EDIT_CALENDAR',
                                        'text' => 'Edit users permissions',
                                        'de' => 'Benutzerberechtigungen bearbeiten', // !
                                        'es' => 'Editar permisos de usuarios', // !
                                        'fr' => 'Modifier les autorisations des utilisateurs'));//!
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR_NEW_RESERVATIONS',
                                        'parent' => 'PARENT_CALENDARS_EDIT_CALENDAR',
                                        'text' => 'new reservations',
                                        'de' => 'neue reservierungen', // !
                                        'es' => 'nuevas reservas', // !
                                        'fr' => 'Nouvelles réservations'));//!
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR_DELETE',
                                        'parent' => 'PARENT_CALENDARS_EDIT_CALENDAR',
                                        'text' => 'Delete calendar',
                                        'de' => 'Kalender löschen', // !
                                        'es' => 'Suprima calendario', // !
                                        'fr' => 'Supprimez le calendrier'));//!
                
                return $text;
            }
            
            /*
             * Calendars - Delete calendar text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function calendarsDeleteCalendar($text){
                array_push($text, array('key' => 'PARENT_CALENDARS_DELETE_CALENDAR',
                                        'parent' => '',
                                        'text' => 'Calendars - Delete calendar'));
                
                array_push($text, array('key' => 'CALENDARS_DELETE_CALENDAR_CONFIRMATION',
                                        'parent' => 'PARENT_CALENDARS_DELETE_CALENDAR',
                                        'text' => 'Are you sure you want to delete this calendar?',
                                        'de' => 'Möchten Sie diesen Kalender wirklich löschen?', // !
                                        'es' => '¿Seguro que quieres borrar este calendario?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer ce calendrier?'));//!
                array_push($text, array('key' => 'CALENDARS_DELETE_CALENDAR_DELETING',
                                        'parent' => 'PARENT_CALENDARS_DELETE_CALENDAR',
                                        'text' => 'Deleting calendar ...',
                                        'de' => 'Kalender wird gelöscht ...', // !
                                        'es' => 'Supresión de calendario...', // !
                                        'fr' => 'Suppression du calendrier...'));//!
                array_push($text, array('key' => 'CALENDARS_DELETE_CALENDAR_SUCCESS',
                                        'parent' => 'PARENT_CALENDARS_DELETE_CALENDAR',
                                        'text' => 'You have successfully deleted the calendar.',
                                        'de' => 'Sie haben den Kalender erfolgreich gelöscht.', // !
                                        'es' => 'Has eliminado con éxito el calendario.', // !
                                        'fr' => 'Vous avez réussi à supprimer le calendrier.'));//!
                
                return $text;
            }
            
            /*
             * Calendars - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function calendarsHelp($text){
                array_push($text, array('key' => 'PARENT_CALENDARS_HELP',
                                        'parent' => '',
                                        'text' => 'Calendars - Help'));
                
                array_push($text, array('key' => 'CALENDARS_HELP',
                                        'parent' => 'PARENT_CALENDARS_HELP',
                                        'text' => 'Click on a calendar item to open the editing area.',
                                        'de' => 'Klicken Sie auf ein Kalenderelement, um den Bearbeitungsbereich zu öffnen.', // !
                                        'es' => 'Haga clic en un elemento del calendario para abrir el área de edición.', // !
                                        'fr' => 'Cliquez sur un élément de calendrier pour ouvrir la zone d<<single-quote>>édition.'));//!
                
                array_push($text, array('key' => 'CALENDARS_ADD_CALENDAR_HELP',
                                        'parent' => 'PARENT_CALENDARS_HELP',
                                        'text' => 'Click on the "plus" icon to add a calendar.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um einen Kalender hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "plus" para agregar un calendario.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter un calendrier.'));//!
                
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR_HELP',
                                        'parent' => 'PARENT_CALENDARS_HELP',
                                        'text' => 'Click on the "calendar" icon to edit calendar availability. Select the days and hours to edit them.',
                                        'de' => 'Klicken Sie auf das Symbol "Kalender", um die Verfügbarkeit des Kalenders zu bearbeiten. Wählen Sie die Tage und Stunden aus, um sie zu bearbeiten.', // !
                                        'es' => 'Haga clic en el icono "calendario" para editar la disponibilidad del calendario. Seleccione los días y horas para editarlos.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "calendrier" pour modifier la disponibilité du calendrier. Sélectionnez les jours et les heures pour les modifier.'));//!
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR_SETTINGS_HELP',
                                        'parent' => 'PARENT_CALENDARS_HELP',
                                        'text' => 'Click on the "gear" icon to edit calendar settings.',
                                        'de' => 'Klicken Sie auf das "Zahnrad"-Symbol, um die Kalendereinstellungen zu bearbeiten.', // !
                                        'es' => 'Haga clic en el icono "engranaje" para editar la configuración del calendario.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "gear" pour modifier les paramètres du calendrier.'));//!
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR_EMAILS_HELP',
                                        'parent' => 'PARENT_CALENDARS_HELP',
                                        'text' => 'Click on the "email" icon to set emails/notifications options.',
                                        'de' => 'Klicken Sie auf das Symbol "E-Mail", um E-Mail-/Benachrichtigungsoptionen festzulegen.', // !
                                        'es' => 'Haga clic en el icono "email" para configurar opciones de email/notificaciones.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "email" pour définir les options e-mails/notifications.'));//!
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR_PAYMENT_GATEWAYS_HELP',
                                        'parent' => 'PARENT_CALENDARS_HELP',
                                        'text' => 'Click on the "wallet" icon to set payment options.',
                                        'de' => 'Klicken Sie auf das Symbol "Brieftasche", um Zahlungsoptionen festzulegen.', // !
                                        'es' => 'Haga clic en el icono "billetera" para establecer las opciones de pago.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "portefeuille" pour définir les options de paiement.'));//!
                array_push($text, array('key' => 'CALENDARS_EDIT_CALENDAR_USERS_HELP',
                                        'parent' => 'PARENT_CALENDARS_HELP',
                                        'text' => 'Click on the "users" icon to set users permissions.',
                                        'de' => 'Klicken Sie auf das Symbol "Benutzer", um Benutzerberechtigungen festzulegen.', // !
                                        'es' => 'Haga clic en el icono "usuarios" para establecer los permisos de los usuarios.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "utilisateurs" pour définir les permissions des utilisateurs.'));//!
                
                array_push($text, array('key' => 'CALENDARS_CALENDAR_NOTIFICATIONS_HELP',
                                        'parent' => 'PARENT_CALENDARS_HELP',
                                        'text' => 'The "bulb" icon notifies you if you have new reservations.',
                                        'de' => 'Das "Glühbirne"-Symbol informiert Sie, wenn Sie neue Reserservierungen haben.', // !
                                        'es' => 'El icono "bulbo" le notifica si tiene nuevas reservas.', // !
                                        'fr' => 'L<<single-quote>>icône "ampoule" vous informe si vous avez de nouvelles réservations.'));//!
                
                return $text;
            }
        }
    } 