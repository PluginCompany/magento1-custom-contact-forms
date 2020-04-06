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
 * Form admin edit form
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Form_Edit
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
        $this->_controller = 'adminhtml_form';
        $this->_updateButton('save', 'label', Mage::helper('plugincompany_contactforms')->__('Save Form'));
        $this->_updateButton('save', 'onclick', 'submitForm()');
        $this->_updateButton('delete', 'label', Mage::helper('plugincompany_contactforms')->__('Delete Form'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('plugincompany_contactforms')->__('Save And Continue Edit'),
            'onclick'    => 'saveAndContinueEdit()',
            'class'        => 'save',
        ), -100);
        if($this->getRequest()->getParam('id')){
            $this->_addButton('copy', array(
                'label'        => Mage::helper('plugincompany_contactforms')->__('Duplicate'),
                'onclick'    => "window.location.href = '" . $this->getUrl('*/*/*',array('copyfromid'=>Mage::app()->getRequest()->getParam('id'))) . "'",
                'class'        => 'add',
            ), 0);
        }
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                jQuery('#formEntryGrid_massaction-select').removeClass('required-entry');
                prepareFormSave();
                editForm.submit($('edit_form').action+'back/edit/');
            }
            function submitForm(){
                jQuery('#formEntryGrid_massaction-select').removeClass('required-entry');
                prepareFormSave();
                 editForm.submit();
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
        if( Mage::registry('current_form') && Mage::registry('current_form')->getId() ) {
            return Mage::helper('plugincompany_contactforms')->__("Edit Form '%s'", $this->escapeHtml(Mage::registry('current_form')->getTitle()));
        }
        else {
            return Mage::helper('plugincompany_contactforms')->__('Add Form');
        }
    }

}
