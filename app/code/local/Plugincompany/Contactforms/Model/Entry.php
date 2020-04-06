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
 * Form Entry model
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Model_Entry
    extends Mage_Core_Model_Abstract {
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'plugincompany_contactforms_entry';
    const CACHE_TAG = 'plugincompany_contactforms_entry';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'plugincompany_contactforms_entry';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'entry';
    /**
     * constructor
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function _construct(){
        parent::_construct();
        $this->_init('plugincompany_contactforms/entry');
    }
    /**
     * before save form entry
     * @access protected
     * @return Plugincompany_Contactforms_Model_Entry
     * @author Milan Simek
     */
    protected function _beforeSave(){


        parent::_beforeSave();

        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()){
            $this->_prepareParamsForSave();
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }
    /**
     * save entry relation
     * @access public
     * @return Plugincompany_Contactforms_Model_Entry
     * @author Milan Simek
     */
    protected function _afterSave() {
        return parent::_afterSave();
    }

    protected function _prepareParamsForSave(){
        if(!$this->getParams() || !$this->getForm() || !$this->getAdminNotification() || !$this->getCustomerNotification()){
            return;
        }

        $cNotification = $this->getCustomerNotification();
        $aNotification = $this->getAdminNotification();
        $params = $this->getParams();

        foreach($params as $k => $v)
        {
            $params[$k] = utf8_encode($v);
        }

        if(isset($aNotification['uploaddir'])){
            $uploaddir = str_replace(Mage::getBaseDir(),'',$aNotification['uploaddir']);
            $params['upload_dir'] = $uploaddir;
        }

        $cData = new Varien_Object();
        $cData->setData($cNotification['maildata']);

        $aData = new Varien_Object();
        $aData->setData($aNotification['maildata']);


        $this->setData(
            array(
                'form_id' => $this->getForm()->getId(),
                'store_id'=> Mage::app()->getStore()->getStoreId(),
                'customer_name' => $cData->getToName(),
                'customer_email' => $cData->getToEmail(),
                'customer_bcc'=> $cData->getBcc(),
                'sender_name'=> $cData->getFromName(),
                'sender_email'=> $cData->getFromEmail(),
                'customer_subject'=> $cData->getSubject(),
                'customer_notification'=> $cData->getBody(),
                'admin_email'=> is_array($aData->getToEmail()) ? implode(', ', $aData->getToEmail()) : $aData->getToEmail(),
                'admin_bcc'=> $aData->getBcc(),
                'admin_notification'=> $aData->getBody(),
                'admin_subject'=> $aData->getSubject(),
                'fields'=> serialize($params),
                'increment_id' => $this->getForm()->getEntryIncrementIdCounter(),
                'increment_text' => $this->getForm()->getCurrentIncrementText()
            )
        );
    }

    /**
     * Retrieve parent 
     * @access public
     * @return null|Plugincompany_Contactforms_Model_Form
     * @author Milan Simek
     */
    public function getParentForm(){
        if (!$this->hasData('_parent_form')) {
            if (!$this->getFormId()) {
                return null;
            }
            else {
                $form = Mage::getModel('plugincompany_contactforms/form')->load($this->getFormId());
                if ($form->getId()) {
                    $this->setData('_parent_form', $form);
                }
                else {
                    $this->setData('_parent_form', null);
                }
            }
        }
        return $this->getData('_parent_form');
    }
    /**
     * get default values
     * @access public
     * @return array
     * @author Milan Simek
     */
    public function getDefaultValues() {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    public function getParamsArray()
    {
        $params = unserialize($this->getFields());
        foreach($params as $k => $v)
        {
            $params[$k] = utf8_decode($v);
        }
        return $params;
    }
}
