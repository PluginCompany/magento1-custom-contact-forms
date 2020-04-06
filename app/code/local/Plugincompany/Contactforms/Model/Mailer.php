<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */
class Plugincompany_Contactforms_Model_Mailer extends Varien_Object {

    private $form;

    /**
     * Send Customer Notification e-mail message
     *
     * @param Plugincompany_Contactforms_Model_Form $form
     * @param $params
     * @param bool $returnContent
     * @return $this|bool
     */
    public function sendCustomerNotification(Plugincompany_Contactforms_Model_Form $form, $params, $returnContent = false)
    {
        $this->form = $form;

        //general wrapper for font style
        $bodyPrefix = '';
        $bodySuffix = '';
        if(!stristr($form->getMailVar('customer_mail_content'), 'design/email/header')
            && !stristr($form->getMailVar('customer_mail_content'), '{{include')
        ) {
            $bodyPrefix = '<html><body style="font-family:calibri,arial,helvetica,sans-serif;font-size:11pt">';
            $bodySuffix = '</body></html>';
        }

        //unset reCaptcha fields
        if(isset($params['recaptcha_challenge_field'])){
            unset($params['recaptcha_challenge_field']);
            unset($params['recaptcha_response_field']);
        }

        $mailData = $params;

        //use name or else firstname and lastname as recipient title
        $mailData['to_name'] = $form->getCustomerToName();
        if (isset($params['name'])) {
            $mailData['to_name'] = $params['name'];
        }elseif(isset($params['firstname'])){
            $mailData['to_name'] = $params['firstname'] . ' ' . $params['lastname'];
        }

        $mailData['to_email'] = $form->getCustomerToEmail();
        if(isset($params['email'])){
            $mailData['to_email'] = $params['email'];
        }

        $mailData['from_name'] = $form->getMailVar('customer_from_name');
        $mailData['from_email'] = $form->getMailVar('customer_from_email');
        $mailData['body'] = $bodyPrefix . $form->getMailVar('customer_mail_content') . $bodySuffix;
        $mailData['subject'] = $form->getMailVar('customer_mail_subject');
        $mailData['bcc'] = $form->getMailVar('customer_mail_bcc');

        //insert variables into e-mail data
        $mailData = $this->insertVariables($mailData,$params);
        $mailData['submission_overview'] = $this->generateParamsTable($params);

        if($returnContent){
            return array('maildata' => $mailData);
        }

        //create parameter object
        $paramsObj = new Varien_Object();
        $paramsObj
            ->setData($mailData)
            ->setCanSendMail(true);

        //event hook
        Mage::dispatchEvent('pc_contactforms_customer_notify_before', array('form' => $form, 'mail_data' => $paramsObj));

        //send e-mail
        if($paramsObj->getCanSendMail()){
            $mailData = $paramsObj->getData();
            $this->sendMail($mailData);

            Mage::dispatchEvent('pc_contactforms_customer_notify_after', array('form' => $form, 'mail_data' => $paramsObj));
        }

        return $this;

    }

