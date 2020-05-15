<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-fees.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Fees translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextFees')){
        class DOPBSPTranslationTextFees{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize fees text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'fees'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'feesFee'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'feesAddFee'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'feesDeleteFee'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'feesHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'feesFrontEnd'));
            }
            
            /*
             * Fees text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function fees($text){
                array_push($text, array('key' => 'PARENT_FEES',
                                        'parent' => '',
                                        'text' => 'Taxes & fees',
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'FEES_TITLE',
                                        'parent' => 'PARENT_FEES',
                                        'text' => 'Taxes & fees',
                                        'de' => 'Steuern und Gebühren', // !
                                        'es' => 'Impuestos y tasas', // !
                                        'fr' => 'Taxes & frais', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'FEES_CREATED_BY',
                                        'parent' => 'PARENT_FEES',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von', // !
                                        'es' => 'Creada por', // !
                                        'fr' => 'Créé par', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'FEES_LOAD_SUCCESS',
                                        'parent' => 'PARENT_FEES',
                                        'text' => 'Taxes & fees list loaded.',
                                        'de' => 'Steuern & Gebühren Liste geladen.', // !
                                        'es' => 'Lista de impuestos y tasas cargadas.', // !
                                        'fr' => 'Liste des taxes et frais chargée.'));//!
                array_push($text, array('key' => 'FEES_NO_FEES',
                                        'parent' => 'PARENT_FEES',
                                        'text' => 'No taxes or fees. Click the above "plus" icon to add a new one.',
                                        'de' => 'Keine Steuern oder Gebühren. Klicken Sie auf das obige "Plus"-Symbol, um ein neues hinzuzufügen.', // !
                                        'es' => 'No hay impuestos y tasas. Haga clic en el icono de arriba "más" para agregar uno nuevo.', // !
                                        'fr' => 'No taxes or fees. Click the above "plus" icon to add a new one.'));//!
                
                return $text;
            }
            
            /*
             * Fees - Fee text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function feesFee($text){
                array_push($text, array('key' => 'PARENT_FEES_FEE',
                                        'parent' => '',
                                        'text' => 'Taxes & fees - Tax or fee'));
                
                array_push($text, array('key' => 'FEES_FEE_NAME',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Name',
                                        'de' => 'Name', // !
                                        'es' => 'Nombre', // !
                                        'fr' => 'Nom'));//!
                array_push($text, array('key' => 'FEES_FEE_LANGUAGE',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Language',
                                        'de' => 'Sprache', // !
                                        'es' => 'Idioma', // !
                                        'fr' => 'Langue'));//!
                
                array_push($text, array('key' => 'FEES_FEE_LABEL',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Label',
                                        'de' => 'Etikett', // !
                                        'es' => 'Etiqueta', // !
                                        'fr' => 'Étiquette'));//!
                array_push($text, array('key' => 'FEES_FEE_OPERATION',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Operation',
                                        'de' => 'Vorgang', // !
                                        'es' => 'Operación', // !
                                        'fr' => 'Operation'));//!
                array_push($text, array('key' => 'FEES_FEE_PRICE',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Price/Percent',
                                        'de' => 'Preis/Prozent', // !
                                        'es' => 'Precio/Por ciento', // !
                                        'fr' => 'Prix/pour cent'));//!
                array_push($text, array('key' => 'FEES_FEE_PRICE_TYPE',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Price type',
                                        'de' => 'Preistyp', // !
                                        'es' => 'Tipo de precios', // !
                                        'fr' => 'Prix type'));//!
                array_push($text, array('key' => 'FEES_FEE_PRICE_TYPE_FIXED',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Fixed',
                                        'de' => 'Fest', // !
                                        'es' => 'Fijo', // !
                                        'fr' => 'Fixe'));//!
                array_push($text, array('key' => 'FEES_FEE_PRICE_TYPE_PERCENT',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Percent',
                                        'de' => 'Prozent', // !
                                        'es' => 'Por ciento', // !
                                        'fr' => 'Pour cent'));//!
                array_push($text, array('key' => 'FEES_FEE_PRICE_BY',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Price by',
                                        'de' => 'Preis von', // !
                                        'es' => 'Precio por', // !
                                        'fr' => 'Prix par'));//!
                array_push($text, array('key' => 'FEES_FEE_PRICE_BY_ONCE',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Once',
                                        'de' => 'Einmal', // !
                                        'es' => 'Una vez', // !
                                        'fr' => 'Une fois'));//!
                array_push($text, array('key' => 'FEES_FEE_PRICE_BY_PERIOD',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'day/hour',
                                        'de' => 'tag/stunde', // !
                                        'es' => 'día/hora', // !
                                        'fr' => 'jour/heure'));//!
                array_push($text, array('key' => 'FEES_FEE_INCLUDED',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Included',
                                        'de' => 'Einbezogen', // !
                                        'es' => 'Incluido', // !
                                        'fr' => 'Inclus'));//!
                array_push($text, array('key' => 'FEES_FEE_EXTRAS',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Add the extra<<single-quote>>s price in the calculations',
                                        'de' => 'Fügen Sie den Extra Preis in die Berechnungen ein', // !
                                        'es' => 'Añadir el precio de extra en los cálculos', // !
                                        'fr' => 'Ajouter le prix du supplément dans les calculs'));//!
                array_push($text, array('key' => 'FEES_FEE_CART',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Display fees in cart<<single-quote>>s total',
                                        'de' => 'Gebühren in der Gesamtsumme des Warenkorbs anzeigen', // !
                                        'es' => 'Tasas de visualización en el total del carrito', // !
                                        'fr' => 'Affichage des frais dans le total du panier'));//!
                
                array_push($text, array('key' => 'FEES_FEE_LOADED',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Tax or fee loaded.',
                                        'de' => 'Steuer oder Gebühr geladen.', // !
                                        'es' => 'Impuesto o tasa cargada', // !
                                        'fr' => 'La taxe ou les frais est chargé.'));//!
                
                return $text;
            }
            
            /*
             * Fees - Add fee text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function feesAddFee($text){
                array_push($text, array('key' => 'PARENT_FEES_ADD_FEE',
                                        'parent' => '',
                                        'text' => 'Taxes & fees - Add tax or fee'));
                
                array_push($text, array('key' => 'FEES_ADD_FEE_NAME',
                                        'parent' => 'PARENT_FEES_ADD_FEE',
                                        'text' => 'New tax / fee',
                                        'de' => 'Neue Steuer / Gebühr', // !
                                        'es' => 'Nuevo impuesto / tasa', // !
                                        'fr' => 'Nouvel taxe / frais'));//!
                array_push($text, array('key' => 'FEES_ADD_FEE_LABEL',
                                        'parent' => 'PARENT_FEES_ADD_FEE',
                                        'text' => 'New tax / fee label',
                                        'de' => 'Neues Steuer-/Gebühren Etikett', // !
                                        'es' => 'La etiqueta de nuevo impuesto/ tasa', // !
                                        'fr' => 'New tax / fee label étiquette'));//!
                array_push($text, array('key' => 'FEES_ADD_FEE_SUBMIT',
                                        'parent' => 'PARENT_FEES_ADD_FEE',
                                        'text' => 'Add tax or fee',
                                        'de' => 'Steuern oder Gebühren hinzufügen', // !
                                        'es' => 'Añadir impuesto o tasa', // !
                                        'fr' => 'Ajouter une taxe ou des frais'));//!
                array_push($text, array('key' => 'FEES_ADD_FEE_ADDING',
                                        'parent' => 'PARENT_FEES_ADD_FEE',
                                        'text' => 'Adding a new tax or fee ...',
                                        'de' => 'Hinzufügen einer neuen Steuer oder Gebühr ...', // !
                                        'es' => 'Añadir un nuevo impuesto o tasa ...', // !
                                        'fr' => 'Ajouter une nouvelle taxe ou des frais...'));//!
                array_push($text, array('key' => 'FEES_ADD_FEE_SUCCESS',
                                        'parent' => 'PARENT_FEES_ADD_FEE',
                                        'text' => 'You have successfully added a new tax or fee.',
                                        'de' => 'Sie haben eine neue Steuer oder Gebühr hinzugefügt.', // !
                                        'es' => 'Usted ha añadido con éxito un nuevo impuesto o tasa.', // !
                                        'fr' => 'Vous avez réussi à ajouter une nouvelle taxe ou des frais.'));//!
                
                return $text;
            }
            
            /*
             * Fees - Delete fee text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function feesDeleteFee($text){
                array_push($text, array('key' => 'PARENT_FEES_DELETE_FEE',
                                        'parent' => '',
                                        'text' => 'Taxes & fees - Delete tax or fee'));
                
                array_push($text, array('key' => 'FEES_DELETE_FEE_CONFIRMATION',
                                        'parent' => 'PARENT_FEES_DELETE_FEE',
                                        'text' => 'Are you sure you want to delete this tax / fee?',
                                        'de' => 'Möchten Sie diese Steuer/Gebühr wirklich löschen?', // !
                                        'es' => '¿Estás seguro de que quieres eliminar este impuesto / tasa?', // !
                                        'fr' => 'Êtes-vous certain de vouloir supprimer cette taxe ou ces frais?'));//!
                array_push($text, array('key' => 'FEES_DELETE_FEE_SUBMIT',
                                        'parent' => 'PARENT_FEES_DELETE_FEE',
                                        'text' => 'Delete tax / fee',
                                        'de' => 'Steuer/Gebühr löschen', // !
                                        'es' => 'Suprima el impuesto / tasa', // !
                                        'fr' => 'Supprimez l<<single-quote>>impôt/des honoraires'));//!
                array_push($text, array('key' => 'FEES_DELETE_FEE_DELETING',
                                        'parent' => 'PARENT_FEES_DELETE_FEE',
                                        'text' => 'Deleting tax / fee ...',
                                        'de' => 'Löschen Steuer / Gebühr ...', // !
                                        'es' => 'Supresión de impuesto / tasa...', // !
                                        'fr' => 'Suppression de la taxe / frais...'));//!
                array_push($text, array('key' => 'FEES_DELETE_FEE_SUCCESS',
                                        'parent' => 'PARENT_FEES_DELETE_FEE',
                                        'text' => 'You have successfully deleted the tax / fee.',
                                        'de' => 'Sie haben die Steuer/Gebühr erfolgreich gelöscht.', // !
                                        'es' => 'Usted ha eliminado con éxito el impuesto / tasa.', // !
                                        'fr' => 'Vous avez réussi à supprimer la taxe ou les frais.'));//!
                
                return $text;
            }
            
            /*
             * Fees - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function feesHelp($text){
                array_push($text, array('key' => 'PARENT_FEES_HELP',
                                        'parent' => '',
                                        'text' => 'Taxes & fees - Help'));
                
                array_push($text, array('key' => 'FEES_HELP',
                                        'parent' => 'PARENT_FEES_HELP',
                                        'text' => 'Click on a tax / fee item to open the editing area.',
                                        'de' => 'Klicken Sie auf eine Steuer-/Gebührenposition, um den Bearbeitungsbereich zu öffnen.', // !
                                        'es' => 'Haga clic en un artículo de impuestos/ tasa para abrir el área de edición.', // !
                                        'fr' => 'Cliquez sur un élément de taxe ou de frais pour ouvrir la zone d<<single-quote>>édition.'));//!
                array_push($text, array('key' => 'FEES_ADD_FEE_HELP',
                                        'parent' => 'PARENT_FEES_HELP',
                                        'text' => 'Click on the "plus" icon to add a tax or fee.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um eine Steuer oder Gebühr hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "plus" para agregar un impuesto o tasa.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter une taxe ou des frais.'));//!
                
                /*
                 * Fee help.
                 */
                array_push($text, array('key' => 'FEES_FEE_HELP',
                                        'parent' => 'PARENT_FEES_HELP',
                                        'text' => 'Click the group "trash" icon to delete the tax / fee.',
                                        'de' => 'Klicken Sie auf das Symbol "Papierkorb", um die Steuer/Gebühr zu löschen.', // !
                                        'es' => 'Haga clic en el grupo "basura" icono para eliminar el impuesto / tasa.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône « corbeille » du groupe pour supprimer la taxe ou les frais.'));//!
                array_push($text, array('key' => 'FEES_FEE_NAME_HELP',
                                        'parent' => 'PARENT_FEES_HELP',
                                        'text' => 'Change tax / fee name.',
                                        'de' => 'Ändern Sie den Namen der Steuer/Gebühr.', // !
                                        'es' => 'Cambiar el nombre del impuesto / tasa.', // !
                                        'fr' => 'Changer le nom de la taxe ou des frais.'));//!
                array_push($text, array('key' => 'FEES_FEE_LANGUAGE_HELP',
                                        'parent' => 'PARENT_FEES_HELP',
                                        'text' => 'Change to the language you want to edit the tax / fee.',
                                        'de' => 'Wechseln Sie in die Sprache, in der Sie die Steuer/Gebühr bearbeiten möchten.', // !
                                        'es' => 'Cambie el idioma que desea editar el impuesto / tasa.', // !
                                        'fr' => 'Modifier la langue dans laquelle vous voulez modifier la taxe ou les frais.'));//!
                array_push($text, array('key' => 'FEES_FEE_LABEL_HELP',
                                        'parent' => 'PARENT_FEES_HELP',
                                        'text' => 'Enter tax / fee label.',
                                        'de' => 'Geben Sie das Steuer-/Gebühren Etikett ein.', // !
                                        'es' => 'Introduzca la etiqueta de impuesto / tasa.', // !
                                        'fr' => 'Entrez l<<single-quote>>étiquette de taxe ou de frais.'));//!
                array_push($text, array('key' => 'FEES_FEE_OPERATION_HELP',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Select tax / fee price operation.',
                                        'de' => 'Wählen Sie Steuer-/Gebühren Preis Operation aus.', // !
                                        'es' => 'Seleccione el precio de operación para impuestos / tasa .', // !
                                        'fr' => 'Sélectionner opération taxe / frais de prix.'));//!
                array_push($text, array('key' => 'FEES_FEE_PRICE_HELP',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Enter tax / fee price.',
                                        'de' => 'Steuern/Gebühren preis eingeben.', // !
                                        'es' => 'Introduzca la precio de impuesto / tasa.', // !
                                        'fr' => 'Entrez le prix des taxes/frais.'));//!
                array_push($text, array('key' => 'FEES_FEE_PRICE_TYPE_HELP',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Select tax / fee price type.',
                                        'de' => 'Wählen Sie die Art des Steuer-/Gebühren Preises aus.', // !
                                        'es' => 'Seleccione el tipo de precio para el impuesto / tasa .', // !
                                        'fr' => 'Sélectionnez le type de taxe ou de frais.'));//!
                array_push($text, array('key' => 'FEES_FEE_PRICE_BY_HELP',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Select tax / fee price by.',
                                        'de' => 'Wählen Sie Steuern/Gebühren preise nach.', // !
                                        'es' => 'Seleccione impuestos / tasa precio por.', // !
                                        'fr' => 'Sélectionnez le prix de la taxe ou des frais par.'));//!
                array_push($text, array('key' => 'FEES_FEE_INCLUDED_HELP',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Tax / fee is included in reservation prices.',
                                        'de' => 'Steuern / Gebühren sind in den Reservierungspreisen enthalten.', // !
                                        'es' => 'Impuestos / tasa está incluida en los precios de reserva.', // !
                                        'fr' => 'Les taxes/frais sont inclus dans les prix de réservation.'));//!
                array_push($text, array('key' => 'FEES_FEE_EXTRAS_HELP',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'Calculate reservation tax / fee including extras price, if used.',
                                        'de' => 'Berechnen Sie die Reservierung Steuer/Gebühr inklusive des Zusatzpreises, bei Bedarf.', // !
                                        'es' => 'Calcular el impuesto / tasa de reserva incluyendo el precio de extras, si se utiliza.', // !
                                        'fr' => 'Calculer la taxe de réservation/les frais, y compris le prix des extras, s<<single-quote>>il y a lieu.'));//!
                array_push($text, array('key' => 'FEES_FEE_CART_HELP',
                                        'parent' => 'PARENT_FEES_FEE',
                                        'text' => 'If you use the cart option, you can choose to display the tax to total price or to each reservation.',
                                        'de' => 'Wenn Sie die Warenkorboption verwenden, können Sie wählen, ob die Steuer für den Gesamtpreis oder für jede Reservierung angezeigt werden soll.', // !
                                        'es' => 'Si utiliza la opción carrito, puede elegir mostrar el impuesto al precio total o a cada reserva.', // !
                                        'fr' => 'Si vous utilisez l<<single-quote>>option panier, vous pouvez choisir d<<single-quote>>afficher la taxe au prix total ou à chaque réservation.'));//!
                
                return $text;
            }
            
            /*
             * Fees front end text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function feesFrontEnd($text){
                array_push($text, array('key' => 'PARENT_FEES_FRONT_END',
                                        'parent' => '',
                                        'text' => 'Fees - Front end'));
                
                array_push($text, array('key' => 'FEES_FRONT_END_TITLE',
                                        'parent' => 'PARENT_FEES_FRONT_END',
                                        'text' => 'Taxes & fees',
                                        'de' => 'Steuern und Gebühren', // !
                                        'es' => 'Impuestos y tasas', // !
                                        'fr' => 'Taxes & frais', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'FEES_FRONT_END_BY_DAY',
                                        'parent' => 'PARENT_FEES_FRONT_END',
                                        'text' => 'day',
                                        'de' => 'tag', // !
                                        'es' => 'día', // !
                                        'fr' => 'jour', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'FEES_FRONT_END_BY_HOUR',
                                        'parent' => 'PARENT_FEES_FRONT_END',
                                        'text' => 'hour',
                                        'de' => 'Stunde', // !
                                        'es' => 'hora', // !
                                        'fr' => 'heure', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'FEES_FRONT_END_INCLUDED',
                                        'parent' => 'PARENT_FEES_FRONT_END',
                                        'text' => 'Included in price',
                                        'de' => 'Im Preis inbegriffen', // !
                                        'es' => 'Incluido en el precio', // !
                                        'fr' => 'Inclus dans prix', //!
                                        'location' => 'all'));
                
                return $text;
            }
        }
    }