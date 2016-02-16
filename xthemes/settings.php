<?php
// $Id: settings.php 120 2012-11-03 18:30:52Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

define('RMCLOCATION','settings');
require '../../include/cp_header.php';

/**
* This function prepares an option to show in confgiuration form
* @param array Configuration option
* @return string
*/
function xt_form_field($name, $option, $ret = 0)
{
    global $xtAssembler, $xtFunctions;
    static $ids = 0;

    $form = new RMForm('', '', '');

    $currentSettings = $xtAssembler->theme()->settings($name);

    if ($currentSettings !== false)
        $option['value'] = $currentSettings;
    else
        $option['value'] = $option['default'];

    $cleaner = TextCleaner::getInstance();

    $name = 'conf_' . $name;

    switch ($option['type']) {
        case 'checkbox_groups':
        case 'group_multi':
            $ele = new RMFormGroups($option['caption'], $name, 1, 1, 3, $option['value']);
            break;
        case 'radio_groups':
            $ele = new RMFormGroups($option['caption'], $name, 0, 1, 3, $option['value']);
            break;
        case 'group':
        case 'select_groups':
            $ele = new RMFormGroups($option['caption'], $name, 0, 0, 3, $option['value']);
            break;
        case 'select_groups_multi':
            $ele = new RMFormGroups($option['caption'], $name, 1, 0, 3, $option['value']);
            break;
        case 'editor':
            /*if ($rmc_config['editor_type']=='tiny'){
                $tiny = TinyEditor::getInstance();
                $tiny->add_config('elements',$name);
            }*/
            $ele = new RMFormEditor($option['caption'], $name, isset($option['size']) ? $option['size'] : '100%', '300px', $option['value'], '', 1, array('op'));
            break;
        case 'theme':
        case 'select_theme':
            $ele = new RMFormTheme($option['caption'], $name, 0, 0, $option['value'], 3);
            break;
        case 'theme_multi':
        case 'select_theme_multi':
        case 'checkbox_theme':
            $ele = new RMFormTheme($option['caption'], $name, 1, 1, $option['value'], 3);
            break;
        case 'gui':
            $ele = new RMFormTheme($option['caption'], $name, 0, 0, $option['value'], 3, 'GUI');
            break;
        case 'gui_multi':
            $ele = new RMFormTheme($option['caption'], $name, 1, 1, $option['value'], 3, 'GUI');
            break;
        case 'yesno':
            $ele = new RMFormYesNo($option['caption'], $name, $option['value']);
            break;
        case 'email':
            $ele = new RMFormText($option['caption'], $name, isset($option['size']) && $option['size'] > 0 ? $option['size'] : 50, null, $option['value']);
            $ele->setClass('email');
            break;
        case 'select':
            $ele = new RMFormSelect($option['caption'], $name, 0, [$option['value']]);
            foreach ($option['options'] as $opvalue => $op) {
                $ele->addOption($opvalue, $op, $opvalue == $option['value'] ? 1 : 0);
            }
            break;
        case 'select_multi':
            $ele = new RMFormSelect($option['caption'], $name . '[]', 1, $option['value']);
            foreach ($option['options'] as $opvalue => $op) {
                $ele->addOption($opvalue, $op);
            }
            break;
        case 'language':
        case 'select_language':
            $ele = new RMFormLanguageField($option['caption'], $name, 0, 0, $option['value'], 3);
            break;
        case 'select_language_multi':
        case 'checkbox_language':
        case 'language_multi':
            $ele = new RMFormLanguageField($option['caption'], $name, 1, 1, !is_array($option['value']) ? array($option['value']) : $option['value'], 3);
            break;
        case 'modules':
            $ele = new RMFormModules($option['caption'], $name, 0, 0, $option['value'], 3);
            $ele->setInserted(array('--' => __('None', 'rmcommon')));
            break;
        case 'modules_multi':
        case 'checkbox_modules':
            $ele = new RMFormModules($option['caption'], $name, 1, 1, $option['value'], 3);
            $ele->setInserted(array('--' => __('None', 'rmcommon')));
            break;
        case 'timezone':
        case 'select_timezone':
            $ele = new RMFormTimeZoneField($option['caption'], $name, 0, 0, $option['value'], 3);
            break;
        case 'timezone_multi':
            $ele = new RMFormTimeZoneField($option['caption'], $name, 0, 1, $option['value'], 3);
            break;
        case 'textarea':
            $ele = new RMFormTextArea($option['caption'], $name, 5, isset($option['size']) && $option['size'] > 0 ? $option['size'] : 50, $option['content'] == 'array' ? $cleaner->specialchars(implode('|', $option['value'])) : $cleaner->specialchars($option['value']));
            break;
        case 'user':
            $ele = new RMFormUser($option['caption'], $name, false, $option['value'], 300);
            break;
        case 'user_multi':
            $ele = new RMFormUser($option['caption'], $name, true, !is_array($option['value']) ? array($option['value']) : $option['value'], 300);
            break;
        case 'radio':
            $ele = new RMFormRadio([
                'caption' => $option['caption'],
                'name' => $name,
                'value' => $option['value'],
                'display' => 'inline'
            ]);
            foreach ($option['options'] as $opvalue => $op) {
                $ele->addOption($op, $opvalue, $opvalue == $option['value'] ? 1 : 0);
            }
            break;
        case 'webfonts':
            $ele = new RMFormWebfonts($option['caption'], $name, $option['value']);
            break;
        case 'imageurl':
            $ele = new RMFormImageUrl($option['caption'], $name, $option['value']);
            break;
        case 'slider':
            if ($ret) return;
            $ele = new RMFormSlider($option['caption'], $name, $option['value']);
            $ele->addField('title', array('caption' => __('Slider Title', 'xthemes'), 'description' => __('Show the slider title', 'xthemes'), 'type' => 'textbox'));
            $i = 0;

            $option['options'] = isset($option['options']) && is_array($option['options']) ? $option['options'] : (isset($option['options']) ? [$option['options']] : []);

            foreach ($option['options'] as $id => $data) {
                $ele->addField($id, $data);
            }
            break;
        case 'color':
            $ele = new RMFormColorSelector($option['caption'], $name, $option['value'], true);
            break;
        case 'imageselect':
            $ele = new RMFormImageSelect($option['caption'], $name, $option['value']);
            foreach ($option['options'] as $v => $url) {
                $ele->addImage($v, $url);
            }
            break;
        case 'textbox':
        case 'password':
        default:
            $ele = new RMFormText($option['caption'], $name, isset($option['size']) && $option['size'] > 0 ? $option['size'] : 50, null, $option['value'], $option['type'] == 'password' ? 1 : 0);
            break;
    }

    $ele = RMEvents::get()->trigger('xthemes.load.form.field', $ele, array_merge($option, ['name' => $name]));

    $ele->setId('xtfield-' . $ids);

    $controls = [
        'select_groups',
        'select_groups_multi',
        'theme',
        'select_theme',
        'select_theme_multi',
        'gui',
        'gui_multi',
        'email',
        'select',
        'select_multi',
        'language',
        'select_language',
        'modules',
        'timezone',
        'select_timezone',
        'textarea',
        'textbox'
    ];

    if (in_array($option['type'], $controls)){
        $ele->add('class', 'form-control');
    }

    $ids++;
    return $ret ? $ele : $ele->render();
    
}

