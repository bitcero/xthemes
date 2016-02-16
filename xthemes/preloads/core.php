<?php
// $Id: core.php 99 2012-10-24 21:46:58Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

class XthemesCorePreload extends XoopsPreloadItem
{
    
    public function eventCoreIncludeCommonLanguage(){

        load_mod_locale('xthemes');
        define('XTPATH', XOOPS_ROOT_PATH.'/modules/xthemes');
        define('XTURL', XOOPS_URL.'/modules/xthemes');

        require_once XTPATH.'/class/xtassembler.class.php';
        $GLOBALS['xtAssembler'] = new XtAssembler();
        $GLOBALS['xtFunctions'] = new XtFunctions();

        load_theme_locale($GLOBALS['xtAssembler']->theme()->getInfo('dir'));

    }

    public function eventCoreHeaderAddMeta(){
        global $xtAssembler;

        /**
        * Init data if neccessary
        */
        if(!defined('XOOPS_CPFUNC_LOADED')){
            $xtAssembler->init();
        }

    }

    public function eventCoreFooterStart(){
        global $xtAssembler;

        /**
         * Init data if neccessary
         */
        if(!defined('XOOPS_CPFUNC_LOADED')){
            $xtAssembler->footer();
        }
    }

    public function eventCoreIndexStart(){

        define('XTHEMES_IS_HOME', 1);

    }
}
