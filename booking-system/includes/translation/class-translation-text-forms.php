<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-forms.php
* File Version            : 1.0.4
* Created / Last Modified : 07 September 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Forms translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextForms')){
        class DOPBSPTranslationTextForms{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize forms text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'forms'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsDefault'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsForm'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsAddForm'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsDeleteForm'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsFormFields'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsFormField'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsFormAddField'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsFormDeleteField'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsFormFieldSelectOptions'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsFormFieldSelectOption'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsFormFieldSelectAddOption'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsFormFieldSelectDeleteOption'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'formsFrontEnd'));
            }
            
            /*
             * Forms text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function forms($text){
                array_push($text, array('key' => 'PARENT_FORMS',
                                        'parent' => '',
                                        'text' => 'Forms'));
                
                array_push($text, array('key' => 'FORMS_TITLE',
                                        'parent' => 'PARENT_FORMS',
                                        'text' => 'Forms',
                                        'de' => 'Formularen', // !
                                        'es' => 'Formularios', // !
                                        'fr' => 'Formulaire')); //!
                array_push($text, array('key' => 'FORMS_CREATED_BY',
                                        'parent' => 'PARENT_FORMS',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von', // !
                                        'es' => 'Creada por', // !
                                        'fr' => 'Créé par')); //!
                array_push($text, array('key' => 'FORMS_LOAD_SUCCESS',
                                        'parent' => 'PARENT_FORMS',
                                        'text' => 'Forms list loaded.',
                                        'de' => 'Formularliste geladen.', // !
                                        'es' => 'La lista de Formularios cargó.', // !
                                        'fr' => 'Liste de formulaires chargée')); //!
                array_push($text, array('key' => 'FORMS_NO_FORMS',
                                        'parent' => 'PARENT_FORMS',
                                        'text' => 'No forms. Click the above "plus" icon to add a new one.',
                                        'de' => 'Keine Formulare. Klicken Sie auf das obige "Plus"-Symbol, um ein neues hinzuzufügen.', // !
                                        'es' => 'No hay formularios. Haga clic en el icono "plus" de arriba para agregar uno nuevo.', // !
                                        'fr' => 'Aucun formulaire. Cliquez sur l<<single-quote>>icône "plus" ci-dessus pour en ajouter un nouveau.')); //!
                
                return $text;
            }
            
            /*
             * Forms default text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsDefault($text){
                array_push($text, array('key' => 'PARENT_FORMS_DEFAULT',
                                        'parent' => '',
                                        'text' => 'Forms - Default data'));
                
                array_push($text, array('key' => 'FORMS_DEFAULT_NAME',
                                        'parent' => 'PARENT_FORMS_DEFAULT',
                                        'text' => 'Contact information',
                                        'de' => 'Kontaktinformationen', // !
                                        'es' => 'Información de contacto', // !
                                        'fr' => 'Informations de contact', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'FORMS_DEFAULT_FIRST_NAME',
                                        'parent' => 'PARENT_FORMS_DEFAULT',
                                        'text' => 'First name',
                                        'de' => 'Vorname', // !
                                        'es' => 'Nombre', // !
                                        'fr' => 'Prenom', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'FORMS_DEFAULT_LAST_NAME',
                                        'parent' => 'PARENT_FORMS_DEFAULT',
                                        'text' => 'Last name',
                                        'de' => 'Nachname', // !
                                        'es' => 'Apellido', // !
                                        'fr' => 'Nom', //!
                                        'location' => 'all')); 
                array_push($text, array('key' => 'FORMS_DEFAULT_EMAIL',
                                        'parent' => 'PARENT_FORMS_DEFAULT',
                                        'text' => 'Email',
                                        'de' => 'E-Mail', // !
                                        'es' => 'Correo electrónico', // !
                                        'fr' => 'Email', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'FORMS_DEFAULT_PHONE',
                                        'parent' => 'PARENT_FORMS_DEFAULT',
                                        'text' => 'Phone',
                                        'de' => 'Telefon', // !
                                        'es' => 'Teléfono', // !
                                        'fr' => 'Téléphone', //!
                                        'location' => 'all')); 
                array_push($text, array('key' => 'FORMS_DEFAULT_MESSAGE',
                                        'parent' => 'PARENT_FORMS_DEFAULT',
                                        'text' => 'Message',
                                        'de' => 'Nachricht', // !
                                        'es' => 'Mensaje', // !
                                        'fr' => 'Message', //!
                                        'location' => 'all'));
                
                return $text;
            }
            
            /*
             * Forms - Form text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsForm($text){
                array_push($text, array('key' => 'PARENT_FORMS_FORM',
                                        'parent' => '',
                                        'text' => 'Forms - Form'));
                
                array_push($text, array('key' => 'FORMS_FORM_NAME',
                                        'parent' => 'PARENT_FORMS_FORM',
                                        'text' => 'Name',
                                        'de' => 'Name', // !
                                        'es' => 'Nombre', // !
                                        'fr' => 'Nom')); //!
                array_push($text, array('key' => 'FORMS_FORM_LANGUAGE',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Language',
                                        'de' => 'Sprache', // !
                                        'es' => 'Idioma', // !
                                        'fr' => 'Langue')); //!
                array_push($text, array('key' => 'FORMS_FORM_LOADED',
                                        'parent' => 'PARENT_FORMS_FORM',
                                        'text' => 'Form loaded.',
                                        'de' => 'Formular geladen.', // !
                                        'es' => 'Formulario cargó.', // !
                                        'fr' => 'Foormulaire chargée')); //!
                
                return $text;
            }
            
            /*
             * Forms - Add form text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsAddForm($text){
                array_push($text, array('key' => 'PARENT_FORMS_ADD_FORM',
                                        'parent' => '',
                                        'text' => 'Forms - Add form'));
                
                array_push($text, array('key' => 'FORMS_ADD_FORM_NAME',
                                        'parent' => 'PARENT_FORMS_ADD_FORM',
                                        'text' => 'New form',
                                        'de' => 'Neues Formular', // !
                                        'es' => 'Nuevo formulario', // !
                                        'fr' => 'Nouveau formulaire')); //!
                array_push($text, array('key' => 'FORMS_ADD_FORM_SUBMIT',
                                        'parent' => 'PARENT_FORMS_ADD_FORM',
                                        'text' => 'Add form',
                                        'de' => 'Formular hinzufügen', // !
                                        'es' => 'Añada formulario', // !
                                        'fr' => 'Ajoutez un formulaire')); //!
                array_push($text, array('key' => 'FORMS_ADD_FORM_ADDING',
                                        'parent' => 'PARENT_FORMS_ADD_FORM',
                                        'text' => 'Adding a new form ...',
                                        'de' => 'Hinzufügen eines neuen Formulars ...', // !
                                        'es' => 'Añadir un nuevo formulario ...', // !
                                        'fr' => 'Ajout d<<single-quote>>un nouveau formulaire...')); //!
                array_push($text, array('key' => 'FORMS_ADD_FORM_SUCCESS',
                                        'parent' => 'PARENT_FORMS_ADD_FORM',
                                        'text' => 'You have successfully added a new form.',
                                        'de' => 'Sie haben erfolgreich ein neues Formular hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito un nuevo formulario.', // !
                                        'fr' => 'Vous avez réussi à ajouter un nouveau formulaire.')); //!
                
                return $text;
            }
            
            /*
             * Forms - Delete form text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsDeleteForm($text){
                array_push($text, array('key' => 'PARENT_FORMS_DELETE_FORM',
                                        'parent' => '',
                                        'text' => 'Forms - Delete form'));
                
                array_push($text, array('key' => 'FORMS_DELETE_FORM_CONFIRMATION',
                                        'parent' => 'PARENT_FORMS_DELETE_FORM',
                                        'text' => 'Are you sure you want to delete this form?',
                                        'de' => 'Möchten Sie dieses Formular wirklich löschen?', // !
                                        'es' => '¿Seguro que quieres borrar este formulario?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer ce formulaire?')); //!
                array_push($text, array('key' => 'FORMS_DELETE_FORM_SUBMIT',
                                        'parent' => 'PARENT_FORMS_DELETE_FORM',
                                        'text' => 'Delete form',
                                        'de' => 'Formular löschen', // !
                                        'es' => 'Suprima formulario', // !
                                        'fr' => 'Supprimez formulaire')); //!
                array_push($text, array('key' => 'FORMS_DELETE_FORM_DELETING',
                                        'parent' => 'PARENT_FORMS_DELETE_FORM',
                                        'text' => 'Deleting form ...',
                                        'de' => 'Formular wird gelöscht ...', // !
                                        'es' => 'Supresión de formulario...', // !
                                        'fr' => 'Suppression de formulaire ...')); //!
                array_push($text, array('key' => 'FORMS_DELETE_FORM_SUCCESS',
                                        'parent' => 'PARENT_FORMS_DELETE_FORM',
                                        'text' => 'You have successfully deleted the form.',
                                        'de' => 'Sie haben das Formular erfolgreich gelöscht.', // !
                                        'es' => 'Ha eliminado con éxito el formulario.', // !
                                        'fr' => 'Vous avez réussi à supprimer le formulaire.')); //!
                
                return $text;
            }
            
            /*
             * Forms - Form fields text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsFormFields($text){
                array_push($text, array('key' => 'PARENT_FORMS_FORM_FIELDS',
                                        'parent' => '',
                                        'text' => 'Forms - Form fields'));
                
                array_push($text, array('key' => 'FORMS_FORM_FIELDS',
                                        'parent' => 'PARENT_FORMS_FORM_FIELDS',
                                        'text' => 'Form fields',
                                        'de' => 'Formularfelder', // !
                                        'es' => 'Campos de formulario', // !
                                        'fr' => 'Champs de formulaire')); //!
                
                return $text;
            }
            
            /*
             * Forms - Form field text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsFormField($text){
                array_push($text, array('key' => 'PARENT_FORMS_FORM_FIELD',
                                        'parent' => '',
                                        'text' => 'Forms - Form field'));
                
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SHOW_SETTINGS',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Show settings',
                                        'de' => 'Einstellungen anzeigen', // !
                                        'es' => 'Muestre los ajustes', // !
                                        'fr' => 'Montrez les paramètres')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_HIDE_SETTINGS',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Hide settings',
                                        'de' => 'Einstellungen ausblenden', // !
                                        'es' => 'Oculte los ajustes', // !
                                        'fr' => 'Cachez les fixations')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SORT',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Sort',
                                        'de' => 'Sortieren', // !
                                        'es' => 'Ordenar', // !
                                        'fr' => 'Sorte')); //!
                
                /*
                 * Field types.
                 */
                array_push($text, array('key' => 'FORMS_FORM_FIELD_TYPE_TEXT_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Text',
                                        'de' => 'Text', // !
                                        'es' => 'Text', // !
                                        'fr' => 'Text'));
                array_push($text, array('key' => 'FORMS_FORM_FIELD_TYPE_TEXTAREA_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Textarea',
                                        'de' => 'Textarea', // !
                                        'es' => 'Textarea', // !
                                        'fr' => 'Textarea')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_TYPE_CHECKBOX_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Checkbox',
                                        'de' => 'Checkbox', // !
                                        'es' => 'Checkbox', // !
                                        'fr' => 'Checkbox')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_TYPE_CHECKBOX_CHECKED_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Checked',
                                        'de' => 'Überprüft',
                                        'es' => 'Marcada', // !
                                        'fr' => 'Coché',
                                        'nl' => 'Gecontroleerd',
                                        'pl' => 'Wybrane'));
                array_push($text, array('key' => 'FORMS_FORM_FIELD_TYPE_CHECKBOX_UNCHECKED_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Unchecked',
                                        'de' => 'Ungeprüft',
                                        'es' => 'Non marcada', // !
                                        'fr' => 'Non coché',
                                        'nl' => 'Ongehinderd',
                                        'pl' => 'Niewybrane'));
                array_push($text, array('key' => 'FORMS_FORM_FIELD_TYPE_SELECT_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Drop down',
                                        'de' => 'Dropdown', // !
                                        'es' => 'Dropdown', // !
                                        'fr' => 'Dropdown')); //!
                
                /*
                 * Settings labels.
                 */
                array_push($text, array('key' => 'FORMS_FORM_FIELD_LABEL_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Label',
                                        'de' => 'Etikett', // !
                                        'es' => 'Etiqueta', // !
                                        'fr' => 'Étiquette')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_ALLOWED_CHARACTERS_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Allowed Characters',
                                        'de' => 'Zulässigen Zeichen', // !
                                        'es' => 'Carácteres permitidos', // !
                                        'fr' => 'Caractères autorisés')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SIZE_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Size',
                                        'de' => 'Größe', // !
                                        'es' => 'Dimensión', // !
                                        'fr' => 'Dimension')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_EMAIL_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Is email',
                                        'de' => 'Ist E-Mail', // !
                                        'es' => 'Es correo electrónico', // !
                                        'fr' => 'Est email')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_PHONE_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Is phone',
                                        'de' => 'Ist Telefon', // !
                                        'es' => 'Es teléfono', // !
                                        'fr' => 'C<<single-quote>>est téléphoné')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_DEFAULT_COUNTRY_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Default country',
                                        'de' => 'Standard Land', // !
                                        'es' => 'País por defecto', // !
                                        'fr' => 'Pays par défaut')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_REQUIRED_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Required',
                                        'de' => 'Erforderlich', // !
                                        'es' => 'Necesario', // !
                                        'fr' => 'Requis')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_MULTIPLE_SELECT_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Multiple select',
                                        'de' => 'Mehrfachauswahl', // !
                                        'es' => 'Múltiple escogido', // !
                                        'fr' => 'Sélection multiple')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_INFO_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Add field to day/hour info',
                                        'de' => 'Feld zu Tag-/Stunden info hinzufügen', // !
                                        'es' => 'Añadir campo a información de día/hora', // !
                                        'fr' => 'Ajouter le champ à l<<single-quote>>information de jour/heure')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_BODY_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Add field to day/hour body',
                                        'de' => 'Feld zum Tag/Stunden körper hinzufügen', // !
                                        'es' => 'Añadir campo al cuerpo día/hora', // !
                                        'fr' => 'Ajouter le champ au corps jour/heure')); //!
                
                return $text;
            }
            
            /*
             * Forms - Add form field text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsFormAddField($text){
                array_push($text, array('key' => 'PARENT_FORMS_FORM_ADD_FIELD',
                                        'parent' => '',
                                        'text' => 'Forms - Add form field'));
                
                array_push($text, array('key' => 'FORMS_FORM_ADD_FIELD_TEXT_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_ADD_FIELD',
                                        'text' => 'New text field',
                                        'de' => 'Neues textfeld', // !
                                        'es' => 'Nuevo campo de texto', // !
                                        'fr' => 'Nouveau champ texte')); //!
                array_push($text, array('key' => 'FORMS_FORM_ADD_FIELD_TEXTAREA_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_ADD_FIELD',
                                        'text' => 'New textarea field',
                                        'de' => 'Neues textarea-Feld', // !
                                        'es' => 'Nuevo campo de textarea ', // !
                                        'fr' => 'Nouveau champ texte')); //!
                array_push($text, array('key' => 'FORMS_FORM_ADD_FIELD_CHECKBOX_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_ADD_FIELD',
                                        'text' => 'New checkbox field',
                                        'de' => 'Neues checkbox-Feld', // !
                                        'es' => 'Nuevo campo de checkbox', // !
                                        'fr' => 'Nouveau checkbox champ')); //!
                array_push($text, array('key' => 'FORMS_FORM_ADD_FIELD_SELECT_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_ADD_FIELD',
                                        'text' => 'New drop down field',
                                        'de' => 'Neues dropdown-Feld', // !
                                        'es' => 'Nuevo campo de dropdown', // !
                                        'fr' => 'Nouveau dropdown champ')); //!
                
                array_push($text, array('key' => 'FORMS_FORM_ADD_FIELD_ADDING',
                                        'parent' => 'PARENT_FORMS_FORM_ADD_FIELD',
                                        'text' => 'Adding a new form field ...',
                                        'de' => 'Hinzufügen eines neuen Formularfeldes ...', // !
                                        'es' => 'Añadir un nuevo campo de formulario ...', // !
                                        'fr' => 'Ajout d<<single-quote>>un nouveau champ de formulaire ...')); //!
                array_push($text, array('key' => 'FORMS_FORM_ADD_FIELD_SUCCESS',
                                        'parent' => 'PARENT_FORMS_FORM_ADD_FIELD',
                                        'text' => 'You have successfully added a new form field.',
                                        'de' => 'Sie haben ein neues Formularfeld hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito un nuevo campo de formulario.', // !
                                        'fr' => 'Vous avez réussi à ajouter un nouveau champ de formulaire.')); //!
                
                return $text;
            }
            
            /*
             * Forms - Delete form field text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsFormDeleteField($text){
                array_push($text, array('key' => 'PARENT_FORMS_FORM_DELETE_FIELD',
                                        'parent' => '',
                                        'text' => 'Forms - Delete form field'));
                
                array_push($text, array('key' => 'FORMS_FORM_DELETE_FIELD_CONFIRMATION',
                                        'parent' => 'PARENT_FORMS_FORM_DELETE_FIELD',
                                        'text' => 'Are you sure you want to delete this form field?',
                                        'de' => 'Möchten Sie dieses Formularfeld wirklich löschen?', // !
                                        'es' => '¿Estás seguro de que quieres borrar este campo de formulario?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer ce champ de formulaire?')); //!
                array_push($text, array('key' => 'FORMS_FORM_DELETE_FIELD_SUBMIT',
                                        'parent' => 'PARENT_FORMS_FORM_DELETE_FIELD',
                                        'text' => 'Delete',
                                        'de' => 'Löschen', // !
                                        'es' => 'Borrar', // !
                                        'fr' => 'Supprimer')); //!
                array_push($text, array('key' => 'FORMS_FORM_DELETE_FIELD_DELETING',
                                        'parent' => 'PARENT_FORMS_FORM_DELETE_FIELD',
                                        'text' => 'Deleting form field ...',
                                        'de' => 'Formularfeld wird gelöscht ...', // !
                                        'es' => 'Supresión de campo de formulario...', // !
                                        'fr' => 'Suppression de champ de formulaire...')); //!
                array_push($text, array('key' => 'FORMS_FORM_DELETE_FIELD_SUCCESS',
                                        'parent' => 'PARENT_FORMS_FORM_DELETE_FIELD',
                                        'text' => 'You have successfully deleted the form field.',
                                        'de' => 'Sie haben das Formularfeld erfolgreich gelöscht.', // !
                                        'es' => 'Ha eliminado con éxito el campo de formulario.', // !
                                        'fr' => 'Vous avez réussi à supprimer le champ du formulaire.')); //!
                
                return $text;
            }
            
            /*
             * Forms - Form field select options text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsFormFieldSelectOptions($text){
                array_push($text, array('key' => 'PARENT_FORMS_FORM_FIELD_SELECT_OPTIONS',
                                        'parent' => '',
                                        'text' => 'Forms - Form field - Select options'));
                
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SELECT_OPTIONS_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD_SELECT_OPTIONS',
                                        'text' => 'Options',
                                        'de' => 'Optionen', // !
                                        'es' => 'Opciones', // !
                                        'fr' => 'Options')); //!
                
                return $text;
            }
            
            /*
             * Forms - Form field select option text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsFormFieldSelectOption($text){
                array_push($text, array('key' => 'PARENT_FORMS_FORM_FIELD_SELECT_OPTION',
                                        'parent' => '',
                                        'text' => 'Forms - Form field - Select option'));
                
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SELECT_OPTION_SORT',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD_SELECT_OPTION',
                                        'text' => 'Sort',
                                        'de' => 'Sortieren', // !
                                        'es' => 'Ordenar', // !
                                        'fr' => 'Sorte')); //!
                
                return $text;
            }
            
            /*
             * Forms - Add form field select option text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsFormFieldSelectAddOption($text){
                array_push($text, array('key' => 'PARENT_FORMS_FORM_FIELD_SELECT_ADD_OPTION',
                                        'parent' => '',
                                        'text' => 'Forms - Form field - Add select option'));
                
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SELECT_ADD_OPTION_LABEL',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD_SELECT_ADD_OPTION',
                                        'text' => 'New option',
                                        'de' => 'Neue Option', // !
                                        'es' => 'Nueva opción', // !
                                        'fr' => 'Nouvelle option')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SELECT_ADD_OPTION_SUBMIT',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD_SELECT_ADD_OPTION',
                                        'text' => 'Add select option',
                                        'de' => 'Option hinzufügen', // !
                                        'es' => 'Añadir opción para selección', // !
                                        'fr' => 'Ajouter une option de sélection')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SELECT_ADD_OPTION_ADDING',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD_SELECT_ADD_OPTION',
                                        'text' => 'Adding a new select option ...',
                                        'de' => 'Hinzufügen einer neuen Auswahloption ...', // !
                                        'es' => 'Añadir nuevo opción para selección', // !
                                        'fr' => 'Ajout d<<single-quote>>une nouvelle option de sélection ...')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SELECT_ADD_OPTION_SUCCESS',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD_SELECT_ADD_OPTION',
                                        'text' => 'You have successfully added a new select option.',
                                        'de' => 'Sie haben erfolgreich eine neue Auswahloption hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito un nuevo nuevo opción para selección', // !
                                        'fr' => 'Vous avez réussi à ajouter une nouvelle option de sélection.')); //!
                
                return $text;
            }
            
            /*
             * Forms - Delete form field select option text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsFormFieldSelectDeleteOption($text){
                array_push($text, array('key' => 'PARENT_FORMS_FORM_FIELD_SELECT_DELETE_OPTION',
                                        'parent' => '',
                                        'text' => 'Forms - Form field - Delete select option'));
                
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SELECT_DELETE_OPTION_CONFIRMATION',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD_SELECT_DELETE_OPTION',
                                        'text' => 'Are you sure you want to delete this select option?',
                                        'de' => 'Möchten Sie diese ausgewählte Option wirklich löschen?', // !
                                        'es' => '¿Estás seguro de que quieres borrar este opción para selección?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer cette option de sélection?')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SELECT_DELETE_OPTION_SUBMIT',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD_SELECT_DELETE_OPTION',
                                        'text' => 'Delete',
                                        'de' => 'Löschen', // !
                                        'es' => 'Borrar', // !
                                        'fr' => 'Supprimer')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SELECT_DELETE_OPTION_DELETING',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD_SELECT_DELETE_OPTION',
                                        'text' => 'Deleting select option ...',
                                        'de' => 'Option wird gelöscht ...', // !
                                        'es' => 'Supresión de opción para selección...', // !
                                        'fr' => 'Suppression d<<single-quote>>option de sélection ...')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SELECT_DELETE_OPTION_SUCCESS',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD_SELECT_DELETE_OPTION',
                                        'text' => 'You have successfully deleted the select option.',
                                        'de' => 'Sie haben die ausgewählte Option erfolgreich gelöscht.', // !
                                        'es' => 'Ha eliminado con éxito el opción para selección.', // !
                                        'fr' => 'Vous avez réussi à supprimer l<<single-quote>>option select.')); //!
                
                return $text;
            }
            
            /*
             * Forms - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsHelp($text){
                array_push($text, array('key' => 'PARENT_FORMS_HELP',
                                        'parent' => '',
                                        'text' => 'Forms - Help'));
                
                array_push($text, array('key' => 'FORMS_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Click on a form item to open the editing area.',
                                        'de' => 'Klicken Sie auf ein Formularelement, um den Bearbeitungsbereich zu öffnen.', // !
                                        'es' => 'Haga clic en un elemento del formulario para abrir el área de edición.', // !
                                        'fr' => 'Cliquez sur un élément du formulaire pour ouvrir la zone d<<single-quote>>édition.')); //!
                array_push($text, array('key' => 'FORMS_ADD_FORM_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Click on the "plus" icon to add a form.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um ein Formular hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "plus" para añadir un formulario.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter un formulaire.')); //!
                
                /*
                 * Form help.
                 */
                array_push($text, array('key' => 'FORMS_FORM_NAME_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Change form name.',
                                        'de' => 'Formularname ändern.', // !
                                        'es' => 'Cambiar el nombre de formulario', // !
                                        'fr' => 'Changer le nom du formulaire.')); //!
                array_push($text, array('key' => 'FORMS_FORM_LANGUAGE_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Change to the language you want to edit the form.',
                                        'de' => 'Wechseln Sie in die Sprache, in der Sie das Formular bearbeiten möchten.', // !
                                        'es' => 'Cambie al idioma que desea editar el formulario.', // !
                                        'fr' => 'Modifiez la langue dans laquelle vous souhaitez modifier le formulaire.')); //!
                array_push($text, array('key' => 'FORMS_FORM_ADD_FIELD_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Click on the bellow "plus" icon to add a form field.',
                                        'de' => 'Klicken Sie auf das untenstehende "Plus"-Symbol, um ein Formularfeld hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "plus" para añadir un campo de formulario.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter un champ de formulaire.')); //!
                array_push($text, array('key' => 'FORMS_FORM_EDIT_FIELD_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Click the field "expand" icon to display/hide the settings.',
                                        'de' => 'Klicken Sie auf das Symbol "Erweitern", um die Einstellungen ein-/auszublenden.', // !
                                        'es' => 'Haga clic en el icono "expandir" para mostrar/ocultar la configuración.', // !
                                        'fr' => 'Cliquez sur le champ "Agrandir" pour afficher/masquer les paramètres.')); //!
                array_push($text, array('key' => 'FORMS_FORM_DELETE_FIELD_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Click the field "trash" icon to delete it.',
                                        'de' => 'Klicken Sie auf das Symbol "Papierkorb", um es zu löschen.', // !
                                        'es' => 'Haga clic en el campo "basura" icono para eliminarlo.', // !
                                        'fr' => 'Cliquez sur le champ "corbeille" icône pour le supprimer.')); //!
                array_push($text, array('key' => 'FORMS_FORM_SORT_FIELD_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Drag the field "arrows" icon to sort it.',
                                        'de' => 'Ziehen Sie das Symbol "Pfeile", um es zu sortieren.', // !
                                        'es' => 'Arrastre el icono "flechas" de campo para ordenarlo.', // !
                                        'fr' => 'Faites glisser le champ "flèches" icône pour le trier.')); //!
                /*
                 * Form field help.
                 */
                array_push($text, array('key' => 'FORMS_FORM_FIELD_LABEL_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Enter field label.',
                                        'de' => 'Feld etikett eingeben.', // !
                                        'es' => 'Entre en la etiqueta de campo.', // !
                                        'fr' => 'Entrez l<<single-quote>>étiquette du champ.')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_ALLOWED_CHARACTERS_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Enter the characters allowed in this field. Leave it blank if all characters are allowed.',
                                        'de' => 'Geben Sie die in diesem Feld zulässigen Zeichen ein. Lassen Sie das Feld leer, wenn alle Zeichen zulässig sind.', // !
                                        'es' => 'Introduzca los caracteres permitidos en este campo. Déjelo en blanco si todos los caracteres están permitidos.', // !
                                        'fr' => 'Entrez les caractères autorisés dans ce champ. Laissez en blanc si tous les caractères sont autorisés.')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SIZE_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Enter the maximum number of characters allowed. Leave it blank for unlimited.',
                                        'de' => 'Geben Sie die maximal zulässige Anzahl von Zeichen ein. Lassen Sie es leer für unbegrenzt.', // !
                                        'es' => 'Introduzca el número máximo de caracteres permitidos. Déjelo en blanco para ilimitado.', // !
                                        'fr' => 'Entrez le nombre maximum de caractères permis. Laissez en blanc pour illimité.')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_EMAIL_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Enable it if you want this field to be verified if an email has been added or not.',
                                        'de' => 'Aktivieren Sie diese Option, wenn dieses Feld überprüft werden soll, ob eine E-Mail hinzugefügt wurde oder nicht.', // !
                                        'es' => 'Habilite si desea que este campo sea verificado si un email ha sido agregado o no.', // !
                                        'fr' => 'Activez-le si vous voulez que ce champ soit vérifié si un courriel a été ajouté ou non.')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_PHONE_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Enable it if you want this field to be verified if a phone number has been added or not.',
                                        'de' => 'Aktivieren Sie diese Option, wenn dieses Feld überprüft werden soll, ob eine Telefonnummer hinzugefügt wurde oder nicht.', // !
                                        'es' => 'Habilitar si desea que este campo se verifique si un número de teléfono se ha añadido o no.', // !
                                        'fr' => 'Activez-le si vous voulez que ce champ soit vérifié si un numéro de téléphone a été ajouté ou non.')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_DEFAULT_COUNTRY',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Select the default country for the phone number prefix.',
                                        'de' => 'Wählen Sie das Standardland für die Vorwahl der Telefonnummer aus.', // !
                                        'es' => 'Seleccione el país por defecto para el prefijo del número de teléfono.', // !
                                        'fr' => 'Sélectionnez le pays par défaut pour le préfixe du numéro de téléphone.')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_REQUIRED_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Enable it if you want the field to be mandatory.',
                                        'de' => 'Aktivieren Sie diese Option, wenn das Feld obligatorisch sein soll.', // !
                                        'es' => 'Activa si quieres que el campo sea obligatorio.', // !
                                        'fr' => 'Activez-le si vous voulez que le champ soit obligatoire.')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_MULTIPLE_SELECT_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Enable it if you want a multiple select drop down.',
                                        'de' => 'Aktivieren Sie diese Option, wenn Sie eine Dropdown-Liste mit mehreren Auswahlmöglichkeiten wünschen.', // !
                                        'es' => 'Activar si desea una opción de selección múltiple.', // !
                                        'fr' => 'Activez-le si vous voulez un menu déroulant à sélection multiple.')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_INFO_HELP',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Enable it if you want to display the field in a reservations list, in the info tooltip, in calendars days/hours.',
                                        'de' => 'Aktivieren Sie diese Option, wenn Sie das Feld in einer Reservierungsliste, in der Info-QuickInfo, in Kalendertagen/Stunden anzeigen möchten.', // !
                                        'es' => 'Habilitar si desea mostrar el campo en una lista de reservas, en la descripción de información, en calendarios días/horas.', // !
                                        'fr' => 'Activez-le si vous souhaitez afficher le champ dans une liste de réservations, dans l<<single-quote>>info-bulle, dans les calendriers jours/heures.')); //!
                array_push($text, array('key' => 'FORMS_FORM_FIELD_ADD_TO_DAY_HOUR_BODY_HELP',
                                        'parent' => 'PARENT_FORMS_FORM_FIELD',
                                        'text' => 'Enable it if you want to display the field in a reservations list, in the days/hours body (under availability), in calendars.',
                                        'de' => 'Aktivieren Sie diese Option, wenn Sie das Feld in einer Reservierungsliste, im Text für Tage/Stunden (unter Verfügbarkeit), in Kalendern anzeigen möchten.',
                                        'es' => 'Habilitar si desea mostrar el campo en una lista de reservas, en el cuerpo días/horas (bajo disponibilidad), en calendarios.', // !
                                        'fr' => 'Activez-le si vous souhaitez afficher le champ dans une liste de réservations, dans les jours/heures boby (sous disponibilité), dans les calendriers.')); //!
                
                array_push($text, array('key' => 'FORMS_FORM_FIELD_SELECT_OPTIONS_HELP',
                                        'parent' => 'PARENT_FORMS_HELP',
                                        'text' => 'Click the "plus" icon to add another option and enter the name. Click on the "delete" icon to remove the option.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um eine weitere Option hinzuzufügen und den Namen einzugeben. Klicken Sie auf das Symbol "Löschen", um die Option zu entfernen.', // !
                                        'es' => 'Haga clic en el icono "plus" para añadir otra opción e introducir el nombre. Haga clic en el icono "delete" para eliminar la opción.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter une autre option et entrez le nom. Cliquez sur l<<single-quote>>icône "supprimer" pour supprimer l<<single-quote>>option.')); //!
                
                return $text;
            }
            
            /*
             * Forms front end text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function formsFrontEnd($text){
                array_push($text, array('key' => 'PARENT_FORMS_FRONT_END',
                                        'parent' => '',
                                        'text' => 'Forms - Front end'));
                
                array_push($text, array('key' => 'FORMS_FRONT_END_TITLE',
                                        'parent' => 'PARENT_FORMS_FRONT_END',
                                        'text' => 'Contact information',
                                        'de' => 'Kontaktinformationen',
                                        'es' => 'Información de contacto', // !
                                        'fr' => 'Informations de contact',
                                        'nl' => 'Contact informatie',
                                        'pl' => 'Informacje kontaktowe',
                                        'location' => 'all'));
                array_push($text, array('key' => 'FORMS_FRONT_END_REQUIRED',
                                        'parent' => 'PARENT_FORMS_FRONT_END',
                                        'text' => 'is required.',
                                        'de' => 'erforderlich.',
                                        'es' => 'es necesario', // !
                                        'fr' => 'est requis.',
                                        'nl' => 'is verplicht.',
                                        'pl' => 'wymagane.',
                                        'location' => 'all'));  
                array_push($text, array('key' => 'FORMS_FRONT_END_INVALID_EMAIL',
                                        'parent' => 'PARENT_FORMS_FRONT_END',
                                        'text' => 'is invalid. Please enter a valid email.',
                                        'de' => 'ist ungültig. Bitte geben Sie eine gültige emailadresse ein.',
                                        'es' => 'no es válido. Introduzca un correo electrónico válido.', // !
                                        'fr' => 'est invalide. Veuillez entrer une adresse e-mail valide.',
                                        'nl' => 'is niet juist. Vul a.u.b. een geldig mail adres in.',
                                        'pl' => 'proszę wpisać poprawny adres e-mail.',
                                        'location' => 'all'));
                
                return $text;
            }
        }
    }