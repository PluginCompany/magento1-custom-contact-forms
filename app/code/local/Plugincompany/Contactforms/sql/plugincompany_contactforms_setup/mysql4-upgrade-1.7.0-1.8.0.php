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
$installer = $this;

$formTable = $installer->getTable('plugincompany_contactforms/form');
$commentTable = $installer->getTable('plugincompany_contactforms/entry_comment');
$entryTable = $installer->getTable('plugincompany_contactforms/entry');

$installer->run("
DROP TABLE IF EXISTS `{$commentTable}`;
CREATE TABLE `{$commentTable}` (
  `comment_id` int NOT NULL auto_increment COMMENT 'Comment ID' ,
  `form_id` int NOT NULL COMMENT 'Form ID' ,
  `entry_id` int NOT NULL COMMENT 'Form Entry ID' ,
  `admin_id` smallint NOT NULL COMMENT 'Admin User ID' ,
  `created_at` timestamp NULL default NULL COMMENT 'Comment Creation Date' ,
  `content` text NULL COMMENT 'Comment Contents' ,
  PRIMARY KEY (`comment_id`, `form_id`, `entry_id`),
  CONSTRAINT `FK_09BDF04C1444BECFF3A452BCD2872AF4` FOREIGN KEY (`comment_id`) REFERENCES `{$entryTable}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT='Form submissions comments table' ENGINE=INNODB charset=utf8 COLLATE=utf8_general_ci
;
ALTER TABLE `{$entryTable}` ADD COLUMN `increment_id` smallint NULL COMMENT 'Form entry increment ID';
ALTER TABLE `{$entryTable}` ADD COLUMN `increment_text` text NULL COMMENT 'Form entry increment';
ALTER TABLE `{$formTable}` ADD COLUMN `entry_increment_prefix` text NULL COMMENT 'Form entry increment ID prefix';
ALTER TABLE `{$formTable}` ADD COLUMN `entry_increment_id_counter` smallint NOT NULL default '0' COMMENT 'Last increment counter';
ALTER TABLE `{$entryTable}` MODIFY COLUMN `status` int NOT NULL default '0' COMMENT 'Entry Status';
    ");

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

$installer->endSetup();