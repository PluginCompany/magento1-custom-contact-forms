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
 * Form admin widget chooser
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */

class Plugincompany_Contactforms_Block_Adminhtml_Form_Widget_Chooser
    extends Mage_Adminhtml_Block_Widget_Grid {
    /**
     * Block construction, prepare grid params
     * @access public
     * @param array $arguments Object data
     * @return void
     * @author Milan Simek
     */
    public function __construct($arguments=array()){
        parent::__construct($arguments);
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setDefaultFilter(array('chooser_status' => '1'));
    }
    /**
     * Prepare chooser element HTML
     * @access public
     * @param Varien_Data_Form_Element_Abstract $element Form Element
     * @return Varien_Data_Form_Element_Abstract
     * @author Milan Simek
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element){
        $uniqId = Mage::helper('core')->uniqHash($element->getId());
        $sourceUrl = $this->getUrl('adminhtml/contactforms_form_widget/chooser', array('uniq_id' => $uniqId));
        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
                ->setElement($element)
                ->setTranslationHelper($this->getTranslationHelper())
                ->setConfig($this->getConfig())
                ->setFieldsetId($this->getFieldsetId())
                ->setSourceUrl($sourceUrl)
                ->setUniqId($uniqId);
        if ($element->getValue()) {
            $form = Mage::getModel('plugincompany_contactforms/form')->load($element->getValue());
            if ($form->getId()) {
                $chooser->setLabel($form->getTitle());
            }
        }
        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }
    /**
     * Grid Row JS Callback
     * @access public
     * @return string
     * @author Milan Simek
     */
    public function getRowClickCallback(){
        $chooserJsObject = $this->getId();
        $js = '
            function (grid, event) {
                var trElement = Event.findElement(event, "tr");
                var formId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                var formTitle = trElement.down("td").next().innerHTML;
                '.$chooserJsObject.'.setElementValue(formId);
                '.$chooserJsObject.'.setElementLabel(formTitle);
                '.$chooserJsObject.'.close();
            }
        ';
        return $js;
    }
    /**
     * Prepare a static blocks collection
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Widget_Chooser
     * @author Milan Simek
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('plugincompany_contactforms/form')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * Prepare columns for the a grid
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Widget_Chooser
     * @author Milan Simek
     */
    protected function _prepareColumns(){
        $this->addColumn('chooser_id', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Id'),
            'align'     => 'right',
            'index'     => 'entity_id',
            'type'        => 'number',
            'width'     => 50
        ));

        $this->addColumn('chooser_title', array(
            'header'=> Mage::helper('plugincompany_contactforms')->__('Form Title'),
            'align' => 'left',
            'index' => 'title',
        ));
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'=> Mage::helper('plugincompany_contactforms')->__('Store Views'),
                'index' => 'store_id',
                'type'  => 'store',
                'store_all' => true,
                'store_view'=> true,
                'sortable'  => false,
            ));
        }
        $this->addColumn('chooser_status', array(
            'header'=> Mage::helper('plugincompany_contactforms')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'options'   => array(
                0 => Mage::helper('plugincompany_contactforms')->__('Disabled'),
                1 => Mage::helper('plugincompany_contactforms')->__('Enabled')
            ),
        ));
        return parent::_prepareColumns();
    }
    /**
     * get url for grid
     * @access public
     * @return string
     * @author Milan Simek
     */
    public function getGridUrl(){
        return $this->getUrl('adminhtml/contactforms_form_widget/chooser', array('_current' => true));
    }
    /**
     * after collection load
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Widget_Chooser
     * @author Milan Simek
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
