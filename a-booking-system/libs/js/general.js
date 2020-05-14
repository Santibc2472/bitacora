Date.prototype.getWeek = function() {
    var januaryDay = new Date(this.getFullYear(),0,1);
    var timeday = 86400000;
    return Math.ceil((((this - januaryDay) /timeday) + januaryDay.getDay()+1)/7);
};

Date.prototype.getWeeks = function() {
  var year = new Date(this.getFullYear());
  var month = 11, day = 31, week;

  // Find week that 31 Dec is in. If is first week, reduce date until
  // get previous week.
  do {
    d = new Date(year, month, day--);
    week = d.getWeek();
  } while (week == 1);

  return week;
};

if (!Object.assign) {
  Object.defineProperty(Object, 'assign', {
    enumerable: false,
    configurable: true,
    writable: true,
    value: function(target) {
      'use strict';
      if (target === undefined || target === null) {
        throw new TypeError('Cannot convert first argument to object');
      }

      var to = Object(target);
      for (var i = 1; i < arguments.length; i++) {
        var nextSource = arguments[i];
        if (nextSource === undefined || nextSource === null) {
          continue;
        }
        nextSource = Object(nextSource);

        var keysArray = Object.keys(nextSource);
        for (var nextIndex = 0, len = keysArray.length; nextIndex < len; nextIndex++) {
          var nextKey = keysArray[nextIndex];
          var desc = Object.getOwnPropertyDescriptor(nextSource, nextKey);
          if (desc !== undefined && desc.enumerable) {
            to[nextKey] = nextSource[nextKey];
          }
        }
      }
      return to;
    }
  });
}

