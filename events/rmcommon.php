<?php
// $Id: rmcommon.php 99 2012-10-24 21:46:58Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

class XthemesRmcommonPreload
{
    public function eventRmcommonLoadLeftWidgets($widgets){
        global $xoopsModule, $xtAssembler;
        
        if(RMCLOCATION!='themes' && $xoopsModule->dirname()=='xthemes'){
            
            return self::showThemeInfo($widgets);
        
        }elseif(RMCLOCATION=='settings' && $xoopsModule->dirname()=='xthemes'){
            
            $widget['title'] = __('Configuration Sections','xthemes');
            
            $options = $xtAssembler->theme()->options();
            $tpl = RMTemplate::get();
            
            // Specific CSS file
            $tpl->add_style('settings.css', 'xthemes');
            $visible = isset($_COOKIE['xtsection']) ? $_COOKIE['xtsection'] : key($sections);
            
            ob_start();
            include $tpl->get_template("widgets/xt_wgt_sections.php",'module','xthemes');
            $widget['content'] = ob_get_clean();
            $widget['icon'] = 'images/sections.png';
            
            //$widgets[] = $widget;
            
            $retw[] = $widget;
            foreach($widgets as $w){
                $retw[] = $w;
            }
            
            return $retw;
            
        }
        
        return $widgets;
        
    }
    
    private function showThemeInfo($widgets){
        global $xtAssembler, $xtFunctions;
        
        $widget['title'] = __('Current Theme','xthemes');
        $widget['icon'] = XOOPS_URL.'/modules/xthemes/images/xthemes.png';
            
        $tpl = RMTemplate::get();
        $tpl->add_style('themes.css', 'xthemes');
            
        $theme = $xtAssembler->theme();
            
        ob_start();
        include $tpl->get_template('widgets/xt_wgt_themeinfo.php', 'module', 'xthemes');
        $widget['content'] = ob_get_clean();
            
        $widgets[] = $widget;
            
        $widget = array();
        $widget['title'] = sprintf(__('%s Options','xthemes'), $theme->getInfo('name'));
        $widget['icon'] = 'images/options.png';
            
        ob_start();
        include $tpl->get_template('widgets/xt_wgt_themeoptions.php', 'module', 'xthemes');
        $widget['content'] = ob_get_clean();
        $widgets[] = $widget; 
        return $widgets;
        
    }
}