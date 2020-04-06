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
ALTER TABLE `{$commentTable}` DROP FOREIGN KEY `FK_09BDF04C1444BECFF3A452BCD2872AF4`;
ALTER TABLE `{$commentTable}` 
ADD CONSTRAINT `FK_09BDF04C1444BECFF3A452BCD2872AF4` 
FOREIGN KEY (`entry_id`) 
REFERENCES `{$entryTable}` (`entity_id`) 
ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE {$commentTable} MODIFY COLUMN entry_id int NOT NULL;
    ");

$installer->endSetup();