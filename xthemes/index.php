<?php
// $Id: index.php 116 2012-10-31 20:14:07Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

define('RMCLOCATION','dashboard');
require '../../include/cp_header.php';

load_theme_locale($xoopsConfig['theme_set']);

$rmTpl->add_style('xthemes.min.css', 'xthemes');
RMTemplate::getInstance()->add_body_class('dashboard');

/**
 * Additional dashboard panels
 */
$dashboardPanels = [];
$dashboardPanels = RMEvents::get()->trigger('xthemes.dashboard.panels', $dashboardPanels);

xoops_cp_header();

include $rmTpl->get_template("xt_index.php", 'module', 'xthemes');

xoops_cp_footer();