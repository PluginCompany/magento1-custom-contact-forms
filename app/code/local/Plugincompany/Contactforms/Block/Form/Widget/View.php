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
 * Form widget block
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Form_Widget_View
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface {
    protected $_htmlTemplate = 'plugincompany/contactforms/form/widget/view.phtml';
    /**
     * Prepare form widget
     * @access protected
     * @return Plugincompany_Contactforms_Block_Form_Widget_View
     * @author Milan Simek
     */
    protected function _beforeToHtml() {
        parent::_beforeToHtml();
        $formId = $this->getData('form_id');
        if ($formId) {
            $form = Mage::getModel('plugincompany_contactforms/form')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($formId);
            if ($form->getStatus()) {
                $this->setCurrentForm($form);
                $this->setTemplate($this->_htmlTemplate);
            }
        }
        return $this;
    }

    /*
     * Add variables to HTML result
     */
    protected function _afterToHtml($html)
    {
        return Mage::helper('plugincompany_contactforms/filter')
            ->filterContactForm($html);
    }

    protected function _isSecure(){
        return Mage::app()->getStore()->isCurrentlySecure();
    }

    /**
     * Returns Submit URL
     * @return string
     */
    public function getSubmitUrl()
    {
        $formId = $this->getCurrentForm()->getId();
        $url = $this->getUrl('plugincompany_contactforms/form/submitform', array('id' => $formId,'_secure'=>$this->_isSecure()));
        return $url;
    }

    /**
     * returns visual captcha start URL
     * @return string
     */
    public function getVisualCaptchaUrl()
    {
        $url = $this->getUrl('plugincompany_contactforms/form/',array('_secure'=>$this->_isSecure()));
        return $url;
    }

    /**
     * Returns General File Upload URL
     * @return string
     */
    public function getUploadUrl()
    {
        $url = $this->getUrl('plugincompany_contactforms/form/upload',array('_secure'=>$this->_isSecure()));
        return $url;
    }

    public function isCustomerLoggedIn()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }

}
