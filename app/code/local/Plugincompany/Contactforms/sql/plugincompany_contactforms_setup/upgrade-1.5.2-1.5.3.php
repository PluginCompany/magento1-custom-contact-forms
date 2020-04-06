<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */
$this->startSetup();
$this->getConnection()
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'condit_to_email', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => true,
        'comment' => 'Conditional Notification Recipient in JSON array'
    ));
$this->endSetup();
