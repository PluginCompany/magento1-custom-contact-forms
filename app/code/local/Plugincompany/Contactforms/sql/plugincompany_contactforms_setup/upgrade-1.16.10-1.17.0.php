<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */

/**
 * Contactforms module install script
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
$this->startSetup();

$conn = $this->getConnection();

$this->getConnection()
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'focus_first_field', array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable' => false,
        'default' => 0,
        'comment' => 'Focus on first field'
    ));

$this->endSetup();
