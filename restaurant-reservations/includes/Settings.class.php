<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'rtbSettings' ) ) {
/**
 * Class to handle configurable settings for Restaurant Reservations
 *
 * @since 0.0.1
 */
class rtbSettings {

	/**
	 * Default values for settings
	 * @since 0.0.1
	 */
	public $defaults = array();

	/**
	 * Stored values for settings
	 * @since 0.0.1
	 */
	public $settings = array();

	/**
	 * Languages supported by the pickadate library
	 */
	public $supported_i8n = array(
		'ar'	=> 'ar',
		'bg_BG'	=> 'bg_BG',
		'bs_BA'	=> 'bs_BA',
		'ca_ES'	=> 'ca_ES',
		'cs_CZ'	=> 'cs_CZ',
		'da_DK'	=> 'da_DK',
		'de_DE'	=> 'de_DE',
		'el_GR'	=> 'el_GR',
		'es_ES'	=> 'es_ES',
		'et_EE'	=> 'et_EE',
		'eu_ES'	=> 'eu_ES',
		'fa_IR'	=> 'fa_IR',
		'fi_FI'	=> 'fi_FI',
		'fr_FR'	=> 'fr_FR',
		'gl_ES'	=> 'gl_ES',
		'he_IL'	=> 'he_IL',
		'hi_IN'	=> 'hi_IN',
		'hr_HR'	=> 'hr_HR',
		'hu_HU'	=> 'hu_HU',
		'id_ID'	=> 'id_ID',
		'is_IS'	=> 'is_IS',
		'it_IT'	=> 'it_IT',
		'ja_JP'	=> 'ja_JP',
		'ko_KR'	=> 'ko_KR',
		'lt_LT'	=> 'lt_LT',
		'lv_LV'	=> 'lv_LV',
		'nb_NO'	=> 'nb_NO',
		'ne_NP'	=> 'ne_NP',
		'nl_NL'	=> 'nl_NL',
		'no_NO'	=> 'no_NO', // Old norwegian translation kept for backwards compatibility
		'pl_PL'	=> 'pl_PL',
		'pt_BR'	=> 'pt_BR',
		'pt_PT'	=> 'pt_PT',
		'ro_RO'	=> 'ro_RO',
		'ru_RU'	=> 'ru_RU',
		'sk_SK'	=> 'sk_SK',
		'sl_SI'	=> 'sl_SI',
		'sv_SE'	=> 'sv_SE',
		'th_TH'	=> 'th_TH',
		'tr_TR'	=> 'tr_TR',
		'uk_UA'	=> 'uk_UA',
		'zh_CN'	=> 'zh_CN',
		'zh_TW'	=> 'zh_TW',
	);

	/**
	 * Currencies accepted for deposits
	 */
	public $currency_options = array(
		'AUD' => 'Australian Dollar',
		'BRL' => 'Brazilian Real',
		'CAD' => 'Canadian Dollar',
		'CZK' => 'Czech Koruna',
		'DKK' => 'Danish Krone',
		'EUR' => 'Euro',
		'HKD' => 'Hong Kong Dollar',
		'HUF' => 'Hungarian Forint',
		'ILS' => 'Israeli New Sheqel',
		'JPY' => 'Japanese Yen',
		'MYR' => 'Malaysian Ringgit',
		'MXN' => 'Mexican Peso',
		'NOK' => 'Norwegian Krone',
		'NZD' => 'New Zealand Dollar',
		'PHP' => 'Philippine Peso',
		'PLN' => 'Polish Zloty',
		'GBP' => 'Pound Sterling',
		'RUB' => 'Russian Ruble',
		'SGD' => 'Singapore Dollar',
		'SEK' => 'Swedish Krona',
		'CHF' => 'Swiss Franc',
		'TWD' => 'Taiwan New Dollar',
		'THB' => 'Thai Baht',
		'TRY' => 'Turkish Lira',
		'USD' => 'U.S. Dollar',			
	);

	public $country_phone_array = array(
		// 'AD' => array( 'name' => 'ANDORRA', 'code' => '376' ),
		// 'AE' => array( 'name' => 'UNITED ARAB EMIRATES', 'code' => '971' ),
		// 'AF' => array( 'name' => 'AFGHANISTAN', 'code' => '93' ),
		// 'AG' => array( 'name' => 'ANTIGUA AND BARBUDA', 'code' => '1268' ),
		// 'AI' => array( 'name' => 'ANGUILLA', 'code' => '1264' ),
		// 'AL' => array( 'name' => 'ALBANIA', 'code' => '355' ),
		// 'AM' => array( 'name' => 'ARMENIA', 'code' => '374' ),
		// 'AN' => array( 'name' => 'NETHERLANDS ANTILLES', 'code' => '599' ),
		// 'AO' => array( 'name' => 'ANGOLA', 'code' => '244' ),
		// 'AQ' => array( 'name' => 'ANTARCTICA', 'code' => '672' ),
		'AR' => array( 'name' => 'ARGENTINA', 'code' => '54' ),
		// 'AS' => array( 'name' => 'AMERICAN SAMOA', 'code' => '1684' ),
		'AT' => array( 'name' => 'AUSTRIA', 'code' => '43' ),
		'AU' => array( 'name' => 'AUSTRALIA', 'code' => '61' ),
		// 'AW' => array( 'name' => 'ARUBA', 'code' => '297' ),
		// 'AZ' => array( 'name' => 'AZERBAIJAN', 'code' => '994' ),
		// 'BA' => array( 'name' => 'BOSNIA AND HERZEGOVINA', 'code' => '387' ),
		// 'BB' => array( 'name' => 'BARBADOS', 'code' => '1246' ),
		// 'BD' => array( 'name' => 'BANGLADESH', 'code' => '880' ),
		'BE' => array( 'name' => 'BELGIUM', 'code' => '32' ),
		// 'BF' => array( 'name' => 'BURKINA FASO', 'code' => '226' ),
		'BG' => array( 'name' => 'BULGARIA', 'code' => '359' ),
		// 'BH' => array( 'name' => 'BAHRAIN', 'code' => '973' ),
		// 'BI' => array( 'name' => 'BURUNDI', 'code' => '257' ),
		// 'BJ' => array( 'name' => 'BENIN', 'code' => '229' ),
		// 'BL' => array( 'name' => 'SAINT BARTHELEMY', 'code' => '590' ),
		// 'BM' => array( 'name' => 'BERMUDA', 'code' => '1441' ),
		// 'BN' => array( 'name' => 'BRUNEI DARUSSALAM', 'code' => '673' ),
		// 'BO' => array( 'name' => 'BOLIVIA', 'code' => '591' ),
		'BR' => array( 'name' => 'BRAZIL', 'code' => '55' ),
		// 'BS' => array( 'name' => 'BAHAMAS', 'code' => '1242' ),
		// 'BT' => array( 'name' => 'BHUTAN', 'code' => '975' ),
		// 'BW' => array( 'name' => 'BOTSWANA', 'code' => '267' ),
		// 'BY' => array( 'name' => 'BELARUS', 'code' => '375' ),
		// 'BZ' => array( 'name' => 'BELIZE', 'code' => '501' ),
		'CA' => array( 'name' => 'CANADA', 'code' => '1' ),
		// 'CC' => array( 'name' => 'COCOS (KEELING) ISLANDS', 'code' => '61' ),
		// 'CD' => array( 'name' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'code' => '243' ),
		// 'CF' => array( 'name' => 'CENTRAL AFRICAN REPUBLIC', 'code' => '236' ),
		// 'CG' => array( 'name' => 'CONGO', 'code' => '242' ),
		'CH' => array( 'name' => 'SWITZERLAND', 'code' => '41' ),
		// 'CI' => array( 'name' => 'COTE D IVOIRE', 'code' => '225' ),
		// 'CK' => array( 'name' => 'COOK ISLANDS', 'code' => '682' ),
		// 'CL' => array( 'name' => 'CHILE', 'code' => '56' ),
		// 'CM' => array( 'name' => 'CAMEROON', 'code' => '237' ),
		'CN' => array( 'name' => 'CHINA', 'code' => '86' ),
		// 'CO' => array( 'name' => 'COLOMBIA', 'code' => '57' ),
		// 'CR' => array( 'name' => 'COSTA RICA', 'code' => '506' ),
		// 'CU' => array( 'name' => 'CUBA', 'code' => '53' ),
		// 'CV' => array( 'name' => 'CAPE VERDE', 'code' => '238' ),
		// 'CX' => array( 'name' => 'CHRISTMAS ISLAND', 'code' => '61' ),
		// 'CY' => array( 'name' => 'CYPRUS', 'code' => '357' ),
		'CZ' => array( 'name' => 'CZECH REPUBLIC', 'code' => '420' ),
		'DE' => array( 'name' => 'GERMANY', 'code' => '49' ),
		// 'DJ' => array( 'name' => 'DJIBOUTI', 'code' => '253' ),
		'DK' => array( 'name' => 'DENMARK', 'code' => '45' ),
		// 'DM' => array( 'name' => 'DOMINICA', 'code' => '1767' ),
		// 'DO' => array( 'name' => 'DOMINICAN REPUBLIC', 'code' => '1809' ),
		// 'DZ' => array( 'name' => 'ALGERIA', 'code' => '213' ),
		// 'EC' => array( 'name' => 'ECUADOR', 'code' => '593' ),
		'EE' => array( 'name' => 'ESTONIA', 'code' => '372' ),
		// 'EG' => array( 'name' => 'EGYPT', 'code' => '20' ),
		// 'ER' => array( 'name' => 'ERITREA', 'code' => '291' ),
		'ES' => array( 'name' => 'SPAIN', 'code' => '34' ),
		// 'ET' => array( 'name' => 'ETHIOPIA', 'code' => '251' ),
		'FI' => array( 'name' => 'FINLAND', 'code' => '358' ),
		// 'FJ' => array( 'name' => 'FIJI', 'code' => '679' ),
		// 'FK' => array( 'name' => 'FALKLAND ISLANDS (MALVINAS)', 'code' => '500' ),
		// 'FM' => array( 'name' => 'MICRONESIA, FEDERATED STATES OF', 'code' => '691' ),
		// 'FO' => array( 'name' => 'FAROE ISLANDS', 'code' => '298' ),
		'FR' => array( 'name' => 'FRANCE', 'code' => '33' ),
		// 'GA' => array( 'name' => 'GABON', 'code' => '241' ),
		'GB' => array( 'name' => 'UNITED KINGDOM', 'code' => '44' ),
		// 'GD' => array( 'name' => 'GRENADA', 'code' => '1473' ),
		// 'GE' => array( 'name' => 'GEORGIA', 'code' => '995' ),
		// 'GH' => array( 'name' => 'GHANA', 'code' => '233' ),
		// 'GI' => array( 'name' => 'GIBRALTAR', 'code' => '350' ),
		'GL' => array( 'name' => 'GREENLAND', 'code' => '299' ),
		// 'GM' => array( 'name' => 'GAMBIA', 'code' => '220' ),
		// 'GN' => array( 'name' => 'GUINEA', 'code' => '224' ),
		// 'GQ' => array( 'name' => 'EQUATORIAL GUINEA', 'code' => '240' ),
		'GR' => array( 'name' => 'GREECE', 'code' => '30' ),
		// 'GT' => array( 'name' => 'GUATEMALA', 'code' => '502' ),
		// 'GU' => array( 'name' => 'GUAM', 'code' => '1671' ),
		// 'GW' => array( 'name' => 'GUINEA-BISSAU', 'code' => '245' ),
		// 'GY' => array( 'name' => 'GUYANA', 'code' => '592' ),
		'HK' => array( 'name' => 'HONG KONG', 'code' => '852' ),
		// 'HN' => array( 'name' => 'HONDURAS', 'code' => '504' ),
		'HR' => array( 'name' => 'CROATIA', 'code' => '385' ),
		// 'HT' => array( 'name' => 'HAITI', 'code' => '509' ),
		'HU' => array( 'name' => 'HUNGARY', 'code' => '36' ),
		'ID' => array( 'name' => 'INDONESIA', 'code' => '62' ),
		'IE' => array( 'name' => 'IRELAND', 'code' => '353' ),
		'IL' => array( 'name' => 'ISRAEL', 'code' => '972' ),
		// 'IM' => array( 'name' => 'ISLE OF MAN', 'code' => '44' ),
		'IN' => array( 'name' => 'INDIA', 'code' => '91' ),
		// 'IQ' => array( 'name' => 'IRAQ', 'code' => '964' ),
		// 'IR' => array( 'name' => 'IRAN, ISLAMIC REPUBLIC OF', 'code' => '98' ),
		'IS' => array( 'name' => 'ICELAND', 'code' => '354' ),
		'IT' => array( 'name' => 'ITALY', 'code' => '39' ),
		// 'JM' => array( 'name' => 'JAMAICA', 'code' => '1876' ),
		// 'JO' => array( 'name' => 'JORDAN', 'code' => '962' ),
		'JP' => array( 'name' => 'JAPAN', 'code' => '81' ),
		// 'KE' => array( 'name' => 'KENYA', 'code' => '254' ),
		// 'KG' => array( 'name' => 'KYRGYZSTAN', 'code' => '996' ),
		// 'KH' => array( 'name' => 'CAMBODIA', 'code' => '855' ),
		// 'KI' => array( 'name' => 'KIRIBATI', 'code' => '686' ),
		// 'KM' => array( 'name' => 'COMOROS', 'code' => '269' ),
		// 'KN' => array( 'name' => 'SAINT KITTS AND NEVIS', 'code' => '1869' ),
		// 'KP' => array( 'name' => 'KOREA DEMOCRATIC PEOPLES REPUBLIC OF', 'code' => '850' ),
		'KR' => array( 'name' => 'KOREA REPUBLIC OF', 'code' => '82' ),
		// 'KW' => array( 'name' => 'KUWAIT', 'code' => '965' ),
		// 'KY' => array( 'name' => 'CAYMAN ISLANDS', 'code' => '1345' ),
		// 'KZ' => array( 'name' => 'KAZAKSTAN', 'code' => '7' ),
		// 'LA' => array( 'name' => 'LAO PEOPLES DEMOCRATIC REPUBLIC', 'code' => '856' ),
		// 'LB' => array( 'name' => 'LEBANON', 'code' => '961' ),
		// 'LC' => array( 'name' => 'SAINT LUCIA', 'code' => '1758' ),
		'LI' => array( 'name' => 'LIECHTENSTEIN', 'code' => '423' ),
		// 'LK' => array( 'name' => 'SRI LANKA', 'code' => '94' ),
		// 'LR' => array( 'name' => 'LIBERIA', 'code' => '231' ),
		// 'LS' => array( 'name' => 'LESOTHO', 'code' => '266' ),
		'LT' => array( 'name' => 'LITHUANIA', 'code' => '370' ),
		'LU' => array( 'name' => 'LUXEMBOURG', 'code' => '352' ),
		'LV' => array( 'name' => 'LATVIA', 'code' => '371' ),
		// 'LY' => array( 'name' => 'LIBYAN ARAB JAMAHIRIYA', 'code' => '218' ),
		// 'MA' => array( 'name' => 'MOROCCO', 'code' => '212' ),
		// 'MC' => array( 'name' => 'MONACO', 'code' => '377' ),
		// 'MD' => array( 'name' => 'MOLDOVA, REPUBLIC OF', 'code' => '373' ),
		'ME' => array( 'name' => 'MONTENEGRO', 'code' => '382' ),
		// 'MF' => array( 'name' => 'SAINT MARTIN', 'code' => '1599' ),
		// 'MG' => array( 'name' => 'MADAGASCAR', 'code' => '261' ),
		// 'MH' => array( 'name' => 'MARSHALL ISLANDS', 'code' => '692' ),
		// 'MK' => array( 'name' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'code' => '389' ),
		// 'ML' => array( 'name' => 'MALI', 'code' => '223' ),
		// 'MM' => array( 'name' => 'MYANMAR', 'code' => '95' ),
		// 'MN' => array( 'name' => 'MONGOLIA', 'code' => '976' ),
		// 'MO' => array( 'name' => 'MACAU', 'code' => '853' ),
		// 'MP' => array( 'name' => 'NORTHERN MARIANA ISLANDS', 'code' => '1670' ),
		// 'MR' => array( 'name' => 'MAURITANIA', 'code' => '222' ),
		// 'MS' => array( 'name' => 'MONTSERRAT', 'code' => '1664' ),
		// 'MT' => array( 'name' => 'MALTA', 'code' => '356' ),
		// 'MU' => array( 'name' => 'MAURITIUS', 'code' => '230' ),
		// 'MV' => array( 'name' => 'MALDIVES', 'code' => '960' ),
		// 'MW' => array( 'name' => 'MALAWI', 'code' => '265' ),
		'MX' => array( 'name' => 'MEXICO', 'code' => '52' ),
		'MY' => array( 'name' => 'MALAYSIA', 'code' => '60' ),
		// 'MZ' => array( 'name' => 'MOZAMBIQUE', 'code' => '258' ),
		// 'NA' => array( 'name' => 'NAMIBIA', 'code' => '264' ),
		// 'NC' => array( 'name' => 'NEW CALEDONIA', 'code' => '687' ),
		// 'NE' => array( 'name' => 'NIGER', 'code' => '227' ),
		// 'NG' => array( 'name' => 'NIGERIA', 'code' => '234' ),
		// 'NI' => array( 'name' => 'NICARAGUA', 'code' => '505' ),
		'NL' => array( 'name' => 'NETHERLANDS', 'code' => '31' ),
		'NO' => array( 'name' => 'NORWAY', 'code' => '47' ),
		// 'NP' => array( 'name' => 'NEPAL', 'code' => '977' ),
		// 'NR' => array( 'name' => 'NAURU', 'code' => '674' ),
		// 'NU' => array( 'name' => 'NIUE', 'code' => '683' ),
		'NZ' => array( 'name' => 'NEW ZEALAND', 'code' => '64' ),
		// 'OM' => array( 'name' => 'OMAN', 'code' => '968' ),
		// 'PA' => array( 'name' => 'PANAMA', 'code' => '507' ),
		// 'PE' => array( 'name' => 'PERU', 'code' => '51' ),
		// 'PF' => array( 'name' => 'FRENCH POLYNESIA', 'code' => '689' ),
		// 'PG' => array( 'name' => 'PAPUA NEW GUINEA', 'code' => '675' ),
		// 'PH' => array( 'name' => 'PHILIPPINES', 'code' => '63' ),
		// 'PK' => array( 'name' => 'PAKISTAN', 'code' => '92' ),
		'PL' => array( 'name' => 'POLAND', 'code' => '48' ),
		// 'PM' => array( 'name' => 'SAINT PIERRE AND MIQUELON', 'code' => '508' ),
		// 'PN' => array( 'name' => 'PITCAIRN', 'code' => '870' ),
		'PR' => array( 'name' => 'PUERTO RICO', 'code' => '1' ),
		'PT' => array( 'name' => 'PORTUGAL', 'code' => '351' ),
		// 'PW' => array( 'name' => 'PALAU', 'code' => '680' ),
		// 'PY' => array( 'name' => 'PARAGUAY', 'code' => '595' ),
		// 'QA' => array( 'name' => 'QATAR', 'code' => '974' ),
		'RO' => array( 'name' => 'ROMANIA', 'code' => '40' ),
		'RS' => array( 'name' => 'SERBIA', 'code' => '381' ),
		'RU' => array( 'name' => 'RUSSIAN FEDERATION', 'code' => '7' ),
		// 'RW' => array( 'name' => 'RWANDA', 'code' => '250' ),
		// 'SA' => array( 'name' => 'SAUDI ARABIA', 'code' => '966' ),
		// 'SB' => array( 'name' => 'SOLOMON ISLANDS', 'code' => '677' ),
		// 'SC' => array( 'name' => 'SEYCHELLES', 'code' => '248' ),
		// 'SD' => array( 'name' => 'SUDAN', 'code' => '249' ),
		'SE' => array( 'name' => 'SWEDEN', 'code' => '46' ),
		'SG' => array( 'name' => 'SINGAPORE', 'code' => '65' ),
		// 'SH' => array( 'name' => 'SAINT HELENA', 'code' => '290' ),
		'SI' => array( 'name' => 'SLOVENIA', 'code' => '386' ),
		'SK' => array( 'name' => 'SLOVAKIA', 'code' => '421' ),
		// 'SL' => array( 'name' => 'SIERRA LEONE', 'code' => '232' ),
		// 'SM' => array( 'name' => 'SAN MARINO', 'code' => '378' ),
		// 'SN' => array( 'name' => 'SENEGAL', 'code' => '221' ),
		// 'SO' => array( 'name' => 'SOMALIA', 'code' => '252' ),
		// 'SR' => array( 'name' => 'SURINAME', 'code' => '597' ),
		// 'ST' => array( 'name' => 'SAO TOME AND PRINCIPE', 'code' => '239' ),
		// 'SV' => array( 'name' => 'EL SALVADOR', 'code' => '503' ),
		// 'SY' => array( 'name' => 'SYRIAN ARAB REPUBLIC', 'code' => '963' ),
		// 'SZ' => array( 'name' => 'SWAZILAND', 'code' => '268' ),
		// 'TC' => array( 'name' => 'TURKS AND CAICOS ISLANDS', 'code' => '1649' ),
		// 'TD' => array( 'name' => 'CHAD', 'code' => '235' ),
		// 'TG' => array( 'name' => 'TOGO', 'code' => '228' ),
		'TH' => array( 'name' => 'THAILAND', 'code' => '66' ),
		// 'TJ' => array( 'name' => 'TAJIKISTAN', 'code' => '992' ),
		// 'TK' => array( 'name' => 'TOKELAU', 'code' => '690' ),
		// 'TL' => array( 'name' => 'TIMOR-LESTE', 'code' => '670' ),
		// 'TM' => array( 'name' => 'TURKMENISTAN', 'code' => '993' ),
		// 'TN' => array( 'name' => 'TUNISIA', 'code' => '216' ),
		// 'TO' => array( 'name' => 'TONGA', 'code' => '676' ),
		// 'TR' => array( 'name' => 'TURKEY', 'code' => '90' ),
		// 'TT' => array( 'name' => 'TRINIDAD AND TOBAGO', 'code' => '1868' ),
		// 'TV' => array( 'name' => 'TUVALU', 'code' => '688' ),
		'TW' => array( 'name' => 'TAIWAN', 'code' => '886' ),
		// 'TZ' => array( 'name' => 'TANZANIA, UNITED REPUBLIC OF', 'code' => '255' ),
		'UA' => array( 'name' => 'UKRAINE', 'code' => '380' ),
		// 'UG' => array( 'name' => 'UGANDA', 'code' => '256' ),
		'US' => array( 'name' => 'UNITED STATES', 'code' => '1' ),
		'UY' => array( 'name' => 'URUGUAY', 'code' => '598' ),
		// 'UZ' => array( 'name' => 'UZBEKISTAN', 'code' => '998' ),
		// 'VA' => array( 'name' => 'HOLY SEE (VATICAN CITY STATE)', 'code' => '39' ),
		// 'VC' => array( 'name' => 'SAINT VINCENT AND THE GRENADINES', 'code' => '1784' ),
		// 'VE' => array( 'name' => 'VENEZUELA', 'code' => '58' ),
		// 'VG' => array( 'name' => 'VIRGIN ISLANDS, BRITISH', 'code' => '1284' ),
		// 'VI' => array( 'name' => 'VIRGIN ISLANDS, U.S.', 'code' => '1340' ),
		'VN' => array( 'name' => 'VIETNAM', 'code' => '84' ),
		// 'VU' => array( 'name' => 'VANUATU', 'code' => '678' ),
		// 'WF' => array( 'name' => 'WALLIS AND FUTUNA', 'code' => '681' ),
		// 'WS' => array( 'name' => 'SAMOA', 'code' => '685' ),
		// 'XK' => array( 'name' => 'KOSOVO', 'code' => '381' ),
		// 'YE' => array( 'name' => 'YEMEN', 'code' => '967' ),
		// 'YT' => array( 'name' => 'MAYOTTE', 'code' => '262' ),
		'ZA' => array( 'name' => 'SOUTH AFRICA', 'code' => '27' ),
		// 'ZM' => array( 'name' => 'ZAMBIA', 'code' => '260' ),
		// 'ZW' => array( 'name' => 'ZIMBABWE', 'code' => '263' )
	);

	public function __construct() {

		add_action( 'init', array( $this, 'set_defaults' ) );

		add_action( 'init', array( $this, 'load_settings_panel' ) );

		// Order schedule exceptions and remove past exceptions
		add_filter( 'sanitize_option_rtb-settings', array( $this, 'clean_schedule_exceptions' ), 100 );

	}

	/**
	 * Load the plugin's default settings
	 * @since 0.0.1
	 */
	public function set_defaults() {

		$this->defaults = array(

			'auto-confirm-max-party-size'	=> 1,
			'rtb-dining-block-length'		=> '120_minutes',
			'success-message'				=> _x( 'Thanks, your booking request is waiting to be confirmed. Updates will be sent to the email address you provided.', 'restaurant-reservations' ),
			'confirmed-message'				=> _x( 'Thanks, your booking request has been automatically confirmed. We look forward to seeing you soon!', 'restaurant-reservations' ),
			'date-format'					=> _x( 'mmmm d, yyyy', 'Default date format for display. Must match formatting rules at http://amsul.ca/pickadate.js/date/#formats', 'restaurant-reservations' ),
			'time-format'					=> _x( 'h:i A', 'Default time format for display. Must match formatting rules at http://amsul.ca/pickadate.js/time/#formats', 'restaurant-reservations' ),
			'time-interval'					=> _x( '30', 'Default interval in minutes when selecting a time.', 'restaurant-reservations' ),

			// Payment defaults
			'rtb-paypal-email'				=> get_option( 'admin_email' ),
			'rtb-stripe-currency-symbol'	=> '$',
			'rtb-currency-symbol-location'	=> 'before',
			'rtb-currency'					=> 'USD',
			'rtb-stripe-mode'				=> 'live',

			// Export defaults
			'ebfrtb-paper-size' 			=> 'A4',
			'ebfrtb-pdf-lib' 				=> 'mpdf',
			'ebfrtb-csv-date-format' 		=> get_option( 'date_format' ) . ' ' . get_option( 'time_format' ),

			// MailChimp defaults
			'mc-optprompt' 					=> __( 'Sign up for our mailing list.', 'restaurant-reservations' ),

			// Email address where admin notifications should be sent
			'admin-email-address'			=> get_option( 'admin_email' ),
			'ultimate-purchase-email'		=> get_option( 'admin_email' ),

			// Name and email address which should appear in the Reply-To section of notification emails
			'reply-to-name'					=> get_bloginfo( 'name' ),
			'reply-to-address'				=> get_option( 'admin_email' ),

			// Email template sent to an admin when a new booking request is made
			'subject-booking-admin'			=> _x( 'New Booking Request', 'Default email subject for admin notifications of new bookings', 'restaurant-reservations' ),
			'template-booking-admin'		=> _x( 'A new booking request has been made at {site_name}:

{user_name}
{party} people
{date}

{bookings_link}
{confirm_link}
{close_link}

&nbsp;

<em>This message was sent by {site_link} on {current_time}.</em>',
				'Default email sent to the admin when a new booking request is made. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'restaurant-reservations'
			),

			// Email template sent to a user when a new booking request is made
			'subject-booking-user'			=> sprintf( _x( 'Your booking at %s is pending', 'Default email subject sent to user when they request a booking. %s will be replaced by the website name', 'restaurant-reservations' ), get_bloginfo( 'name' ) ),
			'template-booking-user'			=> _x( 'Thanks {user_name},

Your booking request is <strong>waiting to be confirmed</strong>.

Give us a few moments to make sure that we\'ve got space for you. You will receive another email from us soon. If this request was made outside of our normal working hours, we may not be able to confirm it until we\'re open again.

<strong>Your request details:</strong>
{user_name}
{party} people
{date}

&nbsp;

<em>This message was sent by {site_link} on {current_time}.</em>',
				'Default email sent to users when they make a new booking request. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'restaurant-reservations'
			),

			// Email template sent to an admin when a new booking request is made
			'subject-booking-confirmed-admin'	=> _x( 'New Confirmed Booking Request', 'Default email subject for admin notifications when a new confirmed booking is made', 'restaurant-reservations' ),
			'template-booking-confirmed-admin'	=> _x( 'A new confirmed booking has been made at {site_name}:

{user_name}
{party} people
{date}

{bookings_link}
{confirm_link}
{close_link}

&nbsp;

<em>This message was sent by {site_link} on {current_time}.</em>',
				'Default email sent to the admin when a new confirmed booking is made. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'restaurant-reservations'
			),

			// Email template sent to an admin when a new booking request is made
			'subject-booking-cancelled-admin'	=> _x( 'Booking Request Cancelled', 'Default email subject for admin notifications of cancelled bookings', 'restaurant-reservations' ),
			'template-booking-cancelled-admin'	=> _x( 'A booking request has been cancelled at {site_name}:

{user_name}
{party} people
{date}

{bookings_link}

&nbsp;

<em>This message was sent by {site_link} on {current_time}.</em>',
				'Default email sent to the admin when a booking request is cancelled. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'restaurant-reservations'
			),

			// Email template sent to a user when a new booking request is made
			'subject-booking-user'			=> sprintf( _x( 'Your booking at %s is pending', 'Default email subject sent to user when they request a booking. %s will be replaced by the website name', 'restaurant-reservations' ), get_bloginfo( 'name' ) ),
			'template-booking-user'			=> _x( 'Thanks {user_name},

Your booking request is <strong>waiting to be confirmed</strong>.

Give us a few moments to make sure that we\'ve got space for you. You will receive another email from us soon. If this request was made outside of our normal working hours, we may not be able to confirm it until we\'re open again.

<strong>Your request details:</strong>
{user_name}
{party} people
{date}

&nbsp;

<em>This message was sent by {site_link} on {current_time}.</em>',
				'Default email sent to users when they make a new booking request. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'restaurant-reservations'
			),

			// Email template sent to a user when a booking request is confirmed
			'subject-confirmed-user'		=> sprintf( _x( 'Your booking at %s is confirmed', 'Default email subject sent to user when their booking is confirmed. %s will be replaced by the website name', 'restaurant-reservations' ), get_bloginfo( 'name' ) ),
			'template-confirmed-user'		=> _x( 'Hi {user_name},

Your booking request has been <strong>confirmed</strong>. We look forward to seeing you soon.

<strong>Your booking:</strong>
{user_name}
{party} people
{date}

&nbsp;

<em>This message was sent by {site_link} on {current_time}.</em>',
				'Default email sent to users when they make a new booking request. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'restaurant-reservations'
			),

			// Email template sent to a user when a booking request is rejected
			'subject-rejected-user'			=> sprintf( _x( 'Your booking at %s was not accepted', 'Default email subject sent to user when their booking is rejected. %s will be replaced by the website name', 'restaurant-reservations' ), get_bloginfo( 'name' ) ),
			'template-rejected-user'		=> _x( 'Hi {user_name},

Sorry, we could not accomodate your booking request. We\'re full or not open at the time you requested:

{user_name}
{party} people
{date}

&nbsp;

<em>This message was sent by {site_link} on {current_time}.</em>',
				'Default email sent to users when their booking request is rejected. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'restaurant-reservations'
			),

			// Email template sent to a user when they cancel their booking
			'subject-booking-cancelled-user'	=> sprintf( _x( 'Your reservation at %s was cancelled', 'Default email subject sent to user after they cancel their booking. %s will be replaced by the website name', 'restaurant-reservations' ), get_bloginfo( 'name' ) ),
			'template-booking-cancelled-user'	=> _x( 'Hi {user_name},

Your reservation with the following details has been cancelled:

{date}
{user_name}
{party} people

If you were not the one to cancel this booking, please contact us.

&nbsp;

<em>This message was sent by {site_link} on {current_time}.</em>',
				'Default email sent to users when they cancel their booking. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'restaurant-reservations'
			),

			// Email template sent to a user when they have an upcoming booking
			'subject-reminder-user'			=> sprintf( _x( 'Reminder: Your reservation at %s', 'Default email subject sent to user as a reminder about for their booking. %s will be replaced by the website name', 'restaurant-reservations' ), get_bloginfo( 'name' ) ),
			'template-reminder-user'		=> _x( 'Reminder: You have a reservation {date} for {party} at {site_name}',
				'Default email sent to users as a reminder about their booking request. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'restaurant-reservations'
			),

			// Email template sent to a user when they're late for their booking
			'subject-late-user'			=> sprintf( _x( 'You\'re late for your booking at %s', 'Default email subject sent to user when they are late for their booking. %s will be replaced by the website name', 'restaurant-reservations' ), get_bloginfo( 'name' ) ),
			'template-late-user'		=> _x( 'You had a reservation {date} for {party} at {site_name}',
				'Default email sent to users when they are late for their booking request. The tags in {brackets} will be replaced by the appropriate content and should be left in place. HTML is allowed, but be aware that many email clients do not handle HTML very well.',
				'restaurant-reservations'
			),

			// Email sent to a user with a custom update notice from the admin
			'subject-admin-notice'			=> sprintf( _x( 'Update regarding your booking at %s', 'Default email subject sent to users when the admin sends a custom notice email from the bookings panel.', 'restaurant-reservations' ), get_bloginfo( 'name' ) ),

			// Email address used in the FROM header of all emails
			'from-email-address' => get_option( 'admin_email' ),
		);

		$i8n = str_replace( '-', '_', get_bloginfo( 'language' ) );
		if ( array_key_exists( $i8n, $this->supported_i8n ) ) {
			$this->defaults['i8n'] = $i8n;
		}

		$this->defaults = apply_filters( 'rtb_defaults', $this->defaults );
	}

	/**
	 * Get a setting's value or fallback to a default if one exists
	 * @since 0.0.1
	 */
	public function get_setting( $setting ) {

		if ( empty( $this->settings ) ) {
			$this->settings = get_option( 'rtb-settings' );
		}

		if ( !empty( $this->settings[ $setting ] ) ) {
			return apply_filters( 'rtb-setting-' . $setting, $this->settings[ $setting ] );
		}

		if ( !empty( $this->defaults[ $setting ] ) ) {
			return apply_filters( 'rtb-setting-' . $setting, $this->defaults[ $setting ] );
		}

		return apply_filters( 'rtb-setting-' . $setting, null );
	}

	/**
	 * Set a setting to a particular value
	 * @since 2.1.0
	 */
	public function set_setting( $setting, $value ) {

		$this->settings[ $setting ] = $value;
	}

	/**
	 * Save all setting, to be used with set_setting
	 * @since 2.1.0
	 */
	public function save_settings() {
		
		update_option( 'rtb-settings', $this->settings );
	}

	/**
	 * Load the admin settings page
	 * @since 0.0.1
	 * @sa https://github.com/NateWr/simple-admin-pages
	 */
	public function load_settings_panel() {
		global $rtb_controller;

		require_once( RTB_PLUGIN_DIR . '/lib/simple-admin-pages/simple-admin-pages.php' );
		$sap = sap_initialize_library(
			$args = array(
				'version'       => '2.2.0',
				'lib_url'       => RTB_PLUGIN_URL . '/lib/simple-admin-pages/',
			)
		);

		$sap->add_page(
			'submenu',
			array(
				'id'            => 'rtb-settings',
				'title'         => __( 'Settings', 'restaurant-reservations' ),
				'menu_title'    => __( 'Settings', 'restaurant-reservations' ),
				'parent_menu'	=> 'rtb-bookings',
				'description'   => '',
				'capability'    => 'manage_options',
				'default_tab'   => 'rtb-schedule-tab',
			)
		);

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-schedule-tab',
				'title'         => __( 'Booking Schedule', 'restaurant-reservations' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-schedule',
				'title'         => __( 'Scheduling Options', 'restaurant-reservations' ),
				'tab'	          => 'rtb-schedule-tab',
			)
		);

		// Translateable strings for scheduler components
		$scheduler_strings = array(
			'add_rule'			=> __( 'Add new scheduling rule', 'restaurant-reservations' ),
			'weekly'			=> _x( 'Weekly', 'Format of a scheduling rule', 'restaurant-reservations' ),
			'monthly'			=> _x( 'Monthly', 'Format of a scheduling rule', 'restaurant-reservations' ),
			'date'				=> _x( 'Date', 'Format of a scheduling rule', 'restaurant-reservations' ),
			'weekdays'			=> _x( 'Days of the week', 'Label for selecting days of the week in a scheduling rule', 'restaurant-reservations' ),
			'month_weeks'		=> _x( 'Weeks of the month', 'Label for selecting weeks of the month in a scheduling rule', 'restaurant-reservations' ),
			'date_label'		=> _x( 'Date', 'Label to select a date for a scheduling rule', 'restaurant-reservations' ),
			'time_label'		=> _x( 'Time', 'Label to select a time slot for a scheduling rule', 'restaurant-reservations' ),
			'allday'			=> _x( 'All day', 'Label to set a scheduling rule to last all day', 'restaurant-reservations' ),
			'start'				=> _x( 'Start', 'Label for the starting time of a scheduling rule', 'restaurant-reservations' ),
			'end'				=> _x( 'End', 'Label for the ending time of a scheduling rule', 'restaurant-reservations' ),
			'set_time_prompt'	=> _x( 'All day long. Want to %sset a time slot%s?', 'Prompt displayed when a scheduling rule is set without any time restrictions', 'restaurant-reservations' ),
			'toggle'			=> _x( 'Open and close this rule', 'Toggle a scheduling rule open and closed', 'restaurant-reservations' ),
			'delete'			=> _x( 'Delete rule', 'Delete a scheduling rule', 'restaurant-reservations' ),
			'delete_schedule'	=> __( 'Delete scheduling rule', 'restaurant-reservations' ),
			'never'				=> _x( 'Never', 'Brief default description of a scheduling rule when no weekdays or weeks are included in the rule', 'restaurant-reservations' ),
			'weekly_always'	=> _x( 'Every day', 'Brief default description of a scheduling rule when all the weekdays/weeks are included in the rule', 'restaurant-reservations' ),
			'monthly_weekdays'	=> _x( '%s on the %s week of the month', 'Brief default description of a scheduling rule when some weekdays are included on only some weeks of the month. %s should be left alone and will be replaced by a comma-separated list of days and weeks in the following format: M, T, W on the first, second week of the month', 'restaurant-reservations' ),
			'monthly_weeks'		=> _x( '%s week of the month', 'Brief default description of a scheduling rule when some weeks of the month are included but all or no weekdays are selected. %s should be left alone and will be replaced by a comma-separated list of weeks in the following format: First, second week of the month', 'restaurant-reservations' ),
			'all_day'			=> _x( 'All day', 'Brief default description of a scheduling rule when no times are set', 'restaurant-reservations' ),
			'before'			=> _x( 'Ends at', 'Brief default description of a scheduling rule when an end time is set but no start time. If the end time is 6pm, it will read: Ends at 6pm', 'restaurant-reservations' ),
			'after'				=> _x( 'Starts at', 'Brief default description of a scheduling rule when a start time is set but no end time. If the start time is 6pm, it will read: Starts at 6pm', 'restaurant-reservations' ),
			'separator'			=> _x( '&mdash;', 'Separator between times of a scheduling rule', 'restaurant-reservations' ),
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-schedule',
			'scheduler',
			array(
				'id'			=> 'schedule-open',
				'title'			=> __( 'Schedule', 'restaurant-reservations' ),
				'description'	=> __( 'Define the weekly schedule during which you accept bookings.', 'restaurant-reservations' ),
				'weekdays'		=> array(
					'monday'		=> _x( 'Mo', 'Monday abbreviation', 'restaurant-reservations' ),
					'tuesday'		=> _x( 'Tu', 'Tuesday abbreviation', 'restaurant-reservations' ),
					'wednesday'		=> _x( 'We', 'Wednesday abbreviation', 'restaurant-reservations' ),
					'thursday'		=> _x( 'Th', 'Thursday abbreviation', 'restaurant-reservations' ),
					'friday'		=> _x( 'Fr', 'Friday abbreviation', 'restaurant-reservations' ),
					'saturday'		=> _x( 'Sa', 'Saturday abbreviation', 'restaurant-reservations' ),
					'sunday'		=> _x( 'Su', 'Sunday abbreviation', 'restaurant-reservations' )
				),
				'time_format'	=> $this->get_setting( 'time-format' ),
				'date_format'	=> $this->get_setting( 'date-format' ),
				'disable_weeks'	=> true,
				'disable_date'	=> true,
				'strings' => $scheduler_strings,
			)
		);

		$scheduler_strings['all_day'] = _x( 'Closed all day', 'Brief default description of a scheduling exception when no times are set', 'restaurant-reservations' );
		$sap->add_setting(
			'rtb-settings',
			'rtb-schedule',
			'scheduler',
			array(
				'id'				=> 'schedule-closed',
				'title'				=> __( 'Exceptions', 'restaurant-reservations' ),
				'description'		=> __( "Define special opening hours for holidays, events or other needs. Leave the time empty if you're closed all day.", 'restaurant-reservations' ),
				'time_format'		=> esc_attr( $this->get_setting( 'time-format' ) ),
				'date_format'		=> esc_attr( $this->get_setting( 'date-format' ) ),
				'disable_weekdays'	=> true,
				'disable_weeks'		=> true,
				'strings' => $scheduler_strings,
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-schedule',
			'select',
			array(
				'id'            => 'early-bookings',
				'title'         => __( 'Early Bookings', 'restaurant-reservations' ),
				'description'   => __( 'Select how early customers can make their booking. (Administrators and Booking Managers are not restricted by this setting.)', 'restaurant-reservations' ),
				'blank_option'	=> false,
				'options'       => array(
					''		=> __( 'Any time', 'restaurant-reservations' ),
					'1' 	=> __( 'From 1 day in advance', 'restaurant-reservations' ),
					'7' 	=> __( 'From 1 week in advance', 'restaurant-reservations' ),
					'14' 	=> __( 'From 2 weeks in advance', 'restaurant-reservations' ),
					'30' 	=> __( 'From 30 days in advance', 'restaurant-reservations' ),
					'60' 	=> __( 'From 60 days in advance', 'restaurant-reservations' ),
					'90' 	=> __( 'From 90 days in advance', 'restaurant-reservations' ),
				)
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-schedule',
			'select',
			array(
				'id'            => 'late-bookings',
				'title'         => __( 'Late Bookings', 'restaurant-reservations' ),
				'description'   => __( 'Select how late customers can make their booking. (Administrators and Booking Managers are not restricted by this setting.)', 'restaurant-reservations' ),
				'blank_option'	=> false,
				'options'       => array(
					'' 	       => __( 'Up to the last minute', 'restaurant-reservations' ),
					'15'       => __( 'At least 15 minutes in advance', 'restaurant-reservations' ),
					'30'       => __( 'At least 30 minutes in advance', 'restaurant-reservations' ),
					'45'       => __( 'At least 45 minutes in advance', 'restaurant-reservations' ),
					'60'       => __( 'At least 1 hour in advance', 'restaurant-reservations' ),
					'240'      => __( 'At least 4 hours in advance', 'restaurant-reservations' ),
					'1440'     => __( 'At least 24 hours in advance', 'restaurant-reservations' ),
					'same_day' => __( 'Block same-day bookings', 'restaurant-reservations' ),
				)
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-schedule',
			'select',
			array(
				'id'			=> 'date-onload',
				'title'			=> __( 'Date Pre-selection', 'restaurant-reservations' ),
				'description'	=> __( 'When the booking form is loaded, should it automatically attempt to select a valid date?', 'restaurant-reservations' ),
				'blank_option'	=> false,
				'options'       => array(
					'' 			=> __( 'Select today if valid', 'restaurant-reservations' ),
					'soonest'	=> __( 'Select today or next valid date', 'restaurant-reservations' ),
					'empty' 	=> __( 'Leave empty', 'restaurant-reservations' ),
				)
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-schedule',
			'select',
			array(
				'id'			=> 'time-interval',
				'title'			=> __( 'Time Interval', 'restaurant-reservations' ),
				'description'	=> __( 'Select the number of minutes between each available time.', 'restaurant-reservations' ),
				'blank_option'	=> false,
				'options'       => array(
					'' 			=> __( 'Every 30 minutes', 'restaurant-reservations' ),
					'15' 		=> __( 'Every 15 minutes', 'restaurant-reservations' ),
					'10' 		=> __( 'Every 10 minutes', 'restaurant-reservations' ),
					'5' 		=> __( 'Every 5 minutes', 'restaurant-reservations' ),
				)
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-schedule',
			'select',
			array(
				'id'            => 'week-start',
				'title'         => __( 'Week Starts On', 'restaurant-reservations' ),
				'description'	=> __( 'Select the first day of the week', 'restaurant-reservations' ),
				'blank_option'	=> false,
				'options'       => array(
					'0' => __( 'Sunday', 'restaurant-reservations' ),
					'1' => __( 'Monday', 'restaurant-reservations' ),
				)
			)
		);

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-basic',
				'title'         => __( 'Basic', 'restaurant-reservations' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-general',
				'title'         => __( 'General', 'restaurant-reservations' ),
				'tab'	          => 'rtb-basic',
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-general',
			'post',
			array(
				'id'            => 'booking-page',
				'title'         => __( 'Booking Page', 'restaurant-reservations' ),
				'description'   => __( 'Select a page on your site to automatically display the booking form and confirmation message.', 'restaurant-reservations' ),
				'blank_option'	=> true,
				'args'			=> array(
					'post_type' 		=> 'page',
					'posts_per_page'	=> -1,
					'post_status'		=> 'publish',
				),
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-general',
			'select',
			array(
				'id'            => 'party-size-min',
				'title'         => __( 'Min Party Size', 'restaurant-reservations' ),
				'description'   => __( 'Set a minimum allowed party size for bookings.', 'restaurant-reservations' ),
				'blank_option'	=> false,
				'options'       => $this->get_party_size_setting_options( false ),
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-general',
			'select',
			array(
				'id'            => 'party-size',
				'title'         => __( 'Max Party Size', 'restaurant-reservations' ),
				'description'   => __( 'Set a maximum allowed party size for bookings.', 'restaurant-reservations' ),
				'blank_option'	=> false,
				'options'       => $this->get_party_size_setting_options(),
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-general',
			'select',
			array(
				'id'            => 'auto-confirm-max-party-size',
				'title'         => __( 'Automatically Confirm Below Party Size', 'restaurant-reservations' ),
				'description'   => __( 'Set a maximum party size below which all bookings will be automatically confirmed.', 'restaurant-reservations' ),
				'blank_option'	=> false,
				'default' 		=> $this->defaults['auto-confirm-max-party-size'],
				'options'       => $this->get_party_size_setting_options( false ),
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-general',
			'toggle',
			array(
				'id'			=> 'allow-cancellations',
				'title'			=> __( 'Allow Cancellations', 'restaurant-reservations' ),
				'description'			=> __( 'Adds a cancellation option to your booking form, so that customers are able to cancel their reservations.', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-general',
			'select',
			array(
				'id'            => 'require-phone',
				'title'         => __( 'Require Phone', 'restaurant-reservations' ),
				'description'   => __( "Don't accept booking requests without a phone number.", 'restaurant-reservations' ),
				'blank_option'	=> false,
				'options'       => array(
					'' => __( 'No', 'restaurant-reservations' ),
					'1' => __( 'Yes', 'restaurant-reservations' ),
				),
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-general',
			'textarea',
			array(
				'id'			=> 'success-message',
				'title'			=> __( 'Pending Confirmation Message', 'restaurant-reservations' ),
				'description'	=> __( 'Enter the message to display when a booking request is made and is set to pending confirmation.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['success-message'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-general',
			'textarea',
			array(
				'id'			=> 'confirmed-message',
				'title'			=> __( 'Confirmed Booking Message', 'restaurant-reservations' ),
				'description'	=> __( 'Enter the message to display when a booking is made that has been automatically confirmed.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['confirmed-message'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-general',
			'text',
			array(
				'id'            => 'pending-redirect-page',
				'title'         => __( 'Pending Redirect Page', 'restaurant-reservations' ),
				'description'	=> __( 'Input the URL of the page you want the booking form to redirect to after a reservation is made that is set to pending. This overrides the "Pending Confirmation Message" text/option.', 'restaurant-reservations' ),
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-general',
			'text',
			array(
				'id'            => 'confirmed-redirect-page',
				'title'         => __( 'Confirmed Redirect Page', 'restaurant-reservations' ),
				'description'	=> __( 'Input the URL of the page you want the booking form to redirect to after a reservation is made that is automatically confirmed. This overrides the "Confirmed Booking Message" text/option.', 'restaurant-reservations' ),
			)
		);

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-booking-form',
				'title'         => __( 'Booking Form', 'restaurant-reservations' ),
				'tab'	          => 'rtb-basic',
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-booking-form',
			'text',
			array(
				'id'            => 'date-format',
				'title'         => __( 'Date Format', 'restaurant-reservations' ),
				'description'   => sprintf( __( 'Define how the date is formatted on the booking form. %sFormatting rules%s. This only changes the format on the booking form. To change the date format in notification messages, modify your general %sWordPress Settings%s.', 'restaurant-reservations' ), '<a href="http://amsul.ca/pickadate.js/date/#formats">', '</a>', '<a href="' . admin_url( 'options-general.php' ) . '">', '</a>' ),
				'placeholder'	=> $this->defaults['date-format'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-booking-form',
			'text',
			array(
				'id'            => 'time-format',
				'title'         => __( 'Time Format', 'restaurant-reservations' ),
				'description'   => sprintf( __( 'Define how the time is formatted on the booking form. %sFormatting rules%s. This only changes the format on the booking form. To change the time format in notification messages, modify your general %sWordPress Settings%s.', 'restaurant-reservations' ), '<a href="http://amsul.ca/pickadate.js/time/#formats">', '</a>', '<a href="' . admin_url( 'options-general.php' ) . '">', '</a>' ),
				'placeholder'	=> $this->defaults['time-format'],
			)
		);

		// Add i8n setting for pickadate if the frontend assets are to be loaded
		if ( apply_filters( 'rtb-load-frontend-assets', true ) ) {
			$sap->add_setting(
				'rtb-settings',
				'rtb-general',
				'select',
				array(
					'id'            => 'i8n',
					'title'         => __( 'Language', 'restaurant-reservations' ),
					'description'   => __( 'Select a language to use for the booking form datepicker if it is different than your WordPress language setting.', 'restaurant-reservations' ),
					'options'		=> $this->supported_i8n,
				)
			);
		}

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-security',
				'title'         => __( 'Security', 'restaurant-reservations' ),
				'tab'	          => 'rtb-basic',
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-security',
			'textarea',
			array(
				'id'			=> 'ban-emails',
				'title'			=> __( 'Banned Email Addresses', 'restaurant-reservations' ),
				'description'	=> __( 'You can block bookings from specific email addresses. Enter each email address on a separate line.', 'restaurant-reservations' ),
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-security',
			'textarea',
			array(
				'id'			=> 'ban-ips',
				'title'			=> __( 'Banned IP Addresses', 'restaurant-reservations' ),
				'description'	=> __( 'You can block bookings from specific IP addresses. Enter each IP address on a separate line. Be aware that many internet providers rotate their IP address assignments, so an IP address may accidentally refer to a different user. Also, if you block an IP address used by a public connection, such as cafe WIFI, a public library, or a university network, you may inadvertantly block several people.', 'restaurant-reservations' ),
			)
		);

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-captcha',
				'title'         => __( 'Captcha', 'restaurant-reservations' ),
				'tab'	          => 'rtb-basic',
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-captcha',
			'toggle',
			array(
				'id'			=> 'enable-captcha',
				'title'			=> __( 'Enable Google reCAPTCHA v2', 'restaurant-reservations' ),
				'description'			=> sprintf( __( 'Adds Google\'s reCAPTCHA code to your form, to verify guests before they can book. Please check %s our documentation %s for more information on how to configure this feature.', 'restaurant-reservations' ), '<a href="http://doc.fivestarplugins.com/plugins/restaurant-reservations/" target="_blank">', '</a>')
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-captcha',
			'text',
			array(
				'id'            => 'captcha-site-key',
				'title'         => __( 'Google Site Key', 'restaurant-reservations' ),
				'description'   => __( 'The site key provided to you by Google', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-captcha',
			'text',
			array(
				'id'            => 'captcha-secret-key',
				'title'         => __( 'Google Secret Key', 'restaurant-reservations' ),
				'description'   => __( 'The secret key provided to you by Google', 'restaurant-reservations' )
			)
		);

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-privacy',
				'title'         => __( 'Privacy', 'restaurant-reservations' ),
				'tab'	          => 'rtb-basic',
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-privacy',
			'toggle',
			array(
				'id'			=> 'require-consent',
				'title'			=> __( 'Require Consent', 'restaurant-reservations' ),
				'description'			=> __( 'Require customers to consent to the collection of their details when making a booking. This may be required to comply with privacy laws in your country.', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-privacy',
			'textarea',
			array(
				'id'			=> 'consent-statement',
				'title'			=> __( 'Consent Statement', 'restaurant-reservations' ),
				'description'	=> __( 'Enter the statement you would like customers to confirm when making a booking.', 'restaurant-reservations' ),
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-privacy',
			'post',
			array(
				'id'            => 'privacy-page',
				'title'         => __( 'Privacy Statement Page', 'restaurant-reservations' ),
				'description'   => __( 'Select a page on your site which contains a privacy statement. If selected, it will be linked to in your consent statement.', 'restaurant-reservations' ),
				'blank_option'	=> true,
				'args'			=> array(
					'post_type' 		=> 'page',
					'posts_per_page'	=> -1,
					'post_status'		=> 'publish',
				),
			)
		);

		if ( ! $rtb_controller->permissions->check_permission('premium_view_bookings') ) {
			$premium_view_bookings_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'	=> 'https://www.fivestarplugins.com/plugins/five-star-restaurant-reservations/'
			);
		}
		else { $premium_view_bookings_permissions = array(); }

		if ( ! $rtb_controller->permissions->check_permission('premium_table_restrictions') ) {
			$premium_table_restrictions_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'	=> 'https://www.fivestarplugins.com/plugins/five-star-restaurant-reservations/'
			);
		}
		else { $premium_table_restrictions_permissions = array(); }

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-premium',
				'title'         => __( 'Premium', 'restaurant-reservations' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'rtb-settings',
			array_merge( 
				array(
					'id'            => 'rtb-view-bookings-form',
					'title'         => __( 'View Bookings Form', 'restaurant-reservations' ),
					'tab'	          => 'rtb-premium',
				),
				$premium_view_bookings_permissions
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-view-bookings-form',
			'post',
			array(
				'id'            => 'view-bookings-page',
				'title'         => __( 'View Bookings Page', 'restaurant-reservations' ),
				'description'   => __( 'Select a page on your site to automatically display the view bookings form. Useful for restaurant staff checking guests in as they arrive.', 'restaurant-reservations' ),
				'blank_option'	=> true,
				'args'			=> array(
					'post_type' 		=> 'page',
					'posts_per_page'	=> -1,
					'post_status'		=> 'publish',
				),
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-view-bookings-form',
			'toggle',
			array(
				'id'			=> 'view-bookings-private',
				'title'			=> __( 'Keep View Bookings Private', 'restaurant-reservations' ),
				'description'			=> __( 'Only display the view bookings form to visitors who are logged in to your site.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-view-bookings-form',
			'toggle',
			array(
				'id'			=> 'view-bookings-arrivals',
				'title'			=> __( 'Check In Arrivals', 'restaurant-reservations' ),
				'description'			=> __( 'Allow guests to be checked in as they arrive. This is necessary for late arrival reminders to work correctly.', 'restaurant-reservations' )
			)
		);

		$sap->add_section(
			'rtb-settings',
			array_merge(
				array(
					'id'            => 'rtb-table-seat-assignments',
					'title'         => __( 'Table/Seat Restrictions', 'restaurant-reservations' ),
					'tab'	          => 'rtb-premium',
				),
				$premium_table_restrictions_permissions
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-table-seat-assignments',
			'count',
			array(
				'id'			=> 'rtb-dining-block-length',
				'title'			=> __( 'Dining Block Length', 'restaurant-reservations' ),
				'description'			=> __( 'How long does a meal generally last? This setting affects a table and/or seat unavailable for after someone makes a reservation.', 'restaurant-reservations' ),
				'default'		=> $this->defaults['rtb-dining-block-length'],
				'blank_option'	=> false,
				'min_value'		=> 10,
				'max_value'		=> 240,
				'increment'		=> 5,
				'units'			=> array( 'minutes' => 'Minutes' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-table-seat-assignments',
			'toggle',
			array(
				'id'			=> 'rtb-enable-max-tables',
				'title'			=> __( 'Enable Max Reservations', 'restaurant-reservations' ),
				'description'			=> __( 'Only allow a certain number of reservations (set below) during a specific time. Once the maximum number of reservations has been reached, visitors will only be able to select other reservation times.', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-table-seat-assignments',
			'count',
			array(
				'id'			=> 'rtb-max-tables-count',
				'title'			=> __( 'Max Reservations', 'restaurant-reservations' ),
				'description'			=> __( 'How many reservations, if enabled above, should be allowed at the same time? Set dining block length setting above to change how long a meal typically lasts.', 'restaurant-reservations' ),
				'min_value'		=> 1,
				'max_value'		=> 100,
				'increment'		=> 1
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-table-seat-assignments',
			'count',
			array(
				'id'			=> 'auto-confirm-max-reservations',
				'title'         => __( 'Automatically Confirm Below Reservation Number', 'restaurant-reservations' ),
				'description'   => __( 'Set a maximum number of reservations at one time below which all bookings will be automatically confirmed.', 'restaurant-reservations' ),
				'min_value'		=> 1,
				'max_value'		=> 100,
				'increment'		=> 1
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-table-seat-assignments',
			'count',
			array(
				'id'			=> 'auto-confirm-max-seats',
				'title'         => __( 'Automatically Confirm Below Seats Number', 'restaurant-reservations' ),
				'description'   => __( 'Set a maximum number of seats at one time below which all bookings will be automatically confirmed.', 'restaurant-reservations' ),
				'min_value'		=> 1,
				'max_value'		=> 400,
				'increment'		=> 1
			)
		);

		if ( ! $rtb_controller->permissions->check_permission('mailchimp') ) {
			$mailchimp_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'	=> 'https://www.fivestarplugins.com/plugins/five-star-restaurant-reservations/'
			);
		}
		else { $mailchimp_permissions = array(); }

		$sap->add_section(
			'rtb-settings',
			array_merge(
				array(
					'id'            => 'rtb-mailchimp',
					'title'         => __( 'MailChimp', 'restaurant-reservations' ),
					'tab'	        => 'rtb-premium',
				),
				$mailchimp_permissions
			)
		);

		// MailChimp API key
		$sap->add_setting(
			'rtb-settings',
			'rtb-mailchimp',
			'mcapikey',
			array(
				'id'            => 'mc-apikey',
				'title'         => __( 'MailChimp API Key', 'restaurant-reservations' ),
				'description'   => '<a href="https://admin.mailchimp.com/account/api/" target="_blank">' . __( 'Retrieve or create an API key for your MailChimp account', 'restaurant-reservations' ) . '</a>',
				'placeholder'	=> __( 'API Key', 'restaurant-reservations' ),
				'string_status_connected'	=> __( 'Connected', 'restaurant-reservations' ),
				'string_status_error'		=> __( 'Invalid Key', 'restaurant-reservations' ),
			)
		);

		// Don't show the settings until an API key has been successfully entered
		if ( $rtb_controller->mailchimp->status === true ) {

			// MailChimp list and merge fields
			$sap->add_setting(
				'rtb-settings',
				'rtb-mailchimp',
				'mclistmerge',
				array(
					'id'            => 'mc-lists',
					'title'         => __( 'Subscribe List', 'restaurant-reservations' ),
					'description'   => __( 'New booking requests will be subscribed to this list.', 'restaurant-reservations' ),
					'fields'		=> $rtb_controller->mailchimp->merge_fields,
					'string_loading'	=> __( 'Loading...', 'restaurant-reservations' ),
				)
			);

			// Opt-out Option
			$sap->add_setting(
				'rtb-settings',
				'rtb-mailchimp',
				'select',
				array(
					'id'            => 'mc-optout',
					'title'         => __( 'Opt-in', 'restaurant-reservations' ),
					'description'   => __( 'Whether to show an option for users to opt-in to being signed up for your mailing list when making a reservation.', 'restaurant-reservations' ),
					'blank_option'	=> false,
					'options'		=> array(
						''			=> __( 'Show opt-in prompt', 'restaurant-reservations' ),
						'checked'	=> __( 'Show pre-checked opt-in prompt', 'restaurant-reservations' ),
						'no'		=> __( 'Don\'t show opt-in prompt', 'restaurant-reservations' ),
					),
				)
			);

			// Opt-out prompt text
			$sap->add_setting(
				'rtb-settings',
				'rtb-mailchimp',
				'text',
				array(
					'id'            => 'mc-optprompt',
					'title'         => __( 'Opt-in Prompt', 'restaurant-reservations' ),
					'description'   => __( 'Text to display with the opt-in option.', 'restaurant-reservations' ),
					'placeholder'	=> $this->defaults['mc-optprompt'],
				)
			);
		}

		if ( ! $rtb_controller->permissions->check_permission('designer') ) {
			$designer_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'	=> 'https://www.fivestarplugins.com/plugins/five-star-restaurant-reservations/'
			);
		}
		else { $designer_permissions = array(); }

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-notifications-tab',
				'title'         => __( 'Notifications', 'restaurant-reservations' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'rtb-settings',
			array_merge(
				array(
					'id'            => 'rtb-email-templates',
					'title'         => __( 'Email Templates', 'restaurant-reservations' ),
					'tab'	          => 'rtb-notifications-tab',
				),
				$designer_permissions
			)
		);

		$notifications_settings_url = admin_url( '/admin.php?page=rtb-settings&tab=rtb-notifications-tab' );
		$customizer_url = admin_url( '/customize.php?etfrtb_designer=1&return=' . urlencode( $notifications_settings_url ) );
	
		$sap->add_setting(
			'rtb-settings',
			'rtb-email-templates',
			'html',
			array(
				'id'       => 'etfrtb-load-customizer',
				'title'    => __( 'Email Designer', 'restaurant-reservations' ),
				'html'     => '<a href="' . esc_url( $customizer_url ) . '" class="button">' . __( 'Launch Email Designer', 'restaurant-reservations' ) . '</a>',
				'position' => array( 'top' ),
			)
		);

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-notifications',
				'title'         => __( 'General', 'restaurant-reservations' ),
				'tab'	          => 'rtb-notifications-tab',
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications',
			'text',
			array(
				'id'			=> 'reply-to-name',
				'title'			=> __( 'Reply-To Name', 'restaurant-reservations' ),
				'description'	=> __( 'The name which should appear in the Reply-To field of a user notification email', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['reply-to-name'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications',
			'text',
			array(
				'id'			=> 'reply-to-address',
				'title'			=> __( 'Reply-To Email Address', 'restaurant-reservations' ),
				'description'	=> __( 'The email address which should appear in the Reply-To field of a user notification email.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['reply-to-address'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications',
			'toggle',
			array(
				'id'			=> 'admin-email-option',
				'title'			=> __( 'Admin Notification', 'restaurant-reservations' ),
				'description'			=> __( 'Send an email notification to an administrator when a new booking is requested.', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications',
			'toggle',
			array(
				'id'			=> 'admin-confirmed-email-option',
				'title'			=> __( 'Admin New Confirmed Notification', 'restaurant-reservations' ),
				'description'			=> __( 'Send an email notification to an administrator when a new confirmed booking is made.', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications',
			'toggle',
			array(
				'id'			=> 'admin-cancelled-email-option',
				'title'			=> __( 'Admin Cancellation Notification', 'restaurant-reservations' ),
				'description'			=> __( 'Send an email notification to an administrator when a booking is cancelled.', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications',
			'text',
			array(
				'id'			=> 'admin-email-address',
				'title'			=> __( 'Admin Email Address', 'restaurant-reservations' ),
				'description'	=> __( 'The email address where admin notifications should be sent.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['admin-email-address'],
			)
		);

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-notifications-templates',
				'title'         => __( 'Notification Emails', 'restaurant-reservations' ),
				'tab'			=> 'rtb-notifications-tab',
				'description'	=> __( 'Adjust the messages that are emailed to users and admins during the booking process.', 'restaurant-reservations' ),
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'html',
			array(
				'id'			=> 'template-tags-description',
				'title'			=> __( 'Template Tags', 'restaurant-reservations' ),
				'html'			=> '
					<p class="description">' . __( 'Use the following tags to automatically add booking information to the emails. Tags labeled with an asterisk (*) can be used in the email subject as well.', 'restaurant-reservations' ) . '</p>' .
					$this->render_template_tag_descriptions(),
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'text',
			array(
				'id'			=> 'subject-booking-admin',
				'title'			=> __( 'Admin Notification Subject', 'restaurant-reservations' ),
				'description'	=> __( 'The email subject for admin notifications.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['subject-booking-admin'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'editor',
			array(
				'id'			=> 'template-booking-admin',
				'title'			=> __( 'Admin Notification Email', 'restaurant-reservations' ),
				'description'	=> __( 'Enter the email an admin should receive when an initial booking request is made.', 'restaurant-reservations' ),
				'default'		=> $this->defaults['template-booking-admin'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'text',
			array(
				'id'			=> 'subject-booking-cancelled-admin',
				'title'			=> __( 'Admin Booking Cancelled Subject', 'restaurant-reservations' ),
				'description'	=> __( 'The email subject for admin notifications when a booking is cancelled.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['subject-booking-cancelled-admin'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'editor',
			array(
				'id'			=> 'template-booking-cancelled-admin',
				'title'			=> __( 'Admin Booking Cancelled Email', 'restaurant-reservations' ),
				'description'	=> __( 'Enter the email an admin should receive when a booking is cancelled.', 'restaurant-reservations' ),
				'default'		=> $this->defaults['template-booking-cancelled-admin'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'text',
			array(
				'id'			=> 'subject-booking-user',
				'title'			=> __( 'New Request Email Subject', 'restaurant-reservations' ),
				'description'	=> __( 'The email subject a user should receive when they make an initial booking request.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['subject-booking-user'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'editor',
			array(
				'id'			=> 'template-booking-user',
				'title'			=> __( 'New Request Email', 'restaurant-reservations' ),
				'description'	=> __( 'Enter the email a user should receive when they make an initial booking request.', 'restaurant-reservations' ),
				'default'		=> $this->defaults['template-booking-user'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'text',
			array(
				'id'			=> 'subject-confirmed-user',
				'title'			=> __( 'Confirmed Email Subject', 'restaurant-reservations' ),
				'description'	=> __( 'The email subject a user should receive when their booking has been confirmed.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['subject-confirmed-user'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'editor',
			array(
				'id'			=> 'template-confirmed-user',
				'title'			=> __( 'Confirmed Email', 'restaurant-reservations' ),
				'description'	=> __( 'Enter the email a user should receive when their booking has been confirmed.', 'restaurant-reservations' ),
				'default'		=> $this->defaults['template-confirmed-user'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'text',
			array(
				'id'			=> 'subject-rejected-user',
				'title'			=> __( 'Rejected Email Subject', 'restaurant-reservations' ),
				'description'	=> __( 'The email subject a user should receive when their booking has been rejected.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['subject-rejected-user'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'editor',
			array(
				'id'			=> 'template-rejected-user',
				'title'			=> __( 'Rejected Email', 'restaurant-reservations' ),
				'description'	=> __( 'Enter the email a user should receive when their booking has been rejected.', 'restaurant-reservations' ),
				'default'		=> $this->defaults['template-rejected-user'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'text',
			array(
				'id'			=> 'subject-booking-cancelled-user',
				'title'			=> __( 'Booking Cancelled Email Subject', 'restaurant-reservations' ),
				'description'	=> __( 'The email subject a user should receive when they have cancelled their booking.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['subject-booking-cancelled-user'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'editor',
			array(
				'id'			=> 'template-booking-cancelled-user',
				'title'			=> __( 'Booking Cancelled Email', 'restaurant-reservations' ),
				'description'	=> __( 'Enter the email a user should receive when they cancel their booking.', 'restaurant-reservations' ),
				'default'		=> $this->defaults['template-booking-cancelled-user'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-templates',
			'text',
			array(
				'id'			=> 'subject-admin-notice',
				'title'			=> __( 'Admin Update Subject', 'restaurant-reservations' ),
				'description'	=> sprintf( __( 'The email subject a user should receive when an admin sends them a custom email message from the %sbookings panel%s.', 'restaurant-reservations' ), '<a href="' . admin_url( '?page=rtb-bookings' ) . '">', '</a>' ),
				'placeholder'	=> $this->defaults['subject-admin-notice'],
			)
		);

		if ( ! $rtb_controller->permissions->check_permission('reminders') ) {
			$reminders_permissions = array(
				'disabled'			=> true,
				'disabled_image'	=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'		=> 'https://www.fivestarplugins.com/plugins/five-star-restaurant-reservations/',
				'ultimate_needed'	=> 'Yes'
			);
		}
		else { $reminders_permissions = array(); }

		$sap->add_section(
			'rtb-settings',
			array_merge(
				array(
					'id'            => 'rtb-reservation-reminders',
					'title'         => __( 'Reservation Reminders', 'restaurant-reservations' ),
					'tab'			=> 'rtb-notifications-tab',
					'description'	=> __( 'Set up reservation and late arrival reminders.' ),
				),
				$reminders_permissions
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-reminders',
			'text',
			array(
				'id'			=> 'ultimate-purchase-email',
				'title'			=> __( 'Ultimate Plan Purchase Email', 'restaurant-reservations' ),
				'description'	=> __( 'The email used to purchase your \'Ultimate\' plan subscription. Used to verify SMS requests are actually being sent from your site.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['ultimate-purchase-email'],
			)
		);

		$country_phone_display_array = array();
		foreach ( $this->country_phone_array as $country_code => $country_array ) { $country_phone_display_array[$country_code] = $country_array['name'] . ' (+' . $country_array['code'] . ')'; }

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-reminders',
			'select',
			array(
				'id'            => 'rtb-country-code',
				'title'         => __( 'Country Code', 'restaurant-reservations' ),
				'description'   => __( 'What country code should be added to SMS reminders? If no country is specified, phone numbers for reservations should start with +XXX (a plus sign followed by the country code), followed by a space or dash, or else the number the phone number will be assumed to be North American.', 'restaurant-reservations' ),
				'blank_option'	=> true,
				'options'       => $country_phone_display_array
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-reminders',
			'radio',
			array(
				'id'			=> 'reminder-notification-format',
				'title'			=> __( 'Reminder Format', 'restaurant-reservations' ),
				'description'	=> __( 'Should reminders be sent via email or text (SMS) message. SMS requires a positive credit balance on your account.', 'restaurant-reservations' ),
				'options'		=> array(
					'email'			=> 'Email',
					'text'			=> 'Text (SMS)'
				)
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-reminders',
			'radio',
			array(
				'id'			=> 'late-notification-format',
				'title'			=> __( 'Late Notification Format', 'restaurant-reservations' ),
				'description'	=> __( 'Should late notifications be sent via email or text (SMS) message. SMS requires a positive credit balance on your account.', 'restaurant-reservations' ),
				'options'		=> array(
					'email'			=> 'Email',
					'text'			=> 'Text (SMS)'
				)
			)
		);

		$sap->add_setting(
            'rtb-settings',
            'rtb-reservation-reminders',
            'count',
            array(
                'id'            => 'time-reminder-user',
                'title'            => __( 'Reservation Reminder Before Time', 'restaurant-reservations' ),
                'description'    => __( 'How long before a reservation should a reminder email be sent? Leave blank to not send a reservation reminder.', 'restaurant-reservations' ),
                'min_value'        => 1,
                'max_value'        => 60,
                'increment'        => 1,
                'units'            => array(
                                    'minutes'     => 'Minutes',
                                    'hours'        => 'Hours',
                                    'days'        => 'Days'
                )
            )
        );

		$sap->add_setting(
		 	'rtb-settings',
		 	'rtb-reservation-reminders',
		 	'text',
		 	array(
		 		'id'			=> 'subject-reminder-user',
		 		'title'			=> __( 'Reservation Reminder Email Subject', 'restaurant-reservations' ),
		 		'description'	=> __( 'The email subject a user should receive as a reminder about their reservation.', 'restaurant-reservations' ),
		 		'placeholder'	=> $this->defaults['subject-reminder-user'],
		 	)
		);

		$sap->add_setting(
		 	'rtb-settings',
		 	'rtb-reservation-reminders',
		 	'editor',
		 	array(
		 		'id'			=> 'template-reminder-user',
		 		'title'			=> __( 'Reservation Reminder Email', 'restaurant-reservations' ),
		 		'description'	=> __( 'Enter the email a user should receive as a reminder about their reservation.', 'restaurant-reservations' ),
		 		'default'		=> $this->defaults['template-reminder-user'],
		 	)
		);

		$sap->add_setting(
		 	'rtb-settings',
		 	'rtb-reservation-reminders',
		 	'count',
		 	array(
		 		'id'			=> 'time-late-user',
		 		'title'			=> __( 'Late for Reservation Time', 'restaurant-reservations' ),
		 		'description'	=> __( 'How long after being late for a reservation should a late arrival email be sent? Leave blank to not send a late arrival email.', 'restaurant-reservations' ),
		 		'min_value'		=> 1,
		 		'max_value'		=> 60,
		 		'increment'		=> 1,
		 		'units'			=> array(
		 							'minutes' 	=> 'Minutes',
		 							'hours'		=> 'Hours',
		 		)
		 	)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-reminders',
			'text',
			array(
				'id'			=> 'subject-late-user',
				'title'			=> __( 'Late for Reservation Email Subject', 'restaurant-reservations' ),
				'description'	=> __( 'The email subject a user should receive when they are late for their reservation.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['subject-late-user'],
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-reminders',
			'editor',
			array(
				'id'			=> 'template-late-user',
				'title'			=> __( 'Late for Reservation Email', 'restaurant-reservations' ),
				'description'	=> __( 'Enter the email a user should receive when they are late for their reservation.', 'restaurant-reservations' ),
				'default'		=> $this->defaults['template-late-user'],
			)
		);

		$sap->add_section(
			'rtb-settings',
			array(
				'id' => 'rtb-notifications-advanced',
				'title' => __( 'Advanced', 'restaurant-reservations' ),
				'description' => __( "Modifying the settings below can prevent your emails from being delivered. Do not make changes unless you know what you're doing.", 'restaurant-reservations' ),
				'tab' => 'rtb-notifications-tab',
			)
		);

		$sap->add_section(
			'rtb-settings',
			array(
				'id' => 'rtb-notifications-advanced',
				'title' => __( 'Advanced', 'restaurant-reservations' ),
				'description' => __( "Modifying the settings below can prevent your emails from being delivered. Do not make changes unless you know what you're doing.", 'restaurant-reservations' ),
				'tab' => 'rtb-notifications-tab',
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-notifications-advanced',
			'text',
			array(
				'id'			=> 'from-email-address',
				'title'			=> __( 'FROM Email Address Header', 'restaurant-reservations' ),
				'description'	=> sprintf( __( "Change the email address used in the FROM header of all emails sent by this plugin. In most cases you should not change this. Modifying this can prevent your emails from being delivered. %sLearn more%s.", 'restaurant-reservations' ), '<a href="http://doc.fivestarplugins.com/plugins/restaurant-reservations/user/faq#no-emails-from-header">', '</a>' ),
				'placeholder'	=> $this->defaults['from-email-address'],
			)
		);

		if ( ! $rtb_controller->permissions->check_permission('payments') ) {
			$payment_permissions = array(
				'disabled'			=> true,
				'disabled_image'	=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'		=> 'https://www.fivestarplugins.com/plugins/five-star-restaurant-reservations/',
				'ultimate_needed'	=> 'Yes'
			);
		}
		else { $payment_permissions = array(); }

		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-payments-tab',
				'title'         => __( 'Payments', 'restaurant-reservations' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'rtb-settings',
			array_merge(
				array(
					'id'            => 'rtb-general-payment',
					'title'         => __( 'General', 'restaurant-reservations' ),
					'tab'	          => 'rtb-payments-tab',
				),
				$payment_permissions
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-general-payment',
			'toggle',
			array(
				'id'			=> 'require-deposit',
				'title'			=> __( 'Require Deposit', 'restaurant-reservations' ),
				'description'			=> __( 'Require guests to make a deposit when making a reservation.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-general-payment',
			'radio',
			array(
				'id'			=> 'rtb-payment-gateway',
				'title'			=> __( 'Payment Gateway', 'restaurant-reservations' ),
				'description'	=> __( 'Which payment gateway should be used to accept deposits.', 'restaurant-reservations' ),
				'options'		=> array(
					'paypal'		=> 'PayPal',
					'stripe'		=> 'Stripe'
				)
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-general-payment',
			'radio',
			array(
				'id'			=> 'rtb-deposit-type',
				'title'			=> __( 'Deposit Type', 'restaurant-reservations' ),
				'description'	=> __( 'What type of deposit should be required, per reservation or per guest?', 'restaurant-reservations' ),
				'options'		=> array(
					'reservation'	=> 'Per Reservation',
					'guest'			=> 'Per Guest'
				)
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-general-payment',
			'text',
			array(
				'id'            => 'rtb-deposit-amount',
				'title'         => __( 'Deposit Amount', 'restaurant-reservations' ),
				'description'   => __( 'What deposit amount is required (either per reservation or per guest, depending on the setting above).', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-general-payment',
			'select',
			array(
				'id'            => 'rtb-currency',
				'title'         => __( 'Currency', 'restaurant-reservations' ),
				'description'   => __( 'Select the currency you accept for your deposits.', 'restaurant-reservations' ),
				'blank_option'	=> false,
				'options'       => $this->currency_options
			)
		);

		$sap->add_section(
			'rtb-settings',
			array_merge(
				array(
					'id'            => 'rtb-paypal-payment',
					'title'         => __( 'PayPal', 'restaurant-reservations' ),
					'tab'	          => 'rtb-payments-tab',
				),
				$payment_permissions
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-paypal-payment',
			'text',
			array(
				'id'            => 'rtb-paypal-email',
				'title'         => __( 'PayPal Email Address', 'restaurant-reservations' ),
				'description'   => __( 'The email address you\'ll be using to accept PayPal payments.', 'restaurant-reservations' ),
				'placeholder'	=>$this->defaults['rtb-paypal-email']
			)
		);

		$sap->add_section(
			'rtb-settings',
			array_merge(
				array(
					'id'            => 'rtb-stripe-payment',
					'title'         => __( 'Stripe', 'restaurant-reservations' ),
					'tab'	          => 'rtb-payments-tab',
				),
				$payment_permissions
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-stripe-payment',
			'text',
			array(
				'id'            => 'rtb-stripe-currency-symbol',
				'title'         => __( 'Stripe Currency Symbol', 'restaurant-reservations' ),
				'description'   => __( 'The currency symbol you\'d like displayed before or after the required deposit amount.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['rtb-stripe-currency-symbol']
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-stripe-payment',
			'radio',
			array(
				'id'			=> 'rtb-currency-symbol-location',
				'title'			=> __( 'Currency Symbol Location', 'restaurant-reservations' ),
				'description'	=> __( 'Should the currency symbol be placed before or after the deposit amount?', 'restaurant-reservations' ),
				'options'		=> array(
					'before'		=> 'Before',
					'after'			=> 'After'
				)
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-stripe-payment',
			'radio',
			array(
				'id'			=> 'rtb-stripe-mode',
				'title'			=> __( 'Test/Live Mode', 'restaurant-reservations' ),
				'description'	=> __( 'Should the system use test or live mode? Test mode should only be used for testing, no deposits will actually be processed while turned on.', 'restaurant-reservations' ),
				'options'		=> array(
					'test'			=> 'Test',
					'live'			=> 'Live'
				)
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-stripe-payment',
			'text',
			array(
				'id'            => 'rtb-stripe-live-secret',
				'title'         => __( 'Stripe Live Secret', 'restaurant-reservations' ),
				'description'   => __( 'The live secret that you have set up for your Stripe account.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-stripe-payment',
			'text',
			array(
				'id'            => 'rtb-stripe-live-publishable',
				'title'         => __( 'Stripe Live Publishable', 'restaurant-reservations' ),
				'description'   => __( 'The live publishable that you have set up for your Stripe account.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-stripe-payment',
			'text',
			array(
				'id'            => 'rtb-stripe-test-secret',
				'title'         => __( 'Stripe Test Secret', 'restaurant-reservations' ),
				'description'   => __( 'The test secret that you have set up for your Stripe account. Only needed for testing payments.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-stripe-payment',
			'text',
			array(
				'id'            => 'rtb-stripe-test-publishable',
				'title'         => __( 'Stripe Test Publishable', 'restaurant-reservations' ),
				'description'   => __( 'The test publishable that you have set up for your Stripe account. Only needed for testing payments.', 'restaurant-reservations' )
			)
		);

		if ( ! $rtb_controller->permissions->check_permission('export') ) {
			$export_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'	=> 'https://www.fivestarplugins.com/plugins/five-star-restaurant-reservations/'
			);
		}
		else { $export_permissions = array(); }

		//Create a tab for export settings
		$sap->add_section(
			'rtb-settings',
			array(
				'id'            => 'rtb-export-tab',
				'title'         => _x( 'Export', 'Label for the Export tab in the settings page', 'restaurant-reservations' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'rtb-settings',
			array_merge(
				array(
					'id'            => 'rtb-export',
					'title'         => __( 'Settings', 'restaurant-reservations' ),
					'tab'	        => 'rtb-export-tab',
				),
				$export_permissions
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-export',
			'select',
			array(
				'id'            => 'ebfrtb-paper-size',
				'title'         => __( 'Paper Size', 'restaurant-reservations' ),
				'description'   => __( 'Select your preferred paper size.', 'restaurant-reservations' ),
				'blank_option'	=> false,
				'options'       => array(
					'A4'		=> 'A4',
					'LETTER'	=> 'Letter (U.S.)',
				)
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-export',
			'select',
			array(
				'id'            => 'ebfrtb-pdf-lib',
				'title'         => __( 'PDF Renderer', 'restaurant-reservations' ),
				'description'   => __( 'mPDF looks nicer but is not compatible with all servers. Select TCPDF only if you get errors when trying to export a PDF.', 'restaurant-reservations' ),
				'blank_option'	=> false,
				'options'       => array(
					'mpdf'	=> 'mPDF',
					'tcpdf'	=> 'TCPDF',
				),
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-export',
			'text',
			array(
				'id'            => 'ebfrtb-csv-date-format',
				'title'         => __( 'Excel/CSV Date Format', 'restaurant-reservations' ),
				'description'   => __( 'Enter a custom date format to be used when generating Excel/CSV exports if you want the format to be different than your WordPress setting. This is useful if you need the date in a machine-readable format.', 'restaurant-reservations' ),
				'placeholder'	=> $this->defaults['ebfrtb-csv-date-format'],
			)
		);

		if ( ! $rtb_controller->permissions->check_permission('styling') ) {
			$styling_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> 'https://www.etoilewebdesign.com/wp-content/uploads/2018/06/Logo-White-Filled40-px.png',
				'purchase_link'	=> 'https://www.fivestarplugins.com/plugins/five-star-restaurant-reservations/'
			);
		}
		else { $styling_permissions = array(); }

		// Create a tab for styling settings
		$sap->add_section(
			'rtb-settings',
			array(
				'id'			=> 'rtb-styling-settings-tab',
				'title'			=> __( 'Styling', 'restaurant-reservations' ),
				'is_tab'		=> true
			)
		);

		$sap->add_section(
			'rtb-settings',
			array_merge(
				array(
					'id'            => 'rtb-reservation-form-styling',
					'title'         => __( 'Reservation Form', 'restaurant-reservations' ),
					'tab'	          => 'rtb-styling-settings-tab',
				),
				$styling_permissions
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'radio',
			array(
				'id'			=> 'rtb-styling-layout',
				'title'			=> __( 'Layout', 'restaurant-reservations' ),
				'description'	=> __( 'Choose which layout you want to use for your reservation form', 'restaurant-reservations' ),
				'options'		=> array(
					'default'		=> 'Default',
					'contemporary'	=> 'Contemporary',
					'columns'		=> 'Columns',
				)
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'text',
			array(
				'id'			=> 'rtb-styling-section-title-font-family',
				'title'			=> __( 'Section Title Font Family', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the font family for the section titles. (Please note that the font family must already be loaded on the site. This does not load it.)', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'text',
			array(
				'id'			=> 'rtb-styling-section-title-font-size',
				'title'			=> __( 'Section Title Font Size', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the font size for the section titles. Include the unit (e.g. 20px or 2em).', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-section-title-color',
				'title'			=> __( 'Section Title Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the color for the section titles.', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-section-background-color',
				'title'			=> __( 'Section Background Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the background color for the form sections.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'text',
			array(
				'id'			=> 'rtb-styling-section-border-size',
				'title'			=> __( 'Section Border Size', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the border size for the form sections (in the default layout). Include the unit (e.g. 2px).', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-section-border-color',
				'title'			=> __( 'Section Border Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the color for the section border (in the default layout).', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'text',
			array(
				'id'			=> 'rtb-styling-label-font-family',
				'title'			=> __( 'Label Font Family', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the font family for the form field labels. (Please note that the font family must already be loaded on the site. This does not load it.)', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'text',
			array(
				'id'			=> 'rtb-styling-label-font-size',
				'title'			=> __( 'Label Font Size', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the font size for the form field labels. Include the unit (e.g. 20px or 2em).', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-label-color',
				'title'			=> __( 'Label Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the color for the form field labels.', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-add-message-button-background-color',
				'title'			=> __( '"Add a Message" Button Background Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the background color for the "Add a Message" button.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-add-message-button-background-hover-color',
				'title'			=> __( '"Add a Message" Button Background Hover Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the background color for the "Add a Message" button on hover.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-add-message-button-text-color',
				'title'			=> __( '"Add a Message" Button Text Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the text color for the "Add a Message" button.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-add-message-button-text-hover-color',
				'title'			=> __( '"Add a Message" Button Text Hover Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the text color for the "Add a Message" button on hover.', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-request-booking-button-background-color',
				'title'			=> __( '"Request Booking" Button Background Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the background color for the "Request Booking" button.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-request-booking-button-background-hover-color',
				'title'			=> __( '"Request Booking" Button Background Hover Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the background color for the "Request Booking" button on hover.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-request-booking-button-text-color',
				'title'			=> __( '"Request Booking" Button Text Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the text color for the "Request Booking" button.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-request-booking-button-text-hover-color',
				'title'			=> __( '"Request Booking" Button Text Hover Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the text color for the "Request Booking" button on hover.', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-cancel-button-background-color',
				'title'			=> __( 'Cancel Reservation Button Background Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the background color for the cancel reservation toggle button button.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-cancel-button-background-hover-color',
				'title'			=> __( 'Cancel Reservation Button Background Hover Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the background color for the cancel reservation toggle button on hover.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-cancel-button-text-color',
				'title'			=> __( 'Cancel Reservation Text Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the text color for the cancel reservation toggle button.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-cancel-button-text-hover-color',
				'title'			=> __( 'Cancel Reservation Text Hover Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the text color for the cancel reservation toggle button on hover.', 'restaurant-reservations' )
			)
		);

		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-find-reservations-button-background-color',
				'title'			=> __( '"Find Reservations" Button Background Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the background color for the "Find Reservations" button.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-find-reservations-button-background-hover-color',
				'title'			=> __( '"Find Reservations" Button Background Hover Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the background color for the "Find Reservations" button on hover.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-find-reservations-button-text-color',
				'title'			=> __( '"Find Reservations" Button Text Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the text color for the "Find Reservations" button.', 'restaurant-reservations' )
			)
		);
		$sap->add_setting(
			'rtb-settings',
			'rtb-reservation-form-styling',
			'colorpicker',
			array(
				'id'			=> 'rtb-styling-find-reservations-button-text-hover-color',
				'title'			=> __( '"Find Reservations" Button Text Hover Color', 'restaurant-reservations' ),
				'description'	=> __( 'Choose the text color for the "Find Reservations" button on hover.', 'restaurant-reservations' )
			)
		);

		$sap = apply_filters( 'rtb_settings_page', $sap );

		$sap->add_admin_menus();

	}

	/**
	 * Get options for the party size setting
	 * @since 1.3
	 */
	public function get_party_size_setting_options( $max = true ) {

		$options = array();

		if ( $max ) {
			$options[''] = __( 'Any size', 'restaurant-reservations' );
		}

		$max = apply_filters( 'rtb_party_size_upper_limit', 100 );

		for ( $i = 1; $i <= $max; $i++ ) {
			$options[$i] = $i;
		}

		return apply_filters( 'rtb_party_size_setting_options', $options );
	}

	/**
	 * Get options for the party select field in the booking form
	 * @since 1.3
	 */
	public function get_form_party_options() {

		$options = array();

		$party_size = (int) $this->get_setting( 'party-size' );
		$party_size_min = (int) $this->get_setting( 'party-size-min' );

		$min = empty( $party_size_min ) ? 1 : (int) $this->get_setting( 'party-size-min' );
		$max = empty( $party_size ) ? apply_filters( 'rtb_party_size_upper_limit', 100 ) : (int) $this->get_setting( 'party-size' );

		for ( $i = $min; $i <= $max; $i++ ) {
			$options[$i] = $i;
		}

		return apply_filters( 'rtb_form_party_options', $options );
	}

	/**
	 * Retrieve form fields
	 *
	 * @param $request rtbBooking Details of a booking request made
	 * @param $args array Associative array of arguments to pass to the field:
	 *  `location` int Location post id
	 * @since 1.3
	 */
	public function get_booking_form_fields( $request = null, $args = array() ) {

		global $rtb_controller;

		// $request will represent a rtbBooking object with the request
		// details when the form is being printed and $_POST data exists
		// to populate the request. All other times $request will just
		// be an empty object
		if ( $request === null ) {
			$request = $rtb_controller->request;
		}

		/**
		 * This array defines the field details and a callback function to
		 * render each field. To customize the form output, modify the
		 * callback functions to point to your custom function. Don't forget
		 * to output an error message in your custom callback function. You
		 * can use rtb_print_form_error( $slug ) to do this.
		 *
		 * In addition to the parameters described below, each fieldset
		 * and field can accept a `classes` array in the callback args since
		 * v1.3. These classes will be appended to the <fieldset> and
		 * <div> elements for each field. A fieldset can also take a
		 * `legend_classes` array in the callback_args which will be
		 * added to the legend element.
		 *
		 * Example:
		 *
		 * 	$fields = array(
		 * 		'fieldset'	=> array(
		 * 			'legend'	=> __( 'My Legend', 'restaurant-reservations' ),
		 * 			'callback_args'	=> array(
		 * 				'classes'		=> array( 'fieldset-class', 'other-fieldset-class' ),
		 * 				'legend_classes	=> array( 'legend-class' ),
		 *			),
		 * 			'fields'	=> array(
		 * 				'my-field'	=> array(
		 * 					...
		 * 					'callback_args'	=> array(
		 * 						'classes'	=> array( 'field-class' ),
		 *					)
		 * 				)
		 * 			)
		 * 		)
		 * 	);
		 *
		 * See /includes/template-functions.php
		 */
		$fields = array(

			// Reservation details fieldset
			'reservation'	=> array(
				'legend'	=> __( 'Book a table', 'restaurant-reservations' ),
				'fields'	=> array(
					'date'		=> array(
						'title'			=> __( 'Date', 'restaurant-reservations' ),
						'request_input'	=> empty( $request->request_date ) ? '' : $request->request_date,
						'callback'		=> 'rtb_print_form_text_field',
						'required'		=> true,
					),
					'time'		=> array(
						'title'			=> __( 'Time', 'restaurant-reservations' ),
						'request_input'	=> empty( $request->request_time ) ? '' : $request->request_time,
						'callback'		=> 'rtb_print_form_text_field',
						'required'		=> true,
					),
					'party'		=> array(
						'title'			=> __( 'Party', 'restaurant-reservations' ),
						'request_input'	=> empty( $request->party ) ? '' : $request->party,
						'callback'		=> 'rtb_print_form_select_field',
						'callback_args'	=> array(
							'options'	=> $this->get_form_party_options(),
						),
						'required'		=> true,
					),
				),
			),

			// Contact details fieldset
			'contact'	=> array(
				'legend'	=> __( 'Contact Details', 'restaurant-reservations' ),
				'fields'	=> array(
					'name'		=> array(
						'title'			=> __( 'Name', 'restaurant-reservations' ),
						'request_input'	=> empty( $request->name ) ? '' : $request->name,
						'callback'		=> 'rtb_print_form_text_field',
						'required'		=> true,
					),
					'email'		=> array(
						'title'			=> __( 'Email', 'restaurant-reservations' ),
						'request_input'	=> empty( $request->email ) ? '' : $request->email,
						'callback'		=> 'rtb_print_form_text_field',
						'callback_args'	=> array(
							'input_type'	=> 'email',
						),
						'required'		=> true,
					),
					'phone'		=> array(
						'title'			=> __( 'Phone', 'restaurant-reservations' ),
						'request_input'	=> empty( $request->phone ) ? '' : $request->phone,
						'callback'		=> 'rtb_print_form_text_field',
						'callback_args'	=> array(
							'input_type'	=> 'tel',
						),
					),
					'add-message'	=> array(
						'title'		=> __( 'Add a Message', 'restaurant-reservations' ),
						'request_input'	=> '',
						'callback'	=> 'rtb_print_form_message_link',
					),
					'message'		=> array(
						'title'			=> __( 'Message', 'restaurant-reservations' ),
						'request_input'	=> empty( $request->message ) ? '' : $request->message,
						'callback'		=> 'rtb_print_form_textarea_field',
					),
				),
			),
		);

		// Add a consent request if setting is selected and it's not the admin page
		$require_consent = $rtb_controller->settings->get_setting( 'require-consent' );
		$consent_statement = $rtb_controller->settings->get_setting( 'consent-statement' );
		$privacy_page = $rtb_controller->settings->get_setting( 'privacy-page' );
		if ( !is_admin() && $require_consent && $consent_statement ) {

			if ( $privacy_page && get_post_status( $privacy_page ) !== false ) {
				$consent_statement .= sprintf(' <a href="%s">%s</a>', get_permalink( $privacy_page ), get_the_title( $privacy_page ) );
			}

			$fields['consent'] = array(
				'fields' => array(
					'consent-statement' => array(
						'title' => $consent_statement,
						'request_input' => empty( $request->consent_statement ) ? '' : $request->consent_statement,
						'callback' => 'rtb_print_form_confirm_field',
						'required' => true,
					),
				),
				'order' => 900,
			);
		}

		return apply_filters( 'rtb_booking_form_fields', $fields, $request, $args );
	}

	/**
	 * Get required fields
	 *
	 * Filters the fields array to return just those marked required
	 * @since 1.3
	 */
	public function get_required_fields() {

		$required_fields = array();

		$fieldsets = $this->get_booking_form_fields();
		foreach ( $fieldsets as $fieldset ) {
			$required_fields = array_merge( $required_fields, array_filter( $fieldset['fields'], array( $this, 'is_field_required' ) ) );
		}

		return $required_fields;
	}

	/**
	 * Check if a field is required
	 *
	 * @since 1.3
	 */
	public function is_field_required( $field ) {
		return !empty( $field['required'] );
	}

	/**
	 * Render HTML code of descriptions for the template tags
	 * @since 1.2.3
	 */
	public function render_template_tag_descriptions() {

		$descriptions = apply_filters( 'rtb_notification_template_tag_descriptions', array(
				'{user_email}'		=> __( 'Email of the user who made the booking', 'restaurant-reservations' ),
				'{user_name}'		=> __( '* Name of the user who made the booking', 'restaurant-reservations' ),
				'{party}'			=> __( '* Number of people booked', 'restaurant-reservations' ),
				'{date}'			=> __( '* Date and time of the booking', 'restaurant-reservations' ),
				'{phone}'			=> __( 'Phone number if supplied with the request', 'restaurant-reservations' ),
				'{message}'			=> __( 'Message added to the request', 'restaurant-reservations' ),
				'{bookings_link}'	=> __( 'A link to the admin panel showing pending bookings', 'restaurant-reservations' ),
				'{cancel_link}'		=> __( 'A link that a guest can use to cancel their booking if cancellations are enabled', 'restaurant-reservations' ),
				'{confirm_link}'	=> __( 'A link to confirm this booking. Only include this in admin notifications', 'restaurant-reservations' ),
				'{close_link}'		=> __( 'A link to reject this booking. Only include this in admin notifications', 'restaurant-reservations' ),
				'{site_name}'		=> __( 'The name of this website', 'restaurant-reservations' ),
				'{site_link}'		=> __( 'A link to this website', 'restaurant-reservations' ),
				'{current_time}'	=> __( 'Current date and time', 'restaurant-reservations' ),
			)
		);

		$output = '';

		foreach ( $descriptions as $tag => $description ) {
			$output .= '
				<div class="rtb-template-tags-box">
					<strong>' . $tag . '</strong> ' . $description . '
				</div>';
		}

		return $output;
	}

	/**
	 * Sort the schedule exceptions and remove past exceptions before saving
	 *
	 * @since 1.4.6
	 */
	public function clean_schedule_exceptions( $val ) {

		if ( empty( $val['schedule-closed'] ) ) {
			return $val;
		}

		// Sort by date
		$schedule_closed = $val['schedule-closed'];
		usort( $schedule_closed, array( $this, 'sort_by_date' ) );

		// Remove exceptions more than a week old
		$week_ago = time() - 604800;
		for( $i = 0; $i < count( $schedule_closed ); $i++ ) {
			if ( strtotime( $schedule_closed[$i]['date'] ) > $week_ago ) {
				break;
			}
		}
		if ( $i ) {
			$schedule_closed = array_slice( $schedule_closed, $i );
		}

		$val['schedule-closed'] = $schedule_closed;

		return $val;
	}

	/**
	 * Sort an associative array by the value's date parameter
	 *
	 * @usedby self::clean_schedule_exceptions()
	 * @since 0.1
	 */
	public function sort_by_date( $a, $b ) {

		$ad = empty( $a['date'] ) ? 0 : strtotime( $a['date'] );
		$bd = empty( $b['date'] ) ? 0 : strtotime( $b['date'] );

		return $ad - $bd;
	}

}
} // endif;
