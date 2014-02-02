<?php
// $Id: themes.php 159 2012-12-06 23:51:54Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

define('RMCLOCATION','themes');
require '../../include/cp_header.php';

load_theme_locale($xoopsConfig['theme_set']);

$tpl = RMTemplate::get();
$xtf = new XTFunctions();

function xt_show_themes(){
    global $tpl, $xtf, $xoopsSecurity, $xtAssembler;

    $current = $xtAssembler->theme();
    
    // Read all available themes
    $dh = opendir(XOOPS_THEME_PATH);
    $i = 0;
    while(false !== ($dir = readdir($dh))){
        if($dir=='.' || $dir=='..' || is_file(XOOPS_THEME_PATH.'/'.$dir)) continue;
        
        if(!is_file(XOOPS_THEME_PATH.'/'.$dir.'/theme.html')) continue;
        
        // Supported themes
        $theme_path = XOOPS_THEME_PATH.'/'.$dir;
        if(is_file($theme_path.'/assemble/'.strtolower($dir).'.theme.php')){
            
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
    
    $tpl->add_style("themes.css", 'xthemes');
    $tpl->add_local_script('xthemes.js', 'xthemes');
    $tpl->add_head_script("var xoops_url = '".XOOPS_URL."';");
    $tpl->assign('xoops_pagetitle', __('Themes Manager','xthemes'));

    $bc = RMBreadCrumb::get();
    $bc->add_crumb(__('Themes', 'xthemes'));
    
    xoops_cp_header();
    
    include $tpl->get_template("xt_themes.php", 'module', 'xthemes');
    
    xoops_cp_footer();
    
}

/**
* Prepare XOOPS in order to preview a theme
*/
function xt_preview_theme(){
    global $xoopsConfig;
    $dir = rmc_server_var($_GET, 'dir', '');
    if($dir==''){
        echo _e('No theme has been specified!', 'xthemes');
        die();
    }
    
    $theme = XOOPS_THEME_PATH.'/'.$dir.'/theme.html';
    if(!is_file($theme)){
        echo sprintf(__('%s is not a valid theme!','xthemes'), $dir);
        die();
    }
    
    $db = XoopsDatabaseFactory::getDatabaseConnection();
    $allowed = array($xoopsConfig['theme_set'], $dir);
    $sql = "UPDATE ".$db->prefix("config")." SET conf_value='".serialize($allowed)."' WHERE conf_modid=0 AND conf_catid=1 AND conf_name='theme_set_allowed'";
    $db->queryF($sql);
    
    header('location: '.XOOPS_URL.'/?xoops_theme_select='.$dir);
    die();
    
}

function xt_activate_theme(){
    
    $dir = rmc_server_var($_GET, 'dir', '');
    if($dir=='')
        redirectMsg('themes.php', __('No theme has been specified!','xthemes'), RMMSG_ERROR);
    
    $theme_dir = XOOPS_THEME_PATH.'/'.$dir;
    
    if(!is_file($theme_dir.'/theme.html'))
        redirectMsg('themes.php', __('Specified directory does not contain a valid theme!','xthemes'), RMMSG_WARN);
        
    $db = XoopsDatabaseFactory::getDatabaseConnection();
    
    $sql = "UPDATE ".$db->prefix("config")." SET conf_value='$dir' WHERE conf_modid=0 AND conf_catid=1 AND conf_name='theme_set'";
    if(!$db->queryF($sql))
        redirectMsg('themes.php', __('Theme could not be activated','xthemes').$db->getError(), RMMSG_ERROR);
        
    $sql = "UPDATE ".$db->prefix("config")." SET conf_value='".serialize(array($dir))."' WHERE conf_modid=0 AND conf_catid=1 AND conf_name='theme_set_allowed'";
    $db->queryF($sql);
    
    redirectMsg('themes.php', __('Theme activated successfully!','xthemes'), RMMSG_SUCCESS);
    
}

/**
* Install specified theme
*/
function xt_install_theme(){
    global $xoopsConfig, $xtFunctions;
    
    $dir = rmc_server_var($_GET, 'dir', '');
    if($dir=='')
        redirectMsg('themes.php', __('No theme has been specified!','xthemes'), RMMSG_ERROR);
    
    $theme_dir = XOOPS_THEME_PATH.'/'.$dir;
    
    if(!is_file($theme_dir.'/theme.html'))
        redirectMsg('themes.php', __('Specified directory does not contain a valid theme!','xthemes'), RMMSG_WARN);
    
    $db = XoopsDatabaseFactory::getDatabaseConnection();
    
    if(is_file($theme_dir.'/assemble/'.$dir.'.theme.php')){
        
        // Install a xThemes Theme
        
        include_once $theme_dir.'/assemble/'.$dir.'.theme.php';
        $class = ucfirst($dir);
        if(!class_exists($class))
            redirectMsg('themes.php', __('Specified theme is not a valid xThemes theme!','xthemes'), RMMSG_WARN);
        
        $theme = new $class();
        $theme->setVar('date', time());
            
        if(!$theme->on_install())
            redirectMsg('themes.php', __('Theme could not be activated!','xthemes').$theme->errors(), RMMSG_ERROR);
        
        if(!$theme->save() && $theme->isNew())
            redirectMsg('themes.php', __('Sorry, theme could not be installed!','xthemes').$theme->errors(), RMMSG_ERROR);
        
        // Configuration options
        if(!$xtFunctions->insertOptions($theme))
            redirectMsg('themes.php', __('Sorry, theme could not be installed!','xthemes').$theme->errors(), RMMSG_ERROR);
        
        
        
    }
    
    $sql = "UPDATE ".$db->prefix("config")." SET conf_value='$dir' WHERE conf_modid=0 AND conf_catid=1 AND conf_name='theme_set'";
    if(!$db->queryF($sql))
        redirectMsg('themes.php', __('Theme could not be activated','xthemes').$db->getError(), RMMSG_ERROR);
        
    $sql = "UPDATE ".$db->prefix("config")." SET conf_value='".serialize(array($dir))."' WHERE conf_modid=0 AND conf_catid=1 AND conf_name='theme_set_allowed'";
    $db->queryF($sql);
    
    redirectMsg('themes.php', __('Theme installed and activated successfully!','xthemes'), RMMSG_SUCCESS);   
        
}


function xt_uninstall_theme(){
    global $xoopsConfig, $xtFunctions;
    
    $dir = rmc_server_var($_GET, 'dir', '');
    
    if($dir=='')
        redirectMsg('themes.php', __('Specified theme is not valid!','xthemes'), RMMSG_ERROR);
    
    if($dir == $xoopsConfig['theme_set'])
        redirectMsg('themes.php', __('Specified theme is being used by XOOPS as current theme and can not be uninstalled. Please, activate another available theme before uninstalling this.','xthemes'), RMMSG_WARN);
    
    $theme = $xtFunctions->load_theme($dir);
    
    if(!$theme || $theme->getInfo('type')=='standard')
        redirectMsg('themes.php', __('This theme is not a xThemes! To deactivate it simply activate another available theme.','xthemes'), RMMSG_WARN);
    
    $db = XoopsDatabaseFactory::getDatabaseConnection();

    if(!$theme->on_uninstall())
            redirectMsg('themes.php', __('Theme could not be uninstalled!','xthemes').$theme->errors(), RMMSG_ERROR);

    if(!$xtFunctions->purge_theme($theme))
        redirectMsg('themes.php', __('Theme could not be uninstalled!','xthemes').'<br />'.$db->error(), RMMSG_ERROR);
    
    redirectMsg('themes.php', __('Theme has been uninstalled successfully!','xthemes'), RMMSG_SUCCESS);
    
}


$action = rmc_server_var($_REQUEST, 'action', '');

switch($action){
    
    case 'activate':
        xt_activate_theme();
        break;
        
    case 'install':
        xt_install_theme();
        break;
        
    case 'uninstall':
        xt_uninstall_theme();
        break;
    
    case 'preview':
        xt_preview_theme();
        break;
        
    default:
        xt_show_themes();
        break;
    
}