<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-emails.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Emails translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextEmails')){
        class DOPBSPTranslationTextEmails{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize emails text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'emails'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'emailsDefault'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'emailsEmail'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'emailsAddEmail'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'emailsDeleteEmail'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'emailsHelp'));
            }
            
            /*
             * Emails text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function emails($text){
                array_push($text, array('key' => 'PARENT_EMAILS',
                                        'parent' => '',
                                        'text' => 'Email templates'));
                
                array_push($text, array('key' => 'EMAILS_TITLE',
                                        'parent' => 'PARENT_EMAILS',
                                        'text' => 'Email templates',
                                        'de' => 'E-Mail-Vorlagen', // !
                                        'es' => 'Plantillas de correo electrónico', // !
                                        'fr' => 'Modèles de courrier électronique')); //!
                array_push($text, array('key' => 'EMAILS_CREATED_BY',
                                        'parent' => 'PARENT_EMAILS',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von', // !
                                        'es' => 'Creada por', // !
                                        'fr' => 'Créé par')); //!
                array_push($text, array('key' => 'EMAILS_LOAD_SUCCESS',
                                        'parent' => 'PARENT_EMAILS',
                                        'text' => 'Email templates  list loaded.',
                                        'de' => 'Liste der E-Mail-Vorlagen geladen.', // !
                                        'es' => 'Lista de plantillas de correo electrónico cargada.', // !
                                        'fr' => 'Liste des modèles de courriel chargée.')); //!
                array_push($text, array('key' => 'EMAILS_NO_EMAILS',
                                        'parent' => 'PARENT_EMAILS',
                                        'text' => 'No email templates. Click the above "plus" icon to add new ones.',
                                        'de' => 'Keine E-Mail-Vorlagen. Klicken Sie auf das obige "Plus"-Symbol, um neue hinzuzufügen.', // !
                                        'es' => 'No hay plantillas de de correo electrónico. Haga clic en el icono de arriba "más" para agregar nuevas.', // !
                                        'fr' => 'Aucun modèle de courriel. Cliquez sur l<<single-quote>>icône "plus" ci-dessus pour en ajouter de nouveaux.')); //!
                
                return $text;
            }
            
            /*
             * Emails default text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function emailsDefault($text){
                array_push($text, array('key' => 'PARENT_EMAILS_DEFAULT',
                                        'parent' => '',
                                        'text' => 'Email templates - Default messages'));
                
                array_push($text, array('key' => 'EMAILS_DEFAULT_NAME',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'Default email templates',
                                        'de' => 'Standard-E-Mail-Vorlagen', // !
                                        'es' => 'Plantillas de correo electrónico por defecto', // !
                                        'fr' => 'Modèles de courrier électronique par défaut')); //!
                
                /*
                 * Default booking, with payment on arrival.
                 */
                array_push($text, array('key' => 'EMAILS_DEFAULT_BOOK_ADMIN_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'You received a booking request.',
                                        'de' => 'Sie haben eine buchungsanfrage erhalten.',
                                        'es' => 'Recibió una solicitud de reserva.', // !
                                        'fr' => 'Vous avez reçu une demande de réservation.',
                                        'nl' => 'U heeft een boekingsaanvraag ontvangen',
                                        'pl' => 'Otrzymałeś nową rezerwację.'));
                array_push($text, array('key' => 'EMAILS_DEFAULT_BOOK_ADMIN',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'Below are the details. Go to admin to approve or reject the request.',
                                        'de' => 'Details finden sie nachfolgend. Öffnen sie das dashboard um die anfrage zu genehmigen oder die anfrage abzulehnen.',
                                        'es' => 'Abajo están los detalles. Vaya a la administración para aprobar o rechazar la solicitud.', // !
                                        'fr' => 'Voici les détails. Aller à l<<single-quote>>administration pour approuver ou rejeter la demande.',
                                        'nl' => 'Hieronder staan de gegevens. Ga naar het administratie gedeelte om de boeking te accepteren of af te wijzen.',
                                        'pl' => 'Szczegóły zamówienia, przejdź do panelu aby zaakceptować.'));
                array_push($text, array('key' => 'EMAILS_DEFAULT_BOOK_USER_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'Your booking request has been sent.',
                                        'de' => 'Ihre Buchungsanfrage wurde versendet.',
                                        'es' => 'Su solicitud de reserva ha sido enviada.', // !
                                        'fr' => 'Votre demande de réservation a été envoyée.',
                                        'nl' => 'Uw boekingsverzoek is verzonden.',
                                        'pl' => 'Zamówienie została wysłane.'));
                array_push($text, array('key' => 'EMAILS_DEFAULT_BOOK_USER',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'Please wait for approval. Below are the details.',
                                        'de' => 'BItte warten sie auf die bestätigung. Details finden sie nachfolgend.',
                                        'es' => 'Por favor espere su aprobación. A continuación se detallan los detalles.', // !
                                        'fr' => 'Veuillez attendre l<<single-quote>>approbation. Voici les détails ci-dessous.',
                                        'nl' => 'Wacht a.u.b. op goedkeuring. Hieronder staat de gegevens.',
                                        'pl' => 'Prosimy czekać na potwierdzenie. Poniżej szczegóły.'));
                /*
                 * Booking with approval.
                 */
                array_push($text, array('key' => 'EMAILS_DEFAULT_BOOK_WITH_APPROVAL_ADMIN_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'You received a booking request.',
                                        'de' => 'Sie haben eine buchungsanfrage erhalten.',
                                        'es' => 'Recibió una solicitud de reserva.', // !
                                        'fr' => 'Vous avez reçu une demande de réservation.',
                                        'nl' => 'U heeft een boekingsaanvraag ontvangen',
                                        'pl' => 'Otrzymałeś nową rezerwację.'));
                array_push($text, array('key' => 'EMAILS_DEFAULT_BOOK_WITH_APPROVAL_ADMIN',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'Below are the details. Go to admin to cancel the request.',
                                        'de' => 'Details finden sie nachfolgend. Öffnen sie das dashboard um die anfrage zu stornieren.',
                                        'es' => 'Abajo están los detalles. Vaya a la administración para cancelar la solicitud.', // !
                                        'fr' => 'Voici les détails. Aller à l<<single-quote>>administration pour annuler la demande.',
                                        'nl' => 'Hieronder staat de gegevens. Ga naar het administratie gedeelte om de boeking te annuleren.',
                                        'pl' => 'Szczegóły zamówienia, przejdź do panelu aby anulować.'));
                array_push($text, array('key' => 'EMAILS_DEFAULT_BOOK_WITH_APPROVAL_USER_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'Your booking request has been sent.',
                                        'de' => 'Ihre Buchungsanfrage wurde versendet.',
                                        'es' => 'Su solicitud de reserva ha sido enviada.', // !
                                        'fr' => 'Votre demande de réservation a été envoyée.',
                                        'nl' => 'Uw boekingsverzoek is verzonden.',
                                        'pl' => 'Zamówienie została wysłane.'));
                array_push($text, array('key' => 'EMAILS_DEFAULT_BOOK_WITH_APPROVAL_USER',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'Below are the details.',
                                        'de' => 'Details finden sie nachfolgend.',
                                        'es' => 'Abajo están los detalles.', // !
                                        'fr' => 'Voici les détails ci-dessous.',
                                        'nl' => 'Hieronder staat de gegevens.',
                                        'pl' => 'BSzczegóły zamówienia.'));
                /*
                 * Approved reservation.
                 */
                array_push($text, array('key' => 'EMAILS_DEFAULT_APPROVED_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'Your booking request has been approved.',
                                        'de' => 'Ihre buchungsanfrage wurde zurück akzeptiert.',
                                        'es' => 'Su solicitud de reserva ha sido aprobada.', // !
                                        'fr' => 'Votre demande de réservation a été approuvée.',
                                        'nl' => 'Uw boekingsaanvraag is goedgekeurd.',
                                        'pl' => 'Rezerwacja została przyjęta.'));
                array_push($text, array('key' => 'EMAILS_DEFAULT_APPROVED',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'Congratulations! Your booking request has been approved. Details about your request are below.',
                                        'de' => 'Glückwunsch! Ihre buchungsanfrage wurde zurück akzeptiert. Details finden sie nachfolgend.',
                                        'es' => '¡Felicitaciones! Su solicitud de reserva ha sido aprobada. Detalles sobre su solicitud están abajo.', // !
                                        'fr' => 'Félicitations! Votre demande de réservation a été approuvée. Les détails au sujet de votre demande sont ci-dessous.',
                                        'nl' => 'Gefelifiteerd! Uw boekingsaanvraag is goedgekeurd. Gegevens over uw boeking staan hieronder.',
                                        'pl' => 'Dziękujemy! Rezerwacja została przyjęta, szczegóły zamówienia poniżej.'));
                /*
                 * Canceled reservation.
                 */
                array_push($text, array('key' => 'EMAILS_DEFAULT_CANCELED_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'Your booking request has been canceled.',
                                        'de' => 'Ihre buchungsanfrage wurde storniert.',
                                        'es' => 'Su solicitud de reserva ha sido cancelada.', // !
                                        'fr' => 'Votre demande de réservation a été annulée.',
                                        'nl' => 'Uw boekingsaanvraag is geannuleerd.',
                                        'pl' => 'Rezerwacja została anulowana.'));
                array_push($text, array('key' => 'EMAILS_DEFAULT_CANCELED',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'I<<single-quote>>m sorry but your booking request has been canceled. Details about your request are below.',
                                        'de' => 'Ihre buchungsanfrage wurde storniert. Details finden sie nachfolgend.',
                                        'es' => 'Lo siento pero su solicitud de reserva ha sido cancelada. Detalles sobre su solicitud están abajo.', // !
                                        'fr' => 'Nous sommes désolés mais votre demande de réservation a été annulée. Les détails au sujet de votre demande sont ci-dessous.',
                                        'nl' => 'Sorry, maar helaas is uw boekingsaanvraag geannuleerd. De gegevens van uw boeking staan hieronder.',
                                        'pl' => 'Bardzo nam przykro, rezerwacja została anulowana. Szczegóły poniżej.'));
                /*
                 * Rejected reservation.
                 */
                array_push($text, array('key' => 'EMAILS_DEFAULT_REJECTED_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'Your booking request has been rejected.',
                                        'de' => 'Ihre buchungsanfrage wurde zurück gewiesen.',
                                        'es' => 'Su solicitud de reserva ha sido rechazada.', // !
                                        'fr' => 'Votre demande de réservation a été rejetée.',
                                        'nl' => 'Uw boekingsaanvraag is afgewezen.',
                                        'pl' => 'Rezerwacja została odrzucona.'));
                array_push($text, array('key' => 'EMAILS_DEFAULT_REJECTED',
                                        'parent' => 'PARENT_EMAILS_DEFAULT',
                                        'text' => 'I<<single-quote>>m sorry but your booking request has been rejected. Details about your request are below.',
                                        'de' => 'Ihre buchungsanfrage wurde zurück gewiesen. Details finden sie nachfolgend.',
                                        'es' => 'Lo siento, pero su solicitud de reserva ha sido rechazada. Detalles sobre su solicitud están abajo.', // !
                                        'fr' => 'Nous sommes désolés mais votre demande de réservation a été rejetée. Les détails au sujet de votre demande sont ci-dessous.',
                                        'nl' => 'Sorry, maar helaas is uw boekingsaanvraag afgewezen. De gegevens van uw boeking staan hieronder.',
                                        'pl' => 'Bardzo nam przykro, rezerwacja została odrzucona. Szczegóły poniżej.'));
                
                return $text;
            }
            
            /*
             * Emails - Email text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function emailsEmail($text){
                array_push($text, array('key' => 'PARENT_EMAILS_EMAIL',
                                        'parent' => '',
                                        'text' => 'Email templates - Templates'));
                
                array_push($text, array('key' => 'EMAILS_EMAIL_NAME',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Name',
                                        'de' => 'Name', // !
                                        'es' => 'Nombre', // !
                                        'fr' => 'Nom')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_LANGUAGE',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Language',
                                        'de' => 'Sprache', // !
                                        'es' => 'Idioma', // !
                                        'fr' => 'Langue')); //!
                
                array_push($text, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Select template',
                                        'de' => 'Vorlage wählen', // !
                                        'es' => 'Seleccione la plantilla', // !
                                        'fr' => 'Choisissez le modèle')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_ADMIN',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Admin notification',
                                        'de' => 'Administrator Benachrichtigung', // !
                                        'es' => 'Notificación de admin', // !
                                        'fr' => 'Notification d<<single-quote>>administration')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_USER',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'User notification',
                                        'de' => 'Benutzerbenachrichtigung', // !
                                        'es' => 'Notificación al usuario', // !
                                        'fr' => 'Notification utilisateur')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_WITH_APPROVAL_ADMIN',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Instant approval admin notification',
                                        'de' => 'Administrator benachrichtigung für sofortige Genehmigung', // !
                                        'es' => 'Notificación de admin por aprobación instantánea', // !
                                        'fr' => 'Notification administrative d<<single-quote>>approbation instantanée')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_WITH_APPROVAL_USER',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Instant approval user notification',
                                        'de' => 'Benutzerbenachrichtigung für sofortige Genehmigung', // !
                                        'es' => 'Notificación al usuario por aprobación instantánea', // !
                                        'fr' => 'Notification utilisateur d<<single-quote>>approbation instantanée')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_APPROVED',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Approve reservation',
                                        'de' => 'Reservierung genehmigen', // !
                                        'es' => 'Apruebe reserva', // !
                                        'fr' => 'Approuvez la réservation')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_CANCELED',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Cancel reservation',
                                        'de' => 'Reservierung stornieren', // !
                                        'es' => 'Cancelar reserva', // !
                                        'fr' => 'Annulez réservation')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_REJECTED',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Reject reservation',
                                        'de' => 'Reservierung ablehnen', // !
                                        'es' => 'Reserva de desecho', // !
                                        'fr' => 'Rejetez la réservation')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Subject',
                                        'de' => 'Betreff', // !
                                        'es' => 'Sujeto', // !
                                        'fr' => 'Sujet')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_MESSAGE',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Message',
                                        'de' => 'Nachricht', // !
                                        'es' => 'Mensaje', // !
                                        'fr' => 'Message')); //!
                
                array_push($text, array('key' => 'EMAILS_EMAIL_LOADED',
                                        'parent' => 'PARENT_EMAILS_EMAIL',
                                        'text' => 'Email templates loaded.',
                                        'de' => 'E-Mail-Vorlagen geladen.', // !
                                        'es' => 'Las plantillas de correo electrónico cargaron.', // !
                                        'fr' => 'Les modèles de courrier électronique ont chargé.')); //!
                
                return $text;
            }
            
            /*
             * Email templates - Add email text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function emailsAddEmail($text){
                array_push($text, array('key' => 'PARENT_EMAILS_ADD_EMAIL',
                                        'parent' => '',
                                        'text' => 'Email templates - Add templates'));
                
                array_push($text, array('key' => 'EMAILS_ADD_EMAIL_NAME',
                                        'parent' => 'PARENT_EMAILS_ADD_EMAIL',
                                        'text' => 'New email templates',
                                        'de' => 'Neue E-Mail-Vorlagen', // !
                                        'es' => 'Nuevas plantillas de correo electrónico', // !
                                        'fr' => 'Nouveaux modèles de courrier électronique')); //!
                array_push($text, array('key' => 'EMAILS_ADD_EMAIL_SUBMIT',
                                        'parent' => 'PARENT_EMAILS_ADD_EMAIL',
                                        'text' => 'Add email templates',
                                        'de' => 'Fügen Sie E-Mail-Vorlagen hinzu', // !
                                        'es' => 'Añada plantillas de correo electrónico', // !
                                        'fr' => 'Ajoutez des modèles de courrier électronique')); //!
                array_push($text, array('key' => 'EMAILS_ADD_EMAIL_ADDING',
                                        'parent' => 'PARENT_EMAILS_ADD_EMAIL',
                                        'text' => 'Adding new email templates ...',
                                        'de' => 'Hinzufügen neuer E-Mail-Vorlagen ...', // !
                                        'es' => 'Añadir nuevas plantillas de correo electrónico ...', // !
                                        'fr' => 'Ajout de nouveaux modèles de courriel ...')); //!
                array_push($text, array('key' => 'EMAILS_ADD_EMAIL_SUCCESS',
                                        'parent' => 'PARENT_EMAILS_ADD_EMAIL',
                                        'text' => 'You have successfully added new email templates.',
                                        'de' => 'Sie haben neue E-Mail-Vorlagen hinzugefügt.', // !
                                        'es' => 'Usted ha añadido con éxito nuevas plantillas de correo electrónico.', // !
                                        'fr' => 'Vous avez réussi à ajouter de nouveaux modèles de courriel.')); //!
                
                return $text;
            }
            
            /*
             * Emails - Delete email text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function emailsDeleteEmail($text){
                array_push($text, array('key' => 'PARENT_EMAILS_DELETE_EMAIL',
                                        'parent' => '',
                                        'text' => 'Email templates - Delete templates'));
                
                array_push($text, array('key' => 'EMAILS_DELETE_EMAIL_CONFIRMATION',
                                        'parent' => 'PARENT_EMAILS_DELETE_EMAIL',
                                        'text' => 'Are you sure you want to delete the email templates?',
                                        'de' => 'Möchten Sie die E-Mail-Vorlagen wirklich löschen?', // !
                                        'es' => '¿Estás seguro de que quieres eliminar las plantillas de correo electronico?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer les modèles de courriel?')); //!
                array_push($text, array('key' => 'EMAILS_DELETE_EMAIL_SUBMIT',
                                        'parent' => 'PARENT_EMAILS_DELETE_EMAIL',
                                        'text' => 'Delete email templates',
                                        'de' => 'Löschen Sie E-Mail-Vorlagen', // !
                                        'es' => 'Suprima plantillas de correo electrónico', // !
                                        'fr' => 'Supprimez des modèles de courrier électronique')); //!
                array_push($text, array('key' => 'EMAILS_DELETE_EMAIL_DELETING',
                                        'parent' => 'PARENT_EMAILS_DELETE_EMAIL',
                                        'text' => 'Deleting email templates ...',
                                        'de' => 'E-Mail-Vorlagen werden gelöscht ...', // !
                                        'es' => 'Supresión de plantillas de correo electrónico...', // !
                                        'fr' => 'Suppression de modèles de courrier électronique ...')); //!
                array_push($text, array('key' => 'EMAILS_DELETE_EMAIL_SUCCESS',
                                        'parent' => 'PARENT_EMAILS_DELETE_EMAIL',
                                        'text' => 'You have successfully deleted the email templates.',
                                        'de' => 'Sie haben die E-Mail-Vorlagen erfolgreich gelöscht.', // !
                                        'es' => 'Usted ha eliminado con éxito las plantillas de correo electrónico', // !
                                        'fr' => 'Vous avez réussi à supprimer les modèles de courriel.')); //!
                
                return $text;
            }
            
            /*
             * Emails - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function emailsHelp($text){
                array_push($text, array('key' => 'PARENT_EMAILS_HELP',
                                        'parent' => '',
                                        'text' => 'Email templates - Help'));
                
                array_push($text, array('key' => 'EMAILS_HELP',
                                        'parent' => 'PARENT_EMAILS_HELP',
                                        'text' => 'Click on a templates item to open the editing area.',
                                        'de' => 'Klicken Sie auf ein Vorlagenelement, um den Bearbeitungsbereich zu öffnen.', // !
                                        'es' => 'Haga clic en un elemento de plantillas para abrir el área de edición.', // !
                                        'fr' => 'Cliquez sur un élément des modèles pour ouvrir la zone d<<single-quote>>édition.')); //!
                array_push($text, array('key' => 'EMAILS_ADD_EMAIL_HELP',
                                        'parent' => 'PARENT_EMAILS_HELP',
                                        'text' => 'Click on the "plus" icon to add email templates.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um E-Mail-Vorlagen hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "más" para agregar plantillas de correo electrónico', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter des modèles de courriel.')); //!
                
                /*
                 * Email help.
                 */
                array_push($text, array('key' => 'EMAILS_EMAIL_HELP',
                                        'parent' => 'PARENT_EMAILS_HELP',
                                        'text' => 'Click the "trash" icon to delete the email.',
                                        'de' => 'Klicken Sie auf das Symbol "Papierkorb", um die E-Mail zu löschen.', // !
                                        'es' => 'Haga clic en el icono "basura" para eliminar el correo electrónico.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "corbeille" pour supprimer le courriel.')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_NAME_HELP',
                                        'parent' => 'PARENT_EMAILS_HELP',
                                        'text' => 'Change email templates name.',
                                        'de' => 'Ändern Sie den Namen der E-Mail-Vorlagen.', // !
                                        'es' => 'Cambie el nombre de las plantillas de correo electrónico', // !
                                        'fr' => 'Changer le nom des modèles de courriel.')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_LANGUAGE_HELP',
                                        'parent' => 'PARENT_EMAILS_HELP',
                                        'text' => 'Change to the language you want to edit the email templates.',
                                        'de' => 'Wechseln Sie in die Sprache, in der Sie die E-Mail-Vorlagen bearbeiten möchten.', // !
                                        'es' => 'Cambie al idioma que desea editar las plantillas de email.', // !
                                        'fr' => 'Modifiez la langue dans laquelle vous souhaitez modifier les modèles de courriel.')); //!
                array_push($text, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_HELP',
                                        'parent' => 'PARENT_EMAILS_HELP',
                                        'text' => 'Select the template you want to edit and modify the subject and message.',
                                        'de' => 'Wählen Sie die Vorlage aus, die Sie bearbeiten möchten, und ändern Sie den Betreff und die Nachricht.', // !
                                        'es' => 'Seleccione la plantilla que desea editar y modificar el sujeto y el mensaje.', // !
                                        'fr' => 'Sélectionnez le modèle que vous souhaitez modifier et modifier le sujet et le message.')); //!
                
                return $text;
            }
        }
    }