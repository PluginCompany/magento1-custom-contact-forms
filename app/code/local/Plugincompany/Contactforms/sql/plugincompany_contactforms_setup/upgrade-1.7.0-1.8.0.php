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

$this->getConnection()->dropTable($this->getTable('plugincompany_contactforms/entry_comment'));
$table = $this->getConnection()
    ->newTable($this->getTable('plugincompany_contactforms/entry_comment'))
    ->addColumn('comment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Comment ID')
    ->addColumn('form_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
    ), 'Form ID')
    ->addColumn('entry_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
    ), 'Form Entry ID')
    ->addColumn('admin_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Admin User ID')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Comment Creation Date')
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
    ), 'Comment Contents')
    ->addForeignKey($this->getFkName('plugincompany_contactforms/entry_comment', 'entry_id', 'plugincompany_contactforms/entry', 'entity_id'), 'comment_id', $this->getTable('plugincompany_contactforms/entry'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Form submissions comments table')
;

$this->getConnection()->createTable($table);

$this->getConnection()
    ->addColumn($this->getTable('plugincompany_contactforms/entry'), 'increment_id', array(
        'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'nullable' => true,
        'comment' => 'Form entry increment ID'
    ));

$conn = $this->getConnection();

$conn
    ->addColumn($this->getTable('plugincompany_contactforms/entry'), 'increment_text', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => true,
        'comment' => 'Form entry increment'
    ));

$this->getConnection()
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'entry_increment_prefix', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => true,
        'comment' => 'Form entry increment ID prefix'
    ));

$this->getConnection()
    ->addColumn($this->getTable('plugincompany_contactforms/form'), 'entry_increment_id_counter', array(
        'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'nullable' => false,
        'default' => 0,
        'comment' => 'Last increment counter'
    ))
;

$connection = $this->getConnection();
$this->getConnection()
    ->modifyColumn($this->getTable('plugincompany_contactforms/entry'), 'status', array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'default' => 0,
        'nullable' => false,
        'comment' => 'Entry Status'
    ));

//add reference to all form submissions
$forms = Mage::getModel('plugincompany_contactforms/form')->getCollection();
foreach($forms as $form){
    $form = $form->load($form->getId());
    $entries = $form->getSelectedEntriesCollection();
    $entries->addOrder('entity_id','ASC');
    $i = 0;
    foreach($entries as $entry){
        $i++;
        $form->setEntryIncrementIdCounter($i);
        $entry
            ->setIncrementId($i)
            ->setIncrementText($form->getCurrentIncrementText())
            ->save();
    }
    $form->save();
}

$this->endSetup();
