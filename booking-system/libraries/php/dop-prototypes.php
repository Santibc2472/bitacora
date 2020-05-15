<?php

/*
* Title                   : DOP Prototypes (PHP class)
* Version                 : 1.0.3
* File                    : dop-prototypes.php
* File Version            : 1.0.3
* Created / Last Modified : 19 January 2016
* Author                  : Dot on Paper
* Copyright               : © 2014 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : List of general functions that we use at Dot on Paper.
* Licence                 : MIT
*/

    if (!class_exists('DOPPrototypes')){
        class DOPPrototypes{
            /*
             * Constructor
             */
            function __construct(){
            }
            
/*
 * Date/time 
 */         
            /*
             * Converts time to AM/PM format.
             * 
             * @param $time (string): time that will returned in format HH:MM
             * 
             * @return time to AM/PM format
             */
            function getAMPM($time){
                $time_pieces = explode(':', $time);
                $hour = (int)$time_pieces[0];
                $minutes = $time_pieces[1];
                $result = '';

                if ($hour == 0){
                    $result = '12';
                }
                else if ($hour > 12){
                    $result = $this->getLeadingZero($hour-12);
                }
                else{
                    $result = $this->getLeadingZero($hour);
                }

                $result .= ':'.$minutes.' '.($hour < 12 ? 'AM':'PM');

                return $result;
            }
            
            /*
             * Get hours list.
             * 
             * @param start_hour (string): start hour
             * @param end_hour (integer): end hour
             * @param diff (integer): difference between hours in minutes
             * 
             * @return array with hours
             */
            function getHours($start_hour = '00:00',
                              $end_hour = '23:59',
                              $diff = 5){
                $hours = array();
                $hour = '';
                $curr_hour = 0;
                $curr_minute = 0;
                
                array_push($hours, $start_hour);
                
                while ($hour < $end_hour && $hour < '23:59'){
                    $curr_minute += $diff;
                    
                    if ($curr_minute >= 60){
                        $curr_hour++;
                        $curr_minute = $curr_minute-60;
                    }
                    
                    $hour = $this->getLeadingZero($curr_hour).':'.$this->getLeadingZero($curr_minute);
                    $hour = $hour == '24:00' ? '23:59':$hour;
                    $hour >= $start_hour ? array_push($hours, $hour):'';
                }
                
                return $hours;
            }
            
            /*
             * Returns date in requested format.
             * 
             * @param $date (string): date that will be returned in format YYYY-MM-DD
             * @param $type (string): '1' for american ([month name] DD, YYYY)
             *                      : '2' for european (DD [month name] YYYY)
             * 
             * @return date to format
             */
            function setDateToFormat($date, 
                                     $type, 
                                     $month_names = array('January',
                                                          'February',
                                                          'March',
                                                          'April',
                                                          'May',
                                                          'June',
                                                          'July',
                                                          'August',
                                                          'September',
                                                          'October',
                                                          'November',
                                                          'December')){
                $dayPieces = explode('-', $date);

                if ($type == '1'){
                    return $month_names[(int)$dayPieces[1]-1].' '.$dayPieces[2].', '.$dayPieces[0];
                }
                else{
                    return $dayPieces[2].' '.$month_names[(int)$dayPieces[1]-1].' '.$dayPieces[0];
                }
            }
            
/*
 * String & numbers            
 */ 
            /*
             * Changes all characters from a string that are not in english alphabet to english alphabet.
             * 
             * @param string (string): the string
             * 
             * @return the string with all non-english characters changed
             */
            function getEnglishCharacters($string){
                $characters = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
                
                return str_replace(array_keys($characters), array_values($characters), $string);
            }
            
            /*
             * Adds a leading 0 if number smaller than 10.
             * 
             * @param no (integer): the number
             * 
             * @return number with leading 0 if needed
             */
            function getLeadingZero($no){
                if ($no < 10){
                    return '0'.$no;
                }
                else{
                    return $no;
                }
            }
            
            /*
             * Creates a string with random characters.
             * 
             * @param string_length (integer): the length of the returned string
             * @param allowed_characters (string): the string of allowed characters
             * 
             * @return random string
             */
            function getRandomString($string_length,
                                     $allowed_characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz'){
                $random_string = '';

                for ($i=0; $i<$string_length; $i++){
                    $characters_position = mt_rand(1, strlen($allowed_characters))-1;
                    $random_string .= $allowed_characters[$characters_position];
                }
                
                return $random_string;
            }
            
            /*
             * Returns a number with a predefined number of decimals.
             * 
             * @param number (float): the number
             * @param no (integer): the number of decimals
             * 
             * @return string with number and decimals
             */
            function getWithDecimals($number, 
                                     $no = 2){
                return (int)$number == $number ? (string)$number:number_format($number, $no, '.', '');
            }
            
            /*
             * Email validation.
             * 
             * @param email (string): email to be checked
             * 
             * @return true/false
             */
            function validEmail($email){
                if (preg_match("/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is", $email)){
                    return true;
                }
                else{
                    return false;
                }
            }
            
            function convertOldCurrency($id,$type = 'code'){
                $currency = '';
                
                $DOPBSP_currencies = array(
                    array(
                        'id' => 1,
                        'name' => 'Albania Lek',
                        'code' => 'ALL',
                        'sign' => '&#76;&#101;&#107;'
                    ),
                    array(
                        'id' => 2,
                        'name' => 'Afghanistan Afghani',
                        'code' => 'AFN',
                        'sign' => '&#1547;'
                    ),
                    array(
                        'id' => 3,
                        'name' => 'Argentina Peso',
                        'code' => 'ARS',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 4,
                        'name' => 'Aruba Guilder',
                        'code' => 'AWG',
                        'sign' => '&#402;'
                    ),
                    array(
                        'id' => 5,
                        'name' => 'Australia Dollar',
                        'code' => 'AUD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 6,
                        'name' => 'Azerbaijan New Manat',
                        'code' => 'AZN',
                        'sign' => '&#1084;&#1072;&#1085;'
                    ),
                    array(
                        'id' => 7,
                        'name' => 'Bahamas Dollar',
                        'code' => 'BSD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 8,
                        'name' => 'Barbados Dollar',
                        'code' => 'BBD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 9,
                        'name' => 'Belarus Ruble',
                        'code' => 'BYR',
                        'sign' => '&#112;&#46;'
                    ),
                    array(
                        'id' => 10,
                        'name' => 'Belize Dollar',
                        'code' => 'BZD',
                        'sign' => '&#66;&#90;&#36;'
                    ),
                    array(
                        'id' => 11,
                        'name' => 'Bermuda Dollar',
                        'code' => 'BMD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 12,
                        'name' => 'Bolivia Boliviano',
                        'code' => 'BOB',
                        'sign' => '&#36;&#98;'
                    ),
                    array(
                        'id' => 13,
                        'name' => 'Bosnia and Herzegovina Convertible Marka',
                        'code' => 'BAM',
                        'sign' => '&#75;&#77;'
                    ),
                    array(
                        'id' => 14,
                        'name' => 'Botswana Pula',
                        'code' => 'BWP',
                        'sign' => '&#80;'
                    ),
                    array(
                        'id' => 15,
                        'name' => 'Bulgaria Lev',
                        'code' => 'BGN',
                        'sign' => '&#1083;&#1074;'
                    ),
                    array(
                        'id' => 16,
                        'name' => 'Brazil Real',
                        'code' => 'BRL',
                        'sign' => '&#82;&#36;'
                    ),
                    array(
                        'id' => 17,
                        'name' => 'Brunei Darussalam Dollar',
                        'code' => 'BND',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 18,
                        'name' => 'Cambodia Riel',
                        'code' => 'KHR',
                        'sign' => '&#6107;'
                    ),
                    array(
                        'id' => 19,
                        'name' => 'Canada Dollar',
                        'code' => 'CAD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 20,
                        'name' => 'Cayman Islands Dollar',
                        'code' => 'KYD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 21,
                        'name' => 'Chile Peso',
                        'code' => 'CLP',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 22,
                        'name' => 'China Yuan Renminbi',
                        'code' => 'CNY',
                        'sign' => '&#165;'
                    ),
                    array(
                        'id' => 23,
                        'name' => 'Colombia Peso',
                        'code' => 'COP',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 24,
                        'name' => 'Costa Rica Colon',
                        'code' => 'CRC',
                        'sign' => '&#8353;'
                    ),
                    array(
                        'id' => 25,
                        'name' => 'Croatia Kuna',
                        'code' => 'HRK',
                        'sign' => '&#107;&#110;'
                    ),
                    array(
                        'id' => 26,
                        'name' => 'Cuba Peso',
                        'code' => 'CUP',
                        'sign' => '&#8369;'
                    ),
                    array(
                        'id' => 27,
                        'name' => 'Czech Republic Koruna',
                        'code' => 'CZK',
                        'sign' => '&#75;&#269;'
                    ),
                    array(
                        'id' => 28,
                        'name' => 'Denmark Krone',
                        'code' => 'DKK',
                        'sign' => '&#107;&#114;'
                    ),
                    array(
                        'id' => 29,
                        'name' => 'Dominican Republic Peso',
                        'code' => 'DOP',
                        'sign' => '&#82;&#68;&#36;'
                    ),
                    array(
                        'id' => 30,
                        'name' => 'East Caribbean Dollar',
                        'code' => 'XCD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 31,
                        'name' => 'Egypt Pound',
                        'code' => 'EGP',
                        'sign' => '&#163;'
                    ),
                    array(
                        'id' => 32,
                        'name' => 'El Salvador Colon',
                        'code' => 'SVC',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 33,
                        'name' => 'Estonia Kroon',
                        'code' => 'EEK',
                        'sign' => '&#107;&#114;'
                    ),
                    array(
                        'id' => 34,
                        'name' => 'Euro Member Countries',
                        'code' => 'EUR',
                        'sign' => '&#8364;'
                    ),
                    array(
                        'id' => 35,
                        'name' => 'Falkland Islands (Malvinas) Pound',
                        'code' => 'FKP',
                        'sign' => '&#163;'
                    ),
                    array(
                        'id' => 36,
                        'name' => 'Fiji Dollar',
                        'code' => 'FJD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 37,
                        'name' => 'Ghana Cedis',
                        'code' => 'GHC',
                        'sign' => '&#162;'
                    ),
                    array(
                        'id' => 38,
                        'name' => 'Gibraltar Pound',
                        'code' => 'GIP',
                        'sign' => '&#163;'
                    ),
                    array(
                        'id' => 39,
                        'name' => 'Guatemala Quetzal',
                        'code' => 'GTQ',
                        'sign' => '&#81;'
                    ),
                    array(
                        'id' => 40,
                        'name' => 'Guernsey Pound',
                        'code' => 'GGP',
                        'sign' => '&#163;'
                    ),
                    array(
                        'id' => 41,
                        'name' => 'Guyana Dollar',
                        'code' => 'GYD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 42,
                        'name' => 'Honduras Lempira',
                        'code' => 'HNL',
                        'sign' => '&#76;'
                    ),
                    array(
                        'id' => 43,
                        'name' => 'Hong Kong Dollar',
                        'code' => 'HKD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 44,
                        'name' => 'Hungary Forint',
                        'code' => 'HUF',
                        'sign' => '&#70;&#116;'
                    ),
                    array(
                        'id' => 45,
                        'name' => 'Iceland Krona',
                        'code' => 'ISK',
                        'sign' => '&#107;&#114;'
                    ),
                    array(
                        'id' => 46,
                        'name' => 'India Rupee',
                        'code' => 'INR',
                        'sign' => 'INR'
                    ),
                    array(
                        'id' => 47,
                        'name' => 'Indonesia Rupiah',
                        'code' => 'IDR',
                        'sign' => 'IDR'
                    ),
                    array(
                        'id' => 48,
                        'name' => 'Iran Rial',
                        'code' => 'IRR',
                        'sign' => '&#65020;'
                    ),
                    array(
                        'id' => 49,
                        'name' => 'Isle of Man Pound',
                        'code' => 'IMP',
                        'sign' => '&#163;'
                    ),
                    array(
                        'id' => 50,
                        'name' => 'Israel Shekel',
                        'code' => 'ILS',
                        'sign' => '&#8362;'
                    ),
                    array(
                        'id' => 51,
                        'name' => 'Jamaica Dollar',
                        'code' => 'JMD',
                        'sign' => '&#74;&#36;'
                    ),
                    array(
                        'id' => 52,
                        'name' => 'Japan Yen',
                        'code' => 'JPY',
                        'sign' => '&#165;'
                    ),
                    array(
                        'id' => 53,
                        'name' => 'Jersey Pound',
                        'code' => 'JEP',
                        'sign' => '&#163;'
                    ),
                    array(
                        'id' => 54,
                        'name' => 'Kazakhstan Tenge',
                        'code' => 'KZT',
                        'sign' => '&#1083;&#1074;'
                    ),
                    array(
                        'id' => 55,
                        'name' => 'Korea (North) Won',
                        'code' => 'KPW',
                        'sign' => '&#8361;'
                    ),
                    array(
                        'id' => 56,
                        'name' => 'Korea (South) Won',
                        'code' => 'KRW',
                        'sign' => '&#8361;'
                    ),
                    array(
                        'id' => 57,
                        'name' => 'Kyrgyzstan Som',
                        'code' => 'KGS',
                        'sign' => '&#1083;&#1074;'
                    ),
                    array(
                        'id' => 58,
                        'name' => 'Laos Kip',
                        'code' => 'LAK',
                        'sign' => '&#8365;'
                    ),
                    array(
                        'id' => 59,
                        'name' => 'Latvia Lat',
                        'code' => 'LVL',
                        'sign' => '&#76;&#115;'
                    ),
                    array(
                        'id' => 60,
                        'name' => 'Lebanon Pound',
                        'code' => 'LBP',
                        'sign' => '&#163;'
                    ),
                    array(
                        'id' => 61,
                        'name' => 'Liberia Dollar',
                        'code' => 'LRD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 62,
                        'name' => 'Lithuania Litas',
                        'code' => 'LTL',
                        'sign' => '&#76;&#116;'
                    ),
                    array(
                        'id' => 63,
                        'name' => 'Macedonia Denar',
                        'code' => 'MKD',
                        'sign' => '&#1076;&#1077;&#1085;'
                    ),

                    array(
                        'id' => 64,
                        'name' => 'Malaysia Ringgit',
                        'code' => 'MYR',
                        'sign' => '&#82;&#77;'
                    ),
                    array(
                        'id' => 65,
                        'name' => 'Mauritius Rupee',
                        'code' => 'MUR',
                        'sign' => '&#8360;'
                    ),
                    array(
                        'id' => 66,
                        'name' => 'Mexico Peso',
                        'code' => 'MXN',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 67,
                        'name' => 'Mongolia Tughrik',
                        'code' => 'MNT',
                        'sign' => '&#8366;'
                    ),
                    array(
                        'id' => 68,
                        'name' => 'Mozambique Metical',
                        'code' => 'MZN',
                        'sign' => '&#77;&#84;'
                    ),
                    array(
                        'id' => 69,
                        'name' => 'Namibia Dollar',
                        'code' => 'NAD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 70,
                        'name' => 'Nepal Rupee',
                        'code' => 'NPR',
                        'sign' => '&#8360;'
                    ),
                    array(
                        'id' => 71,
                        'name' => 'Netherlands Antilles Guilder',
                        'code' => 'ANG',
                        'sign' => '&#402;'
                    ),
                    array(
                        'id' => 72,
                        'name' => 'New Zealand Dollar',
                        'code' => 'NZD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 73,
                        'name' => 'Nicaragua Cordoba',
                        'code' => 'NIO',
                        'sign' => '&#67;&#36;'
                    ),
                    array(
                        'id' => 74,
                        'name' => 'Nigeria Naira',
                        'code' => 'NGN',
                        'sign' => '&#8358;'
                    ),
                    array(
                        'id' => 75,
                        'name' => 'Korea (North) Won',
                        'code' => 'KPW',
                        'sign' => '&#8361;'
                    ),
                    array(
                        'id' => 76,
                        'name' => 'Norway Krone',
                        'code' => 'NOK',
                        'sign' => '&#107;&#114;'
                    ),
                    array(
                        'id' => 77,
                        'name' => 'Oman Rial',
                        'code' => 'OMR',
                        'sign' => '&#65020;'
                    ),
                    array(
                        'id' => 78,
                        'name' => 'Pakistan Rupee',
                        'code' => 'PKR',
                        'sign' => '&#8360;'
                    ),
                    array(
                        'id' => 79,
                        'name' => 'Panama Balboa',
                        'code' => 'PAB',
                        'sign' => '&#66;&#47;&#46;'
                    ),
                    array(
                        'id' => 80,
                        'name' => 'Paraguay Guarani',
                        'code' => 'PYG',
                        'sign' => '&#71;&#115;'
                    ),
                    array(
                        'id' => 81,
                        'name' => 'Peru Nuevo Sol',
                        'code' => 'PEN',
                        'sign' => '&#83;&#47;&#46;'
                    ),
                    array(
                        'id' => 82,
                        'name' => 'Philippines Peso',
                        'code' => 'PHP',
                        'sign' => '&#8369;'
                    ),
                    array(
                        'id' => 83,
                        'name' => 'Poland Zloty',
                        'code' => 'PLN',
                        'sign' => '&#122;&#322;'
                    ),
                    array(
                        'id' => 84,
                        'name' => 'Qatar Riyal',
                        'code' => 'QAR',
                        'sign' => '&#65020;'
                    ),
                    array(
                        'id' => 85,
                        'name' => 'Romania New Leu',
                        'code' => 'RON',
                        'sign' => '&#108;&#101;&#105;'
                    ),
                    array(
                        'id' => 86,
                        'name' => 'Russia Ruble',
                        'code' => 'RUB',
                        'sign' => '&#1088;&#1091;&#1073;'
                    ),
                    array(
                        'id' => 87,
                        'name' => 'Saint Helena Pound',
                        'code' => 'SHP',
                        'sign' => '&#163;'
                    ),
                    array(
                        'id' => 88,
                        'name' => 'Saudi Arabia Riyal',
                        'code' => 'SAR',
                        'sign' => '&#65020;'
                    ),
                    array(
                        'id' => 89,
                        'name' => 'Serbia Dinar',
                        'code' => 'RSD',
                        'sign' => '&#1044;&#1080;&#1085;&#46;'
                    ),
                    array(
                        'id' => 90,
                        'name' => 'Seychelles Rupee',
                        'code' => 'SCR',
                        'sign' => '&#8360;'
                    ),
                    array(
                        'id' => 91,
                        'name' => 'Singapore Dollar',
                        'code' => 'SGD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 92,
                        'name' => 'Solomon Islands Dollar',
                        'code' => 'SBD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 93,
                        'name' => 'Somalia Shilling',
                        'code' => 'SOS',
                        'sign' => '&#83;'
                    ),
                    array(
                        'id' => 94,
                        'name' => 'South Africa Rand',
                        'code' => 'ZAR',
                        'sign' => '&#82;'
                    ),
                    array(
                        'id' => 95,
                        'name' => 'Korea (South) Won',
                        'code' => 'KRW',
                        'sign' => '&#8361;'
                    ),
                    array(
                        'id' => 96,
                        'name' => 'Sri Lanka Rupee',
                        'code' => 'LKR',
                        'sign' => '&#8360;'
                    ),
                    array(
                        'id' => 97,
                        'name' => 'Sweden Krona',
                        'code' => 'SEK',
                        'sign' => '&#107;&#114;'
                    ),
                    array(
                        'id' => 98,
                        'name' => 'Switzerland Franc',
                        'code' => 'CHF',
                        'sign' => '&#67;&#72;&#70;'
                    ),
                    array(
                        'id' => 99,
                        'name' => 'Suriname Dollar',
                        'code' => 'SRD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 100,
                        'name' => 'Syria Pound',
                        'code' => 'SYP',
                        'sign' => '&#163;'
                    ),
                    array(
                        'id' => 101,
                        'name' => 'Taiwan New Dollar',
                        'code' => 'TWD',
                        'sign' => '&#78;&#84;&#36;'
                    ),
                    array(
                        'id' => 102,
                        'name' => 'Thailand Baht',
                        'code' => 'THB',
                        'sign' => '&#3647;'
                    ),
                    array(
                        'id' => 103,
                        'name' => 'Trinidad and Tobago Dollar',
                        'code' => 'TTD',
                        'sign' => '&#84;&#84;&#36;'
                    ),
                    array(
                        'id' => 104,
                        'name' => 'Turkey Lira',
                        'code' => 'TRL',
                        'sign' => '&#8356;'
                    ),
                    array(
                        'id' => 105,
                        'name' => 'Tuvalu Dollar',
                        'code' => 'TVD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 106,
                        'name' => 'Ukraine Hryvna',
                        'code' => 'UAH',
                        'sign' => '&#8372;'
                    ),
                    array(
                        'id' => 107,
                        'name' => 'United Kingdom Pound',
                        'code' => 'GBP',
                        'sign' => '&#163;'
                    ),
                    array(
                        'id' => 108,
                        'name' => 'United States Dollar',
                        'code' => 'USD',
                        'sign' => '&#36;'
                    ),
                    array(
                        'id' => 109,
                        'name' => 'Uruguay Peso',
                        'code' => 'UYU',
                        'sign' => '&#36;&#85;'
                    ),
                    array(
                        'id' => 110,
                        'name' => 'Uzbekistan Som',
                        'code' => 'UZS',
                        'sign' => '&#1083;&#1074;'
                    ),
                    array(
                        'id' => 111,
                        'name' => 'Venezuela Bolivar Fuerte',
                        'code' => 'VEF',
                        'sign' => '&#66;&#115;'
                    ),
                    array(
                        'id' => 112,
                        'name' => 'Viet Nam Dong',
                        'code' => 'VND',
                        'sign' => '&#8363;'
                    ),
                    array(
                        'id' => 113,
                        'name' => 'Yemen Rial',
                        'code' => 'YER',
                        'sign' => '&#65020;'
                    ),
                    array(
                        'id' => 114,
                        'name' => 'Zimbabwe Dollar',
                        'code' => 'ZWD',
                        'sign' => '&#90;&#36;'
                    )
                );
                
                foreach ($DOPBSP_currencies as $DOPBSP_currency) {
                    
                    if ($id == $DOPBSP_currency['id']) {
                        
                        if ($type == 'code') {
                            $currency = $DOPBSP_currency['code'];
                        } else {
                            $currency = $DOPBSP_currency['sign'];
                        }
                    }
                }
                
                return $currency;
            }
        }
    }