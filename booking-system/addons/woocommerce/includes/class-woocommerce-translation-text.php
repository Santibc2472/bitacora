<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.2
* File                    : addons/woocommerce/includes/class-woocommerce-translation-text.php
* File Version            : 1.0
* Created / Last Modified : 04 December 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : WooCommerce translation text PHP class.
*/

    if (!class_exists('DOPBSPWooCommerceTranslationText')){
        class DOPBSPWooCommerceTranslationText{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize WooCommerce text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'woocommerce'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'woocommerceHelp'));
            }
            
            /*
             * WooCommerce text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function woocommerce($text){
                array_push($text, array('key' => 'PARENT_WOOCOMMERCE',
                                        'parent' => '',
                                        'text' => 'WooCommerce'));
                /*
                 * Back end tab.
                 */
                array_push($text, array('key' => 'WOOCOMMERCE_TAB',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Pinpoint Booking System',
                                        'de' => 'Pinpoint Buchungssystem', // !
                                        'es' => 'Sistema de Reservas Pinpoint', //!
                                        'fr' => 'Pinpoint Booking System')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_CALENDAR',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Calendar',
                                        'de' => 'Kalender', // !
                                        'es' => 'Calendario', //!
                                        'fr' => 'Calendrier')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_CALENDAR_NO_CALENDARS',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'No calendars.',
                                        'de' => 'Keine Kalender.', // !
                                        'es' => 'Ningunos calendarios', //!
                                        'fr' => 'Aucun calendrier')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_CALENDAR_SELECT',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Select calendar',
                                        'de' => 'Wählen Sie den Kalender aus', // !
                                        'es' => 'Seleccione un calendario', //!
                                        'fr' => 'Choisissez un calendrier')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_LANGUAGE',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Language',
                                        'de' => 'Sprache', // !
                                        'es' => 'Lengua', //!
                                        'fr' => 'Langue')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_POSITION',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Position',
                                        'de' => 'Position', // !
                                        'es' => 'Posición', //!
                                        'fr' => 'Position')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_POSITION_SUMMARY',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Summary',
                                        'de' => 'Zusammenfassung', // !
                                        'es' => 'Resumen', //!
                                        'fr' => 'Résumé')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_POSITION_TABS',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Tabs',
                                        'de' => 'Registerkarten', // !
                                        'es' => 'Etiquetas', //!
                                        'fr' => 'Onglets')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_POSITION_SUMMARY_AND_TABS',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Summary & Tabs',
                                        'de' => 'Zusammenfassung & Registerkarten', // !
                                        'es' => 'Resumen y Etiquetas', //!
                                        'fr' => 'Résumé et Languettes')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_ADD_TO_CART',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Use the "Add To Cart" button from',
                                        'de' => 'Verwenden Sie die Schaltfläche "In den Warenkorb" von', // !
                                        'es' => 'Utilice el botón "Añadir a la Cesta" de', //!
                                        'fr' => 'Utilisez le bouton "Ajouter au panier" de')); //!
                
                /*
                 * Front end.
                 */
                array_push($text, array('key' => 'WOOCOMMERCE_VIEW_AVAILABILITY',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'View availability',
                                        'de' => 'Verfügbarkeit anzeigen', // !
                                        'es' => 'Vea la disponibilidad', //!
                                        'fr' => 'Considérez la disponibilité', //!
                                        'location' => 'woocommerce_frontend'));
                array_push($text, array('key' => 'WOOCOMMERCE_STARTING_FROM',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Starting from',
                                        'de' => 'Ausgehend von', // !
                                        'location' => 'woocommerce_frontend'));
                array_push($text, array('key' => 'WOOCOMMERCE_ADD_TO_CART',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Add to cart',
                                        'de' => 'Zum Warenkorb hinzufügen', // !
                                        'es' => 'Añada al carro', //!
                                        'fr' => 'Ajoutez au chariot', //!
                                        'location' => 'woocommerce_frontend'));
                array_push($text, array('key' => 'WOOCOMMERCE_TABS',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Book',
                                        'de' => 'Buchen', // !
                                        'es' => 'Reservar', //!
                                        'fr' => 'Réserver', //!
                                        'location' => 'woocommerce_frontend'));
                
                /*
                 * Messages
                 */
                array_push($text, array('key' => 'WOOCOMMERCE_VIEW_CART',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'View cart',
                                        'de' => 'Warenkorb anzeigen', // !
                                        'es' => 'reservar', //!
                                        'fr' => 'réserver', //!
                                        'location' => 'woocommerce_frontend'));
                array_push($text, array('key' => 'WOOCOMMERCE_SUCCESS',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'The reservation has been added to cart.',
                                        'de' => 'Die Reservierung wurde in den Warenkorb gelegt.', // !
                                        'es' => 'La reserva se ha añadido a la cesta.', //!
                                        'fr' => 'La réservation a été ajoutée au panier.', //!
                                        'location' => 'woocommerce_frontend'));
                array_push($text, array('key' => 'WOOCOMMERCE_UNAVAILABLE',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'The period you selected is not available anymore.',
                                        'de' => 'Der ausgewählte Zeitraum ist nicht mehr verfügbar.', // !
                                        'es' => 'El periodo seleccionado ya no está disponible.', //!
                                        'fr' => 'La période que vous avez sélectionnée n<<single-quote>>est plus disponible.', //!
                                        'location' => 'woocommerce_frontend'));
                array_push($text, array('key' => 'WOOCOMMERCE_OVERLAP',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'The period you selected will overlap with the ones you already added to cart. Please select another one.',
                                        'de' => 'Der ausgewählte Zeitraum überlappt sich mit dem Zeitraum, den Sie bereits in den Warenkorb gelegt haben. Wählen Sie eine andere aus.', // !
                                        'es' => 'El periodo que ha seleccionado se superpondrá con los que ya ha añadido a la cesta. Por favor, seleccione otro.', //!
                                        'fr' => 'La période que vous avez sélectionnée chevauchera celles que vous avez déjà ajoutées au panier. Veuillez en sélectionner une autre.', //!
                                        'location' => 'woocommerce_frontend'));
                array_push($text, array('key' => 'WOOCOMMERCE_DELETED',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'The reservation(s) has(have) been deleted from cart.',
                                        'de' => 'Die Reservierungen wurden aus dem Warenkorb gelöscht.', // !
                                        'es' => 'La reserva(s) (han) ha sido borrada del carrito.', //!
                                        'fr' => 'La ou les réservations ont été supprimées du panier.', //!
                                        'location' => 'woocommerce_frontend'));
                
                return $text;
            }
            
            /*
             * WooCommerce - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function woocommerceHelp($text){
                array_push($text, array('key' => 'PARENT_WOOCOMMERCE_HELP',
                                        'parent' => '',
                                        'text' => 'WooCommerce - Help'));
                
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_CALENDAR_HELP',
                                        'parent' => 'PARENT_WOOCOMMERCE_HELP',
                                        'text' => 'Select the calendar that you want associated with this product.',
                                        'de' => 'Wählen Sie den Kalender aus, der mit diesem Produkt verknüpft werden soll.', // !
                                        'es' => 'Seleccione el calendario que desea asociar con este producto.', //!
                                        'fr' => 'Sélectionnez le calendrier que vous souhaitez associer à ce produit.')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_LANGUAGE_HELP',
                                        'parent' => 'PARENT_WOOCOMMERCE_HELP',
                                        'text' => 'Select the language for the calendar.',
                                        'de' => 'Wählen Sie die Sprache für den Kalender aus.', // !
                                        'es' => 'Seleccione el idioma para el calendario.', //!
                                        'fr' => 'Sélectionnez la langue du calendrier.')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_POSITION_HELP',
                                        'parent' => 'PARENT_WOOCOMMERCE_HELP',
                                        'text' => 'Select the calendar position. Add it in "product summary", "product tabs" or add the form in "summary" and the calendar in "product tabs".',
                                        'de' => 'Wählen Sie die Kalenderposition aus. Fügen Sie es in "Produktzusammenfassung", "Produktregisterkarten" oder fügen Sie das Formular in "Zusammenfassung" und den Kalender in "Produktregisterkarten" hinzu.', // !
                                        'es' => 'Sélectionnez la position du calendrier. Ajoutez-le dans "product summary", "product tabs" ou ajoutez le formulaire dans "summary" et le calendrier dans "product tabs".', //!
                                        'fr' => 'Sélectionnez la position du calendrier. Ajoutez-le dans "product summary", "product tabs" ou ajoutez le formulaire dans "summary" et le calendrier dans "product tabs".')); //!
                array_push($text, array('key' => 'WOOCOMMERCE_TAB_ADD_TO_CART_HELP',
                                        'parent' => 'PARENT_WOOCOMMERCE_HELP',
                                        'text' => 'Select to choose to use Pinpoint Booking System<<single-quote>>s "Add to cart" button, or WooCommerce default button.',
                                        'de' => 'Wählen Sie diese Option aus, um die Schaltfläche "In den Warenkorb legen" des Pinpoint Buchungssystems oder die Schaltfläche WooCommerce Standard zu verwenden.', // !
                                        'es' => 'Seleccione el botón "Añadir a la cesta" del Sistema de Reservas Pinpoint, o el botón predeterminado de WooCommerce.', //!
                                        'fr' => 'Choisissez d<<single-quote>>utiliser le bouton "Ajouter au panier" de Pinpoint Booking System ou le bouton par défaut de Woocommerce.')); //!
                
                return $text;
            }
        }
    }