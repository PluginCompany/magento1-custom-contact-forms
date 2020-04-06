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
ALTER TABLE `{$formTable}`
ADD COLUMN `admin_reply_to_email` text NULL COMMENT 'Reply to e-mail for admin notification'
    ;
    ");
$installer->endSetup();