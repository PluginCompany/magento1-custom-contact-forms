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
 * Contactforms module install script
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
$this->startSetup();

$this->getConnection()->dropTable($this->getTable('plugincompany_contactforms/form'));
$table = $this->getConnection()
    ->newTable($this->getTable('plugincompany_contactforms/form'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Form ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Form Title')

    ->addColumn('enabled', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Enable Form')

    ->addColumn('frontend_page', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Create Front-end URL')

    ->addColumn('enable_captcha', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Enable Captcha')

    ->addColumn('notify_customer', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Enable Customer Notification')

    ->addColumn('customer_from_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'From Name')

    ->addColumn('customer_from_email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'From e-mail address')

    ->addColumn('customer_mail_subject', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Notification Subject')

    ->addColumn('customer_mail_bcc', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Send e-mail copy to')

    ->addColumn('customer_mail_content', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
        ), 'Customer notification content')

    ->addColumn('contact_form_html', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        ), 'Contact Form HTML')

    ->addColumn('contact_form_json', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        ), 'Contact Form JSON')

    ->addColumn('notify_admin', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        ), 'Enable Admin Notification')

    ->addColumn('admin_from_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'From Name')

    ->addColumn('admin_from_email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'From e-mail address')

    ->addColumn('admin_to_email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'To e-mail address')

    ->addColumn('admin_mail_subject', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Notification Subject')

    ->addColumn('admin_mail_bcc', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Send e-mail copy to')

    ->addColumn('admin_notification_content', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
        ), 'Notification Content')

    ->addColumn('form_wrapper', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'The front-end form wrapper')

    ->addColumn('frontend_title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'Frontend form title')

    ->addColumn('theme', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'Front-end theme')

    ->addColumn('max_width', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'Form max-width')

    ->addColumn('show_title', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
    ), 'Show Title on front end')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        ), 'Enabled')

    ->addColumn('url_key', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'URL key')

     ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'Form Status')

    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Form Modification Time')

    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Form Creation Time')

    ->addColumn('frontend_success_message', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
    ), 'Frontend from submit message')

    ->addColumn('in_window', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    ), 'Lightbox yes no')

    ->addColumn('window_link_text', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'Link text')

    ->setComment('Form Table')
;

$this->getConnection()->createTable($table);

$this->getConnection()->dropTable($this->getTable('plugincompany_contactforms/form_store'));
$table = $this->getConnection()
    ->newTable($this->getTable('plugincompany_contactforms/form_store'))
    ->addColumn('form_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Form ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($this->getIdxName('plugincompany_contactforms/form_store', array('store_id')), array('store_id'))
    ->addForeignKey($this->getFkName('plugincompany_contactforms/form_store', 'form_id', 'plugincompany_contactforms/form', 'entity_id'), 'form_id', $this->getTable('plugincompany_contactforms/form'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('plugincompany_contactforms/form_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Forms To Store Linkage Table');
$this->getConnection()->createTable($table);
$this->endSetup();
