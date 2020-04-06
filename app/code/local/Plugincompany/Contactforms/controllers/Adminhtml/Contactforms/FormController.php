<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */

/**
 * Form admin controller
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Adminhtml_Contactforms_FormController
    extends Plugincompany_Contactforms_Controller_Adminhtml_Contactforms {
    /**
     * init the form
     * @access protected
     * @return Plugincompany_Contactforms_Model_Form
     */
    protected function _initForm(){
        $formId  = (int) $this->getRequest()->getParam('id');
        $copyFromFormId  = (int) $this->getRequest()->getParam('copyfromid');
        $form    = Mage::getModel('plugincompany_contactforms/form');
        if ($formId) {
            $form->load($formId);
        }
        if ($copyFromFormId) {
            $copyForm = Mage::getModel('plugincompany_contactforms/form')->load($copyFromFormId);
            $form
                ->setData($copyForm->getData())
                ->setEntityId(null)
                ->setId(null)
            ;
        }
        Mage::register('current_form', $form);
        return $form;
    }
     /**
     * default action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('plugincompany_contactforms')->__('Contact Forms'))
             ->_title(Mage::helper('plugincompany_contactforms')->__('Forms'));
        $this->renderLayout();
    }
    /**
     * grid action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function gridAction() {
        $this->loadLayout()->renderLayout();
    }
    /**
     * edit form - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function editAction() {
        $formId    = $this->getRequest()->getParam('id');
        $form      = $this->_initForm();
        if ($formId && !$form->getId()) {
            $this->_getSession()->addError(Mage::helper('plugincompany_contactforms')->__('This form no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $form->setData($data);
        }
        Mage::register('form_data', $form);
        $this->loadLayout();
        $this->_title(Mage::helper('plugincompany_contactforms')->__('Contact Forms'))
             ->_title(Mage::helper('plugincompany_contactforms')->__('Forms'));
        if ($form->getId()){
            $this->_title($form->getTitle());
        }
        else{
            $this->_title(Mage::helper('plugincompany_contactforms')->__('Add form'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new form action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save form - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('form')) {
            try {
                $data = $this->_serializeConditionalToEmail($data);
                $form = $this->_initForm();
                $form->addData($data);
                $form->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('plugincompany_contactforms')->__('Form was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $form->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was a problem saving the form.'));
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Unable to find form to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * serialize data Conditional Admin To Email
     * @param $data      post data
     * @return array     serialized post data
     * @author Yudha PH
     */
    private function _serializeConditionalToEmail($data){
        $newData = array();
        $condit_to_email = !empty($data['condit_to_email']) ? $data['condit_to_email'] : false;
        If ($condit_to_email) {
            $condit_to_delete = !empty($condit_to_email['delete']) ? $condit_to_email['delete'] : false; // deleted flag
            unset($data['condit_to_email']);
            unset($condit_to_email['delete']);
            foreach ($condit_to_email as $key => $val ) {
                $id = str_replace('row_', '', $key);
                if ($condit_to_delete['option_'.$id] != "1"){
                    $newData[$key] = $val;
                }
            }

            $data['condit_to_email'] = serialize($newData); // override
        }
        return (array) $data;
    }
    /**
     * delete form - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $form = Mage::getModel('plugincompany_contactforms/form');
                $form->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('plugincompany_contactforms')->__('Form was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error deleting form.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Could not find form to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete form - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function massDeleteAction() {
        $formIds = $this->getRequest()->getParam('form');
        if(!is_array($formIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Please select forms to delete.'));
        }
        else {
            try {
                foreach ($formIds as $formId) {
                    $form = Mage::getModel('plugincompany_contactforms/form');
                    $form->setId($formId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('plugincompany_contactforms')->__('Total of %d forms were successfully deleted.', count($formIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error deleting forms.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass status change - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function massStatusAction(){
        $formIds = $this->getRequest()->getParam('form');
        if(!is_array($formIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Please select forms.'));
        }
        else {
            try {
                foreach ($formIds as $formId) {
                $form = Mage::getSingleton('plugincompany_contactforms/form')->load($formId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d forms were successfully updated.', count($formIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error updating forms.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Enable Form change - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function massEnabledAction(){
        $formIds = $this->getRequest()->getParam('form');
        if(!is_array($formIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Please select forms.'));
        }
        else {
            try {
                foreach ($formIds as $formId) {
                $form = Mage::getSingleton('plugincompany_contactforms/form')->load($formId)
                            ->setEnabled($this->getRequest()->getParam('flag_enabled'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d forms were successfully updated.', count($formIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error updating forms.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Create Front-end URL change - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function massFrontendPageAction(){
        $formIds = $this->getRequest()->getParam('form');
        if(!is_array($formIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Please select forms.'));
        }
        else {
            try {
                foreach ($formIds as $formId) {
                $form = Mage::getSingleton('plugincompany_contactforms/form')->load($formId)
                            ->setFrontendPage($this->getRequest()->getParam('flag_frontend_page'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d forms were successfully updated.', count($formIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error updating forms.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Enable Captcha change - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function massEnableCaptchaAction(){
        $formIds = $this->getRequest()->getParam('form');
        if(!is_array($formIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Please select forms.'));
        }
        else {
            try {
                foreach ($formIds as $formId) {
                $form = Mage::getSingleton('plugincompany_contactforms/form')->load($formId)
                            ->setEnableCaptcha($this->getRequest()->getParam('flag_enable_captcha'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d forms were successfully updated.', count($formIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error updating forms.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Enable Customer Notification change - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function massNotifyCustomerAction(){
        $formIds = $this->getRequest()->getParam('form');
        if(!is_array($formIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Please select forms.'));
        }
        else {
            try {
                foreach ($formIds as $formId) {
                $form = Mage::getSingleton('plugincompany_contactforms/form')->load($formId)
                            ->setNotifyCustomer($this->getRequest()->getParam('flag_notify_customer'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d forms were successfully updated.', count($formIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error updating forms.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Enable Admin Notification change - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function massNotifyAdminAction(){
        $formIds = $this->getRequest()->getParam('form');
        if(!is_array($formIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Please select forms.'));
        }
        else {
            try {
                foreach ($formIds as $formId) {
                $form = Mage::getSingleton('plugincompany_contactforms/form')->load($formId)
                            ->setNotifyAdmin($this->getRequest()->getParam('flag_notify_admin'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d forms were successfully updated.', count($formIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error updating forms.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * export as csv - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function exportCsvAction(){
        $fileName   = 'form.csv';
        $content    = $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function exportExcelAction(){
        $fileName   = 'form.xls';
        $content    = $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function exportXmlAction(){
        $fileName   = 'form.xml';
        $content    = $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
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

    public function formbuilderAction()
    {
        $this->getResponse()->setBody(
            $this
                ->getLayout()
                ->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_formbuilder')
                ->toHtml()
        );
    }

    public function entriesgridAction(){
        $this->getResponse()->setBody(
            $this
                ->getLayout()
                ->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_entries')
                ->setFormId($this->getRequest()->getParam('id'))
                ->toHtml()
        );
    }

    public function dfieldsAction()
    {
        $this->getResponse()->setBody(
            $this
                ->getLayout()
                ->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_dependentfields')
                ->toHtml()
        );
    }

}
