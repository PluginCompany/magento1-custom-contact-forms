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

//fix for 1.8.0 bug
$forms = Mage::getModel('plugincompany_contactforms/form')->getCollection();
foreach($forms as $form) {
 $form = $form->load($form->getId());
 if(!$form->getStoreId()){
  $form->setStoreId(array(0));
  $form->save();
 }
}

$this->endSetup();
