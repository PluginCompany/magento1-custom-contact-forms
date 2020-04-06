<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */
$this->startSetup();
$this->getConnection()
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'admin_reply_to_email', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => true,
        'comment' => 'Reply to e-mail for admin notification'
    ));
$this->endSetup();
