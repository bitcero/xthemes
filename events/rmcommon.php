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

    /**
     * Add the customize widget to Common Utilities Dashboard
     */
    public function eventRmcommonDashboardRightWidgets(){
        global $xtAssembler;

        if (!isset($GLOBALS['xtAssembler']))
            $xtAssembler = new XtAssembler();

        if ( !$xtAssembler->isSupported() )
            return;

        $theme = $xtAssembler->theme();

        RMTemplate::get()->add_style('rmc-dashboard.css', 'xthemes');

        ?>
        <div class="cu-box">
            <div class="box-header">
                <span class="fa fa-caret-up box-handler"></span>
                <h3><?php _e('Appearance','rmcommon'); ?></h3>
            </div>
            <div class="box-content collapsable" id="xthemes-options">
                <img src="<?php echo XOOPS_THEME_URL; ?>/<?php echo $theme->getInfo('dir'); ?>/<?php echo $theme->getInfo('screenshot'); ?>" class="img-thumbnail">
                <ul class="nav nav-pills nav-justified nav-options">
                    <li>
                        <a href="<?php echo XOOPS_URL; ?>/modules/xthemes/" title="<?php _e('Manage Themes', 'xthemes'); ?>" rel="tooltip">
                            <span class="fa fa-th-large"></span>
                        </a>
                    </li>
                    <?php if(method_exists($theme, 'controlPanel')): ?>
                        <li>
                            <a rel="tooltip" href="<?php echo XOOPS_URL; ?>/modules/xthemes/theme.php" title="<?php echo sprintf(__('%s Control Panel', 'xthemes'), $theme->getInfo('name')); ?>">
                                <span class="fa fa-dashboard"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if($xtAssembler->rootMenus()): ?>
                        <li>
                            <a href="<?php echo XOOPS_URL; ?>/modules/xthemes/navigation.php" title="<?php _e('Menu Maker', 'xthemes'); ?>" rel="tooltip">
                                <span class="fa fa-bars"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if($theme->options()): ?>
                        <li>
                            <a href="<?php echo XOOPS_URL; ?>/modules/xthemes/settings.php" title="<?php _E('Theme Settings', 'xthemes'); ?>" rel="tooltip">
                                <span class="fa fa-wrench"></span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <small><?php echo $theme->getInfo('description'); ?></small>
                <?php if( $theme->getInfo('social') ): ?>
                    <hr>
                <ul class="list-inline">
                    <?php foreach( $theme->getInfo('social') as $type => $link ): ?>
                    <li>
                        <a href="<?php echo $link; ?>">
                            <span class="fa fa-<?php echo $type; ?>"></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}