<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : includes/translation/class-translation-text-dashboard.php
* File Version            : 1.1.4
* Created / Last Modified : 19 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Dashboard translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextDashboard')){
        class DOPBSPTranslationTextDashboard{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize dashboard text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'dashboard'));
            }

            /*
             * Dashboard text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function dashboard($text){
                array_push($text, array('key' => 'PARENT_DASHBOARD',
                                        'parent' => '',
                                        'text' => 'Dashboard'));
                
                array_push($text, array('key' => 'DASHBOARD_TITLE',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Dashboard',
                                        'de' => 'Dashboard', // !
                                        'es' => 'Panel de control', // !
                                        'fr' => 'Tableau de bord'));//!
                array_push($text, array('key' => 'DASHBOARD_SUBTITLE',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Welcome to Pinpoint Booking System!',
                                        'de' => 'Willkommen bei Pinpoint Buchunssystem!', // !
                                        'es' => 'Bienvenido a Sistema de Reservas Pinpoint', // !
                                        'fr' => 'Bienvenue sur le Pinpoint Booking System'));
                array_push($text, array('key' => 'DASHBOARD_TEXT',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'This plugin will help you to easily create a booking/reservation system on your WordPress website or blog. This is intended to book, anything, anywhere, anytime ... so if you have any suggestions please tell us.',
                                        'de' => 'Dieses Plugin hilft Ihnen, ein Buchungs-/Reservierungssystem auf Ihrer WordPress Website oder Ihrem Blog zu erstellen. Dies ist beabsichtigt, zu buchen, alles, überall, jederzeit ... so, wenn Sie irgendwelche Vorschläge haben, teilen Sie uns bitte mit.', // !
                                        'es' => 'Este plugin le ayudará a crear fácilmente un sistema de reservas en su sitio web de WordPress o blog. Esto es para reservar, lo que sea, en cualquier lugar, en cualquier momento ... así que si tienes alguna sugerencia por favor dinos.', // !
                                        'fr' => 'Ce plugin vous aidera à créer facilement un système de réservation/réservation sur votre site Wordpress ou votre blog. Ceci est destiné à réserver, n<<single-quote>>importe quoi, n<<single-quote>>importe où, n<<single-quote>>importe quand ... donc si vous avez des suggestions s<<single-quote>>il vous plaît nous dire.'));//!
                /*
                 * Get started
                 */
                array_push($text, array('key' => 'DASHBOARD_GET_STARTED',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Get started',
                                        'de' => 'Anfangen', // !
                                        'es' => 'Empezar', // !
                                        'fr' => 'Commencer'));//!
                array_push($text, array('key' => 'DASHBOARD_GET_STARTED_CALENDARS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add a new calendar',
                                        'de' => 'Fügen Sie einen neuen Kalender hinzu', // !
                                        'es' => 'Añadir un nuevo calendario', // !
                                        'fr' => 'Ajouter un nouveau calendrier'));//!
                array_push($text, array('key' => 'DASHBOARD_GET_STARTED_CALENDARS_VIEW',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'View calendars',
                                        'de' => 'Kalender anzeigen', // !
                                        'es' => 'Calendarios de vista', // !
                                        'fr' => 'Voyez les calendriers'));//!
                array_push($text, array('key' => 'DASHBOARD_GET_STARTED_EVENTS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add a new event',
                                        'de' => 'Fügen Sie ein neues Ereignis hinzu', // !
                                        'es' => 'Añadir un nuevo evento', // !
                                        'fr' => 'Ajouter un nouvel événement'));//!
                array_push($text, array('key' => 'DASHBOARD_GET_STARTED_STAFF',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add a staff member',
                                        'de' => 'Fügen Sie einen Mitarbeiter hinzu', // !
                                        'es' => 'Agregar un miembro del personal', // !
                                        'fr' => 'Ajouter un membre du personnel'));//!
                array_push($text, array('key' => 'DASHBOARD_GET_STARTED_LOCATIONS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add a new location',
                                        'de' => 'Fügen Sie einen neuen Standort hinzu', // !
                                        'es' => 'Añadir una nueva ubicación', // !
                                        'fr' => 'Ajouter un nouvel emplacement'));//!
                array_push($text, array('key' => 'DASHBOARD_GET_STARTED_RESERVATIONS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'View reservations',
                                        'de' => 'Reservierungen anzeigen', // !
                                        'es' => 'Reservas de vista', // !
                                        'fr' => 'Voyez les réservations'));//!
                array_push($text, array('key' => 'DASHBOARD_GET_STARTED_REVIEWS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'View reviews',
                                        'de' => 'Bewertungen anzeigen', // !
                                        'es' => 'Revisiones de vista', // !
                                        'fr' => 'Voyez les examens'));//!
                /*
                 * More actions
                 */
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'More actions',
                                        'de' => 'Weitere Aktionen', // !
                                        'es' => 'Más acciones', // !
                                        'fr' => 'Actions supplémentaires'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_ADDONS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Get add-ons!',
                                        'de' => 'Add-ons herunterladen!', // !
                                        'es' => '¡Consiga accesorios!', // !
                                        'fr' => 'Obtenez les add-ons!'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_COUPONS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add coupons',
                                        'de' => 'Coupons hinzufügen', // !
                                        'es' => 'Más acciones', // !
                                        'fr' => 'Ajoutez coupons'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_DISCOUNTS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add discounts',
                                        'de' => 'Rabatte hinzufügen', // !
                                        'es' => 'Añada descuentos', // !
                                        'fr' => 'Ajoutez des remises'));//
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_EMAILS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add email templates',
                                        'de' => 'Fügen Sie E-Mail-Vorlagen hinzu', // !
                                        'es' => 'Añada plantillas de correo electrónico', // !
                                        'fr' => 'Ajoutez des modèles de courrier électronique'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_EXTRAS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add extras',
                                        'de' => 'Extras hinzufügen', // !
                                        'es' => 'Añada extras', // !
                                        'fr' => 'Add suppléments'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_FEES',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add taxes & fees',
                                        'de' => 'Steuern und Gebühren hinzufügen', // !
                                        'es' => 'Añadir impuestos y tasas', // !
                                        'fr' => 'Ajouter taxes et frais'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_FORMS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add forms',
                                        'de' => 'Formulare hinzufügen', // !
                                        'es' => 'Añada formulario', // !
                                        'fr' => 'Ajoutez formulaires'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_RULES',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add rules',
                                        'de' => 'Regeln hinzufügen', // !
                                        'es' => 'Añadir reglas', // !
                                        'fr' => 'Ajoutez des règles'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_SEARCH',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add search',
                                        'de' => 'Suche hinzufügen', // !
                                        'es' => 'Añada búsqueda', // !
                                        'fr' => 'Ajoutez la recherche'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_SETTINGS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Change settings',
                                        'de' => 'Einstellungen ändern', // !
                                        'es' => 'Cambiar los ajustes', // !
                                        'fr' => 'Modifier les paramètres'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_TEMPLATES',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Add templates',
                                        'de' => 'Fügen Sie Vorlagen hinzu', // !
                                        'es' => 'Añada plantillas', // !
                                        'fr' => 'Ajoutez des modèles'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_THEMES',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Get themes!',
                                        'de' => 'Hol dir Theme!', // !
                                        'es' => '¡Consiga temas!', // !
                                        'fr' => 'Obtenez des thèmes!'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_TOOLS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Tools',
                                        'de' => 'Werkzeuge', // !
                                        'es' => 'Herramientas', // !
                                        'fr' => 'Outils'));//!
                array_push($text, array('key' => 'DASHBOARD_MORE_ACTIONS_TRANSLATION',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Change translation',
                                        'de' => 'Übersetzung ändern', // !
                                        'es' => 'Cambiar traducción', // !
                                        'fr' => 'Changez la traduction'));//!
                /*
                 * API
                 */
                array_push($text, array('key' => 'DASHBOARD_API_TITLE',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'API key',
                                        'de' => 'API-Schlüssel', // !
                                        'es' => 'Clave de API', // !
                                        'fr' => 'Clé d<<single-quote>>API'));//!
                array_push($text, array('key' => 'DASHBOARD_API_RESET',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Reset API key',
                                        'de' => 'API-Schlüssel zurücksetzen', // !
                                        'es' => 'Reiniciar Clave de API', // !
                                        'fr' => 'Réinitialiser la clé API'));//!
                array_push($text, array('key' => 'DASHBOARD_API_RESET_SUCCESS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'API key was reset successfully!',
                                        'de' => 'API-Schlüssel wurde erfolgreich zurückgesetzt!', // !
                                        'es' => 'La clave API se reinició con éxito', // !
                                        'fr' => 'La clé API a été réinitialisée avec succès!')); // !
                array_push($text, array('key' => 'DASHBOARD_API_HELP',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'This is the key you need to use the API to access data from Pinpoint booking system. Each user has their own unique key, which can be reset using the adjacent button.',
                                        'de' => 'Dies ist der Schlüssel, den Sie benötigen, um die API für den Zugriff auf Daten aus dem Pinpoint-Buchungssystem zu verwenden. Jeder Benutzer verfügt über eine eigene, eindeutige Taste, die über die nebenstehende Schaltfläche zurückgesetzt werden kann.', // !
                                        'es' => 'Esta es la clave que necesita para utilizar la API para acceder a los datos desde un sistema de reservas puntual. Cada usuario tiene su propia llave única, que se puede restablecer usando el botón adyacente.', // !
                                        'fr' => 'C<<single-quote>>est la clé dont vous avez besoin pour utiliser l<<single-quote>>API pour accéder aux données du système de réservation Pinpoint. Chaque utilisateur a sa propre clé unique, qui peut être réinitialisé en utilisant le bouton adjacent.'));//!
                /*
                 * Server
                 */
                array_push($text, array('key' => 'DASHBOARD_SERVER_TITLE',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Server environment',
                                        'de' => 'Serverumgebung', // !
                                        'es' => 'Entorno de servidor', // !
                                        'fr' => 'Environnement de serveur'));//!
                
                array_push($text, array('key' => 'DASHBOARD_SERVER_REQUIRED',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Required',
                                        'de' => 'Erforderlich', // !
                                        'es' => 'Necesario', // !
                                        'fr' => 'Nécessaire'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_AVAILABLE',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Available',
                                        'de' => 'Verfügbar', // !
                                        'es' => 'Disponible', // !
                                        'fr' => 'Disponible'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_STATUS',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Status',
                                        'de' => 'Status', // !
                                        'es' => 'Estado', // !
                                        'fr' => 'Statut'));//
                
                array_push($text, array('key' => 'DASHBOARD_SERVER_NO',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'No',
                                        'de' => 'Nein', // !
                                        'es' => 'No', // !
                                        'fr' => 'Non'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_YES',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Yes',
                                        'de' => 'Ja', // !
                                        'es' => 'Sí', // !
                                        'fr' => 'Oui'));
                
                array_push($text, array('key' => 'DASHBOARD_SERVER_VERSION',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Pinpoint Booking System version',
                                        'de' => 'Version des Pinpoint Buchungssystems', // !
                                        'es' => 'Versión de Sistema de Reservas Pinpoint', // !
                                        'fr' => 'Version du Pinpoint Booking System'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_WORDPRESS_VERSION',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'WordPress version',
                                        'de' => 'Version des WordPress', // !
                                        'es' => 'Versión de WordPress', // !
                                        'fr' => 'Version de WordPress'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_WORDPRESS_MULTISITE',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'WordPress multisite',
                                        'de' => 'WordPress Multisite', // !
                                        'es' => 'WordPress multisitio', // !
                                        'fr' => 'Multisite WordPress'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_WOOCOMMERCE_VERSION',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'WooCommerce version',
                                        'de' => 'Version des WooCommerce', // !
                                        'es' => 'Versión de WooCommerce', // !
                                        'fr' => 'Version WooCommerce'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_WOOCOMMERCE_ENABLE_CODE',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'code is enabled even if WooCommerce plugin is not detected',
                                        'de' => 'Code ist auch dann aktiviert, wenn WooCommerce Plugin nicht erkannt wird', // !
                                        'es' => 'Código está habilitado incluso si WooCommerce plugin no se detecta', // !
                                        'fr' => 'code est activé même si le plugin Woocommerce n<<single-quote>>est pas détecté'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_PHP_VERSION',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'PHP version',
                                        'de' => 'Version des PHP', // !
                                        'es' => 'Versión de PHP', // !
                                        'fr' => 'Version de PHP'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_MYSQL_VERSION',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'MySQL version',
                                        'de' => 'Version des MySQL', // !
                                        'es' => 'Versión de MySQL', // !
                                        'fr' => 'Version de MySQL'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_MEMORY_LIMIT',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Memory limit',
                                        'de' => 'Speicherlimit', // !
                                        'es' => 'Límite de memoria', // !
                                        'fr' => 'Limite de mémoire'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_MEMORY_LIMIT_WP',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'WordPress memory limit',
                                        'de' => 'WordPress Speicherlimit', // !
                                        'es' => 'Límite de memoria de WordPress', // !
                                        'fr' => 'Limite de mémoire WordPress'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_MEMORY_LIMIT_WP_MAX',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'WordPress maximum memory limit',
                                        'de' => 'WordPress maximale Speichergrenze', // !
                                        'es' => 'Límite máximo de memoria de WordPress', // !
                                        'fr' => 'Limite maximale de mémoire Wordpress'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_MEMORY_LIMIT_WOOCOMMERCE',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'WooCommerce memory limit',
                                        'de' => 'WooCommerce Speicherlimit', // !
                                        'es' => 'WooCommerce límite de memoria', // !
                                        'fr' => 'WooCommerce limite de mémoire'));//!
                array_push($text, array('key' => 'DASHBOARD_SERVER_CURL_VERSION',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'cURL version - necessary for TLS security protocol',
                                        'de' => 'cURL-Version - erforderlich für TLS-Sicherheitsprotokoll', // !
                                        'es' => 'versión cURL - necesaria para el protocolo de seguridad TLS', // !
                                        'fr' => 'cURL version - nécessaire pour le protocole de sécurité TLS'));//!
                
                return $text;
            }
        }
    }