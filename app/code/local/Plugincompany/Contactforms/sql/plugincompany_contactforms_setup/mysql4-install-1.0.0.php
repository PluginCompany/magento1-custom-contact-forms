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
$installer = $this;

$formTable = $installer->getTable('plugincompany_contactforms/form');

$sql = "
DROP TABLE IF EXISTS {$formTable};
CREATE TABLE `{$formTable}`
  (
     `entity_id`                  INT NOT NULL auto_increment comment 'Form ID',
     `title`                      VARCHAR(255) NOT NULL comment 'Form Title',
     `enabled`                    SMALLINT NOT NULL comment 'Enable Form',
     `frontend_page`              SMALLINT NOT NULL comment
     'Create Front-end URL',
     `enable_captcha`             SMALLINT NOT NULL comment 'Enable Captcha',
     `notify_customer`            SMALLINT NOT NULL comment
     'Enable Customer Notification',
     `customer_from_name`         VARCHAR(255) NULL comment 'From Name',
     `customer_from_email`        VARCHAR(255) NULL comment
     'From e-mail address',
     `customer_mail_subject`      VARCHAR(255) NULL comment
     'Notification Subject',
     `customer_mail_bcc`          VARCHAR(255) NULL comment
     'Send e-mail copy to',
     `customer_mail_content`      TEXT NOT NULL comment 'Customer notification content',
     `contact_form_html`          LONGTEXT NULL comment 'Contact Form HTML',
     `contact_form_json`          LONGTEXT NULL comment 'Contact Form JSON',
     `notify_admin`               SMALLINT NOT NULL comment 'Enable Admin Notification',
     `admin_from_name`            VARCHAR(255) NULL comment 'From Name',
     `admin_from_email`           VARCHAR(255) NULL comment
     'From e-mail address',
     `admin_to_email`             VARCHAR(255) NULL comment 'To e-mail address',
     `admin_mail_subject`         VARCHAR(255) NOT NULL comment
     'Notification Subject',
     `admin_mail_bcc`             VARCHAR(255) NULL comment
     'Send e-mail copy to',
     `admin_notification_content` TEXT NOT NULL comment 'Notification Content',
     `form_wrapper`               VARCHAR(255) NULL comment
     'The front-end form wrapper',
     `frontend_title`             VARCHAR(255) NULL comment
     'Frontend form title',
     `theme`                      VARCHAR(255) NULL comment 'Front-end theme',
     `max_width`                  VARCHAR(255) NULL comment 'Form max-width',
     `show_title`                 SMALLINT NULL comment
     'Show Title on front end',
     `url_key`                    VARCHAR(255) NULL comment 'URL key',
     `updated_at`                 TIMESTAMP NULL DEFAULT NULL comment
     'Form Modification Time',
     `status`                     INT NULL comment 'Form Status',
     `created_at`                 TIMESTAMP NULL DEFAULT NULL comment
     'Form Creation Time',
     `frontend_success_message`   TEXT NULL comment
     'Frontend from submit message',
     `in_window`                  INT NULL comment 'Lightbox yes no',
     `window_link_text`           VARCHAR(255) NULL comment 'Link text',
     PRIMARY KEY (`entity_id`)
  )
comment='Form Table'
engine=innodb
charset=utf8
COLLATE=utf8_general_ci
";

$installer->run($sql);

$storeTable = $installer->getTable('plugincompany_contactforms/form_store');

$coreStoreTable = $installer->getTable('core/store');

$sql = "
DROP TABLE IF EXISTS {$storeTable};
CREATE TABLE `{$storeTable}`
  (
     `form_id`  INT NOT NULL comment 'Form ID',
     `store_id` SMALLINT UNSIGNED NOT NULL comment 'Store ID',
     PRIMARY KEY (`form_id`, `store_id`),
     INDEX `idx_plugincompany_contactforms_form_store_store_id` (`store_id`),
     CONSTRAINT `fk_6dcec28311201a0b2d1b9f89f588ca7a` FOREIGN KEY (`form_id`)
     REFERENCES `{$formTable}` (`entity_id`) ON DELETE
     CASCADE ON UPDATE CASCADE,
     CONSTRAINT `fk_7471964d0f0dac5acd0106a3c66386c9` FOREIGN KEY (`store_id`)
     REFERENCES `{$coreStoreTable}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
  )
comment='Forms To Store Linkage Table'
engine=innodb
charset=utf8
COLLATE=utf8_general_ci
";

$installer->run($sql);

$this->endSetup();
