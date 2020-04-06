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
 * Form admin widget controller
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Adminhtml_Contactforms_Form_WidgetController
    extends Mage_Adminhtml_Controller_Action {
    /**
     * Chooser Source action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function chooserAction(){
        $uniqId = $this->getRequest()->getParam('uniq_id');
        $grid = $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_widget_chooser', '', array(
            'id' => $uniqId,
        ));
        $this->getResponse()->setBody($grid->toHtml());
    }

    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     * @author Milan Simek
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('cms/plugincompany_contactforms');
    }
}
