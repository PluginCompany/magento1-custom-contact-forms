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
 * Form edit form
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */


class Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare form
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Form
     * @author Milan Simek
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
                        'id'         => 'edit_form',
                        'action'     => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                        'method'     => 'post',
                        'enctype'    => 'multipart/form-data'
                    )
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

    protected function _toHtml(){
        return parent::_toHtml();
    }
}
