<?php
class Plugincompany_Contactforms_Model_Customerhelper 
    extends Mage_Customer_Model_Customer
{
    /**
     * Set/Get attribute wrapper
     *
     * @param   string $method
     * @param   array $args
     * @return  mixed
     */
    
    public function __call($method, $args)
    {
        switch (substr($method, 0, 3)) {
            case 'get' :
                //Varien_Profiler::start('GETTER: '.get_class($this).'::'.$method);
                $key = $this->_underscore(substr($method,3));
                $data = $this->getData($key, isset($args[0]) ? $args[0] : null);
                if(is_numeric($data) && $this->_isAttrSelect($key)){
                    $data = $this->_getSelectAttributeTextVal($key);
                }
                return $data;
            case 'set' :
                //Varien_Profiler::start('SETTER: '.get_class($this).'::'.$method);
                $key = $this->_underscore(substr($method,3));
                $result = $this->setData($key, isset($args[0]) ? $args[0] : null);
                //Varien_Profiler::stop('SETTER: '.get_class($this).'::'.$method);
                return $result;

            case 'uns' :
                //Varien_Profiler::start('UNS: '.get_class($this).'::'.$method);
                $key = $this->_underscore(substr($method,3));
                $result = $this->unsetData($key);
                //Varien_Profiler::stop('UNS: '.get_class($this).'::'.$method);
                return $result;

            case 'has' :
                //Varien_Profiler::start('HAS: '.get_class($this).'::'.$method);
                $key = $this->_underscore(substr($method,3));
                //Varien_Profiler::stop('HAS: '.get_class($this).'::'.$method);
                return isset($this->_data[$key]);
        }
        throw new Varien_Exception("Invalid method ".get_class($this)."::".$method."(".print_r($args,1).")");
    }
    
    
    
    protected function _isAttrSelect($key){
        if($key == 'store_id'){
            return false;
        }
        $input = $this
            ->getResource()
            ->getAttribute($key)
            ->getFrontendInput()
        ;
        return in_array($input,array('select','multiselect'));
    }
    
    protected function _getSelectAttributeTextVal($key)
    {
        return $this
                ->getResource()
                ->getAttribute($key)
                ->getFrontend()
                ->getValue($this);
        ;
    }
    
    public function getInvoiceNumbersAsOptions()
    {
        $idsArray = $this->getAllInvoiceIncrementIds();
        return $this->_getFormatHelper()->formatArrayAsFormHtmlOptions($idsArray);
    }
    
    protected function _getFormatHelper()
    {
        return Mage::helper('plugincompany_contactforms');
    }
    
    public function getAllInvoiceIncrementIds()
    {
        $invoices = $this->getInvoiceCollection();
        return $invoices->getColumnValues('increment_id');
    }
    
    public function getInvoiceCollection()
    {
        $collection = Mage::getResourceModel('sales/order_invoice_collection');
        $collection
            ->getSelect()
            ->joinLeft(
                array('order' => Mage::getModel('core/resource')->getTableName('sales/order')), 
                'order.entity_id=main_table.order_id', 
                array('customer_id' => 'customer_id')
            );
        $collection
            ->addFieldToFilter('customer_id',$this->getId());
        return $collection;
    }
    
    public function getOrderCollection()
    {
        $collection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToFilter('customer_id',$this->getId());
        return $collection;
    }

    public function getOrderNumbersAsOptions()
    {
        $idsArray = $this->getOrderIncrementIdArray();
        return $this->_getFormatHelper()->formatArrayAsFormHtmlOptions($idsArray);
    }
    
    public function getOrderIncrementIdArray()
    {
        return $this->getOrderCollection()->getColumnValues('increment_id');
    }
        
}
