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
 * Form Entry edit form tab
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Entry_Edit_Tab_Admin
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Entry_Edit_Tab_Form
     * @author Milan Simek
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('entry_');
        $form->setFieldNameSuffix('entry');
        $this->setForm($form);
        $fieldset = $form->addFieldset('entry_form', array('legend'=>Mage::helper('plugincompany_contactforms')->__('Admin Notification Details')));

        $fieldset->addField('admin_email', 'pchtml', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Notification recipient'),
            'name'  => 'admin_email',
//            'note'	=> $this->__('The admin e-mail address that received the admin notification'),
        ));

        $fieldset->addField('admin_bcc', 'pchtml', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('BCC recipient(s)'),
            'name'  => 'admin_bcc',
        ));

        $fieldset->addField('admin_subject', 'pchtml', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Notification subject'),
            'name'  => 'admin_subject',
        ));

        $fieldset->addField('admin_notification', 'pchtml', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Notification content'),
            'name'  => 'admin_notification',
            'note'	=> $this->__('The e-mail notification sent to the admin.'),
            'html_safe' => true
        ));

        $formValues = Mage::registry('current_entry')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getEntryData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getEntryData());
            Mage::getSingleton('adminhtml/session')->setEntryData(null);
        }
        elseif (Mage::registry('current_entry')){
            $formValues = array_merge($formValues, Mage::registry('current_entry')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
