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
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'css_classes', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => true,
        'comment' => 'Form custom CSS classes'
    ));

$this->getConnection()
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'custom_css', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => true,
        'comment' => 'Form custom CSS'
    ));

$this->getConnection()
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'pageload_js', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => true,
        'comment' => 'Pageload custom JS',
        'after' => 'arbitrary_js'
    ));

$this->getConnection()
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'beforesubmit_js', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => true,
        'comment' => 'Before form submit custom JS',
        'after' => 'arbitrary_js'
    ));

$this->endSetup();
