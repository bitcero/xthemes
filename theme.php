<?php
// $Id: theme.php 116 2012-10-31 20:14:07Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

define('RMCLOCATION','theme');
require '../../include/cp_header.php';

/**
* This file allows to themes to show their own pages.
* This feature is specially useful when themes needs to have a single
* control panel or other features.0
*/

global $xtAssembler;

$theme = $xtAssembler->theme();

if(!method_exists($theme, 'controlPanel'))
    redirectMsg('themes.php', sprintf(__('%s does not support this feature.','xthemes'), $theme->getInfo('name')), RMMSG_WARN);

$theme->controlPanel();
