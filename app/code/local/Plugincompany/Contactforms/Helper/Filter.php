<?php
class Plugincompany_Contactforms_Helper_Filter
    extends Mage_Cms_Model_Template_Filter 
{
    
    protected $_customer;
    
    protected function _getProduct()
    {
        $product = Mage::registry('current_product');
        if($product && $product->getId()){
            return Mage::getModel('plugincompany_contactforms/producthelper')->load($product->getId());
        }
    }
    
    protected function _getCustomer()
    {
        if($this->_customer){
            return $this->_customer;
        }
        
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        if($customer && $customer->getId()){
            $this->_customer = Mage::getModel('plugincompany_contactforms/customerhelper')->load($customer->getId());
        }else{
            $this->_customer = new Varien_Object();
        }
        return $this->_customer;
    }
    
    public function filterContactForm($html)
    {
        $tVars = array();
        $tVars['product'] = $this->_getProduct();
        $tVars['customer'] = $this->_getCustomer();
        $tVars['billing_address'] = $this->_getCustomer()->getDefaultBillingAddress();
        $tVars['shipping_address'] = $this->_getCustomer()->getDefaultShippingAddress();
        $tVars['category'] = Mage::registry('current_category');
        $tVars['store'] = Mage::app()->getStore();

        $this->setVariables($tVars);
        $html = $this->filter($html);
        return Mage::getSingleton('widget/template_filter')->filter($html);
    }
}
