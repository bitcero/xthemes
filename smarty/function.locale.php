<?php
// $Id: function.locale.php 99 2012-10-24 21:46:58Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

/**
* This function enable the capacity of translate themes for Xoops
*/
function smarty_function_locale($params, &$smarty){
    global $xtAssembler;
    
    $theme = $xtAssembler->theme()->getInfo('dir');
    
    return __($params['t'], $theme);
    
}