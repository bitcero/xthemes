<?php
// $Id: xtassembler.class.php 159 2012-12-06 23:51:54Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

// Load required classes
include_once XTPATH.'/class/xttheme.php';
include_once XTPATH.'/class/xtcolor.class.php';
include_once XTPATH.'/class/standardtheme.class.php';
include_once XTPATH.'/class/xtfunctions.class.php';

/**
* This class is the main controller for xThemes
*/
class XtAssembler
{
    private $current = null;
    private $root_menus = null;
    private $menus = null;
    private $registered = array();
    private $colors = '';
    private $xsettings;
    
    public function __construct($theme = ''){
        
        global $xoopsConfig;
        
        $theme = $theme!='' ? $theme : $xoopsConfig['theme_set'];
        $dir = XOOPS_THEME_PATH.'/'.($theme=='' ? $xoopsConfig['theme_set'] : $theme);
        
        if(!is_file($dir.'/assemble/'.$theme.'.theme.php')){
            $this->current = new StandardTheme();
            $this->current->set_dir($theme);
            return;
        }
        
        require_once $dir.'/assemble/'.$theme.'.theme.php';
        $class = ucfirst($theme);
        $this->current = new $class();
        
        /**
        * The theme support native menus?
        */
        $this->root_menus = $this->current->haveMenus();

        // xThemes settings (?)
        $this->xsettings = RMSettings::module_settings( 'xthemes' );

        /**
        * Load theme configuration
        */
        $this->current->setSettings($this->load_settings());
        /*
        * @todo Agregar código para carga de métodos del tema
        */
        $this->loadMenus();
        
        // Register pluguins
        if(method_exists($this->current, 'register')){
            
            $plugins = $this->theme()->register();

            if ( empty( $plugins ) )
                return;
            
            $dir = str_replace(XOOPS_URL, XOOPS_ROOT_PATH, $this->theme()->url().'/assemble/plugins');
            foreach($plugins as $plug){
                if(!file_exists($dir.'/'.$plug['file'])) continue;
                
                include_once $dir.'/'.$plug['file'];
                $this->registered[$plug['var']] = new $plug['name']();
                
            }
            
        }

    }
    
    /**
    * This function reload the current theme
    */
    public function loadTheme($theme){
        $this->__construct($theme);
    }
    
    /**
    * Init data for theme rendering
    */
    public function init(){

        global $xoopsTpl, $xoopsConfig, $rmc_config, $xoTheme;

        // xThemes settings (?)
        $this->xsettings = RMSettings::module_settings( 'xthemes' );

	    $xoopsTpl->assign('isHome', defined('XTHEMES_IS_HOME'));

        if(!$this->isSupported()) return;
        
        if($this->current->getInfo('dir')!=$xoopsConfig['theme_set']){
            
            // If user has selected another theme, realod all theme data
            $dir = XOOPS_THEME_PATH.'/'.$xoopsConfig['theme_set'];
        
            if(!is_file($dir.'/assemble/'.$xoopsConfig['theme_set'].'.theme.php')){
                $this->current = new StandardTheme();
                $this->current->set_dir($xoopsConfig['theme_set']);
                return;
            }
            
            require_once $dir.'/assemble/'.$xoopsConfig['theme_set'].'.theme.php';
            $class = ucfirst($xoopsConfig['theme_set']);
            $this->current = new $class();
            
            /**
            * The theme support native menus?
            */
            $this->root_menus = $this->current->haveMenus();
            
            /**
            * Load theme configuration
            */
            $this->current->setSettings($this->load_settings());
            /*
            * @todo Agregar código para carga de métodos del tema
            */
            $this->loadMenus();
            
            // Register pluguins
            if(method_exists($this->current, 'register')){
                
                $plugins = $this->theme()->register();
                
                $dir = str_replace(XOOPS_URL, XOOPS_ROOT_PATH, $this->theme()->url().'/assemble/plugins');
                foreach($plugins as $plug){
                    if(!file_exists($dir.'/'.$plug['file'])) continue;
                    
                    include_once $dir.'/'.$plug['file'];
                    $this->registered[$plug['var']] = new $plug['name']();
                    
                }
                
            }
            
        }
        
        $xoopsTpl->assign('theme', $this->theme());
        $xoopsTpl->assign('xtConfig', $this->theme()->settings());
        $xoopsTpl->assign('xt_language', $rmc_config['lang']);
        $xoopsTpl->assign('isHome', defined('XTHEMES_IS_HOME'));
        
        $this->colors = new XtColor();
        $xoopsTpl->assign('xtColor', $this->colors);
        
        // Assign plugins

        foreach($this->registered as $id => $o){
            $xoopsTpl->assign($id, $o);
        }

        // Register smarty plugins
        $dir = str_replace(XOOPS_URL, XOOPS_ROOT_PATH, $this->theme()->url());

        $xoopsTpl->plugins_dir[] = XOOPS_ROOT_PATH.'/modules/xthemes/smarty';
        $xoopsTpl->plugins_dir[] = $dir . '/assemble/smarty';
        
        load_theme_locale($this->theme()->getInfo('dir'));
        
        $this->current->init();
        
    }
    
