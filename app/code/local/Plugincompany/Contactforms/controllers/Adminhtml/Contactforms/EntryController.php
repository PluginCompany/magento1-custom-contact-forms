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
 * Form Entry admin controller
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Adminhtml_Contactforms_EntryController
    extends Plugincompany_Contactforms_Controller_Adminhtml_Contactforms {

    private $_entry;

    private function getEntry()
    {
        if(!$this->_entry){
            $this->_initEntry();
        }
        return $this->_entry;
    }

    private function getForm()
    {
        return $this->getEntry()->getParentForm();
    }
    /**
     * init the entry
     * @access protected
     * @return Plugincompany_Contactforms_Model_Entry
     */
    protected function _initEntry(){
        $entryId  = (int) $this->getRequest()->getParam('id');
        $entry    = Mage::getModel('plugincompany_contactforms/entry');
        if ($entryId) {
            $entry->load($entryId);
        }
        Mage::register('current_entry', $entry);
        $this->_entry = $entry;
        return $entry;
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
             ->_title(Mage::helper('plugincompany_contactforms')->__('Form Submissions'));
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
     * edit form entry - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function editAction() {
        $entryId    = $this->getRequest()->getParam('id');
        $entry      = $this->_initEntry();
        if ($entryId && !$entry->getId()) {
            $this->_getSession()->addError(Mage::helper('plugincompany_contactforms')->__('This form submission no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getEntryData(true);
        if (!empty($data)) {
            $entry->setData($data);
        }
        Mage::register('entry_data', $entry);
        $this->loadLayout();
        $this->_title(Mage::helper('plugincompany_contactforms')->__('Contact Forms'))
             ->_title(Mage::helper('plugincompany_contactforms')->__('Form Submissions'));
        if ($entry->getId()){
            $this->_title($entry->getCustomerName());
        }

        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new form entry action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save form entry - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('entry')) {
            try {
                $entry = $this->_initEntry();
                $entry->addData($data);
                $entry->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('plugincompany_contactforms')->__('Form Submission was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $entry->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setEntryData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was a problem saving the form entry.'));
                Mage::getSingleton('adminhtml/session')->setEntryData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Unable to find form entry to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete form entry - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $entry = Mage::getModel('plugincompany_contactforms/entry');
                $entry->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('plugincompany_contactforms')->__('Form Submission was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error deleting form entry.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Could not find form entry to delete.'));

        $this->_redirect('*/*/');
    }
    /**
     * mass delete form entry - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function massDeleteAction() {
        $entryIds = $this->getRequest()->getParam('entry');
        if(!is_array($entryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Please select form entries to delete.'));
        }
        else {
            try {
                foreach ($entryIds as $entryId) {
                    $entry = Mage::getModel('plugincompany_contactforms/entry');
                    $entry->setId($entryId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('plugincompany_contactforms')->__('Total of %d form entries were successfully deleted.', count($entryIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error deleting form entries.'));
                Mage::logException($e);
            }
        }

        if(Mage::app()->getRequest()->getParam('backtoform')){
            $this->_redirect('adminhtml/contactforms_form/edit',array('id'=> $this->getRequest()->getParam('form_id'),'active_tab'=>'form_entries'));
        }else{
            $this->_redirect('*/*/index');
        }

    }
    /**
     * mass status change - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function massStatusAction(){
        $entryIds = $this->getRequest()->getParam('entry');
        if(!is_array($entryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Please select form entries.'));
        }
        else {
            try {
                foreach ($entryIds as $entryId) {
                $entry = Mage::getSingleton('plugincompany_contactforms/entry')->load($entryId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d form entries were successfully updated.', count($entryIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error updating form entries.'));
                Mage::logException($e);
            }
        }
        if(Mage::app()->getRequest()->getParam('backtoform')){
            $this->_redirect('adminhtml/contactforms_form/edit',array('id'=> $this->getRequest()->getParam('form_id'),'active_tab'=>'form_entries'));
        }else{
            $this->_redirect('*/*/index');
        }
    }
    /**
     * mass Store change - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function massStoreIdAction(){
        $entryIds = $this->getRequest()->getParam('entry');
        if(!is_array($entryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Please select form entries.'));
        }
        else {
            try {
                foreach ($entryIds as $entryId) {
                $entry = Mage::getSingleton('plugincompany_contactforms/entry')->load($entryId)
                            ->setStoreId($this->getRequest()->getParam('flag_store_id'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d form entries were successfully updated.', count($entryIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error updating form entries.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass form change - action
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function massFormIdAction(){
        $entryIds = $this->getRequest()->getParam('entry');
        if(!is_array($entryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('Please select form entries.'));
        }
        else {
            try {
                foreach ($entryIds as $entryId) {
                $entry = Mage::getSingleton('plugincompany_contactforms/entry')->load($entryId)
                            ->setFormId($this->getRequest()->getParam('flag_form_id'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d form entries were successfully updated.', count($entryIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('plugincompany_contactforms')->__('There was an error updating form entries.'));
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
        $fileName   = 'form_submissions.csv';
        if($this->getRequest()->getParam('from_tab')){
            $formId = $this->getRequest()->getParam('form_id');
            $content    = $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_entries')->setFormId($formId)->getCsv();
        }else{
            $content    = $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_entry_grid')->getCsv();
        }

        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     * @access public
     * @return void
     * @throws Exception
     * @author Milan Simek
     */
    public function exportExcelAction(){
        $exporter = new PCExportExcel_Exportexcel('browser', 'form_submissions.xls');
        $exporter->initialize();

        $fp = tmpfile();

        if($this->getRequest()->getParam('from_tab')){
            $formId = $this->getRequest()->getParam('form_id');
            $content    = $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_form_edit_tab_entries')->setFormId($formId)->getCsv();
        }else{
            $content    = $this->getLayout()->createBlock('plugincompany_contactforms/adminhtml_entry_grid')->getCsv();
        }

        fwrite($fp, $content);
        rewind($fp); //rewind to process CSV
        while (($row = fgetcsv($fp, 0)) !== FALSE) {
            $exporter->addRow($row);
        }
        $exporter->finalize();
    }

    public function downloadfileAction(){
        $file = base64_decode($this->getRequest()->getParam('file'));
        $filename = explode(DS,$file);
        $filename = array_pop($filename);
        header("Content-disposition: attachment; filename=$filename");
        readfile($file);
    }

    public function entryCommentsGridAction(){
        $this->_initEntry();
        $this->getResponse()->setBody(
            $this
                ->getLayout()
                ->createBlock('plugincompany_contactforms/adminhtml_entry_edit_tab_comments')
                ->toHtml()
        );
    }

    public function newCommentAction(){
        $content = $this->getCommentContent();
        $entry = $this->_initEntry();

        if(!$content){
            Mage::getSingleton('core/session')->addError('Comment text can\'t be empty');
            return;
        }

        try{
            //save comment
            Mage::getModel('plugincompany_contactforms/entry_comment')
                ->setEntryId($entry->getId())
                ->setFormId($entry->getFormId())
                ->setAdminId(Mage::getSingleton('admin/session')->getUser()->getUserId())
                ->setContent($content)
                ->setCreatedAt(Mage::getSingleton('core/date')->gmtDate())
                ->save();

            if($this->shouldNotifyComment()){
                $this->_sendNotification();
            }
        }
        catch(Exception $e){
            Mage::log($e->getMessage(),null,'custom_contact_forms.log',true);
            $this->addErrorMessage();
            $error = 1;
        }
        if(!isset($error)){
            $this->addSuccessMessage();
        }
    }

    private function getCommentContent()
    {
        return $this->getRequest()->getParam('content');
    }

    private function shouldNotifyComment()
    {
        return $this->getRequest()->getParam('notify') == "true";
    }

    protected function _sendNotification()
    {
        Mage::getModel('plugincompany_contactforms/mailer')
            ->sendCommentNotification($this->getEntry(), $this->getCommentContent());
        return $this;
    }

    private function addSuccessMessage()
    {
        $message = $this->__('Comment successfully added');
        if($this->shouldNotifyComment()){
            $message .= $this->__(' and customer notified');
        }
        Mage::getSingleton('core/session')->addSuccess($message);
    }

    private function addErrorMessage()
    {
        $message = $this->__('An error occured. Please check logs for more details.');
        Mage::getSingleton('core/session')->addError($message);
    }

    public function changeStatusAction(){
        $status = $this->getRequest()->getParam('status');
        try{
            $entry = $this->_initEntry();
            $entry->setStatus($status)->save();
        }catch(Exception $e){
            Mage::getSingleton('core/session')->addError($this->__("An error occured changing the form submission status."));
            Mage::log($e->getMessage(),null,'custom_contact_forms.log',true);
            return $this->getResponse()->setBody(
                $this->getLayout()->createBlock('core/messages')->toHtml()
            );
        }
        Mage::getSingleton('core/session')->addSuccess($this->__("Status updated sucessfully"));
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('core/messages')->toHtml()
        );
    }


    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     * @author Milan Simek
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('cms/plugincompany_contactforms/entry');
    }

}
