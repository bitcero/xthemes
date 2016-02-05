<?php
/**
 * xThemes Framework for Common Utilities
 *
 * Copyright © 2015 Eduardo Cortés http://www.redmexico.com.mx
 * -------------------------------------------------------------
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * -------------------------------------------------------------
 * @copyright    Eduardo Cortés (http://www.redmexico.com.mx)
 * @license      GNU GPL 2
 * @package      xthemes
 * @author       Eduardo Cortés (AKA bitcero)    <i.bitcero@gmail.com>
 * @url          http://www.redmexico.com.mx
 * @url          http://www.eduardocortes.mx
 */

function xoops_module_update_xthemes($mod, $pre){

    global $xoopsDB;

    $table = $xoopsDB->prefix("xt_menus");

    $sql = "SELECT * FROM $table";
    $result = $xoopsDB->query($sql);

    $toSave = [];

    while($row = $xoopsDB->fetchArray($result)){
        $serialized = @unserialize($row['content']);

        if(false !== $serialized){
            $toSave[$row['id_menu']] = $row['content'];
        }
    }

    if(empty($toSave)){
        return true;
    }

    $sql = "UPDATE $table SET content = '%s' WHERE id_menu = %u";

    foreach($toSave as $id => $content){
        $xoopsDB->queryF(sprintf($sql, base64_encode($content), $id));
    }

    return true;

}