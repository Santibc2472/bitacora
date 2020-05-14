<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemResources {
  
    function __construct(){
    }
    
    /*
     *  Frontend CMS
     */ 
    function frontend() {
        global $ABookingSystem;
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          
            // CSS FILES
            foreach($ABookingSystem['resources']['css'] as $cssLink){
                $fileName = str_replace(' ', '-', $cssLink['name']);
                
                if($cssLink['type'] != 'backend') {
                    wp_register_style($fileName, ($cssLink['load'] == 'file' ? $ABookingSystem['plugin_url']:'').$cssLink['file']);
                    wp_enqueue_style($fileName);

                    // Hook after
                    if(isset($cssLink['hook_after'])){
                        do_action($cssLink['hook_after']);
                    }
                }
            }
          
            if (!wp_script_is('jquery', 'queue')){
                wp_enqueue_script('jquery');
            }
          
            if (!wp_script_is('jquery-ui-datepicker', 'queue')){
                wp_enqueue_script('jquery-ui-datepicker');
            }
          
            // JS FILES
            foreach($ABookingSystem['resources']['js'] as $jsLink){
                $fileName = str_replace(' ', '-', $jsLink['name']);
                
                if(($jsLink['page'] != '' && $ABookingSystem['page'] == $jsLink['page'])
                  || ($jsLink['page'] == '')
                  || $jsLink['type'] == 'both'
                  && ($jsLink['role'] == ''
                      || $jsLink['role'] == $ABookingSystem['role'])) {
                        
                    if($jsLink['page'] == 'calendars') {
                        // WordPress Media library
                        wp_enqueue_media();
                    }
                    
                    if($jsLink['type'] != 'backend') {
                        $jquery_needed = $ABookingSystem['page'] == 'register' ? array():array('jquery');
                        wp_register_script($fileName, ($jsLink['load'] == 'file' ? $ABookingSystem['plugin_url']:'').$jsLink['file'], $jquery_needed, false, true);
                        wp_enqueue_script($fileName, 9999);
                    }
                }
            }
        }
    }
    
    /*
     *  Backend CMS
     */ 
    function backend() {
        global $ABookingSystem;
        global $absdashboardclasses;
      
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
          
            // CSS FILES
            foreach($ABookingSystem['resources']['css'] as $cssLink){
                $fileName = str_replace(' ', '-', $cssLink['name']);
                
                if($cssLink['type'] != 'frontend') {
                    wp_register_style($fileName, ($cssLink['load'] == 'file' ? $ABookingSystem['plugin_url']:'').$cssLink['file']);
                    wp_enqueue_style($fileName);

                    // Hook after
                    if(isset($cssLink['hook_after'])){
                        do_action($cssLink['hook_after']);
                    }
                }
            }
          
            if (!wp_script_is('jquery', 'queue')){
                wp_enqueue_script('jquery');
            }
          
            if (!wp_script_is('jquery-ui-datepicker', 'queue')){
                wp_enqueue_script('jquery-ui-datepicker');
            }
          
            if($absdashboardclasses->main->isBMpage()) {
                // JS FILES
                foreach($ABookingSystem['resources']['js'] as $jsLink){
                    $fileName = str_replace(' ', '-', $jsLink['name']);

                    if(($jsLink['page'] != '' && $ABookingSystem['page'] == $jsLink['page'])
                      || ($jsLink['page'] == '')
                      && ($jsLink['role'] == ''
                          || $jsLink['role'] == $ABookingSystem['role'])) {
                        
                        if($jsLink['page'] == 'calendars') {
                            // WordPress Media library
                            wp_enqueue_media();
                        }

                        if($jsLink['type'] != 'frontend') {
                            wp_register_script($fileName, ($jsLink['load'] == 'file' ? $ABookingSystem['plugin_url']:'').$jsLink['file'], array('jquery'), false, true);
                            wp_enqueue_script($fileName, 9999);
                        }
                    }
                }
            } else {
                // JS FILES
                foreach($ABookingSystem['resources']['js'] as $jsLink){
                    $fileName = str_replace(' ', '-', $jsLink['name']);

                    if($jsLink['page'] == ''
                        && ($jsLink['role'] == ''
                            || $jsLink['role'] == $ABookingSystem['role'])) {

                        if($jsLink['type'] != 'frontend') {
                            wp_register_script($fileName, ($jsLink['load'] == 'file' ? $ABookingSystem['plugin_url']:'').$jsLink['file'], array('jquery'), false, true);
                            wp_enqueue_script($fileName, 9999);
                        }
                    }
                }
            }
        }
    }
    
    /*
     *  // JS vars - Translation, Requests, ...
     */ 
    function js() {
        global $ABookingSystem;
        global $absdashboardtext;
        global $ABookingSystem;
        global $absdashboardclasses;
        
        $js_html = array();
        
        // Wordpress
        if($ABookingSystem['type'] == 'wordpress') {
      
            // Max groups & calendars
            $server = $absdashboardclasses->option->get('server',
                                               $ABookingSystem['user_id']);
          
            if(isset($server) 
               && $server != '') {
                $ABookingSystem['api_url'] = str_replace('www', $server, $ABookingSystem['api_url']);
            }
            
            // Currency
            $currency = $absdashboardclasses->option->get('currency',
                                                 $ABookingSystem['user_id']);
            $currency = $currency != '' ? $currency:'USD';
            $ABookingSystem['currency'] = $currency;
            
            // Max groups & calendars
            $max_groups = $absdashboardclasses->option->get('max_groups',
                                                   $ABookingSystem['user_id']);
            $max_groups = $max_groups != '' ? $max_groups:0;
            $no_groups = $absdashboardclasses->option->get('no_groups',
                                                  $ABookingSystem['user_id']);
            $no_groups = $no_groups != '' ? $no_groups:0;
            $max_calendars = $absdashboardclasses->option->get('max_calendars',
                                                      $ABookingSystem['user_id']);
            $max_calendars = $max_calendars != '' ? $max_calendars:0;
            $no_calendars = $absdashboardclasses->option->get('no_calendars',
                                                      $ABookingSystem['user_id']);
            $no_calendars = $no_calendars != '' ? $no_calendars:0;
            
            // Referral
            $referral_website = $absdashboardclasses->option->get('referral_website',
                                                      $ABookingSystem['user_id']);
            $referral_website = $referral_website != '' ? $referral_website:'';
            $referral_logo = $absdashboardclasses->option->get('referral_logo',
                                                      $ABookingSystem['user_id']);
            $referral_logo = $referral_logo != '' ? $referral_logo:0;
            
            $used_for = $absdashboardclasses->option->get('used_for',
                                                 $ABookingSystem['user_id']);
            $used_for = $used_for != '' ? $used_for:0;
            
            $bookeu_user_id = $absdashboardclasses->option->get('id',
                                                 $ABookingSystem['user_id']);
            $bookeu_user_id = $bookeu_user_id != '' ? $bookeu_user_id:0;
            
            $referral_id = $absdashboardclasses->option->get('referral_id',
                                                 $ABookingSystem['user_id']);
            $referral_id = $referral_id != '' ? $referral_id:0;
            
            
            // Account type
            $account_type = $absdashboardclasses->option->get('account_type',
                                                     $ABookingSystem['user_id']);
            
            if($account_type == '') {
                $account_type = 'free';
            }
            
            // Referral logo
            if($referral_website != ''
               && $referral_logo != '') {
                array_push($js_html, '<style type="text/css">');
                array_push($js_html,   '.custom-logo-link { display: none !important;}');
                array_push($js_html, '</style>');
            }
          
            array_push($js_html, '<script type="text/javascript">');
            
            // Translation
            array_push($js_html,   'window.absdashboardtext = [];');
            array_push($js_html,   'var absdashboardtext = [];');
            foreach ($absdashboardtext as $key => $value) {
                array_push ($js_html, 'window.absdashboardtext["'.$key.'"] = "'.$value.'";');
            }
          
            // Ajax requests
            array_push($js_html,   'window.abookingsystemdashboard_request_url = "'.admin_url('admin-ajax.php').'";');
            array_push($js_html,   'var abookingsystemdashboard_request_url = "'.admin_url('admin-ajax.php').'";');
            array_push($js_html,   'window.abookingsystemdashboard_request = [];');
            array_push($js_html,   'var abookingsystemdashboard_request = [];');
            foreach($ABookingSystem['requests'] as $request){
                array_push ($js_html, 'window.abookingsystemdashboard_request["'.$request['name'].'"] = "abookingsystemdashboard_'.$request['name'].'";');
            }
            
            // General Data
            array_push($js_html,   'window.abookingsystemdashboard = [];');
            array_push($js_html,   'var abookingsystemdashboard = [];');
            array_push($js_html,   '    abookingsystemdashboard["page"] = "'.$ABookingSystem['page'].'";');
            array_push($js_html,   '    abookingsystemdashboard["server"] = "'.$server.'";');
            array_push($js_html,   '    abookingsystemdashboard["calendar_url"] = "'.$ABookingSystem['calendar_url'].'";');
            array_push($js_html,   '    abookingsystemdashboard["api_url"] = "'.$ABookingSystem['api_url'].'";');
            array_push($js_html,   '    abookingsystemdashboard["type"] = "'.$ABookingSystem['type'].'";');
            array_push($js_html,   '    abookingsystemdashboard["used_for"] = "'.$used_for.'";');
            array_push($js_html,   '    abookingsystemdashboard["role"] = "'.$ABookingSystem['role'].'";');
            array_push($js_html,   '    abookingsystemdashboard["max_groups"] = '.$max_groups.';');
            array_push($js_html,   '    abookingsystemdashboard["max_calendars"] = '.$max_calendars.';');
            array_push($js_html,   '    abookingsystemdashboard["no_groups"] = '.$no_groups.';');
            array_push($js_html,   '    abookingsystemdashboard["no_calendars"] = '.$no_calendars.';');
            array_push($js_html,   '    abookingsystemdashboard["support_role"] = "'.$ABookingSystem['support_url'].'";');
            array_push($js_html,   '    abookingsystemdashboard["upgrade_account"] = "'.$ABookingSystem['upgrade_url'].'";');
            array_push($js_html,   '    abookingsystemdashboard["create_account"] = "'.$ABookingSystem['create_account_link'].'";');
            array_push($js_html,   '    abookingsystemdashboard["language"] = "'.$ABookingSystem['language'].'";');
            array_push($js_html,   '    abookingsystemdashboard["user_id"] = '.$ABookingSystem['user_id'].';');
            array_push($js_html,   '    abookingsystemdashboard["bookeu_user_id"] = '.$bookeu_user_id.';');
            array_push($js_html,   '    abookingsystemdashboard["referral_id"] = '.$referral_id.';');
            array_push($js_html,   '    abookingsystemdashboard["account_type"] = "'.$account_type.'";');
            array_push($js_html,   '    abookingsystemdashboard["vat_data"] = '.$ABookingSystem['vat_data'].';');
            array_push($js_html,   '    abookingsystemdashboard["google_map_api_key"] = "'.$ABookingSystem['google_map_api_key'].'";');
            array_push($js_html,   '    abookingsystemdashboard["ajax_ses"] = "'.$absdashboardclasses->protect->hide($ABookingSystem['user_id'].'@@@'.$ABookingSystem['role']).'";');
            array_push($js_html,   '    abookingsystemdashboard["is_network"] = "'.$absdashboardclasses->main->is_network().'";');
            array_push($js_html,   '    abookingsystemdashboard["currency"] = "'.$ABookingSystem['currency'].'";');
            
            if($ABookingSystem['role'] == 'admin'
               || $ABookingSystem['role'] == 'owner') {
                array_push($js_html,   "    abookingsystemdashboard['extensions'] = '".json_encode($absdashboardclasses->extensions->activatedAndInstalled())."';");
            }
            
            
            if (get_user_option('rich_editing') == 'true'){
                // && $absdashboardclasses->main->is_edit_page('edit')
                $main_calendars = $absdashboardclasses->calendar->own($ABookingSystem['user_id'],
                                                             'main');
                array_push($js_html,   "    abookingsystemdashboard['main_calendars'] = '".json_encode($main_calendars)."';");
                array_push($js_html,   "    abookingsystemdashboard['languages'] = '".$this->languages()."';");
                array_push($js_html,   "    abookingsystemdashboard['apbs_api_key'] = '".$absdashboardclasses->protect->get('apbs_api_key')."';");
                
            } else {
                array_push($js_html,   "    abookingsystemdashboard['languages'] = '".$this->languages()."';");
            }
            
            array_push($js_html, '</script>');
          
        }
      
        echo implode('', $js_html);
    }
    
    function shortcode(){
        if (get_user_option('rich_editing') == 'true'){
            add_filter('mce_external_plugins', array (&$this, 'shortcodeToTinyMCE'), 5);
            add_filter('mce_buttons', array (&$this, 'shortcodeButton'), 5);
        }
    }
    
    function shortcodeToTinyMCE($plugins){
        global $ABookingSystem;
        
        $plugins['BOOKEUCOM'] =  $ABookingSystem['plugin_url'].'js/button.js';

        return $plugins;
    }
    
    function shortcodeButton($buttons){
        array_push($buttons, '', 'BOOKEUCOM');

        return $buttons;
    }
    
    function languages(){
        global $absdashboardtext;
        global $absdashboardlanguages;
        $valid_languages = $absdashboardlanguages['languages'];
        $language_codes = array(
                'en' => 'English' , 
                'aa' => 'Afar' , 
                'ab' => 'Abkhazian' , 
                'af' => 'Afrikaans' , 
                'am' => 'Amharic' , 
                'ar' => 'Arabic' , 
                'as' => 'Assamese' , 
                'ay' => 'Aymara' , 
                'az' => 'Azerbaijani' , 
                'ba' => 'Bashkir' , 
                'be' => 'Byelorussian' , 
                'bg' => 'Bulgarian' , 
                'bh' => 'Bihari' , 
                'bi' => 'Bislama' , 
                'bn' => 'Bengali/Bangla' , 
                'bo' => 'Tibetan' , 
                'br' => 'Breton' , 
                'ca' => 'Catalan' , 
                'co' => 'Corsican' , 
                'cs' => 'Czech' , 
                'cy' => 'Welsh' , 
                'da' => 'Danish' , 
                'de' => 'German' , 
                'dz' => 'Bhutani' , 
                'el' => 'Greek' , 
                'eo' => 'Esperanto' , 
                'es' => 'Spanish' , 
                'et' => 'Estonian' , 
                'eu' => 'Basque' , 
                'fa' => 'Persian' , 
                'fi' => 'Finnish' , 
                'fj' => 'Fiji' , 
                'fo' => 'Faeroese' , 
                'fr' => 'French' , 
                'fy' => 'Frisian' , 
                'ga' => 'Irish' , 
                'gd' => 'Scots/Gaelic' , 
                'gl' => 'Galician' , 
                'gn' => 'Guarani' , 
                'gu' => 'Gujarati' , 
                'ha' => 'Hausa' , 
                'hi' => 'Hindi' , 
                'hr' => 'Croatian' , 
                'hu' => 'Hungarian' , 
                'hy' => 'Armenian' , 
                'ia' => 'Interlingua' , 
                'ie' => 'Interlingue' , 
                'ik' => 'Inupiak' , 
                'in' => 'Indonesian' , 
                'is' => 'Icelandic' , 
                'it' => 'Italian' , 
                'iw' => 'Hebrew' , 
                'jp' => 'Japanese' , 
                'ji' => 'Yiddish' , 
                'jw' => 'Javanese' , 
                'ka' => 'Georgian' , 
                'kk' => 'Kazakh' , 
                'kl' => 'Greenlandic' , 
                'km' => 'Cambodian' , 
                'kn' => 'Kannada' , 
                'ko' => 'Korean' , 
                'ks' => 'Kashmiri' , 
                'ku' => 'Kurdish' , 
                'ky' => 'Kirghiz' , 
                'la' => 'Latin' , 
                'ln' => 'Lingala' , 
                'lo' => 'Laothian' , 
                'lt' => 'Lithuanian' , 
                'lv' => 'Latvian/Lettish' , 
                'mg' => 'Malagasy' , 
                'mi' => 'Maori' , 
                'mk' => 'Macedonian' , 
                'ml' => 'Malayalam' , 
                'mn' => 'Mongolian' , 
                'mo' => 'Moldavian' , 
                'mr' => 'Marathi' , 
                'ms' => 'Malay' , 
                'mt' => 'Maltese' , 
                'my' => 'Burmese' , 
                'na' => 'Nauru' , 
                'ne' => 'Nepali' , 
                'nl' => 'Dutch' , 
                'no' => 'Norwegian' , 
                'oc' => 'Occitan' , 
                'om' => '(Afan)/Oromoor/Oriya' , 
                'pa' => 'Punjabi' , 
                'pl' => 'Polish' , 
                'ps' => 'Pashto/Pushto' , 
                'pt' => 'Portuguese' , 
                'qu' => 'Quechua' , 
                'rm' => 'Rhaeto-Romance' , 
                'rn' => 'Kirundi' , 
                'ro' => 'Romanian' , 
                'ru' => 'Russian' , 
                'rw' => 'Kinyarwanda' , 
                'sa' => 'Sanskrit' , 
                'sd' => 'Sindhi' , 
                'sg' => 'Sangro' , 
                'sh' => 'Serbo-Croatian' , 
                'si' => 'Singhalese' , 
                'sk' => 'Slovak' , 
                'sl' => 'Slovenian' , 
                'sm' => 'Samoan' , 
                'sn' => 'Shona' , 
                'so' => 'Somali' , 
                'sq' => 'Albanian' , 
                'sr' => 'Serbian' , 
                'ss' => 'Siswati' , 
                'st' => 'Sesotho' , 
                'su' => 'Sundanese' , 
                'sv' => 'Swedish' , 
                'sw' => 'Swahili' , 
                'ta' => 'Tamil' , 
                'te' => 'Tegulu' , 
                'tg' => 'Tajik' , 
                'th' => 'Thai' , 
                'ti' => 'Tigrinya' , 
                'tk' => 'Turkmen' , 
                'tl' => 'Tagalog' , 
                'tn' => 'Setswana' , 
                'to' => 'Tonga' , 
                'tr' => 'Turkish' , 
                'ts' => 'Tsonga' , 
                'tt' => 'Tatar' , 
                'tw' => 'Twi' , 
                'uk' => 'Ukrainian' , 
                'ur' => 'Urdu' , 
                'uz' => 'Uzbek' , 
                'vi' => 'Vietnamese' , 
                'vo' => 'Volapuk' , 
                'wo' => 'Wolof' , 
                'xh' => 'Xhosa' , 
                'yo' => 'Yoruba' , 
                'zh' => 'Chinese' , 
                'zu' => 'Zulu' , 
                );
        $languages = array();
        
        $language = new stdClass;
        $language->name = $absdashboardtext['autodetect'];
        $language->value = 'auto';
        array_push($languages, $language);
        
        foreach($language_codes as $key => $value){
            
            if(in_array($key, $valid_languages)) {
                $language = new stdClass;
                $language->name = $language_codes[$key];
                $language->value = $key;
                array_push($languages, $language);
            }
        }

        return json_encode($languages);
	}
}