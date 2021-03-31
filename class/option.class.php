<?php

/**
 * xThemes Themes Framework for Common Utilities
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
class Xthemes_Option extends RMObject
{
    public function __construct($id = null, $theme = '')
    {
        $this->noTranslate = ['name', 'type'];
        $this->ownerName = 'xthemes';
        $this->ownerType = 'module';

        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->_dbtable = $this->db->prefix('xt_options');
        $this->setNew();
        $this->initVarsFromTable();
        $this->setVarType('value', XOBJ_DTYPE_SOURCE);

        if (null === $id) {
            return;
        }

        if (is_int($id)) {
            $load = $this->loadValues($id);
        } else {
            $sql = 'SELECT * FROM ' . $this->_dbtable . " WHERE `name`='$id' AND `theme`=$theme";
            $result = $this->db->query($sql);

            if ('' != $this->db->error()) {
                $this->addError($this->db->error());
            }

            if ($this->db->getRowsNum($result) <= 0) {
                return false;
            }

            $data = $this->db->fetchArray($result);
            $this->assignVars($data);
            $this->unsetNew();
            $load = true;
        }

        if ($load) {
            $this->unsetNew();
        }
    }

    public function save()
    {
        if ($this->isNew()) {
            return $this->saveToTable();
        }

        return $this->updateTable();
    }

    public function delete()
    {
        return $this->deleteFromTable();
    }
}
