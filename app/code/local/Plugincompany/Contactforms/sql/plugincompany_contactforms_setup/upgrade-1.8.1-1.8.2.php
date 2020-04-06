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

$this->getConnection()
    ->dropForeignKey($this->getTable('plugincompany_contactforms/entry_comment'),$this->getFkName('plugincompany_contactforms/entry_comment', 'entry_id', 'plugincompany_contactforms/entry', 'entity_id'))
    ->addForeignKey($this->getFkName('plugincompany_contactforms/entry_comment', 'entry_id', 'plugincompany_contactforms/entry', 'entity_id'),  $this->getTable('plugincompany_contactforms/entry_comment'),'entry_id', $this->getTable('plugincompany_contactforms/entry'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
;

$this->endSetup();
