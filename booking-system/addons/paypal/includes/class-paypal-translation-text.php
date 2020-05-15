<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : addons/paypal/includes/class-paypal-translation-text.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : PayPal translation text PHP class.
*/

    if (!class_exists('DOPBSPPayPalTranslationText')){
        class DOPBSPPayPalTranslationText{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize settings text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settings'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'settingsHelp'));
                
                /*
                 * Initialize order text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'order'));
                
                /*
                 * Initialize email text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'email'));
                
                /*
                 * Initialize SMS text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'sms'));
                
            }
            
            /*
             * PayPal settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settings($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'parent' => '',
                                        'text' => 'Settings - PayPal'));
               
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal',
                                        'de' => 'PayPal', // !
                                        'es' => 'PayPal', //!
                                        'fr' => 'PayPal')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Enable PayPal payment',
                                        'de' => 'PayPal-Zahlung aktivieren', // !
                                        'es' => 'Permita pago PayPal', //!
                                        'fr' => 'Permettez paiement PayPal')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_CREDIT_CARD',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Enable PayPal credit card payment',
                                        'de' => 'Aktivieren Sie die PayPal-Zahlung per Kreditkarte', // !
                                        'es' => 'Habilitar pago con tarjeta de crédito PayPal', //!
                                        'fr' => 'Activer le paiement par carte de crédit Paypal')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_USERNAME',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal API user name',
                                        'de' => 'PayPal-API-Benutzername', // !
                                        'es' => 'Nombre de usuario de PayPal API', //!
                                        'fr' => 'Nom d<<single-quote>>utilisateur de l<<single-quote>>API Paypal')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_PASSWORD',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal API password',
                                        'de' => 'PayPal-API-Kennwort', // !
                                        'es' => 'PayPal API contraseña', //!
                                        'fr' => 'PayPal mot de passe d<<single-quote>>API')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SIGNATURE',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal API signature',
                                        'de' => 'PayPal-API-Signatur', // !
                                        'es' => 'PayPal API firma', //!
                                        'fr' => 'Signature d<<single-quote>>API PayPal')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Enable PayPal sandbox',
                                        'de' => 'Aktivieren Sie PayPal Sandbox', // !
                                        'es' => 'Permita sandbox de PayPal', //!
                                        'fr' => 'Permettez le sandbox PayPal')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_USERNAME',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal API sandbox user name',
                                        'de' => 'PayPal API Sandbox-Benutzername', // !
                                        'es' => 'Nombre de usuario de PayPal API sandbox', //!
                                        'fr' => 'PayPal API sandbox nom d<<single-quote>>utilisateur')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_PASSWORD',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal API sandbox password',
                                        'de' => 'PayPal API Sandbox-Kennwort', // !
                                        'es' => 'Contraseña PayPal API sandbox', //!
                                        'fr' => 'Mot de passe Paypal API sandbox')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_SIGNATURE',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal API sandbox signature',
                                        'de' => 'PayPal API Sandbox-Signatur', // !
                                        'es' => 'PayPal API sandbox firma', //!
                                        'fr' => 'Signature Paypal API sandbox')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Enable refunds',
                                        'de' => 'Rückerstattungen aktivieren', // !
                                        'es' => 'Permita reembolsos', //!
                                        'fr' => 'Permettez remboursements')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_VALUE',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Refund value',
                                        'de' => 'Rückerstattungswert', // !
                                        'es' => 'Valor de reembolso', //!
                                        'fr' => 'Valeur de remboursement')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_TYPE',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Refund type',
                                        'de' => 'Art der Erstattung', // !
                                        'es' => 'Tipo de reembolso', //!
                                        'fr' => 'Type de remboursement')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_TYPE_FIXED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Fixed',
                                        'de' => 'Fest', // !
                                        'es' => 'Fijo', //!
                                        'fr' => 'Fixé')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_TYPE_PERCENT',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Percent',
                                        'de' => 'Prozent', // !
                                        'es' => 'Por ciento', //!
                                        'fr' => 'Pour cent')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REDIRECT',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Redirect after payment',
                                        'de' => 'Umleitung nach Zahlung', // !
                                        'es' => 'Remita después del pago', //!
                                        'fr' => 'Faites suivre après le paiement')); //!
                /*
                 * Notifications
                 */     
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_ADMIN',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal - Notify admin',
                                        'de' => 'PayPal - Administrator benachrichtigen', // !
                                        'es' => 'PayPal - Administrador de notificaciones', //!
                                        'fr' => 'Paypal - Notifier admin')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_USER',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal - Notify user',
                                        'de' => 'PayPal - Benutzer benachrichtigen', // !
                                        'es' => 'PayPal - Notificar al usuario', //!
                                        'fr' => 'Paypal - Notifier l<<single-quote>>utilisateur')); //!
                
                return $text;
            }
            
            /*
             * PayPal settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsHelp($text){
                array_push($text, array('key' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - PayPal - Help'));
                
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Default value: Disabled. Allow users to pay with PayPal. The period is instantly booked.',
                                        'de' => 'Standardwert: Deaktiviert. Erlauben Sie Benutzern, mit PayPal zu bezahlen. Die Periode wird sofort gebucht.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Permita que los usuarios paguen con PayPal. El periodo se reserva instantáneamente.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Permet aux utilisateurs de payer avec Paypal. La période est immédiatement réservée.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_CREDIT_CARD_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Default value: Disabled. Enable so that users can pay directly with their credit card.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie diese Option, damit Benutzer direkt mit ihrer Kreditkarte zahlen können.', // !
                                        'es' => 'Valor predeterminado: Discapacitado. Permite que los usuarios puedan pagar directamente con su tarjeta de crédito.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Activer pour que les utilisateurs puissent payer directement avec leur carte de crédit.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_USERNAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enter PayPal API credentials user name. View documentation to see from where you can get them.',
                                        'de' => 'Geben Sie den Benutzernamen für die PayPal-API-Anmeldeinformationen ein. Sehen Sie sich die Dokumentation an, von der Sie sie erhalten können.', // !
                                        'es' => 'Introduzca el nombre de usuario de las credenciales de PayPal API. Vea la documentación para ver desde dónde las puede obtener.', //!
                                        'fr' => 'Entrez le nom d<<single-quote>>utilisateur des identifiants de l<<single-quote>>API Paypal. Consultez la documentation pour voir d<<single-quote>>où vous pouvez les obtenir.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_PASSWORD_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enter PayPal API credentials password. View documentation to see from where you can get them.',
                                        'de' => 'Geben Sie das Kennwort für die PayPal-API-Anmeldeinformationen ein. Sehen Sie sich die Dokumentation an, von der Sie sie erhalten können.', // !
                                        'es' => 'Introduzca la contraseña de las credenciales de PayPal API. Vea la documentación para ver desde dónde puede conseguirlas.', //!
                                        'fr' => 'Entrez le mot de passe d<<single-quote>>identification de l<<single-quote>>API Paypal. Consultez la documentation pour voir d<<single-quote>>où vous pouvez les obtenir.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SIGNATURE_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enter PayPal API credentials signature. View documentation to see from where you can get them.',
                                        'de' => 'Geben Sie die Signatur für die PayPal-API-Anmeldeinformationen ein. Sehen Sie sich die Dokumentation an, von der Sie sie erhalten können.', // !
                                        'es' => 'Introduzca la firma de credenciales de PayPal API. Vea la documentación para ver desde dónde puede conseguirlas.', //!
                                        'fr' => 'Entrez la signature d<<single-quote>>identification de l<<single-quote>>API Paypal. Consultez la documentation pour voir d<<single-quote>>où vous pouvez les obtenir.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Default value: Disabled. Enable to use PayPal sandbox features.',
                                        'de' => 'Standardwert: Deaktiviert. Aktivieren Sie die Verwendung der Sandbox-Funktionen von PayPal.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Permite utilizar las funciones de la sandbox de PayPal.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Permet d<<single-quote>>utiliser les fonctions de bac à sable Paypal.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_USERNAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enter PayPal API sandbox credentials user name.',
                                        'de' => 'Geben Sie den Benutzernamen für die PayPal-API-Sandbox-Anmeldeinformationen ein.', // !
                                        'es' => 'Introduzca el nombre de usuario de PayPal API sandbox credenciales.', //!
                                        'fr' => 'Entrez le nom d<<single-quote>>utilisateur de l<<single-quote>>API Paypal.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_PASSWORD_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enter PayPal API sandbox credentials password.',
                                        'de' => 'Geben Sie das Passwort für die PayPal-API-Sandbox-Anmeldeinformationen ein.', // !
                                        'es' => 'Introduzca la contraseña de PayPal API sandbox credenciales.', //!
                                        'fr' => 'Entrez le mot de passe d<<single-quote>>identification de l<<single-quote>>API Paypal.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_SIGNATURE_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enter PayPal API sandbox credentials signature.',
                                        'de' => 'Geben Sie die Signatur für die PayPal-API-Sandbox-Anmeldeinformationen ein.', // !
                                        'es' => 'Introduzca la firma de credenciales de PayPal API sandbox.', //!
                                        'fr' => 'Entrez la signature d<<single-quote>>identification de l<<single-quote>>API Paypal.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Default value: Disabled. Users that paid with PayPal will be refunded automatically if a reservation is canceled.',
                                        'de' => 'Standardwert: Deaktiviert. Benutzer, die mit PayPal bezahlt haben, werden automatisch zurückerstattet, wenn eine Reservierung storniert wird.', // !
                                        'es' => 'Valor predeterminado: Desactivado. Los usuarios que pagaron con PayPal serán reembolsados automáticamente si se cancela una reserva.', //!
                                        'fr' => 'Valeur par défaut : Désactivé. Les utilisateurs qui ont payé avec Paypal seront remboursés automatiquement si une réservation est annulée.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_VALUE_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Default value: 100. Enter the refund value from reservation total price.',
                                        'de' => 'Standardwert: 100. Geben Sie den Erstattungswert für den Gesamtpreis der Reservierung ein.', // !
                                        'es' => 'Valor predeterminado: 100. Introduzca el valor de la devolución desde el precio total de la reserva.', //!
                                        'fr' => 'Valeur par défaut : 100. Entrez la valeur du remboursement à partir du prix total de la réservation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REFUND_TYPE_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Default value: Percent. Select refund value type. It can be a fixed value or a percent from reservation price.',
                                        'de' => 'Standardwert: Prozent. Wählen Sie den Rückerstattungswerttyp aus. Es kann ein fester Wert oder ein Prozent vom Reservierungspreis sein.', // !
                                        'es' => 'Valor predeterminado: Porcentaje. Seleccione el tipo de valor de reembolso. Puede ser un valor fijo o un porcentaje del precio de reserva.', //!
                                        'fr' => 'Valeur par défaut : Pourcentage. Sélectionnez le type de valeur de remboursement. Il peut être une valeur fixe ou un pourcentage du prix de réservation.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REDIRECT_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enter the URL where to redirect after the payment has been completed. Leave it blank to redirect back to the calendar.',
                                        'de' => 'Geben Sie die URL ein, unter der die Weiterleitung nach Abschluss der Zahlung erfolgen soll. Lassen Sie das Feld leer, um zum Kalender zurückzukehren.', // !
                                        'es' => 'Introduzca la dirección URL donde redirigir después de que el pago ha sido completado. Deje en blanco para redirigir de nuevo al calendario.', //!
                                        'fr' => 'Entrez l<<single-quote>>URL où rediriger après que le paiement a été terminé. Laissez vide pour rediriger vers le calendrier.')); //!
                /*
                 * Notifications
                 */
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_ADMIN_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enable to send an email notification to admin on book request payed with PayPal.',
                                        'de' => 'Aktivieren Sie diese Option, um eine E-Mail-Benachrichtigung an den Administrator zu senden, wenn die Buchanfrage mit PayPal bezahlt wurde.', // !
                                        'es' => 'Habilitar para enviar una notificación por correo electrónico a la administración en la solicitud de libro pagado con PayPal.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer un email de notification à l<<single-quote>>administration sur demande de livre payé avec Paypal.')); //!
                array_push($text, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_USER_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enable to send an email notification to user on book request payed with PayPal.',
                                        'de' => 'Aktivieren Sie diese Option, um eine E-Mail-Benachrichtigung an den Benutzer zu senden, wenn der Buchantrag mit PayPal bezahlt wurde.', // !
                                        'es' => 'Permite enviar una notificación por correo electrónico al usuario a petición de libro pagado con PayPal.', //!
                                        'fr' => 'Permet d<<single-quote>>envoyer une notification par email à l<<single-quote>>utilisateur sur demande de livre payé avec Paypal.')); //!
                
                return $text;
            }

            /*
             * PayPal order text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function order($text){
                array_push($text, array('key' => 'PARENT_ORDER_PAYMENT_GATEWAYS_PAYPAL',
                                        'parent' => '',
                                        'text' => 'Order - PayPal'));
                /*
                 * Payment method.
                 */
                array_push($text, array('key' => 'ORDER_PAYMENT_METHOD_PAYPAL',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'PayPal',
                                        'de' => 'PayPal', // !
                                        'es' => 'PayPal', //!
                                        'fr' => 'PayPal',
                                        'location' => 'all'));
                /*
                 * Front end.
                 */
                array_push($text, array('key' => 'ORDER_PAYMENT_GATEWAYS_PAYPAL',
                                        'parent' => 'PARENT_ORDER_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Pay on PayPal (instant booking)',
                                        'de' => 'Bezahlung mit PayPal (sofortige buchung)',
                                        'es' => 'Pago en PayPal (reserva instantánea)', //!                             
                                        'fr' => 'Payer sur PayPal (réservation instantanée)',
                                        'nl' => 'Betaal via PayPal (direct boeken)',
                                        'pl' => 'Pay on PayPal (instant booking)',
                                        'location' => 'all'));
                array_push($text, array('key' => 'ORDER_PAYMENT_GATEWAYS_PAYPAL_SUCCESS',
                                        'parent' => 'PARENT_ORDER_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Your payment was approved and services are booked.',
                                        'de' => 'Ihre zahlung wurde akzeptiert und die leistungen sind gebucht.',
                                        'es' => 'Su pago fue aprobado y los servicios están reservados.', //!
                                        'fr' => 'Votre paiement a été approuvé et vos services sont réservés.',
                                        'nl' => 'Uw betaling is goedgekeurd en de diensten zijn geboekt.',                                      
                                        'pl' => 'Płatność została zaakceptowana i rezerwacj potwierdzona.',
                                        'location' => 'all')); 
                array_push($text, array('key' => 'ORDER_PAYMENT_GATEWAYS_PAYPAL_CANCEL',
                                        'parent' => 'PARENT_ORDER_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'You canceled your payment with PayPal. Please try again.',
                                        'de' => 'Sie haben Ihre Zahlung mit PayPal storniert. Bitte versuchen Sie es erneut.', // !
                                        'es' => 'Cancelaste tu pago con PayPal. Por favor, inténtalo de nuevo.', //!
                                        'fr' => 'You canceled your payment with PayPal. Please try again.', //!
                                        'location' => 'all')); 
                array_push($text, array('key' => 'ORDER_PAYMENT_GATEWAYS_PAYPAL_ERROR',
                                        'parent' => 'PARENT_ORDER_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'There was an error while processing PayPal payment. Please try again.',
                                        'de' => 'Es gab einen fehler während der Paypal-bezahlung. Bitte versuchen Sie es erneut.',
                                        'es' => 'Hubo un error al procesar el pago de PayPal. Por favor, intente de nuevo.', //!
                                        'fr' => 'Il y a eu une erreur lors du traitement de paiement PayPal. Veuillez essayer à nouveau.',
                                        'nl' => 'Er is een fout opgetreden tijdens het verwerken van PayPal-betaling. Probeer het opnieuw.',                                       
                                        'pl' => 'Wystapił bład podczas płatności, prosimy spróbować ponownie.',
                                        'location' => 'all'));
                
                return $text;
            }

            /*
             * PayPal email text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function email($text){
                array_push($text, array('key' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'parent' => '',
                                        'text' => 'Email templates - PayPal default messages'));
                /*
                 * Admin
                 */
                array_push($text, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_PAYPAL_ADMIN',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'PayPal admin notification',
                                        'de' => 'PayPal Admin Benachrichtigung', // !
                                        'es' => 'PayPal notificación de admón', //!
                                        'fr' => 'PayPal notification d<<single-quote>>administration')); //!
                array_push($text, array('key' => 'EMAILS_DEFAULT_PAYPAL_ADMIN_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'You received a booking request.',
                                        'de' => 'Sie haben eine buchungsanfrage erhalten.',
                                        'es' => 'Recibió una solicitud de reserva.', //!
                                        'fr' => 'Vous avez reçu une demande de réservation.',
                                        'nl' => 'U heeft een boekingsaanvraag ontvangen',                                       
                                        'pl' => 'Otrzymałeś nową rezerwację.'));
                array_push($text, array('key' => 'EMAILS_DEFAULT_PAYPAL_ADMIN',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'Below are the details. Payment has been done via PayPal and the period has been booked.',
                                        'de' => 'Details finden sie nachfolgend. Es wurde mit PayPal bezahlt und der zeitraum wurde gebucht.',
                                        'es' => 'Abajo están los detalles. El pago se ha hecho a través de PayPal y el período ha sido reservado.', //!
                                        'fr' => 'Voici les détails. Le paiement a été effectué via PayPal et la période a été réservée.',
                                        'nl' => 'Hieronder staan de gegevens. De betaling is gedaan via PayPal en de periode is geboekt.',                                        
                                        'pl' => 'Szczegóły zamówienia, rezerwacja została opłacona i termin zarezerwowany.'));
                /*
                 * User
                 */
                array_push($text, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_PAYPAL_USER',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'PayPal user notification',
                                        'de' => 'PayPal Benutzerbenachrichtigung', // !
                                        'es' => 'PayPal notificación de usuario', //!
                                        'fr' => 'PayPal notification d<<single-quote>>utilisateur')); //!           
                array_push($text, array('key' => 'EMAILS_DEFAULT_PAYPAL_USER_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'Your booking request has been sent.',
                                        'de' => 'Ihre Buchungsanfrage wurde versendet.',
                                        'es' => 'Su solicitud de reserva ha sido enviada.', //!
                                        'fr' => 'Votre demande de réservation a été envoyée.',
                                        'nl' => 'Uw boekingsverzoek is verzonden.',        
                                        'pl' => 'Zamówienie została wysłane.'));
                array_push($text, array('key' => 'EMAILS_DEFAULT_PAYPAL_USER',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'The period has been book. Below are the details.',
                                        'de' => 'Der zeitraum wurde gebucht. Details finden sie nachfolgend.',
                                        'es' => 'El período ha sido libro. Abajo están los detalles.', //!
                                        'fr' => 'La période a été réservée. Voici les détails.',
                                        'nl' => 'De periode is geboekt. Hieronder staan de gegevens.',                                    
                                        'pl' => 'Termin został zarezerwowany.'));
                
                return $text;
            }
            /*
             * PayPal SMS text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function sms($text){
                array_push($text, array('key' => 'PARENT_SMSES_DEFAULT_PAYPAL',
                                        'parent' => '',
                                        'text' => 'SMS templates - PayPal default messages'));
                /*
                 * Admin
                 */
                array_push($text, array('key' => 'SMSES_SMS_TEMPLATE_SELECT_PAYPAL_ADMIN',
                                        'parent' => 'PARENT_SMSES_DEFAULT_PAYPAL',
                                        'text' => 'PayPal admin notification',
                                        'de' => 'PayPal Admin Benachrichtigung', // !
                                        'es' => 'PayPal notificación de admón', //!
                                        'fr' => 'PayPal notification d<<single-quote>>administration')); //!
                array_push($text, array('key' => 'SMSES_DEFAULT_PAYPAL_ADMIN_SUBJECT',
                                        'parent' => 'PARENT_SMSES_DEFAULT_PAYPAL',
                                        'text' => 'You received a booking request.',
                                        'de' => 'Sie haben eine Buchungsanfrage erhalten.', // !
                                        'es' => 'Recibió una solicitud de reserva.', //!
                                        'fr' => 'Vous avez reçu une demande de réservation.')); //!
                array_push($text, array('key' => 'SMSES_DEFAULT_PAYPAL_ADMIN',
                                        'parent' => 'PARENT_SMSES_DEFAULT_PAYPAL',
                                        'text' => 'Payment has been done via PayPal and the period has been booked.',
                                        'de' => 'Die Zahlung erfolgte über PayPal und der Zeitraum wurde gebucht.', // !
                                        'es' => 'El pago se ha hecho a través de PayPal y el período ha sido reservado.', //!
                                        'fr' => 'Le paiement a été effectué via Paypal et la période a été réservée.')); //!
                /*
                 * User
                 */
                array_push($text, array('key' => 'SMSES_SMS_TEMPLATE_SELECT_PAYPAL_USER',
                                        'parent' => 'PARENT_SMSES_DEFAULT_PAYPAL',
                                        'text' => 'PayPal user notification',
                                        'de' => 'PayPal Benutzerbenachrichtigung', // !
                                        'es' => 'PayPal notificación de usuario', //!
                                        'fr' => 'Notification d<<single-quote>>utilisateur de PayPal')); //!
                array_push($text, array('key' => 'SMSES_DEFAULT_PAYPAL_USER_SUBJECT',
                                        'parent' => 'PARENT_SMSES_DEFAULT_PAYPAL',
                                        'text' => 'Your booking request has been sent.',
                                        'de' => 'Ihre Buchungsanfrage wurde gesendet.', // !
                                        'es' => 'Su solicitud de reserva ha sido enviada.', //!
                                        'fr' => 'Votre demande de réservation a été envoyée.')); //!
                array_push($text, array('key' => 'SMSES_DEFAULT_PAYPAL_USER',
                                        'parent' => 'PARENT_SMS_DEFAULT_PAYPAL',
                                        'text' => 'The period has been book. Below are the details.',
                                        'de' => 'Die Periode ist Buch gewesen. Unten finden Sie die Details.', // !
                                        'es' => 'El período ha sido libro. Abajo están los detalles.', //!
                                        'fr' => 'La période a été livre. Voici les détails.')); //!
                
                return $text;
            }
        }
    }