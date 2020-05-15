<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-rules.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Rules translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextRules')){
        class DOPBSPTranslationTextRules{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize rules text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'rules'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'rulesRule'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'rulesAddRule'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'rulesDeleteRule'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'rulesHelp'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'rulesFrontEnd'));
            }
            
            /*
             * Rules text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rules($text){
                array_push($text, array('key' => 'PARENT_RULES',
                                        'parent' => '',
                                        'text' => 'Rules'));
                
                array_push($text, array('key' => 'RULES_TITLE',
                                        'parent' => 'PARENT_RULES',
                                        'text' => 'Rules',
                                        'de' => 'Regeln', // !
                                        'es' => 'Reglas', // !
                                        'fr' => 'Règles')); //!
                array_push($text, array('key' => 'RULES_DEFAULT_NAME',
                                        'parent' => 'PARENT_RULES',
                                        'text' => 'New rule',
                                        'de' => 'Neue Regel', // !
                                        'es' => 'Nueva regla', // !
                                        'fr' => 'Nouvelle règle')); //!
                array_push($text, array('key' => 'RULES_CREATED_BY',
                                        'parent' => 'PARENT_RULES',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von', // !
                                        'es' => 'Creada por', // !
                                        'fr' => 'Créé par')); //!
                array_push($text, array('key' => 'RULES_LOAD_SUCCESS',
                                        'parent' => 'PARENT_RULES',
                                        'text' => 'Rules list loaded.',
                                        'de' => 'Regelliste geladen.', // !
                                        'es' => 'La lista de reglas cargó.', // !
                                        'fr' => 'La liste de règles a chargé.')); //!
                array_push($text, array('key' => 'RULES_NO_RULES',
                                        'parent' => 'PARENT_RULES',
                                        'text' => 'No rules. Click the above "plus" icon to add a new one.',
                                        'de' => 'Keine Regeln. Klicken Sie auf das obige "Plus"-Symbol, um ein neues hinzuzufügen.', // !
                                        'es' => 'No hay reglas. Haga clic en el icono "plus" de arriba para agregar uno nuevo.', // !
                                        'fr' => 'Pas de règles. Cliquez sur l’icône "plus" ci-dessus pour en ajouter une nouvelle.')); //!
                
                return $text;
            }
            
            /*
             * Rules - Rule text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rulesRule($text){
                array_push($text, array('key' => 'PARENT_RULES_RULE',
                                        'parent' => '',
                                        'text' => 'Rules - Rule'));
                
                array_push($text, array('key' => 'RULES_RULE_NAME',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Name',
                                        'de' => 'Name', // !
                                        'es' => 'Nombre', // !
                                        'fr' => 'Nom')); //!
                
                array_push($text, array('key' => 'RULES_RULE_TIME_LAPSE_MIN',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Minimum time lapse',
                                        'de' => 'Minimaler Zeitraffer', // !
                                        'es' => 'Lapso de tiempo mínimo', // !
                                        'fr' => 'Laps de temps minimal')); //!
                array_push($text, array('key' => 'RULES_RULE_TIME_LAPSE_MAX',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Maximum time lapse',
                                        'de' => 'Maximaler Zeitraffer', // !
                                        'es' => 'Lapso de tiempo máximo', // !
                                        'fr' => 'Laps de temps maximal')); //!
                
                array_push($text, array('key' => 'RULES_RULE_LOADED',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Rule loaded.',
                                        'de' => 'Regel geladen.', // !
                                        'es' => 'La regla cargó.', // !
                                        'fr' => 'La règle a chargé.')); //!
                
                return $text;
            }
            
            /*
             * Rules - Add rule text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rulesAddRule($text){
                array_push($text, array('key' => 'PARENT_RULES_ADD_RULE',
                                        'parent' => '',
                                        'text' => 'Rules - Add rule'));
                
                array_push($text, array('key' => 'RULES_ADD_RULE_NAME',
                                        'parent' => 'PARENT_RULES_ADD_RULE',
                                        'text' => 'New rule',
                                        'de' => 'Neue Regel', // !
                                        'es' => 'Nueva regla', // !
                                        'fr' => 'Nouvelle règle')); //!
                array_push($text, array('key' => 'RULES_ADD_RULE_SUBMIT',
                                        'parent' => 'PARENT_RULES_ADD_RULE',
                                        'text' => 'Add rule',
                                        'de' => 'Regel hinzufügen', // !
                                        'es' => 'Añada regla', // !
                                        'fr' => 'Ajoutez règle')); //!
                array_push($text, array('key' => 'RULES_ADD_RULE_ADDING',
                                        'parent' => 'PARENT_RULES_ADD_RULE',
                                        'text' => 'Adding a new rule ...',
                                        'de' => 'Hinzufügen einer neuen Regel ...', // !
                                        'es' => 'Añadir una nueva regla ...', // !
                                        'fr' => 'Ajout d’une nouvelle règle...')); //!
                array_push($text, array('key' => 'RULES_ADD_RULE_SUCCESS',
                                        'parent' => 'PARENT_RULES_ADD_RULE',
                                        'text' => 'You have successfully added a new rule.',
                                        'de' => 'Sie haben erfolgreich eine neue Regel hinzugefügt.', // !
                                        'es' => 'Ha añadido con éxito una nueva regla.', // !
                                        'fr' => 'Vous avez réussi à ajouter une nouvelle règle.')); //!
                
                return $text;
            }
            
            /*
             * Rules - Delete rule text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rulesDeleteRule($text){
                array_push($text, array('key' => 'PARENT_RULES_DELETE_RULE',
                                        'parent' => '',
                                        'text' => 'Rules - Delete rule'));
                
                array_push($text, array('key' => 'RULES_DELETE_RULE_CONFIRMATION',
                                        'parent' => 'PARENT_RULES_DELETE_RULE',
                                        'text' => 'Are you sure you want to delete this rule?',
                                        'de' => 'Möchten Sie diese Regel wirklich löschen?', // !
                                        'es' => '¿Seguro que quieres borrar esta regla?', // !
                                        'fr' => 'Êtes-vous sûr de vouloir supprimer cette règle?')); //!
                array_push($text, array('key' => 'RULES_DELETE_RULE_SUBMIT',
                                        'parent' => 'PARENT_RULES_DELETE_RULE',
                                        'text' => 'Delete rule',
                                        'de' => 'Regel löschen', // !
                                        'es' => 'Suprimir la regla', // !
                                        'fr' => 'Supprimez la règle')); //!
                array_push($text, array('key' => 'RULES_DELETE_RULE_DELETING',
                                        'parent' => 'PARENT_RULES_DELETE_RULE',
                                        'text' => 'Deleting rule ...',
                                        'de' => 'Regel wird gelöscht...', // !
                                        'es' => 'Supresión de regla...', // !
                                        'fr' => 'Suppression de règle...')); //!
                array_push($text, array('key' => 'RULES_DELETE_RULE_SUCCESS',
                                        'parent' => 'PARENT_RULES_DELETE_RULE',
                                        'text' => 'You have successfully deleted the rule.',
                                        'de' => 'Sie haben die Regel erfolgreich gelöscht.', // !
                                        'es' => 'Has eliminado con éxito la regla.', // !
                                        'fr' => 'Vous avez réussi à supprimer la règle.')); //!
                
                return $text;
            }
            
            /*
             * Rules - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rulesHelp($text){
                array_push($text, array('key' => 'PARENT_RULES_HELP',
                                        'parent' => '',
                                        'text' => 'Rules - Help'));
                
                array_push($text, array('key' => 'RULES_HELP',
                                        'parent' => 'PARENT_RULES_HELP',
                                        'text' => 'Click on a rule item to open the editing area.',
                                        'de' => 'Klicken Sie auf ein Regelelement, um den Bearbeitungsbereich zu öffnen.', // !
                                        'es' => 'Haga clic en un elemento de regla para abrir el área de edición.', // !
                                        'fr' => 'Cliquez sur un élément de règle pour ouvrir la zone d’édition.')); //!
                array_push($text, array('key' => 'RULES_ADD_RULE_HELP',
                                        'parent' => 'PARENT_RULES_HELP',
                                        'text' => 'Click on the "plus" icon to add a rule.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um eine Regel hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "plus" para añadir una regla.', // !
                                        'fr' => 'Cliquez sur l’icône "plus" pour ajouter une règle.')); //!
                array_push($text, array('key' => 'RULES_RULE_NAME_HELP',
                                        'parent' => 'PARENT_RULES_HELP',
                                        'text' => 'Change rule name.',
                                        'de' => 'Regelname ändern.', // !
                                        'es' => 'Cambiar la nombre de régla.', // !
                                        'fr' => 'Nom de règlede changement.')); //!
                
                /*
                 * Rule help.
                 */
                array_push($text, array('key' => 'RULES_RULE_TIME_LAPSE_MIN_HELP',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Enter minimum booking time lapse. Default value is 1.',
                                        'de' => 'Geben Sie den Mindestzeitraum für die Buchung ein. Der Standardwert ist 1.', // !
                                        'es' => 'Introduzca el tiempo mínimo de reserva. El valor predeterminado es 1.', // !
                                        'fr' => 'Entrez le délai minimum de réservation. La valeur par défaut est 1.')); //!
                array_push($text, array('key' => 'RULES_RULE_TIME_LAPSE_MAX_HELP',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Enter maximum booking time lapse. Add 0 for unlimited period.',
                                        'de' => 'Geben Sie den maximalen Zeitraum für die Buchung ein. Fügen Sie 0 für unbegrenzte Zeit hinzu.', // !
                                        'es' => 'Introduzca el tiempo máximo de reserva. Añadir 0 para el período ilimitado.', // !
                                        'fr' => 'Entrez le délai maximum de réservation. Ajoutez 0 pour une période illimitée.')); //!
                
                return $text;
            }
            
            
            
            /*
             * Rules front end text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rulesFrontEnd($text){
                array_push($text, array('key' => 'PARENT_RULES_FRONT_END',
                                        'parent' => '',
                                        'text' => 'Rules - Front end'));
                
                array_push($text, array('key' => 'RULES_FRONT_END_MIN_TIME_LAPSE_DAYS_WARNING',
                                        'parent' => 'PARENT_RULES_FRONT_END',
                                        'text' => 'You need to book a minimum number of %d days.',
                                        'de' => 'Sie müssen zumindest %d tag buchen.',
                                        'es' => 'Necesitas reservar un número mínimo de %d días.', //!
                                        'fr' => 'Vous avez besoin de réserver un nombre minimum de %d jours.',
                                        'nl' => 'U dient een minimaal aantal %d dagen te reserveren.',
                                        'pl' => 'Oferta dotyczy minimalnej liczby %d dni.',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'RULES_FRONT_END_MAX_TIME_LAPSE_DAYS_WARNING',
                                        'parent' => 'PARENT_RULES_FRONT_END',
                                        'text' => 'You can book only a maximum number of %d days.',
                                        'de' => 'Sie können maximal %d tage buchen.',
                                        'es' => 'Usted puede reservar sólo un número máximo de %d días.', //!
                                        'fr' => 'Vous avez besoin de réserver un nombre maximum de %d jours.',
                                        'nl' => 'U kunt een maximum aantal %d dagen boeken.',
                                        'pl' => 'Można zarezerwować tylko max liczbę %d dni.',
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'RULES_FRONT_END_MIN_TIME_LAPSE_HOURS_WARNING',
                                        'parent' => 'PARENT_RULES_FRONT_END',
                                        'text' => 'You need to book a minimum number of %d hours.',
                                        'de' => 'Sie müssen mindestens %d Stunden buchen.', // !
                                        'es' => 'Necesitas reservar un mínimo de %d horas.', // !
                                        'fr' => 'Vous devez réserver un nombre minimum d’heures %d.', //!
                                        'location' => 'calendar'));
                array_push($text, array('key' => 'RULES_FRONT_END_MAX_TIME_LAPSE_HOURS_WARNING',
                                        'parent' => 'PARENT_RULES_FRONT_END',
                                        'text' => 'You can book only a maximum number of %d hours.',
                                        'de' => 'Sie können nur eine maximale Anzahl von %d Stunden buchen.', // !
                                        'es' => 'Usted puede reservar sólo un número máximo de %d horas.', // !
                                        'fr' => 'Vous ne pouvez réserver qu’un nombre maximal d’heures %d.', //!
                                        'location' => 'calendar'));
                
                return $text;
            }
        }
    }