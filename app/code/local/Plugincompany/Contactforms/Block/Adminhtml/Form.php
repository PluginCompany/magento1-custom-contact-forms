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
 * Form admin block
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Form
    extends Mage_Adminhtml_Block_Widget_Grid_Container {
    /**
     * constructor
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function __construct(){
        $this->_controller         = 'adminhtml_form';
        $this->_blockGroup         = 'plugincompany_contactforms';
        parent::__construct();
        $this->_headerText         = Mage::helper('plugincompany_contactforms')->__('Manage Contact Forms');
        $this->_updateButton('add', 'label', Mage::helper('plugincompany_contactforms')->__('Add Form'));

    }
}
