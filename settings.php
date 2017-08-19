<?php
// $Id: settings.php 120 2012-11-03 18:30:52Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

define('RMCLOCATION', 'settings');
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
        case 'hidden':
            return '';
            break;
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

    if (in_array($option['type'], $controls)) {
        $ele->add('class', 'form-control');
    }

    $ids++;
    return $ret ? $ele : $ele->render();

}

/**
 * Show the form to configure current theme
 */
function xt_show_options()
{
    global $xoopsModule, $xtAssembler, $xtFunctions, $xoopsSecurity, $common;

    $id = $common->httpRequest()::get('theme', 'string', '');

    $tpl = RMTemplate::get();

    if('' == $id){
        $theme = $xtAssembler->theme();
    } else {
        $theme = $xtAssembler->loadTheme($id);
    }

    $options = $theme->options();
    $sections = $options['sections'];
    $topt = $options['options'];

    $visible = isset($_COOKIE['xtsection']) ? $_COOKIE['xtsection'] : key($sections);

    $options = array();

    foreach ($topt as $id => $option) {

        if (!isset($option['type']) || $option['type'] != 'heading')
            $option['field'] = xt_form_field($id, $option);

        $options[$option['section']][$id] = $option;

    }

    $tpl->add_style("xthemes.min.css", 'xthemes');
    $tpl->add_script('jquery.ck.js', 'rmcommon', ['footer' => 1]);
    $tpl->add_script('xthemes.min.js', 'xthemes', ['id' => 'xthemes-js', 'footer' => 1]);

    $tpl->add_inline_script('var confirmDeletion = "' . __('Do your really want to restore default settings for this theme? All current configurations will be lost.', 'xthemes') . '";');

    xoops_cp_header();

    include $tpl->path('xt-settings.php', 'module', 'xthemes');

    xoops_cp_footer();
}


function xt_save_settings()
{
    global $xoopsConfig, $xtAssembler, $xtFunctions;

    if (!$xtAssembler->isSupported())
        redirectMsg('index.php', __('This is a not valid theme', 'xthemes'), 1);

    $xt_to_save = array();

    $theme = $xtAssembler->theme();

    foreach ($_POST as $id => $v) {
        if (substr($id, 0, 5) != 'conf_') continue;

        $xt_to_save[substr($id, 5)] = $theme->checkSettingValue($v);

    }

    $result = $xtFunctions->insertOptions($theme, $xt_to_save);

    if (true !== $result)
        redirectMsg('settings.php', __('Settings could not be saved! Please try again', 'xthemes') . $result, RMMSG_ERROR);

    RMEvents::get()->trigger('xtheme.save.settings', $xt_to_save);

    redirectMsg('settings.php', __('Settings updated successfully!', 'xthemes'), RMMSG_SAVED);
}


function xt_restore_settings()
{
    global $common;

    $common->ajax()->prepare();
    $common->checkToken();

    $dir = $common->httpRequest()::post('theme', 'string', '');

    if ('' == $dir) {
        $common->ajax()->notifyError(__('Provided theme is not valid!', 'xthemes'));
    }

    $xtAssembler = XtAssembler::getInstance();
    $xtAssembler->loadTheme($dir);

    if (false == $common->nativeTheme) {
        $common->ajax()->response(
            __('Provided theme is not a xThemes Theme', 'xthemes'), RMMSG_WARN, 0, [
                'reload' => true
            ]
        );
    }

    $options = $xtAssembler->theme()->options();
    $toSave = [];

    foreach ($options['options'] as $name => $option) {
        $toSave[$name] = $option['default'];
    }

    if (XtFunctions::getInstance()->insertOptions($xtAssembler->theme(), $toSave)) {
        RMEvents::get()->trigger('xtheme.save.settings', $toSave);
        showMessage(__('Default settings has been restored successfully!', 'xthemes'), RMMSG_SUCCESS);
        $common->ajax()->response(
            __('Default settings has been restored successfully!', 'xthemes'), RMMSG_SUCCESS, 0, [
                'reload' => true
            ]
        );
    }

    $common->ajax()->notifyError(__('Default settings could not be restored. Please try again.', 'xthemes'));
}

function xt_export_settings()
{
    global $common, $xtAssembler;

    $common->ajax()->prepare();

    $id = $common->httpRequest()::get('theme', 'string', 'current');

    if('current' == $id){
        $theme = $xtAssembler->theme();
    } else {
        $theme = $xtAssembler->loadTheme($id);
    }

    $file = XOOPS_CACHE_PATH . '/xtexport.xtheme';
    $toSave = [
        'settings' => $theme->settings()
    ];

    $sql = "SELECT * FROM " . $common->db()->prefix("xt_menus") . " WHERE theme = " . $theme->id();
    $result = $common->db()->queryF($sql);
    $menus = [];
    while($row = $common->db()->fetchArray($result)){
        $menus[$row['menu']] = $row['content'];
    }

    $toSave['menu'] = $menus;

    file_put_contents($file, base64_encode(json_encode($toSave)));

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$theme->getInfo('dir').'-export.xtheme"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    @unlink($file);
    exit;
}

