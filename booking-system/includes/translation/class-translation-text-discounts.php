<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-discounts.php
* File Version            : 1.0.5
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Discounts translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextDiscounts')){
        class DOPBSPTranslationTextDiscounts{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize discounts text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discounts'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsDiscount'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsAddDiscount'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsDeleteDiscount'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsDiscountItems'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsDiscountItem'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsDiscountAddItem'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsDiscountDeleteItem'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsDiscountItemRules'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsDiscountItemRule'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsDiscountItemAddRule'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsDiscountItemDeleteRule'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'discountsFrontEnd'));
            }
            
            /*
             * Discounts text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discounts($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS',
                                        'parent' => '',
                                        'text' => 'Discounts'));
                
                array_push($text, array('key' => 'DISCOUNTS_TITLE',
                                        'parent' => 'PARENT_DISCOUNTS',
                                        'text' => 'Discounts',
                                        'de' => 'Rabatte', // !
                                        'es' => 'Descuentos', // !
                                        'fr' => 'Remises'));//!
                array_push($text, array('key' => 'DISCOUNTS_CREATED_BY',
                                        'parent' => 'PARENT_DISCOUNTS',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von', // !
                                        'es' => 'Creada por', // !
                                        'fr' => 'Créé par'));//!
                array_push($text, array('key' => 'DISCOUNTS_LOAD_SUCCESS',
                                        'parent' => 'PARENT_DISCOUNTS',
                                        'text' => 'Discounts list loaded.',
                                        'de' => 'Rabattliste geladen.', // !
                                        'es' => 'La lista de descuentos cargó.', // !
                                        'fr' => 'Liste de remises chargée.'));//!
                array_push($text, array('key' => 'DISCOUNTS_NO_DISCOUNTS',
                                        'parent' => 'PARENT_DISCOUNTS',
                                        'text' => 'No discounts. Click the above "plus" icon to add a new one.',
                                        'de' => 'Keine Rabatte. Klicken Sie auf das obige "Plus"-Symbol, um ein neues hinzuzufügen.', // !
                                        'es' => 'No hay descuentos. Haga clic en el icono "plus" de arriba para agregar uno nuevo.', // !
                                        'fr' => 'Pas de rabais. Cliquez sur l<<single-quote>>icône "plus" ci-dessus pour en ajouter une nouvelle.'));//!
                
                return $text;
            }
            
            /*
             * Discounts - Discount text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsDiscount($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_DISCOUNT',
                                        'parent' => '',
                                        'text' => 'Discounts - Discount'));
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_NAME',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT',
                                        'text' => 'Name',
                                        'de' => 'Name', // !
                                        'es' => 'Nombre', // !
                                        'fr' => 'Nom'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_LANGUAGE',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'Language',
                                        'de' => 'Sprache', // !
                                        'es' => 'Idioma', // !
                                        'fr' => 'Langue'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_EXTRAS',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'Add the extra<<single-quote>>s price in the calculations',
                                        'de' => 'Fügen Sie den Extrapreis in die Berechnungen ein', // !
                                        'es' => 'Añadir el precio de extra en los cálculos', // !
                                        'fr' => 'Ajouter le prix supplémentaire<<single-quote>s dans les calculs'));//!
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_LOADED',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT',
                                        'text' => 'Discount loaded.',
                                        'de' => 'Rabatt geladen.', // !
                                        'es' => 'El descuento cargó.', // !
                                        'fr' => 'Remise chargée.'));//!
                
                return $text;
            }
            
            /*
             * Discounts - Add discount text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsAddDiscount($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_ADD_DISCOUNT',
                                        'parent' => '',
                                        'text' => 'Discounts - Add discount'));
                
                array_push($text, array('key' => 'DISCOUNTS_ADD_DISCOUNT_NAME',
                                        'parent' => 'PARENT_DISCOUNTS_ADD_DISCOUNT',
                                        'text' => 'New discount',
                                        'de' => 'Neuer Rabatt', // !
                                        'es' => 'Nuevo descuento', // !
                                        'fr' => 'Nouveau remise'));//!
                array_push($text, array('key' => 'DISCOUNTS_ADD_DISCOUNT_SUBMIT',
                                        'parent' => 'PARENT_DISCOUNTS_ADD_DISCOUNT',
                                        'text' => 'Add discount',
                                        'de' => 'Rabatt hinzufügen', // !
                                        'es' => 'Añada descuento', // !
                                        'fr' => 'Ajoutez la remise'));//!
                array_push($text, array('key' => 'DISCOUNTS_ADD_DISCOUNT_ADDING',
                                        'parent' => 'PARENT_DISCOUNTS_ADD_DISCOUNT',
                                        'text' => 'Adding a new discount ...',
                                        'de' => 'Hinzufügen eines neuen Rabatts ...', // !
                                        'es' => 'Añadir un nuevo descuento ...', // !
                                        'fr' => 'Ajouter un nouveau rabais ...'));//!
                array_push($text, array('key' => 'DISCOUNTS_ADD_DISCOUNT_SUCCESS',
                                        'parent' => 'PARENT_DISCOUNTS_ADD_DISCOUNT',
                                        'text' => 'You have successfully added a new discount.',
                                        'de' => 'Sie haben erfolgreich einen neuen Rabatt hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito un nuevo descuento.', // !
                                        'fr' => 'Vous avez réussi à ajouter un nouveau rabais.'));//!
                
                return $text;
            }
            
            /*
             * Discounts - Delete discount text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsDeleteDiscount($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_DELETE_DISCOUNT',
                                        'parent' => '',
                                        'text' => 'Discounts - Delete discount'));
                
                array_push($text, array('key' => 'DISCOUNTS_DELETE_DISCOUNT_CONFIRMATION',
                                        'parent' => 'PARENT_DISCOUNTS_DELETE_DISCOUNT',
                                        'text' => 'Are you sure you want to delete this discount?',
                                        'de' => 'Möchten Sie diesen Rabatt wirklich löschen?', // !
                                        'es' => '¿Seguro que quieres borrar este descuento?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer cette réduction?'));//!
                array_push($text, array('key' => 'DISCOUNTS_DELETE_DISCOUNT_SUBMIT',
                                        'parent' => 'PARENT_DISCOUNTS_DELETE_DISCOUNT',
                                        'text' => 'Delete discount',
                                        'de' => 'Rabatt löschen', // !
                                        'es' => 'Suprima descuento', // !
                                        'fr' => 'Supprimez la remise'));//!
                array_push($text, array('key' => 'DISCOUNTS_DELETE_DISCOUNT_DELETING',
                                        'parent' => 'PARENT_DISCOUNTS_DELETE_DISCOUNT',
                                        'text' => 'Deleting discount ...',
                                        'de' => 'Rabatt wird gelöscht ...', // !
                                        'es' => 'Supresión de descuento...', // !
                                        'fr' => 'Suppression de remise'));//!
                array_push($text, array('key' => 'DISCOUNTS_DELETE_DISCOUNT_SUCCESS',
                                        'parent' => 'PARENT_DISCOUNTS_DELETE_DISCOUNT',
                                        'text' => 'You have successfully deleted the discount.',
                                        'de' => 'Sie haben den Rabatt erfolgreich gelöscht.', // !
                                        'es' => 'Ha eliminado con éxito el descuento.', // !
                                        'fr' => 'Vous avez réussi à supprimer la réduction.'));//!
                
                return $text;
            }
            
            /*
             * Discounts - Discount items text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsDiscountItems($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_DISCOUNT_ITEMS',
                                        'parent' => '',
                                        'text' => 'Discounts - Discount items'));
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEMS',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEMS',
                                        'text' => 'Discount items',
                                        'de' => 'Rabattartikel', // !
                                        'es' => 'Artículos de descuento', // !
                                        'fr' => 'Les articles discount'));//!
                
                return $text;
            }
            
            /*
             * Discounts - Discount item text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsDiscountItem($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'parent' => '',
                                        'text' => 'Discounts - Discount item'));
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_SHOW_SETTINGS',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'Show settings',
                                        'de' => 'Einstellungen anzeigen', // !
                                        'es' => 'Muestre los ajustes', // !
                                        'fr' => 'Montrer les paramètres'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_HIDE_SETTINGS',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'Hide settings',
                                        'de' => 'Einstellungen ausblenden', // !
                                        'es' => 'Oculte los ajustes', // !
                                        'fr' => 'Cachez des paramètres'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_SORT',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'Sort',
                                        'de' => 'Sortieren', // !
                                        'es' => 'Ordenar', // !
                                        'fr' => 'Sorte'));//!
                /*
                 * Settings labels.
                 */
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_LABEL_LABEL',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'Label',
                                        'de' => 'Etikett', // !
                                        'es' => 'Etiqueta', // !
                                        'fr' => 'Étiquette'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_START_TIME_LAPSE_LABEL',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'Start time lapse (days/hours)',
                                        'de' => 'Zeitraffer starten (Tage/Stunden)', // !
                                        'es' => 'Plazo de inicio (días/horas)', // !
                                        'fr' => 'Délai de début (jours/heures)'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_END_TIME_LAPSE_LABEL',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'End time lapse (days/hours)',
                                        'de' => 'Ende des Zeitverlaufs (Tage/Stunden)', // !
                                        'es' => 'Plazo del tiempo final (días/horas)', // !
                                        'fr' => 'Délai de fin (jours/heures)'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_OPERATION_LABEL',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'Operation',
                                        'de' => 'Vorgang', // !
                                        'es' => 'Operación', // !
                                        'fr' => 'Opération'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_PRICE_LABEL',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'Price/Percent',
                                        'de' => 'Preis/Prozent', // !
                                        'es' => 'Precio/Por ciento', // !
                                        'fr' => 'Prix/pour cent'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_PRICE_TYPE_LABEL',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'Price type',
                                        'de' => 'Preistyp', // !
                                        'es' => 'Tipo de precios', // !
                                        'fr' => 'Type des prix'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_PRICE_BY_LABEL',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM',
                                        'text' => 'Price by',
                                        'de' => 'Preis von', // !
                                        'es' => 'Precio por', // !
                                        'fr' => 'Prix par'));//!
                
                return $text;
            }
            
            /*
             * Discounts - Add discount item text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsDiscountAddItem($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_DISCOUNT_ADD_ITEM',
                                        'parent' => '',
                                        'text' => 'Discounts - Add discount item'));
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ADD_ITEM_SUBMIT',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ADD_ITEM',
                                        'text' => 'Add item',
                                        'de' => 'Element hinzufügen', // !
                                        'es' => 'Añada artículo', // !
                                        'fr' => 'Ajoutez article'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ADD_ITEM_LABEL',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ADD_ITEM',
                                        'text' => 'New item',
                                        'de' => 'Neues Element', // !
                                        'es' => 'Nuevo artículo', // !
                                        'fr' => 'Nouvel article'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ADD_ITEM_ADDING',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ADD_ITEM',
                                        'text' => 'Adding a new discount item ...',
                                        'de' => 'Hinzufügen eines neuen Rabattartikels ...', // !
                                        'es' => 'Añadir un nuevo artículo de descuento ...', // !
                                        'fr' => 'Ajout d<<single-quote>>un nouvel article à rabais ...'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ADD_ITEM_SUCCESS',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ADD_ITEM',
                                        'text' => 'You have successfully added a new discount item.',
                                        'de' => 'Sie haben erfolgreich einen neuen Rabattartikel hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito un nuevo artículo de descuento.', // !
                                        'fr' => 'Vous avez réussi à ajouter un nouvel article de réduction.'));//!
                
                return $text;
            }
            
            /*
             * Discounts - Delete discount item text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsDiscountDeleteItem($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_DISCOUNT_DELETE_ITEM',
                                        'parent' => '',
                                        'text' => 'Discounts - Delete discount item'));
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_DELETE_ITEM_CONFIRMATION',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_DELETE_ITEM',
                                        'text' => 'Are you sure you want to delete this discount item?',
                                        'de' => 'Möchten Sie diesen Rabattartikel wirklich löschen?', // !
                                        'es' => '¿Estás seguro de que quieres eliminar este artículo de descuento?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer cet élément de réduction?'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_DELETE_ITEM_SUBMIT',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_DELETE_ITEM',
                                        'text' => 'Delete',
                                        'de' => 'Löschen', // !
                                        'es' => 'Borrar', // !
                                        'fr' => 'Supprimer'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_DELETE_ITEM_DELETING',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_DELETE_ITEM',
                                        'text' => 'Deleting discount item ...',
                                        'de' => 'Rabattelement wird gelöscht...', // !
                                        'es' => 'Supresión de artículo de descuento...', // !
                                        'fr' => 'Suppression de l<<single-quote>>élément de réduction ...'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_DELETE_ITEM_SUCCESS',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_DELETE_ITEM',
                                        'text' => 'You have successfully deleted the discount item.',
                                        'de' => 'Sie haben den Rabattartikel erfolgreich gelöscht.', // !
                                        'es' => 'Ha eliminado con éxito el artículo de descuento.', // !
                                        'fr' => 'Vous avez réussi à supprimer l<<single-quote>>élément de réduction.'));//!
                
                return $text;
            }
            
            /*
             * Discounts - Discount item rules text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsDiscountItemRules($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULES',
                                        'parent' => '',
                                        'text' => 'Discounts - Discount item - Rules'));
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_RULES_LABEL',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULES',
                                        'text' => 'Rules',
                                        'de' => 'Regeln', // !
                                        'es' => 'Reglas', // !
                                        'fr' => 'Règles'));//!
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_OPERATION',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULES',
                                        'text' => 'Operation',
                                        'de' => 'Vorgang', // !
                                        'es' => 'Operación', // !
                                        'fr' => 'Opération'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_PRICE',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULES',
                                        'text' => 'Price/Percent',
                                        'de' => 'Preis/Prozent', // !
                                        'es' => 'Precio/Por ciento', // !
                                        'fr' => 'Prix/pour cent'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_PRICE_TYPE',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULES',
                                        'text' => 'Price type',
                                        'de' => 'Preistyp', // !
                                        'es' => 'Tipo de precios', // !
                                        'fr' => 'Type des prix'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_PRICE_BY',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULES',
                                        'text' => 'Price by',
                                        'de' => 'Preis von', // !
                                        'es' => 'Precio por', // !
                                        'fr' => 'Prix par'));//!
                                    
                return $text;
            }
            
            /*
             * Discounts - Discount item rule text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsDiscountItemRule($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULE',
                                        'parent' => '',
                                        'text' => 'Discounts - Discount item - Rule'));
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_TYPE_FIXED',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULE',
                                        'text' => 'Fixed',
                                        'de' => 'Fest', // !
                                        'es' => 'Fijo', // !
                                        'fr' => 'Fixe'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_TYPE_PERCENT',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULE',
                                        'text' => 'Percent',
                                        'de' => 'Prozent', // !
                                        'es' => 'Por ciento', // !
                                        'fr' => 'Pour cent'));//!
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_BY_ONCE',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULE',
                                        'text' => 'Once',
                                        'de' => 'Einmal', // !
                                        'es' => 'Una vez', // !
                                        'fr' => 'Une fois'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_BY_PERIOD',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULE',
                                        'text' => 'day/hour',
                                        'de' => 'tag/stunde', // !
                                        'es' => 'día/hora', // !
                                        'fr' => 'jour/heure'));//!
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_RULE_SORT',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_RULE',
                                        'text' => 'Sort',
                                        'de' => 'Sortieren', // !
                                        'es' => 'Ordenar', // !
                                        'fr' => 'Sorte'));//!
                
                return $text;
            }
            
            /*
             * Discounts - Add discount item rule text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsDiscountItemAddRule($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_ADD_RULE',
                                        'parent' => '',
                                        'text' => 'Discounts - Discount item - Add rule'));
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_ADD_RULE_SUBMIT',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_ADD_RULE',
                                        'text' => 'Add rule',
                                        'de' => 'Regel hinzufügen', // !
                                        'es' => 'Añada regla', // !
                                        'fr' => 'Ajoutez règle'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_ADD_RULE_ADDING',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_ADD_RULE',
                                        'text' => 'Adding a new rule ...',
                                        'de' => 'Hinzufügen einer neuen Regel ...', // !
                                        'es' => 'Añadir una nueva regla ...', // !
                                        'fr' => 'Ajout d<<single-quote>>une nouvelle règle...'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_ADD_RULE_SUCCESS',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_ADD_RULE',
                                        'text' => 'You have successfully added a new rule.',
                                        'de' => 'Sie haben erfolgreich eine neue Regel hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito una nueva regla.', // !
                                        'fr' => 'Vous avez réussi à ajouter une nouvelle règle.'));//!
                
                return $text;
            }
            
            /*
             * Discounts - Delete discount item rule text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsDiscountItemDeleteRule($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE',
                                        'parent' => '',
                                        'text' => 'Discounts - Discount item - Delete rule'));
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE_CONFIRMATION',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE',
                                        'text' => 'Are you sure you want to delete this  rule?',
                                        'de' => 'Möchten Sie diese Regel wirklich löschen?', // !
                                        'es' => '¿Seguro que quieres borrar esta regla?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer cette règle?'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE_SUBMIT',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE',
                                        'text' => 'Delete',
                                        'de' => 'Löschen', // !
                                        'es' => 'Borrar', // !
                                        'fr' => 'Supprimer'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE_DELETING',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE',
                                        'text' => 'Deleting  rule ...',
                                        'de' => 'Regel wird gelöscht...', // !
                                        'es' => 'Supresión de regla...', // !
                                        'fr' => 'Suppression de règle'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE_SUCCESS',
                                        'parent' => 'PARENT_DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE',
                                        'text' => 'You have successfully deleted the  rule.',
                                        'de' => 'Sie haben die Regel erfolgreich gelöscht.', // !
                                        'es' => 'Has eliminado con éxito la regla.', // !
                                        'fr' => 'Vous avez réussi à supprimer la règle.'));//!
                
                return $text;
            }
            
            /*
             * Discounts - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsHelp($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_HELP',
                                        'parent' => '',
                                        'text' => 'Discounts - Help'));
                
                array_push($text, array('key' => 'DISCOUNTS_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Click on a discount rule to open the editing area.',
                                        'de' => 'Klicken Sie auf eine Rabattregel, um den Bearbeitungsbereich zu öffnen.', // !
                                        'es' => 'Haga clic en una regla de descuento para abrir el área de edición.', // !
                                        'fr' => 'Cliquez sur une règle de réduction pour ouvrir la zone d<<single-quote>>édition.'));//!
                array_push($text, array('key' => 'DISCOUNTS_ADD_DISCOUNT_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Click on the "plus" icon to add a discount.',
                                        'de' => 'Click on the "plus" icon to add a discount.', // !
                                        'es' => 'Haga clic en el icono "plus" para añadir un descuento.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter un rabais.'));//!
                
                /*
                 * Discount help.
                 */
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_NAME_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Change discount name.',
                                        'de' => 'Ändern Sie den Namen des Rabatts.', // !
                                        'es' => 'Cambió el nombre de descuento.', // !
                                        'fr' => 'Nom de remise de changement.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_LANGUAGE_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Change to the language you want to edit the discount.',
                                        'de' => 'Wechseln Sie in die Sprache, in der Sie den Rabatt bearbeiten möchten.', // !
                                        'es' => 'Cambie al idioma que desea para editar el descuento.', // !
                                        'fr' => 'Changez la langue dans laquelle vous souhaitez modifier la réduction.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_EXTRAS_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Calculate reservation discounts including extras price, if used.',
                                        'de' => 'Berechnen Sie ggf. Reservierungsrabatte einschließlich Zusatzpreis.', // !
                                        'es' => 'Calcular descuentos de reservas incluyendo el precio de extras, si se utiliza.', // !
                                        'fr' => 'Calculez les rabais de réservation, y compris le prix des extras, le cas échéant.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ADD_ITEM_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Click on the bellow "plus" icon to add a new discount item.',
                                        'de' => 'Klicken Sie auf das untenstehende "Plus"-Symbol, um einen neuen Rabattartikel hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "plus" para añadir un nuevo artículo de descuento.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" ci-dessous pour ajouter un nouvel élément de réduction.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_EDIT_ITEM_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Click the item "expand" icon to display/hide the settings.',
                                        'de' => 'Klicken Sie auf das Symbol "Erweitern", um die Einstellungen ein-/auszublenden.', // !
                                        'es' => 'Haga clic en el icono "expandir" para mostrar/ocultar la configuración.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "Agrandir" pour afficher/masquer les paramètres.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_DELETE_ITEM_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Click the item "trash" icon to delete it.',
                                        'de' => 'Klicken Sie auf das Symbol "Papierkorb", um es zu löschen.', // !
                                        'es' => 'Haga clic en el icono "basura" para eliminarlo.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>élément "trash" icône pour le supprimer.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_SORT_ITEM_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Drag the item "arrows" icon to sort it.',
                                        'de' => 'Ziehen Sie das Symbol "Pfeile", um es zu sortieren.', // !
                                        'es' => 'Arrastre el icono "flechas" para ordenarlo.', // !
                                        'fr' => 'Faites glisser l<<single-quote>>élément "flèches" icône pour le trier.'));//!
                /*
                 * Discount item help.
                 */
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_LABEL_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Enter item label.',
                                        'de' => 'Geben Sie die Bezeichnung des Elements ein.', // !
                                        'es' => 'Entre en la etiqueta de artículo.', // !
                                        'fr' => 'Entrez l<<single-quote>>étiquette de l<<single-quote>>article.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_START_TIME_LAPSE_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Enter the number of days/hours for the beginning of the time lapse. Leave it blank for it to start from 1 day/hour.',
                                        'de' => 'Geben Sie die Anzahl der Tage/Stunden für den Beginn des Zeitverlaufs ein. Lassen Sie das Feld leer, damit es ab 1 Tag/Stunde beginnt.', // !
                                        'es' => 'Introduzca el número de días/horas para el comienzo del lapso de tiempo. Déjelo en blanco para que comience desde 1 día/hora.', // !
                                        'fr' => 'Entrez le nombre de jours/heures pour le début du laps de temps. Laissez vide pour qu<<single-quote>>il commence à partir de 1 jour/heure.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_END_TIME_LAPSE_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Enter the number of days/hours for the ending of the time lapse. Leave it blank to be unlimited.',
                                        'de' => 'Geben Sie die Anzahl der Tage/Stunden für das Ende des Zeitverlaufs ein. Lassen Sie das Feld leer, um unbegrenzt zu sein.', // !
                                        'es' => 'Introduzca el número de días/horas para el final del lapso de tiempo. Déjelo en blanco para que sea ilimitado.', // !
                                        'fr' => 'Entrez le nombre de jours/heures pour la fin du laps de temps. Laissez le vide pour être illimité.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_OPERATION_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Select item price operation. You can add or subtract a value.',
                                        'de' => 'Funktion "Artikelpreis" auswählen. Sie können einen Wert hinzufügen oder abziehen.', // !
                                        'es' => 'Seleccione el precio del artículo. Puede agregar o restar un valor.', // !
                                        'fr' => 'Sélectionnez l<<single-quote>>opération de prix d<<single-quote>>article. Vous pouvez ajouter ou soustraire une valeur.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_PRICE_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Enter item price.',
                                        'de' => 'Artikelpreis eingeben.', // !
                                        'es' => 'Entre en el precio de artículo.', // !
                                        'fr' => 'Entrez dans le prix d<<single-quote>>article.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_PRICE_TYPE_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Select item price type. It can be a fixed value or a percent from price.',
                                        'de' => 'Wählen Sie die Preisart des Artikels aus. Es kann ein fester Wert oder ein Prozent vom Preis sein.', // !
                                        'es' => 'Seleccione el tipo de precio del artículo. Puede ser un valor fijo o un por ciento del precio.', // !
                                        'fr' => 'Sélectionnez le type de prix de l<<single-quote>>article. Il peut être une valeur fixe ou un pourcentage du prix.'));//!
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_PRICE_BY_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Select item price by. The price can be calculated once or by day/hour.',
                                        'de' => 'Artikelpreis auswählen nach. Der Preis kann einmal oder nach Tag/Stunde berechnet werden.', // !
                                        'es' => 'Seleccione el precio del artículo por. El precio se puede calcular una vez o por día/hora.', // !
                                        'fr' => 'Sélectionnez le prix de l<<single-quote>>article par. Le prix peut être calculé une fois ou par jour/heure.'));//!
                
                array_push($text, array('key' => 'DISCOUNTS_DISCOUNT_ITEM_RULES_HELP',
                                        'parent' => 'PARENT_DISCOUNTS_HELP',
                                        'text' => 'Click the "plus" icon to add another rule and enter the name and price conditions. Click on the "delete" icon to remove the rule. Add dates and hours intervals for which you want the rule to apply.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um eine weitere Regel hinzuzufügen und den Namen und die Preisbedingungen einzugeben. Klicken Sie auf das Symbol "Löschen", um die Regel zu entfernen. Fügen Sie Daten und Stundenintervalle hinzu, für die die Regel gelten soll.', // !
                                        'es' => 'Haga clic en el icono "plus" para añadir otra regla e introduzca el nombre y las condiciones de precio. Haga clic en el icono "delete" para eliminar la regla. Añada fechas e intervalos de horas para los que desea que se aplique la regla.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter une autre règle et entrez le nom et les conditions de prix. Cliquez sur l<<single-quote>>icône "supprimer" pour supprimer la règle. Ajoutez les dates et les heures pour lesquelles vous voulez que la règle s<<single-quote>>applique.'));//!
                
                return $text;
            }
            
            /*
             * Discounts front end text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function discountsFrontEnd($text){
                array_push($text, array('key' => 'PARENT_DISCOUNTS_FRONT_END',
                                        'parent' => '',
                                        'text' => 'Discounts - Front end'));
                
                array_push($text, array('key' => 'DISCOUNTS_FRONT_END_TITLE',
                                        'parent' => 'PARENT_DISCOUNTS_FRONT_END',
                                        'text' => 'Discount',
                                        'de' => 'Rabatt', // !
                                        'es' => 'Descuento', // !
                                        'fr' => 'Remise', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'DISCOUNTS_FRONT_END_BY_DAY',
                                        'parent' => 'PARENT_DISCOUNTS_FRONT_END',
                                        'text' => 'day',
                                        'de' => 'tag', // !
                                        'es' => 'día', // !
                                        'fr' => 'jour', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'DISCOUNTS_FRONT_END_BY_HOUR',
                                        'parent' => 'PARENT_DISCOUNTS_FRONT_END',
                                        'text' => 'hour',
                                        'de' => 'stunde', // !
                                        'es' => 'hora', // !
                                        'fr' => 'heure', //!
                                        'location' => 'all'));
                
                return $text;
            }
        }
    }