/**
* Show the form to configure current theme
*/
function xt_show_options(){
    global $xoopsModule, $xtAssembler, $xtFunctions, $xoopsSecurity;

    $tpl = RMTemplate::get();

    $options = $xtAssembler->theme()->options();
    $sections = $options['sections'];
    $topt = $options['options'];

    $visible = isset($_COOKIE['xtsection']) ? $_COOKIE['xtsection'] : key($sections);
    
    $options = array();

    foreach($topt as $id => $option){

        if ( !isset( $option['type'] ) || $option['type']!='heading' )
            $option['field'] = xt_form_field($id, $option);

        $options[$option['section']][$id] = $option;
        
    }

	$tpl->add_style("xthemes.min.css",'xthemes');
    $tpl->add_local_script('jquery.ck.js', 'rmcommon');
    $tpl->add_local_script('xthemes.min.js', 'xthemes');
    xoops_cp_header();
    
    include $tpl->get_template('xt_settings.php','module','xthemes');
    
    xoops_cp_footer();
}


function xt_save_settings(){
    global $xoopsConfig, $xtAssembler, $xtFunctions;

    if (!$xtAssembler->isSupported())
        redirectMsg('index.php', __('This is a not valid theme','xthemes'), 1);
    
    $xt_to_save = array();
    
    $theme = $xtAssembler->theme();
    
    foreach ($_POST as $id => $v){
        if(substr($id, 0, 5)!='conf_') continue;
        
        $xt_to_save[substr($id, 5)] = $theme->checkSettingValue($v);

    }
    
    if(!$xtFunctions->insertOptions($theme, $xt_to_save))
        redirectMsg('settings.php', __('Settings could not be saved! Please try again','xthemes'), RMMSG_ERROR);
    
    RMEvents::get()->run_event('xtheme.save.settings', $xt_to_save);
    
    redirectMsg('settings.php', __('Settings updated successfully!', 'xthemes'), RMMSG_SAVED);
}

$action = rmc_server_var($_REQUEST, 'action', '');

switch($action){
    
    case 'save':
        xt_save_settings();
        break;
        
    default:
        xt_show_options();
        break;
    
}