function xt_import_settings_form()
{
    global $common;

    $common->template()->header();

    $id = $common->httpRequest()::get('theme', 'string', 'current');

    $form = new RMForm([
        'title' => __('Import Settings', 'xthemes'),
        'action' => 'settings.php',
        'method' => 'post',
        'enctype' => 'multipart/form-data'
    ]);

    $form->addElement(new RMFormFile([
        'caption' => __('Settings file', 'xthemes'),
        'name' => 'file',
        'id' => 'import-file',
        'required' => null,
        'accept' => '.xtheme'
    ]));

    $form->addElement(new RMFormYesNo([
        'caption' => __('Import settings', 'xthemes'),
        'value' => 1,
        'name' => 'settings'
    ]));

    $form->addElement(new RMFormYesNo([
        'caption' => __('Import menus', 'xthemes'),
        'value' => 0,
        'name' => 'menus'
    ]))->setDescription(__('If you import menus, existing menus for this theme will be replaced.', 'xthemes'));

    $form->addElement(new RMFormHidden('action', 'import-settings'));
    $form->addElement(new RMFormHidden('theme', $id));

    $btnCancel = new RMFormButton([
        'caption' => __('Cancel', 'xthemes'),
        'type' => 'button',
        'class' => 'btn btn-default',
        'onclick' => 'history.go(-1);'
    ]);

    $btnSubmit = new RMFormButton([
        'caption' => __('Import Now!', 'xthemes'),
        'type' => 'submit',
        'class' => 'btn btn-primary'
    ]);

    $buttons = new RMFormButtonGroup();
    $buttons->addButton($btnSubmit);
    $buttons->addButton($btnCancel);

    $form->addElement($buttons);

    $form->display();

    $common->template()->footer();

}

function xt_import_settings()
{
    global $common, $xtAssembler;

    if(false == $common->security()->check()){
        $common->uris()::redirect_with_message(
            __('Session token expired!', 'xthemes'), 'index.php', RMMSG_ERROR
        );
    }

    $settings = $common->httpRequest()::post('settings', 'integer', 1);
    $id = $common->httpRequest()::post('theme', 'string', 'current');
    $menus = $common->httpRequest()::post('menus', 'integer', 0);
    $file = $_FILES['file'];

    if('current' == $id){
        $theme = $xtAssembler->theme();
    } else {
        $theme = $xtAssembler->loadTheme($id);
    }

    if(empty($file)){
        $common->uris()::redirect_with_message(
            __('You must provide a settings file', 'xthemes'), 'themes.php', RMMSG_ERROR
        );
    }

    $fileData = json_decode(base64_decode(file_get_contents($file['tmp_name'])), true);
    if(empty($fileData) || false == is_array($fileData)){
        $common->uris()::redirect_with_message(
            __('This file is not a vlid settings file', 'xthemes'), 'themes.php', RMMSG_ERROR
        );
    }

    if($settings){

        $table = $common->db()->prefix('xt_options');

        if(false == isset($fileData['settings']) || empty($fileData['settings'])){
            $common->uris()::redirect_with_message(
                __('Settings not detected', 'xthemes'), 'themes.php', RMMSG_ERROR
            );
        }

        foreach($fileData['settings'] as $item => $value){
            $sql = "UPDATE $table SET value='" . $common->db()->escape($value) . "' WHERE theme=" . $theme->id() . " AND name='" . $item . "'";
            $common->db()->queryF($sql);
        }

        //RMEvents::get()->trigger('xtheme.save.settings', $fileData['settings']);

    }

    if($menus && false == empty($fileData['menu']) && is_array($fileData['menu']) ){

        $table = $common->db()->prefix('xt_menus');

        foreach($fileData['menu'] as $name => $content){
            $sql = "UPDATE $table SET content='" . $common->db()->escape($content) . "' WHERE theme=" . $theme->id() . " AND menu='".$common->db()->escape($name)."'";
            $common->db()->queryF($sql);
        }

    }

    $common->uris()::redirect_with_message(
        __('Settings imported successfully!', 'xthemes'),
        'settings.php?theme=' . $theme->getInfo('dir'),
        RMMSG_SUCCESS
    );


}


$action = $common->httpRequest()::request('action', 'string', '');

switch ($action) {

    case 'save':
        xt_save_settings();
        break;

    case 'restore':
        xt_restore_settings();
        break;

    case 'export':
        xt_export_settings();
        break;

    case 'import':
        xt_import_settings_form();
        break;

    case 'import-settings':
        xt_import_settings();
        break;

    default:
        xt_show_options();
        break;

}