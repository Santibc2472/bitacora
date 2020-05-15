<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-reservations.php
* File Version            : 1.1
* Created / Last Modified : 07 September 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Reservations translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextReservations')){
        class DOPBSPTranslationTextReservations{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize reservations text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'reservations'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'reservationsFilters'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'reservationsReservation'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'reservationsHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'reservationsReservationFrontEnd'));
            }
            
            /*
             * Reservations text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function reservations($text){
                array_push($text, array('key' => 'PARENT_RESERVATIONS',
                                        'parent' => '',
                                        'text' => 'Reservations'));  
                
                array_push($text, array('key' => 'RESERVATIONS_TITLE',
                                        'parent' => 'PARENT_RESERVATIONS',
                                        'text' => 'Reservations',
                                        'de' => 'Reservierungen', // !
                                        'es' => 'Reservas', // !
                                        'fr' => 'Réservations')); //!

                array_push($text, array('key' => 'RESERVATIONS_DISPLAY_NEW_RESERVATIONS',
                                        'parent' => 'PARENT_RESERVATIONS',
                                        'text' => 'Display new reservations',
                                        'de' => 'Neue Reservierungen anzeigen', // !
                                        'es' => 'Muestre nuevas reservas', // !
                                        'fr' => 'Montrez de nouvelles réservations')); //!    
                array_push($text, array('key' => 'RESERVATIONS_NO_RESERVATIONS',
                                        'parent' => 'PARENT_RESERVATIONS',
                                        'text' => 'There are no reservations.',
                                        'de' => 'Es gibt keine Reservierungen.', // !
                                        'es' => 'No hay ninguna reserva.', // !
                                        'fr' => 'Il n<<single-quote>>y a pas de réservations.')); //!
                
                return $text;
            }
            
            /*
             * Reservations filters text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function reservationsFilters($text){
                array_push($text, array('key' => 'PARENT_RESERVATIONS_FILTERS',
                                        'parent' => '',
                                        'text' => 'Reservations - Filters')); 
                /*
                 * Reservations calendar filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_CALENDAR',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Calendar',
                                        'de' => 'Kalender', // !
                                        'es' => 'Calendario', // !
                                        'fr' => 'Calendrier')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_CALENDAR_ALL',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'All',
                                        'de' => 'Alle', // !
                                        'es' => 'Todo', // !
                                        'fr' => 'Tout')); //!
                /*
                 * Reservations view filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_VIEW_CALENDAR',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'View calendar',
                                        'de' => 'Kalender anzeigen', // !
                                        'es' => 'Vea el calendario', // !
                                        'fr' => 'Visionner le calendrier')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_VIEW_LIST',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'View list',
                                        'de' => 'Liste Ansicht', // !
                                        'es' => 'Ver lista', // !
                                        'fr' => 'Voir la liste')); //!
                /*
                 * Reservations period filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_PERIOD',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Period',
                                        'de' => 'Zeitraum', // !
                                        'es' => 'Periodo', // !
                                        'fr' => 'Période')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_START_DAY',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Start day',
                                        'de' => 'Starttag', // !
                                        'es' => 'Día de principio', // !
                                        'fr' => 'Jour de départ')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_END_DAY',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'End day',
                                        'de' => 'Endtag', // !
                                        'es' => 'Día de final', // !
                                        'fr' => 'Jour de fin')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_START_HOUR',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Start hour',
                                        'de' => 'Startstunde', // !
                                        'es' => 'Hora de principio', // !
                                        'fr' => 'Heure de début')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_END_HOUR',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'End hour',
                                        'de' => 'Endstunde', // !
                                        'es' => 'Hora de final', // !
                                        'fr' => 'Heure de fin')); //!
                /*
                 * Reservations status filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_STATUS',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Status',
                                        'de' => 'Status', // !
                                        'es' => 'Estado', // !
                                        'fr' => 'Statut')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_STATUS_LABEL',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Select statuses',
                                        'de' => 'Wählen Sie Status aus', // !
                                        'es' => 'Estados escogidos', // !
                                        'fr' => 'Sélectionnez les statuts')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_STATUS_PENDING',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Pending',
                                        'de' => 'Ausstehend', // !
                                        'es' => 'Pendiente', // !
                                        'fr' => 'En attendant')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_STATUS_APPROVED',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Approved',
                                        'de' => 'Genehmigt', // !
                                        'es' => 'Aprobado', // !
                                        'fr' => 'Approuvé')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_STATUS_REJECTED',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Rejected',
                                        'de' => 'Abgelehnt', // !
                                        'es' => 'Rechazado', // !
                                        'fr' => 'Rejeté')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_STATUS_CANCELED',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Canceled',
                                        'de' => 'Abgebrochen', // !
                                        'es' => 'Cancelado', // !
                                        'fr' => 'Annulé')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_STATUS_EXPIRED',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Expired',
                                        'de' => 'Abgelaufen', // !
                                        'es' => 'Expirado', // !
                                        'fr' => 'Expiré')); //!
                /*
                 * Reservations payment filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_PAYMENT_LABEL',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Select payment methods',
                                        'de' => 'Wählen Sie Zahlungsmethoden aus', // !
                                        'es' => 'Seleccione métodos de pago', // !
                                        'fr' => 'Choisissez des méthodes de paiement')); //!
                /*
                 * Reservations search filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_SEARCH',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Search',
                                        'de' => 'Suche', // !
                                        'es' => 'Búsqueda', // !
                                        'fr' => 'Recherche')); //!
                
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_PAGE',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Page',
                                        'de' => 'Seite', // !
                                        'es' => 'Página', // !
                                        'fr' => 'Page')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_PER_PAGE',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Reservations per page',
                                        'de' => 'Reservierungen pro Seite', // !
                                        'es' => 'Reservas por página', // !
                                        'fr' => 'Réservation par page')); //!
                
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_ORDER',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Order',
                                        'de' => 'Bestellung', // !
                                        'es' => 'Orden', // !
                                        'fr' => 'Ordre')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_ORDER_ASCENDING',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Ascending',
                                        'de' => 'Aufsteigender', // !
                                        'es' => 'Ascendente', // !
                                        'fr' => 'Ascendant')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_ORDER_DESCENDING',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Descending',
                                        'de' => 'Absteigender', // !
                                        'es' => 'Descendente', // !
                                        'fr' => 'Descendant')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_ORDER_BY',
                                        'parent' => 'PARENT_RESERVATIONS_FILTERS',
                                        'text' => 'Order by',
                                        'de' => 'Sortieren nach', // !
                                        'es' => 'Orden por', // !
                                        'fr' => 'Trier par')); //!
                
                return $text;
            }
            
            /*
             * Reservation text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function reservationsReservation($text){
                array_push($text, array('key' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'parent' => '',
                                        'text' => 'Reservations - Reservation'));  
                /*
                 * Add
                 */
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_ADD',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Add reservation',
                                        'de' => 'Reservierung hinzufügen', // !
                                        'es' => 'Añada reserva', // !
                                        'fr' => 'Ajoutez la réservation')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_ADD_SUCCESS',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Add reservation',
                                        'de' => 'Reservierung hinzufügen', // !
                                        'es' => 'Añada reserva', // !
                                        'fr' => 'Ajoutez la réservation')); //!
                /*
                 * Details
                 */
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_DETAILS_TITLE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Details',
                                        'de' => 'Details', // !
                                        'es' => 'Detalles', // !
                                        'fr' => 'Détails', //!
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_ID',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Reservation ID',
                                        'de' => 'Reservierungs-ID', // !
                                        'es' => 'Reserva ID', // !
                                        'fr' => 'ID de réservation', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_DATE_CREATED',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Date created',
                                        'de' => 'Erstellungsdatum', // !
                                        'es' => 'Fecha de creación', // !
                                        'fr' => 'Date de création')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_IP_ADDRESS',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'IP address',
                                        'de' => 'IP-Adresse', // !
                                        'es' => 'Dirección IP', // !
                                        'fr' => 'Adresse IP')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_CALENDAR_ID',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Calendar ID',
                                        'de' => 'Kalender-ID', // !
                                        'es' => 'Calendario ID', // !
                                        'fr' => 'ID de calendrier')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_CALENDAR_NAME',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Calendar name',
                                        'de' => 'Kalendername', // !
                                        'es' => 'Nombre del calendario', // !
                                        'fr' => 'Nom de calendrier')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_LANGUAGE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Selected language',
                                        'de' => 'Ausgewählte Sprache', // !
                                        'es' => 'Idioma seleccionado', // !
                                        'fr' => 'Langue sélectionnée')); //!
                /*
                 * Status
                 */
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_STATUS',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Status',
                                        'de' => 'Status', // !
                                        'es' => 'Estado', // !
                                        'fr' => 'Statut')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_STATUS_PENDING',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Pending',
                                        'de' => 'Ausstehend', // !
                                        'es' => 'Pendiente', // !
                                        'fr' => 'En attendant')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_STATUS_APPROVED',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Approved',
                                        'de' => 'Genehmigt', // !
                                        'es' => 'Aprobado', // !
                                        'fr' => 'Approuvé')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_STATUS_REJECTED',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Rejected',
                                        'de' => 'Abgelehnt', // !
                                        'es' => 'Rechazado', // !
                                        'fr' => 'Rejetées')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_STATUS_CANCELED',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Canceled',
                                        'de' => 'Abgebrochen', // !
                                        'es' => 'Cancelado', // !
                                        'fr' => 'Annulé')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_STATUS_EXPIRED',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Expired',
                                        'de' => 'Abgelaufen', // !
                                        'es' => 'Expirado', // !
                                        'fr' => 'Expiré')); //!
                /*
                 * Payment details.
                 */
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_PAYMENT_PRICE_CHANGE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Price change',
                                        'de' => 'Preisänderung', // !
                                        'es' => 'Cambio de precio', // !
                                        'fr' => 'Variation de prix', //!
                                        'location' => 'all'));
                /*
                 * Sync details.
                 */
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_SYNC',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Synced from',
                                        'de' => 'Synchronisiert von', // !
                                        'es' => 'Sincronizado de', // !
                                        'fr' => 'Synchronisées de', //!
                                        'location' => 'all'));
                /*
                 * Sync details.
                 */
                array_push($text, array('key' => 'RESERVATIONS_APPROVE_UNAVAILABLE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Another approved reservation already exists for this period.',
                                        'de' => 'Für diesen Zeitraum ist bereits eine andere genehmigte Reservierung vorhanden.', // !
                                        'es' => 'Ya existe otra reserva aprobada para este período.', // !
                                        'fr' => 'Une autre réserve approuvée existe déjà pour cette période.', //!
                                        'location' => 'all'));
                
                
                /*
                 * No data.
                 */
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_NO_EXTRAS',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'No extras.',
                                        'de' => 'Keine Extras.', // !
                                        'es' => 'Sin extras', // !
                                        'fr' => 'Aucune suppléments.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_NO_DISCOUNT',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'No discount.',
                                        'de' => 'Keinen Rabatt', // !
                                        'es' => 'Sin descuento', // !
                                        'fr' => 'Aucune remise', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_NO_COUPON',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'No coupon.',
                                        'de' => 'Keinen coupon', // !
                                        'es' => 'Sin cupon', // !
                                        'fr' => 'Aucun coupon.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_NO_FEES',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'No taxes or fees.',
                                        'de' => 'Keine Steuern oder Gebühren.', // !
                                        'es' => 'Sin impuestos ni tasas.', // !
                                        'fr' => 'Pas de taxes ou de frais.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_NO_ADDRESS_BILLING',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'No billing address.',
                                        'de' => 'Keine Rechnungsadresse.', // !
                                        'es' => 'Ninguna dirección de facturación.', // !
                                        'fr' => 'Aucune adresse de facturation.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_NO_ADDRESS_SHIPPING',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'No shipping address.',
                                        'de' => 'Keine Lieferadresse.', // !
                                        'es' => 'Ninguna dirección de embarque.', // !
                                        'fr' => 'Aucune adresse de livraison.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_NO_FORM',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Form was not completed.',
                                        'de' => 'Formular wurde nicht ausgefüllt.', // !
                                        'es' => 'El formulario no se completó.', // !
                                        'fr' => 'Le formulaire n<<single-quote>>a pas été rempli.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_NO_FORM_FIELD',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Form field was not completed.',
                                        'de' => 'Formularfeld wurde nicht ausgefüllt.', // !
                                        'es' => 'El campo de formulario no se completó.', // !
                                        'fr' => 'Le champ formulaire n<<single-quote>>a pas été rempli.', //!
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_ADDRESS_SHIPPING_COPY',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Same as billing address.',
                                        'de' => 'Identisch mit Rechnungsadresse.', // !
                                        'es' => 'Igual que la dirección de facturación.', // !
                                        'fr' => 'Identique à l<<single-quote>>adresse de facturation.', //!
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_INSTRUCTIONS',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Click to edit the reservation.',
                                        'de' => 'Klicken Sie hier, um die Reservierung zu bearbeiten.', // !
                                        'es' => 'Haga clic para editar la reserva.', // !
                                        'fr' => 'Cliquez pour modifier la réservation.', //!
                                        'location' => 'all'));
                /*
                 * Approve reservation.
                 */
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_APPROVE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Approve',
                                        'de' => 'Genehmigen', // !
                                        'es' => 'Aprobar', // !
                                        'fr' => 'Approuvez')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_APPROVE_CONFIRMATION',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Are you sure you want to approve this reservation?',
                                        'de' => 'Möchten Sie diese Reservierung wirklich genehmigen?', // !
                                        'es' => '¿Seguro que quieres aprobar esta reserva?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir approuver cette réservation?')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_APPROVE_SUCCESS',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'The reservation has been approved.',
                                        'de' => 'Die Reservierung wurde genehmigt.', // !
                                        'es' => 'La reserva ha sido aprobada.', // !
                                        'fr' => 'La réservation a été approuvée.')); //!
                /*
                 * Cancel reservation.
                 */
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_CANCEL',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Cancel',
                                        'de' => 'Abbrechen', // !
                                        'es' => 'Cancelar', // !
                                        'fr' => 'Annuler')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_CANCEL_CONFIRMATION',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Are you sure you want to cancel this reservation?',
                                        'de' => 'Möchten Sie diese Reservierung wirklich stornieren?', // !
                                        'es' => '¿Seguro que quieres cancelar esta reserva?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir annuler cette réservation?')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_CANCEL_CONFIRMATION_REFUND',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Are you sure you want to cancel this reservation? A refund will be issued automatically.',
                                        'de' => 'Möchten Sie diese Reservierung wirklich stornieren? Eine Rückerstattung wird automatisch ausgegeben.', // !
                                        'es' => '¿Está seguro de que desea cancelar esta reserva? Un reembolso se emitirá automáticamente.', // !
                                        'fr' => 'Êtes-vous sûr de vouloir annuler cette réservation? Un remboursement sera émis automatiquement.')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_CANCEL_SUCCESS',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'The reservation has been canceled.',
                                        'de' => 'Die Reservierung wurde storniert.', // !
                                        'es' => 'La reserva ha sido cancelada.', // !
                                        'fr' => 'La réservation a été annulée.')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_CANCEL_SUCCESS_REFUND',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'A refund of %s has been made.',
                                        'de' => 'Eine Rückerstattung von  %s ist erfolgt.', // !
                                        'es' => 'Se ha hecho un reembolso de %s.', // !
                                        'fr' => 'Un remboursement de %s a été effectué.')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_CANCEL_SUCCESS_REFUND_WARNING',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'A refund or a partial refund has already been made.',
                                        'de' => 'Eine Rückerstattung oder eine teilweise Rückerstattung wurde bereits vorgenommen.', // !
                                        'es' => 'Ya se ha efectuado un reembolso o un reembolso parcial.', // !
                                        'fr' => 'Un remboursement ou un remboursement partiel a déjà été effectué.')); //!
                /*
                 * Delete reservation.
                 */
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_DELETE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Delete',
                                        'de' => 'Löschen', // !
                                        'es' => 'Borrar', // !
                                        'fr' => 'Supprimez')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_DELETE_CONFIRMATION',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Are you sure you want to delete this reservation?',
                                        'de' => 'Möchten Sie diese Reservierung wirklich löschen?', // !
                                        'es' => '¿Seguro que quieres borrar esta reserva?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer cette réservation?')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_DELETE_SUCCESS',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'The reservation has been deleted.',
                                        'de' => 'Die Reservierung wurde gelöscht.', // !
                                        'es' => 'Se ha suprimido la reserva.', // !
                                        'fr' => 'La réservation a été supprimée.')); //!
                /*
                 * Reject reservation.
                 */
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_REJECT',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Reject',
                                        'de' => 'Ablehnen', // !
                                        'es' => 'Rechazar', // !
                                        'fr' => 'Rejeter')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_REJECT_CONFIRMATION',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Are you sure you want to reject this reservation?',
                                        'de' => 'Möchten Sie diese Reservierung wirklich ablehnen?', // !
                                        'es' => '¿Seguro que quieres rechazar esta reserva?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir rejeter cette réserve?')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_REJECT_SUCCESS',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'The reservation has been rejected.',
                                        'de' => 'Die Reservierung wurde abgelehnt.', // !
                                        'es' => 'La reserva ha sido rechazada.', // !
                                        'fr' => 'La réserve a été rejetée.')); //!
                
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_CLOSE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Close',
                                        'de' => 'Schließen', // !
                                        'es' => 'Cerrar', // !
                                        'fr' => 'Fermer')); //!
                
                /*
                 * Print reservations.
                 */
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_PRINT',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Print',
                                        'de' => 'Print', // !
                                        'es' => 'Imprimir', // !
                                        'fr' => 'Imprimer')); //!
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_EXPORT',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Export to:',
                                        'de' => 'Exportieren nach:', // !
                                        'es' => 'Exportación:', // !
                                        'fr' => 'Exportation:')); //!
                return $text;
            }
            
            /*
             * Reservations help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function reservationsHelp($text){
                array_push($text, array('key' => 'PARENT_RESERVATIONS_HELP',
                                        'parent' => '',
                                        'text' => 'Reservations - Help')); 
                
                array_push($text, array('key' => 'RESERVATIONS_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Manage reservations.',
                                        'de' => 'Reservierungen verwalten', // !
                                        'es' => 'Administrar reservas', // !
                                        'fr' => 'Administrez des réservations')); //!
                /*
                 * Reservations calendar filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_CALENDAR_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Select the calendar for which you want to see reservations, or display all reservations.',
                                        'de' => 'Wählen Sie den Kalender aus, für den Sie Reservierungen anzeigen möchten, oder zeigen Sie alle Reservierungen an.', // !
                                        'es' => 'Seleccione el calendario para el que desea ver las reservas, o mostrar todas las reservas.', // !
                                        'fr' => 'Sélectionnez le calendrier pour lequel vous voulez voir les réservations, ou afficher toutes les réservations.')); //!
                /*
                 * Reservations view filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_VIEW_CALENDAR_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Selecting "Calendar view" will display the reservations in a calendar. Only possible when you select one calendar.',
                                        'de' => 'Wenn Sie "Kalenderansicht" auswählen, werden die Reservierungen in einem Kalender angezeigt. Nur möglich, wenn Sie einen Kalender auswählen.', // !
                                        'es' => 'Al seleccionar "Vista del calendario" se mostrarán las reservas en un calendario. Sólo es posible cuando se selecciona un calendario.', // !
                                        'fr' => 'Sélectionner "Vue du calendrier" affichera les réservations dans un calendrier. Seulement possible lorsque vous sélectionnez un calendrier.')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_VIEW_LIST_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Selecting "List view" will display the reservations in a list.',
                                        'de' => 'Durch Auswahl von "Listenansicht" werden die Reservierungen in einer Liste angezeigt.', // !
                                        'es' => 'Al seleccionar "Ver lista" aparecerán las reservas en una lista.', // !
                                        'fr' => 'Sélectionner "Affichage de la liste" affichera les réservations dans une liste.')); //!
                /*
                 * Reservations period filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_START_DAY_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Select the day from where displayed reservations start.',
                                        'de' => 'Wählen Sie den Tag aus, an dem die angezeigten Reservierungen beginnen.', // !
                                        'es' => 'Seleccione el día desde donde comienzan las reservas mostradas.', // !
                                        'fr' => 'Sélectionnez le jour à partir duquel les réservations affichées commencent.')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_END_DAY_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Select the day where displayed reservations end.',
                                        'de' => 'Wählen Sie den Tag aus, an dem die angezeigten Reservierungen enden', // !
                                        'es' => 'Seleccione el día donde terminan las reservas mostradas.', // !
                                        'fr' => 'Sélectionnez le jour où se termine la réservation affichée.')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_START_HOUR_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Select the hour from where displayed reservations start.',
                                        'de' => 'Wählen Sie die Stunde aus, ab der die angezeigten Reservierungen beginnen.', // !
                                        'es' => 'Seleccione la hora desde donde comienzan las reservas mostradas.', // !
                                        'fr' => 'Sélectionnez l<<single-quote>>heure à partir de laquelle les réservations affichées commencent.')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_END_HOUR_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Select the hour where displayed reservations end.',
                                        'de' => 'Wählen Sie die Stunde aus, zu der die angezeigten Reservierungen enden', // !
                                        'es' => 'Seleccione la hora donde terminan las reservas mostradas.', // !
                                        'fr' => 'Sélectionnez l<<single-quote>>heure où se termine la réservation affichée.')); //!
                /*
                 * Reservations status filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_STATUS_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Display reservations with selected status.',
                                        'de' => 'Reservierungen mit ausgewähltem Status anzeigen.', // !
                                        'es' => 'Mostrar reservas con estado seleccionado.', // !
                                        'fr' => 'Afficher les réservations au statut sélectionné.')); //!
                /*
                 * Reservations payment filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_PAYMENT_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Display reservations with selected payment methods.',
                                        'de' => 'Reservierungen mit ausgewählten Zahlungsmethoden anzeigen.', // !
                                        'es' => 'Mostrar reservas con métodos de pago seleccionados.', // !
                                        'fr' => 'Afficher les réservations avec les méthodes de paiement sélectionnées.')); //!
                /*
                 * Reservations search filters.
                 */
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_SEARCH_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Enter the search value.',
                                        'de' => 'Geben Sie den Suchwert ein.', // !
                                        'es' => 'Introduzca el valor de búsqueda.', // !
                                        'fr' => 'Entrez la valeur de recherche.')); //!
                
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_PAGE_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Select page.',
                                        'de' => 'Seite auswählen', // !
                                        'es' => 'Página escogida.', // !
                                        'fr' => 'Sélectionnez la page')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_PER_PAGE_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Select the number of reservations which will be displayed on page.',
                                        'de' => 'Wählen Sie die Anzahl der Reservierungen aus, die auf Seite angezeigt werden.', // !
                                        'es' => 'Seleccione el número de reservas que se mostrará en la página.', // !
                                        'fr' => 'Sélectionnez le nombre de réservations qui sera affiché sur la page.')); //!
                
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_ORDER_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Order the reservations ascending or descending.',
                                        'de' => 'Ordnen Sie die Reservierungen auf- oder absteigend an.', // !
                                        'es' => 'Ordenar las reservas ascendentes o descendentes.', // !
                                        'fr' => 'Commandez les réservations ascendantes ou descendantes.')); //!
                array_push($text, array('key' => 'RESERVATIONS_FILTERS_ORDER_BY_HELP',
                                        'parent' => 'PARENT_RESERVATIONS_HELP',
                                        'text' => 'Select the field after which the reservations will be sorted.',
                                        'de' => 'Wählen Sie das Feld aus, nach dem die Reservierungen sortiert werden sollen.', // !
                                        'es' => 'Seleccione el campo después del cual se ordenarán las reservas.', // !
                                        'fr' => 'Sélectionnez le champ après lequel les réservations seront triées.')); //!
                
                return $text;
            }
            
            /*
             * Reservations - Reservation front end text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function reservationsReservationFrontEnd($text){
                array_push($text, array('key' => 'PARENT_RESERVATIONS_RESERVATION_FRONT_END',
                                        'parent' => '',
                                        'text' => 'Reservations - Reservation front end'));
                
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_FRONT_END_TITLE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION_FRONT_END',
                                        'text' => 'Reservation',
                                        'de' => 'Reservierung', // !
                                        'es' => 'Reserva', // !
                                        'fr' => 'Réservation', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_FRONT_END_SELECT_DAYS',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION_FRONT_END',
                                        'text' => 'Please select the days from calendar.',
                                        'de' => 'Wählen Sie die Tage aus dem Kalender aus.', // !
                                        'es' => 'Por favor, seleccione los días del calendario.', // !
                                        'fr' => 'Veuillez sélectionner les jours dans le calendrier.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_FRONT_END_SELECT_HOURS',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION_FRONT_END',
                                        'text' => 'Please select the days and hours from calendar.',
                                        'de' => 'Wählen Sie die Tage und Stunden aus dem Kalender aus.', // !
                                        'es' => 'Por favor seleccione los días y horas del calendario.', // !
                                        'fr' => 'Veuillez sélectionner les jours et les heures dans le calendrier.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_FRONT_END_PRICE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION_FRONT_END',
                                        'text' => 'Price',
                                        'de' => 'Preis', // !
                                        'es' => 'Precio', // !
                                        'fr' => 'Prix', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_FRONT_END_TOTAL_PRICE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION_FRONT_END',
                                        'text' => 'Total',
                                        'de' => 'Summe',
                                        'es' => 'Total', // !
                                        'fr' => 'Total',
                                        'nl' => 'Totaal',
                                        'pl' => 'Razem',
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION_FRONT_END',
                                        'text' => 'Deposit',
                                        'de' => 'Anzahlung',
                                        'es' => 'Depósito', // !
                                        'fr' => 'Dépôt',
                                        'nl' => 'Tegoed',
                                        'pl' => 'Zaliczka',
                                        'location' => 'all'));
                array_push($text, array('key' => 'RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT_LEFT',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION_FRONT_END',
                                        'text' => 'Left to pay',
                                        'de' => 'Restbetrag',
                                        'es' => 'Izquierda a pagar ', // !
                                        'fr' => 'Reste à payer',
                                        'nl' => 'Te betalen',
                                        'pl' => 'Przejdź do płatności',
                                        'location' => 'all'));
                
                return $text;
            }
        }
    }