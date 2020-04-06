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
 * Form edit form tab style
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Form_Edit_Tab_Style
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
        $fieldset = $form->addFieldset('form_style', array('legend'=>Mage::helper('plugincompany_contactforms')->__('Front-end Style')));

        $fieldset->addField('theme', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Font-end theme'),
            'name'  => 'theme',
            'note'  => Mage::helper('plugincompany_contactforms')->__('Choose from 18 Bootstrap themes or use your custom Bootstrap based store theme.'),
            'required'  => true,
            'values'=> array(
                array(
                    'value' => 'notheme',
                    'label' => Mage::helper('plugincompany_contactforms')->__("Use default store theme"),
                ),
                array('value'=>'default','label'=>'Bootstrap default'),
                array('value'=>'amelia','label'=>'Amelia'),
                array('value'=>'cerulean','label'=>'Cerulean'),
                array('value'=>'cosmo','label'=>'Cosmo'),
                array('value'=>'cyborg','label'=>'Cyborg'),
                array('value'=>'darkly','label'=>'Darkly'),
                array('value'=>'flatly','label'=>'Flatly'),
                array('value'=>'journal','label'=>'Journal'),
                array('value'=>'lumen','label'=>'Lumen'),
                array('value'=>'paper','label'=>'Paper'),
                array('value'=>'readable','label'=>'Readable'),
                array('value'=>'sandstone','label'=>'Sandstone'),
                array('value'=>'simplex','label'=>'Simplex'),
                array('value'=>'slate','label'=>'Slate'),
                array('value'=>'spacelab','label'=>'Spacelab'),
                array('value'=>'superhero','label'=>'Superhero'),
                array('value'=>'united','label'=>'United'),
                array('value'=>'yeti','label'=>'Yeti')
            ),
        ));

        $fieldset->addField('form_wrapper', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Form wrapper'),
            'name'  => 'form_wrapper',
            'note'    => Mage::helper('plugincompany_contactforms')->__('Choose from six wrapper styles or no wrapper.'),
            'values' =>
            array(
                array('value' => 'well','label'=>'Well'),
                array('value' => 'panel_default','label'=>'Default Panel'),
                array('value' => 'panel_primary','label'=>'Primary Panel'),
                array('value' => 'panel_success','label'=>'Success Panel'),
                array('value' => 'panel_info','label'=>'Info Panel'),
                array('value' => 'panel_warning','label'=>'Warning Panel'),
                array('value' => null,'label'=>'No wrapper')
            )
        ));


        $fieldset->addField('show_title', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Enable title bar'),
            'name'  => 'show_title',
            'values' =>
                array(
                    array('value' => 1,'label'=>'Yes'),
                    array('value' => 2,'label'=>'No'),
                ),
            'note'    => Mage::helper('plugincompany_contactforms')->__('Show the form title bar (even if no title is entered).')
        ));

        $fieldset->addField('frontend_title', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Form title'),
            'name'  => 'frontend_title',
            'note'    => Mage::helper('plugincompany_contactforms')->__('Text shown in the form title bar.')
        ));

        $fieldset->addField('max_width', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Max width'),
            'name'  => 'max_width',
            'note'    => Mage::helper('plugincompany_contactforms')->__('Maximum form width in pixels.')
        ));

        $fieldset->addField('focus_first_field', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Focus First Field'),
            'name'  => 'focus_first_field',
            'values' =>
                array(
                    array('value' => 1,'label'=>'Yes'),
                    array('value' => 0,'label'=>'No'),
                ),
            'note'    => Mage::helper('plugincompany_contactforms')->__('If set to yes, the browser will focus on the first form field on page load.')
        ));

        $fieldset->addField('rtl', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Enable RTL'),
            'name'  => 'rtl',
            'values' =>
                array(
                    array('value' => 1,'label'=>'Yes'),
                    array('value' => 0,'label'=>'No'),
                ),
            'note'    => Mage::helper('plugincompany_contactforms')->__('Use Right-To-Left text direction.')
        ));

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $fieldset->addField('frontend_success_message', 'editor', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Success message'),
            'name'  => 'frontend_success_message',
            'config' => $wysiwygConfig,
            'note'	=> $this->__('Message shown when the form has been successfully submitted.'),

        ));

        $fieldset->addField('css_classes', 'text', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Custom CSS Class(es)'),
            'name'  => 'css_classes',
            'note'    => Mage::helper('plugincompany_contactforms')->__('Custom form wrapper CSS classes.')
        ));

        $fieldset->addField('custom_css', 'textarea', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Custom CSS'),
            'name'  => 'custom_css',
            'note'    => Mage::helper('plugincompany_contactforms')->__('Custom CSS rules (excluding style HTML tags).'),
            'height' => '200px'
        ));

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
        return parent::_prepareForm();
    }
}
