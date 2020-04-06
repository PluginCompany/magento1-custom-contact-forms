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
 * Form admin edit tabs
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs {
    /**
     * Initialize Tabs
     * @access public
     * @author Milan Simek
     */
    public function __construct() {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('plugincompany_contactforms')->__('Form'));
    }

    private function getFormId()
    {
        $copyFromId = Mage::app()->getRequest()->getParam('copyfromid');
        if($copyFromId){
            return $copyFromId;
        }
        return Mage::app()->getRequest()->getParam('id');
    }

    /**
     * before render html
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tabs
     * @author Milan Simek
     */
    protected function _beforeToHtml(){
        $this->addTab('form_form', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Form Settings'),
            'title'        => Mage::helper('plugincompany_contactforms')->__('Form Settings'),
            'content'     => $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_form')->toHtml(),
        ));

        $formBuilderUrl = $this->getUrl('*/*/formbuilder',array('id'=>$this->getFormId()));
        $this->addTab('form_builder', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Form Builder'),
            'title'        => Mage::helper('plugincompany_contactforms')->__('Form Builder'),
            'content'     =>  "<iframe id='form_builder_iframe' style='border:none;width:100%;min-height:900px;' scrolling='no' src='$formBuilderUrl'></iframe>",
        ));

        $dfieldsUrl = $this->getUrl('*/*/dfields',array('id'=>$this->getFormId()));

        $this->addTab('dependent_fields', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Conditional Form Fields'),
            'title'        => Mage::helper('plugincompany_contactforms')->__('Conditional Form Fields'),
            'content'     =>  "<iframe id='dfields_iframe' style='border:none;width:100%;min-height:300px;' scrolling='no' src='$dfieldsUrl'></iframe>",
        ));

        $this->addTab('form_style', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Front-end Style'),
            'title'        => Mage::helper('plugincompany_contactforms')->__('Front-end Style'),
            'content'     => $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_style')->toHtml(),
        ));

        $this->addTab('form_js', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Custom Javascript'),
            'title'        => Mage::helper('plugincompany_contactforms')->__('Custom Javascript'),
            'content'     => $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_js')->toHtml(),
        ));

        $this->addTab('form_customer_notification', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Customer Notification'),
            'title'        => Mage::helper('plugincompany_contactforms')->__('Customer Notification'),
            'content'     => $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_customernotification')->toHtml(),
        ));
        $this->addTab('form_admin_notification', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Admin Notification'),
            'title'        => Mage::helper('plugincompany_contactforms')->__('Admin Notification'),
            'content'     => $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_adminnotification')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_form', array(
                'label'        => Mage::helper('plugincompany_contactforms')->__('Store Views'),
                'title'        => Mage::helper('plugincompany_contactforms')->__('Store Views'),
                'content'     => $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_stores')->toHtml(),
            ));
        }
        if($id = Mage::app()->getRequest()->getParam('id')){
            $this->addTab('form_entries', array(
                'label'        => Mage::helper('plugincompany_contactforms')->__('Form Submissions'),
                'title'        => Mage::helper('plugincompany_contactforms')->__('Form Submissions'),
                'content'     => $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_entries')->setFormId($id)->toHtml()
            ));
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve form entity
     * @access public
     * @return Plugincompany_Contactforms_Model_Form
     * @author Milan Simek
     */
    public function getForm(){
        return Mage::registry('current_form');
    }
}
