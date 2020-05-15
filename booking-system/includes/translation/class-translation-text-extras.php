<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-extras.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Extras translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextExtras')){
        class DOPBSPTranslationTextExtras{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize extras text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extras'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasDefault'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasExtra'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasAddExtra'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasDeleteExtra'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasExtraGroups'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasExtraGroup'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasExtraAddGroup'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasExtraDeleteGroup'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasExtraGroupItems'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasExtraGroupItem'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasExtraGroupAddItem'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasExtraGroupDeleteItem'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'extrasFrontEnd'));
            }
            
            /*
             * Extras text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extras($text){
                array_push($text, array('key' => 'PARENT_EXTRAS',
                                        'parent' => '',
                                        'text' => 'Extras'));
                
                array_push($text, array('key' => 'EXTRAS_TITLE',
                                        'parent' => 'PARENT_EXTRAS',
                                        'text' => 'Extras',
                                        'de' => 'Extras', // !
                                        'es' => 'Extras', // !
                                        'fr' => 'Suppléments')); //!
                array_push($text, array('key' => 'EXTRAS_CREATED_BY',
                                        'parent' => 'PARENT_EXTRAS',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von', // !
                                        'es' => 'Creada por', // !
                                        'fr' => 'Créé par'));//!
                array_push($text, array('key' => 'EXTRAS_LOAD_SUCCESS',
                                        'parent' => 'PARENT_EXTRAS',
                                        'text' => 'Extras list loaded.',
                                        'de' => 'Extras Liste geladen.', // !
                                        'es' => 'La lista de Extras cargó.', // !
                                        'fr' => 'La liste des suppléments est chargée.'));//!
                array_push($text, array('key' => 'EXTRAS_NO_EXTRAS',
                                        'parent' => 'PARENT_EXTRAS',
                                        'text' => 'No extras. Click the above "plus" icon to add a new one.',
                                        'de' => 'Keine Extras. Klicken Sie auf das obige "Plus"-Symbol, um ein neues hinzuzufügen.', // !
                                        'es' => 'No hay Extras. Haga clic en el icono "plus" de arriba para agregar uno nuevo.', // !
                                        'fr' => 'Pas de suppléments. Cliquez sur l<<single-quote>>icône "plus" ci-dessus pour en ajouter une nouvelle.'));//!
                
                return $text;
            }
            
            /*
             * Extras default text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasDefault($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_DEFAULT',
                                        'parent' => '',
                                        'text' => 'Extras - Default data'));
                
                array_push($text, array('key' => 'EXTRAS_DEFAULT_PEOPLE',
                                        'parent' => 'PARENT_EXTRAS_DEFAULT',
                                        'text' => 'People',
                                        'de' => 'Personen', // !
                                        'es' => 'Personas', // !
                                        'fr' => 'Personnes'));//!
                array_push($text, array('key' => 'EXTRAS_DEFAULT_ADULTS',
                                        'parent' => 'PARENT_EXTRAS_DEFAULT',
                                        'text' => 'Adults',
                                        'de' => 'Erwachsenen', // !
                                        'es' => 'Adultos', // !
                                        'fr' => 'Adultes'));//!
                array_push($text, array('key' => 'EXTRAS_DEFAULT_CHILDREN',
                                        'parent' => 'PARENT_EXTRAS_DEFAULT',
                                        'text' => 'Children',
                                        'de' => 'Kinder', // !
                                        'es' => 'Niños', // !
                                        'fr' => 'Enfants'));//!
                
                return $text;
            }
            
            /*
             * Extras - Extra text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasExtra($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_EXTRA',
                                        'parent' => '',
                                        'text' => 'Extras - Extra'));
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_NAME',
                                        'parent' => 'PARENT_EXTRAS_EXTRA',
                                        'text' => 'Name',
                                        'de' => 'Name', // !
                                        'es' => 'Nombre', // !
                                        'fr' => 'Nom'));
                array_push($text, array('key' => 'EXTRAS_EXTRA_LANGUAGE',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP',
                                        'text' => 'Language',
                                        'de' => 'Sprache', // !
                                        'es' => 'Idioma', // !
                                        'fr' => 'Langue'));
                array_push($text, array('key' => 'EXTRAS_EXTRA_LOADED',
                                        'parent' => 'PARENT_EXTRAS_EXTRA',
                                        'text' => 'Extra loaded.',
                                        'de' => 'Extra geladen.', // !
                                        'es' => 'Los extras cargaron', // !
                                        'fr' => 'Supplément chargée.'));//!
                
                return $text;
            }
            
            /*
             * Extras - Add extra text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasAddExtra($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_ADD_EXTRA',
                                        'parent' => '',
                                        'text' => 'Extras - Add extra'));
                
                array_push($text, array('key' => 'EXTRAS_ADD_EXTRA_NAME',
                                        'parent' => 'PARENT_EXTRAS_ADD_EXTRA',
                                        'text' => 'New extra',
                                        'de' => 'Neue extra', // !
                                        'es' => 'Nuevo extra', // !
                                        'fr' => 'Nouveau supplément'));
                array_push($text, array('key' => 'EXTRAS_ADD_EXTRA_SUBMIT',
                                        'parent' => 'PARENT_EXTRAS_ADD_EXTRA',
                                        'text' => 'Add extra',
                                        'de' => 'Fügen Sie extra hinzu', // !
                                        'es' => 'Añadir extra', // !
                                        'fr' => 'Ajoutez supplément'));//!
                array_push($text, array('key' => 'EXTRAS_ADD_EXTRA_ADDING',
                                        'parent' => 'PARENT_EXTRAS_ADD_EXTRA',
                                        'text' => 'Adding a new extra ...',
                                        'de' => 'Ein neues Extra hinzufügen ...', // !
                                        'es' => 'Añadir un nuevo extras ...', // !
                                        'fr' => 'Ajout d<<single-quote>>un nouveau supplément ...'));//!
                array_push($text, array('key' => 'EXTRAS_ADD_EXTRA_SUCCESS',
                                        'parent' => 'PARENT_EXTRAS_ADD_EXTRA',
                                        'text' => 'You have successfully added a new extra.',
                                        'de' => 'Sie haben erfolgreich ein neues Extra hinzugefügt.', // !
                                        'es' => 'Has añadido con éxito un nuevo extra.', // !
                                        'fr' => 'Vous avez réussi à ajouter un nouveau supplément.'));//!
                
                return $text;
            }
            
            /*
             * Extras - Delete extra text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasDeleteExtra($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_DELETE_EXTRA',
                                        'parent' => '',
                                        'text' => 'Extras - Delete extra'));
                
                array_push($text, array('key' => 'EXTRAS_DELETE_EXTRA_CONFIRMATION',
                                        'parent' => 'PARENT_EXTRAS_DELETE_EXTRA',
                                        'text' => 'Are you sure you want to delete this extra?',
                                        'de' => 'Möchten Sie diesen extra wirklich löschen?', // !
                                        'es' => '¿Seguro que quieres borrar este extra?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer ce supplément?'));//!
                array_push($text, array('key' => 'EXTRAS_DELETE_EXTRA_SUBMIT',
                                        'parent' => 'PARENT_EXTRAS_DELETE_EXTRA',
                                        'text' => 'Delete extra',
                                        'de' => 'Löschen von extra', // !
                                        'es' => 'Suprima extra', // !
                                        'fr' => 'Supprimez le supplément')); //!
                array_push($text, array('key' => 'EXTRAS_DELETE_EXTRA_DELETING',
                                        'parent' => 'PARENT_EXTRAS_DELETE_EXTRA',
                                        'text' => 'Deleting extra ...',
                                        'de' => 'Löschen von extra ...', // !
                                        'es' => 'Supresión extra...', // !
                                        'fr' => 'Suppression de supplémentaire ...'));//!
                array_push($text, array('key' => 'EXTRAS_DELETE_EXTRA_SUCCESS',
                                        'parent' => 'PARENT_EXTRAS_DELETE_EXTRA',
                                        'text' => 'You have successfully deleted the extra.',
                                        'de' => 'Sie haben den extra erfolgreich gelöscht.', // !
                                        'es' => 'Has eliminado con éxito el extra.', // !
                                        'fr' => 'Vous avez réussi à supprimer le supplément.'));//!
                
                return $text;
            }
            
            /*
             * Extras - Extra groups text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasExtraGroups($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_EXTRA_GROUPS',
                                        'parent' => '',
                                        'text' => 'Extras - Extra groups'));
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUPS',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUPS',
                                        'text' => 'Extra fields',
                                        'de' => 'Extra Felder', // !
                                        'es' => 'Extra campos', // !
                                        'fr' => 'Les champs supplémentaires'));//!
                
                return $text;
            }
            
            /*
             * Extras - Extra group text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasExtraGroup($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_EXTRA_GROUP',
                                        'parent' => '',
                                        'text' => 'Extras - Extra group'));
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_SHOW_SETTINGS',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP',
                                        'text' => 'Show settings',
                                        'de' => 'Einstellungen anzeigen',
                                        'es' => 'Muestre los ajustes', // !
                                        'fr' => 'Montrez les parametres'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_HIDE_SETTINGS',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP',
                                        'text' => 'Hide settings',
                                        'de' => 'Einstellungen ausblenden', // !
                                        'es' => 'Oculte los ajustes', // !
                                        'fr' => 'Cachez les paramètres'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_SORT',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP',
                                        'text' => 'Sort',
                                        'de' => 'Sortieren',
                                        'es' => 'Ordenar', // !
                                        'fr' => 'Sorte'));//!
                /*
                 * Settings labels.
                 */
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_LABEL_LABEL',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP',
                                        'text' => 'Label',
                                        'de' => 'Etikett', // !
                                        'es' => 'Etiqueta', // !
                                        'fr' => 'Étiquette'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_REQUIRED_LABEL',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP',
                                        'text' => 'Required',
                                        'de' => 'Erforderlich', // !
                                        'es' => 'Necesario', // !
                                        'fr' => 'Nécessaire'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_NO_ITEMS_MULTIPLY_LABEL',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP',
                                        'text' => 'Multiply with No. Items',
                                        'de' => 'Multiplizieren Sie mit der Anzahl der Elemente', // !
                                        'es' => 'Multiplicar con número de artículos', // !
                                        'fr' => 'Multiplier par No. Items'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_MULTIPLE_SELECT_LABEL',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP',
                                        'text' => 'Multiple select',
                                        'de' => 'Mehrfachauswahl', // !
                                        'es' => 'Múltiple escogido', // !
                                        'fr' => 'Select multiple')); //!
                
                return $text;
            }
            
            /*
             * Extras - Add extra group text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasExtraAddGroup($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_EXTRA_ADD_GROUP',
                                        'parent' => '',
                                        'text' => 'Extras - Add extra group'));
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_ADD_GROUP_SUBMIT',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_ADD_GROUP',
                                        'text' => 'Add group',
                                        'de' => 'Gruppe hinzufügen', // !
                                        'es' => 'Añada grupo', // !
                                        'fr' => 'Ajoutez un groupe'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_ADD_GROUP_LABEL',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_ADD_GROUP',
                                        'text' => 'New group',
                                        'de' => 'Neue Gruppe', // !
                                        'es' => 'Nuevo grupo', // !
                                        'fr' => 'Nouveau groupe'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_ADD_GROUP_ADDING',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_ADD_GROUP',
                                        'text' => 'Adding a new extra group ...',
                                        'de' => 'Hinzufügen einer neuen extra Gruppe ...', // !
                                        'es' => 'Añadir un nuevo grupo extra ...', // !
                                        'fr' => 'Ajout d<<single-quote>>un nouveau groupe supplémentaire...'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_ADD_GROUP_SUCCESS',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_ADD_GROUP',
                                        'text' => 'You have successfully added a new extra group.',
                                        'de' => 'Sie haben erfolgreich eine neue extra Gruppe hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito un nuevo extra grupo.', // !
                                        'fr' => 'Vous avez réussi à ajouter un nouveau groupe supplémentaire.'));//!
                
                return $text;
            }
            
            /*
             * Extras - Delete extra group text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasExtraDeleteGroup($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_EXTRA_DELETE_GROUP',
                                        'parent' => '',
                                        'text' => 'Extras - Delete extra group'));
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_DELETE_GROUP_CONFIRMATION',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_DELETE_GROUP',
                                        'text' => 'Are you sure you want to delete this extra group?',
                                        'de' => 'Möchten Sie diese extra Gruppe wirklich löschen?', // !
                                        'es' => '¿Seguro que quieres borrar este grupo extra?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer ce groupe supplémentaire?'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_DELETE_GROUP_SUBMIT',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_DELETE_GROUP',
                                        'text' => 'Delete',
                                        'de' => 'Löschen', // !
                                        'es' => 'Borrar', // !
                                        'fr' => 'Supprimer'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_DELETE_GROUP_DELETING',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_DELETE_GROUP',
                                        'text' => 'Deleting extra group ...',
                                        'de' => 'Extra Gruppe wird gelöscht ...', // !
                                        'es' => 'Supresión de grupo extra', // !
                                        'fr' => 'Suppression de groupe supplémentaire ...'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_DELETE_GROUP_SUCCESS',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_DELETE_GROUP',
                                        'text' => 'You have successfully deleted the extra group.',
                                        'de' => 'Sie haben die zusätzliche Gruppe erfolgreich gelöscht.', // !
                                        'es' => 'Ha eliminado con éxito el grupo extra.', // !
                                        'fr' => 'Vous avez réussi à supprimer le groupe supplémentaire.'));//!
                
                return $text;
            }
            
            /*
             * Extras - Extra group items text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasExtraGroupItems($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEMS',
                                        'parent' => '',
                                        'text' => 'Extras - Extra group - Items'));
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_LABEL',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEMS',
                                        'text' => 'Items',
                                        'de' => 'Elemente', // !
                                        'es' => 'Artículos', // !
                                        'fr' => 'Les éléments'));//!
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_LABELS_LABEL',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEMS',
                                        'text' => 'Label',
                                        'de' => 'Etikett', // !
                                        'es' => 'Etiqueta', // !
                                        'fr' => 'Étiquette'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_LABELS_OPERATION',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEMS',
                                        'text' => 'Operation',
                                        'de' => 'Vorgang', // !
                                        'es' => 'Operación', // !
                                        'fr' => 'Opération'));//1
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_LABELS_PRICE',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEMS',
                                        'text' => 'Price/Percent',
                                        'de' => 'Preis/Prozent', // !
                                        'es' => 'Precio/Por ciento', // !
                                        'fr' => 'Prix/Pour cent'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_LABELS_PRICE_TYPE',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEMS',
                                        'text' => 'Price type',
                                        'de' => 'Preistyp', // !
                                        'es' => 'Tipo de precios', // !
                                        'fr' => 'Type des prix'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_LABELS_PRICE_BY',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEMS',
                                        'text' => 'Price by',
                                        'de' => 'Preis von', // !
                                        'es' => 'Precio por', // !
                                        'fr' => 'Prix par')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_LABELS_DEFAULT',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEMS',
                                        'text' => 'Set as default',
                                        'de' => 'Als Standard festlegen', // !
                                        'es' => 'Establecer por defecto', // !
                                        'fr' => 'Définir par défaut'));//!
                                    
                return $text;
            }
            
            /*
             * Extras - Extra group item text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasExtraGroupItem($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEM',
                                        'parent' => '',
                                        'text' => 'Extras - Extra group - Item'));
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_PRICE_TYPE_FIXED',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEM',
                                        'text' => 'Fixed',
                                        'de' => 'Fest', // !
                                        'es' => 'Fijo', // !
                                        'fr' => 'Fixe'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_PRICE_TYPE_PERCENT',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEM',
                                        'text' => 'Percent',
                                        'de' => 'Prozent', // !
                                        'es' => 'Por ciento', // !
                                        'fr' => 'Pour cent'));//!
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_PRICE_BY_ONCE',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEM',
                                        'text' => 'Once',
                                        'de' => 'Einmal', // !
                                        'es' => 'Una vez', // !
                                        'fr' => 'Une fois'));//!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_PRICE_BY_PERIOD',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEM',
                                        'text' => 'day/hour',
                                        'de' => 'tag/stunde', // !
                                        'es' => 'día/hora', // !
                                        'fr' => 'jour/heure'));//!
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_PRICE_BY_PERIOD',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEM',
                                        'text' => 'day/hour',
                                        'de' => 'tag/stunde', // !
                                        'es' => 'día/hora', // !
                                        'fr' => 'jour/heure'));//!
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEM_SORT',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEM',
                                        'text' => 'Sort',
                                        'de' => 'Sortieren', // !
                                        'es' => 'Ordenar', // !
                                        'fr' => 'Sorte'));//!
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_DEFAULT_NO',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEM',
                                        'text' => 'No',
                                        'de' => 'Nein', // !
                                        'es' => 'No', // !
                                        'fr' => 'No'));
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_DEFAULT_YES',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ITEM',
                                        'text' => 'Yes',
                                        'de' => 'Ja', // !
                                        'es' => 'Sí', // !
                                        'fr' => 'Oui'));
                
                return $text;
            }
            
            /*
             * Extras - Add extra group item text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasExtraGroupAddItem($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_EXTRA_GROUP_ADD_ITEM',
                                        'parent' => '',
                                        'text' => 'Extras - Extra group - Add item'));
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ADD_ITEM_LABEL',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ADD_ITEM',
                                        'text' => 'New item',
                                        'de' => 'Neues Element', // !
                                        'es' => 'Nuevo artículo', // !
                                        'fr' => 'nouvel élément')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ADD_ITEM_SUBMIT',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ADD_ITEM',
                                        'text' => 'Add item',
                                        'de' => 'Element hinzufügen', // !
                                        'es' => 'Añada el artículo', // !
                                        'fr' => 'Ajouter un élément')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ADD_ITEM_ADDING',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ADD_ITEM',
                                        'text' => 'Adding a new item ...',
                                        'de' => 'Hinzufügen eines neuen Elements ...', // !
                                        'es' => 'Añadir un nuevo artículo ...', // !
                                        'fr' => 'Ajout d<<single-quote>>un nouvel élément...')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ADD_ITEM_SUCCESS',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_ADD_ITEM',
                                        'text' => 'You have successfully added a new item.',
                                        'de' => 'Sie haben erfolgreich ein neues Element hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito un nuevo artículo', // !
                                        'fr' => 'Vous avez réussi à ajouter un nouvel élément.')); //!
                
                return $text;
            }
            
            /*
             * Extras - Delete extra group item text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasExtraGroupDeleteItem($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_EXTRA_GROUP_DELETE_ITEM',
                                        'parent' => '',
                                        'text' => 'Extras - Extra group - Delete item'));
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_DELETE_ITEM_CONFIRMATION',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_DELETE_ITEM',
                                        'text' => 'Are you sure you want to delete this  item?',
                                        'de' => 'Möchten Sie dieses Element wirklich löschen?', // !
                                        'es' => '¿Estás seguro de que quieres eliminar este artículo?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer cet élément?')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_DELETE_ITEM_SUBMIT',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_DELETE_ITEM',
                                        'text' => 'Delete',
                                        'de' => 'Löschen', // !
                                        'es' => 'Borrar', // !
                                        'fr' => 'Supprimer')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_DELETE_ITEM_DELETING',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_DELETE_ITEM',
                                        'text' => 'Deleting  item ...',
                                        'de' => 'Element wird gelöscht...', // !
                                        'es' => 'Supresión de artículo...', // !
                                        'fr' => 'Suppression d<<single-quote>>élément...')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_DELETE_ITEM_SUCCESS',
                                        'parent' => 'PARENT_EXTRAS_EXTRA_GROUP_DELETE_ITEM',
                                        'text' => 'You have successfully deleted the  item.',
                                        'de' => 'Sie haben das Element erfolgreich gelöscht.', // !
                                        'es' => 'Ha eliminado con éxito el artículo.', // !
                                        'fr' => 'Vous avez réussi à supprimer l<<single-quote>>élément.')); //!
                
                return $text;
            }
            
            /*
             * Extras - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasHelp($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_HELP',
                                        'parent' => '',
                                        'text' => 'Extras - Help'));
                
                array_push($text, array('key' => 'EXTRAS_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Click on a extra item to open the editing area.',
                                        'de' => 'Klicken Sie auf ein zusätzliches Element, um den Bearbeitungsbereich zu öffnen.', // !
                                        'es' => 'Haga clic en un extra artículo para abrir el área de edición.', // !
                                        'fr' => 'Cliquez sur un élément supplémentaire pour ouvrir la zone d<<single-quote>>édition.')); //!
                array_push($text, array('key' => 'EXTRAS_ADD_EXTRA_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Click on the "plus" icon to add a extra.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um ein Extra hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "plus" para agregar un extra.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter un supplément.')); //!
                
                /*
                 * Extra help.
                 */
                array_push($text, array('key' => 'EXTRAS_EXTRA_NAME_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Change extra name.',
                                        'de' => 'Ändern Sie den extra Namen.', // !
                                        'es' => 'Cambiar el nombre de extra', // !
                                        'fr' => 'Changer le nom du supplément')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_LANGUAGE_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Change to the language you want to edit the extra.',
                                        'de' => 'Wechseln Sie in die Sprache, in der Sie das Extra bearbeiten möchten.', // !
                                        'es' => 'Cambie al idioma que desea editar el extra.', // !
                                        'fr' => 'Modifiez la langue dans laquelle vous voulez modifier le supplément.')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_ADD_GROUP_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Click on the bellow "plus" icon to add a new extra group.',
                                        'de' => 'Klicken Sie auf das untenstehende "Plus"-Symbol, um eine neue zusätzliche Gruppe hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "plus" para añadir un nuevo grupo extra.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" ci-dessous pour ajouter un nouveau groupe supplémentaire.')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_EDIT_GROUP_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Click the group "expand" icon to display/hide the settings.',
                                        'de' => 'Klicken Sie auf das Gruppensymbol "Erweitern", um die Einstellungen ein-/auszublenden.', // !
                                        'es' => 'Haga clic en el icono "expandir" para mostrar/ocultar la configuración.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "Agrandir" du groupe pour afficher/masquer les paramètres.')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_DELETE_GROUP_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Click the group "trash" icon to delete it.',
                                        'de' => 'Klicken Sie auf das Symbol "Papierkorb", um es zu löschen.', // !
                                        'es' => 'Haga clic en el grupo "basura" icono para eliminarlo.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "corbeille" du groupe pour le supprimer.')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_SORT_GROUP_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Drag the group "arrows" icon to sort it.',
                                        'de' => 'Ziehen Sie das Gruppensymbol "Pfeile", um es zu sortieren.', // !
                                        'es' => 'Arrastre el icono "flechas" de grupo para ordenarlo.', // !
                                        'fr' => 'Faites glisser l<<single-quote>>icône "flèches" du groupe pour le trier.')); //!
                /*
                 * Extra group help.
                 */
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_LABEL_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Enter group label.',
                                        'de' => 'Geben Sie die Etikett der Gruppe ein.', // !
                                        'es' => 'Entre en la etiqueta de grupo.', // !
                                        'fr' => 'Entrez dans l<<single-quote>>étiquette de groupe.')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_REQUIRED_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Enable it if you want the group to be mandatory.',
                                        'de' => 'Aktivieren Sie diese Option, wenn die Gruppe obligatorisch sein soll.', // !
                                        'es' => 'Activa si quieres que el grupo sea obligatorio.', // !
                                        'fr' => 'Activez-le si vous voulez que le groupe soit obligatoire.')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_MULTIPLE_SELECT_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Enable it if you want multiple selection.',
                                        'de' => 'Aktivieren Sie diese Option, wenn Sie mehrere Optionen auswählen möchten.', // !
                                        'es' => 'Activar si desea selección múltiple.', // !
                                        'fr' => 'Activez-le si vous voulez une sélection multiple.')); //!
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_NO_ITEMS_MULTIPLY_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Enable it if you want the extras price to be multiplied with the number of items.',
                                        'de' => 'Aktivieren Sie diese Option, wenn der Zusatzpreis mit der Anzahl der Artikel multipliziert werden soll.', // !
                                        'es' => 'Habilite si desea que el precio de los extras se multiplique con el número de artículos.', // !
                                        'fr' => 'Activez-le si vous voulez que le prix des extras soit multiplié par le nombre d<<single-quote>>articles.')); //!
                
                array_push($text, array('key' => 'EXTRAS_EXTRA_GROUP_ITEMS_HELP',
                                        'parent' => 'PARENT_EXTRAS_HELP',
                                        'text' => 'Click the "plus" icon to add another item and enter the name and price conditions. Click on the "delete" icon to remove the item.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um einen weiteren Artikel hinzuzufügen und geben Sie den Namen und die Preisbedingungen ein. Klicken Sie auf das Symbol "Löschen", um das Element zu entfernen.', // !
                                        'es' => 'Haga clic en el icono "plus" para añadir otro elemento e introducir el nombre y las condiciones de precio. Haga clic en el icono "delete" para eliminar el elemento.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter un autre élément et entrez le nom et les conditions de prix. Cliquez sur l<<single-quote>>icône "supprimer" pour supprimer l<<single-quote>>élément.')); //!
                
                return $text;
            }
            
            /*
             * Extras front end text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function extrasFrontEnd($text){
                array_push($text, array('key' => 'PARENT_EXTRAS_FRONT_END',
                                        'parent' => '',
                                        'text' => 'Extras - Front end'));
                
                array_push($text, array('key' => 'EXTRAS_FRONT_END_TITLE',
                                        'parent' => 'PARENT_EXTRAS_FRONT_END',
                                        'text' => 'Extras',
                                        'de' => 'Extras', // !
                                        'es' => 'Extras', // !
                                        'fr' => 'Suppléments',//!
                                        'location' => 'all'));
                array_push($text, array('key' => 'EXTRAS_FRONT_END_BY_DAY',
                                        'parent' => 'PARENT_EXTRAS_FRONT_END',
                                        'text' => 'day',
                                        'de' => 'tag', // !
                                        'es' => 'día', // !
                                        'fr' => 'jour',//!
                                        'location' => 'all')); 
                array_push($text, array('key' => 'EXTRAS_FRONT_END_BY_HOUR',
                                        'parent' => 'PARENT_EXTRAS_FRONT_END',
                                        'text' => 'hour',
                                        'de' => 'stunde', // !
                                        'es' => 'hora', // !
                                        'fr' => 'heure',//!
                                        'location' => 'all')); 
                array_push($text, array('key' => 'EXTRAS_FRONT_END_INVALID',
                                        'parent' => 'PARENT_EXTRAS_FRONT_END',
                                        'text' => 'Select an option from',
                                        'de' => 'Wählen Sie eine Option aus', // !
                                        'es' => 'Seleccione una opción desde', // !
                                        'fr' => 'Sélectionnez une option dans',//!
                                        'location' => 'all')); 
                
                return $text;
            }
        }
    }