<?php
// $Id: menu.php 151 2012-11-23 06:22:20Z i.bitcero $
// --------------------------------------------------------------
// xThemes
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

defined('XOOPS_ROOT_PATH') or die();

load_mod_locale('xthemes');

global $xtAssembler;

$adminmenu[] = array(
    'title' => __('Dashboard','xthemes'),
    'link' => 'index.php',
    'icon' => "images/dashboard.png",
    'location' => 'dashboard'
);

$adminmenu[] = array(
    'title' => __('Themes','xthemes'),
    'link' => 'themes.php',
    'icon' => "images/themes.png",
    'location' => 'themes'
);

if($xtAssembler->isSupported() &&  $xtAssembler->theme()->settings()){
    $menu = array(
        'title' => $xtAssembler->theme()->getInfo('name'),
        'link' => 'settings.php',
        'icon' => "images/settings.png",
        'location' => 'settings'
    );
    
    if($xtAssembler->rootMenus()):
        $options[] = array(
            'title' => __('Menus','xthemes'),
            'link'  => 'navigation.php',
            'selected' => 'menus',
            'icon' => 'images/menu.png'
        );
    endif;
    
    if($xtAssembler->theme()->options()):
        $options[] = array(
            'title' => __('Settings','xthemes'),
            'link'  => 'settings.php',
            'selected' => 'settings',
            'icon' => 'images/tools.png'
        );
    endif;
    
    if($xtAssembler->theme()->getInfo('uri')!=''):
        $options[] = array(
            'title' => __('Website','xthemes'),
            'link'  => $xtAssembler->theme()->getInfo('uri'),
            'selected' => 'none',
            'icon' => 'images/web.png'
        );
    endif;
    
    if($xtAssembler->theme()->getInfo('author_uri')!=''):
        $options[] = array(
            'title' => __('Author','xthemes'),
            'link'  => $xtAssembler->theme()->getInfo('author_uri'),
            'selected' => 'none',
            'icon' => 'images/author.png'
        );
    endif;
    
    $menu['options'] = $options;
    
    $adminmenu[] = $menu;
    unset($menu, $options);
    
}

/*
$adminmenu[3]['title'] = __('Catalog','xthemes');
$adminmenu[3]['link'] = '#';
$adminmenu[3]['icon'] = "images/catalog.png";
$adminmenu[3]['location'] = 'catalog';

$adminmenu[4]['title'] = __('About','xthemes');
$adminmenu[4]['link'] = 'index.php?op=about';
$adminmenu[4]['icon'] = "images/about.png";
$adminmenu[4]['location'] = 'catalog';
*/
global $rmEvents;
$adminmenu = $rmEvents->run_event('xthemes.menu', $adminmenu);
