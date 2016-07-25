<?php
// $Id: xttheme.php 99 2012-10-24 21:46:58Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

/**
* This is the plugins parent class
*/

abstract class XtTheme extends RMObject
{
	protected $details = array();
	protected $errors = array();
    private $settings = array();
    
    /**
    * Load a theme
    * 
    * @param mixed Id or dirname for theme
    * @return XtTheme
    */
    public function __construct(){
        // Load details from theme
        $this->details = $this->details();
        
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->_dbtable = $this->db->prefix("xt_themes");
        $this->setNew();
        $this->initVarsFromTable();
        
        $id = $this->getInfo('dir'); 
        $this->primary = 'dir';
        if ($this->loadValues($id)) $this->unsetNew();
        $this->primary = 'id_theme';
        
        if($this->isNew()){
            $this->setVars($this->getInfo());
        }
        
    }
	
	public function errors( $errors = true ){
		return $this->errors;
	}

    public function addError($error_msg){
        $this->errors[] = $error_msg;
    }
	
    /**
    * Get an info key or all information
    */
	public function getInfo($key = ''){
        
        if($key=='') return $this->details;
        
        if(!isset($this->details[$key])) return false;
        return $this->details[$key];
        
    }
    
    /**
    * Get theme url
    * @return string
    */
    public function url(){
        return XOOPS_THEME_URL.'/'.$this->getInfo('dir');
    }
    /**
    * Get theme path
    * @return string
    */
    public function path(){
        return XOOPS_THEME_PATH.'/'.$this->getInfo('dir');
    }
    
    /**
    * Indicates if theme is installed
    * @return bool
    */
    public function installed(){
        global $xtAssembler;
        
        return $xtAssembler->theme()->getInfo('dir')==$this->getInfo('dir');
    }

    public function on_install(){
        return true;
    }
    
    public function on_uninstall(){
        return true;
    }
    
    public function setSettings($settings){
        $this->settings = $settings;
    }
    
    /**
    * Get theme configuration 
    */
    public function settings($key = ''){
        if($key=='') return $this->settings;
        
        if(isset($this->settings[$key]))
            return $this->settings[$key];
        
        return false;
    }
    
    /**
    * This function allows to themes verify the input data for each individual setting
    * @param mixed $value
    * @return mixed value
    */
    public function checkSettingValue($value){
        return $value;
    }
    
    public function save(){
        if($this->isNew())
            return $this->saveToTable();
        else
            return $this->updateTable();
    }
    
    public function delete(){
        return $this->deleteFromTable();
    }
    
    public function menu($id=''){
        global $xtAssembler;
        return $xtAssembler->menu($id);
    }

    public function blocks(){
        return array();
    }

    public function blocks_positions(){
        return false;
    }

    /**
     * Notify to theme when it is activated or deactivated in order to perform operations.
     *
     * This method is called only when the theme changes its status and is installed and
     * is the theme that will be deactivated or activated.
     *
     * @param string $action <p>New status: active|inactive</p>
     * @return bool
     */
    public function status( $action = 'active' ){
        return true;
    }

    public function body_classes(){
        return RMTemplate::get()->body_classes();
    }
	
}

interface XtITheme
{
    public function details();
    
    /**
    * This function must return a name for menu(s) (if supported)
    * otherwise must return false
    * @return string with menu name
    * @return array with menus names
    */
    public function haveMenus();
    /**
    * Get configuration options with default values
    * @return array
    */
    public function options();
    /**
    * This event is launched when xtAssembler init basic smarty vars
    */
    public function init();
}
