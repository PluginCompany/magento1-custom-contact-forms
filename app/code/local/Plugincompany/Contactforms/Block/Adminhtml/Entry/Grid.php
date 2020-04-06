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
 * Form Entry admin grid block
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Entry_Grid
    extends Mage_Adminhtml_Block_Widget_Grid {

    protected $_formHash;

    /**
     * constructor
     * @access public
     * @author Milan Simek
     */
    public function __construct(){
        parent::__construct();
        $this->setId('entryGrid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    /**
     * prepare collection
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Entry_Grid
     * @author Milan Simek
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('plugincompany_contactforms/entry')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Entry_Grid
     * @author Milan Simek
     */
    protected function _prepareColumns(){

        $this->addColumn('increment_text', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Reference'),
            'align'     => 'left',
            'index'     => 'increment_text',
            'width'     => '120px'
        ));

        $this->addColumn('form_id', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Contact Form'),
            'index'     => 'form_id',
            'type'      => 'options',
            'options'   => Mage::getResourceModel('plugincompany_contactforms/form_collection')->toOptionHash(),
            'renderer'  => 'plugincompany_contactforms/adminhtml_helper_column_renderer_parent',
            'params' => array(
                'id'=>'getFormId'
            ),
            'base_link' => 'adminhtml/contactforms_form/edit'
        ));

        $this->addColumn('store_id', array(
            'header'=> Mage::helper('plugincompany_contactforms')->__('Store'),
            'index' => 'store_id',
            'type'  => 'options',
            'options' => Mage::getModel('core/store')->getCollection()->toOptionHash()
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Created At'),
            'index'     => 'created_at',
            'width'     => '150px',
            'type'      => 'datetime',
        ));

        $this->addColumn('status', array(
            'header'=> Mage::helper('plugincompany_contactforms')->__('Status'),
            'index' => 'status',
            'type'=> 'options',
            'options' => Mage::getModel('plugincompany_contactforms/entry_source_status')->toOptionArray(false),
            'width' => '80px'
        ));

        $this->addColumn('customer_name', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Customer Name'),
            'align'     => 'left',
            'index'     => 'customer_name',
        ));

        $this->addColumn('customer_email', array(
            'header'=> Mage::helper('plugincompany_contactforms')->__('Customer E-mail'),
            'index' => 'customer_email',
            'type'=> 'text',
        ));

        $this->addColumn('fields', array(
            'header'=> Mage::helper('plugincompany_contactforms')->__('Form Submission'),
            'index' => 'fields',
            'type'=> 'text',
            'renderer' => "Plugincompany_Contactforms_Block_Adminhtml_Renderer_Serialized"
        ));


        $this->addExportType('*/*/exportCsv', Mage::helper('plugincompany_contactforms')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('plugincompany_contactforms')->__('Excel'));
//        $this->addExportType('*/*/exportXml', Mage::helper('plugincompany_contactforms')->__('XML'));
        return parent::_prepareColumns();
    }
    /**
     * prepare mass action
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Entry_Grid
     * @author Milan Simek
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entry');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('plugincompany_contactforms')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('plugincompany_contactforms')->__('Are you sure?')
        ));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('plugincompany_contactforms')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'status' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('plugincompany_contactforms')->__('Status'),
                    'values' => Mage::getModel('plugincompany_contactforms/entry_source_status')->toOptionArray(false)
                )
            )
        ));

        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param Plugincompany_Contactforms_Model_Entry
     * @return string
     * @author Milan Simek
     */
    public function getRowUrl($row){
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    /**
     * get the grid url
     * @access public
     * @return string
     * @author Milan Simek
     */
    public function getGridUrl(){
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
    /**
     * after collection load
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Entry_Grid
     * @author Milan Simek
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * Retrieve Grid data as CSV
     *
     * @return string
     */
    public function getCsv()
    {
        $csv = '';
        $this->_isExport = true;
        $this->_prepareGrid();
        $this->getCollection()->getSelect()->limit();
        $this->getCollection()->setPageSize(0);
        $this->getCollection()->load();
        $this->_afterLoadCollection();

        $data = array();
        foreach ($this->_columns as $column) {
            if (!$column->getIsSystem() && $column->getIndex() != 'fields') {
                $data[] = '"'.$column->getExportHeader().'"';
            }
        }

        //add custom fields as columns
        foreach($this->getAdditionalColumns() as $column){
            $data[] = '"'.$column .'"';
        }

        $csv.= implode(',', $data)."\n";

        foreach ($this->getCollection() as $item) {
            $data = array();
            foreach ($this->_columns as $column) {
                if (!$column->getIsSystem() && $column->getIndex() != 'fields') {
                    $value = $column->getRowFieldExport($item);
                    if($column->getIndex() == 'form_id'){
                        $value = $this->getFormName($item->getFormId());
                    }
                    $data[] = '"' . str_replace(array('"', '\\'), array('""', '\\\\'),
                            $value ) . '"';
                }
            }

            //add custom field data
            $fields = unserialize($item->getData('fields'));
            foreach($this->getAdditionalColumns() as $column){
                $value = isset($fields[$column]) ? utf8_decode($fields[$column]) : '';
                $data[] = '"' . str_replace(array('"', '\\'), array('""', '\\\\'),
                        $value) . '"';
            }

            $csv.= implode(',', $data)."\n";
        }

        if ($this->getCountTotals())
        {
            $data = array();
            foreach ($this->_columns as $column) {
                if (!$column->getIsSystem()) {
                    $data[] = '"' . str_replace(array('"', '\\'), array('""', '\\\\'),
                            $column->getRowFieldExport($this->getTotals())) . '"';
                }
            }
            $csv.= implode(',', $data)."\n";
        }

        return $csv;
    }

    public function getAdditionalColumns(){
        $columns = array();
        $fields = $this->getCollection()->getColumnValues('fields');
        foreach($fields as $field){
            $field = unserialize($field);
            foreach($field as $col => $v){
                if($col == 'upload_dir') continue;
                if($v){
                    $columns[$col] = $col;
                }
            }
        }
        return $columns;
    }

    public function getFormName($id){
        if(!$this->_formHash){
            $this->_formHash = Mage::getResourceModel('plugincompany_contactforms/form_collection')->toOptionHash();
        }
        return $this->_formHash[$id];
    }
}
