<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */

class Plugincompany_Contactforms_Block_Adminhtml_Table_Grid
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    public function __construct(){
        parent::__construct();
        $this->setTemplate('plugincompany/Tablegrid.phtml');
    }

    /**
     * _prepareToRender     initialize form
     * return               NA
     */
    public function _prepareToRender() {
        $this->addColumn('dept_name', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Field ID'),
            'style' => 'width:150px;',
        ));
        $this->addColumn('person', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Value'),
            'style' => 'width:150px;',
        ));
        $this->addColumn('e_mail', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('E-Mail'),
            'style' => 'width:150px;',
        ));

        $this->addColumn('contains', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Contains'),
            'style' => 'width:150px;',
            'type'  => 'checkbox'
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('plugincompany_contactforms')->__('Add');
    }
}