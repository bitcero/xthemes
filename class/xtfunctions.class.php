<?php
// $Id: xtfunctions.class.php 172 2012-12-13 06:17:41Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

class XtFunctions
{
    /**
    * Get the current theme and all related information
    * return object
    */
    public function current_theme(){
        global $xoopsConfig;
        
        // Configured theme
        $ctheme = $xoopsConfig['theme_set'];
        
        // Check if theme is a valid xTheme or not
        $theme = $this->load_theme($ctheme); 
        
        return $theme;
        
    }
    
    /**
    * Load a specified theme
    * return object
    */
    public function load_theme($dir){
        
        if($dir=='') return false;
        
        $fulldir = XOOPS_THEME_PATH.'/'.$dir;
        if(!is_dir($fulldir)) return false;
        
        $theme_file = $fulldir.'/assemble/'.$dir.'.theme.php';
        
        if(is_file($theme_file)){
            include_once $theme_file;
            $class = ucfirst($dir);
            $theme = new $class();
            return $theme;
        }
        
        $theme = new StandardTheme();
        $theme->set_dir($dir);
        return $theme;
        
    }
    
    /**
    * Insert configuration options
    * @param array with sections and options
    * @return bool
    */
    public function insertOptions($theme, $set = null){
        
        if($theme==null) return false;
        $options = $theme->options();
        $to_delete = array();
        
        if(empty($options)) return true;
        
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        // Current settings
        $current = $theme->settings();
        $count = count($current);

        $to_delete = array_keys( array_diff_key( $current, $options['options'] ) );

        $sql = "INSERT INTO ".$db->prefix("xt_options")." (`theme`,`name`,`value`,`type`) VALUES ";
        $sqlu = "UPDATE ".$db->prefix("xt_options")." SET `value`=";

        //$values = array();
        $errors = '';

        foreach($options['options'] as $name => $option){

            $value = isset($set[$name]) ? $set[$name] : $option['default'];
            $value = $option['content']=='array' ? ( is_array( $value ) ? base64_encode( serialize( $value ) ) : '' ) : $value;
            
            $item = new Xthemes_Option($name, $theme->id());
            $item->name = $name;
            $item->theme = $theme->id();
            $item->value = $value;
            $item->type = $option['content'];
            if(!$item->save()){
                $errors .= '<br>' . $item->errors();
            }

            /*if($count<=0){
                $value = isset($set[$name]) ? $set[$name] : $option['default'];
            $value = $option['type']=='array' ? ( is_array( $value ) ? base64_encode( serialize( $value ) ) : '' ) : TextCleaner::getInstance()->addslashes($value);
                $values[] = "(".$theme->id().",'$name','$value','$option[content]')";
            }else {
                if( $set && isset($current[$name]) ){
                    // Update single option
                    $value = $option['content']=='array' ? ( isset( $set[$name] ) ? base64_encode( serialize( $set[$name] ) ) : '' ) : TextCleaner::getInstance()->addslashes($set[$name]);
                    $sqlt = $sqlu . "'$value', `type`='$option[content]' WHERE name='$name' AND theme='".$theme->id()."'";
                    $db->queryF( $sqlt );
                }else{
                    $value = isset($set[$name]) ? $set[$name] : $option['content'];
                    $value = $option['type']=='array' ? ( is_array( $value ) ? base64_encode( serialize( $value ) ) : '' ) : TextCleaner::getInstance()->addslashes($value);
                    $values[] = "(".$theme->id().",'$name','$value','$option[content]')";
                }
            }*/

        }

        if ( !empty( $to_delete ) )
            $db->queryF("DELETE FROM " . $db->prefix("xt_options") . " WHERE theme = " . $theme->id() . " AND ( name = '" . implode("' OR name='", $to_delete) . "')");

        /*if(!empty($values))
            $sql .= implode(",",$values); 
        else
            return true;*/

        if($errors != ''){
            return $errors;
        }

        return true;
        
    }

    /**
     * Create positions for blocks
     */
    public function insertPositions( $theme ){

        if($theme==null) return false;

        $positions = $theme->blocks_positions();

        if( false === $positions ) return true;

        foreach ( $positions as $tag => $name ){

            $pos = new RMBlockPosition( $tag );
            if($pos->isNew()){

                $pos->setVar( 'name', $name );
                $pos->setVar( 'tag', $tag );
                $pos->setVar( 'active', 1 );
                $pos->save();

            }

        }

        return true;

    }

    /**
    * Remove all theme data from database
    */
    public function purge_theme($theme){
        
        if(!$theme) return false;
        if(is_a($theme, 'StandardTheme')) return true;
        
        // Delete options
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "DELETE FROM ".$db->prefix("xt_options")." WHERE theme=".$theme->id();
        if(!$db->queryF($sql))
            return false;
        
        $sql = "DELETE FROM ".$db->prefix("xt_menus")." WHERE theme=".$theme->id();
        if(!$db->queryF($sql))
            return false;

        $positions = $theme->blocks_positions();
        if( false === $positions ) return true;

        foreach ( $positions as $tag => $name ){

            $pos = new RMBlockPosition( $tag );
            if($pos->isNew())
                continue;

            $pos->delete();

        }

        return true;
        
        return $theme->delete();
        
    }
    
    /**
    * Forms the menu in menu manager based on <li>s
    * @param 
    */
    public function formAdminMenu($menu){
        if(empty($menu)) return false;
        
        $tpl = RMTemplate::get();

        foreach($menu as $m){
            include $tpl->path('xt-menu-manager.php', 'module', 'xthemes');
        }
    }

    /**
     * Shows the icon for social network
     * @param string $type Social identifier
     * @return string
     */
    public function social_icon( $type ){

        $icons = array(

            'twitter'   => 'fa fa-twitter',
            'facebook'   => 'fa fa-facebook',
            'google-plus'   => 'fa fa-google-plus',
            'linkedin'   => 'fa fa-linkedin',
            'instagram'   => 'fa fa-instagram',
            'tumblr'   => 'fa fa-tumblr',
            'flickr'   => 'fa fa-flickr',
            'youtube'   => 'fa fa-youtube',
            'stack-overflow'   => 'fa fa-stack-overflow',
            'vimeo'   => 'fa fa-vimeo',
            'skype'   => 'fa fa-skype',
            'foursquare'   => 'fa fa-foursquare',
            'github'   => 'fa fa-github',
            'pinterest'   => 'fa fa-pinterest',
            'blog'  => 'fa fa-quote-left'

        );

        if ( isset( $icons[$type] ) )
            return '<span class="fa ' . $icons[$type] . '"></span>';

        return '<span class="fa fa-check-square"></span>';

    }

    public function notify_deactivation( $dir ){
        $theme = self::load_theme( $dir );

        if ( !is_a( $theme, 'StandardTheme') ){

            $theme->status( 'inactive' );
            // Disable blocks positions assigned to this theme
            $positions = $theme->blocks_positions();
            foreach( $positions as $tag => $name){

                $pos = new RMBlockPosition( $tag );
                if ( !$pos->isNew() ){
                    $pos->setVar('active', 0);
                    $pos->save();
                }

            }

        }
    }

    /**
     * Loads current instance
     * @return XtFunctions
     */
    public static function getInstance()
    {
        static $instance;

        if (!isset($instance)) {
            $instance = new XtFunctions();
        }

        return $instance;
    }
    
}
