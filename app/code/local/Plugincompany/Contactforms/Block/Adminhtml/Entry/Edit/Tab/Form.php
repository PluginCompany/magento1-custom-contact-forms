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
 * Form Entry edit form tab
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Entry_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Entry_Edit_Tab_Form
     * @author Milan Simek
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('entry_');
        $form->setFieldNameSuffix('entry');
        $this->setForm($form);
        $fieldset = $form->addFieldset('entry_form', array('legend'=>Mage::helper('plugincompany_contactforms')->__('Form Submission Details')));

        $values = Mage::getResourceModel('plugincompany_contactforms/form_collection')->toOptionArray();
        array_unshift($values, array('label'=>'', 'value'=>''));

        $html = '<a style="display:block;margin-top:2px;float:left" href="{#url}" id="entry_form_id_link"></a>';
        $html .= '<script type="text/javascript">
            function changeFormIdLink(){
                if ($(\'entry_form_id\').value == \'\') {
                    $(\'entry_form_id_link\').hide();
                }
                else {
                    $(\'entry_form_id_link\').show();
                    var url = \''.$this->getUrl('adminhtml/contactforms_form/edit', array('id'=>'{#id}', 'clear'=>1)).'\';
                    var text = \''.Mage::helper('core')->escapeHtml($this->__('{#name}')).'\';
                    var realUrl = url.replace(\'{#id}\', $(\'entry_form_id\').value);
                    $(\'entry_form_id_link\').href = realUrl;
                    $(\'entry_form_id_link\').innerHTML = text.replace(\'{#name}\', $(\'entry_form_id\').options[$(\'entry_form_id\').selectedIndex].innerHTML);
                }
            }
            $(\'entry_form_id\').observe(\'change\', changeFormIdLink);
            changeFormIdLink();
            </script>';

        $fieldset->addField('form_id', 'select', array(
            'label'     => Mage::helper('plugincompany_contactforms')->__('Contact form'),
            'name'      => 'form_id',
            'values'    => $values,
            'after_element_html' => $html,
            'disabled' => true,
            'style' => 'display:none'
        ));

        $fieldset->addField('store_id', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Store'),
            'name'  => 'store_id',
            'values' => Mage::getModel('core/store')->getCollection()->toOptionHash(),
            'disabled' => true
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Submission Status'),
            'name'  => 'status',
            'values' => Mage::getModel('plugincompany_contactforms/entry_source_status')->toOptionArray(),
            'onchange' => "updateStatus(this)"
        ));

        $fieldset->addField('fields', 'pcserialized', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Form submission'),
            'name'  => 'fields',
        ));

        $fieldset->addField('uploads', 'pcuploads', array(
            'label' => Mage::helper('plugincompany_contactforms')->__('Uploads'),
            'name'  => 'uploads',
        ));

        $formValues = Mage::registry('current_entry')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getEntryData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getEntryData());
            Mage::getSingleton('adminhtml/session')->setEntryData(null);
        }
        elseif (Mage::registry('current_entry')){
            $formValues = array_merge($formValues, Mage::registry('current_entry')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
