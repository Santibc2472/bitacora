<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-order.php
* File Version            : 1.0.5
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Order translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextOrder')){
        class DOPBSPTranslationTextOrder{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize order text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'order'));
                
                /*
                 * Initialize order address text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'orderAddress'));
            }

            /*
             * Order text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function order($text){
                array_push($text, array('key' => 'PARENT_ORDER',
                                        'parent' => '',
                                        'text' => 'Order',
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'ORDER_TITLE',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Order',
                                        'de' => 'Bestellung', // !
                                        'es' => 'Orden', // !
                                        'fr' => 'Ordre', //!
                                        'location' => 'all',));
                array_push($text, array('key' => 'ORDER_UNAVAILABLE',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'The period you selected is not available anymore. The calendar will refresh to update the schedule.',
                                        'de' => 'Der ausgewählte Zeitraum ist nicht mehr verfügbar. Der Kalender wird aktualisiert, um den Zeitplan zu aktualisieren.', // !
                                        'es' => 'El periodo seleccionado ya no está disponible. El calendario se actualizará para actualizar el horario.', // !
                                        'fr' => 'La période que vous avez sélectionnée n<<single-quote>>est plus disponible. Le calendrier sera mis à jour pour mettre à jour le calendrier.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_UNAVAILABLE_COUPON',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'The coupon you entered is not available anymore.',
                                        'de' => 'Der eingegebene Coupon ist nicht mehr verfügbar.', // !
                                        'es' => 'El cupón que introdujiste ya no está disponible.', // !
                                        'fr' => 'Le coupon que vous avez entré n<<single-quote>>est plus disponible.', //!
                                        'location' => 'all'));
                /*
                 * Payment methods.
                 */
                array_push($text, array('key' => 'ORDER_PAYMENT_METHOD',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Payment method',
                                        'de' => 'Zahlungsmethode', // !
                                        'es' => 'Método de pago', // !
                                        'fr' => 'Moyen de paiement', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_PAYMENT_FULL_AMOUNT',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Pay full amount',
                                        'de' => 'Zahlung des vollen Betrags', // !
                                        'es' => 'Total de paga', // !
                                        'fr' => 'Payez le montant total', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_PAYMENT_METHOD_NONE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'None',
                                        'de' => 'Keine', // !
                                        'es' => 'Ninguno', // !
                                        'fr' => 'Aucun', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_PAYMENT_METHOD_ARRIVAL',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'On arrival',
                                        'de' => 'Bei der Ankunft', // !
                                        'es' => 'A la llegada', // !
                                        'fr' => 'À l<<single-quote>>arrivée', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_PAYMENT_METHOD_WOOCOMMERCE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'WooCommerce',
                                        'de' => 'WooCommerce', // !
                                        'es' => 'WooCommerce', // !
                                        'fr' => 'WooCommerce', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_PAYMENT_METHOD_WOOCOMMERCE_ORDER_ID',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Order ID',
                                        'de' => 'Bestell-ID', // !
                                        'es' => 'Orden ID', // !
                                        'fr' => 'Ordre ID', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_PAYMENT_METHOD_TRANSACTION_ID',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Transaction ID',
                                        'de' => 'Transaktions ID',
                                        'es' => 'ID de transacción', // !
                                        'fr' => 'ID de tansaction',
                                        'nl' => 'Transactie ID',
                                        'pl' => 'Transaction ID',
                                        'location' => 'all'));
                /*
                 * Front end.
                 */
                array_push($text, array('key' => 'ORDER_PAYMENT_ARRIVAL',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Pay on arrival (need to be approved)',
                                        'de' => 'Zahlung bei ankunft (muss genehmigt werden)',
                                        'es' => 'Pago a la llegada (debe ser aprobado)', // !
                                        'fr' => 'Payer à l<<single-quote>>arrivée (besoin d<<single-quote>>être approuvé)',
                                        'nl' => 'Betaling na bevestiging',
                                        'location' => 'all')); 
                array_push($text, array('key' => 'ORDER_PAYMENT_ARRIVAL_WITH_APPROVAL',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Pay on arrival (instant booking)',
                                        'de' => 'Bezahlung bei Ankunft (sofortige Buchung)', // !
                                        'es' => 'Pago a la llegada (reserva instantánea)', // !
                                        'fr' => 'Payer à l<<single-quote>>arrivée (réservation instantanée)',
                                        'nl' => 'Betaling na bevestiging (direct boeken)',
                                        'pl' => 'Pay on arrival (need to be approved)',
                                        'location' => 'all')); 
                array_push($text, array('key' => 'ORDER_PAYMENT_ARRIVAL_SUCCESS',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Your request has been successfully sent. Please wait for approval.',
                                        'de' => 'Ihre anfrage wurde erfolgreich übermittelt. Bitte warten sie auf ihre bestätigung.',
                                        'es' => 'Su solicitud ha sido enviada con éxito. Por favor espere la aprobación.', // !
                                        'fr' => 'Votre demande a bien été envoyé. Veuillez attendre l<<single-quote>>approbation.',
                                        'nl' => 'Uw aanvraag is succesvol verzonden. U ontvangt z.s.m. een reactie.',
                                        'pl' => 'Państwa rezerwacja została wysłana, prosimy czekać na potwierdzenie.',
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_PAYMENT_ARRIVAL_WITH_APPROVAL_SUCCESS',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Your request has been successfully received. We are waiting you!',
                                        'de' => 'Wir haben ihre buchung erhalten. Wir freuen uns auf sie!',
                                        'es' => 'Su solicitud ha sido recibida con éxito. ¡Le estamos esperando!', // !
                                        'fr' => 'Votre demande a bien été reçue. Nous vous attendons!',
                                        'nl' => 'Your request has been successfully received. We are waiting you!',
                                        'pl' => 'Państwa rezerwacja została potwierdzona, dziękujemy!',
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'ORDER_TERMS_AND_CONDITIONS',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'I agree to the Terms & Conditions.',
                                        'de' => 'Ich akzeptiere die AGB.',
                                        'es' => 'Acepto los Términos y Condiciones.', // !
                                        'fr' => 'Je m<<single-quote>>engage à accepter les Termes & Conditions.',
                                        'nl' => 'Ik accepteer de algemene voorwaarden.',
                                        'pl' => 'Akceptuję regulamin.',
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_TERMS_AND_CONDITIONS_INVALID',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'You must agree with our Terms & Conditions to continue.',
                                        'de' => 'Sie müssen unseren AGB zustimmen, um fortfahren zu können.',
                                        'es' => 'Usted debe estar de acuerdo con nuestros Términos y Condiciones para continuar.', // !
                                        'fr' => 'Vous devez accepter nos Termes & Conditions pour continuer.',
                                        'nl' => 'U moet de algemene voorwaarden accepteren om door te gaan.',
                                        'pl' => 'Proszę zaakceptować regulamin.',
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'ORDER_BOOK',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Book now',
                                        'de' => 'Jetzt buchen',
                                        'es' => 'Reservar ahora', // !
                                        'fr' => 'Réserver maintenant',
                                        'nl' => 'Reserveer nu',
                                        'pl' => 'Rezerwuj teraz',
                                        'location' => 'all'));
                
                return $text;
            }

            /*
             * Order address text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function orderAddress($text){
                array_push($text, array('key' => 'PARENT_ORDER_ADDRESS',
                                        'parent' => '',
                                        'text' => 'Order - Billing/shipping address',
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'ORDER_ADDRESS_SELECT_PAYMENT_METHOD',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Select payment method.',
                                        'de' => 'Wählen Sie die Zahlungsmethode aus.', // !
                                        'es' => 'Seleccione el método de pago.', // !
                                        'fr' => 'Choisissez la méthode de paiement.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_BILLING',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Billing address',
                                        'de' => 'Rechnungsadresse', // !
                                        'es' => 'Dirección de facturación', // !
                                        'fr' => 'Adresse de facturation', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_BILLING_DISABLED',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Billing address is not enabled.',
                                        'de' => 'Rechnungsadresse ist nicht aktiviert.', // !
                                        'es' => 'La dirección de facturación no está habilitada.', // !
                                        'fr' => 'L<<single-quote>>adresse de facturation n<<single-quote>>est pas activée.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_SHIPPING',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Shipping address',
                                        'de' => 'Lieferadresse', // !
                                        'es' => 'Dirección de envío', // !
                                        'fr' => 'Adresse d<<single-quote>>expédition', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_SHIPPING_DISABLED',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Shipping address is not enabled.',
                                        'de' => 'Lieferadresse ist nicht aktiviert.', // !
                                        'es' => 'La dirección de envío no está habilitada.', // !
                                        'fr' => 'L<<single-quote>>adresse d<<single-quote>>expédition n<<single-quote>>est pas activée.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_SHIPPING_COPY',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Use billing address',
                                        'de' => 'Rechnungsadresse verwenden', // !
                                        'es' => 'Utilice la dirección de facturación', // !
                                        'fr' => 'Utilisez l<<single-quote>>adresse de facturation', //!
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'ORDER_ADDRESS_FIRST_NAME',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'First name',
                                        'de' => 'Vorname', // !
                                        'es' => 'Nombre', // !
                                        'fr' => 'Prénom', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_LAST_NAME',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Last name',
                                        'de' => 'Nachname', // !
                                        'es' => 'Apellido', // !
                                        'fr' => 'Nom', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_COMPANY',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Company',
                                        'de' => 'Firma', // !
                                        'es' => 'Compañía', // !
                                        'fr' => 'Entreprise', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_EMAIL',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Email',
                                        'de' => 'E-Mail', // !
                                        'es' => 'Correo electrónico', // !
                                        'fr' => 'Email', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_PHONE',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Phone number',
                                        'de' => 'Telefonnummer', // !
                                        'es' => 'Número de teléfono', // !
                                        'fr' => 'Numéro de téléphone', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_COUNTRY',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Country',
                                        'de' => 'Land', // !
                                        'es' => 'País', // !
                                        'fr' => 'Pays', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_ADDRESS_FIRST',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Address line 1',
                                        'de' => 'Adresszeile 1', // !
                                        'es' => 'Línea de dirección 1', // !
                                        'fr' => 'Ligne d<<single-quote>>adresse 1', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_ADDRESS_SECOND',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Address line 2',
                                        'de' => 'Adresszeile 2', // !
                                        'es' => 'Línea de dirección 2', // !
                                        'fr' => 'Ligne d<<single-quote>>adresse 2', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_CITY',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'City',
                                        'de' => 'Stadt', // !
                                        'es' => 'Ciudad', // !
                                        'fr' => 'Ville', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_STATE',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'State/Province',
                                        'de' => 'Staat/Provinz', // !
                                        'es' => 'Estado/Provincia', // !
                                        'fr' => 'État/Province', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_ADDRESS_ZIP_CODE',
                                        'parent' => 'PARENT_ORDER_ADDRESS',
                                        'text' => 'Zip code',
                                        'de' => 'Postleitzahl', // !
                                        'es' => 'Código postal', // !
                                        'fr' => 'Code postal', //!
                                        'location' => 'all'));
                
                return $text;
            }
        }
    }