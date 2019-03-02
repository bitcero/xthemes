<?php
// $Id: index.php 116 2012-10-31 20:14:07Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

define('RMCLOCATION', 'dashboard');
require '../../include/cp_header.php';

load_theme_locale($xoopsConfig['theme_set']);

$rmTpl->add_style('xthemes.min.css', 'xthemes');
RMTemplate::getInstance()->add_body_class('dashboard');

/**
 * Additional dashboard panels
 */
$dashboardPanels = [];
$dashboardPanels = RMEvents::get()->trigger('xthemes.dashboard.panels', $dashboardPanels);

/* Current Theme */
$currentTheme = $xtAssembler->theme();

/* Available themes */
// Read all available themes
$dh = opendir(XOOPS_THEME_PATH);
$i = 0;
while (false !== ($dir = readdir($dh))) {
    if ($dir=='.' || $dir=='..' || is_file(XOOPS_THEME_PATH.'/'.$dir)) {
        continue;
    }

    $path = XOOPS_THEME_PATH . '/' . $dir . '/';

    if (!is_file($path . '/theme.html') && !is_file($path . '/theme.tpl')) {
        continue;
    }

    // Supported themes
    $theme_path = XOOPS_THEME_PATH.'/'.$dir;
    if (is_file($theme_path.'/assemble/'.strtolower($dir).'.theme.php')) {
        include_once $theme_path.'/assemble/'.strtolower($dir).'.theme.php';
        $class = ucfirst(strtolower($dir));
        $theme = new $class();
    } else {
        $theme = new StandardTheme();
        $theme->set_dir($dir);
    }

    $themes[$i] = $theme->getInfo();
    $themes[$i]['url'] = $theme->url();
    $themes[$i]['installed'] = !$theme->isNew();
    $i++;
}

$common->breadcrumb()->add_crumb(__('Dashboard', 'xthemes'));

xoops_cp_header();

include $rmTpl->get_template("xt-index.php", 'module', 'xthemes');

xoops_cp_footer();
