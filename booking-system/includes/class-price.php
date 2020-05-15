<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/class-price.php
* File Version            : 1.0
* Created / Last Modified : 26 August 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Price PHP class.
*/

    if (!class_exists('DOPBSPPrice')){
        class DOPBSPPrice{
            /*
             * Constructor
             */
            function __construct(){
            }
            /*
             * Display price with currency in set format.
             * 
             * @param price (float): price value
             * @param currency (string): currency sign
             * @param position (string): currency position
             * 
             * @return price with currency
             */
            function set($price,
                         $currency,
                         $position = 'before'){
                global $DOPBSP;
                
                $price_displayed = '';
                $price = $DOPBSP->classes->prototypes->getWithDecimals(abs($price), 2);
                
                switch ($position){
                    case 'after':
                        $price_displayed =  $price.$currency;
                        break;
                    case 'after_with_space':
                        $price_displayed =  $price.' '.$currency;
                        break;
                    case 'before_with_space':
                        $price_displayed =  $currency.' '.$price;
                        break;
                    default:
                        $price_displayed = $currency.$price;
                }
                
                return $price_displayed;
            }
        }
    }