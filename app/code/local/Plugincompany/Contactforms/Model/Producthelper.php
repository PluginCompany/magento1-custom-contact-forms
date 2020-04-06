<?php
class Plugincompany_Contactforms_Model_Producthelper
    extends Mage_Catalog_Model_Product 
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
                if(is_numeric($data)){
                    $text = $this
                        ->getAttributeText($key);
                    if($text){
                        $data = $text;
                    }
                }

                //Varien_Profiler::stop('GETTER: '.get_class($this).'::'.$method);
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

    public function getFormattedPrice()
    {
        return Mage::helper('core')->formatPrice($this->getPrice(), false);
    }

    public function getFormattedFinalPrice()
    {
        return Mage::helper('core')->formatPrice($this->getFinalPrice(), false);
    }

    public function getFormattedPriceNoSymbol()
    {
        return Mage::getModel('directory/currency')->format(
            $this->getPrice(),
            array('display'=>Zend_Currency::NO_SYMBOL),
            false
        );
    }

    public function getFormattedFinalPriceNoSymbol()
    {
        return Mage::getModel('directory/currency')->format(
            $this->getFinalPrice(),
            array('display'=>Zend_Currency::NO_SYMBOL),
            false
        );
    }
}
