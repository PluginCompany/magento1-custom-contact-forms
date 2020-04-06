<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */
class Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tab_Dependentfields extends Mage_Core_Block_Template
{

    public function __construct(){
        $this->setTemplate('plugincompany/Dependentfields.phtml');
    }

    private function getFormId()
    {
        return Mage::app()->getRequest()->getParam('id');
    }

    /**
     * Get dependent fields in JSON format
     *
     * @return string
     */
    public function getDfieldsJSON()
    {
        if (!$id = $this->getFormId()) {
            //default content for new form
            $json = '[]';
        }else{
            //form contents of existing form
            $json = Mage::getModel('plugincompany_contactforms/form')->load($id)->getDependentFields();
            if(!$json){
                $json = '[]';
            }
        }
        return $json;
    }

    /**
     * Get form contents in JSON format for Bootstrap Form Builder
     *
     * @return string
     */
    public function getFormContentsJSON()
    {
        if (!$id = $this->getFormId()) {
            //default content for new form
            $json = '[{"title":"form name"},{"title":"Paragraph text","fields":{"content":{"label":"Content","type":"textarea","value":"Leave a message below and we\'ll get in touch with you as soon as possible!","name":"content"}}},{"title":"Text Input","fields":{"id":{"label":"ID / Name","type":"input","value":"name","name":"id"},"label":{"label":"Label Text","type":"input","value":"Name","name":"label"},"placeholder":{"label":"Placeholder","type":"input","value":"Please enter your name","name":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"","name":"helptext"},"required":{"label":"Required","type":"checkbox","value":true,"name":"required"},"validation":{"label":"Validation","type":"select","value":[{"value":"","selected":true,"label":"None"},{"value":"email","selected":false,"label":"email"},{"value":"street","selected":false,"label":"Street (Letters, numbers, spaces or #)"},{"value":"phoneLax","selected":false,"label":"Phone"},{"value":"fax","selected":false,"label":"Fax"},{"value":"url","selected":false,"label":"URL (including http://)"},{"value":"clean-url","selected":false,"label":"Domain URL"},{"value":"number","selected":false,"label":"Number (number and dot)"},{"value":"digits","selected":false,"label":"Digits (only numbers)"},{"value":"alpha","selected":false,"label":"Letters only (a-z or A-Z)"},{"value":"alphanum","selected":false,"label":"Alphanumeric (Letters or numbers only)"},{"value":"date-au","selected":false,"label":"Date (dd/mm/yyyy)"}],"name":"validation"},"inputheight":{"label":"Input Height","type":"select","value":[{"value":"input-sm","selected":false,"label":"Small"},{"value":"","selected":true,"label":"Default"},{"value":"input-lg","selected":false,"label":"Large"}],"name":"inputheight"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"col-md-2","selected":false,"label":"Mini"},{"value":"col-md-3","selected":false,"label":"Small"},{"value":"col-md-4","selected":false,"label":"Medium"},{"value":"col-md-5","selected":false,"label":"Large"},{"value":"col-md-6","selected":true,"label":"Xlarge"},{"value":"col-md-8","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Text Input","fields":{"id":{"label":"ID / Name","type":"input","value":"email","name":"id"},"label":{"label":"Label Text","type":"input","value":"E-mail","name":"label"},"placeholder":{"label":"Placeholder","type":"input","value":"Please enter your e-mail address","name":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"","name":"helptext"},"required":{"label":"Required","type":"checkbox","value":true,"name":"required"},"validation":{"label":"Validation","type":"select","value":[{"value":"","selected":false,"label":"None"},{"value":"email","selected":true,"label":"email"},{"value":"street","selected":false,"label":"Street (Letters, numbers, spaces or #)"},{"value":"phoneLax","selected":false,"label":"Phone"},{"value":"fax","selected":false,"label":"Fax"},{"value":"url","selected":false,"label":"URL (including http://)"},{"value":"clean-url","selected":false,"label":"Domain URL"},{"value":"number","selected":false,"label":"Number (number and dot)"},{"value":"digits","selected":false,"label":"Digits (only numbers)"},{"value":"alpha","selected":false,"label":"Letters only (a-z or A-Z)"},{"value":"alphanum","selected":false,"label":"Alphanumeric (Letters or numbers only)"},{"value":"date-au","selected":false,"label":"Date (dd/mm/yyyy)"}],"name":"validation"},"inputheight":{"label":"Input Height","type":"select","value":[{"value":"input-sm","selected":false,"label":"Small"},{"value":"","selected":true,"label":"Default"},{"value":"input-lg","selected":false,"label":"Large"}],"name":"inputheight"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"col-md-2","selected":false,"label":"Mini"},{"value":"col-md-3","selected":false,"label":"Small"},{"value":"col-md-4","selected":false,"label":"Medium"},{"value":"col-md-5","selected":false,"label":"Large"},{"value":"col-md-6","selected":true,"label":"Xlarge"},{"value":"col-md-8","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Multiple Radios Inline","fields":{"name":{"label":"Group Name","type":"input","value":"priority","name":"name"},"label":{"label":"Label Text","type":"input","value":"Question priority","name":"label"},"radios":{"label":"Radios","type":"textarea-split","value":["Low","Medium","High"],"name":"radios"}}},{"title":"Multiple Checkboxes Inline","fields":{"name":{"label":"Group Name","type":"input","value":"answer","name":"name"},"label":{"label":"Label Text","type":"input","value":"Answer me by","name":"label"},"required":{"label":"Required","type":"checkbox","value":false,"name":"required"},"checkboxes":{"label":"Checkboxes","type":"textarea-split","value":["Mail","Phone"],"name":"checkboxes"}}},{"title":"Select Basic","fields":{"id":{"label":"ID / Name","type":"input","value":"department","name":"id"},"label":{"label":"Label Text","type":"input","value":"Question for","name":"label"},"options":{"label":"Options","type":"textarea-split","value":["Sales","Customer Service"],"name":"options"},"inputheight":{"label":"Input Height","type":"select","value":[{"value":"input-sm","selected":false,"label":"Small"},{"value":"","selected":true,"label":"Default"},{"value":"input-lg","selected":false,"label":"Large"}],"name":"inputheight"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"col-md-2","selected":false,"label":"Mini"},{"value":"col-md-3","selected":false,"label":"Small"},{"value":"col-md-4","selected":false,"label":"Medium"},{"value":"col-md-5","selected":false,"label":"Large"},{"value":"col-md-6","selected":true,"label":"Xlarge"},{"value":"col-md-8","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Text Area","fields":{"id":{"label":"ID / Name","type":"input","value":"message","name":"id"},"label":{"label":"Label Text","type":"input","value":"Message","name":"label"},"textarea":{"label":"Starting Text","type":"textarea","value":"","name":"textarea"},"required":{"label":"Required","type":"checkbox","value":true,"name":"required"},"validation":{"label":"Validation","type":"select","value":[{"value":"","selected":true,"label":"None"},{"value":"email","selected":false,"label":"email"},{"value":"street","selected":false,"label":"Street (Letters, numbers, spaces or #)"},{"value":"phoneLax","selected":false,"label":"Phone"},{"value":"fax","selected":false,"label":"Fax"},{"value":"url","selected":false,"label":"URL (including http://)"},{"value":"clean-url","selected":false,"label":"Domain URL"},{"value":"number","selected":false,"label":"Number (number and dot)"},{"value":"digits","selected":false,"label":"Digits (only numbers)"},{"value":"alpha","selected":false,"label":"Letters only (a-z or A-Z)"},{"value":"alphanum","selected":false,"label":"Alphanumeric (Letters or numbers only)"},{"value":"date-au","selected":false,"label":"Date (dd/mm/yyyy)"}],"name":"validation"},"inputheight":{"label":"Input Height","type":"select","value":[{"value":"input-sm","selected":false,"label":"Small"},{"value":"","selected":true,"label":"Default"},{"value":"input-lg","selected":false,"label":"Large"}],"name":"inputheight"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"col-md-2","selected":false,"label":"Mini"},{"value":"col-md-3","selected":false,"label":"Small"},{"value":"col-md-4","selected":false,"label":"Medium"},{"value":"col-md-5","selected":false,"label":"Large"},{"value":"col-md-6","selected":true,"label":"Xlarge"},{"value":"col-md-8","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Single Button","fields":{"id":{"label":"ID / Name","type":"input","value":"submitform","name":"id"},"label":{"label":"Label Text","type":"input","value":"Submit Form","name":"label"},"buttonlabel":{"label":"Button Label","type":"input","value":"Submit","name":"buttonlabel"},"buttontype":{"label":"Button Type","type":"select","value":[{"value":"btn-default","label":"Default","selected":false},{"value":"btn-primary","label":"Primary","selected":true},{"value":"btn-info","label":"Info","selected":false},{"value":"btn-success","label":"Success","selected":false},{"value":"btn-warning","label":"Warning","selected":false},{"value":"btn-danger","label":"Danger","selected":false}],"name":"buttontype"}}}]' ;
        }else{
            //form contents of existing form
            $json = Mage::getModel('plugincompany_contactforms/form')->load($id)->getContactFormJson();
        }
        return $json;
    }

}