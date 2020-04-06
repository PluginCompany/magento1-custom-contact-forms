<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */
 ?>
<?php

/**
 * Contactforms module upgrade script
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
$this->startSetup();
$this->getConnection()
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'customer_to_email', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => false,
        'comment' => 'Customer notification recipient address'
    ))
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'customer_to_name', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => false,
        'comment' => 'Customer notification recipient name'
    ));
$this->endSetup();
