<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */

/**
 * Contactforms module upgrade script
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
$this->startSetup();
$installer = $this;

$entryTable = $installer->getTable('plugincompany_contactforms/entry');

$installer->run("
CREATE TABLE IF NOT EXISTS `{$entryTable}` (
  `entity_id` int NOT NULL auto_increment COMMENT 'Form Entry ID' ,
  `form_id` int UNSIGNED NULL COMMENT 'Form ID' ,
  `store_id` int NOT NULL COMMENT 'Store' ,
  `customer_name` varchar(255) NOT NULL COMMENT 'Customer Name' ,
  `customer_email` varchar(255) NOT NULL COMMENT 'Customer e-mail' ,
  `customer_bcc` varchar(255) NOT NULL COMMENT 'Customer BCC' ,
  `sender_name` varchar(255) NOT NULL COMMENT 'Sender Name' ,
  `sender_email` varchar(255) NOT NULL COMMENT 'Sender e-mail' ,
  `customer_subject` varchar(255) NOT NULL COMMENT 'Customer Notification Subject' ,
  `customer_notification` text NOT NULL COMMENT 'Customer Notification' ,
  `admin_email` varchar(255) NOT NULL COMMENT 'Admin e-mail' ,
  `admin_bcc` varchar(255) NOT NULL COMMENT 'Admin BCC' ,
  `admin_notification` text NOT NULL COMMENT 'Admin Notification' ,
  `admin_subject` varchar(255) NOT NULL COMMENT 'Admin Notification Subject' ,
  `fields` text NOT NULL COMMENT 'Form Fields' ,
  `updated_at` timestamp NULL default NULL COMMENT 'Form Entry Modification Time' ,
  `status` int NULL COMMENT 'Form Entry Status' ,
  `created_at` timestamp NULL default NULL COMMENT 'Form Entry Creation Time' ,
  PRIMARY KEY (`entity_id`),
  INDEX `IDX_PLUGINCOMPANY_CONTACTFORMS_FORM_FORM_ID` (`form_id`)
) COMMENT='Form Entry Table' ENGINE=INNODB charset=utf8 COLLATE=utf8_general_ci
    ");
$installer->endSetup();