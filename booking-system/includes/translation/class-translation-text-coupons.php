<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-coupons.php
* File Version            : 1.0.4
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Coupons translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextCoupons')){
        class DOPBSPTranslationTextCoupons{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize coupons text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'coupons'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'couponsCoupon'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'couponsAddCoupon'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'couponsDeleteCoupon'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'couponsHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'couponsFrontEnd'));
            }
            
            /*
             * Coupons text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function coupons($text){
                array_push($text, array('key' => 'PARENT_COUPONS',
                                        'parent' => '',
                                        'text' => 'Coupons'));
                
                array_push($text, array('key' => 'COUPONS_TITLE',
                                        'parent' => 'PARENT_COUPONS',
                                        'text' => 'Coupons',
                                        'de' => 'Coupons', // !
                                        'es' => 'Cupones', // !
                                        'fr' => 'Coupons'));
                array_push($text, array('key' => 'COUPONS_CREATED_BY',
                                        'parent' => 'PARENT_COUPONS',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von',//!
                                        'es' => 'Creada por', // !
                                        'fr' => 'Créé par')); //!
                array_push($text, array('key' => 'COUPONS_LOAD_SUCCESS',
                                        'parent' => 'PARENT_COUPONS',
                                        'text' => 'Coupons list loaded.',
                                        'de' => 'Coupon-Liste geladen.',//!
                                        'es' => 'La lista de cupones cargó.', // !
                                        'fr' => 'La liste de coupons a chargé.')); //!
                array_push($text, array('key' => 'COUPONS_NO_COUPONS',
                                        'parent' => 'PARENT_COUPONS',
                                        'text' => 'No coupons. Click the above "plus" icon to add a new one.',
                                        'de' => 'Keine Coupons. Klicken Sie auf das obige "Plus"-Symbol, um ein neues hinzuzufügen.', // !
                                        'es' => 'No hay cupones. Haga clic en el icono de arriba "más" para agregar uno nuevo.', // !
                                        'fr' => 'Pas de coupons. Cliquez sur l<<single-quote>>icône "plus" ci-dessus pour en ajouter une nouvelle.')); //!
                
                return $text;
            }
            
            /*
             * Coupons - Coupon text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function couponsCoupon($text){
                array_push($text, array('key' => 'PARENT_COUPONS_COUPON',
                                        'parent' => '',
                                        'text' => 'Coupons - Coupon'));
                
                array_push($text, array('key' => 'COUPONS_COUPON_NAME',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Name',
                                        'de' => 'Name', // !
                                        'es' => 'Nombre', // !
                                        'fr' => 'Nom')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_LANGUAGE',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Language',
                                        'de' => 'Sprache', // !
                                        'es' => 'Idioma', // !
                                        'fr' => 'Langue')); //!
                
                array_push($text, array('key' => 'COUPONS_COUPON_LABEL',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Label',
                                        'de' => 'Etikett', // !
                                        'es' => 'Etiqueta', // !
                                        'fr' => 'Étiquette')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_CODE',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Code',
                                        'de' => 'Code', // !
                                        'es' => 'Código', // !
                                        'fr' => 'Code')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_CODE_GENERATE',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Generate a random code',
                                        'de' => 'Generieren Sie einen zufälligen Code', // !
                                        'es' => 'Generar un código aleatorio', // !
                                        'fr' => 'Générer un code aléatoire')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_START_DATE',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Start date',
                                        'de' => 'Startdatum', // !
                                        'es' => 'Fecha de inicio', // !
                                        'fr' => 'Date de début')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_END_DATE',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'End date',
                                        'de' => 'Enddatum', // !
                                        'es' => 'Fecha final', // !
                                        'fr' => 'Date de fin')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_START_HOUR',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Start hour',
                                        'de' => 'Startstunde', // !
                                        'es' => 'Hora de principio', // !
                                        'fr' => 'Heure de début')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_END_HOUR',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'End hour',
                                        'de' => 'Endstunde', // !
                                        'es' => 'Hora de final', // !
                                        'fr' => 'Heure de fin')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_NO_COUPONS',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Number of coupons',
                                        'de' => 'Anzahl der Coupons', // !
                                        'es' => 'número de cupones', // !
                                        'fr' => 'Nombre de coupons')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_OPERATION',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Operation',
                                        'de' => 'Vorgang', // !
                                        'es' => 'Operación', // !
                                        'fr' => 'Opération')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_PRICE',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Price/Percent',
                                        'de' => 'Preis/Prozent', // !
                                        'es' => 'Precio/Por ciento', // !
                                        'fr' => 'Prix/Pourcentage')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_PRICE_TYPE',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Price type',
                                        'de' => 'Preistyp', // !
                                        'es' => 'Tipo de precios', // !
                                        'fr' => 'Type des prix')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_PRICE_TYPE_FIXED',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Fixed',
                                        'de' => 'Fest', // !
                                        'es' => 'Fijo', // !
                                        'fr' => 'Fixé')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_PRICE_TYPE_PERCENT',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Percent',
                                        'de' => 'Prozent', // !
                                        'es' => 'Por ciento', // !
                                        'fr' => 'Pourcentage')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_PRICE_BY',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Price by',
                                        'de' => 'Preis von', // !
                                        'es' => 'Precio por', // !
                                        'fr' => 'Prix par')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_PRICE_BY_ONCE',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Once',
                                        'de' => 'Einmal', // !
                                        'es' => 'Una vez', // !
                                        'fr' => 'Une fois')); // !
                array_push($text, array('key' => 'COUPONS_COUPON_PRICE_BY_PERIOD',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'day/hour',
                                        'de' => 'tag/stunde', // !
                                        'es' => 'día/hora', // !
                                        'fr' => 'jour/heure')); //!
                
                array_push($text, array('key' => 'COUPONS_COUPON_LOADED',
                                        'parent' => 'PARENT_COUPONS_COUPON',
                                        'text' => 'Coupon loaded.',
                                        'de' => 'Coupon geladen.', // !
                                        'es' => 'El cupón cargó.', // !
                                        'fr' => 'Coupon chargé.')); //!
                
                return $text;
            }
            
            /*
             * Coupons - Add coupon text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function couponsAddCoupon($text){
                array_push($text, array('key' => 'PARENT_COUPONS_ADD_COUPON',
                                        'parent' => '',
                                        'text' => 'Coupons - Add coupon'));
                
                array_push($text, array('key' => 'COUPONS_ADD_COUPON_NAME',
                                        'parent' => 'PARENT_COUPONS_ADD_COUPON',
                                        'text' => 'New coupon',
                                        'de' => 'Neuer Gutschein', // !
                                        'es' => 'Nuevo cupón', // !
                                        'fr' => 'Nouveau coupon')); //!
                array_push($text, array('key' => 'COUPONS_ADD_COUPON_LABEL',
                                        'parent' => 'PARENT_COUPONS_ADD_COUPON',
                                        'text' => 'Coupon',
                                        'de' => 'Coupon', // !
                                        'es' => 'Cupón', // !
                                        'fr' => 'Coupon')); //!
                array_push($text, array('key' => 'COUPONS_ADD_COUPON_SUBMIT',
                                        'parent' => 'PARENT_COUPONS_ADD_COUPON',
                                        'text' => 'Add coupon',
                                        'de' => 'Coupon hinzufügen', // !
                                        'es' => 'Añada cupón', // !
                                        'fr' => 'Ajoutez le coupon')); //!
                array_push($text, array('key' => 'COUPONS_ADD_COUPON_ADDING',
                                        'parent' => 'PARENT_COUPONS_ADD_COUPON',
                                        'text' => 'Adding a new coupon ...',
                                        'de' => 'Hinzufügen eines neuen Coupons ...', // !
                                        'es' => 'Añadir un nuevo cupón ...', // !
                                        'fr' => 'Ajout d<<single-quote>>un nouveau coupon ...')); //!
                array_push($text, array('key' => 'COUPONS_ADD_COUPON_SUCCESS',
                                        'parent' => 'PARENT_COUPONS_ADD_COUPON',
                                        'text' => 'You have successfully added a new coupon.',
                                        'de' => 'Sie haben einen neuen Coupon hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito un nuevo cupón.', // !
                                        'fr' => 'Vous avez réussi à ajouter un nouveau coupon.')); //!
                
                return $text;
            }
            
            /*
             * Coupons - Delete coupon text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function couponsDeleteCoupon($text){
                array_push($text, array('key' => 'PARENT_COUPONS_DELETE_COUPON',
                                        'parent' => '',
                                        'text' => 'Coupons - Delete coupon'));
                
                array_push($text, array('key' => 'COUPONS_DELETE_COUPON_CONFIRMATION',
                                        'parent' => 'PARENT_COUPONS_DELETE_COUPON',
                                        'text' => 'Are you sure you want to delete this coupon?',
                                        'de' => 'Möchten Sie diesen Coupon wirklich löschen?', // !
                                        'es' => '¿Seguro que quieres borrar este cupón?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer ce coupon?')); //!
                array_push($text, array('key' => 'COUPONS_DELETE_COUPON_SUBMIT',
                                        'parent' => 'PARENT_COUPONS_DELETE_COUPON',
                                        'text' => 'Delete coupon',
                                        'de' => 'Coupon löschen', // !
                                        'es' => 'Suprima cupón', // !
                                        'fr' => 'Supprimez coupon')); //!
                array_push($text, array('key' => 'COUPONS_DELETE_COUPON_DELETING',
                                        'parent' => 'PARENT_COUPONS_DELETE_COUPON',
                                        'text' => 'Deleting coupon ...',
                                        'de' => 'Coupon wird gelöscht ...', // !
                                        'es' => 'Supresión de cupón...', // !
                                        'fr' => 'Supprimer le coupon ...')); //!
                array_push($text, array('key' => 'COUPONS_DELETE_COUPON_SUCCESS',
                                        'parent' => 'PARENT_COUPONS_DELETE_COUPON',
                                        'text' => 'You have successfully deleted the coupon.',
                                        'de' => 'Sie haben den Coupon erfolgreich gelöscht.', // !
                                        'es' => 'Ha eliminado con éxito el cupón.', // !
                                        'fr' => 'Vous avez réussi à supprimer le coupon.')); //!
                
                return $text;
            }
            
            /*
             * Coupons - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function couponsHelp($text){
                array_push($text, array('key' => 'PARENT_COUPONS_HELP',
                                        'parent' => '',
                                        'text' => 'Coupons - Help'));
                
                array_push($text, array('key' => 'COUPONS_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Click on a coupon item to open the editing area.',
                                        'de' => 'Klicken Sie auf einen Coupon-Artikel, um den Bearbeitungsbereich zu öffnen.', // !
                                        'es' => 'Haga clic en un elemento de cupón para abrir el área de edición.', // !
                                        'fr' => 'Cliquez sur un coupon pour ouvrir la zone d<<single-quote>>édition.')); //!
                array_push($text, array('key' => 'COUPONS_ADD_COUPON_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Click on the "plus" icon to add a coupon.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um einen Gutschein hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "plus" para añadir un cupón.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter un coupon.')); //!
                
                /*
                 * Coupon help.
                 */
                array_push($text, array('key' => 'COUPONS_COUPON_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Click the group "trash" icon to delete the coupon.',
                                        'de' => 'Klicken Sie auf das "Papierkorb"-Symbol der Gruppe, um den Coupon zu löschen.', // !
                                        'es' => 'Haga clic en el grupo "basura" icono para eliminar el cupón.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "corbeille" du groupe pour supprimer le coupon.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_NAME_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Change coupon name.',
                                        'de' => 'Ändern Sie den Namen des Coupons.', // !
                                        'es' => 'Nombre de cupón de cambio.', // !
                                        'fr' => 'Changer le nom du coupon.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_LANGUAGE_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Change to the language you want to edit the coupon.',
                                        'de' => 'Wechseln Sie in die Sprache, in der Sie den Coupon bearbeiten möchten.', // !
                                        'es' => 'Cambie al idioma que desea editar el cupón.', // !
                                        'fr' => 'Modifiez la langue dans laquelle vous souhaitez modifier le coupon.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_LABEL_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Enter coupon label.',
                                        'de' => 'Geben Sie das Coupon-Etikett ein.', // !
                                        'es' => 'Entre en la etiqueta de cupón.', // !
                                        'fr' => 'Saisir l<<single-quote>>étiquette du coupon')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_CODE_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Enter coupon code.',
                                        'de' => 'Geben Sie den Gutscheincode ein.', // !
                                        'es' => 'Entre en el código de cupón.', // !
                                        'fr' => 'Saisir le code coupon.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_START_DATE_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Enter coupon start date, when the coupon will start being used.. Leave it blank to start today.',
                                        'de' => 'Geben Sie das Startdatum des Coupons ein, an dem der Coupon verwendet wird. Lassen Sie es leer, um von heute an zu beginnen.', // !
                                        'es' => 'Introduzca la fecha de inicio del cupón, cuando el cupón comenzará a ser utilizado.. Déjelo en blanco para comenzar hoy.', // !
                                        'fr' => 'Entrez la date de début du coupon, lorsque le coupon commencera à être utilisé. Laissez le vide pour commencer aujourd<<single-quote>>hui.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_END_DATE_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Enter coupon end date, when the coupon will stop being used. Leave it blank for the coupons to have an unlimited time lapse.',
                                        'de' => 'Geben Sie das Enddatum des Coupons ein, wenn der Coupon ungültig wird. Lassen Sie es leer die Coupons haben eine unbegrenzte Zeit verstreichen.', // !
                                        'es' => 'Introduzca la fecha final del cupón, cuando el cupón dejará de ser utilizado. Déjelo en blanco para que los cupones tengan un lapso de tiempo ilimitado.', // !
                                        'fr' => 'Entrez la date de fin du coupon, lorsque le coupon cessera d<<single-quote>>être utilisé. Laissez en blanc pour que les coupons aient un délai illimité.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_START_HOUR_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Enter coupon start hour, when the coupon will start being used. Leave it blank so you can use the coupons from the start of the day.',
                                        'de' => 'Geben Sie die Anfangsstunde des Coupons ein, zu der der Coupon verwendet wird. Lassen Sie das Feld leer, damit Sie die Coupons ab Tagesbeginn verwenden können.', // !
                                        'es' => 'Introduzca la hora de inicio del cupón, cuando el cupón comenzará a utilizarse. Déjelo en blanco para que pueda utilizar los cupones desde el comienzo del día.', // !
                                        'fr' => 'Entrez l<<single-quote>>heure de début du coupon, lorsque le coupon commencera à être utilisé. Laissez-le en blanc pour que vous puissiez utiliser les coupons dès le début de la journée.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_END_HOUR_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Enter coupon end hour, when the coupon will end being used. Leave it blank so you can use the coupons until the end of the day.',
                                        'de' => 'Geben Sie die Endstunde des Coupons ein, wenn der Coupon nicht mehr verwendet wird. Lassen Sie das Feld leer, damit Sie die Coupons bis zum Ende des Tages verwenden können.', // !
                                        'es' => 'Introduzca la hora final del cupón, cuando el cupón terminará siendo utilizado. Déjelo en blanco para que pueda utilizar los cupones hasta el final del día.', // !
                                        'fr' => 'Entrez l<<single-quote>>heure de fin du coupon, lorsque le coupon se terminera. Laissez en blanc pour que vous puissiez utiliser les coupons jusqu<<single-quote>>à la fin de la journée.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_NO_COUPONS_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Enter the number of coupons available. Leave it blank for unlimited number of coupons.',
                                        'de' => 'Geben Sie die Anzahl der verfügbaren Coupons ein. Lassen Sie das Feld leer, um eine unbegrenzte Anzahl von Coupons zu erhalten.', // !
                                        'es' => 'Introduzca el número de cupones disponibles. Déjelo en blanco para el número ilimitado de cupones.', // !
                                        'fr' => 'Entrez le nombre de coupons disponibles. Laissez en blanc pour un nombre illimité de coupons.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_OPERATION_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Select coupon price operation. You can add or subtract a value.',
                                        'de' => 'Wählen Sie den Vorgang für den Couponpreis aus. Sie können einen Wert hinzufügen oder abziehen.', // !
                                        'es' => 'Seleccione la operación del precio del cupón. Puede agregar o restar un valor.', // !
                                        'fr' => 'Sélectionnez opération de prix de coupon. Vous pouvez ajouter ou soustraire une valeur.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_PRICE_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Enter coupon price.',
                                        'de' => 'Geben Sie den Couponpreis ein.', // !
                                        'es' => 'Entre en el precio de cupón.', // !
                                        'fr' => 'Entrez dans le prix de coupon.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_PRICE_TYPE_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Select coupon price type. It can be a fixed value or a percent from price.',
                                        'de' => 'Wählen Sie die Preisart des Coupons aus. Es kann ein fester Wert oder ein Prozent vom Preis sein.', // !
                                        'es' => 'Seleccione el tipo de precio del cupón. Puede ser un valor fijo o un por ciento de precio.', // !
                                        'fr' => 'Sélectionnez le type de prix du coupon. Il peut s<<single-quote>>agir d<<single-quote>>une valeur fixe ou d<<single-quote>>un pourcentage du prix.')); //!
                array_push($text, array('key' => 'COUPONS_COUPON_PRICE_BY_HELP',
                                        'parent' => 'PARENT_COUPONS_HELP',
                                        'text' => 'Select coupon price by. The price can be calculated once or by day/hour.',
                                        'de' => 'Wählen Sie aus, wie der Coupon angewendet werden soll. Der Preis kann einmal oder nach Tag/Stunde berechnet werden.', // !
                                        'es' => 'Seleccione el precio del cupón por. El precio se puede calcular una vez o por día/hora.', // !
                                        'fr' => 'Sélectionnez le prix du coupon par. Le prix peut être calculé une fois ou par jour/heure.')); //!
                
                return $text;
            }
            
            /*
             * Coupons front end text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function couponsFrontEnd($text){
                array_push($text, array('key' => 'PARENT_COUPONS_FRONT_END',
                                        'parent' => '',
                                        'text' => 'Coupons - Front end'));
                
                array_push($text, array('key' => 'COUPONS_FRONT_END_TITLE',
                                        'parent' => 'PARENT_COUPONS_FRONT_END',
                                        'text' => 'Coupons',
                                        'de' => 'Coupons', // !
                                        'es' => 'Cupones', // !
                                        'fr' => 'Coupons', //!
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'COUPONS_FRONT_END_CODE',
                                        'parent' => 'PARENT_COUPONS_FRONT_END',
                                        'text' => 'Enter code',
                                        'de' => 'Code eingeben', // !
                                        'es' => 'Introduce el código', // !
                                        'fr' => 'Entrez le code', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'COUPONS_FRONT_END_VERIFY',
                                        'parent' => 'PARENT_COUPONS_FRONT_END',
                                        'text' => 'Verify code',
                                        'de' => 'Code überprüfen', // !
                                        'es' => 'Verifique código', // !
                                        'fr' => 'Vérifiez le code', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'COUPONS_FRONT_END_VERIFY_SUCCESS',
                                        'parent' => 'PARENT_COUPONS_FRONT_END',
                                        'text' => 'The coupon code is valid.',
                                        'de' => 'Der Gutscheincode ist gültig.', // !
                                        'es' => 'El código de cupón es válido.', // !
                                        'fr' => 'Le code coupon est valide.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'COUPONS_FRONT_END_VERIFY_ERROR',
                                        'parent' => 'PARENT_COUPONS_FRONT_END',
                                        'text' => 'The coupon code is invalid. Please enter another one.',
                                        'de' => 'Der Gutscheincode ist ungültig. Geben Sie eine andere ein.', // !
                                        'es' => 'El código de cupón no es válido. Introduzca otro.', // !
                                        'fr' => 'Le code du coupon n<<single-quote>>est pas valide. Veuillez en entrer un autre.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'COUPONS_FRONT_END_USE',
                                        'parent' => 'PARENT_COUPONS_FRONT_END',
                                        'text' => 'Use coupon',
                                        'de' => 'Gutschein verwenden', // !
                                        'es' => 'Utilizar el cupón', // !
                                        'fr' => 'Utiliser le coupon', //!
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'COUPONS_FRONT_END_BY_DAY',
                                        'parent' => 'PARENT_COUPONS_FRONT_END',
                                        'text' => 'day',
                                        'de' => 'tag', // !
                                        'es' => 'día', // !
                                        'fr' => 'jour', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'COUPONS_FRONT_END_BY_HOUR',
                                        'parent' => 'PARENT_COUPONS_FRONT_END',
                                        'text' => 'hour',
                                        'de' => 'stunde', // !
                                        'es' => 'hora', // !
                                        'fr' => 'heure', //!
                                        'location' => 'all'));
                
                return $text;
            }
        }
    }