(function($){
  
  /*
   * General
   */
  var abookingsystemdashboardGeneral = {
      currencies: {
          data: {"USD":{"symbol":"$","name":"US Dollar","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"USD","name_plural":"US dollars"},"CAD":{"symbol":"CA$","name":"Canadian Dollar","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"CAD","name_plural":"Canadian dollars"},"EUR":{"symbol":"€","name":"Euro","symbol_native":"€","decimal_digits":2,"rounding":0,"code":"EUR","name_plural":"euros"},"AED":{"symbol":"AED","name":"United Arab Emirates Dirham","symbol_native":"د.إ.‏","decimal_digits":2,"rounding":0,"code":"AED","name_plural":"UAE dirhams"},"AFN":{"symbol":"Af","name":"Afghan Afghani","symbol_native":"؋","decimal_digits":0,"rounding":0,"code":"AFN","name_plural":"Afghan Afghanis"},"ALL":{"symbol":"ALL","name":"Albanian Lek","symbol_native":"Lek","decimal_digits":0,"rounding":0,"code":"ALL","name_plural":"Albanian lekë"},"AMD":{"symbol":"AMD","name":"Armenian Dram","symbol_native":"դր.","decimal_digits":0,"rounding":0,"code":"AMD","name_plural":"Armenian drams"},"ARS":{"symbol":"AR$","name":"Argentine Peso","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"ARS","name_plural":"Argentine pesos"},"AUD":{"symbol":"AU$","name":"Australian Dollar","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"AUD","name_plural":"Australian dollars"},"AZN":{"symbol":"man.","name":"Azerbaijani Manat","symbol_native":"ман.","decimal_digits":2,"rounding":0,"code":"AZN","name_plural":"Azerbaijani manats"},"BAM":{"symbol":"KM","name":"Bosnia-Herzegovina Convertible Mark","symbol_native":"KM","decimal_digits":2,"rounding":0,"code":"BAM","name_plural":"Bosnia-Herzegovina convertible marks"},"BDT":{"symbol":"Tk","name":"Bangladeshi Taka","symbol_native":"৳","decimal_digits":2,"rounding":0,"code":"BDT","name_plural":"Bangladeshi takas"},"BGN":{"symbol":"BGN","name":"Bulgarian Lev","symbol_native":"лв.","decimal_digits":2,"rounding":0,"code":"BGN","name_plural":"Bulgarian leva"},"BHD":{"symbol":"BD","name":"Bahraini Dinar","symbol_native":"د.ب.‏","decimal_digits":3,"rounding":0,"code":"BHD","name_plural":"Bahraini dinars"},"BIF":{"symbol":"FBu","name":"Burundian Franc","symbol_native":"FBu","decimal_digits":0,"rounding":0,"code":"BIF","name_plural":"Burundian francs"},"BND":{"symbol":"BN$","name":"Brunei Dollar","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"BND","name_plural":"Brunei dollars"},"BOB":{"symbol":"Bs","name":"Bolivian Boliviano","symbol_native":"Bs","decimal_digits":2,"rounding":0,"code":"BOB","name_plural":"Bolivian bolivianos"},"BRL":{"symbol":"R$","name":"Brazilian Real","symbol_native":"R$","decimal_digits":2,"rounding":0,"code":"BRL","name_plural":"Brazilian reals"},"BWP":{"symbol":"BWP","name":"Botswanan Pula","symbol_native":"P","decimal_digits":2,"rounding":0,"code":"BWP","name_plural":"Botswanan pulas"},"BYR":{"symbol":"BYR","name":"Belarusian Ruble","symbol_native":"BYR","decimal_digits":0,"rounding":0,"code":"BYR","name_plural":"Belarusian rubles"},"BZD":{"symbol":"BZ$","name":"Belize Dollar","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"BZD","name_plural":"Belize dollars"},"CDF":{"symbol":"CDF","name":"Congolese Franc","symbol_native":"FrCD","decimal_digits":2,"rounding":0,"code":"CDF","name_plural":"Congolese francs"},"CHF":{"symbol":"CHF","name":"Swiss Franc","symbol_native":"CHF","decimal_digits":2,"rounding":0.05,"code":"CHF","name_plural":"Swiss francs"},"CLP":{"symbol":"CL$","name":"Chilean Peso","symbol_native":"$","decimal_digits":0,"rounding":0,"code":"CLP","name_plural":"Chilean pesos"},"CNY":{"symbol":"CN¥","name":"Chinese Yuan","symbol_native":"CN¥","decimal_digits":2,"rounding":0,"code":"CNY","name_plural":"Chinese yuan"},"COP":{"symbol":"CO$","name":"Colombian Peso","symbol_native":"$","decimal_digits":0,"rounding":0,"code":"COP","name_plural":"Colombian pesos"},"CRC":{"symbol":"₡","name":"Costa Rican Colón","symbol_native":"₡","decimal_digits":0,"rounding":0,"code":"CRC","name_plural":"Costa Rican colóns"},"CVE":{"symbol":"CV$","name":"Cape Verdean Escudo","symbol_native":"CV$","decimal_digits":2,"rounding":0,"code":"CVE","name_plural":"Cape Verdean escudos"},"CZK":{"symbol":"Kč","name":"Czech Republic Koruna","symbol_native":"Kč","decimal_digits":2,"rounding":0,"code":"CZK","name_plural":"Czech Republic korunas"},"DJF":{"symbol":"Fdj","name":"Djiboutian Franc","symbol_native":"Fdj","decimal_digits":0,"rounding":0,"code":"DJF","name_plural":"Djiboutian francs"},"DKK":{"symbol":"Dkr","name":"Danish Krone","symbol_native":"kr","decimal_digits":2,"rounding":0,"code":"DKK","name_plural":"Danish kroner"},"DOP":{"symbol":"RD$","name":"Dominican Peso","symbol_native":"RD$","decimal_digits":2,"rounding":0,"code":"DOP","name_plural":"Dominican pesos"},"DZD":{"symbol":"DA","name":"Algerian Dinar","symbol_native":"د.ج.‏","decimal_digits":2,"rounding":0,"code":"DZD","name_plural":"Algerian dinars"},"EEK":{"symbol":"Ekr","name":"Estonian Kroon","symbol_native":"kr","decimal_digits":2,"rounding":0,"code":"EEK","name_plural":"Estonian kroons"},"EGP":{"symbol":"EGP","name":"Egyptian Pound","symbol_native":"ج.م.‏","decimal_digits":2,"rounding":0,"code":"EGP","name_plural":"Egyptian pounds"},"ERN":{"symbol":"Nfk","name":"Eritrean Nakfa","symbol_native":"Nfk","decimal_digits":2,"rounding":0,"code":"ERN","name_plural":"Eritrean nakfas"},"ETB":{"symbol":"Br","name":"Ethiopian Birr","symbol_native":"Br","decimal_digits":2,"rounding":0,"code":"ETB","name_plural":"Ethiopian birrs"},"GBP":{"symbol":"£","name":"British Pound Sterling","symbol_native":"£","decimal_digits":2,"rounding":0,"code":"GBP","name_plural":"British pounds sterling"},"GEL":{"symbol":"GEL","name":"Georgian Lari","symbol_native":"GEL","decimal_digits":2,"rounding":0,"code":"GEL","name_plural":"Georgian laris"},"GHS":{"symbol":"GH₵","name":"Ghanaian Cedi","symbol_native":"GH₵","decimal_digits":2,"rounding":0,"code":"GHS","name_plural":"Ghanaian cedis"},"GNF":{"symbol":"FG","name":"Guinean Franc","symbol_native":"FG","decimal_digits":0,"rounding":0,"code":"GNF","name_plural":"Guinean francs"},"GTQ":{"symbol":"GTQ","name":"Guatemalan Quetzal","symbol_native":"Q","decimal_digits":2,"rounding":0,"code":"GTQ","name_plural":"Guatemalan quetzals"},"HKD":{"symbol":"HK$","name":"Hong Kong Dollar","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"HKD","name_plural":"Hong Kong dollars"},"HNL":{"symbol":"HNL","name":"Honduran Lempira","symbol_native":"L","decimal_digits":2,"rounding":0,"code":"HNL","name_plural":"Honduran lempiras"},"HRK":{"symbol":"kn","name":"Croatian Kuna","symbol_native":"kn","decimal_digits":2,"rounding":0,"code":"HRK","name_plural":"Croatian kunas"},"HUF":{"symbol":"Ft","name":"Hungarian Forint","symbol_native":"Ft","decimal_digits":0,"rounding":0,"code":"HUF","name_plural":"Hungarian forints"},"IDR":{"symbol":"Rp","name":"Indonesian Rupiah","symbol_native":"Rp","decimal_digits":0,"rounding":0,"code":"IDR","name_plural":"Indonesian rupiahs"},"ILS":{"symbol":"₪","name":"Israeli New Sheqel","symbol_native":"₪","decimal_digits":2,"rounding":0,"code":"ILS","name_plural":"Israeli new sheqels"},"INR":{"symbol":"Rs","name":"Indian Rupee","symbol_native":"₹","decimal_digits":2,"rounding":0,"code":"INR","name_plural":"Indian rupees"},"IQD":{"symbol":"IQD","name":"Iraqi Dinar","symbol_native":"د.ع.‏","decimal_digits":0,"rounding":0,"code":"IQD","name_plural":"Iraqi dinars"},"IRR":{"symbol":"IRR","name":"Iranian Rial","symbol_native":"﷼","decimal_digits":0,"rounding":0,"code":"IRR","name_plural":"Iranian rials"},"ISK":{"symbol":"Ikr","name":"Icelandic Króna","symbol_native":"kr","decimal_digits":0,"rounding":0,"code":"ISK","name_plural":"Icelandic krónur"},"JMD":{"symbol":"J$","name":"Jamaican Dollar","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"JMD","name_plural":"Jamaican dollars"},"JOD":{"symbol":"JD","name":"Jordanian Dinar","symbol_native":"د.أ.‏","decimal_digits":3,"rounding":0,"code":"JOD","name_plural":"Jordanian dinars"},"JPY":{"symbol":"¥","name":"Japanese Yen","symbol_native":"￥","decimal_digits":0,"rounding":0,"code":"JPY","name_plural":"Japanese yen"},"KES":{"symbol":"Ksh","name":"Kenyan Shilling","symbol_native":"Ksh","decimal_digits":2,"rounding":0,"code":"KES","name_plural":"Kenyan shillings"},"KHR":{"symbol":"KHR","name":"Cambodian Riel","symbol_native":"៛","decimal_digits":2,"rounding":0,"code":"KHR","name_plural":"Cambodian riels"},"KMF":{"symbol":"CF","name":"Comorian Franc","symbol_native":"FC","decimal_digits":0,"rounding":0,"code":"KMF","name_plural":"Comorian francs"},"KRW":{"symbol":"₩","name":"South Korean Won","symbol_native":"₩","decimal_digits":0,"rounding":0,"code":"KRW","name_plural":"South Korean won"},"KWD":{"symbol":"KD","name":"Kuwaiti Dinar","symbol_native":"د.ك.‏","decimal_digits":3,"rounding":0,"code":"KWD","name_plural":"Kuwaiti dinars"},"KZT":{"symbol":"KZT","name":"Kazakhstani Tenge","symbol_native":"тңг.","decimal_digits":2,"rounding":0,"code":"KZT","name_plural":"Kazakhstani tenges"},"LBP":{"symbol":"LB£","name":"Lebanese Pound","symbol_native":"ل.ل.‏","decimal_digits":0,"rounding":0,"code":"LBP","name_plural":"Lebanese pounds"},"LKR":{"symbol":"SLRs","name":"Sri Lankan Rupee","symbol_native":"SL Re","decimal_digits":2,"rounding":0,"code":"LKR","name_plural":"Sri Lankan rupees"},"LTL":{"symbol":"Lt","name":"Lithuanian Litas","symbol_native":"Lt","decimal_digits":2,"rounding":0,"code":"LTL","name_plural":"Lithuanian litai"},"LVL":{"symbol":"Ls","name":"Latvian Lats","symbol_native":"Ls","decimal_digits":2,"rounding":0,"code":"LVL","name_plural":"Latvian lati"},"LYD":{"symbol":"LD","name":"Libyan Dinar","symbol_native":"د.ل.‏","decimal_digits":3,"rounding":0,"code":"LYD","name_plural":"Libyan dinars"},"MAD":{"symbol":"MAD","name":"Moroccan Dirham","symbol_native":"د.م.‏","decimal_digits":2,"rounding":0,"code":"MAD","name_plural":"Moroccan dirhams"},"MDL":{"symbol":"MDL","name":"Moldovan Leu","symbol_native":"MDL","decimal_digits":2,"rounding":0,"code":"MDL","name_plural":"Moldovan lei"},"MGA":{"symbol":"MGA","name":"Malagasy Ariary","symbol_native":"MGA","decimal_digits":0,"rounding":0,"code":"MGA","name_plural":"Malagasy Ariaries"},"MKD":{"symbol":"MKD","name":"Macedonian Denar","symbol_native":"MKD","decimal_digits":2,"rounding":0,"code":"MKD","name_plural":"Macedonian denari"},"MMK":{"symbol":"MMK","name":"Myanma Kyat","symbol_native":"K","decimal_digits":0,"rounding":0,"code":"MMK","name_plural":"Myanma kyats"},"MOP":{"symbol":"MOP$","name":"Macanese Pataca","symbol_native":"MOP$","decimal_digits":2,"rounding":0,"code":"MOP","name_plural":"Macanese patacas"},"MUR":{"symbol":"MURs","name":"Mauritian Rupee","symbol_native":"MURs","decimal_digits":0,"rounding":0,"code":"MUR","name_plural":"Mauritian rupees"},"MXN":{"symbol":"MX$","name":"Mexican Peso","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"MXN","name_plural":"Mexican pesos"},"MYR":{"symbol":"RM","name":"Malaysian Ringgit","symbol_native":"RM","decimal_digits":2,"rounding":0,"code":"MYR","name_plural":"Malaysian ringgits"},"MZN":{"symbol":"MTn","name":"Mozambican Metical","symbol_native":"MTn","decimal_digits":2,"rounding":0,"code":"MZN","name_plural":"Mozambican meticals"},"NAD":{"symbol":"N$","name":"Namibian Dollar","symbol_native":"N$","decimal_digits":2,"rounding":0,"code":"NAD","name_plural":"Namibian dollars"},"NGN":{"symbol":"₦","name":"Nigerian Naira","symbol_native":"₦","decimal_digits":2,"rounding":0,"code":"NGN","name_plural":"Nigerian nairas"},"NIO":{"symbol":"C$","name":"Nicaraguan Córdoba","symbol_native":"C$","decimal_digits":2,"rounding":0,"code":"NIO","name_plural":"Nicaraguan córdobas"},"NOK":{"symbol":"Nkr","name":"Norwegian Krone","symbol_native":"kr","decimal_digits":2,"rounding":0,"code":"NOK","name_plural":"Norwegian kroner"},"NPR":{"symbol":"NPRs","name":"Nepalese Rupee","symbol_native":"नेरू","decimal_digits":2,"rounding":0,"code":"NPR","name_plural":"Nepalese rupees"},"NZD":{"symbol":"NZ$","name":"New Zealand Dollar","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"NZD","name_plural":"New Zealand dollars"},"OMR":{"symbol":"OMR","name":"Omani Rial","symbol_native":"ر.ع.‏","decimal_digits":3,"rounding":0,"code":"OMR","name_plural":"Omani rials"},"PAB":{"symbol":"B/.","name":"Panamanian Balboa","symbol_native":"B/.","decimal_digits":2,"rounding":0,"code":"PAB","name_plural":"Panamanian balboas"},"PEN":{"symbol":"S/.","name":"Peruvian Nuevo Sol","symbol_native":"S/.","decimal_digits":2,"rounding":0,"code":"PEN","name_plural":"Peruvian nuevos soles"},"PHP":{"symbol":"₱","name":"Philippine Peso","symbol_native":"₱","decimal_digits":2,"rounding":0,"code":"PHP","name_plural":"Philippine pesos"},"PKR":{"symbol":"PKRs","name":"Pakistani Rupee","symbol_native":"₨","decimal_digits":0,"rounding":0,"code":"PKR","name_plural":"Pakistani rupees"},"PLN":{"symbol":"zł","name":"Polish Zloty","symbol_native":"zł","decimal_digits":2,"rounding":0,"code":"PLN","name_plural":"Polish zlotys"},"PYG":{"symbol":"₲","name":"Paraguayan Guarani","symbol_native":"₲","decimal_digits":0,"rounding":0,"code":"PYG","name_plural":"Paraguayan guaranis"},"QAR":{"symbol":"QR","name":"Qatari Rial","symbol_native":"ر.ق.‏","decimal_digits":2,"rounding":0,"code":"QAR","name_plural":"Qatari rials"},"RON":{"symbol":"RON","name":"Romanian Leu","symbol_native":"RON","decimal_digits":2,"rounding":0,"code":"RON","name_plural":"Romanian lei"},"RSD":{"symbol":"din.","name":"Serbian Dinar","symbol_native":"дин.","decimal_digits":0,"rounding":0,"code":"RSD","name_plural":"Serbian dinars"},"RUB":{"symbol":"RUB","name":"Russian Ruble","symbol_native":"руб.","decimal_digits":2,"rounding":0,"code":"RUB","name_plural":"Russian rubles"},"RWF":{"symbol":"RWF","name":"Rwandan Franc","symbol_native":"FR","decimal_digits":0,"rounding":0,"code":"RWF","name_plural":"Rwandan francs"},"SAR":{"symbol":"SR","name":"Saudi Riyal","symbol_native":"ر.س.‏","decimal_digits":2,"rounding":0,"code":"SAR","name_plural":"Saudi riyals"},"SDG":{"symbol":"SDG","name":"Sudanese Pound","symbol_native":"SDG","decimal_digits":2,"rounding":0,"code":"SDG","name_plural":"Sudanese pounds"},"SEK":{"symbol":"Skr","name":"Swedish Krona","symbol_native":"kr","decimal_digits":2,"rounding":0,"code":"SEK","name_plural":"Swedish kronor"},"SGD":{"symbol":"S$","name":"Singapore Dollar","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"SGD","name_plural":"Singapore dollars"},"SOS":{"symbol":"Ssh","name":"Somali Shilling","symbol_native":"Ssh","decimal_digits":0,"rounding":0,"code":"SOS","name_plural":"Somali shillings"},"SYP":{"symbol":"SY£","name":"Syrian Pound","symbol_native":"ل.س.‏","decimal_digits":0,"rounding":0,"code":"SYP","name_plural":"Syrian pounds"},"THB":{"symbol":"฿","name":"Thai Baht","symbol_native":"฿","decimal_digits":2,"rounding":0,"code":"THB","name_plural":"Thai baht"},"TND":{"symbol":"DT","name":"Tunisian Dinar","symbol_native":"د.ت.‏","decimal_digits":3,"rounding":0,"code":"TND","name_plural":"Tunisian dinars"},"TOP":{"symbol":"T$","name":"Tongan Paʻanga","symbol_native":"T$","decimal_digits":2,"rounding":0,"code":"TOP","name_plural":"Tongan paʻanga"},"TRY":{"symbol":"TL","name":"Turkish Lira","symbol_native":"TL","decimal_digits":2,"rounding":0,"code":"TRY","name_plural":"Turkish Lira"},"TTD":{"symbol":"TT$","name":"Trinidad and Tobago Dollar","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"TTD","name_plural":"Trinidad and Tobago dollars"},"TWD":{"symbol":"NT$","name":"New Taiwan Dollar","symbol_native":"NT$","decimal_digits":2,"rounding":0,"code":"TWD","name_plural":"New Taiwan dollars"},"TZS":{"symbol":"TSh","name":"Tanzanian Shilling","symbol_native":"TSh","decimal_digits":0,"rounding":0,"code":"TZS","name_plural":"Tanzanian shillings"},"UAH":{"symbol":"₴","name":"Ukrainian Hryvnia","symbol_native":"₴","decimal_digits":2,"rounding":0,"code":"UAH","name_plural":"Ukrainian hryvnias"},"UGX":{"symbol":"USh","name":"Ugandan Shilling","symbol_native":"USh","decimal_digits":0,"rounding":0,"code":"UGX","name_plural":"Ugandan shillings"},"UYU":{"symbol":"$U","name":"Uruguayan Peso","symbol_native":"$","decimal_digits":2,"rounding":0,"code":"UYU","name_plural":"Uruguayan pesos"},"UZS":{"symbol":"UZS","name":"Uzbekistan Som","symbol_native":"UZS","decimal_digits":0,"rounding":0,"code":"UZS","name_plural":"Uzbekistan som"},"VEF":{"symbol":"Bs.F.","name":"Venezuelan Bolívar","symbol_native":"Bs.F.","decimal_digits":2,"rounding":0,"code":"VEF","name_plural":"Venezuelan bolívars"},"VND":{"symbol":"₫","name":"Vietnamese Dong","symbol_native":"₫","decimal_digits":0,"rounding":0,"code":"VND","name_plural":"Vietnamese dong"},"XAF":{"symbol":"FCFA","name":"CFA Franc BEAC","symbol_native":"FCFA","decimal_digits":0,"rounding":0,"code":"XAF","name_plural":"CFA francs BEAC"},"XOF":{"symbol":"CFA","name":"CFA Franc BCEAO","symbol_native":"CFA","decimal_digits":0,"rounding":0,"code":"XOF","name_plural":"CFA francs BCEAO"},"YER":{"symbol":"YR","name":"Yemeni Rial","symbol_native":"ر.ي.‏","decimal_digits":0,"rounding":0,"code":"YER","name_plural":"Yemeni rials"},"ZAR":{"symbol":"R","name":"South African Rand","symbol_native":"R","decimal_digits":2,"rounding":0,"code":"ZAR","name_plural":"South African rand"},"ZMK":{"symbol":"ZK","name":"Zambian Kwacha","symbol_native":"ZK","decimal_digits":0,"rounding":0,"code":"ZMK","name_plural":"Zambian kwachas"}},
          get: function(){
              var myCurrencies = [], i = 0;

              for(var key in abookingsystemdashboardGeneral.currencies.data){

                  myCurrencies[i] = {};
                  myCurrencies[i]['name'] = abookingsystemdashboardGeneral.currencies.data[key]['name']+' ( '+abookingsystemdashboardGeneral.currencies.data[key]['symbol']+' )';
                  myCurrencies[i]['value'] = abookingsystemdashboardGeneral.currencies.data[key]['code'];
                  i++;
              }
            
              return myCurrencies;
          },
          sign: function(code) {
              var sign = '$';

              for(var key in abookingsystemdashboardGeneral.currencies.data){

                  if(code === abookingsystemdashboardGeneral.currencies.data[key]['code']) {
                      return abookingsystemdashboardGeneral.currencies.data[key]['symbol'];
                  }
              }
            
              return sign;
          }
      },
      languages: {
          data: [{"code":"ab","name":"Abkhaz"},{"code":"aa","name":"Afar"},{"code":"af","name":"Afrikaans"},{"code":"ak","name":"Akan"},{"code":"sq","name":"Albanian"},{"code":"am","name":"Amharic"},{"code":"ar","name":"Arabic"},{"code":"an","name":"Aragonese"},{"code":"hy","name":"Armenian"},{"code":"as","name":"Assamese"},{"code":"av","name":"Avaric"},{"code":"ae","name":"Avestan"},{"code":"ay","name":"Aymara"},{"code":"az","name":"Azerbaijani"},{"code":"bm","name":"Bambara"},{"code":"ba","name":"Bashkir"},{"code":"eu","name":"Basque"},{"code":"be","name":"Belarusian"},{"code":"bn","name":"Bengali; Bangla"},{"code":"bh","name":"Bihari"},{"code":"bi","name":"Bislama"},{"code":"bs","name":"Bosnian"},{"code":"br","name":"Breton"},{"code":"bg","name":"Bulgarian"},{"code":"my","name":"Burmese"},{"code":"ca","name":"Catalan; Valencian"},{"code":"ch","name":"Chamorro"},{"code":"ce","name":"Chechen"},{"code":"ny","name":"Chichewa; Chewa; Nyanja"},{"code":"zh","name":"Chinese"},{"code":"cv","name":"Chuvash"},{"code":"kw","name":"Cornish"},{"code":"co","name":"Corsican"},{"code":"cr","name":"Cree"},{"code":"hr","name":"Croatian"},{"code":"cs","name":"Czech"},{"code":"da","name":"Danish"},{"code":"dv","name":"Divehi; Dhivehi; Maldivian;"},{"code":"nl","name":"Dutch"},{"code":"dz","name":"Dzongkha"},{"code":"en","name":"English"},{"code":"eo","name":"Esperanto"},{"code":"et","name":"Estonian"},{"code":"ee","name":"Ewe"},{"code":"fo","name":"Faroese"},{"code":"fj","name":"Fijian"},{"code":"fi","name":"Finnish"},{"code":"fr","name":"French"},{"code":"ff","name":"Fula; Fulah; Pulaar; Pular"},{"code":"gl","name":"Galician"},{"code":"ka","name":"Georgian"},{"code":"de","name":"German"},{"code":"el","name":"Greek, Modern"},{"code":"gn","name":"GuaranÃ­"},{"code":"gu","name":"Gujarati"},{"code":"ht","name":"Haitian; Haitian Creole"},{"code":"ha","name":"Hausa"},{"code":"he","name":"Hebrew (modern)"},{"code":"hz","name":"Herero"},{"code":"hi","name":"Hindi"},{"code":"ho","name":"Hiri Motu"},{"code":"hu","name":"Hungarian"},{"code":"ia","name":"Interlingua"},{"code":"id","name":"Indonesian"},{"code":"ie","name":"Interlingue"},{"code":"ga","name":"Irish"},{"code":"ig","name":"Igbo"},{"code":"ik","name":"Inupiaq"},{"code":"io","name":"Ido"},{"code":"is","name":"Icelandic"},{"code":"it","name":"Italian"},{"code":"iu","name":"Inuktitut"},{"code":"ja","name":"Japanese"},{"code":"jv","name":"Javanese"},{"code":"kl","name":"Kalaallisut, Greenlandic"},{"code":"kn","name":"Kannada"},{"code":"kr","name":"Kanuri"},{"code":"ks","name":"Kashmiri"},{"code":"kk","name":"Kazakh"},{"code":"km","name":"Khmer"},{"code":"ki","name":"Kikuyu, Gikuyu"},{"code":"rw","name":"Kinyarwanda"},{"code":"ky","name":"Kyrgyz"},{"code":"kv","name":"Komi"},{"code":"kg","name":"Kongo"},{"code":"ko","name":"Korean"},{"code":"ku","name":"Kurdish"},{"code":"kj","name":"Kwanyama, Kuanyama"},{"code":"la","name":"Latin"},{"code":"lb","name":"Luxembourgish, Letzeburgesch"},{"code":"lg","name":"Ganda"},{"code":"li","name":"Limburgish, Limburgan, Limburger"},{"code":"ln","name":"Lingala"},{"code":"lo","name":"Lao"},{"code":"lt","name":"Lithuanian"},{"code":"lu","name":"Luba-Katanga"},{"code":"lv","name":"Latvian"},{"code":"gv","name":"Manx"},{"code":"mk","name":"Macedonian"},{"code":"mg","name":"Malagasy"},{"code":"ms","name":"Malay"},{"code":"ml","name":"Malayalam"},{"code":"mt","name":"Maltese"},{"code":"mi","name":"MÄori"},{"code":"mr","name":"Marathi (MarÄá¹­hÄ«)"},{"code":"mh","name":"Marshallese"},{"code":"mn","name":"Mongolian"},{"code":"na","name":"Nauru"},{"code":"nv","name":"Navajo, Navaho"},{"code":"nb","name":"Norwegian BokmÃ¥l"},{"code":"nd","name":"North Ndebele"},{"code":"ne","name":"Nepali"},{"code":"ng","name":"Ndonga"},{"code":"nn","name":"Norwegian Nynorsk"},{"code":"no","name":"Norwegian"},{"code":"ii","name":"Nuosu"},{"code":"nr","name":"South Ndebele"},{"code":"oc","name":"Occitan"},{"code":"oj","name":"Ojibwe, Ojibwa"},{"code":"cu","name":"Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic"},{"code":"om","name":"Oromo"},{"code":"or","name":"Oriya"},{"code":"os","name":"Ossetian, Ossetic"},{"code":"pa","name":"Panjabi, Punjabi"},{"code":"pi","name":"PÄli"},{"code":"fa","name":"Persian (Farsi)"},{"code":"pl","name":"Polish"},{"code":"ps","name":"Pashto, Pushto"},{"code":"pt","name":"Portuguese"},{"code":"qu","name":"Quechua"},{"code":"rm","name":"Romansh"},{"code":"rn","name":"Kirundi"},{"code":"ro","name":"Romanian"},{"code":"ru","name":"Russian"},{"code":"sa","name":"Sanskrit (Saá¹ská¹›ta)"},{"code":"sc","name":"Sardinian"},{"code":"sd","name":"Sindhi"},{"code":"se","name":"Northern Sami"},{"code":"sm","name":"Samoan"},{"code":"sg","name":"Sango"},{"code":"sr","name":"Serbian"},{"code":"gd","name":"Scottish Gaelic; Gaelic"},{"code":"sn","name":"Shona"},{"code":"si","name":"Sinhala, Sinhalese"},{"code":"sk","name":"Slovak"},{"code":"sl","name":"Slovene"},{"code":"so","name":"Somali"},{"code":"st","name":"Southern Sotho"},{"code":"az","name":"South Azerbaijani"},{"code":"es","name":"Spanish; Castilian"},{"code":"su","name":"Sundanese"},{"code":"sw","name":"Swahili"},{"code":"ss","name":"Swati"},{"code":"sv","name":"Swedish"},{"code":"ta","name":"Tamil"},{"code":"te","name":"Telugu"},{"code":"tg","name":"Tajik"},{"code":"th","name":"Thai"},{"code":"ti","name":"Tigrinya"},{"code":"bo","name":"Tibetan Standard, Tibetan, Central"},{"code":"tk","name":"Turkmen"},{"code":"tl","name":"Tagalog"},{"code":"tn","name":"Tswana"},{"code":"to","name":"Tonga (Tonga Islands)"},{"code":"tr","name":"Turkish"},{"code":"ts","name":"Tsonga"},{"code":"tt","name":"Tatar"},{"code":"tw","name":"Twi"},{"code":"ty","name":"Tahitian"},{"code":"ug","name":"Uyghur, Uighur"},{"code":"uk","name":"Ukrainian"},{"code":"ur","name":"Urdu"},{"code":"uz","name":"Uzbek"},{"code":"ve","name":"Venda"},{"code":"vi","name":"Vietnamese"},{"code":"vo","name":"VolapÃ¼k"},{"code":"wa","name":"Walloon"},{"code":"cy","name":"Welsh"},{"code":"wo","name":"Wolof"},{"code":"fy","name":"Western Frisian"},{"code":"xh","name":"Xhosa"},{"code":"yi","name":"Yiddish"},{"code":"yo","name":"Yoruba"},{"code":"za","name":"Zhuang, Chuang"},{"code":"zu","name":"Zulu"}],
          get: {
              all: function(){
                  var myLanguages = [], i = 0;

                  for(var key in abookingsystemdashboardGeneral.languages.data){
                      myLanguages[i] = {};
                      myLanguages[i]['name'] = abookingsystemdashboardGeneral.languages.data[key]['name'];
                      myLanguages[i]['value'] = abookingsystemdashboardGeneral.languages.data[key]['code'];
                      i++;
                  }
            
                  return myLanguages;
              },
              name: function(code){
                  var myLanguage = 'English';

                  for(var key in abookingsystemdashboardGeneral.languages.data){
                      
                      if(abookingsystemdashboardGeneral.languages.data[key]['code'] === code) {
                          myLanguage = abookingsystemdashboardGeneral.languages.data[key]['name'];
                      }
                  }
            
                  return myLanguage;
              }
          }
      },
      select: {
        options: function(data){
            var newOptions = [];
            
            for(var i = 0; i < data.length; i++) {
                newOptions[i] = [];
                
                newOptions[i]['name']   = data[i];
                newOptions[i]['value']  = data[i];
            }
          
            return newOptions;
        },
        optionsValues: function(data){
            var newOptions = [];
            
            for(var i = 0; i < data.length; i++) {
                newOptions[i] = [];
                
                newOptions[i]['name']   = data[i]['name'];
                newOptions[i]['value']  = data[i]['value'];
            }
          
            return newOptions;
        },
        optionsLower: function(data){
            var newOptions = [];
            
            for(var i = 0; i < data.length; i++) {
                newOptions[i] = [];
                
                newOptions[i]['name']   = data[i];
                newOptions[i]['value']  = data[i].toLowerCase();
            }
          
            return newOptions;
        },
        optionsTime: function(){
            var newOptions = [];
            
            newOptions[0] = [];

            newOptions[0]['name']   = absdashboardtext['cancellation_no'];
            newOptions[0]['value']  = 0;
            
          //Days
            for(var i = 1; i < 7; i++) {
                newOptions[i] = [];
                
                if(i === 1) {
                    newOptions[i]['name']   = absdashboardtext['cancellation_before_day'];
                } else {
                    newOptions[i]['name']   = absdashboardtext['cancellation_before_days'].split('%s').join(i);
                }
                newOptions[i]['value']  = i;
            }
            
           // Weeks
            for(var i = 7; i < 22; i++) {
                newOptions[i] = [];
                
                if(i === 7) {
                    newOptions[i]['name']   = absdashboardtext['cancellation_before_week'];
                } else {
                    newOptions[i]['name']   = absdashboardtext['cancellation_before_weeks'].split('%s').join(i/7);
                }
                newOptions[i]['value']  = i;
               i = i+6;
            }
            
           // Months
            for(var i = 28; i < 169; i++) {
                newOptions[i] = [];
                
                if(i === 28) {
                    newOptions[i]['name']   = absdashboardtext['cancellation_before_month'];
                } else {
                    newOptions[i]['name']   = absdashboardtext['cancellation_before_months'].split('%s').join(i/28);
                }
                newOptions[i]['value']  = i;
               i = i+27;
            }
              
            return newOptions;
        }
      },
      getTime: function(selectedTime){
        var time_name = absdashboardtext['cancellation_no'];
        
        selectedTime = parseInt(selectedTime);
        
        if(selectedTime > 1) {
            
            if(selectedTime < 2){
                time_name = absdashboardtext['cancellation_before_day'];
            } else if(selectedTime < 7){
                time_name = absdashboardtext['cancellation_before_days'].split('%s').join(selectedTime);
            } else if(selectedTime === 7){
                time_name = absdashboardtext['cancellation_before_week'];
            } else if(selectedTime < 22){
                time_name = absdashboardtext['cancellation_before_weeks'].split('%s').join(i/7);
            } else if(selectedTime === 28){
                time_name = absdashboardtext['cancellation_before_month'];
            } else if(selectedTime < 169){
                time_name = absdashboardtext['cancellation_before_months'].split('%s').join(i/28);
            }
        }
        
        return time_name;
      },
      reOrderArray: function(myArray){
          var newArray = [], i = 0;
          
          for(var key in myArray) {
              newArray.push(myArray[key]);
          }
        
          return newArray;
      }
  };
  
  window.abookingsystemdashboardGeneral = abookingsystemdashboardGeneral;
  
  
  var abookingsystemdashboardTabs = {
      start: function(box, data){
          var HTML = new Array(),
              first = true,
              firstTab = true;
          
          HTML.push('<div class="absd-tabs">');
          HTML.push('   <div class="absd-tabs-menu">');
          
          for(var key in data){
              HTML.push('   <div id="absd-tab-'+data[key]['name']+'" class="absd-tab-menu'+(first === true ? ' absd-opened':'')+'">'+data[key]['label']+'</div>');
              first = false;
          }
        
          HTML.push('   </div>');
          HTML.push('   <div class="absd-tabs-content">');
        
          for(var key in data){
              HTML.push('   <div id="absd-tab-'+data[key]['name']+'-content" class="absd-tab-content'+(firstTab === false ? ' absd-invisible':'')+'"></div>');
              firstTab = false;
          }
        
          HTML.push('   </div>');
          HTML.push('</div>');
        
          box.html(HTML.join(''));
        
          abookingsystemdashboardTabs.events();
      },
      box: function(name){
          return $('#absd-tab-'+name+'-content');
      },
      add: function (name, content, callbackfn){
          abookingsystemdashboardTabs.box(name).html(content);
        
          if(callbackfn !== undefined) {
              callbackfn();
          }
      },
      events: function(){
          
          $('.absd-tab-menu').unbind('click');
          $('.absd-tab-menu').bind('click', function(){
              $('.absd-tab-menu').removeClass('absd-opened');
              $(this).addClass('absd-opened');
              $('.absd-tab-content').addClass('absd-invisible');
              $('#'+$(this).attr('id')+'-content').removeClass('absd-invisible');
          });
      }
  };
  
  window.abookingsystemdashboardTabs = abookingsystemdashboardTabs;
  
  var abookingsystemdashboardAccordion = {
      start: function(box, data, css_class){
          var HTML = new Array(),
              first = true;
          
          
          for(var key in data){
              HTML.push('<div class="absd-accordion'+(css_class !== undefined ? ' '+css_class:'')+(data[key]['class'] !== undefined ? ' '+data[key]['class']:'')+'" id="absd-accordion-'+data[key]['name']+'" class="absd-accordion-menu'+(first === true ? ' absd-opened':'')+'">');
              HTML.push('   <div class="absd-accordion-arrow" data-id="absd-accordion-'+data[key]['name']+'"></div>');
              HTML.push('   <div class="absd-accordion-element" data-id="absd-accordion-'+data[key]['name']+'">');
              HTML.push('       <h3 data-id="absd-accordion-'+data[key]['name']+'">');
              HTML.push(          data[key]['label']);
              HTML.push('       </h3>');
            
              if(data[key]['data_time'] !== undefined) {
                  HTML.push('       <div class="absd-ticket-time">');
                  HTML.push(          data[key]['data_time']);
                  HTML.push('       </div>');
              }
            
              if(data[key]['delete'] !== undefined
                 && data[key]['delete'] === true) {
                  HTML.push('   <div class="absd-ticket-actions-holder">');
                  HTML.push('       <div class="absd-ticket-actions">');
                  HTML.push('           <span class="absd-visible absd-delete-ticket-reply absd-delete" '+(data[key]['ticket_id'] !== undefined ? ' data-ticket-id="'+data[key]['ticket_id']+'"':'')+' '+(data[key]['reply_id'] !== undefined ? ' data-reply-id="'+data[key]['reply_id']+'"':'')+' '+(data[key]['api_key'] !== undefined ? ' data-api-key="'+data[key]['api_key']+'"':'')+'><span class="absd-icon"></span><span class="absd-text">'+absdashboardtext['delete_button']+'</span></span>');
                  HTML.push('       </div>');
                  HTML.push('   </div>');
              }
              HTML.push('   </div>');
              HTML.push('   <div class="absd-accordion-content" id="absd-accordion-'+data[key]['name']+'-content">');
              HTML.push('       <div class="absd-accordion-content-box">'+(data[key]['content'] !== undefined ? ' '+data[key]['content']:'')+'</div>');
              HTML.push('   </div>');
              HTML.push('</div>');
              first = false;
          }
        
          box.html(HTML.join(''));
        
          abookingsystemdashboardAccordion.events();
      },
      box: function(name){
          return $('#absd-accordion-'+name+'-content .absd-accordion-content-box');
      },
      add: function (name, content, callbackfn){
          abookingsystemdashboardAccordion.box(name).html(content);
        
          if(callbackfn !== undefined) {
              callbackfn();
          }
      },
      events: function(){
          
          $('.absd-accordion-arrow, .absd-accordion-element').unbind('click');
          $('.absd-accordion-arrow, .absd-accordion-element').bind('click', function(){
              var currentID = $(this).attr('data-id');
            
              if($('#'+currentID).hasClass('absd-opened')) {
                  $('#'+currentID).removeClass('absd-opened');
              } else {
                  $('#'+currentID).addClass('absd-opened');
              }
          });
      }
  };
  
  window.abookingsystemdashboardAccordion = abookingsystemdashboardAccordion;
  
  $('.absd-menu').after().click(function() {
      $('.absd-popup').toggleClass('absd-open');
      $(this).toggleClass('absd-menu-active');
  });
})(jQuery);
  
  
/* type watch */
var wdhDelay = function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    }  
}();