<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */

/**
 * Form front contrller
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_FormController
    extends Mage_Core_Controller_Front_Action {

    protected $_formId;
    protected $_uid;
    protected $_index;
    protected $_vcaptchaSession;

/**
     * init Form
     * @access protected
     * @return Plugincompany_Contactforms_Model_Entity
     * @author Milan Simek
     */
    protected function _initForm(){
        $formId   = $this->getRequest()->getParam('id', 0);
        $form     = Mage::getModel('plugincompany_contactforms/form')
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->load($formId);
        if (!$form->getId()){
            return false;
        }
        elseif (!$form->getStatus()){
            return false;
        }
        return $form;
    }

    protected function _getVcaptchaSession()
    {
        if ($this->_vcaptchaSession) {
            return $this->_vcaptchaSession;
        }
        $namespace = $this->getRequest()->getParam('vcaptcha_namespace');
        $this->_vcaptchaSession = Mage::getSingleton('plugincompany_contactforms/lib_visualcaptcha_session',array('namespace'=>$namespace));
        return $this->_vcaptchaSession;
    }

    protected function _getVCaptcha()
    {
        $captcha = Mage::getModel('plugincompany_contactforms/lib_visualcaptcha_captcha',array('session' => $this->_getVcaptchaSession()));
        return $captcha;
    }

    protected function _subscribeToNewsletter($form,$paramsObj){
        $email = $form->getCustomerToEmail();
        if($email){
            //custom e-mail is set
            if(stristr($email,'{')){
                //has variable
                $email = str_replace(array('{','}'),'',$email);
                $email = $paramsObj->getData($email);
            }
        }else{
            if($paramsObj->getEmail()){
                $email = $paramsObj->getEmail();
            }
        }
        if($email){
            try{
                Mage::getModel('newsletter/subscriber')->subscribe($email);
            }catch(Exception $e){
                Mage::log($e->getMessage(),null,'custom_contact_forms.log',true);
            }
        }
    }

    /**
      * view form action
      * @access public
      * @return void
      * @author Milan Simek
      */
    public function viewAction(){
        $form = $this->_initForm();
        if (!$form) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_form', $form);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('contactforms-form contactforms-form' . $form->getId());
        }
        if (Mage::helper('plugincompany_contactforms/form')->getUseBreadcrumbs()){
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
                $breadcrumbBlock->addCrumb('home', array(
                            'label'    => Mage::helper('plugincompany_contactforms')->__('Home'),
                            'link'     => Mage::getUrl(),
                        )
                );
                $breadcrumbBlock->addCrumb('form', array(
                            'label'    => $form->getTitle(),
                            'link'    => '',
                    )
                );
            }
        }
        $this->getLayout()->getBlock('head')->setTitle($form->getTitle());
        $this->renderLayout();
    }


    /**
     * Submit Form and send notifications
     * @return bool
     */
    public function submitformAction(){
        if ($this->getRequest()->isGet()){
            $this->_redirect("/");
            return;
        }
        try {
            $postId = $this->getRequest()->getParam('id');

            //if no form id is specified throw error
            if (!$postId) {
                $errors = 1;
                throw new Exception('Something went wrong submitting the form. Please try again.');
            }

            //clean params
            $params = Mage::app()->getRequest()->getPost();
            foreach($params as $k => $v){
                if(is_array($v)){
                    $v = implode(', ',$v);
                }
                $params[$k] = htmlspecialchars(strip_tags($v));
            }

            //get uid to retrieve file uploads for admin notification
            $uid = null;
            if (isset($params['form_unique_id'])) {
                $uid = $params['form_unique_id'];
                unset($params['form_unique_id']);
            }

            //unset reCaptcha response
            $reCaptchaRes = false;
            if (isset($params['g-recaptcha-response'])) {
                $reCaptchaRes = $params['g-recaptcha-response'];
                unset($params['g-recaptcha-response']);
            }


            //unset vcaptcha namespace
            if (isset($params['vcaptcha_namespace'])) {
                unset($params['vcaptcha_namespace']);
            }

            //strip identifier from parameters (identifier is used for js form validation)
            if (isset($params['form_increment'])) {
                $strip = strlen($params['form_increment']);
                unset($params['form_increment']);
                $cParams = array();
                foreach ($params as $k => $v) {
                    $cParams[substr($k, 0, -$strip)] = $v;
                }
                $params = $cParams;
            }

            //load form
            $form = Mage::getModel('plugincompany_contactforms/form')->load($postId);

            //check reCaptcha
            if (!$this->captchaOk($form,$reCaptchaRes)) {
                //set responsetext for front-end error handling
                return $this->getResponse()->setBody(
                    'captcha_error'
                );
            };

            //test vcaptcha
            $vCaptcha = $this->visualCaptchaOk($form);
            if (!empty($vCaptcha['msg']) && stristr($vCaptcha['msg'],'error')) {
                return $this->getResponse()->setBody(
                    'visualcaptcha_error'
                );
            }

            //unset vcaptcha image param
            if (
                isset($vCaptcha['imgfield']) 
                && isset($params[substr($vCaptcha['imgfield'],0,-$strip)])
            ) {
                unset($params[substr($vCaptcha['imgfield'],0,-$strip)]);
            }

            //increase form increment
            $form
                ->setEntryIncrementIdCounter($form->getEntryIncrementIdCounter() + 1)
                ->save();
            ;

            //add reference 
            $params['reference'] = $form->getCurrentIncrementText();
            
            //add form_url
            if(isset($_SERVER['HTTP_REFERER'])) {
                $params['form_url'] = htmlspecialchars(strip_tags($_SERVER['HTTP_REFERER']));
            }
            
            //add visitor IP
            if(Mage::getStoreConfigFlag('plugincompany_contactforms/form/visitor_ip')) {
                $params['visitor_ip'] = Mage::helper('core/http')->getRemoteAddr();
            }

            $paramsObj = new Varien_Object();
            $paramsObj->setData($params);

            Mage::dispatchEvent('pc_contactforms_form_submit_before', array('form' => $form, 'params' => $paramsObj));
            if ($paramsObj->getStopProcessing()) {
                throw new Exception('stop processing');
            }

            $params = $paramsObj->getData();

            //subscribe to newsletter
            if($paramsObj->getNewsletter()){
                $this->_subscribeToNewsletter($form,$paramsObj);
            }

            $userConfirmation = $form->getMailVar('customer_enabled');
            $adminConfirmation = $form->getMailVar('admin_enabled');

            if($userConfirmation){
                if ($result = Mage::getModel('plugincompany_contactforms/mailer')->sendCustomerNotification($form, $params)) {
                   //TODO error handling
                }
            }

            if($adminConfirmation){
                if ($result = Mage::getModel('plugincompany_contactforms/mailer')->sendAdminNotification($form, $params, $this->_getUploadDir($uid))) {
                    //TODO error handling
                }
            }


            //save entry in database
            $adminNotification = Mage::getModel('plugincompany_contactforms/mailer')->sendAdminNotification($form, $params, $this->_getUploadDir($uid),true);
            $customerNotification = Mage::getModel('plugincompany_contactforms/mailer')->sendCustomerNotification($form, $params, true);

            if($form->getEnableEntries()){
                Mage::getModel('plugincompany_contactforms/entry')
                    ->setParams($params)
                    ->setForm($form)
                    ->setAdminNotification($adminNotification)
                    ->setCustomerNotification($customerNotification)
                    ->save();
            }

            Mage::dispatchEvent('pc_contactforms_form_submit_after', array('form' => $form, 'params' => $paramsObj));

        } catch (Exception $e){
            Mage::log($e->getMessage(),null,'custom_contact_forms.log',true);
            $error = 1;
        }

        if (isset($error)) {
            //return generic error message
            return $this->getResponse()->setBody(
                '<div style="display:none" class="alert alert-warning" role="alert">' . $this->__('An error occured, please contact us directly by e-mail') . '</div>'
            );
        }else{
            $frontendSuccessMessage = $form->getFrontendSuccessMessage();
            $filter = Mage::getModel('cms/template_filter');
            $frontendSuccessMessage = $filter->filter($frontendSuccessMessage);
            return $this->getResponse()->setBody(
                $frontendSuccessMessage
            );
        }
	 }


    /**
     * checks whether the submitted captcha text is OK by validating with Google reCaptcha
     * @param $form
     * @return bool
     */
    public function captchaOk($form,$response)
    {
        if(!stristr($form->getContactFormHtml(),'<captcha>')){
            return true;
        }

        $privateKey = Mage::getStoreConfig('plugincompany_contactforms/form/recaptcha_private_key');

        try{
            //validate using recaptcha api
            $fields  = 'secret=' . $privateKey;
            $fields .= '&response=' . $response;
            $fields .= '&remoteip=' . Mage::helper('core/http')->getRemoteAddr(true);
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch,CURLOPT_POST, 3);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
            $result = json_decode(curl_exec($ch));
            curl_close($ch);
            return $result->success;

        }catch(Exception $e){
            Mage::log($e->getMessage(),null,'custom_contact_forms.log',true);
            return false;
        }
    }


    public function uploadAction()
    {
        try{
            //extract and validate parameters
            $this->_extractUploadParams();

            //load form
            $form = Mage::getModel('plugincompany_contactforms/form')->load($this->_formId);
            $fieldParams = $form->getUploadFieldParams($this->_index);

            $extensions = null;
            if($fieldParams->extensions->value){
                $extensions = explode(',', $fieldParams->extensions->value);
            }

            $maxSize = $fieldParams->max_filesize->value;
            $maxFiles = $fieldParams->max_files->value;

            //validate and upload file
            $this->_saveUpload($this->_uid, $extensions, $maxSize, $maxFiles);

            return $this->getResponse()->setBody(
                'success'
            );

        }catch(Exception $e){
            Mage::log($_FILES,null,'custom_contact_forms.log',true);
            Mage::log($e->getMessage(),null,'custom_contact_forms.log',true);
            return $this->getResponse()->setBody(
                'error: ' . $e->getMessage()
            );
        }
    }


    protected function _extractUploadParams()
    {
        //get parameters
        $index = (int)$this->getRequest()->getParam('index');
        $uid = preg_replace("/[^A-Za-z0-9 ]/", '', $this->getRequest()->getParam('uid'));
        $formId = (int)$this->getRequest()->getParam('form_id');

        //check if parameters exist
        if (!$formId) {
            throw new Exception(Mage::helper('plugincompany_contactforms')->__('no form ID specified.'));
        }
        if (!$uid) {
            throw new Exception(Mage::helper('plugincompany_contactforms')->__('no UID specified.'));
        }
        if ($index === false || $index === '') {
            throw new Exception(Mage::helper('plugincompany_contactforms')->__('no upload field specified.'));
        }

        $this->_index = $index;
        $this->_uid = $uid;
        $this->_formId = $formId;
    }

    protected function _saveUpload($uid, $extensions, $maxSize, $maxFiles, $postField = 'file')
    {
        if(empty($_FILES[$postField])){
            throw new Exception('An error occured while uploading');
        }
        $fileName = $_FILES[$postField]['name'];
        $fileSize = $_FILES[$postField]['size'] / 1000000;
        

        $path = $this->_getUploadDir($uid);

        $fi = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS);
        $fileCount = iterator_count($fi);

        if ($fileCount >= $maxFiles) {
            throw new Exception("Upload limit is $maxFiles files");
        }

        if ($fileSize > $maxSize) {
            throw new Exception("File exceeds max upload size");
        }

        $uploader = new Varien_File_Uploader('file');
        $uploader->setAllowedExtensions($extensions);
        $uploader->setAllowRenameFiles(false);
        $uploader->setFilesDispersion(false);
        $uploader->save($path . DS, $fileName );
    }

    public function deleteuploadAction(){
        $this->_extractUploadParams();
        $dir = $this->_getUploadDir($this->_uid);
        $fileName = str_replace(array('/','\\'),'',$this->getRequest()->getParam('filename'));
        try{
            unlink($dir . DS . $fileName);
        }catch(Exception $e){
            Mage::log($e->getMessage(),null,'custom_contact_forms.log',true);
            return $this->getResponse()->setBody(
                'error'
            );
        }
        return $this->getResponse()->setBody(
            'success'
        );
    }

    protected function _getUploadDir($uid)
    {
        $sessionID = Mage::getSingleton('customer/session')->getEncryptedSessionId();
        $mainPath = Mage::getBaseDir('media') . DS . 'pccf_uploads';
        if(!is_dir($mainPath)){
            mkdir($mainPath, 0777, true);
        }else{
            try{
                @chmod($mainPath,0777);
            }catch(Exception $e){
                // do nothing
            }
        }
        $path = $mainPath . DS . $sessionID . DS .  $uid;
        if(!is_dir($path)){
            mkdir($path, 0777, true);
        }
        return $path;
    }

    public function startvcaptchaAction()
    {
        $captcha = $this->_getVCaptcha();
        $captcha->generate(5);
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(
            json_encode( $captcha->getFrontendData() )
        );
    }

    public function imagevcaptchaAction()
    {
        $index = $this->getRequest()->getParam('index');
        $retina = $this->getRequest()->getParam('retina');

        $captcha = $this->_getVCaptcha();
        if ( !$captcha->streamImage(
            array(),
            $index,
            $retina
        ) ) {
            return $this->getResponse()->setBody(
                'pass?'
            );
        }
    }

    public function audiovcaptchaAction()
    {
        $captcha = $this->_getVCaptcha();
        if ( ! $captcha->streamAudio( array(), 'mp3') ) {
            return $this->getResponse()->setBody(
                'pass?'
            );
        }
    }

    public function visualCaptchaOk($form)
    {
        if(!stristr($form->getContactFormHtml(),'vcaptcha')){
            return 'success';
        }
        $captcha = $this->_getVCaptcha();
        $frontendData = $captcha->getFrontendData();
        $params = Array();

        $return = 'error';
        $imgField = 'none';
        if ( ! $frontendData ) {
            $return = 'error_nocaptcha';
        } else {
            $imgField =  $frontendData[ 'imageFieldName' ];
            // If an image field name was submitted, try to validate it
            if ( $imageAnswer = $this->getRequest()->getParam( $frontendData[ 'imageFieldName' ] ) ) {
                if ( $captcha->validateImage( $imageAnswer ) ) {
                    $return = 'success';
                } else {
                    $params[] = 'status=failedImage';
                    $return = 'error_image';
                }
            } else if ( $audioAnswer = $this->getRequest()->getParam( $frontendData[ 'audioFieldName' ] ) ) {
                if ( $captcha->validateAudio( $audioAnswer ) ) {
                    $return = 'success';
                } else {
                    $return = 'error_audio';
                }
            }

            $howMany = count( $captcha->getImageOptions() );
            $captcha->generate( $howMany );
        }
        return array('msg'=>$return,'imgfield'=>$imgField);
    }
}
