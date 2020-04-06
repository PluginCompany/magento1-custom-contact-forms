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
$table = $this->getConnection()
    ->newTable($this->getTable('plugincompany_contactforms/entry'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Form Entry ID')
    ->addColumn('form_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
    ), 'Form ID')

    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Store')

    ->addColumn('customer_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Customer Name')

    ->addColumn('customer_email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Customer e-mail')

    ->addColumn('customer_bcc', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Customer BCC')

    ->addColumn('sender_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Sender Name')

    ->addColumn('sender_email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Sender e-mail')

    ->addColumn('customer_subject', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Customer Notification Subject')

    ->addColumn('customer_notification', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
    ), 'Customer Notification')

    ->addColumn('admin_email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Admin e-mail')

    ->addColumn('admin_bcc', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Admin BCC')

    ->addColumn('admin_notification', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
    ), 'Admin Notification')

    ->addColumn('admin_subject', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Admin Notification Subject')

    ->addColumn('fields', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
    ), 'Form Fields')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
    ), 'Enabled')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'Form Entry Status')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Form Entry Modification Time')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Form Entry Creation Time')
    ->addIndex($this->getIdxName('plugincompany_contactforms/form', array('form_id')), array('form_id'))
    ->setComment('Form Entry Table');
$this->getConnection()->createTable($table);
