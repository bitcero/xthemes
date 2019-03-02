<?php
/**
 * xThemes Framework for XOOPS
 * More info at Eduardo Cortés Website (www.eduardocortes.mx)
 *
 * Copyright © 2012 - 2017 Eduardo Cortés (http://www.eduardocortes.mx)
 * -------------------------------------------------------------
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * -------------------------------------------------------------
 * @copyright    Eduardo Cortés (http://www.eduardocortes.mx)
 * @license      GNU GPL 2
 * @package      xthemes
 * @author       Eduardo Cortés (AKA bitcero)    <i.bitcero@gmail.com>
 * @url          http://www.eduardocortes.mx
 */

class XthemesRmcommonPreload
{
    /**
     * Add the customize widget to Common Utilities Dashboard
     */
    public static function eventRmcommonDashboardPanels($panels)
    {
        global $xtAssembler, $xtFunctions;

        if (!isset($GLOBALS['xtAssembler'])) {
            $xtAssembler = new XtAssembler();
        }

        if (!$xtAssembler->isSupported()) {
            return;
        }

        $theme = $xtAssembler->theme();

        RMTemplate::get()->add_style('rmc-dashboard.css', 'xthemes');
        ob_start(); ?>
        <div class="size-1" data-dashboard="item">
            <div class="cu-box box-green">
                <div class="box-header">
                    <span class="fa fa-caret-up box-handler"></span>
                    <h3 class="box-title"><?php _e('Appearance', 'rmcommon'); ?></h3>
                </div>
                <div class="box-content collapsable" id="xthemes-options">
                    <img src="<?php echo XOOPS_THEME_URL; ?>/<?php echo $theme->getInfo('dir'); ?>/<?php echo $theme->getInfo('screenshot'); ?>"
                         class="img-thumbnail">
                    <ul class="nav nav-pills nav-justified nav-options">
                        <li>
                            <a href="<?php echo XOOPS_URL; ?>/modules/xthemes/themes.php" title="<?php _e('Manage Themes', 'xthemes'); ?>" rel="tooltip">
                                <span class="fa fa-th-large"></span>
                            </a>
                        </li>
                        <?php if (method_exists($theme, 'controlPanel')): ?>
                            <li>
                                <a rel="tooltip" href="<?php echo XOOPS_URL; ?>/modules/xthemes/theme.php"
                                   title="<?php echo sprintf(__('%s Control Panel', 'xthemes'), $theme->getInfo('name')); ?>">
                                    <span class="fa fa-dashboard"></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($xtAssembler->rootMenus()): ?>
                            <li>
                                <a href="<?php echo XOOPS_URL; ?>/modules/xthemes/navigation.php" title="<?php _e('Menu Maker', 'xthemes'); ?>" rel="tooltip">
                                    <span class="fa fa-bars"></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($theme->options()): ?>
                            <li>
                                <a href="<?php echo XOOPS_URL; ?>/modules/xthemes/settings.php" title="<?php _E('Theme Settings', 'xthemes'); ?>" rel="tooltip">
                                    <span class="fa fa-wrench"></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <small><?php echo $theme->getInfo('description'); ?></small>
                    <?php if ($theme->getInfo('social')): ?>
                        <hr>
                        <ul class="nav nav-pills xthemes-social">
                            <?php foreach ($theme->getInfo('social') as $type => $link): ?>
                                <li>
                                    <a href="<?php echo $link; ?>" target="_blank">
                                        <?php echo $xtFunctions->social_icon($type); ?>
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

    public static function eventRmcommonSmartyPlugins($plugins)
    {
        global $xoopsConfig;

        if (!in_array(XOOPS_ROOT_PATH . '/modules/xthemes/smarty', $plugins)) {
            $plugins[] = XOOPS_ROOT_PATH . '/modules/xthemes/smarty';
        }

        $dir = XOOPS_THEME_PATH . '/' . $xoopsConfig['theme_set'] . '/assemble/smarty';

        if (!in_array($dir, $plugins)) {
            $plugins[] = $dir;
        }

        return $plugins;
    }

    public static function eventRmcommonCheckUpdatesThemes($urls)
    {
        global $common, $xoopsDB;
        $sql = "SELECT * FROM " . $xoopsDB->prefix("xt_themes");
        $result = $xoopsDB->queryF($sql);
        if ($xoopsDB->getRowsNum($result) <= 0) {
            return $urls;
        }
        while ($row = $xoopsDB->fetchArray($result)) {
            $theme = XtFunctions::getInstance()->load_theme($row['dir']);
            if (false == $theme->getInfo('updateurl')) {
                continue;
            }
            $version = $theme->getInfo('version');
            if (false == $version || '' == $version) {
                $version = 0;
            }
            $url = $theme->getInfo('updateurl');
            $url .= (strpos($url, '?')===false ? '?' : '&') . 'action=check&type=theme&id='.$row['dir'].'&version='.$version;
            $urls[$row['dir']] = [
                'url' => $url,
                'name' => $theme->getInfo('name')
            ];
        }
        return $urls;
    }

    public static function eventRmcommonThemeUpdateUrl($url, $theme)
    {
        global $common;
        $theme = XtFunctions::getInstance()->load_theme($theme);
        if (false == $theme) {
            return false;
        }
        $url = $theme->getInfo('updateurl');
        return $url;
    }
}
