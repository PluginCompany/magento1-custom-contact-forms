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
 * Form Entry admin edit tabs
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Entry_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs {
    /**
     * Initialize Tabs
     * @access public
     * @author Milan Simek
     */
    public function __construct() {
        parent::__construct();
        $this->setId('entry_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('plugincompany_contactforms')->__('Form Submission'));
    }
    /**
     * before render html
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Entry_Edit_Tabs
     * @author Milan Simek
     */
    protected function _beforeToHtml(){
        $this->addTab('form_entry', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Form Submission'),
            'title'        => Mage::helper('plugincompany_contactforms')->__('Form Submission'),
            'content'     => $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_entry_edit_tab_form')->toHtml(),
        ));
        $this->addTab('customer_notification', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Customer Notification'),
            'title'        => Mage::helper('plugincompany_contactforms')->__('Customer Notification'),
            'content'     => $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_entry_edit_tab_customer')->toHtml(),
        ));
        $this->addTab('admin_notification', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Admin Notification'),
            'title'        => Mage::helper('plugincompany_contactforms')->__('Admin Notification'),
            'content'     => $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_entry_edit_tab_admin')->toHtml(),
        ));
        $this->addTab('comments', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Comments'),
            'title'        => Mage::helper('plugincompany_contactforms')->__('Comments'),
            'content'     =>
                $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_entry_edit_tab_comments_new')->toHtml() .
                $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_entry_edit_tab_comments')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve form entry entity
     * @access public
     * @return Plugincompany_Contactforms_Model_Entry
     * @author Milan Simek
     */
    public function getEntry(){
        return Mage::registry('current_entry');
    }
}
