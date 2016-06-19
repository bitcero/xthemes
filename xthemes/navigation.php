<?php
// $Id: navigation.php 157 2012-11-25 04:43:29Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

define('RMCLOCATION','menus');
require '../../include/cp_header.php';

/**
* REsponses in json
*/
function xt_response($msg, $error, $level){
    
    echo json_encode(array('message'=>$msg,'error'=>$error));
    exit();
    
}

function xt_show_menus(){
    global $xtAssembler, $xtFunctions;
    
    $tc = TextCleaner::getInstance();
    $menus = $xtAssembler->rootMenus();
    if(!$menus)
        redirectMsg('themes.php', __('This theme does not support xThemes menus!','xthemes'), RMMSG_WARN);
    
    $theme_menu = $xtAssembler->menu();
    
    $tpl = RMTemplate::getInstance();
    $tpl->add_jquery(true, true);
    $tpl->add_script('jquery.nestedSortable.min.js', 'xthemes', ['id' => 'sortable-js']);
    //$tpl->add_local_script('json_encode.min.js', 'xthemes');
    $tpl->add_inline_script("var lang_delete = '".__('Do you really want to delete selected menu?','xthemes')."';");
    $tpl->add_script('xthemes.min.js', 'xthemes', ['footer' => 1, 'id' => 'xthemes-js']);
    $tpl->add_style('xthemes.min.css', 'xthemes', ['id' => 'xthemes-css']);
    $tpl->assign('xoops_pagetitle', __('Theme menus','xthemes'));
    
    xoops_cp_header();
    
    include $tpl->path('xt_navigation.php', 'module', 'xthemes');
    
    xoops_cp_footer();
    
}

/**
* Save the items of created menus
*/
function xt_save_menus(){
    global $xtAssembler, $xtFunctions, $xoopsConfig, $xoopsLogger;
    
    $xoopsLogger->activated = false;
    $xoopsLogger->renderingEnabled = false;
    
    $params = rmc_server_var($_POST, 'params', '');

    if(get_magic_quotes_gpc()==1)
        $params = stripslashes($params);

    $params = json_decode($params, true);
    
    if(empty($params))
        xt_response(__('Menu not found!','xthemes'), 1, RMMSG_WARN);
    
    $theme_menus = $xtAssembler->rootMenus();
    
    // Errors container
    $errors = array();
    // Menus container
    $menus = array();
    
    foreach($params as $menu){
        $id = $menu['id'];
        if(!isset($theme_menus[$id]))
            // If menu does not exists in theme then we will return an error
            $errors[] = sprintf(__('Current theme "%s" does not have any menu identified as "%s"','xthemes'), $xtAssembler->theme()->getInfo("name"), $id);
        else
            $menus[$menu['id']] = $menu['content'] ;
    }
    
    if(!empty($errors))
        xt_response(__('There was some errors while trying to save menus:','xthemes').'<br />'.implode("<br />", $errors), 1, RMMSG_ERROR);
    
    $db = XoopsDatabaseFactory::getDatabaseConnection();
    
    foreach($menus as $id => $content){

        $menu = new Xthemes_Menu($id, $xtAssembler->theme()->id());
        if($menu->isNew()){
            $menu->menu = $id;
            $menu->theme = $xtAssembler->theme()->id();
        }
        $menu->setContent($content);
        if(!$menu->save()){
            $errors[] = $menu->errors();
        }

        /*if(!$xtAssembler->menu($id)){

            if(!$db->queryF("INSERT INTO ".$db->prefix("xt_menus")." (`theme`,`menu`,`content`) VALUES ('".$xtAssembler->theme()->id()."','".$id."','".base64_encode(serialize($content))."')"))
                $errors[] = $db->error();
                
        } else {
            
            if(!$db->queryF("UPDATE ".$db->prefix("xt_menus")." SET `content`='".base64_encode(serialize($content))."' WHERE `theme`='".$xtAssembler->theme()->id()."' AND `menu`='".$id."'"))
                $errors[] = $db->error();
            
        }*/
    }
    
    if(!empty($errors))
        xt_response(__('There was some errors while trying to save menus:','xthemes').'<br />'.implode("<br />", $errors), 1, RMMSG_ERROR);
    
    xt_response(__('Menu saved successfully!','xthemes'), 0, RMMSG_SAVED);
    
}


$action = rmc_server_var($_REQUEST, 'action', '');

switch($action){
    
    case 'save':
        xt_save_menus();
        break;
        
    default:
        xt_show_menus();
        break;
    
}
