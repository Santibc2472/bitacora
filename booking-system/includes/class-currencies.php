<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.1
* File                    : includes/class-currencies.php
* File Version            : 1.0.2
* Created / Last Modified : 02 January 2015
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Currencies PHP class.
*/

    if (!class_exists('DOPBSPCurrencies')){
        class DOPBSPCurrencies{
            /*
             * Currencies list.
             */
            public $currencies = array();
            
            /*
             * Constructor
             */
            function __construct(){
                add_filter('dopbsp_filter_currencies', array(&$this, 'set'));
                add_action('init', array(&$this, 'init'));
            }
            
            /*
             * Initialize currencies.
             */
            function init(){
                $this->currencies = apply_filters('dopbsp_filter_currencies', $this->currencies);
            }
            
            /*
             * Get currency.
             * 
             * @param code (string): currency code
             * @param field (string): currency field
             * 
             * @return currency field value
             */
            function get($code = 'USD',
                         $field = 'sign'){
                $field_value = '&#36;';
                
                for ($i=0; $i<count($this->currencies); $i++){
                    if ($this->currencies[$i]['code'] == $code){
                        $field_value = $this->currencies[$i][$field];
                        break;
                    }
                }
                
                return $field_value;
            }
            
            /*
             * Set currencies.
             * 
             * @param currencies (array): initial currencies list 
             * 
             * @return currencies array
             */
            function set($currencies){
                array_push($currencies, array('code' => 'AFN',
                                              'name' => 'Afghanistan Afghani',
                                              'sign' => '&#1547;'));
                array_push($currencies, array('code' => 'ALL',
                                              'name' => 'Albania Lek',
                                              'sign' => '&#76;&#101;&#107;'));
                array_push($currencies, array('code' => 'DZD',
                                              'name' => 'Algeria Dinar',
                                              'sign' => 'دج'));
                array_push($currencies, array('code' => 'ARS',
                                              'name' => 'Argentina Peso',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'AMD',
                                              'name' => 'Armenian Dram',
                                              'sign' => '&#1423;'));
                array_push($currencies, array('code' => 'AWG',
                                              'name' => 'Aruba Guilder',
                                              'sign' => '&#402;'));
                array_push($currencies, array('code' => 'AUD',
                                              'name' => 'Australia Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'AZN',
                                              'name' => 'Azerbaijan New Manat',
                                              'sign' => '&#1084;&#1072;&#1085;'));
                array_push($currencies, array('code' => 'BSD',
                                              'name' => 'Bahamas Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'BDT',
                                              'name' => 'Bangladesh Taka',
                                              'sign' => '&#2547;'));
                array_push($currencies, array('code' => 'BBD',
                                              'name' => 'Barbados Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'BYR',
                                              'name' => 'Belarus Ruble',
                                              'sign' => '&#112;&#46;'));
                array_push($currencies, array('code' => 'BZD',
                                              'name' => 'Belize Dollar',
                                              'sign' => '&#66;&#90;&#36;'));
                array_push($currencies, array('code' => 'BMD',
                                              'name' => 'Bermuda Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'BOB',
                                              'name' => 'Bolivia Boliviano',
                                              'sign' => '&#36;&#98;'));
                array_push($currencies, array('code' => 'BAM',
                                              'name' => 'Bosnia and Herzegovina Convertible Marka',
                                              'sign' => '&#75;&#77;'));
                array_push($currencies, array('code' => 'BWP',
                                              'name' => 'Botswana Pula',
                                              'sign' => '&#80;'));
                array_push($currencies, array('code' => 'BGN',
                                              'name' => 'Bulgaria Lev',
                                              'sign' => '&#1083;&#1074;'));
                array_push($currencies, array('code' => 'BRL',
                                              'name' => 'Brazil Real',
                                              'sign' => '&#82;&#36;'));
                array_push($currencies, array('code' => 'BND',
                                              'name' => 'Brunei Darussalam Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'KHR',
                                              'name' => 'Cambodia Riel',
                                              'sign' => '&#6107;'));
                array_push($currencies, array('code' => 'CAD',
                                              'name' => 'Canada Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'KYD',
                                              'name' => 'Cayman Islands Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'CLP',
                                              'name' => 'Chile Peso',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'CNY',
                                              'name' => 'China Yuan Renminbi',
                                              'sign' => '&#165;'));
                array_push($currencies, array('code' => 'COP',
                                              'name' => 'Colombia Peso',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'CRC',
                                              'name' => 'Costa Rica Colon',
                                              'sign' => '&#8353;'));
                array_push($currencies, array('code' => 'HRK',
                                              'name' => 'Croatia Kuna',
                                              'sign' => '&#107;&#110;'));
                array_push($currencies, array('code' => 'CUP',
                                              'name' => 'Cuba Peso',
                                              'sign' => '&#8369;'));
                array_push($currencies, array('code' => 'CZK',
                                              'name' => 'Czech Republic Koruna',
                                              'sign' => '&#75;&#269;'));
                array_push($currencies, array('code' => 'DKK',
                                              'name' => 'Denmark Krone',
                                              'sign' => '&#107;&#114;'));
                array_push($currencies, array('code' => 'DOP',
                                              'name' => 'Dominican Republic Peso',
                                              'sign' => '&#82;&#68;&#36;'));
                array_push($currencies, array('code' => 'XCD',
                                              'name' => 'East Caribbean Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'EGP',
                                              'name' => 'Egypt Pound',
                                              'sign' => '&#163;'));
                array_push($currencies, array('code' => 'SVC',
                                              'name' => 'El Salvador Colon',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'EEK',
                                              'name' => 'Estonia Kroon',
                                              'sign' => '&#107;&#114;'));
                array_push($currencies, array('code' => 'EUR',
                                              'name' => 'Euro Member Countries',
                                              'sign' => '&#8364;'));
                array_push($currencies, array('code' => 'FKP',
                                              'name' => 'Falkland Islands (Malvinas) Pound',
                                              'sign' => '&#163;'));
                array_push($currencies, array('code' => 'FJD',
                                              'name' => 'Fiji Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'GHC',
                                              'name' => 'Ghana Cedis',
                                              'sign' => '&#162;'));
                array_push($currencies, array('code' => 'GIP',
                                              'name' => 'Gibraltar Pound',
                                              'sign' => '&#163;'));
                array_push($currencies, array('code' => 'GTQ',
                                              'name' => 'Guatemala Quetzal',
                                              'sign' => '&#81;'));
                array_push($currencies, array('code' => 'GGP',
                                              'name' => 'Guernsey Pound',
                                              'sign' => '&#163;'));
                array_push($currencies, array('code' => 'GYD',
                                              'name' => 'Guyana Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'HNL',
                                              'name' => 'Honduras Lempira',
                                              'sign' => '&#76;'));
                array_push($currencies, array('code' => 'HKD',
                                              'name' => 'Hong Kong Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'HUF',
                                              'name' => 'Hungary Forint',
                                              'sign' => '&#70;&#116;'));
                array_push($currencies, array('code' => 'ISK',
                                              'name' => 'Iceland Krona',
                                              'sign' => '&#107;&#114;'));
                array_push($currencies, array('code' => 'INR',
                                              'name' => 'India Rupee',
                                              'sign' => 'INR'));
                array_push($currencies, array('code' => 'IDR',
                                              'name' => 'Indonesia Rupiah',
                                              'sign' => 'IDR'));
                array_push($currencies, array('code' => 'IRR',
                                              'name' => 'Iran Rial',
                                              'sign' => '&#65020;'));
                array_push($currencies, array('code' => 'IMP',
                                              'name' => 'Isle of Man Pound',
                                              'sign' => '&#163;'));
                array_push($currencies, array('code' => 'ILS',
                                              'name' => 'Israel Shekel',
                                              'sign' => '&#8362;'));
                array_push($currencies, array('code' => 'JMD',
                                              'name' => 'Jamaica Dollar',
                                              'sign' => '&#74;&#36;'));
                array_push($currencies, array('code' => 'JPY',
                                              'name' => 'Japan Yen',
                                              'sign' => '&#165;'));
                array_push($currencies, array('code' => 'JEP',
                                              'name' => 'Jersey Pound',
                                              'sign' => '&#163;'));
                array_push($currencies, array('code' => 'KZT',
                                              'name' => 'Kazakhstan Tenge',
                                              'sign' => '&#8376;')); 
                array_push($currencies, array('code' => 'KES',
                                              'name' => 'Kenya Shilling',
                                              'sign' => 'KSh'));
                array_push($currencies, array('code' => 'KPW',
                                              'name' => 'Korea (North) Won',
                                              'sign' => '&#8361;'));
                array_push($currencies, array('code' => 'KRW',
                                              'name' => 'Korea (South) Won',
                                              'sign' => '&#8361;'));
                array_push($currencies, array('code' => 'KGS',
                                              'name' => 'Kyrgyzstan Som',
                                              'sign' => '&#1083;&#1074;'));
                array_push($currencies, array('code' => 'LAK',
                                              'name' => 'Laos Kip',
                                              'sign' => '&#8365;'));
                array_push($currencies, array('code' => 'LVL',
                                              'name' => 'Latvia Lat',
                                              'sign' => '&#76;&#115;'));
                array_push($currencies, array('code' => 'LBP',
                                              'name' => 'Lebanon Pound',
                                              'sign' => '&#163;'));
                array_push($currencies, array('code' => 'LRD',
                                              'name' => 'Liberia Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'LTL',
                                              'name' => 'Lithuania Litas',
                                              'sign' => '&#76;&#116;'));
                array_push($currencies, array('code' => 'MKD',
                                              'name' => 'Macedonia Denar',
                                              'sign' => '&#1076;&#1077;&#1085;'));
                array_push($currencies, array('code' => 'MYR',
                                              'name' => 'Malaysia Ringgit',
                                              'sign' => '&#82;&#77;'));
                array_push($currencies, array('code' => 'MUR',
                                              'name' => 'Mauritius Rupee',
                                              'sign' => '&#8360;'));
                array_push($currencies, array('code' => 'MXN',
                                              'name' => 'Mexico Peso',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'MNT',
                                              'name' => 'Mongolia Tughrik',
                                              'sign' => '&#8366;'));
                array_push($currencies, array('code' => 'MAD',
                                              'name' => 'Moroccan Dirham',
                                              'sign' => '&#68;&#72;'));
                array_push($currencies, array('code' => 'MZN',
                                              'name' => 'Mozambique Metical',
                                              'sign' => '&#77;&#84;'));
                array_push($currencies, array('code' => 'NAD',
                                              'name' => 'Namibia Dollar',
                                              'sign' => 'N&#36;'));
                array_push($currencies, array('code' => 'NPR',
                                              'name' => 'Nepal Rupee',
                                              'sign' => '&#8360;'));
                array_push($currencies, array('code' => 'ANG',
                                              'name' => 'Netherlands Antilles Guilder',
                                              'sign' => '&#402;'));
                array_push($currencies, array('code' => 'NZD',
                                              'name' => 'New Zealand Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'NIO',
                                              'name' => 'Nicaragua Cordoba',
                                              'sign' => '&#67;&#36;'));
                array_push($currencies, array('code' => 'NGN',
                                              'name' => 'Nigeria Naira',
                                              'sign' => '&#8358;'));
                array_push($currencies, array('code' => 'KPW',
                                              'name' => 'Korea (North) Won',
                                              'sign' => '&#8361;'));
                array_push($currencies, array('code' => 'NOK',
                                              'name' => 'Norway Krone',
                                              'sign' => '&#107;&#114;'));
                array_push($currencies, array('code' => 'OMR',
                                              'name' => 'Oman Rial',
                                              'sign' => '&#65020;'));
                array_push($currencies, array('code' => 'PKR',
                                              'name' => 'Pakistan Rupee',
                                              'sign' => '&#8360;'));
                array_push($currencies, array('code' => 'PAB',
                                              'name' => 'Panama Balboa',
                                              'sign' => '&#66;&#47;&#46;'));
                array_push($currencies, array('code' => 'PYG',
                                              'name' => 'Paraguay Guarani',
                                              'sign' => '&#71;&#115;'));
                array_push($currencies, array('code' => 'PEN',
                                              'name' => 'Peru Nuevo Sol',
                                              'sign' => '&#83;&#47;&#46;'));
                array_push($currencies, array('code' => 'PHP',
                                              'name' => 'Philippines Peso',
                                              'sign' => '&#8369;'));
                array_push($currencies, array('code' => 'PLN',
                                              'name' => 'Poland Zloty',
                                              'sign' => '&#122;&#322;'));
                array_push($currencies, array('code' => 'QAR',
                                              'name' => 'Qatar Riyal',
                                              'sign' => '&#65020;'));
                array_push($currencies, array('code' => 'RON',
                                              'name' => 'Romania New Leu',
                                              'sign' => '&#108;&#101;&#105;'));
                array_push($currencies, array('code' => 'RUB',
                                              'name' => 'Russia Ruble',
                                              'sign' => '&#1088;&#1091;&#1073;'));
                array_push($currencies, array('code' => 'SHP',
                                              'name' => 'Saint Helena Pound',
                                              'sign' => '&#163;'));
                array_push($currencies, array('code' => 'SAR',
                                              'name' => 'Saudi Arabia Riyal',
                                              'sign' => '&#65020;'));
                array_push($currencies, array('code' => 'RSD',
                                              'name' => 'Serbia Dinar',
                                              'sign' => '&#1044;&#1080;&#1085;&#46;'));
                array_push($currencies, array('code' => 'SCR',
                                              'name' => 'Seychelles Rupee',
                                              'sign' => '&#8360;'));
                array_push($currencies, array('code' => 'SGD',
                                              'name' => 'Singapore Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'SBD',
                                              'name' => 'Solomon Islands Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'SOS',
                                              'name' => 'Somalia Shilling',
                                              'sign' => '&#83;'));
                array_push($currencies, array('code' => 'ZAR',
                                              'name' => 'South Africa Rand',
                                              'sign' => '&#82;'));
                array_push($currencies, array('code' => 'KRW',
                                              'name' => 'Korea (South) Won',
                                              'sign' => '&#8361;'));
                array_push($currencies, array('code' => 'LKR',
                                              'name' => 'Sri Lanka Rupee',
                                              'sign' => '&#8360;'));
                array_push($currencies, array('code' => 'SEK',
                                              'name' => 'Sweden Krona',
                                              'sign' => '&#107;&#114;'));
                array_push($currencies, array('code' => 'CHF',
                                              'name' => 'Switzerland Franc',
                                              'sign' => '&#67;&#72;&#70;'));
                array_push($currencies, array('code' => 'SRD',
                                              'name' => 'Suriname Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'SYP',
                                              'name' => 'Syria Pound',
                                              'sign' => '&#163;'));
                array_push($currencies, array('code' => 'TWD',
                                              'name' => 'Taiwan New Dollar',
                                              'sign' => '&#78;&#84;&#36;'));
                array_push($currencies, array('code' => 'THB',
                                              'name' => 'Thailand Baht',
                                              'sign' => '&#3647;'));
                array_push($currencies, array('code' => 'TTD',
                                              'name' => 'Trinidad and Tobago Dollar',
                                              'sign' => '&#84;&#84;&#36;'));
                array_push($currencies, array('code' => 'TRL',
                                              'name' => 'Turkey Lira',
                                              'sign' => '&#8356;'));
                array_push($currencies, array('code' => 'TVD',
                                              'name' => 'Tuvalu Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'AED',
                                              'name' => 'UAE Dirham',
                                              'sign' => 'د.إ'));
                array_push($currencies, array('code' => 'UAH',
                                              'name' => 'Ukraine Hryvna',
                                              'sign' => '&#8372;'));
                array_push($currencies, array('code' => 'GBP',
                                              'name' => 'United Kingdom Pound',
                                              'sign' => '&#163;'));
                array_push($currencies, array('code' => 'USD',
                                              'name' => 'United States Dollar',
                                              'sign' => '&#36;'));
                array_push($currencies, array('code' => 'UYU',
                                              'name' => 'Uruguay Peso',
                                              'sign' => '&#36;&#85;'));
                array_push($currencies, array('code' => 'UZS',
                                              'name' => 'Uzbekistan Som',
                                              'sign' => '&#1083;&#1074;'));
                array_push($currencies, array('code' => 'VUV',
                                              'name' => 'Vanuatu vatu',
                                              'sign' => '&#86;&#84;'));
                array_push($currencies, array('code' => 'VEF',
                                              'name' => 'Venezuela Bolivar Fuerte',
                                              'sign' => '&#66;&#115;'));
                array_push($currencies, array('code' => 'VND',
                                              'name' => 'Viet Nam Dong',
                                              'sign' => '&#8363;'));
                array_push($currencies, array('code' => 'YER',
                                              'name' => 'Yemen Rial',
                                              'sign' => '&#65020;'));
                array_push($currencies, array('code' => 'ZWD',
                                              'name' => 'Zimbabwe Dollar',
                                              'sign' => '&#90;&#36;'));
                
                return $currencies;
            }
        }
    }