    /**
    * Access to registered plugins
    */
    public function plugin($name){

        if($name=='' || !isset($this->registered[$name])) return false;
        
        return $this->registered[$name];
        
    }
    
    /**
    * Determines if current page is the homepage
    */
    public function isHome(){
        return defined('XTHEMES_IS_HOME');
    }
    
    /**
    * Load theme settings from database
    */
    private function load_settings(){
        
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "SELECT * FROM ".$db->prefix("xt_options")." WHERE theme=".$this->current->id();

        $result = $db->query($sql);
        
        $settings = array();
        
        while($row = $db->fetchArray($result)){
            $settings[$row['name']] = $row['type']=='array' ? unserialize( $this->recalculate( base64_decode( $row['value'] ) ) ) : $row['value'];
        }
        
        return $settings;
        
    }

    private function recalculate( $data ){

        if ( $this->xsettings->recal )
            $data = preg_replace_callback('!s:(\d+):"(.*?)";!', function($t){ return "s:" . strlen($t[2]) . ":\"$t[2]\";";}, $data);

        return $data;
    }
    
    /**
    * Load confgiured menus from database
    * @return array
    * @return bool
    */
    private function loadMenus(){
        
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "SELECT * FROM ".$db->prefix("xt_menus")." WHERE theme=".$this->current->id()." AND (";
        $sqlm = '';
        
        foreach($this->root_menus as $id => $menu){
            $sqlm .= $sqlm=='' ? "menu='".$id."'" : " OR menu='".$id."'";
        }
        $sql .= $sqlm.')';
        unset($sqlm);
        
        $result = $db->query($sql);
        $this->menus = array();
        
        while($row = $db->fetchArray($result)){
            $this->menus[$row['menu']] = unserialize($row['content']);
        }
        
    }
    
    /**
    * Get configured menus from database
    * @return array
    * @return false
    */
    public function menu($id = ''){
        
        if($id=='') return $this->menus;
        
        if(!isset($this->menus[$id])) return false;
        
        return $this->menus[$id];
        
    }
    
    /**
    * @return Theme Object
    */
    public function theme(){return $this->current;}

    /**
    * @return $xtColor class
    */
    public function colorControl(){

        if(!is_object($this->colors))
            $this->colors = new XtColor();
        
        return $this->colors;
    }
    
    /**
    * Return the accepted menus from theme
    * @return array
    */
    public function rootMenus(){
        return $this->root_menus;
    }
    
    /**
    * Determines if the theme is supported
    */
    public function isSupported(){
        
        return !is_a($this->current, 'StandardTheme');
        
    }

    /**
     * is module or plugin installed?
     * @paramn string Directory name of module or plugin
     * @param string type can be 'module' or 'plugin'
     * @return bool
     */
    public function installed($dirname, $type){

        $rmf = new RMFunctions();

        if($type=='plugin'){

            return $rmf->plugin_installed($dirname);

        } else {

            $mod = RMModules::load_module( $dirname );
            if($mod->isNew())
                return false;
            else
                return true;

        }

    }
    
}
