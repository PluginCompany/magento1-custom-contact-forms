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
 * Form edit form tab style
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tab_Js
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tab_Form
     * @author Milan Simek
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('form_');
        $form->setFieldNameSuffix('form');
        $this->setForm($form);
        $fieldset = $form->addFieldset('form_js', array('legend'=>Mage::helper('plugincompany_contactforms')->__('Custom Javascript')));

        $fieldset->addField('pageload_js', 'textarea', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Arbitrary JS - on page load'),
            'name'  => 'pageload_js',
            'note'    => Mage::helper('plugincompany_contactforms')->__('Javascript to be executed on page load.'),
            'height' => '200px'
        ));

        $fieldset->addField('beforesubmit_js', 'textarea', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Arbitrary JS - before submitting form'),
            'name'  => 'beforesubmit_js',
            'note'    => Mage::helper('plugincompany_contactforms')->__('Javascript to be executed before form submission, for example manipulating some input field values.'),
            'height' => '200px'
        ));

        $fieldset->addField('arbitrary_js', 'textarea', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Arbitrary JS - after form submission'),
            'name'  => 'arbitrary_js',
            'note'    => Mage::helper('plugincompany_contactforms')->__('Javascript to be executed on form submission, for example a Google Analytics tracking event.'),
            'height' => '200px'
        ));

        $formValues = Mage::registry('current_form')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getFormData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getFormData());
            Mage::getSingleton('adminhtml/session')->setFormData(null);
        }
        elseif (Mage::registry('current_form')){
            $formValues = array_merge($formValues, Mage::registry('current_form')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
