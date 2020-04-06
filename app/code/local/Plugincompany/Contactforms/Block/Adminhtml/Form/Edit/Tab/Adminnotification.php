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
class Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tab_Adminnotification
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
        $fieldset = $form->addFieldset('form_admin_notification', array('legend'=>Mage::helper('plugincompany_contactforms')->__('Admin Notification')));
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

        $fieldset->addField('notify_admin', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Enable admin notification'),
            'name'  => 'notify_admin',
            'note'	=> $this->__('Notify the admin per e-mail when a form is submitted.'),
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

        $fieldset->addField('admin_to_email', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Notification recipient'),
            'name'  => 'admin_to_email',
            'note'	=> $this->__('Leave empty to use the default configuration.'),
        ));

        $fieldset->addField('admin_mail_bcc', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('BCC recipient(s)'),
            'name'  => 'admin_mail_bcc',
            'note'	=> $this->__('Send a copy of the admin notification to this e-mail address / comma-separated list.'),
        ));

        $fieldset->addField('condit_to_email', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Conditional recipient(s)'),
            'name'  => 'condit_to_email',
        ));

        $custom = $form->getElement('condit_to_email');
        $custom->setRenderer(
            $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_table_grid')
        );


        $fieldset->addField('admin_from_name', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Sender name'),
            'name'  => 'admin_from_name',
            'note'	=> $this->__('Leave empty to use the default configuration.'),
        ));

        $fieldset->addField('admin_from_email', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Sender e-mail address'),
            'name'  => 'admin_from_email',
            'note'	=> $this->__('Leave empty to use the default configuration.'),
        ));

        $fieldset->addField('admin_reply_to_email', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Reply to e-mail address'),
            'name' => 'admin_reply_to_email',
            'note' => $this->__('The recipient of replies to admin notifications. To directly reply to customers, use the ID of the e-mail address input field, for example {email}.'),
        ));

        $fieldset->addField('admin_mail_subject', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Notification subject'),
            'name'  => 'admin_mail_subject',
            'note'	=> $this->__('Leave empty to use the default configuration.'),
        ));

        $fieldset->addField('admin_notification_content', 'editor', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Notification content'),
            'name'  => 'admin_notification_content',
            'config' => $wysiwygConfig,
            'note'	=> $this->__('The content of the admin notification e-mail.'),

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
