<?php
if (!defined('ABSPATH')) exit;

class ABookingSystemExtensions {
  
    function __construct(){
        $this->load();
    }
    
    /*
     * Autodetect & Load Extensions
     */ 
    function load() {
        global $ABookingSystem;
        global $absdashboardclasses;
      
        // Start Database
        $absdashboardclasses->db->start();

        $activeAndInstalled = $this->activatedAndInstalled();
        $activeAndInstalled = (array)$activeAndInstalled;
        $activeAndInstalled['activated'] = (array)$activeAndInstalled['activated'];
        $ABookingSystem['extensions_loaded_in_config'] = array();

        /*
         * Load Extensions from config file
         */
        if(!empty($ABookingSystem['extensions_load'])){

            foreach($ABookingSystem['extensions_load'] as $key => $value) {
                $extension = $key;
              
                // Check if extension is enabled
                if($value['enabled'] && in_array($extension, $activeAndInstalled['activated'])) {
                    $required_plugins = $value['required']['plugins'];

                    // Check if required plugins are active
                    if($this->plugins_exist($required_plugins)) {

                        // Check file exist
                        if(file_exists($ABookingSystem['plugin_path'].'extensions/'.$extension.'/'.$extension.'.php')) {
                            include_once $ABookingSystem['plugin_path'].'extensions/'.$extension.'/'.$extension.'.php';
                            $extension_class = 'ABookingSystem_ext_'.$extension;
                            $this->$extension_class = class_exists("$extension_class") ? new $extension_class():'Class does not exist!';
                            array_push($ABookingSystem['extensions_loaded_in_config'], $extension);
                        }
                    }
                }
            }
        }
        
        // Load Extensions from Database
        $this->loadFromDB();
    }
    
    /*
     * Load extensions from Database
     */
    function loadFromDB(){
        global $ABookingSystem;
        global $absdashboardclasses;
      
        // Start Database
        $absdashboardclasses->db->start();
    
        /*
         * Load Extensions from database
         */
        $db_extensions_load = $absdashboardclasses->option->get('extensions_load');
        $db_extensions_load = $db_extensions_load != '' ? json_decode($db_extensions_load):array();
        
        if(!empty($db_extensions_load)){

            foreach($db_extensions_load as $key => $value) {
                $extension = $key;
                $value = (array)$value;
              
                // Check if extension is enabled
                if($value['enabled'] == 'true' && !in_array($extension, $ABookingSystem['extensions_loaded_in_config'])) {
                    $value['required'] = (array)$value['required'];
                    $required_plugins = $value['required']['plugins'];
                    
                    // Check if required plugins are active
                    if($this->plugins_exist($required_plugins)) {
                        // Check file exist
                        if(file_exists($ABookingSystem['plugin_path'].'extensions/'.$extension.'/'.$extension.'.php')) {
                            include_once $ABookingSystem['plugin_path'].'extensions/'.$extension.'/'.$extension.'.php';
                            $extension_class = 'ABookingSystem_ext_'.$extension;
                            $this->$extension_class = class_exists("$extension_class") ? new $extension_class():'Class does not exist!';
                        }
                    }
                }
            }
        }
    }
    
    /*
     * Get Activated & Installed extensions
     */
    function activatedAndInstalled(){
        global $ABookingSystem;
        global $absdashboardclasses;
        
        $activated_extensions = array();
        $installed_extensions = array();

        /*
         * Check Loaded Extensions from config file
         */
        if(!empty($ABookingSystem['extensions_load'])){

            foreach($ABookingSystem['extensions_load'] as $extension => $data) {

                // Check if extension installed
                if(file_exists($ABookingSystem['plugin_path'].'extensions/'.$extension.'/'.$extension.'.php')) {
                    array_push($installed_extensions, $extension);
              
                    // Check if extension is activated
                    if($data['enabled']) {
                        array_push($activated_extensions, $extension);
                    }
                }
            }
        }
        
        
        /*
         * Check Loaded Extensions from database
         */
        $db_extensions_loaded = $absdashboardclasses->option->get('extensions_load');
        $db_extensions_loaded = $db_extensions_loaded != '' ? json_decode($db_extensions_loaded):array();
        
        if(!empty($db_extensions_loaded)){

            foreach($db_extensions_loaded as $extension => $data) {
                $data = (array)$data;

                // Check if extension installed
                if(file_exists($ABookingSystem['plugin_path'].'extensions/'.$extension.'/'.$extension.'.php')) {
                    array_push($installed_extensions, $extension);
              
                    // Check if extension is activated
                    if($data['enabled'] == 'true') {
                        array_push($activated_extensions, $extension);
                    } else {
                        if (($key = array_search($extension, $activated_extensions)) !== false) {
                            unset($activated_extensions[$key]);
                        }
                    }
                }
            }
        }
        
        
        return array('activated' => (array)$activated_extensions,
                     'installed' => (array)$installed_extensions);
    }
    
    /*
     * Install extension
     */
    function plugin_setup($data){
        global $ABookingSystem;
        $returnData = array();
        
        // Download and extract extension
        $file = fopen($ABookingSystem['plugin_path'].'extensions/'.$data['name'].".zip", "w+");
        
        if(flock($file, LOCK_EX)) {
            fwrite($file, fopen($data['download_link'], 'r'));
            
            $zip = new ZipArchive;
            $res = $zip->open($ABookingSystem['plugin_path'].'extensions/'.$data['name'].".zip");
            
            if($res === TRUE) {
                $zip->extractTo($ABookingSystem['plugin_path'].'extensions/'.$data['name']);
                $zip->close();
                
                // Save to Installed extension
                $db_extensions_load = $absdashboardclasses->option->get('extensions_load');
                $db_extensions_load = $db_extensions_load != '' ? json_decode($db_extensions_load):array();
                $required_plugins   = $data['required_plugins'] != '' ? $data['required_plugins']:array();
                $required_themes    = $data['required_themes'] != '' ? $data['required_themes']:array();
                
                $extension_data = array($extension => array('required' => array('plugins' => $required_plugins,
                                                                                'theme' => $required_themes),
                                                            'version' => $data['version'],
                                                            'enabled' => 'false'));
                
                array($db_extensions_load, $extension_data);
                $db_extensions_load = $absdashboardclasses->option->get('extensions_load');
                
                // Save
                $absdashboardclasses->option->add('extensions_load',
                                                  $db_extensions_load);
                
                $returnData = array('status' => 'success',
                                    'error' => 'The extension has been successfully installed.');
            } else {
                $returnData = array('status' => 'error',
                                    'error' => 'Couldn\'t unzipped the extension file. Please try again later or contact our support.');
            }
            flock($file, LOCK_UN);
        } else {
            $returnData = array('status' => 'error',
                                'error' => 'Couldn\'t download the extension file. Please try again later or contact our support.');
        }
        fclose($file);
        
        // Delete zip file
        unlink($ABookingSystem['plugin_path'].'extensions/'.$data['name'].".zip");
        
        return $returnData;
    }
    
    /*
     * Check if extension exist
     */
    function plugins_exist($plugins){
        $active_plugins=get_option('active_plugins');
      
        foreach($plugins as $plugin) {
            
            if(!in_array($plugin.'/'.$plugin.'.php', $active_plugins)) {
                return false;
            }
        }
        
        return true;
    }
}