<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */

/**
 * Form model
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Model_Form
    extends Mage_Core_Model_Abstract {
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'plugincompany_contactforms_form';
    const CACHE_TAG = 'plugincompany_contactforms_form';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'plugincompany_contactforms_form';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'form';
    /**
     * constructor
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function _construct(){
        parent::_construct();
        $this->_init('plugincompany_contactforms/form');
    }
    /**
     * generate comma separated email address
     * @return string
     * @author Yudha
     */
    public function getConditionalAdminToEmail($params){
        // first get the default e-mail value
        $toMail = $this->getMailVar('admin_to_email');
        // get the conditonal fields array
        $conditFields = $this->getConditionalAdminToEmailArray();
        
        // loop through all conditional e-mails
        $conditionalMatches = array();
        foreach($conditFields as $field){
            // get the field ID
            $fieldName = $field['dept_name'];
            // check if the value of the submitted field with
            // the same field ID,
            // has the same value as the condition value
            if(empty($params[$fieldName]) ) {
                continue;
            }

            //set default 'exact' for backwards compatibility
            if(!isset($field['match_type'])){
                $field['match_type'] = 'exact';
            }

            //exact match
            if($field['match_type'] == 'exact' && $params[$fieldName] == $field['person']){
                // if a match is found, we will use this
                // e-mail instead of the default e-mail
                $conditionalMatches[] = $field['e_mail'];
            //contains match
            }elseif($field['match_type'] == 'contains' && stristr($params[$fieldName],$field['person'])){
                $conditionalMatches[] = $field['e_mail'];
            }
        }
        if(!empty($conditionalMatches)){
            return $conditionalMatches;
        }
        return $toMail;
    }
    /**
     * get Conditional Admin To Email
     * @return array  ['row_(n)'=>['dept_name'=>value,'person'=>value,'e_mail'=>value]]
     * @author Yudha
     */
    public function getConditionalAdminToEmailArray(){
        $data = $this->getData('condit_to_email');
        if (empty($data)){
            return array();
        } 
        if(is_string($data)) {
            $data = unserialize($data);
        }
        return $data;
    }
    /**
     * before save form
     * @access protected
     * @return Plugincompany_Contactforms_Model_Form
     * @author Milan Simek
     */
    protected function _beforeSave(){
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()){
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }
    /**
     * get the url to the form details page
     * @access public
     * @return string
     * @author Milan Simek
     */
    public function getFormUrl(){
        if ($this->getUrlKey()){
            $urlKey = '';
            if ($prefix = Mage::getStoreConfig('plugincompany_contactforms/form/url_prefix')){
                $urlKey .= $prefix.'/';
            }
            $urlKey .= $this->getUrlKey();
            if ($suffix = Mage::getStoreConfig('plugincompany_contactforms/form/url_suffix')){
                $urlKey .= $suffix;
            }
            return Mage::getUrl('', array('_direct'=>$urlKey));
        }
        return Mage::getUrl('plugincompany_contactforms/form/view', array('id'=>$this->getId()));
    }
    /**
     * check URL key
     * @access public
     * @param string $urlKey
     * @param bool $active
     * @return mixed
     * @author Milan Simek
     */
    public function checkUrlKey($urlKey, $active = true){
        return $this->_getResource()->checkUrlKey($urlKey, $active);
    }

    /**
     * get the form Customer notification content
     * @access public
     * @return string
     * @author Milan Simek
     */
    public function getCustomerMailContent(){
        return $this->getData('customer_mail_content');
    }
    /**
     * get the form Notification Content
     * @access public
     * @return string
     * @author Milan Simek
     */
    public function getAdminNotificationContent(){
        return $this->getData('admin_notification_content');
    }
    /**
     * save form relation
     * @access public
     * @return Plugincompany_Contactforms_Model_Form
     * @author Milan Simek
     */
    protected function _afterSave() {
        $this->_updateEntryPrefixes();
        return parent::_afterSave();
    }

    protected function _updateEntryPrefixes(){
        if($this->getOrigData('entry_increment_prefix') != $this->getData('entry_increment_prefix')){

            $trim = strlen($this->getOrigData('entry_increment_prefix'));
            if(!strlen($trim)){
                $trim = strlen($this->getId());
            }

            foreach($this->getSelectedEntriesCollection() as $entry){
                //replace increment prefix
                $incrementText = $this->getEntryIncrementPrefix() . substr($entry->getIncrementText(),$trim);
                $entry
                    ->setIncrementText($incrementText)
                    ->save();
            }
        }
        return $this;
    }

    /**
     * Retrieve  collection
     * @access public
     * @return Plugincompany_Contactforms_Model_Entry_Collection
     * @author Milan Simek
     */
    public function getSelectedEntriesCollection(){
        if (!$this->hasData('_entry_collection')) {
            if (!$this->getId()) {
                return new Varien_Data_Collection();
            }
            else {
                $collection = Mage::getResourceModel('plugincompany_contactforms/entry_collection')
                        ->addFieldToFilter('form_id', $this->getId());
                $this->setData('_entry_collection', $collection);
            }
        }
        return $this->getData('_entry_collection');
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
        $values['enable_entries'] = '1';
        $values['enabled'] = '1';
        $values['frontend_page'] = '1';
        $values['enable_captcha'] = '1';
        $values['notify_customer'] = '2';
        $values['notify_admin'] = '2';
        $values['frontend_page'] = '2';
        $values['enable_captcha'] = '2';
        $values['theme'] = 'default';
        $values['form_wrapper'] = 'well';
        $values['frontend_title'] = 'Contact us';
        $values['max_width'] = '800px';
        $values['customer_mail_content'] = "<p>Dear {name},</p>
<p>Thank you for contacting us.</p>
<p>We have received your message and will get in touch with you shortly.</p>
<p>If you have any other questions in the mean time, feel free to contact us by phone on {store_telephone} or by e-mail at {store_contact_email}.</p>
<p>Best regards,</p>
<p>{store_contact_name}<br />{store_name}</p>
<p>{store_address}</p>
";
        $values['admin_notification_content'] = "<p>New contact request for {store_name}:</p>
<p>{submission_overview}</p>
";
        $values['frontend_success_message'] = '<div class="alert alert-success">
    <h3>Thank you for contacting us!</h3>
    <p>We have received your message and will get in touch with you shortly.</p>
  </div>';
        $values['in_window'] = 2;

        $values['arbitrary_js'] = "//enter javascript here




";
        $values['pageload_js'] = "//enter javascript here




";

        $values['beforesubmit_js'] = "//enter javascript here




";
        $values['focus_first_field'] = 0;
        return $values;
    }

    /**
     * returns e-mail variable value for notification. Will return default value if no value is found.
     * @param $var
     * @return bool|mixed|string
     * @throws Exception
     */
    public function getMailVar($var)
    {
        if(!$this->getId()){
            throw new Exception('No form object loaded');
        }

        switch($var)
        {
            //CUSTOMER NOTIFICATION VARIABLES
            case 'customer_enabled':
                if ($this->getNotifyCustomer() == 1) {
                    return true;
                }elseif($this->getNotifyCustomer() == 2){
                    return Mage::getStoreConfig('plugincompany_contactforms/customer_notification/enable');
                }
                break;

            case 'customer_from_name':
                if ($this->getCustomerFromName()) {
                    return $this->getCustomerFromName();
                }elseif($storeValue = Mage::getStoreConfig('plugincompany_contactforms/customer_notification/from_name')){
                    return $storeValue;

                }else{
                    return Mage::getStoreConfig('trans_email/ident_general/name');
                }
                break;

            case 'customer_from_email':
                if ($this->getCustomerFromEmail()) {
                    return $this->getCustomerFromEmail();
                }elseif($storeValue = Mage::getStoreConfig('plugincompany_contactforms/customer_notification/from_email')){
                    return $storeValue;
                }else{
                    return Mage::getStoreConfig('trans_email/ident_general/email');
                }
                break;

            case 'customer_mail_subject':
                if ($value = $this->getCustomerMailSubject()) {
                    return $value;
                }elseif($storeValue = Mage::getStoreConfig('plugincompany_contactforms/customer_notification/subject')){
                    return $storeValue;
                }else{
                    return 'Thank you for contacting us';
                }
                break;

            case 'customer_mail_bcc':
                if ($val = $this->getCustomerMailBcc()) {
                   return $val;
                }else{
                    return Mage::getStoreConfig('plugincompany_contactforms/customer_notification/bcc');
                }
                break;
            case 'customer_mail_content':
                if ($val = $this->getCustomerMailContent()) {
                    return $val;
                }else{
                    return Mage::getStoreConfig('plugincompany_contactforms/customer_notification/content');
                }
                break;

            //ADMIN NOTIFICATION VARIABLES
            case 'admin_enabled':
                if ($this->getNotifyAdmin() == 1) {
                    return true;
                }elseif($this->getNotifyAdmin() == 2){
                    return Mage::getStoreConfig('plugincompany_contactforms/admin_notification/enable');
                }
                break;

            case 'admin_from_name':
                if ($this->getAdminFromName()) {
                    return $this->getAdminFromName();
                }elseif($storeValue = Mage::getStoreConfig('plugincompany_contactforms/admin_notification/from_name')){
                    return $storeValue;
                }else{
                    return Mage::getStoreConfig('trans_email/ident_general/name');
                }
                break;

            case 'admin_from_email':
                if ($this->getAdminFromEmail()) {
                    return $this->getAdminFromEmail();
                }elseif($storeValue = Mage::getStoreConfig('plugincompany_contactforms/admin_notification/from_email')){
                    return $storeValue;
                }else{
                    return Mage::getStoreConfig('trans_email/ident_general/email');
                }
                break;

            case 'admin_to_email':
                if ($this->getAdminToEmail()) {
                    return $this->getAdminToEmail();
                }elseif($storeValue = Mage::getStoreConfig('plugincompany_contactforms/admin_notification/to_email')){
                    return $storeValue;
                }else{
                    return Mage::getStoreConfig('trans_email/ident_general/email');
                }
                break;

            case 'admin_mail_subject':
                if ($value = $this->getAdminMailSubject()) {
                    return $value;
                }elseif($storeValue = Mage::getStoreConfig('plugincompany_contactforms/admin_notification/subject')){
                    return $storeValue;
                }else{
                    return 'New contact form submission';
                }
                break;

            case 'admin_reply_to_email':
                if ($this->getAdminReplyToEmail()) {
                    return $this->getAdminReplyToEmail();
                }
                return $this->getCustomerToEmail();
                break;

            case 'admin_mail_bcc':
                if ($val = $this->getAdminMailBcc()) {
                   return $val;
                }else{
                    return Mage::getStoreConfig('plugincompany_contactforms/admin_notification/bcc');
                }
                break;
            case 'admin_mail_content':
                if ($val = $this->getAdminNotificationContent()) {
                    return $val;
                }else{
                    return Mage::getStoreConfig('plugincompany_contactforms/admin_notification/content');
                }
                break;
        }
    }

    /**
     * returns the css  class of the form wrapper based on frontend design choice
     * @return string
     */
    public function getWrapClass()
    {
        if ($this->getFormWrapper() == 'well') {
            return 'well';
        }

        if ($this->getFormWrapper() == 'panel_danger') {
            return 'panel panel-danger';
        }
        if ($this->getFormWrapper() == 'panel_success') {
            return 'panel panel-success';
        }
        if ($this->getFormWrapper() == 'panel_info') {
            return 'panel panel-info';
        }
        if ($this->getFormWrapper() == 'panel_warning') {
            return 'panel panel-warning';
        }
        if ($this->getFormWrapper() == 'panel_primary') {
            return 'panel panel-primary';
        }
        if ($this->getFormWrapper() == 'panel_default') {
            return 'panel panel-default';
        }
    }

    /**
     * Returns true if form is using the 'panel' design option
     * @return bool
     */
    public function getIsPanel()
    {
        $isPanel = explode('_', $this->getFormWrapper());
        if ($isPanel[0] == 'panel') {
            return true;
        }

        return false;
    }

    public function getFrontendPage()
    {
        if (parent::getFrontendPage() == 2) {
            return Mage::getStoreConfig('plugincompany_contactforms/form/frontendurl');

        }
        return parent::getFrontendPage();
    }

    public function getTheme()
    {
        if(parent::getTheme() != 'notheme'){
            return parent::getTheme();
        }
        return false;
    }

    public function getUploadFieldParams($fieldIndex)
    {
        //load form json data
        $form = $this;
        $formJSON = $form->getContactFormJson();
        if (!$formJSON) {
            throw new Exception('error: ' . Mage::helper('plugincompany_contactforms')->__('unable to find form data'));
        }

        $formData = json_decode($formJSON);

        //extract upload field from form data
        $i = 0;
        foreach($formData as $v){
            if(!empty($v->type) && $v->type == 'upload'){
                if ($i == $fieldIndex) {
                    $fieldParams = $v->fields;
                    break;
                }
                $i++;
            }
        }

        if (!$fieldParams) {
            throw new Exception('error: ' . Mage::helper('plugincompany_contactforms')->__('unable to find upload params'));
        }

        return $fieldParams;
    }

    public function getCurrentIncrementText(){
        $incrementID = $this->getEntryIncrementIdCounter();
        $prefix = $this->getEntryIncrementPrefix();
        $incrementText = $prefix . sprintf('%08d', $incrementID);
        return $incrementText;
    }

    public function getEntryIncrementPrefix(){
        if($prefix = $this->getData('entry_increment_prefix')){
            return $prefix;
        }
        return $this->getId();
    }
    
    public function hasVisualCaptcha()
    {
        return (bool)stristr($this->getContactFormHtml(), 'visualcaptcha');
    }
    
    public function hasReCaptcha()
    {
        return (bool)stristr($this->getContactFormHtml(),'<captcha');
    }

    /**
     * @param string $fieldId
     * @return string
     */
    public function getFieldLabel($fieldId)
    {
        foreach($this->getFieldData() as $field)
        {
            if(!isset($field['fields']['id']['value'])) {
                continue;
            }
            if(!isset($field['fields']['label']['value'])) {
                continue;
            }
            if($fieldId == $field['fields']['id']['value']) {
                return $field['fields']['label']['value'];
            }
        }
        return ucfirst(str_replace('_', ' ', $fieldId));
    }

    public function getFieldData()
    {
        return json_decode($this->getContactFormJson(), true);
    }


}
