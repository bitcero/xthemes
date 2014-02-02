<?php
// $Id: block.htmlhead.php 99 2012-10-24 21:46:58Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

function smarty_block_htmlhead($params, $content, $tpl, &$repeat){
    
    RMTemplate::get()->add_head($content);
    
}
