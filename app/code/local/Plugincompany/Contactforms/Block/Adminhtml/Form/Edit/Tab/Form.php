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
 * Form edit form tab
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tab_Form
     * @author Milan Simek
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('form_');
        $form->setFieldNameSuffix('form');
        $this->setForm($form);
        $fieldset = $form->addFieldset('form_form', array('legend'=>Mage::helper('plugincompany_contactforms')->__('Form Settings')));
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Form name'),
            'name'  => 'title',
            'note'	=> $this->__('Name shown in breadcrumbs navigation and page title.'),
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('frontend_page', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Create front-end URL'),
            'name'  => 'frontend_page',
            'note'	=> $this->__('Create a new front-end page for the contact form.'),
            'required'  => true,
            'class' => 'required-entry',

            'values'=> array(
                array(
                    'value' => 2,
                    'label' => Mage::helper('plugincompany_contactforms')->__('Use Store Config'),
                ),
                array(
                    'value' => 1,
                    'label' => Mage::helper('plugincompany_contactforms')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('plugincompany_contactforms')->__('No'),
                ),
            ),
        ));



        $fieldset->addField('url_key', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('URL key'),
            'name'  => 'url_key',
            'note'    => Mage::helper('plugincompany_contactforms')->__('URL key of the contact form page. Example: http://www.domain.com/{prefix}/{urlkey}{suffix}'),
        ));

        $fieldset->addField('enable_entries', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Save form submissions'),
            'name'  => 'enable_entries',
            'note'	=> $this->__('Form submissions are saved in the back-end.'),
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('plugincompany_contactforms')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('plugincompany_contactforms')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('entry_increment_prefix', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Form submission ID prefix'),
            'name'  => 'entry_increment_prefix',
            'note'    => Mage::helper('plugincompany_contactforms')->__('Custom prefix used for form submission reference IDs, for example RMA. Leave empty to use the form ID.'),
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Form status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('plugincompany_contactforms')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('plugincompany_contactforms')->__('Disabled'),
                ),
            ),
        ));

        if (Mage::app()->isSingleStoreMode()){
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_form')->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $formValues = Mage::registry('current_form')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getFormData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getFormData());
            Mage::getSingleton('adminhtml/session')->setFormData(null);
        }
        elseif (Mage::registry('current_form')){
            $formValues = array_merge($formValues, Mage::registry('current_form')->getData());
        }

        $form->setValues($formValues);

        //form url section
        if (Mage::registry('current_form')->getId() && Mage::registry('current_form')->getFrontendPage()) {

           $urlFieldset = $form->addFieldset('form_urls', array('legend'=>Mage::helper('plugincompany_contactforms')->__('Form URLs')));

            $contactForm = Mage::registry('current_form');


            //get form stores
            $stores = Mage::app()->getStores();
            $storeArray = array();
            foreach ($stores as $store) {
                $storeArray[$store->getStoreId()] = $store->getName();
            }

            $storeIds = $contactForm->getResource()->lookupStoreIds($contactForm->getId());

            $arr = array_diff($storeIds, array(0));
            if (!in_array(0,$storeIds) && !empty($arr)) {
                //filter store ids if store ids are selected
                $storeArray = array_intersect_key($storeArray, array_flip($storeIds));
            }

            //add url fields
            foreach ($storeArray as $id => $name) {
                Mage::app()->setCurrentStore($id);
                $urlFieldset->addField('store_link_' . $id, 'link', array(
                    'label' => $name . Mage::helper('plugincompany_contactforms')->__(' store form URL'),
                    'name'  => 'store_link_' . $id,
                    'value' => $contactForm->getFormUrl(),
                    'href' => $contactForm->getFormUrl(),
                    'target' => '_blank'
                ));
            }
            Mage::app()->setCurrentStore(0);

            $urlFieldset->addField('url_information', 'note', array(
                'name'  => 'url_info',
                'text' => 'Configure the default URL prefix and suffix <a style="color:#2f2f2f" href="' . $this->getUrl('adminhtml/system_config/edit',array('section'=>'plugincompany_contactforms')) . '">here</a>.'
            ));

        }



        return parent::_prepareForm();
    }
}
