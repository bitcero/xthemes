<?php
// $Id: index.php 116 2012-10-31 20:14:07Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

define('RMCLOCATION','dashboard');
require '../../include/cp_header.php';

load_theme_locale($xoopsConfig['theme_set']);

$rmTpl->add_style('dashboard.css', 'xthemes');

$donateButton = '<form id="paypal-form" name="_xclick" action="https://www.paypal.com/fr/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="ohervis@redmexico.com.mx">
                    <input type="hidden" name="item_name" value="MyWords Support">
                    <input type="hidden" name="amount" value=0>
                    <input type="hidden" name="currency_code" value="USD">
                    <img src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" onclick="$(\'#paypal-form\').submit()" alt="PayPal - The safer, easier way to pay online!" />
    </form>';
$myEmail = 'a888698732624c0a1d4da48f1e5c6bb4';

xoops_cp_header();

include $rmTpl->get_template("xt_index.php", 'module', 'xthemes');

xoops_cp_footer();