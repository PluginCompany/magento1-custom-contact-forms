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
 * Form resource model
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Model_Resource_Form
    extends Mage_Core_Model_Mysql4_Abstract {
    /**
     * constructor
     * @access public
     * @author Milan Simek
     */
    public function _construct(){
        $this->_init('plugincompany_contactforms/form', 'entity_id');
    }

    /**
     * Get store ids to which specified item is assigned
     * @access public
     * @param int $formId
     * @return array
     * @author Milan Simek
     */
    public function lookupStoreIds($formId){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('plugincompany_contactforms/form_store'), 'store_id')
            ->where('form_id = ?',(int)$formId);
        return $adapter->fetchCol($select);
    }

    /**
     * Perform operations after object load
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return Plugincompany_Contactforms_Model_Resource_Form
     * @author Milan Simek
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object){
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
        }
        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Plugincompany_Contactforms_Model_Form $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object){
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('contactforms_form_store' => $this->getTable('plugincompany_contactforms/form_store')),
                $this->getMainTable() . '.entity_id = contactforms_form_store.form_id',
                array()
            )
            ->where('contactforms_form_store.store_id IN (?)', $storeIds)
            ->order('contactforms_form_store.store_id DESC')
            ->limit(1);
        }
        return $select;
    }
    /**
     * Assign form to store views
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return Plugincompany_Contactforms_Model_Resource_Form
     * @author Milan Simek
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object){
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('plugincompany_contactforms/form_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = array(
                'form_id = ?' => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );
            $this->_getWriteAdapter()->delete($table, $where);
        }
        if ($insert) {
            $data = array();
            foreach ($insert as $storeId) {
                $data[] = array(
                    'form_id'  => (int) $object->getId(),
                    'store_id' => (int) $storeId
                );
            }
            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }
        return parent::_afterSave($object);
    }


    /**
     * check url key
     * @access public
     * @param string $urlKey
     * @param int $storeId
     * @param bool $active
     * @return mixed
     * @author Milan Simek
     */
    public function checkUrlKey($urlKey, $storeId, $active = true){
        $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID, $storeId);
        $select = $this->_initCheckUrlKeySelect($urlKey, $stores);
        if ($active) {
            $select->where('e.status = ?', $active);
        }
        $select->reset(Zend_Db_Select::COLUMNS)
            ->columns('e.entity_id')
            ->limit(1);

        return $this->_getReadAdapter()->fetchOne($select);
    }

    /**
     * Check for unique URL key
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     * @author Milan Simek
     */
    public function getIsUniqueUrlKey(Mage_Core_Model_Abstract $object){
        if (Mage::app()->isSingleStoreMode() || !$object->hasStores()) {
            $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID);
        }
        else {
            $stores = (array)$object->getData('stores');
        }
        $select = $this->_initCheckUrlKeySelect($object->getData('url_key'), $stores);
        if ($object->getId()) {
            $select->where('e.entity_id <> ?', $object->getId());
        }
        if ($this->_getWriteAdapter()->fetchRow($select)) {
            return false;
        }
        return true;
    }
    /**
     * Check if the URL key is numeric
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     * @author Milan Simek
     */
    protected function isNumericUrlKey(Mage_Core_Model_Abstract $object){
        return preg_match('/^[0-9]+$/', $object->getData('url_key'));
    }
    /**
     * Checkif the URL key is valid
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     * @author Milan Simek
     */
    protected function isValidUrlKey(Mage_Core_Model_Abstract $object){
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('url_key'));
    }
    /**
     * format string as url key
     * @access public
     * @param string $str
     * @return string
     * @author Milan Simek
     */
    public function formatUrlKey($str) {
        $urlKey = preg_replace('#[^0-9a-z]+#i', '-', Mage::helper('catalog/product_url')->format($str));
        $urlKey = strtolower($urlKey);
        $urlKey = trim($urlKey, '-');
        return $urlKey;
    }
    /**
     * init the check select
     * @access protected
     * @param string $urlKey
      * @param array $store
     * @return Zend_Db_Select
     * @author Milan Simek
     */
    protected function _initCheckUrlKeySelect($urlKey, $store){
        $select = $this->_getReadAdapter()->select()
            ->from(array('e' => $this->getMainTable()))
            ->join(
                array('es' => $this->getTable('plugincompany_contactforms/form_store')),
                'e.entity_id = es.form_id',
                array())
            ->where('e.url_key = ?', $urlKey)
            ->where('es.store_id IN (?)', $store);
        return $select;
    }

    /**
     * validate before saving
     * @access protected
     * @param $object
     * @return Plugincompany_Contactforms_Model_Resource_Form
     * @author Milan Simek
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object){
        $urlKey = $object->getData('url_key');
        if ($urlKey == '') {
            $urlKey = $object->getTitle();
        }
        $urlKey = $this->formatUrlKey($urlKey);
        $validKey = false;
        while (!$validKey) {
            $entityId = $this->checkUrlKey($urlKey, $object->getStoreId(), false);
            if ($entityId == $object->getId() || empty($entityId)) {
                $validKey = true;
            }
            else {
                $parts = explode('-', $urlKey);
                $last = $parts[count($parts) - 1];
                if (!is_numeric($last)){
                    $urlKey = $urlKey.'-1';
                }
                else {
                    $suffix = '-'.($last + 1);
                    unset($parts[count($parts) - 1]);
                    $urlKey = implode('-', $parts).$suffix;
                }
            }
        }
        $object->setData('url_key', $urlKey);
        return parent::_beforeSave($object);
    }
}
