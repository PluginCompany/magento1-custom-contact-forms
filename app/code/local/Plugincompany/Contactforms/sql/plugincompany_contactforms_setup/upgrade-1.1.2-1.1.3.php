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
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'rtl', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TINYINT,
        'nullable' => false,
        'default' => 0,
        'comment' => 'Use RTL yesno'
    ));
$this->endSetup();
