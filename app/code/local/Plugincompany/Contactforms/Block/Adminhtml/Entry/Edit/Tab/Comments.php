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
class Plugincompany_Contactforms_Block_Adminhtml_Entry_Edit_Tab_Comments
    extends Mage_Adminhtml_Block_Widget_Grid {

    protected $_formHash;
    protected $_entry;

    /**
     * constructor
     * @access public
     * @author Milan Simek
     */
    public function __construct(){
        parent::__construct();
        $this->setId('entryCommentGrid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);

    }

    public function getEntry(){
        if(!$this->_entry){
            $this->_entry = Mage::registry('current_entry');
        }
        return $this->_entry;
    }

    public function getEntryId()
    {
        return $this->getEntry()->getId();
    }
    /**
     * prepare collection
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Entry_Edit_Tab_Comments
     * @author Milan Simek
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('plugincompany_contactforms/entry_comment')->getCollection();
        $collection
            ->addFieldToFilter('entry_id',$this->getEntryId())
            ;
        $collection
            ->getSelect()
            ->joinLeft(
                array('admin'=>$collection->getTable('admin/user')),
                'admin.user_id=main_table.admin_id',
                array('firstname','lastname'));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return Plugincompany_Contactforms_Block_Adminhtml_Entry_Edit_Tab_Comments
     * @author Milan Simek
     */
    protected function _prepareColumns(){

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Commented At'),
            'index'     => 'created_at',
            'width'     => '160px',
            'type'      => 'datetime',
        ));

        $this->addColumn('firstname', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Firstname'),
            'align'     => 'left',
            'index'     => 'firstname',
            'width'     => '100px'

        ));

        $this->addColumn('lastname', array(
            'header'    => Mage::helper('plugincompany_contactforms')->__('Lastname'),
            'align'     => 'left',
            'index'     => 'lastname',
            'width'     => '100px'
        ));

        $this->addColumn('content', array(
            'header'=> Mage::helper('plugincompany_contactforms')->__('Comment'),
            'index' => 'content',
            'type'=> 'text',
            'truncate' => 100000,
            'nl2br' => true
        ));

        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     * @access protected
     * @author Milan Simek
     */
    protected function _prepareMassaction(){
        return $this;
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entry');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('plugincompany_contactforms')->__('Delete'),
            'url'  => $this->getUrl('*/contactforms_entry/massDelete', array('backtoform' => true, 'form_id' => $this->getFormId())),
            'confirm'  => Mage::helper('plugincompany_contactforms')->__('Are you sure?')
        ));

        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param Plugincompany_Contactforms_Model_Entry_Comment
     * @return string
     * @author Milan Simek
     */
    public function getRowUrl($row){
        return false;
        return $this->getUrl('adminhtml/contactforms_entry/edit', array('id' => $row->getId(),'backtoform'=>true));
    }

    /**
     * get the grid url
     * @access public
     * @return string
     * @author Milan Simek
     */
    public function getGridUrl(){
        return $this->getUrl('*/*/entryCommentsGrid', array('_current'=>true));
    }
    /**
     * after collection load
     * @access protected
     * @author Milan Simek
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

}
