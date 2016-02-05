<?php
// $Id: xoops_version.php 198 2013-01-08 05:27:19Z i.bitcero $
// --------------------------------------------------------------
// xThemes
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

$amod = xoops_getActiveModules();
if(!in_array("rmcommon",$amod)){
    $error = "<strong>WARNING:</strong> xThemes requires %s to be installed!<br />Please install %s before trying to use xThemes";
    $error = str_replace("%s", '<a href="http://www.xoopsmexico.net/downloads/common-utilities/" target="_blank">Common Utilities</a>', $error);
    xoops_error($error);
    $error = '%s is not installed! This might cause problems with functioning of xThemes and entire system. To solve, install %s or uninstall xThemes and then delete module folder.';
    $error = str_replace("%s", '<a href="http://www.xoopsmexico.net/downloads/common-utilities/" target="_blank">Common Utilities</a>', $error);
    trigger_error($error, E_USER_WARNING);
    echo "<br />";
}

if (!function_exists("__")){
    function __($text, $d){
        return $text;
    }
}

$modversion['name'] = 'xThemes';
$modversion['version'] = 1.6;
$modversion['description'] = 'A module to manage advanced themes for XOOPS.';
$modversion['credits'] = "Eduardo Cortés <i.bitcero@gmail.com>";
$modversion['help'] = "docs/readme.html";
$modversion['license'] = "GPLv2";
$modversion['official'] = 0;
$modversion['image'] = "images/logo.png";
$modversion['dirname'] = "xthemes";
$modversion['onUpdate'] = "include/install.php";

// Common Utilities
$modversion['rmnative'] = '1';
$modversion['url'] = 'https://github.com/bitcero/xthemes';
$modversion['rmversion'] = array('major'=>1,'minor'=>6, 'revision'=>35,'stage'=>0,'name'=>'XThemes');
$modversion['updateurl'] = "http://www.xoopsmexico.net/modules/vcontrol/";
$modversion['author'] = "Eduardo Cortes";
$modversion['authormail'] = "i.bitcero@gmail.com";
$modversion['authorweb'] = "EduardoCortes.mx";
$modversion['authorurl'] = "http://eduardocortes.mx";
$modversion['icon']   = 'fa fa-heart text-red';

// Social links
$modversion['social'][0] = array('title' => __('Twitter', 'rmcommon'),'type' => 'twitter','url' => 'http://www.twitter.com/bitcero/');
$modversion['social'][1] = array('title' => __('LinkedIn', 'rmcommon'),'type' => 'linkedin','url' => 'http://www.linkedin.com/bitcero/');
$modversion['social'][2] = array('title' => __('Google+', 'rmcommon'),'type' => 'google+','url' => 'https://plus.google.com/u/0/100655708852776329288/posts');

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['tables'][0] = "xt_menus";
$modversion['tables'][1] = "xt_options";
$modversion['tables'][2] = "xt_themes";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "index.php";
$modversion['adminmenu'] = "menu.php";

$modversion['hasMain'] = 0;
$modversion['hasSearch'] = 0;

$modversion['config'] = array(
    array(
        'name' => 'recal',
        'title' => __('Recalculate length of serialized data','docs'),
        'description' => __('Enable this option only when you receive an error like <em>[function.unserialize]: Error at offset</em>.', 'docs'),
        'formtype' => 'yesno',
        'valuetype' => 'int',
        'default' => 0
    ),
);

global $xtAssembler;
if ( $xtAssembler ){
    $theme = $xtAssembler->theme();
    if ( $xtAssembler->isSupported() ){

        $modversion['blocks'] = $theme->blocks();

    }
}
