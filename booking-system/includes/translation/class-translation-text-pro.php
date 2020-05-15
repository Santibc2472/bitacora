<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.9.2
* File                    : includes/translation/class-translation-text-pro.php
* File Version            : 1.0.1
* Created / Last Modified : 1 august 2019
* Author                  : PINPOINT.WORLD
* Copyright               : © 2019 Pinpoint World
* Website                 : https://pinpoint.world
* Description             : Pro features translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextPro')){
        class DOPBSPTranslationTextPro{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize addons text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'pro'));
            }

            /*
             * Pro features text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function pro($text){
                array_push($text, array('key' => 'PARENT_PRO',
                                        'parent' => '',
                                        'text' => 'Pro'));
                
                /*
                 * General
                 */
                
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Features',
                                        'de' => 'Eigenschaften',
                                        'es' => 'Características',
                                        'fr' => 'Fonctionnalités'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_MAIN_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Why choose PRO?',
                                        'de' => 'Warum PRO?',
                                        'es' => '¿Por qué escogen PRO?',
                                        'fr' => 'Pourquoi choisir PRO?'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DESCRIPTION',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The booking system comes with a huge set of amazing features. View the list, compare FREE and PRO versions, and decide which is best suited for your needs.',
                                        'de' => 'Das Buchungssystem verfügt über eine Vielzahl von erstaunlichen Funktionen. Sehen Sie sich die Liste an, vergleichen Sie die KOSTENLOSE und PRO-Versionen und entscheiden Sie, welche für Ihre Bedürfnisse am besten geeignet ist.',
                                        'es' => 'El sistema de reservas viene con un enorme conjunto de características increíbles. Vea la lista, compare las versiones FREE y PRO y decida cuál es la más adecuada para sus necesidades.',
                                        'fr' => 'Le système de réservation est livré avec un énorme ensemble de fonctionnalités étonnantes. Consultez la liste, comparez les versions GRATUITE et PRO, et choisissez celle qui convient le mieux à vos besoins.'));
                
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FREE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Free',
                                        'de' => 'Gratis',
                                        'es' => 'Gratis',
                                        'fr' => 'Gratuit'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DOWNLOAD',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Download',
                                        'de' => 'Download',
                                        'es' => 'Descargar',
                                        'fr' => 'Télécharger'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_STANDARD',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Standard',
                                        'de' => 'Standard',
                                        'es' => 'Estándar',
                                        'fr' => 'Standard'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_PRICING',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Pricing',
                                        'de' => 'Preis',
                                        'es' => 'Precio',
                                        'fr' => 'Prix'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FROM',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'from',
                                        'de' => 'Von',
                                        'es' => 'de',
                                        'fr' => 'de'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_GET',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Get',
                                        'de' => 'Erhalten',
                                        'es' => 'Obtener',
                                        'fr' => 'Obtenir'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_SHOW',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Show More',
                                        'de' => 'Mehr anzeigen',
                                        'es' => 'Ver más',
                                        'fr' => 'Voir plus'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_HIDE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Hide',
                                        'de' => 'Ausblenden',
                                        'es' => 'Esconder',
                                        'fr' => 'Cacher'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_BUY',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Buy now',
                                        'de' => 'Jetzt kaufen',
                                        'es' => 'Compra ahora',
                                        'fr' => 'Achetez maintenant'));
                
                /*
                 * Calendars
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Booking calendar',
                                        'de' => 'Buchungskalender',
                                        'es' => 'Calendario de reservas',
                                        'fr' => 'Calendrier de réservation'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'A booking calendar is displayed in the front-end, where clients can view availability and can make reservations & appointments.',
                                        'de' => 'Im Frontend wird ein Buchungskalender angezeigt, in dem die Kunden die Verfügbarkeit einsehen und Reservierungen und Termine vornehmen können.',
                                        'es' => 'Un calendario de reservas se muestra en la interfaz, donde los clientes pueden ver la disponibilidad y pueden hacer reservas y citas.',
                                        'fr' => 'Un calendrier des réservations est affiché dans la partie front-end (frontale), où les clients peuvent consulter les disponibilités, faire des réservations et prendre des rendez-vous.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'All administrators & users can create an unlimited number of booking calendars with PRO version.',
                                        'de' => 'Alle Administratoren und Benutzer können mit der PRO-Version eine unbegrenzte Anzahl von Buchungskalendern erstellen.',
                                        'es' => 'Todos los administradores y usuarios pueden crear un número ilimitado de calendarios de reserva con la versión PRO.',
                                        'fr' => 'Tous les administrateurs et utilisateurs peuvent créer un nombre illimité de calendriers de réservation avec la version PRO.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Booking calendars can be duplicated with all current data and settings.',
                                        'de' => 'Buchungskalender können mit allen aktuellen Daten und Einstellungen dupliziert werden.',
                                        'es' => 'Los calendarios de reserva se pueden duplicar con todos los datos y ajustes actuales.',
                                        'fr' => 'Les calendriers de réservation peuvent être dupliqués avec toutes les données et paramètres actuels.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Booking can be stopped x minutes/hours/days in advance.',
                                        'de' => 'Die Buchung kann x Minuten/Stunden/Tage im Voraus gestoppt werden.',
                                        'es' => 'La reservación puede ser detenida x minutos/horas/días por adelantado.',
                                        'fr' => 'La réservation peut être arrêtée x minutes/heures/jours à l<<single-quote>>avance.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT5',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Calendars will display the data depending on users time zones.',
                                        'de' => 'Kalender zeigen die Daten abhängig von den Zeitzonen der Benutzer an.',
                                        'es' => 'Los calendarios mostrarán los datos dependiendo de las zonas horarias de los usuarios.',
                                        'fr' => 'Les calendriers afficheront les données en fonction des fuseaux horaires des utilisateurs.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT6',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Clients can click on the calendar’s days and/or hours to select the booking period they want.',
                                        'de' => 'Kunden können auf die Tage und/oder Stunden des Kalenders klicken, um den gewünschten Buchungszeitraum auszuwählen.',
                                        'es' => 'Los clientes pueden hacer clic en los días y/u horas del calendario para seleccionar el período de reserva que deseen.',
                                        'fr' => 'Les clients peuvent cliquer sur les jours et/ou heures du calendrier pour sélectionner la période de réservation qu<<single-quote>>ils souhaitent.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT7',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Clients can select to display multiple or fewer months for better visualization. The number of months to be initially displayed can be set from calendar settings.',
                                        'de' => 'Kunden können wählen, ob sie mehrere oder weniger Monate zur besseren Visualisierung anzeigen möchten. Die Anzahl der Monate, die anfänglich angezeigt werden sollen, kann über die Kalendereinstellungen eingestellt werden.',
                                        'es' => 'Los clientes pueden seleccionar si desean mostrar varios meses o menos para una mejor visualización. El número de meses que se mostrarán inicialmente se puede establecer a partir de los ajustes del calendario.',
                                        'fr' => 'Les clients peuvent choisir d<<single-quote>>afficher plusieurs mois ou moins pour une meilleure visualisation. Le nombre de mois à afficher initialement peut être défini à partir des paramètres du calendrier.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT8',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Front end booking calendar is responsive and can be viewed on all browsers and devices.',
                                        'de' => 'Der Frontend-Buchungskalender ist reaktionsschnell und kann auf allen Browsern und Geräten angezeigt werden.',
                                        'es' => 'El calendario de reservas de la interfaz es adaptable y se puede ver en todos los navegadores y dispositivos.',
                                        'fr' => 'Le calendrier front end (frontal) des réservations est réactif et peut être consulté sur tous les navigateurs et appareils.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT9',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Only the calendar can be displayed so that your users can check only availability.',
                                        'de' => 'Es kann auch nur der Kalender angezeigt werden, sodass Ihre Benutzer nur die Verfügbarkeit überprüfen können.',
                                        'es' => 'Se puede visualizar únicamente el calendario para que los usuarios puedan comprobar sólo la disponibilidad.',
                                        'fr' => 'Seul le calendrier peut être affiché pour que vos utilisateurs puissent vérifier uniquement la disponibilité.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT10',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Price can be hidden in front end calendar.',
                                        'de' => 'Der Preis kann im Frontend-Kalender ausgeblendet werden.',
                                        'es' => 'Se puede ocultar el precio en el calendario frontal.',
                                        'fr' => 'Le prix peut être caché sur le calendrier front end (frontal).'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT11',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Support for Terms & Conditions.',
                                        'de' => 'Unterstützung für die Allgemeinen Geschäftsbedingungen.',
                                        'es' => 'Soporte para los Términos y Condiciones.',
                                        'fr' => 'Prise en charge des conditions générales.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT12',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The booking calendar is AJAX powered, so there is no need to refresh the page to make a reservation, update schedule ...',
                                        'de' => 'Der Buchungskalender ist AJAX-basiert, sodass es nicht notwendig ist, die Seite zu aktualisieren, um eine Reservierung vorzunehmen, den Zeitplan zu aktualisieren ...',
                                        'es' => 'El calendario de reservas es potenciado por AJAX, por lo que no hay necesidad de actualizar la página para hacer una reserva, actualizar la programación...',
                                        'fr' => 'Le calendrier de réservation est alimenté par AJAX, il n<<single-quote>>est donc pas nécessaire de rafraîchir la page pour faire une réservation, mettre à jour le calendrier...'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT13',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The booking calendar contains a sidebar where clients can search availability, they can select the number of rooms/items they want, can select extras & services, can use coupons/vouchers, can view reservation summary with discounts & taxes/fees and can enter their details in a customizable form.',
                                        'de' => 'Der Buchungskalender enthält eine Seitenleiste, in der die Kunden die Verfügbarkeit suchen können, die Anzahl der Zimmer/Positionen auswählen können, Extras und Dienstleistungen auswählen können, Coupons und Gutscheine verwenden können, die Reservierungsübersicht mit Rabatten und Steuern/Gebühren einsehen können und ihre Daten in einer anpassbaren Form eingeben können.',
                                        'es' => 'El calendario de reservas contiene una barra lateral donde los clientes pueden buscar disponibilidad, pueden seleccionar el número de habitaciones/artículos que desean, pueden seleccionar extras y servicios, pueden utilizar cupones/vales, pueden ver el resumen de reservas con descuentos e impuestos/tasas y pueden introducir sus detalles en un formulario personalizable.',
                                        'fr' => 'Le calendrier de réservation est doté d<<single-quote>>une barre latérale où les clients peuvent rechercher la disponibilité, sélectionner le nombre de chambres ou d<<single-quote>>articles qu<<single-quote>>ils désirent avoir, sélectionner les options et services, utiliser les coupons/bons, afficher le récapitulatif de réservation avec rabais et taxes ou frais et entrer leurs détails sous une forme personnalisée.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT14',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The calendar’s sidebar view is customizable.',
                                        'de' => 'Die Seitenleistenansicht des Kalenders ist anpassbar.',
                                        'es' => 'La vista de la barra lateral del calendario se puede personalizar.',
                                        'fr' => 'La vue latérale du calendrier est personnalisable.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT15',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The check in/out dates can be in American (MM DD, YYYY) or European (DD MM YYYY) format.',
                                        'de' => 'Die Ein- und Auscheckdaten können im amerikanischen (MM DD, YYYY) oder europäischen (DD MM YYYY) Format sein.',
                                        'es' => 'Las fechas de entrada y salida pueden ser en formato americano (MM DD, AAAA) o europeo (DD MM AAAA).',
                                        'fr' => 'Les dates d<<single-quote>>arrivée et de sortie peuvent être au format américain (MM JJJ, AAAA) ou européen (JJ MM AAAA).'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT16',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The back end booking calendar is similar to the front end version so that administrators can have a very familiar way to add information ... what they see the clients see.',
                                        'de' => 'Der Backend-Buchungskalender ähnelt der Frontend-Version, so dass Administratoren eine sehr vertraute Möglichkeit haben, Informationen hinzuzufügen ... was sie sehen, sehen die Kunden auch.',
                                        'es' => 'El calendario de reservas de fondo es similar a la versión de la interfaz para que los administradores puedan tener una forma muy familiar de añadir información... lo que ven los clientes.',
                                        'fr' => 'Le calendrier back end (en arrière-plan) des réservations est similaire à la version front end (frontale) afin que les administrateurs puissent avoir un moyen très familier d<<single-quote>>ajouter des informations... ce qu<<single-quote>>ils voient les clients voient.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CALENDARS_TEXT17',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can set the first day from which the calendar will start.',
                                        'de' => 'Sie können den ersten Tag einstellen, ab dem der Kalender gestartet wird.',
                                        'es' => 'Puede establecer el primer día a partir del cual comenzará el calendario.',
                                        'fr' => 'Vous pouvez définir le premier jour à partir duquel le calendrier commencera.'));
                
                /*
                 * Coupons
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_COUPONS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Coupons & vouchers',
                                        'de' => 'Coupons & Gutscheine',
                                        'es' => 'Cupones y vales',
                                        'fr' => 'Coupons et bons'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_COUPONS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Create coupon/voucher codes for your clients.',
                                        'de' => 'Erstellen Sie Coupon-/Gutscheincodes für Ihre Kunden.',
                                        'es' => 'Cree códigos de cupón/vales para sus clientes.',
                                        'fr' => 'Créez des codes coupons/bons pour vos clients.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_COUPONS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The value for coupons can be negative or positive, fixed or percent, once or by day/hour.',
                                        'de' => 'Der Wert für Coupons kann negativ oder positiv, fest oder prozentual, einmalig oder pro Tag/Stunde sein.',
                                        'es' => 'El valor de los cupones puede ser negativo o positivo, fijo o porcentual, una vez o por día/hora.',
                                        'fr' => 'La valeur des coupons peut être négative ou positive, fixe ou en pourcentage, une fois ou par jour/heure.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_COUPONS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can set date/time when the coupons can be used.',
                                        'de' => 'Sie können Datum/Uhrzeit einstellen, wann die Coupons verwendet werden können.',
                                        'es' => 'Puede configurar la fecha/hora en la que se pueden utilizar los cupones.',
                                        'fr' => 'Vous pouvez définir la date et l<<single-quote>>heure auxquelles les coupons peuvent être utilisés.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_COUPONS_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can create unlimited number of coupons, to use with one or multiple calendars or you can use multiple coupons in one calendar.',
                                        'de' => 'Sie können eine unbegrenzte Anzahl von Coupons erstellen, die Sie mit einem oder mehreren Kalendern verwenden können, oder Sie können mehrere Coupons in einem Kalender verwenden.',
                                        'es' => 'Puede crear un número ilimitado de cupones, para utilizar con uno o varios calendarios o puede utilizar varios cupones en un calendario.',
                                        'fr' => 'Vous pouvez créer un nombre illimité de coupons, à utiliser avec un ou plusieurs calendriers ou vous pouvez utiliser plusieurs coupons dans un calendrier.'));
                
                /*
                 * CSS Templates
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CSS_TEMPLATES_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Support of multiple CSS Templates',
                                        'de' => 'Unterstützung mehrerer CSS-Vorlagen',
                                        'es' => 'Soporte de múltiples plantillas CSS',
                                        'fr' => 'Prise en charge de plusieurs modèles CSS'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CSS_TEMPLATES_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You have the possibility to create an unlimited number of CSS Templates to customize your front-end booking calendars.',
                                        'de' => 'Sie haben die Möglichkeit, eine unbegrenzte Anzahl von CSS-Vorlagen zu erstellen, um Ihre Frontend-Buchungskalender individuell anzupassen.',
                                        'es' => 'Usted tiene la posibilidad de crear un número ilimitado de Plantillas CSS para personalizar sus calendarios de reservación.',
                                        'fr' => 'Vous avez la possibilité de créer un nombre illimité de modèles CSS pour personnaliser vos calendriers front end (frontaux) de réservation.'));
                
                /*
                 * Currencies
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CURRENCIES_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Multi-currency support',
                                        'de' => 'Unterstützung für mehrere Währungen',
                                        'es' => 'Compatibilidad con varias divisas',
                                        'fr' => 'Prise en charge de plusieurs devises'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CURRENCIES_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Any currency can be used with your booking calendar.',
                                        'de' => 'Jede beliebige Währung kann mit Ihrem Buchungskalender verwendet werden.',
                                        'es' => 'Se puede utilizar cualquier moneda con el calendario de reservas.',
                                        'fr' => 'N<<single-quote>>importe quelle devise peut être utilisée avec votre calendrier de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CURRENCIES_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Currency display can customize to show before or after price.',
                                        'de' => 'Die Währungsanzeige kann so angepasst werden, dass sie vor oder nach dem Preis angezeigt wird.',
                                        'es' => 'La visualización de moneda puede personalizarse para mostrar antes o después del precio.',
                                        'fr' => 'L<<single-quote>>affichage de la devise peut être personnalisé de manière à se faire avant ou après le prix.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CURRENCIES_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can add your own currency using hooks.',
                                        'de' => 'Sie können Ihre eigene Währung mit Hilfe von Häkchen hinzufügen.',
                                        'es' => 'Puede añadir su propia moneda utilizando ganchos.',
                                        'fr' => 'Vous pouvez ajouter votre propre devise à l<<single-quote>>aide de crochets.'));
                
                /*
                 * Custom posts
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CUSTOM_POSTS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Support for custom post type',
                                        'de' => 'Unterstützung für benutzerdefinierte Beiträge',
                                        'es' => 'Soporte para el tipo de entrada personalizado',
                                        'fr' => 'Prise en charge du type de publication personnalisée'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CUSTOM_POSTS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Users have the possibility to create a post with a booking calendar attached.',
                                        'de' => 'Benutzer haben die Möglichkeit, einen Beitrag mit angehängtem Buchungskalender zu erstellen.',
                                        'es' => 'Los usuarios tienen la posibilidad de crear una entrada con un calendario de reservas adjunto.',
                                        'fr' => 'Les utilisateurs ont la possibilité de créer une publication avec un calendrier de réservation joint.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_CUSTOM_POSTS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The booking calendar availability, reservations & settings can be managed from the post.',
                                        'de' => 'Die Verfügbarkeit des Buchungskalenders, Reservierungen und Einstellungen können vom Beitrag aus verwaltet werden.',
                                        'es' => 'La disponibilidad del calendario, las reservas y la configuración se pueden gestionar desde el post.',
                                        'fr' => 'La disponibilité du calendrier de réservation, les réservations et les paramètres peuvent être gérés depuis la publication.'));
                
                /*
                 * Days
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DAYS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Book days',
                                        'de' => 'Tage buchen',
                                        'es' => 'Reserve días',
                                        'fr' => 'Jours de réservation'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DAYS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Add price, promo price, number of items available and information for each day in the front-end booking calendar. In the back end booking calendar administrators can add notes to themselves or other administrators.',
                                        'de' => 'Fügen Sie Preis, Aktionspreis, Anzahl der verfügbaren Artikel und Informationen für jeden Tag im Frontend-Buchungskalender hinzu. Im Backend des Buchungskalenders können Administratoren Notizen zu sich selbst oder anderen Administratoren hinzufügen.',
                                        'es' => 'Añada precio, precio promocional, número de artículos disponibles e información para cada día en el calendario de reservas. En el módulo de reserva, los administradores de calendario pueden añadir notas a sí mismos o a otros administradores.',
                                        'fr' => 'Ajoutez le prix, le prix promo, le nombre d<<single-quote>>articles disponibles et des informations journalières dans le calendrier front end (frontal) de réservation. En arrière-plan, les administrateurs du calendrier des réservations peuvent ajouter des remarques pour eux-mêmes ou pour d<<single-quote>>autres administrateurs.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DAYS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Days are displayed in the booking calendar with the following statuses: None, Available, Booked, Special, Unavailable.',
                                        'de' => 'Im Buchungskalender werden Tage mit folgenden Status angezeigt: Keine, verfügbar, gebucht, speziell, nicht verfügbar.',
                                        'es' => 'Los días se visualizan en el calendario de reservas con los siguientes estados: Ninguno, Disponible, Reservado, Especial, No disponible.',
                                        'fr' => 'Les jours sont affichés dans le calendrier de réservation avec les statuts suivants : Aucun, Disponible, Réservé, Spécial, Indisponible.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DAYS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Days color can be changed from CSS depending on the period.',
                                        'de' => 'Die Farbe der Tage kann in CSS je nach Zeitraum geändert werden.',
                                        'es' => 'El color de los días se puede cambiar de CSS dependiendo del período.',
                                        'fr' => 'La couleur des jours peut être changée de CSS selon la période.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DAYS_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'One or more days can be selected.',
                                        'de' => 'Es können ein oder mehrere Tage ausgewählt werden.',
                                        'es' => 'Se pueden seleccionar uno o más días.',
                                        'fr' => 'Un ou plusieurs jours peuvent être sélectionnés.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DAYS_TEXT5',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Set price & status for groups of days. Multiple groups can be booked together.',
                                        'de' => 'Legen Sie Preis & Status für mehrere Tage fest. Es können mehrere Gruppen zusammen gebucht werden.',
                                        'es' => 'Establezca el precio y el estado para grupos de días. Se pueden reservar varios grupos juntos.',
                                        'fr' => 'Définissez le prix et le statut pour les groupes de jours. Plusieurs groupes peuvent être réservés ensemble.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DAYS_TEXT6',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Set the first day of the week that will appear in the booking calendar.',
                                        'de' => 'Stellen Sie den ersten Tag der Woche ein, der im Buchungskalender erscheinen soll.',
                                        'es' => 'Establezca el primer día de la semana que aparecerá en el calendario de reservas.',
                                        'fr' => 'Définissez le premier jour de la semaine qui apparaîtra dans le calendrier de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DAYS_TEXT7',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Set general available/unavailable weekdays.',
                                        'de' => 'Stellen Sie allgemeine verfügbare/nicht verfügbare Wochentage ein.',
                                        'es' => 'Configure los días laborables generales disponibles/no disponibles.',
                                        'fr' => 'Définissez les jours de la semaine disponibles/in disponibles.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DAYS_TEXT8',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Support for morning check-out. It will display information in the Booking Calendar if you need to check-in in the afternoon and check-out in the morning. This option is very useful for hotels.',
                                        'de' => 'Unterstützt die morgendliche Abreise. Es zeigt Informationen im Buchungskalender an, wenn Sie am Nachmittag einchecken und am Morgen auschecken müssen. Diese Option ist sehr nützlich für Hotels.',
                                        'es' => 'Soporte para check-out matutino. Mostrará información en el Calendario de Reservas si necesita registrarse por la tarde y salir por la mañana. Esta opción es muy útil para los hoteles.',
                                        'fr' => 'Prise en charge du départ en matinée. Les informations seront affichées dans le calendrier de réservation si vous devez arriver dans l<<single-quote>>après-midi et quitter en matinée. Cette option est très utile pour les hôtels.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DAYS_TEXT9',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can limit the minimum and/or maximum number of days that can be booked.',
                                        'de' => 'Sie können die minimale und/oder maximale Anzahl der Tage, die gebucht werden können, begrenzen.',
                                        'es' => 'Puede limitar el número mínimo y/o máximo de días que se pueden reservar.',
                                        'fr' => 'Vous pouvez limiter le nombre minimum et/ou maximum de jours pouvant être réservés.'));
                
                /*
                 * Discounts
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DISCOUNTS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Booking discounts',
                                        'de' => 'Buchungsrabatte',
                                        'es' => 'Descuentos por reserva',
                                        'fr' => 'Rabais sur les réservations'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DISCOUNTS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Set discounts depending on the number of days/hours/minutes that are in a booking request (reservation).',
                                        'de' => 'Setzt Rabatte in Abhängigkeit von der Anzahl der Tage/Stunden/Minuten, die sich in einer Buchungsanfrage (Reservierung) befinden.',
                                        'es' => 'Establezca descuentos dependiendo del número de días/horas/minutos que se encuentran en una solicitud de reserva.',
                                        'fr' => 'Définissez des rabais en fonction du nombre de jours/heures/minutes qui figurent sur une demande de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DISCOUNTS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The value for discounts can be negative or positive, fixed or percent, once or by day/hour.',
                                        'de' => 'Der Wert für Rabatte kann negativ oder positiv, fest oder prozentual, einmalig oder pro Tag/Stunde sein.',
                                        'es' => 'El valor de los descuentos puede ser negativo o positivo, fijo o porcentual, una vez o por día/hora.',
                                        'fr' => 'La valeur des rabais peut être négative ou positive, fixe ou en pourcentage, une fois ou par jour/heure.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DISCOUNTS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can create unlimited number of different discounts, to use with one or multiple calendars.',
                                        'de' => 'Sie können eine unbegrenzte Anzahl von verschiedenen Rabatten erstellen, die Sie mit einem oder mehreren Kalendern verwenden können.',
                                        'es' => 'Puede crear un número ilimitado de descuentos diferentes, para usar con uno o varios calendarios.',
                                        'fr' => 'Vous pouvez créer un nombre illimité de rabais différents, à utiliser avec un ou plusieurs calendriers.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_DISCOUNTS_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can set specific discounts for the date/time for which the booking request (reservation) is made.',
                                        'de' => 'Sie können spezifische Rabatte für das Datum/Uhrzeit einstellen, für das die Buchungsanfrage (Reservierung) gestellt wird.',
                                        'es' => 'Se pueden fijar descuentos específicos para la fecha/hora para la cual se realiza la solicitud de reserva.',
                                        'fr' => 'Vous pouvez définir des rabais spécifiques pour la date et l<<single-quote>>heure pour laquelle la demande de réservation est effectuée.'));
                
                /*
                 * Emails
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EMAILS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Email templates & notifications',
                                        'de' => 'E-Mail-Vorlagen & Benachrichtigungen',
                                        'es' => 'Plantillas y notificaciones de correo electrónico',
                                        'fr' => 'Modèles d’e-mails et de notifications'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EMAILS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Create email templates for all possible notifications and languages.',
                                        'de' => 'Erstellen Sie E-Mail-Vorlagen für alle möglichen Benachrichtigungen und Sprachen.',
                                        'es' => 'Cree plantillas de correo electrónico para todas las notificaciones e idiomas posibles.',
                                        'fr' => 'Créez des modèles d<<single-quote>>e-mail pour toutes les notifications et langues possibles.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EMAILS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Email notifications can be sent with SMTP, PHPMailer class or with PHP mail function.',
                                        'de' => 'E-Mail-Benachrichtigungen können mit SMTP, PHPMailer-Klasse oder mit PHP-Mail-Funktion gesendet werden.',
                                        'es' => 'Las notificaciones de correo electrónico se pueden enviar con SMTP, clase PHPMailer o con la función de correo PHP.',
                                        'fr' => 'Les notifications par e-mail peuvent être envoyées par SMTP, la classe PHPMailer ou avec la fonction de messagerie PHP.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EMAILS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Enable/disable which notifications should be sent.',
                                        'de' => 'Aktivieren/Deaktivieren Sie, welche Benachrichtigungen gesendet werden sollen.',
                                        'es' => 'Active/desactive las notificaciones que deben enviarse.',
                                        'fr' => 'Activer/désactiver les notifications à envoyer.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EMAILS_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Notifications can be sent to multiple admins.',
                                        'de' => 'Benachrichtigungen können an mehrere Administratoren gesendet werden.',
                                        'es' => 'Las notificaciones se pueden enviar a varios administradores.',
                                        'fr' => 'Les notifications peuvent être envoyées à plusieurs administrateurs.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EMAILS_TEXT5',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can add reply email & name.',
                                        'de' => 'Sie können Antwort-E-Mails und Namen hinzufügen.',
                                        'es' => 'Puede agregar el nombre y el correo electrónico de respuesta.',
                                        'fr' => 'Vous pouvez ajouter la réponse par e-mail et le nom.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EMAILS_TEXT6',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can create unlimited number of email templates, to use with one or multiple calendars.',
                                        'de' => 'Sie können eine unbegrenzte Anzahl von E-Mail-Vorlagen erstellen, die Sie mit einem oder mehreren Kalendern verwenden können.',
                                        'es' => 'Puede crear un número ilimitado de plantillas de correo electrónico para utilizar con uno o varios calendarios.',
                                        'fr' => 'Vous pouvez créer un nombre illimité de modèles d<<single-quote>>e-mail, à utiliser avec un ou plusieurs calendriers.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EMAILS_TEXT7',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can set what information should be included in notifications regarding the booking request (reservation) by using shortcodes in the email templates.',
                                        'de' => 'Sie können einstellen, welche Informationen in Benachrichtigungen über die Buchungsanfrage (Reservierung) aufgenommen werden sollen, indem Sie Shortcodes in den E-Mail-Vorlagen verwenden.',
                                        'es' => 'Puede establecer qué información debe incluirse en las notificaciones relativas a la solicitud de reserva utilizando los atajos de las plantillas de correo electrónico.',
                                        'fr' => 'Vous pouvez définir les informations à inclure dans les notifications concernant la demande de réservation en utilisant les shortcodes dans les modèles d<<single-quote>>e-mail.'));
                
                /*
                 * Extras
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EXTRAS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Extras (amenities, services & other stuff)',
                                        'de' => 'Extras (Annehmlichkeiten, Dienstleistungen & andere Dinge)',
                                        'es' => 'Extras (comodidades, servicios y otras cosas)',
                                        'fr' => 'Suppléments (commodités, services et autres)'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EXTRAS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Add amenities, services & other stuff, with price or not, to a booking request (reservation).',
                                        'de' => 'AFügen Sie Annehmlichkeiten, Dienstleistungen und andere Dinge, mit oder ohne Preis, zu einer Buchungsanfrage (Reservierung) hinzu.',
                                        'es' => 'Agregue comodidades, servicios y otras cosas, con o sin precio, a una solicitud de reserva.',
                                        'fr' => 'Ajoutez des commodités, des services et d<<single-quote>>autres choses, avec ou sans prix, à une demande de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EXTRAS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Extras can have default values.',
                                        'de' => 'Extras können Standardwerte haben.',
                                        'es' => 'Los detalles pueden tener valores predeterminados.',
                                        'fr' => 'Les fonctions supplémentaires peuvent avoir des valeurs par défaut.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EXTRAS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Extras groups can be mandatory or not and a client can select a single or multiple items.',
                                        'de' => 'Extras-Gruppen können obligatorisch sein oder nicht und ein Kunde kann einen einzelnen oder mehrere Elemente auswählen.',
                                        'es' => 'Los grupos de extras pueden ser obligatorios o no y un cliente puede seleccionar uno o varios elementos.',
                                        'fr' => 'Les groupes de suppléments peuvent être obligatoires ou non et un client peut sélectionner un ou plusieurs éléments.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EXTRAS_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The value for extras can be negative or positive, fixed or percent, once or by day/hour, or 0.',
                                        'de' => 'Der Wert für Extras kann negativ oder positiv, fest oder prozentual, einmalig oder pro Tag/Stunde oder 0 sein.',
                                        'es' => 'El valor de los extras puede ser negativo o positivo, fijo o porcentual, una vez o por día/hora, o 0.',
                                        'fr' => 'La valeur des suppléments peut être négative ou positive, fixe ou en pourcentage, une fois ou par jour/heure, ou 0.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_EXTRAS_TEXT5',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can create unlimited number of different extras groups, to use with one or multiple calendars.',
                                        'de' => 'Sie können eine unbegrenzte Anzahl von verschiedenen Extras-Gruppen erstellen, die Sie mit einem oder mehreren Kalendern verwenden können.',
                                        'es' => 'Puede crear un número ilimitado de grupos de extras diferentes, para usar con uno o varios calendarios.',
                                        'fr' => 'Vous pouvez créer un nombre illimité de groupes de suppléments différents, à utiliser avec un ou plusieurs calendriers.'));
                
                /*
                 * Fees
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FEES_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Taxes & Fees',
                                        'de' => 'Steuern & Gebühren',
                                        'es' => 'Impuestos y Tarifas',
                                        'fr' => 'Taxes et frais'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FEES_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Add taxes & fees that need to be paid with a booking request (reservation).',
                                        'de' => 'AHinzu kommen Steuern und Gebühren, die bei einer Buchungsanfrage (Reservierung) zu zahlen sind.',
                                        'es' => 'Añada los impuestos y tasas que deben pagarse con una solicitud de reserva.',
                                        'fr' => 'Ajoutez les taxes et les frais qui doivent être payés avec une demande de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FEES_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Taxes & fees included or not in booking request (reservation) price.',
                                        'de' => 'Steuern & Gebühren sind in den Preisen der Buchungsanfrage (Reservierung) enthalten oder nicht.',
                                        'es' => 'Impuestos y tasas incluidos o no en el precio de la solicitud de reserva.',
                                        'fr' => 'Taxes et frais inclus ou non dans le prix de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FEES_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The value for taxes & fees can be negative or positive, fixed or percent, once or by day/hour.',
                                        'de' => 'Der Wert für Steuern & Gebühren kann negativ oder positiv, fest oder prozentual, einmalig oder pro Tag/Stunde sein.',
                                        'es' => 'El valor de los impuestos y cargos puede ser negativo o positivo, fijo o porcentual, una vez o por día/hora.',
                                        'fr' => 'La valeur des taxes et frais peut être négative ou positive, fixe ou en pourcentage, une fois ou par jour/heure.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FEES_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can choose to include or not extras in the calculation of taxes & fees.',
                                        'de' => 'Sie können wählen, ob Sie bei der Berechnung von Steuern und Gebühren Extras berücksichtigen möchten oder nicht.',
                                        'es' => 'Puede optar por incluir o no extras en el cálculo de impuestos y tasas.',
                                        'fr' => 'Vous pouvez choisir d<<single-quote>>inclure ou non des suppléments dans le calcul des taxes et frais.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FEES_TEXT5',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can create unlimited number of taxes & fees, to use with one or multiple calendars.',
                                        'de' => 'Sie können eine unbegrenzte Anzahl von Steuern und Gebühren erstellen, die Sie mit einem oder mehreren Kalendern verwenden können.',
                                        'es' => 'Puede crear un número ilimitado de impuestos y cargos, para usar con uno o varios calendarios.',
                                        'fr' => 'Vous pouvez créer un nombre illimité de taxes et de frais, à utiliser avec un ou plusieurs calendriers.'));
                
                /*
                 * Forms
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FORMS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Booking forms',
                                        'de' => 'Buchungsformulare',
                                        'es' => 'Formularios de reserva',
                                        'fr' => 'Formulaires de réservation'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FORMS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Create your own custom booking forms to get what information you want from your clients.',
                                        'de' => 'Erstellen Sie Ihre eigenen benutzerdefinierten Buchungsformulare, um die gewünschten Informationen von Ihren Kunden zu erhalten.',
                                        'es' => 'Cree sus propios formularios de reservación personalizados para obtener la información que desea de sus clientes.',
                                        'fr' => 'Créez vos propres formulaires de réservation personnalisés pour obtenir les informations que vous attendez de vos clients.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FORMS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The booking form supports Text fields (email, phone, name etc), Text areas, Checkboxes & Dropdowns.',
                                        'de' => 'Das Buchungsformular unterstützt Textfelder (E-Mail, Telefon, Name etc.), Textbereiche, Checkboxen & Dropdowns.',
                                        'es' => 'El formulario de reservación soporta campos de texto (correo electrónico, teléfono, nombre, etc.), áreas de texto, casillas de verificación y desplegables.',
                                        'fr' => 'Le formulaire de réservation prend en charge les champs de texte (e-mail, téléphone, nom, etc.), les zones de texte, les cases à cocher et les menus déroulants.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_FORMS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can create unlimited number of booking forms, to use with one or multiple calendars.',
                                        'de' => 'Sie können beliebig viele Buchungsformulare erstellen, die Sie mit einem oder mehreren Kalendern verwenden können.',
                                        'es' => 'Puede crear un número ilimitado de formularios de reserva, para utilizar con uno o varios calendarios.',
                                        'fr' => 'Vous pouvez créer un nombre illimité de formulaires de réservation, à utiliser avec un ou plusieurs calendriers.'));
                /*
                 * Hours
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_HOURS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Book hours/minutes',
                                        'de' => 'Buchen Sie Stunden/Minuten',
                                        'es' => 'Reserve horas/minutos',
                                        'fr' => 'Réservez les heures/minutes'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_HOURS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Add price, promo price, number of items available and information for each hour in the front-end booking calendar. In the back end booking calendar administrators can add notes to themselves or other administrators.',
                                        'de' => 'Fügen Sie Preis, Aktionspreis, Anzahl der verfügbaren Artikel und Informationen für jede Stunde im Frontend-Buchungskalender hinzu. Im Backend des Buchungskalenders können Administratoren Notizen an sich selbst oder andere Administratoren anhängen.',
                                        'es' => 'Añada precio, precio promocional, número de artículos disponibles e información para cada hora en el calendario de reservas. En el módulo de reserva, los administradores de calendario pueden añadir notas a sí mismos o a otros administradores.',
                                        'fr' => 'Ajoutez le prix, le prix promo, le nombre d<<single-quote>>articles disponibles et des informations pour chaque heure dans le calendrier front end (fronta) de réservation. En arrière-plan, les administrateurs du calendrier des réservations peuvent ajouter des remarques pour eux-mêmes ou pour d<<single-quote>>autres administrateurs.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_HOURS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'One or more hours can be selected.',
                                        'de' => 'Es können eine oder mehrere Stunden ausgewählt werden.',
                                        'es' => 'Se pueden seleccionar una o más horas.',
                                        'fr' => 'Une ou plusieurs heures peuvent être sélectionnées.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_HOURS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Hours can be in AM/PM or 24 hours format.',
                                        'de' => 'Die Stunden können im AM/PM- oder 24-Stunden-Format sein.',
                                        'es' => 'Las horas pueden ser en formato AM/PM o de 24 horas.',
                                        'fr' => 'Les heures peuvent être en format AM/PM ou 24 heures.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_HOURS_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Hours intervals are supported.',
                                        'de' => 'Stundenintervalle werden unterstützt.',
                                        'es' => 'Se soportan intervalos de horas.',
                                        'fr' => 'Les intervalles d<<single-quote>>heures sont pris en charge.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_HOURS_TEXT5',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Set price & status for groups of hours. Multiple groups can be booked together.',
                                        'de' => 'Setzen Sie Preis & Status für mehrere Stunden. Es können mehrere Gruppen zusammen gebucht werden.',
                                        'es' => 'Establezca el precio y el estado para grupos de horas. Se pueden reservar varios grupos juntos.',
                                        'fr' => 'Définissez le prix et le statut pour les groupes d<<single-quote>>heures. Plusieurs groupes peuvent être réservés ensemble.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_HOURS_TEXT6',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The hours are displayed in the Booking Calendar with the following statuses: None, Available, Booked, Special, Unavailable.',
                                        'de' => 'Die Stunden werden im Buchungskalender mit folgenden Status angezeigt: Keine, verfügbar, gebucht, speziell, nicht verfügbar.',
                                        'es' => 'Las horas se visualizan en el Calendario de reservas con los siguientes estados: Ninguno, Disponible, Reservado, Especial, No disponible.',
                                        'fr' => 'Les heures sont affichées dans le calendrier de réservation avec les statuts suivants : Aucun, Disponible, Réservé, Spécial, Indisponible.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_HOURS_TEXT7',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can limit the minimum and/or maximum number of minutes that can be booked.',
                                        'de' => 'Sie können die minimale und/oder maximale Anzahl der Minuten, die gebucht werden können, begrenzen.',
                                        'es' => 'Puede limitar el número mínimo y/o máximo de minutos que se pueden reservar.',
                                        'fr' => 'Vous pouvez limiter le nombre minimum et/ou maximum de minutes pouvant être réservées.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_HOURS_TEXT8',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You have complete control over what hours you are using in your booking calendar. You can set same hours by the minute for the whole calendar or you can set different hours for different days.',
                                        'de' => 'Sie haben die volle Kontrolle darüber, welche Stunden Sie in Ihrem Buchungskalender verwenden. Sie können für den gesamten Kalender minutengenaue Stunden oder für verschiedene Tage unterschiedliche Stunden einstellen.',
                                        'es' => 'Tiene un control total sobre las horas que utiliza en su calendario de reservas. Puede configurar las mismas horas por minuto para todo el calendario o puede configurar horas diferentes para días diferentes.',
                                        'fr' => 'Vous avez un contrôle total sur les heures que vous utilisez dans votre calendrier de réservation. Vous pouvez régler les mêmes heures à la minute près pour l<<single-quote>>ensemble du calendrier ou vous pouvez régler des heures différentes pour des jours différents.'));
                /*
                 * Languages
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_LANGUAGES_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Multilingual support for front-end & back-end',
                                        'de' => 'Mehrsprachige Unterstützung für Frontend & Backend',
                                        'es' => 'Soporte multilingüe para la interfaz y el módulo de servicio',
                                        'fr' => 'Prise en charge multilingue du front-end et du back-end'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_LANGUAGES_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'All booking system text is changeable (calendars, extras, form fields, taxes ...).',
                                        'de' => 'Der gesamte Text des Buchungssystems ist änderbar (Kalender, Extras, Formularfelder, Steuern....).',
                                        'es' => 'Todo el texto del sistema de reservas es modificable (calendarios, extras, campos de formulario, impuestos...).',
                                        'fr' => 'Tout le texte du système de réservation est modifiable (calendriers, suppléments, champs de formulaire, taxes...).'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_LANGUAGES_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Change translation or text in back-end with an easy “to do” translation tool.',
                                        'de' => 'Ändern Sie die Übersetzung oder den Text im Backend mit einem einfachen "to do"-Übersetzungstool.',
                                        'es' => 'Cambie la traducción o el texto en el módulo de servicio con una herramienta de traducción fácil de usar.',
                                        'fr' => 'Modifiez la traduction ou le texte en arrière-plan à l<<single-quote>>aide d<<single-quote>>un outil de traduction « facile à utiliser ».'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_LANGUAGES_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Enable/disable languages.',
                                        'de' => 'Aktivieren/Deaktivieren Sie Sprachen.',
                                        'es' => 'Active/desactive idiomas.',
                                        'fr' => 'Activer/désactiver les langues.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_LANGUAGES_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can add your own language using hooks.',
                                        'de' => 'Sie können Ihre eigene Sprache über Häkchen hinzufügen.',
                                        'es' => 'Puede añadir su propio idioma usando ganchos.',
                                        'fr' => 'Vous pouvez ajouter votre propre langue à l<<single-quote>>aide de crochets.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_LANGUAGES_TEXT5',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'WPML plugin is compatible and supported by Pinpoint Booking System.',
                                        'de' => 'Das WPML-Plugin ist kompatibel und wird vom Pinpoint Buchungssystem unterstützt.',
                                        'es' => 'El plugin WPML es compatible y soportado por el Sistema de Reservas Pinpoint.',
                                        'fr' => 'Le plugin WPML est compatible et pris en charge par Pinpoint Booking System.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_LANGUAGES_TEXT6',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Note: Not all languages are translated.',
                                        'de' => 'Hinweis: Nicht alle Sprachen sind übersetzt.',
                                        'es' => 'Nota: No todos los idiomas están traducidos.',
                                        'fr' => 'Remarque : Toutes les langues ne sont pas traduites.'));
                
                /*
                 * Locations
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_LOCATIONS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Locations',
                                        'de' => 'Standorte',
                                        'es' => 'Ubicaciones',
                                        'fr' => 'Emplacements'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_LOCATIONS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Locations can be added on a Google map, and it can have multiple calendars attached to it.',
                                        'de' => 'Standorte können auf einer Google Map hinzugefügt werden, und es können mehrere Kalender hinzugefügt werden.',
                                        'es' => 'Las ubicaciones se pueden añadir en un mapa de Google, y puede tener varios calendarios adjuntos.',
                                        'fr' => 'Il est possible d<<single-quote>>ajouter des emplacements sur une carte Google map, et plusieurs calendriers peuvent y être associés.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_LOCATIONS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'The locations will display on search results when you view the map.',
                                        'de' => 'Die Standorte werden in den Suchergebnissen angezeigt, wenn Sie sich die Karte ansehen.',
                                        'es' => 'Las ubicaciones se mostrarán en los resultados de la búsqueda cuando vea el mapa.',
                                        'fr' => 'Les emplacements s<<single-quote>>afficheront sur les résultats de la recherche lorsque vous verrez la carte.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_LOCATIONS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Your business location can be shared on PINPOINT.WORLD',
                                        'de' => 'Ihr Firmensitz kann auf PINPOINT.WORLD geteilt werden.',
                                        'es' => 'La ubicación de su negocio puede ser compartida en PINPOINT.WORLD',
                                        'fr' => 'Votre lieu d<<single-quote>>affaires peut être partagé sur PINPOINT.WORLD'));
                
                /*
                 * Multi sites/users
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_MULTI_SITES_USERS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Support for Multi-Sites/Multi-Users',
                                        'de' => 'Unterstützung für mehrere Seiten/mehrere User',
                                        'es' => 'Soporte para multi-sitios/multiusuarios',
                                        'fr' => 'Prise en charge multisites/multi-utilisateurs'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_MULTI_SITES_USERS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Allow administrators to access all calendars.',
                                        'de' => 'Ermöglichen Sie Administratoren den Zugriff auf alle Kalender.',
                                        'es' => 'Permita que los administradores accedan a todos los calendarios.',
                                        'fr' => 'Autoriser les administrateurs à accéder à tous les calendriers.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_MULTI_SITES_USERS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Allow users access to the booking system.',
                                        'de' => 'Ermöglichen Sie den Benutzern den Zugriff auf das Buchungssystem.',
                                        'es' => 'Permita a los usuarios el acceso al sistema de reservas.',
                                        'fr' => 'Permettre aux utilisateurs d<<single-quote>>accéder au système de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_MULTI_SITES_USERS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Allow users access to booking system custom post types.',
                                        'de' => 'Ermöglichen Sie Benutzern den Zugriff auf benutzerdefinierte Beiträge im Buchungssystem.',
                                        'es' => 'Permita a los usuarios acceder a los tipos de post personalizados del sistema de reservas.',
                                        'fr' => 'Permettre aux utilisateurs d<<single-quote>>accéder aux types de publications personnalisées du système de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_MULTI_SITES_USERS_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Allow administrators to create booking calendars and give access to different users.',
                                        'de' => 'Ermöglichen Sie es Administratoren, Buchungskalender zu erstellen und verschiedenen Benutzern Zugriff zu gewähren.',
                                        'es' => 'Permita a los administradores crear calendarios de reservas y dar acceso a diferentes usuarios.',
                                        'fr' => 'Permettre aux administrateurs de créer des calendriers de réservation et de donner accès à différents utilisateurs.'));
                
                /*
                 * Payments
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_PAYMENTS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Payment systems',
                                        'de' => 'Zahlungssysteme',
                                        'es' => 'Sistemas de pago',
                                        'fr' => 'Systèmes de paiement'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_PAYMENTS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Payment cannot be mandatory when a client creates a booking request (reservation).',
                                        'de' => 'Die Zahlung kann nicht obligatorisch sein, wenn ein Kunde eine Buchungsanfrage (Reservierung) erstellt.',
                                        'es' => 'El pago no puede ser obligatorio cuando un cliente crea una solicitud de reserva.',
                                        'fr' => 'Le paiement n<<single-quote>>est pas obligatoire lorsqu<<single-quote>>un client crée une demande de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_PAYMENTS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Payment can be made when a client arrives at the location he/she booked.',
                                        'de' => 'Die Zahlung kann erfolgen, wenn ein Kunde an dem von ihm gebuchten Ort ankommt.',
                                        'es' => 'El pago se puede realizar cuando el cliente llega al lugar que ha reservado.',
                                        'fr' => 'Le paiement peut être effectué à l<<single-quote>>arrivée du client à sa destination de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_PAYMENTS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'PayPal (credit card supported) is included.',
                                        'de' => 'PayPal (Kreditkarte wird unterstützt) ist im Lieferumfang enthalten.',
                                        'es' => 'PayPal (compatible con tarjeta de crédito) está incluido.',
                                        'fr' => 'PayPal (carte de crédit supportée) est inclus.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_PAYMENTS_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Add-ons can be used to add other payment gateways like 2Checkout, Authorize.Net, Braintree, ICEPAY, Mollie, Stripe, and WePay.',
                                        'de' => 'Add-ons können verwendet werden, um andere Zahlungs-Gateways wie 2Checkout, Authorize.Net, Braintree, ICEPAY, Mollie, Stripe und WePay hinzuzufügen.',
                                        'es' => 'Se pueden utilizar complementos para añadir otras pasarelas de pago como 2Checkout, Authorize.Net, Braintree, ICEPAY, Mollie, Stripe y WePay.',
                                        'fr' => 'Des extensions peuvent être utilisées pour ajouter d<<single-quote>>autres passerelles de paiement comme 2Checkout, Authorize.Net, Braintree, ICEPAY, Mollie, Stripe, et WePay.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_PAYMENTS_TEXT5',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Billing and shipping addresses can be added to payment systems.',
                                        'de' => 'Rechnungs- und Lieferadressen können den Zahlungssystemen hinzugefügt werden.',
                                        'es' => 'Las direcciones de facturación y envío se pueden añadir a los sistemas de pago.',
                                        'fr' => 'Les adresses de facturation et d<<single-quote>>expédition peuvent être ajoutées aux systèmes de paiement.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_PAYMENTS_TEXT6',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Deposits can also be used with all payment gateways, and clients can pay only a percent or fixed amount of the sum or the full value of their booking.',
                                        'de' => 'Einzahlungen können auch bei allen Zahlungs-Gateways verwendet werden, und Kunden können nur einen Prozentsatz oder einen festen Betrag der Summe oder den vollen Wert ihrer Buchung bezahlen.',
                                        'es' => 'Los depósitos también se pueden utilizar con todas las pasarelas de pago, y los clientes pueden pagar sólo un porcentaje o una cantidad fija de la suma o el valor total de su reserva.',
                                        'fr' => 'Les dépôts peuvent également être utilisés avec toutes les passerelles de paiement, et les clients ne peuvent payer qu<<single-quote>>un pourcentage ou un montant fixe de la somme ou la valeur totale de leur réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_PAYMENTS_TEXT7',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Each payment system has a refund function included.',
                                        'de' => 'EJedes Zahlungssystem verfügt über eine integrierte Rückerstattungsfunktion.',
                                        'es' => 'Cada sistema de pago tiene una función de reembolso incluida.',
                                        'fr' => 'Chaque système de paiement a une fonction de remboursement incluse.'));
                
                /*
                 * Reservations
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_RESERVATIONS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Reservations',
                                        'de' => 'Reservierungen',
                                        'es' => 'Reservas',
                                        'fr' => 'Réservations'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_RESERVATIONS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Administrators have the possibility to add, approve, reject, edit, cancel or delete a booking request (reservation).',
                                        'de' => 'Administratoren haben die Möglichkeit, eine Buchungsanfrage (Reservierung) hinzuzufügen, zu genehmigen, abzulehnen, zu bearbeiten, zu stornieren oder zu löschen.',
                                        'es' => 'Los administradores tienen la posibilidad de añadir, aprobar, rechazar, editar, cancelar o borrar una solicitud de reserva.',
                                        'fr' => 'Les administrateurs ont la possibilité d<<single-quote>>ajouter, d<<single-quote>>approuver, de refuser, de modifier, d<<single-quote>>annuler ou de supprimer une demande de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_RESERVATIONS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Administrators have the possibility to filter and/or search throw booking requests (reservations).',
                                        'de' => 'Administratoren haben die Möglichkeit, Buchungsanfragen (Reservierungen) zu filtern und/oder zu suchen.',
                                        'es' => 'Los administradores tienen la posibilidad de filtrar y/o buscar solicitudes de reserva.',
                                        'fr' => 'Les administrateurs ont la possibilité de filtrer et/ou de rechercher les demandes de réservation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_RESERVATIONS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Booking requests (reservations) can be instantly approved or can be approved/rejected by administrators. The booking calendar will be changed accordingly.',
                                        'de' => 'Buchungsanfragen (Reservierungen) können sofort genehmigt oder von Administratoren genehmigt bzw. abgelehnt werden. Der Buchungskalender wird entsprechend geändert.',
                                        'es' => 'Las solicitudes de reserva pueden ser aprobadas instantáneamente o pueden ser aprobadas/rechazadas por los administradores. El calendario de reservas se modificará en consecuencia.',
                                        'fr' => 'Les demandes de réservation peuvent être approuvées instantanément ou peuvent être approuvées/rejetées par les administrateurs. Le calendrier de réservation sera modifié en conséquence.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_RESERVATIONS_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Booking requests (reservations) cannot overlap.',
                                        'de' => 'Buchungsanforderungen (Reservierungen) dürfen sich nicht überschneiden.',
                                        'es' => 'Las solicitudes de reserva no pueden solaparse.',
                                        'fr' => 'Les demandes de réservation ne peuvent pas se chevaucher.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_RESERVATIONS_TEXT5',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Reservations are displayed in a list or in a calendar.',
                                        'de' => 'Reservierungen werden in einer Liste oder in einem Kalender angezeigt.',
                                        'es' => 'Las reservas se visualizan en una lista o en un calendario.',
                                        'fr' => 'Les réservations sont affichées dans une liste ou dans un calendrier.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_RESERVATIONS_TEXT6',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Reservations can be printed and/or exported to CSV, XLS, ICS & JSON formats.',
                                        'de' => 'Reservierungen können gedruckt und/oder in die Formate CSV, XLS, ICS & JSON exportiert werden.',
                                        'es' => 'Las reservas se pueden imprimir y/o exportar a los formatos CSV, XLS, ICS y JSON.',
                                        'fr' => 'Les réservations peuvent être imprimées et/ou exportées aux formats CSV, XLS, ICS & JSON.'));
                
                /*
                 * Rules
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_RULES_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Booking rules',
                                        'de' => 'Buchungsregeln',
                                        'es' => 'Normas de reserva',
                                        'fr' => 'Règles de réservation'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_RULES_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Set minimum & maximum number of days/hours/minutes that are permitted in a booking request (reservation).',
                                        'de' => 'Legen Sie die minimale und maximale Anzahl von Tagen/Stunden/Minuten fest, die in einer Buchungsanfrage (Reservierung) erlaubt sind.',
                                        'es' => 'Establezca el número mínimo y máximo de días/horas/minutos que se permiten en una solicitud de reserva.',
                                        'fr' => 'Définissez le nombre minimum et maximum de jours/heures/minutes autorisés dans une demande de réservation.'));
                
                /*
                 * Search
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_SEARCH_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Search availability through all calendars',
                                        'de' => 'Verfügbarkeit über alle Kalender hinweg suchen',
                                        'es' => 'Búsqueda de disponibilidad en todos los calendarios',
                                        'fr' => 'Rechercher la disponibilité sur tous les calendriers'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_SEARCH_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'You can search availability for hours or days, and you can filter results by location and price.',
                                        'de' => 'Sie können die Verfügbarkeit nach Stunden oder Tagen suchen und die Ergebnisse nach Standort und Preis filtern.',
                                        'es' => 'Puede buscar disponibilidad por horas o días, y puede filtrar los resultados por ubicación y precio.',
                                        'fr' => 'Vous pouvez rechercher la disponibilité par heures ou par jours, et vous pouvez filtrer les résultats par emplacement et par prix.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_SEARCH_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Results can be viewed in a list, a grid or by location on a Google map.',
                                        'de' => 'Die Ergebnisse können in einer Liste, einem Raster oder nach Standort auf einer Google-Karte angezeigt werden.',
                                        'es' => 'Los resultados se pueden ver en una lista, una cuadrícula o por ubicación en un mapa de Google.',
                                        'fr' => 'Les résultats peuvent être affichés dans une liste, une grille ou par emplacement sur une carte Google.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_SEARCH_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'If you select a result, you will be redirected to the page where the booking calendar is with search parameters already selected.',
                                        'de' => 'Wenn Sie ein Ergebnis auswählen, werden Sie auf die Seite weitergeleitet, auf der sich der Buchungskalender mit bereits ausgewählten Suchparametern befindet.',
                                        'es' => 'Si selecciona un resultado, será redirigido a la página donde se encuentra el calendario de reservas con los parámetros de búsqueda ya seleccionados.',
                                        'fr' => 'Si vous sélectionnez un résultat, vous serez redirigé vers la page où se trouve le calendrier de réservation avec les paramètres de recherche déjà sélectionnés.'));
                
                /*
                 * SMS
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_SMS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'SMS notifications',
                                        'de' => 'SMS-Benachrichtigungen',
                                        'es' => 'Notificaciones SMS',
                                        'fr' => 'Notifications par SMS'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_SMS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'SMS can be sent, to you or your clients, about reservations status changes with Clickatell SMS gateway.',
                                        'de' => 'Mit dem Clickatell SMS-Gateway können Sie oder Ihre Kunden SMS über Änderungen des Reservierungsstatus erhalten.',
                                        'es' => 'Se puede enviar SMS, a usted o a sus clientes, sobre los cambios de estado de las reservas con la puerta de enlace SMS de Clickatell.',
                                        'fr' => 'Des SMS peuvent être envoyés, à vous ou à vos clients, concernant les changements de statut des réservations avec la passerelle Clickatell SMS.'));
                
                /*
                 * Synchronization
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_SYNCHRONIZATION_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Synchronization with other systems',
                                        'de' => 'Synchronisation mit anderen Systemen',
                                        'es' => 'Sincronización con otros sistemas',
                                        'fr' => 'Synchronisation avec d<<single-quote>>autres systèmes'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_SYNCHRONIZATION_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Each Pinpoint booking calendar availability can be synchronized with Google Calendar, iCalendar or Airbnb.',
                                        'de' => 'Jede Verfügbarkeit von Pinpoint Buchungskalendern kann mit Google Calendar, iCalendar oder Airbnb synchronisiert werden.',
                                        'es' => 'La disponibilidad de cada calendario de reservas Pinpoint se puede sincronizar con Google Calendar, iCalendar o Airbnb.',
                                        'fr' => 'Chaque disponibilité du calendrier de réservation Pinpoint peut être synchronisée avec Google Calendar, iCalendar ou Airbnb.'));
                
                /*
                 * Tools
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_TOOLS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Tools',
                                        'de' => 'Werkzeuge',
                                        'es' => 'Herramientas',
                                        'fr' => 'Outils'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_TOOLS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Pinpoint Booking System has a set of tools to repair technical problems that may appear with your installation.',
                                        'de' => 'Das Pinpoint Buchungssystem verfügt über eine Reihe von Werkzeugen, um technische Probleme zu beheben, die bei Ihrer Installation auftreten können.',
                                        'es' => 'El Sistema de Reservas Pinpoint tiene un conjunto de herramientas para reparar los problemas técnicos que pueden aparecer con su instalación.',
                                        'fr' => 'Pinpoint Booking System dispose d<<single-quote>>un ensemble d<<single-quote>>outils pour réparer les problèmes techniques qui peuvent survenir avec votre installation.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_TOOLS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => '"Repair database & text" tool can be used if your installation or update are not done properly, and you need to repair the database or the translation.',
                                        'de' => 'Das Werkzeug "Datenbank und Text reparieren" kann verwendet werden, wenn Ihre Installation oder Aktualisierung nicht ordnungsgemäß durchgeführt wurde und Sie die Datenbank oder die Übersetzung reparieren müssen.',
                                        'es' => 'La herramienta "Reparar base de datos y texto" se puede utilizar si su instalación o actualización no se realiza correctamente y necesita reparar la base de datos o la traducción.',
                                        'fr' => 'L<<single-quote>>outil « Réparer la base de données et le texte » peut être utilisé si votre installation ou mise à jour n<<single-quote>>est pas faite correctement, et si vous avez besoin de réparer la base de données ou la traduction.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_TOOLS_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => '"Repair calendars settings" tool can be used if a calendar is not behaving as expected after you configure it.',
                                        'de' => 'Das Werkzeug "Kalendereinstellungen reparieren" kann verwendet werden, wenn sich ein Kalender nach der Konfiguration nicht wie erwartet verhält.',
                                        'es' => 'La herramienta "Reparar la configuración de los calendarios" se puede utilizar si un calendario no se comporta como se espera después de configurarlo.',
                                        'fr' => 'L<<single-quote>>outil « Réparer les paramètres des calendriers » peut être utilisé si un calendrier ne se comporte pas comme prévu après sa configuration.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_TOOLS_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => '"Repair search settings" tool can be used if a search module cannot be configured properly.',
                                        'de' => 'Das Werkzeug "Sucheinstellungen reparieren" kann verwendet werden, wenn ein Suchmodul nicht richtig konfiguriert werden kann.',
                                        'es' => 'La herramienta "Reparar la configuración de la búsqueda" puede utilizarse si un módulo de búsqueda no puede configurarse correctamente.',
                                        'fr' => 'L<<single-quote>>outil « Réparer les paramètres de recherche » peut être utilisé si un module de recherche ne peut pas être configuré correctement.'));
                
                /*
                 * Widgets
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_WIDGETS_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Support for Widgets',
                                        'de' => 'Unterstützung für Widgets',
                                        'es' => 'Soporte para Widgets',
                                        'fr' => 'Prise en charge des widgets'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_WIDGETS_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Add booking calendars in a widget area.',
                                        'de' => 'Fügen Sie Buchungskalender in einem Widget-Bereich hinzu.',
                                        'es' => 'Añada calendarios de reservas en un área de widgets.',
                                        'fr' => 'Ajouter des calendriers de réservation dans une zone widget.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_WIDGETS_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Display a booking calendar sidebar in a widget area.',
                                        'de' => 'Zeigen Sie eine Buchungskalender-Sidebar in einem Widget-Bereich an.',
                                        'es' => 'Muestre una barra lateral del calendario de reservas en un área de widgets.',
                                        'fr' => 'Afficher une barre latérale de calendrier de réservation dans une zone de widget.'));
                
                /*
                 * WoooCommerce
                 */
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_WOO_TITLE',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Extend with WooCommerce',
                                        'de' => 'Erweitern Sie mit WooCommerce',
                                        'es' => 'Amplíe con WooCommerce',
                                        'fr' => 'Extension avec WooCommerce'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_WOO_TEXT1',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Configure calendar availability, services, discounts, taxes & fees ... and attach it to a product.',
                                        'de' => 'Konfigurieren Sie Kalenderverfügbarkeit, Dienstleistungen, Rabatte, Steuern und Gebühren... und hängen Sie sie an ein Produkt an.',
                                        'es' => 'Configure la disponibilidad del calendario, los servicios, los descuentos, los impuestos y las tasas ... y adjúntelo a un producto.',
                                        'fr' => 'Configurez la disponibilité du calendrier, les services, les remises, les taxes et les frais... et associez-le à un produit.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_WOO_TEXT2',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'Add bookings to cart and use WooCommerce Extensions for coupons, deposits and more.',
                                        'de' => 'Fügen Sie Buchungen in den Warenkorb und nutzen Sie WooCommerce Erweiterungen für Coupons, Einzahlungen und mehr.',
                                        'es' => 'Agregue reservas al carrito y use las extensiones de WooCommerce para cupones, depósitos y más.',
                                        'fr' => 'Ajoutez des réservations au panier et utilisez les extensions de WooCommerce pour les coupons, les dépôts et plus encore.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_WOO_TEXT3',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'All reservations and data is saved both in WooCommerce orders and Pinpoint',
                                        'de' => 'Alle Reservierungen und Daten werden sowohl in WooCommerce-Bestellungen als auch in Pinpoint gespeichert.',
                                        'es' => 'Todas las reservas y datos se guardan tanto en los pedidos de WooCommerce como en Pinpoint',
                                        'fr' => 'Toutes les réservations et données sont sauvegardées à la fois dans les commandes WooCommerce et dans Pinpoint.'));
                array_push($text, array('key' => 'WORDPRESS_BOOKING_FEATURES_WOO_TEXT4',
                                        'parent' => 'PARENT_PRO',
                                        'text' => 'And the most important part ... you can use all the payment gateways and other plugins offered by WooCommerce.',
                                        'de' => 'Und der wichtigste Teil... Sie können alle Zahlungs-Gateways und andere Plugins von WooCommerce nutzen.',
                                        'es' => 'Y lo más importante.... puede utilizar todas las pasarelas de pago y otros plugins ofrecidos por WooCommerce.',
                                        'fr' => 'Et le plus important... vous pouvez utiliser toutes les passerelles de paiement et autres plugins proposés par WooCommerce.'));
                
                return $text;
            }
        }
    }