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

    /**
     * Add the customize widget to Common Utilities Dashboard
     */
    public function eventRmcommonDashboardPanels( $panels ){
        global $xtAssembler, $xtFunctions;

        if (!isset($GLOBALS['xtAssembler']))
            $xtAssembler = new XtAssembler();

        if ( !$xtAssembler->isSupported() )
            return;

        $theme = $xtAssembler->theme();

        RMTemplate::get()->add_style('rmc-dashboard.css', 'xthemes');
        ob_start();
        ?>
        <div class="size-1" data-dashboard="item">
            <div class="cu-box box-green">
                <div class="box-header">
                    <span class="fa fa-caret-up box-handler"></span>
                    <h3 class="box-title"><?php _e('Appearance','rmcommon'); ?></h3>
                </div>
                <div class="box-content collapsable" id="xthemes-options">
                    <img src="<?php echo XOOPS_THEME_URL; ?>/<?php echo $theme->getInfo('dir'); ?>/<?php echo $theme->getInfo('screenshot'); ?>" class="img-thumbnail">
                    <ul class="nav nav-pills nav-justified nav-options">
                        <li>
                            <a href="<?php echo XOOPS_URL; ?>/modules/xthemes/themes.php" title="<?php _e('Manage Themes', 'xthemes'); ?>" rel="tooltip">
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
                        <ul class="nav nav-pills xthemes-social">
                            <?php foreach( $theme->getInfo('social') as $type => $link ): ?>
                                <li>
                                    <a href="<?php echo $link; ?>" target="_blank">
                                        <?php echo $xtFunctions->social_icon( $type ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        $panel = ob_get_clean();
        $panels[] = $panel;
        return $panels;
    }
}