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
 * Form view block
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */

class Plugincompany_Contactforms_Block_Form_View
    extends Mage_Core_Block_Template {
    /**
     * get the current form
     * @access public
     * @return mixed (Plugincompany_Contactforms_Model_Form|null)
     * @author Milan Simek
     */

    public function getCurrentForm(){
        return Mage::registry('current_form');
    }

    protected function _isSecure(){
        return Mage::app()->getStore()->isCurrentlySecure();
    }
    
    /*
     * Add variables to HTML result
     */
    protected function _afterToHtml($html)
    {
        return Mage::helper('plugincompany_contactforms/filter')
            ->filterContactForm($html);
    }

    /**
     * returns form submit URL
     * @return string
     */
    public function getSubmitUrl()
    {
        $formId = $this->getCurrentForm()->getId();
        $url = $this->getUrl('*/*/submitform', array('id' => $formId,'_secure' => $this->_isSecure()));
        return $url;
    }

    /**
     * returns visual captcha start URL
     * @return string
     */
    public function getVisualCaptchaUrl()
    {
        $url = $this->getUrl('plugincompany_contactforms/form/',array('_secure' => $this->_isSecure()));
        return $url;
    }

    /**
     * Returns General File Upload URL
     * @return string
     */
    public function getUploadUrl()
    {
        $url = $this->getUrl('plugincompany_contactforms/form/upload',array('_secure' => $this->_isSecure()));
        return $url;
    }

    public function isCustomerLoggedIn()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }
}
