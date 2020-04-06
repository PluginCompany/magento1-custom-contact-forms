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
 * Form edit form tab
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tab_Customernotification
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
        $fieldset = $form->addFieldset('form_customer_notification', array('legend'=>Mage::helper('plugincompany_contactforms')->__('Customer Notification')));
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

        $fieldset->addField('notify_customer', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Enable customer notification'),
            'name'  => 'notify_customer',
            'note'	=> $this->__('Notify customers per e-mail when their form is submitted.'),
            'required'  => true,
            'class' => 'required-entry',

            'values'=> array(
                array(
                    'value' => 2,
                    'label' => Mage::helper('plugincompany_contactforms')->__('Use Store Config'),
                ),
                array(
                    'value' => 1,
                    'label' => Mage::helper('plugincompany_contactforms')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('plugincompany_contactforms')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('customer_to_name', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Recipient name'),
            'name'  => 'customer_to_name',
            'note'	=> $this->__('Leave empty to use the form submission value from the input fields with ID "name" or "firstname" + "lastname" (if available).'),
        ));

        $fieldset->addField('customer_to_email', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Recipient e-mail address'),
            'name' => 'customer_to_email',
            'note' => $this->__('Leave empty to use the form submission value from the input field with ID "email" (if available).'),
        ));

        $fieldset->addField('customer_mail_bcc', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('BCC recipient(s)'),
            'name'  => 'customer_mail_bcc',
            'note'	=> $this->__('Send a copy of the customer notification to this e-mail address / comma-separated list.'),
        ));

        $fieldset->addField('customer_from_name', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Sender name'),
            'name'  => 'customer_from_name',
            'note'	=> $this->__('Leave empty to use the default configuration.'),
        ));

        $fieldset->addField('customer_from_email', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Sender e-mail address'),
            'name'  => 'customer_from_email',
            'note'	=> $this->__('Leave empty to use the default configuration.'),
        ));

        $fieldset->addField('customer_mail_subject', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Notification subject'),
            'name'  => 'customer_mail_subject',
            'note'	=> $this->__('Leave empty to use the default configuration.'),
        ));

        $fieldset->addField('customer_mail_content', 'editor', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Notification content'),
            'name'  => 'customer_mail_content',
            'config' => $wysiwygConfig,
            'note'	=> $this->__('The content of the customer notification e-mail.'),
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
