<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */

/**
 * Form entry comment collection resource model
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Model_Resource_Entry_Comment_Collection
    extends Mage_Core_Model_Mysql4_Collection_Abstract {
    protected $_joinedFields = array();
    /**
     * constructor
     * @access public
     * @return void
     * @author Milan Simek
     */
    protected function _construct(){
        parent::_construct();
        $this->_init('plugincompany_contactforms/entry_comment');
    }
    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     * @access public
     * @return Varien_Db_Select
     * @author Milan Simek
     */
    public function getSelectCountSql(){
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(Zend_Db_Select::GROUP);
        return $countSelect;
    }
}
