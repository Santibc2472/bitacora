<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/translation/class-translation-text-cart.php
* File Version            : 1.0.3
* Created / Last Modified : 26 August 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Car translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextCart')){
        class DOPBSPTranslationTextCart{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize order text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'cart'));
            }

            /*
             * Cart text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function cart($text){
                array_push($text, array('key' => 'PARENT_CART',
                                        'parent' => '',
                                        'text' => 'Cart'));
                
                array_push($text, array('key' => 'CART_TITLE',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'Cart',
                                        'de' => 'Warenkorb', // !
                                        'es' => 'Carrito', // !
                                        'fr' => 'Panier',
                                        'location' => 'all'));
                array_push($text, array('key' => 'CART_IS_EMPTY',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'Cart is empty.',
                                        'de' => 'Warenkorb ist leer.', // !
                                        'es' => 'Carrito está vacío', // !
                                        'fr' => 'Panier est vide.', //!
                                        'location' => 'all'));
                
                array_push($text, array('key' => 'CART_ERROR',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'Error',
                                        'de' => 'Fehler', // !
                                        'es' => 'Error', // !
                                        'fr' => 'Erreur',
                                        'location' => 'all'));
                array_push($text, array('key' => 'CART_UNAVAILABLE',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'The period you selected is not available anymore. Please review your reservations.',
                                        'de' => 'Der ausgewählte Zeitraum ist nicht mehr verfügbar. Bitte überprüfen Sie Ihre Reservierungen.', // !
                                        'es' => 'El periodo seleccionado ya no está disponible. Por favor, revise sus reservas.', // !
                                        'fr' => 'La période que vous avez sélectionnée n’est plus disponible. Veuillez examiner vos réservations.', //!
                                        'location' => 'all'));
                array_push($text, array('key' => 'CART_OVERLAP',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'The period you selected will overlap with the ones you already added to cart. Please select another one.',
                                        'de' => 'Der ausgewählte Zeitraum überlappt sich mit dem Zeitraum, den Sie bereits in den Warenkorb gelegt haben. Wählen Sie eine andere aus.', // !
                                        'es' => 'El periodo que ha seleccionado se superpondrá con los que ya ha añadido a la cesta. Por favor, seleccione otro.', // !
                                        'fr' => 'La période que vous avez sélectionnée chevauchera celles que vous avez déjà ajoutées au panier. Veuillez en sélectionner une autre.', //!
                                        'location' => 'all'));
                
                return $text;
            }
        }
    }