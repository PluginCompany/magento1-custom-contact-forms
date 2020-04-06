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
 * Form admin grid block
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Block_Adminhtml_Form_Grid
    extends Mage_Adminhtml_Block_Widget_Grid {
    /**
     * constructor
     * @access public
     * @author Milan Simek
     */
    public function __construct(){
        parent::__construct();
        $this->setId('formGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    /**
     * prepare collection
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Grid
     * @author Milan Simek
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('plugincompany_contactforms/form')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Grid
     * @author Milan Simek
     */
    protected function _prepareColumns(){
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('ID'),
            'index'        => 'entity_id',
            'type'        => 'number'
        ));
        $this->addColumn('title', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Form Name'),
            'align'     => 'left',
            'index'     => 'title',
        ));
        $this->addColumn('status', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Status'),
            'index'        => 'status',
            'type'        => 'options',
            'options'    => array(
                '1' => Mage::helper('plugincompany_contactforms')->__('Enabled'),
                '0' => Mage::helper('plugincompany_contactforms')->__('Disabled'),
            )
        ));
        $this->addColumn('frontend_page', array(
            'header'=> Mage::helper('plugincompany_contactforms')->__('Front-end URL'),
            'index' => 'frontend_page',
            'type'    => 'options',
            'options'    => array(
                '1' => Mage::helper('plugincompany_contactforms')->__('Yes'),
                '0' => Mage::helper('plugincompany_contactforms')->__('No'),
                '2' => Mage::helper('plugincompany_contactforms')->__('Use store config'),
            )

        ));
        $this->addColumn('url_key', array(
            'header' => Mage::helper('plugincompany_contactforms')->__('URL Key'),
            'index'  => 'url_key',
        ));
        $this->addColumn('notify_customer', array(
            'header'=> Mage::helper('plugincompany_contactforms')->__('Notify Customer'),
            'index' => 'notify_customer',
            'type'    => 'options',
            'options'    => array(
                '1' => Mage::helper('plugincompany_contactforms')->__('Yes'),
                '0' => Mage::helper('plugincompany_contactforms')->__('No'),
                '2' => Mage::helper('plugincompany_contactforms')->__('Use store config'),
            )

        ));
        $this->addColumn('notify_admin', array(
            'header'=> Mage::helper('plugincompany_contactforms')->__('Notify Admin'),
            'index' => 'notify_admin',
            'type'    => 'options',
            'options'    => array(
                '1' => Mage::helper('plugincompany_contactforms')->__('Yes'),
                '0' => Mage::helper('plugincompany_contactforms')->__('No'),
                '2' => Mage::helper('plugincompany_contactforms')->__('Use store config'),
            ),
            'width' => '110px'

        ));
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn('store_id', array(
                'header'=> Mage::helper('plugincompany_contactforms')->__('Store Views'),
                'index' => 'store_id',
                'type'  => 'store',
                'store_all' => true,
                'store_view'=> true,
                'sortable'  => false,
                'filter_condition_callback'=> array($this, '_filterStoreCondition'),
                'width'     => '160px'
            ));
        }
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Created At'),
            'index'     => 'created_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Updated At'),
            'index'     => 'updated_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('action',
            array(
                'header'=>  Mage::helper('plugincompany_contactforms')->__('Action'),
                'width' => '100',
                'type'  => 'action',
                'getter'=> 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('plugincompany_contactforms')->__('Edit'),
                        'url'   => array('base'=> '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter'=> false,
                'is_system'    => true,
                'sortable'  => false,
            ));
        $this->addExportType('*/*/exportCsv', Mage::helper('plugincompany_contactforms')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('plugincompany_contactforms')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('plugincompany_contactforms')->__('XML'));
        return parent::_prepareColumns();
    }
    /**
     * prepare mass action
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Grid
     * @author Milan Simek
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('form');
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
                    'values' => array(
                        '1' => Mage::helper('plugincompany_contactforms')->__('Enabled'),
                        '0' => Mage::helper('plugincompany_contactforms')->__('Disabled'),
                    )
                )
            )
        ));
        $this->getMassactionBlock()->addItem('enabled', array(
            'label'=> Mage::helper('plugincompany_contactforms')->__('Change Enable Form'),
            'url'  => $this->getUrl('*/*/massEnabled', array('_current'=>true)),
            'additional' => array(
                'flag_enabled' => array(
                    'name' => 'flag_enabled',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('plugincompany_contactforms')->__('Enable Form'),
                    'values' => array(
                        '1' => Mage::helper('plugincompany_contactforms')->__('Yes'),
                        '0' => Mage::helper('plugincompany_contactforms')->__('No'),
                    )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('frontend_page', array(
            'label'=> Mage::helper('plugincompany_contactforms')->__('Change Create Front-end URL'),
            'url'  => $this->getUrl('*/*/massFrontendPage', array('_current'=>true)),
            'additional' => array(
                'flag_frontend_page' => array(
                    'name' => 'flag_frontend_page',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('plugincompany_contactforms')->__('Create Front-end URL'),
                    'values' => array(
                        '1' => Mage::helper('plugincompany_contactforms')->__('Yes'),
                        '0' => Mage::helper('plugincompany_contactforms')->__('No'),
                    )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('enable_captcha', array(
            'label'=> Mage::helper('plugincompany_contactforms')->__('Change Enable Captcha'),
            'url'  => $this->getUrl('*/*/massEnableCaptcha', array('_current'=>true)),
            'additional' => array(
                'flag_enable_captcha' => array(
                    'name' => 'flag_enable_captcha',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('plugincompany_contactforms')->__('Enable Captcha'),
                    'values' => array(
                        '1' => Mage::helper('plugincompany_contactforms')->__('Yes'),
                        '0' => Mage::helper('plugincompany_contactforms')->__('No'),
                    )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('notify_customer', array(
            'label'=> Mage::helper('plugincompany_contactforms')->__('Change Enable Customer Notification'),
            'url'  => $this->getUrl('*/*/massNotifyCustomer', array('_current'=>true)),
            'additional' => array(
                'flag_notify_customer' => array(
                    'name' => 'flag_notify_customer',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('plugincompany_contactforms')->__('Enable Customer Notification'),
                    'values' => array(
                        '1' => Mage::helper('plugincompany_contactforms')->__('Yes'),
                        '0' => Mage::helper('plugincompany_contactforms')->__('No'),
                    )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('notify_admin', array(
            'label'=> Mage::helper('plugincompany_contactforms')->__('Change Enable Admin Notification'),
            'url'  => $this->getUrl('*/*/massNotifyAdmin', array('_current'=>true)),
            'additional' => array(
                'flag_notify_admin' => array(
                    'name' => 'flag_notify_admin',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('plugincompany_contactforms')->__('Enable Admin Notification'),
                    'values' => array(
                        '1' => Mage::helper('plugincompany_contactforms')->__('Yes'),
                        '0' => Mage::helper('plugincompany_contactforms')->__('No'),
                    )

                )
            )
        ));
        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param Plugincompany_Contactforms_Model_Form
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
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Grid
     * @author Milan Simek
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    /**
     * filter store column
     * @access protected
     * @param Plugincompany_Contactforms_Model_Resource_Form_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Plugincompany_Contactforms_Block_Adminhtml_Form_Grid
     * @author Milan Simek
     */
    protected function _filterStoreCondition($collection, $column){
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}

