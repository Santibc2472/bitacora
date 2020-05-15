<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* File                    : includes/translation/class-translation-text-smses.php
* Author                  : PINPOINT.WORLD
* Copyright               : © 2018 PINPOINT.WORLD
* Website                 : http://www.pinpoint.world
* Description             : SMSes translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextSmses')){
        class DOPBSPTranslationTextSmses{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize SMSes text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'smses'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'smsesDefault'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'smsesSms'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'smsesAddSms'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'smsesDeleteSms'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'smsesHelp'));
            }
            
            /*
             * SMSes text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function smses($text){
                array_push($text, array('key' => 'PARENT_SMSES',
                                        'parent' => '',
                                        'text' => 'SMS templates'));
                
                array_push($text, array('key' => 'SMSES_TITLE',
                                        'parent' => 'PARENT_SMSES',
                                        'text' => 'SMS templates',
                                        'de' => 'SMS-Vorlagen', // ! 
                                        'es' => 'SMS plantillas', //!
                                        'fr' => 'Modèles de SMS')); //!
                array_push($text, array('key' => 'SMSES_CREATED_BY',
                                        'parent' => 'PARENT_SMSES',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von', // ! 
                                        'es' => 'Creado por', //!
                                        'fr' => 'Créé par')); //!
                array_push($text, array('key' => 'SMSES_LOAD_SUCCESS',
                                        'parent' => 'PARENT_SMSES',
                                        'text' => 'SMS templates  list loaded.',
                                        'de' => 'SMS-Vorlagenliste geladen.', // ! 
                                        'es' => 'Lista de plantillas SMS cargadas.', //!
                                        'fr' => 'Liste des modèles de SMS chargée.')); //!
                array_push($text, array('key' => 'SMSES_NO_SMSES',
                                        'parent' => 'PARENT_SMSES',
                                        'text' => 'No SMS templates. Click the above "plus" icon to add new ones.',
                                        'de' => 'Keine SMS-Vorlagen. Klicken Sie auf das obige "Plus"-Symbol, um neue hinzuzufügen.', // ! 
                                        'es' => 'No hay plantillas de SMS. Haga clic en el icono de arriba "más" para agregar nuevas.', //!
                                        'fr' => 'Pas de modèles SMS. Cliquez sur l<<single-quote>>icône "plus" ci-dessus pour en ajouter de nouveaux.')); //!
                
                return $text;
            }
            
            /*
             * SMSes default text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function smsesDefault($text){
                array_push($text, array('key' => 'PARENT_SMSES_DEFAULT',
                                        'parent' => '',
                                        'text' => 'SMS templates - Default messages'));
                
                array_push($text, array('key' => 'SMSES_DEFAULT_NAME',
                                        'parent' => 'PARENT_SMSES_DEFAULT',
                                        'text' => 'Default SMS templates',
                                        'de' => 'Standard-SMS-Vorlagen', // ! 
                                        'es' => 'SMS por defecto', //!
                                        'fr' => 'Modèles de SMS par défaut')); //!
                
                /*
                 * Default booking, with payment on arrival.
                 */
                array_push($text, array('key' => 'SMSES_DEFAULT_BOOK_ADMIN',
                                        'parent' => 'PARENT_SMSES_DEFAULT',
                                        'text' => 'You received a booking request.',
                                        'de' => 'Sie haben eine Buchungsanfrage erhalten.', // ! 
                                        'es' => 'Recibió una solicitud de reserva.', //!
                                        'fr' => 'Vous avez reçu une demande de réservation.')); //!
                array_push($text, array('key' => 'SMSES_DEFAULT_BOOK_USER',
                                        'parent' => 'PARENT_SMSES_DEFAULT',
                                        'text' => 'Your booking request has been sent.',
                                        'de' => 'Ihre Buchungsanfrage wurde gesendet.', // ! 
                                        'es' => 'Su solicitud de reserva ha sido enviada.', //!
                                        'fr' => 'Votre demande de réservation a été envoyée.')); //!
                /*
                 * Booking with approval.
                 */
                array_push($text, array('key' => 'SMSES_DEFAULT_BOOK_WITH_APPROVAL_ADMIN',
                                        'parent' => 'PARENT_SMSES_DEFAULT',
                                        'text' => 'You received a booking request.',
                                        'de' => 'Sie haben eine Buchungsanfrage erhalten.', // ! 
                                        'es' => 'Recibió una solicitud de reserva.', //!
                                        'fr' => 'Vous avez reçu une demande de réservation.')); //!
                array_push($text, array('key' => 'SMSES_DEFAULT_BOOK_WITH_APPROVAL_USER',
                                        'parent' => 'PARENT_SMSES_DEFAULT',
                                        'text' => 'Your booking request has been sent.Please wait for approval.',
                                        'de' => 'Ihre Buchungsanfrage wurde gesendet.Bitte warten Sie auf die Genehmigung.', // ! 
                                        'es' => 'Su solicitud de reserva ha sido enviada. Por favor espere la aprobación.', //!
                                        'fr' => 'Votre demande de réservation a été envoyée. Veuillez attendre l<<single-quote>>approbation.')); //!
                /*
                 * Approved reservation.
                 */
                array_push($text, array('key' => 'SMSES_DEFAULT_APPROVED',
                                        'parent' => 'PARENT_SMSES_DEFAULT',
                                        'text' => 'Your booking request has been approved.',
                                        'de' => 'Ihre Buchungsanfrage wurde genehmigt.', // ! 
                                        'es' => 'Su solicitud de reserva ha sido enviada. Por favor espere la aprobación.', //!
                                        'fr' => 'Votre demande de réservation a été approuvée.')); //!
                /*
                 * Canceled reservation.
                 */
                array_push($text, array('key' => 'SMSES_DEFAULT_CANCELED',
                                        'parent' => 'PARENT_SMSES_DEFAULT',
                                        'text' => 'Your booking request has been canceled.',
                                        'de' => 'Ihre Buchungsanfrage wurde storniert.', // ! 
                                        'es' => 'Su solicitud de reserva ha sido cancelada.', //!
                                        'fr' => 'Votre demande de réservation a été annulée.')); //!
                /*
                 * Rejected reservation.
                 */
                array_push($text, array('key' => 'SMSES_DEFAULT_REJECTED',
                                        'parent' => 'PARENT_SMSES_DEFAULT',
                                        'text' => 'Your booking request has been rejected.',
                                        'de' => 'Ihre Buchungsanfrage wurde abgelehnt', // ! 
                                        'es' => 'Su solicitud de reserva ha sido rechazada.', //!
                                        'fr' => 'Votre demande de réservation a été rejetée.')); //!
                
                return $text;
            }
            
            /*
             * SMSes - Sms text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function smsesSms($text){
                array_push($text, array('key' => 'PARENT_SMSES_SMS',
                                        'parent' => '',
                                        'text' => 'SMS templates - Templates'));
                
                array_push($text, array('key' => 'SMSES_SMS_NAME',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'Name',
                                        'de' => 'Name', // ! 
                                        'es' => 'Nombre', //!
                                        'fr' => 'Nom')); //!
                array_push($text, array('key' => 'SMSES_SMS_LANGUAGE',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'Language',
                                        'de' => 'Sprache', // ! 
                                        'es' => 'Lengua', //!
                                        'fr' => 'Langue')); //!
                
                array_push($text, array('key' => 'SMSES_SMS_TEMPLATE_SELECT',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'Select template',
                                        'de' => 'Vorlage wählen', // ! 
                                        'es' => 'Plantilla escogida', //!
                                        'fr' => 'Sélectionner un modèle')); //!
                array_push($text, array('key' => 'SMSES_SMS_TEMPLATE_SELECT_BOOK_ADMIN',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'Admin notification',
                                        'de' => 'Administrator Benachrichtigung', // !
                                        'es' => 'Notificación de admón', //!
                                        'fr' => 'Notification d<<single-quote>>administration')); //!
                array_push($text, array('key' => 'SMSES_SMS_TEMPLATE_SELECT_BOOK_USER',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'User notification',
                                        'de' => 'Benutzer Benachrichtigung', // ! 
                                        'es' => 'Notificación de usuario', //!
                                        'fr' => 'Notification d<<single-quote>>utilisateur')); //!
                array_push($text, array('key' => 'SMSES_SMS_TEMPLATE_SELECT_BOOK_WITH_APPROVAL_ADMIN',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'Instant approval admin notification',
                                        'de' => 'Administrator Benachrichtigung für sofortige Genehmigung', // ! 
                                        'es' => 'Notificación administrativa de aprobación instantánea', //!
                                        'fr' => 'Notification administrative d<<single-quote>>approbation instantanée')); //!
                array_push($text, array('key' => 'SMSES_SMS_TEMPLATE_SELECT_BOOK_WITH_APPROVAL_USER',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'Instant approval user notification',
                                        'de' => 'Benutzer Benachrichtigung für sofortige Genehmigung', // ! 
                                        'es' => 'Notificación del usuario de aprobación instantánea', //!
                                        'fr' => 'Notification utilisateur d<<single-quote>>homologation instantanée')); //!
                array_push($text, array('key' => 'SMSES_SMS_TEMPLATE_SELECT_APPROVED',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'Approve reservation',
                                        'de' => 'Reservierung genehmigen', // ! 
                                        'es' => 'Apruebe reserva', //!
                                        'fr' => 'Approuvez la réservation')); //!
                array_push($text, array('key' => 'SMSES_SMS_TEMPLATE_SELECT_CANCELED',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'Cancel reservation',
                                        'de' => 'Reservierung stornieren', // ! 
                                        'es' => 'Cancele reserva', //!
                                        'fr' => 'Annulez réservation')); //!
                array_push($text, array('key' => 'SMSES_SMS_TEMPLATE_SELECT_REJECTED',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'Reject reservation',
                                        'de' => 'Reservierung ablehnen', // ! 
                                        'es' => 'Reserva de desecho', //!
                                        'fr' => 'Rejetez la réservation')); //!
                array_push($text, array('key' => 'SMSES_SMS_MESSAGE',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'Message',
                                        'de' => 'Nachricht', // ! 
                                        'es' => 'Mensaje', //!
                                        'fr' => 'Message')); //!
                
                array_push($text, array('key' => 'SMSES_SMS_LOADED',
                                        'parent' => 'PARENT_SMSES_SMS',
                                        'text' => 'SMS templates loaded.',
                                        'de' => 'SMS-Vorlagen geladen.', // !
                                        'es' => 'SMS plantillas cargó.', //!
                                        'fr' => 'Les modèles de SMS ont chargé.')); //!
                
                return $text;
            }
            
            /*
             * SMS templates - Add sms text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function smsesAddSms($text){
                array_push($text, array('key' => 'PARENT_SMSES_ADD_SMS',
                                        'parent' => '',
                                        'text' => 'SMS templates - Add templates'));
                
                array_push($text, array('key' => 'SMSES_ADD_SMS_NAME',
                                        'parent' => 'PARENT_SMSES_ADD_SMS',
                                        'text' => 'New SMS templates',
                                        'de' => 'Neue SMS-Vorlagen', // ! 
                                        'es' => 'Nuevas plantillas SMS', //!
                                        'fr' => 'Nouveaux modèles de SMS')); //!
                array_push($text, array('key' => 'SMSES_ADD_SMS_SUBMIT',
                                        'parent' => 'PARENT_SMSES_ADD_SMS',
                                        'text' => 'Add SMS templates',
                                        'de' => 'SMS-Vorlagen hinzufügen', // ! 
                                        'es' => 'Añada plantillas SMS', //!
                                        'fr' => 'Ajoutez modèles de SMS')); //!
                array_push($text, array('key' => 'SMSES_ADD_SMS_ADDING',
                                        'parent' => 'PARENT_SMSES_ADD_SMS',
                                        'text' => 'Adding new SMS templates ...',
                                        'de' => 'Hinzufügen neuer SMS-Vorlagen ...', // ! 
                                        'es' => 'Añadir nuevas plantillas SMS ...', //!
                                        'fr' => 'Ajout de nouveaux modèles de SMS ...')); //!
                array_push($text, array('key' => 'SMSES_ADD_SMS_SUCCESS',
                                        'parent' => 'PARENT_SMSES_ADD_SMS',
                                        'text' => 'You have successfully added new SMS templates.',
                                        'de' => 'Sie haben erfolgreich neue SMS-Vorlagen hinzugefügt.', // ! 
                                        'es' => 'Ha añadido con éxito nuevas plantillas de SMS.', //!
                                        'fr' => 'Vous avez réussi à ajouter de nouveaux modèles de SMS.')); //!
                
                return $text;
            }
            
            /*
             * SMSes - Delete sms text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function smsesDeleteSms($text){
                array_push($text, array('key' => 'PARENT_SMSES_DELETE_SMS',
                                        'parent' => '',
                                        'text' => 'SMS templates - Delete templates'));
                
                array_push($text, array('key' => 'SMSES_DELETE_SMS_CONFIRMATION',
                                        'parent' => 'PARENT_SMSES_DELETE_SMS',
                                        'text' => 'Are you sure you want to delete the SMS templates?',
                                        'de' => 'Möchten Sie die SMS-Vorlagen wirklich löschen?', // ! 
                                        'es' => '¿Estás seguro de que quieres eliminar las plantillas de SMS?', //!
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer les modèles de SMS?')); //!
                array_push($text, array('key' => 'SMSES_DELETE_SMS_SUBMIT',
                                        'parent' => 'PARENT_SMSES_DELETE_SMS',
                                        'text' => 'Delete SMS templates',
                                        'de' => 'SMS-Vorlagen löschen', // ! 
                                        'es' => 'Suprima plantillas SMS', //!
                                        'fr' => 'Supprimez modèles de SMS')); //!
                array_push($text, array('key' => 'SMSES_DELETE_SMS_DELETING',
                                        'parent' => 'PARENT_SMSES_DELETE_SMS',
                                        'text' => 'Deleting SMS templates ...',
                                        'de' => 'SMS-Vorlagen werden gelöscht ...', // ! 
                                        'es' => 'Supresión SMS plantillas...', //!
                                        'fr' => 'Suppression de modèles de SMS...')); //!
                array_push($text, array('key' => 'SMSES_DELETE_SMS_SUCCESS',
                                        'parent' => 'PARENT_SMSES_DELETE_SMS',
                                        'text' => 'You have successfully deleted the SMS templates.',
                                        'de' => 'Sie haben die SMS-Vorlagen erfolgreich gelöscht.', // ! 
                                        'es' => 'Ha eliminado con éxito las plantillas de SMS.', //!
                                        'fr' => 'Vous avez réussi à supprimer les modèles de SMS.')); //!
                
                return $text;
            }
            
            /*
             * SMSes - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function smsesHelp($text){
                array_push($text, array('key' => 'PARENT_SMSES_HELP',
                                        'parent' => '',
                                        'text' => 'SMS templates - Help'));
                
                array_push($text, array('key' => 'SMSES_HELP',
                                        'parent' => 'PARENT_SMSES_HELP',
                                        'text' => 'Click on a templates item to open the editing area.',
                                        'de' => 'Klicken Sie auf ein Vorlagenelement, um den Bearbeitungsbereich zu öffnen.', // ! 
                                        'es' => 'Haga clic en un elemento de plantillas para abrir el área de edición.', //!
                                        'fr' => 'Cliquez sur un élément des modèles pour ouvrir la zone d<<single-quote>>édition.')); //!
                array_push($text, array('key' => 'SMSES_ADD_SMS_HELP',
                                        'parent' => 'PARENT_SMSES_HELP',
                                        'text' => 'Click on the "plus" icon to add SMS templates.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um SMS-Vorlagen hinzuzufügen.', // ! 
                                        'es' => 'Haga clic en el icono "plus" para agregar plantillas de SMS.', //!
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter des modèles SMS.')); //!
                
                /*
                 * Sms help.
                 */
                array_push($text, array('key' => 'SMSES_SMS_HELP',
                                        'parent' => 'PARENT_SMSES_HELP',
                                        'text' => 'Click the "trash" icon to delete the sms.',
                                        'de' => 'Klicken Sie auf das Symbol "Papierkorb", um die SMS zu löschen.', // ! 
                                        'es' => 'Haga clic en el icono "basura" para eliminar los sms.', //!
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "trash" pour supprimer les SMS.')); //!
                array_push($text, array('key' => 'SMSES_SMS_NAME_HELP',
                                        'parent' => 'PARENT_SMSES_HELP',
                                        'text' => 'Change SMS templates name.',
                                        'de' => 'Ändern Sie den Namen der SMS-Vorlagen.', // ! 
                                        'es' => 'Cambiar el nombre de las plantillas de SMS.', //!
                                        'fr' => 'Changer le nom des modèles SMS.')); //!
                array_push($text, array('key' => 'SMSES_SMS_LANGUAGE_HELP',
                                        'parent' => 'PARENT_SMSES_HELP',
                                        'text' => 'Change to the language you want to edit the SMS templates.',
                                        'de' => 'Wechseln Sie in die Sprache, in der Sie die SMS-Vorlagen bearbeiten möchten.', // ! 
                                        'es' => 'Cambie al idioma que desea editar las plantillas de SMS.', //!
                                        'fr' => 'Modifiez la langue dans laquelle vous souhaitez modifier les modèles de SMS.')); //!
                array_push($text, array('key' => 'SMSES_SMS_TEMPLATE_SELECT_HELP',
                                        'parent' => 'PARENT_SMSES_HELP',
                                        'text' => 'Select the template you want to edit and modify the message.',
                                        'de' => 'Wählen Sie die Vorlage aus, die Sie bearbeiten möchten, und ändern Sie die Nachricht.', // !
                                        'es' => 'Seleccione la plantilla que desea editar y modificar el mensaje.', //!
                                        'fr' => 'Sélectionnez le modèle que vous voulez modifier et modifiez le message.')); //!
                
                return $text;
            }
        }
    }