    /**
     * Send admin notification e-mail message
     *
     * @param $form
     * @param $params
     * @param null $uploadDir
     * @param bool $returnContent
     * @return $this
     */
    public function sendAdminNotification($form, $params, $uploadDir = null, $returnContent = false)
    {
        $this->form = $form;

        //general wrapper for font style
        $bodyPrefix = '';
        $bodySuffix = '';
        if(!stristr($form->getMailVar('customer_mail_content'), 'design/email/header')
            && !stristr($form->getMailVar('customer_mail_content'), '{{include')
        ) {
            $bodyPrefix = '<html><body style="font-family:calibri,arial,helvetica,sans-serif;font-size:11pt">';
            $bodySuffix = '</body></html>';
        }

        //unset reCaptcha fields
        if(isset($params['recaptcha_challenge_field'])){
            unset($params['recaptcha_challenge_field']);
            unset($params['recaptcha_response_field']);
        }

        $mailData = $params;

        $mailData['to_email'] = $form->getConditionalAdminToEmail($params);
        $mailData['from_name'] = $form->getMailVar('admin_from_name');
        $mailData['from_email'] = $form->getMailVar('admin_from_email');
        $mailData['body'] = $bodyPrefix . $form->getMailVar('admin_mail_content') . $bodySuffix;
        $mailData['subject'] = $form->getMailVar('admin_mail_subject');
        $mailData['bcc'] = $form->getMailVar('admin_mail_bcc');
        $mailData['admin_reply_to_email'] = $form->getMailVar('admin_reply_to_email');


        //insert variables into e-mail data
        $mailData = $this->insertVariables($mailData,$params);
        $mailData['submission_overview'] = $this->generateParamsTable($params);

        if($returnContent){
            return array('maildata' => $mailData, 'uploaddir' => $uploadDir);
        }

        //create parameter object
        $paramsObj = new Varien_Object();
        $paramsObj
            ->setData($mailData)
            ->setCanSendMail(true)
            ->setUploadDir($uploadDir)
        ;

        //event hook
        Mage::dispatchEvent('pc_contactforms_admin_notify_before', array('form' => $form, 'mail_data' => $paramsObj));

        //send e-mail
        if($paramsObj->getCanSendMail()){
            $mailData = $paramsObj->getData();
            $this->sendMail($mailData,$paramsObj->getUploadDir());

            Mage::dispatchEvent('pc_contactforms_admin_notify_after', array('form' => $form, 'mail_data' => $paramsObj));

        }

        return $this;
    }

    /**
     * Send Customer Comment e-mail message
     *
     * @param Plugincompany_Contactforms_Model_Entry $entry
     * @param $comment
     * @return $this|bool
     */
    public function sendCommentNotification(Plugincompany_Contactforms_Model_Entry $entry, $comment)
    {
         $form = $entry->getParentForm();
         $this->form = $form;
         $params = $entry->getParamsArray();

         $params['comment_text'] = nl2br($comment);
         $params['customer_name'] = $entry->getCustomerName();

        //general wrapper for font style
        $bodyPrefix = '';
        $bodySuffix = '';
        if(!stristr($form->getMailVar('customer_mail_content'), 'design/email/header')
            && !stristr($form->getMailVar('customer_mail_content'), '{{include')
        ) {
            $bodyPrefix = '<html><body style="font-family:calibri,arial,helvetica,sans-serif;font-size:11pt">';
            $bodySuffix = '</body></html>';
        }

        $mailData = $params;

        //use name or else firstname and lastname as recipient title
        $mailData['to_name'] = $entry->getCustomerName();
        $mailData['to_email'] = $entry->getCustomerEmail();
        $mailData['from_name'] = $form->getMailVar('customer_from_name');
        $mailData['from_email'] = $form->getMailVar('customer_from_email');
        $mailData['body'] = $bodyPrefix . $this->_getCommentTemplate($entry->getStoreId()) . $bodySuffix;
        $mailData['subject'] = $this->_getCommentNotificationSubject($entry->getStoreId());
        $mailData['bcc'] = $form->getMailVar('customer_mail_bcc');

        //insert variables into e-mail data
        $mailData = $this->insertVariables($mailData,$params);
        $mailData['submission_overview'] = $this->generateParamsTable($params);

        //create parameter object
        $paramsObj = new Varien_Object();
        $paramsObj
            ->setData($mailData)
            ->setCanSendMail(true);

        //event hook
        Mage::dispatchEvent('pc_contactforms_comment_notify_before', array('entry' => $entry, 'comment' => $comment));

        //send e-mail
        if($paramsObj->getCanSendMail()){
            $mailData = $paramsObj->getData();
            $this->sendMail($mailData);

            Mage::dispatchEvent('pc_contactforms_comment_notify_after', array('entry' => $entry, 'comment' => $comment));
        }

        return $this;

    }

    /**
     * replaces {variables} with corresponding value
     *
     * @param $mailData
     * @param $params
     * @return mixed
     */
    public function insertVariables($mailData,$params)
    {
        //unset reCaptcha fields
        if(isset($params['recaptcha_challenge_field'])){
            unset($params['recaptcha_challenge_field']);
            unset($params['recaptcha_response_field']);
        }

        //generate array for variable replacement in mail text
        $replace = $this->generateFindReplaceArray($params);

        //find and replace variables
        foreach ($mailData as $k => $v) {
            $mailData[$k] = str_replace($replace['find'],$replace['replace'],$v);
        }
        return $mailData;
    }

