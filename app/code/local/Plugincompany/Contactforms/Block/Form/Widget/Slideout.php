<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */
class Plugincompany_Contactforms_Block_Form_Widget_Slideout
extends Mage_Core_Block_Template
implements Mage_Widget_Block_Interface
{
    protected $_htmlTemplate = 'plugincompany/contactforms/form/widget/slideout.phtml';
    protected function _beforeToHtml() {
        parent::_beforeToHtml();
        $this->setTemplate($this->_htmlTemplate);
        return $this;
    }

    public function getFormHtml()
    {
        if (!$this->getFormId()) {
            return '';
        }
        $form = $this
                  ->getLayout()
                  ->createBlock('plugincompany_contactforms/form_widget_view')
                  ->setSlideOut(true)
                  ->setFormId($this->getFormId())
                  ->toHtml();
//        $form = str_replace('col-md-2', 'col-md-3', $form);
//        $form = str_replace('col-md-6', 'col-md-8', $form);
        $form = str_replace('col-lg-6 visualcaptcha', 'col-lg-8 visualcaptcha', $form);
        return $form;
    }

    public function getAnimation()
    {
        switch($this->getSlideoutPosition()){
            case 'left':
                return 'bounceInLeft';
            case 'right':
                return 'bounceInRight';
            default:
                return 'bounceInUp';
        }
    }

    public function getMargin()
    {
        switch($this->getSlideoutPosition()){
            case 'left':
                return 500;
            case 'right':
                return 500;
            default:
                return "'ownheight'";
        }
    }

}
