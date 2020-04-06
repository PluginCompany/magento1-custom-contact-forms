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
 * Form Entry admin edit form
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Entry_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * constructor
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'plugincompany_contactforms';
        $this->_controller = 'adminhtml_entry';
        $this->removeButton('save');
        $this->_updateButton('delete', 'label', Mage::helper('plugincompany_contactforms')->__('Delete Form Submission'));
        $this->_formScripts[] = "
            function updateStatus(em){
                var newStatus = em.value;
                new Ajax.Updater('messages','" . Mage::helper('adminhtml')->getUrl('*/*/changeStatus',array('_current'=>true)) . "', {
                method: 'post',
                parameters: {
                    form_key:FORM_KEY,
                    status: newStatus
                }
            });
            }
        ";
    }

    /**
     * get the edit form header
     * @access public
     * @return string
     * @author Milan Simek
     */
    public function getHeaderText(){
        if( Mage::registry('current_entry') && Mage::registry('current_entry')->getId() ) {
            return Mage::helper('plugincompany_contactforms')->__("Form Submission by '%s'", $this->escapeHtml(Mage::registry('current_entry')->getCustomerName()));
        }
    }

    public function getBackUrl()
    {
        if(Mage::app()->getRequest()->getParam('backtoform')){
            return Mage::helper('adminhtml')->getUrl('adminhtml/contactforms_form/edit',array('id'=> Mage::registry('current_entry')->getFormId(),'active_tab'=>'form_entries'));
        }
        return $this->getUrl('*/*/');
    }
}
