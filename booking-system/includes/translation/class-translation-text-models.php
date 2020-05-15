<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : includes/translation/class-translation-models.php
* File Version            : 1.0
* Created / Last Modified : 14 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2016 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Models translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextModels')){
        class DOPBSPTranslationTextModels{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize models text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'models'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'modelsModel'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'modelsAddModel'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'modelsDeleteModel'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'modelsHelp'));
            }
            
            /*
             * Models text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function models($text){
                array_push($text, array('key' => 'PARENT_MODELS',
                                        'parent' => '',
                                        'text' => 'Business models'));
                
                array_push($text, array('key' => 'MODELS_TITLE',
                                        'parent' => 'PARENT_MODELS',
                                        'text' => 'Business models',
                                        'de' => 'Geschäftsmodelle', // !
                                        'es' => 'Modelos de negocio', // !
                                        'fr' => 'Modèles d<<single-quote>>affaires')); //!
                array_push($text, array('key' => 'MODELS_CREATED_BY',
                                        'parent' => 'PARENT_MODELS',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von', // !
                                        'es' => 'Creada por', // !
                                        'fr' => 'Créé par')); //!
                array_push($text, array('key' => 'MODELS_LOAD_SUCCESS',
                                        'parent' => 'PARENT_MODELS',
                                        'text' => 'Business models list loaded.',
                                        'de' => 'Liste der Geschäftsmodelle geladen.', // !
                                        'es' => 'Listado de modelos de negocios cargados.', // !
                                        'fr' => 'La liste des modèles d<<single-quote>>affaires est chargée.')); //!
                array_push($text, array('key' => 'MODELS_NO_MODELS',
                                        'parent' => 'PARENT_MODELS',
                                        'text' => 'No business models. Click the above "plus" icon to add a new one.',
                                        'de' => 'Keine Geschäftsmodelle. Klicken Sie auf das obige "Plus"-Symbol, um ein neues hinzuzufügen.', // !
                                        'es' => 'No hay modelos de negocio. Haga clic en el icono "plus" de arriba para agregar uno nuevo.', // !
                                        'fr' => 'Aucun modèle d<<single-quote>>entreprise. Cliquez sur l<<single-quote>>icône "plus" ci-dessus pour en ajouter un nouveau.')); //!
                
                return $text;
            }
            
            /*
             * Models - Model text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function modelsModel($text){
                array_push($text, array('key' => 'PARENT_MODELS_MODEL',
                                        'parent' => '',
                                        'text' => 'Business models - Business model'));
                
                array_push($text, array('key' => 'MODELS_MODEL_NAME',
                                        'parent' => 'PARENT_MODELS_MODEL',
                                        'text' => 'Name',
                                        'de' => 'Name', // !
                                        'es' => 'Nombre', // !
                                        'fr' => 'Nom')); //!
                array_push($text, array('key' => 'MODELS_MODEL_LANGUAGE',
                                        'parent' => 'PARENT_MODELS_MODEL',
                                        'text' => 'Language',
                                        'de' => 'Sprache', // !
                                        'es' => 'Idioma', // !
                                        'fr' => 'Langue')); //!
                
                array_push($text, array('key' => 'MODELS_MODEL_ENABLED',
                                        'parent' => 'PARENT_MODELS_MODEL',
                                        'text' => 'Use this business model',
                                        'de' => 'Verwenden Sie dieses Geschäftsmodell', // !
                                        'es' => 'Utilice este modelo de negocio', // !
                                        'fr' => 'Utiliser ce modèle d<<single-quote>>affaires')); //!
                array_push($text, array('key' => 'MODELS_MODEL_LABEL',
                                        'parent' => 'PARENT_MODELS_MODEL',
                                        'text' => 'Label',
                                        'de' => 'Etikett', // !
                                        'es' => 'Etiqueta', // !
                                        'fr' => 'Étiquette')); //!
                array_push($text, array('key' => 'MODELS_MODEL_MULTIPLE_CALENDARS',
                                        'parent' => 'PARENT_MODELS_MODEL',
                                        'text' => 'Use multiple calendars',
                                        'de' => 'Verwenden Sie mehrere Kalender', // !
                                        'es' => 'Use múltiples calendarios', // !
                                        'fr' => 'Utilisez des calendriers multiples')); //!
                array_push($text, array('key' => 'MODELS_MODEL_CALENDAR_LABEL',
                                        'parent' => 'PARENT_MODELS_MODEL',
                                        'text' => 'Calendar label',
                                        'de' => 'Kalender Etikett', // !
                                        'es' => 'Etiqueta calendaria', // !
                                        'fr' => 'Étiquette de calendrier')); //!
                
                array_push($text, array('key' => 'MODELS_MODEL_LOADED',
                                        'parent' => 'PARENT_MODELS_MODEL',
                                        'text' => 'Business model loaded.',
                                        'de' => 'Geschäftsmodell geladen.', // !
                                        'es' => 'El modelo de negocio cargó.', // !
                                        'fr' => 'Le modèle d<<single-quote>>entreprise a chargé.')); //!
                
                return $text;
            }
            
            /*
             * Models - Add model text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function modelsAddModel($text){
                array_push($text, array('key' => 'PARENT_MODELS_ADD_MODEL',
                                        'parent' => '',
                                        'text' => 'Business models - Add business model'));
                
                array_push($text, array('key' => 'MODELS_ADD_MODEL_NAME',
                                        'parent' => 'PARENT_MODELS_ADD_MODEL',
                                        'text' => 'New business model',
                                        'de' => 'Neues Geschäftsmodell', // !
                                        'es' => 'Nuevo modelo de negocio', // !
                                        'fr' => 'Nouveau modèle d<<single-quote>>entreprise')); //!
                array_push($text, array('key' => 'MODELS_ADD_MODEL_LABEL',
                                        'parent' => 'PARENT_MODELS_ADD_MODEL',
                                        'text' => 'New business model label',
                                        'de' => 'Neues Geschäftsmodell Etikett', // !
                                        'es' => 'Nueva etiqueta de modelo de negocio', // !
                                        'fr' => 'Nouveau label de business model')); //!
                array_push($text, array('key' => 'MODELS_ADD_MODEL_LABEL_CALENDAR',
                                        'parent' => 'PARENT_MODELS_ADD_MODEL',
                                        'text' => 'Calendar label',
                                        'de' => 'Kalender Etikett', // !
                                        'es' => 'Etiqueta calendaria', // !
                                        'fr' => 'Étiquette de calendrier')); //!
                array_push($text, array('key' => 'MODELS_ADD_MODEL_SUBMIT',
                                        'parent' => 'PARENT_MODELS_ADD_MODEL',
                                        'text' => 'Add business model',
                                        'de' => 'Fügen Sie ein Geschäftsmodell hinzu', // !
                                        'es' => 'Añada el modelo de negocio', // !
                                        'fr' => 'Ajoutez le modèle d<<single-quote>>entreprise')); //!
                array_push($text, array('key' => 'MODELS_ADD_MODEL_ADDING',
                                        'parent' => 'PARENT_MODELS_ADD_MODEL',
                                        'text' => 'Adding a business model ...',
                                        'de' => 'Hinzufügen eines Geschäftsmodells ...', // !
                                        'es' => 'Añadir un modelo de negocio ...', // !
                                        'fr' => 'Ajouter un modèle d<<single-quote>>enterprise...')); //!
                array_push($text, array('key' => 'MODELS_ADD_MODEL_SUCCESS',
                                        'parent' => 'PARENT_MODELS_ADD_MODEL',
                                        'text' => 'You have successfully added a new business model.',
                                        'de' => 'Sie haben erfolgreich ein neues Geschäftsmodell hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito un nuevo modelo de negocio.', // !
                                        'fr' => 'Vous avez réussi à ajouter un nouveau modèle d<<single-quote>>enterprise.')); //!
                
                return $text;
            }
            
            /*
             * Models - Delete model text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function modelsDeleteModel($text){
                array_push($text, array('key' => 'PARENT_MODELS_DELETE_MODEL',
                                        'parent' => '',
                                        'text' => 'Business models - Delete business model'));
                
                array_push($text, array('key' => 'MODELS_DELETE_MODEL_CONFIRMATION',
                                        'parent' => 'PARENT_MODELS_DELETE_MODEL',
                                        'text' => 'Are you sure you want to delete this business model?',
                                        'de' => 'Möchten Sie dieses Geschäftsmodell wirklich löschen?', // !
                                        'es' => '¿Seguro que quieres borrar este modelo de negocio?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer ce modèle d<<single-quote>>affaires?')); //!
                array_push($text, array('key' => 'MODELS_DELETE_MODEL_SUBMIT',
                                        'parent' => 'PARENT_MODELS_DELETE_MODEL',
                                        'text' => 'Delete business model',
                                        'de' => 'Geschäftsmodell löschen', // !
                                        'es' => 'Suprima el modelo de negocio', // !
                                        'fr' => 'Supprimer le modèle d<<single-quote>>entreprise')); //!
                array_push($text, array('key' => 'MODELS_DELETE_MODEL_DELETING',
                                        'parent' => 'PARENT_MODELS_DELETE_MODEL',
                                        'text' => 'Deleting business model ...',
                                        'de' => 'Geschäftsmodell wird gelöscht ...', // !
                                        'es' => 'Supresión de modelo de negocio...', // !
                                        'fr' => 'Suppression de modèle d<<single-quote>>entreprise ...')); //!
                array_push($text, array('key' => 'MODELS_DELETE_MODEL_SUCCESS',
                                        'parent' => 'PARENT_MODELS_DELETE_MODEL',
                                        'text' => 'You have successfully deleted the business model.',
                                        'de' => 'Sie haben das Geschäftsmodell erfolgreich gelöscht.', // !
                                        'es' => 'Ha eliminado con éxito el modelo de negocio.', // !
                                        'fr' => 'Vous avez réussi à supprimer le modèle d<<single-quote>>affaires.')); //!
                
                return $text;
            }
            
            /*
             * Models - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function modelsHelp($text){
                array_push($text, array('key' => 'PARENT_MODELS_HELP',
                                        'parent' => '',
                                        'text' => 'Business models - Help'));
                
                array_push($text, array('key' => 'MODELS_HELP',
                                        'parent' => 'PARENT_MODELS_HELP',
                                        'text' => 'Click on a business model item to open the editing area.',
                                        'de' => 'Klicken Sie auf ein Geschäftsmodell, um den Bearbeitungsbereich zu öffnen.', // !
                                        'es' => 'Haga clic en un modelo de negocio para abrir el área de edición.', // !
                                        'fr' => 'Cliquez sur un élément du modèle d<<single-quote>>entreprise pour ouvrir la zone d<<single-quote>>édition.')); //!
                array_push($text, array('key' => 'MODELS_ADD_MODEL_HELP',
                                        'parent' => 'PARENT_MODELS_HELP',
                                        'text' => 'Click on the "plus" icon to add a business model.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um ein Geschäftsmodell hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "plus" para agregar un modelo de negocio.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter un modèle d<<single-quote>>entreprise.')); //!
                
                /*
                 * Model help.
                 */
                array_push($text, array('key' => 'MODELS_MODEL_HELP',
                                        'parent' => 'PARENT_MODELS_HELP',
                                        'text' => 'Click the "trash" icon to delete the business model.',
                                        'de' => 'Klicken Sie auf das Symbol "Papierkorb", um das Geschäftsmodell zu löschen.', // !
                                        'es' => 'Haga clic en el icono "basura" para eliminar el modelo de negocio.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "corbeille" pour supprimer le modèle d<<single-quote>>entreprise.')); //!
                array_push($text, array('key' => 'MODELS_MODEL_NAME_HELP',
                                        'parent' => 'PARENT_MODELS_HELP',
                                        'text' => 'Change business model name.',
                                        'de' => 'Ändern Sie den Namen des Geschäftsmodells.', // !
                                        'es' => 'Cambie el nombre del modelo de negocio.', // !
                                        'fr' => 'Changer le nom du modèle d<<single-quote>>entreprise.')); //!
                array_push($text, array('key' => 'MODELS_MODEL_LANGUAGE_HELP',
                                        'parent' => 'PARENT_MODELS_HELP',
                                        'text' => 'Change to the language you want to edit the business models.',
                                        'de' => 'Wechseln Sie in die Sprache, in der Sie die Geschäftsmodelle bearbeiten möchten.', // !
                                        'es' => 'Cambie al idioma que desea para editar los modelos de negocio.', // !
                                        'fr' => 'Changez la langue dans laquelle vous souhaitez modifier les modèles d<<single-quote>>entreprise.')); //!
                array_push($text, array('key' => 'MODELS_MODEL_ENABLED_HELP',
                                        'parent' => 'PARENT_MODELS_HELP',
                                        'text' => 'Enable this to use the business model.',
                                        'de' => 'Aktivieren Sie diese Option, um das Geschäftsmodell zu verwenden.', // !
                                        'es' => 'Habilitar esto para utilizar el modelo de negocio.', // !
                                        'fr' => 'Permettre d<<single-quote>>utiliser le modèle d<<single-quote>>entreprise.')); //!
                array_push($text, array('key' => 'MODELS_MODEL_LABEL_HELP',
                                        'parent' => 'PARENT_MODELS_HELP',
                                        'text' => 'Enter business model label.',
                                        'de' => 'Geben Sie die Etikett des Geschäftsmodells ein.', // !
                                        'es' => 'Introduzca la etiqueta de modelo de negocio.', // !
                                        'fr' => 'Entrez l<<single-quote>>étiquette du modèle d<<single-quote>>entreprise.')); //!
                array_push($text, array('key' => 'MODELS_MODEL_MULTIPLE_CALENDARS_HELP',
                                        'parent' => 'PARENT_MODELS_HELP',
                                        'text' => 'Enable this option to add more than one calendar to your business model',
                                        'de' => 'Aktivieren Sie diese Option, um Ihrem Geschäftsmodell mehr als einen Kalender hinzuzufügen', // !
                                        'es' => 'Habilite esta opción para agregar más de un calendario a su modelo de negocio', // !
                                        'fr' => 'Activez cette option pour ajouter plus d<<single-quote>>un calendrier à votre modèle d<<single-quote>>entreprise')); //!
                array_push($text, array('key' => 'MODELS_MODEL_CALENDAR_LABEL_HELP',
                                        'parent' => 'PARENT_MODELS_HELP',
                                        'text' => 'Set how the calendars should be called. Examples: Rooms, Staff, ...',
                                        'de' => 'Legen Sie fest, wie die Kalender aufgerufen werden sollen. Beispiele: Zimmer, Personal, ...', // !
                                        'es' => 'Establecer cómo se deben llamar los calendarios. Ejemplos: Habitaciones, Personal, ...', // !
                                        'fr' => 'Définir comment les calendriers doivent être appelés. Exemples : Chambres, Personnel, ...')); //!
                
                return $text;
            }
        }
    }