    /**
     * generates table with all submitted values
     *
     * @param $params
     * @return string
     */
    public function generateParamsTable($params)
    {
        unset($params['submitform']);
        $table = '<table cellpadding="3" border="0">';
        foreach ($params as $k => $v) {
            $v = nl2br($v);
            $table .= "<tr><td><b>{$this->getFormFieldLabel($k)}</b></td><td>$v</td></tr>";
        }
        $table .= '</table>';

        return $table;
    }

    private function getFormFieldLabel($fieldId)
    {
        return $this->form->getFieldLabel($fieldId);
    }

    /**
     * generates an Array to perform variable replacement
     *
     * @param $params
     * @return array
     */
    public function generateFindReplaceArray($params)
    {
        //default variables
        $findReplace = array
        (
            'find' => array(
                '{submission_overview}',
                '{store_name}',
                '{store_telephone}',
                '{store_address}',
                '{store_country}',
                '{store_vat}',
                '{store_contact_name}',
                '{store_contact_email}',
                '{store_sales_name}',
                '{store_sales_email}',
                '{store_support_name}',
                '{store_support_email}'
            ),
            'replace' => array(
                $this->generateParamsTable($params),
                Mage::getStoreConfig('general/store_information/name'),
                Mage::getStoreConfig('general/store_information/phone'),
                nl2br(Mage::getStoreConfig('general/store_information/address')),
                Mage::getStoreConfig('general/store_information/merchant_country'),
                Mage::getStoreConfig('general/store_information/merchant_vat_number'),
                Mage::getStoreConfig('trans_email/ident_general/name'),
                Mage::getStoreConfig('trans_email/ident_general/email'),
                Mage::getStoreConfig('trans_email/ident_sales/name'),
                Mage::getStoreConfig('trans_email/ident_sales/email'),
                Mage::getStoreConfig('trans_email/ident_support/name'),
                Mage::getStoreConfig('trans_email/ident_support/email'),
            )
        );

        //add custom params
        foreach ($params as $k => $v) {
            $findReplace['find'][] = '{' . $k . '}';
            $findReplace['replace'][] = (string)$v;
        }
        return $findReplace;
    }

    /**
     * send e-mail message
     *
     * @param $data
     * @param null $uploadDir
     * @return $this
     */
    public function sendMail($data, $uploadDir = null)
    {
        $this->setData($data);

        if (Mage::getStoreConfigFlag('system/smtp/disable')) {
            return $this;
        }

        $mail = Mage::getModel('core/email_template');

        $mail
            ->setTemplateText($this->getBody())
            ->setTemplateSubject($this->getSubject())
            ->setSenderName($this->getFromName())
            ->setSenderEmail($this->getFromEmail())
            ->setReplyTo($this->getAdminReplyToEmail())
        ;

        if (!empty($data['bcc'])) {
            $bcc = explode(',', $data['bcc']);
            $mail->addBcc($bcc);
        }

        //add attachments for admin mail
        if ($uploadDir) {
            foreach(scandir($uploadDir) as $file){
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $mail
                    ->getMail()
                    ->createAttachment(
                        file_get_contents($uploadDir . DS . $file),
                        finfo_file(finfo_open(FILEINFO_MIME_TYPE), $uploadDir . DS .$file),
                        Zend_Mime::DISPOSITION_ATTACHMENT,
                        Zend_Mime::ENCODING_BASE64,
                        $file
                    );
            }
        }

        $mail->send($this->getToEmail(),$this->getToName(), $data);
    }

    protected function _getCommentTemplate($storeId)
    {
        return Mage::getStoreConfig('plugincompany_contactforms/customer_notification/comment_template',$storeId);
    }

    protected function _getCommentNotificationSubject($storeId)
    {
        return Mage::getStoreConfig('plugincompany_contactforms/customer_notification/comment_subject',$storeId);
    }

}