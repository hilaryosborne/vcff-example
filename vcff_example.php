<?php

/*
* Plugin Name: Example VCFF Plugin
* Plugin URI: http://theblockquote.com/
* Description: General addons
* Version: 1.0.0
* Author: Hilary
* Author URI: http://theblockquote.com/
* License: License GNU General Public License version 2 or later;
* Copyright 2015  theblockquote
*/

if (!defined('EX_VCFF_DIR'))
{ define('EX_VCFF_DIR',untrailingslashit(plugin_dir_path(__FILE__))); }

if (!defined('EX_VCFF_URL'))
{ define('EX_VCFF_URL',untrailingslashit(plugins_url('/', __FILE__))); }

class EX_VCFF {

    public function __construct() {
        // Initalize core logic
        add_action('vcff_init_core',array($this,'__Init_Core'),30);
        // Initalize context logic
        add_action('vcff_init_context',array($this,'__Init_Context'),30);
        // Initalize misc logic
        add_action('vcff_init_misc',array($this,'__Init_Misc'),30);  
    }
    
    public function __Init_Core() {
        // Load helper classes
        $this->_Load_Helpers();
        // Load the core classes
        $this->_Load_Core(); 
    }

    public function __Init_Context() {
        // Load the context classes
        $this->_Load_Context();
    }
    
    public function __Init_Misc() {
        // Load the pages
        $this->_Load_Pages();
        // Load AJAX
        $this->_Load_AJAX();
    }
    
    public function _Load_Helpers() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Recurssively load the directory
        $this->_Recusive_Load_Dir($dir.'/helpers');
    }
    
    protected function _Load_Core() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Recurssively load the directory
        $this->_Recusive_Load_Dir($dir.'/core');
    }
    
    public function _Load_Context() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Recurssively load the directory
        $this->_Recusive_Load_Dir($dir.'/context');
    }

    public function _Load_Pages() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Recurssively load the directory
        $this->_Recusive_Load_Dir($dir.'/pages');
    }
    
    protected function _Load_AJAX() {
        // Retrieve the context director
        $dir = untrailingslashit( plugin_dir_path(__FILE__ ) );
        // Recurssively load the directory
        $this->_Recusive_Load_Dir($dir.'/ajax');
    }

    protected function _Recusive_Load_Dir($dir) {
        // If the directory doesn't exist
        if (!is_dir($dir)) { return; }
        // Load each of the field shortcodes
        foreach (new DirectoryIterator($dir) as $FileInfo) {
            // If this is a directory dot
            if ($FileInfo->isDot()) { continue; }
            // If this is a directory
            if ($FileInfo->isDir()) { 
                // Load the directory
                $this->_Recusive_Load_Dir($FileInfo->getPathname());
            } // Otherwise load the file
            else {
                // If this is not false
                if (stripos($FileInfo->getFilename(),'.tpl') !== false) { continue; } 
                // If this is not false
                if (stripos($FileInfo->getFilename(),'.php') === false) { continue; } 
                // Include the file
                require_once($FileInfo->getPathname());
            }
        }
    }
    
}

new EX_VCFF();