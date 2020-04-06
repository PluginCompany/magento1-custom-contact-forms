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

$installer->run("
ALTER TABLE `{$formTable}` ADD COLUMN `css_classes` text NULL COMMENT 'Form custom CSS classes';
ALTER TABLE `{$formTable}` ADD COLUMN `custom_css` text NULL COMMENT 'Form custom CSS';  
ALTER TABLE `{$formTable}` ADD COLUMN `pageload_js` text NULL COMMENT 'Pageload custom JS' AFTER `arbitrary_js`;
ALTER TABLE `{$formTable}` ADD COLUMN `beforesubmit_js` text NULL COMMENT 'Before form submit custom JS' AFTER `arbitrary_js`;
    ");

$installer->endSetup();