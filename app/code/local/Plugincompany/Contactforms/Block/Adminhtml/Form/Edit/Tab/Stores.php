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
 * store selection tab
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tab_Stores
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tab_Stores
     * @author Milan Simek
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setFieldNameSuffix('form');
        $this->setForm($form);
        $fieldset = $form->addFieldset('form_stores_form', array('legend'=>Mage::helper('plugincompany_contactforms')->__('Store Views')));
        $field = $fieldset->addField('store_id', 'multiselect', array(
            'name'  => 'stores[]',
            'label' => Mage::helper('plugincompany_contactforms')->__('Store Views'),
            'title' => Mage::helper('plugincompany_contactforms')->__('Store Views'),
            'required'  => true,
            'values'=> Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
        ));
        $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
        $field->setRenderer($renderer);
          $form->addValues(Mage::registry('current_form')->getData());
        return parent::_prepareForm();
    }
}
