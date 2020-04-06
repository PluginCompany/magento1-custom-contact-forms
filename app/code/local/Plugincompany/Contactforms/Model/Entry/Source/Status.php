<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */

/**
 * Source model for entry status
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Model_Entry_Source_Status {
    /**
     * get possible values
     * @access public
     * @param bool $withEmpty
     * @return array
     * @author Milan Simek
     */
    public function getAllOptions($withEmpty = true)
    {
        $options =  array(
            array(
                'label' => Mage::helper('plugincompany_contactforms')->__('New'),
                'value' => 0
            ),
            array(
                'label' => Mage::helper('plugincompany_contactforms')->__('Viewed'),
                'value' => 1
            ),
            array(
                'label' => Mage::helper('plugincompany_contactforms')->__('In Progress'),
                'value' => 2
            ),
            array(
                'label' => Mage::helper('plugincompany_contactforms')->__('On Hold'),
                'value' => 3
            ),
            array(
                'label' => Mage::helper('plugincompany_contactforms')->__('Awaiting User'),
                'value' => 4
            ),
            array(
                'label' => Mage::helper('plugincompany_contactforms')->__('Answered'),
                'value' => 5
            ),
            array(
                'label' => Mage::helper('plugincompany_contactforms')->__('Approved'),
                'value' => 6
            ),
            array(
                'label' => Mage::helper('plugincompany_contactforms')->__('Rejected'),
                'value' => 7
            ),
            array(
                'label' => Mage::helper('plugincompany_contactforms')->__('Closed'),
                'value' => 8
            ),
            array(
                'label' => Mage::helper('plugincompany_contactforms')->__('Complete'),
                'value' => 9
            ),
        );
        if ($withEmpty) {
            array_unshift($options, array('label'=>'', 'value'=>''));
        }
        return $options;

    }
    /**
     * get options as array
     * @access public
     * @param bool $withEmpty
     * @return string
     * @author Milan Simek
     */
    public function getOptionsArray($withEmpty = true) {
        $options = array();
        foreach ($this->getAllOptions($withEmpty) as $option) {
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }

    public function toOptionArray($withEmpty = true){
        return $this->getOptionsArray($withEmpty);
    }
    /**
     * get option text
     * @access public
     * @param mixed $value
     * @return string
     * @author Milan Simek
     */
    public function getOptionText($value) {
        $options = $this->getOptionsArray();
        if (!is_array($value)) {
            $value = array($value);
        }
        $texts = array();
        foreach ($value as $v) {
            if (isset($options[$v])) {
                $texts[] = $options[$v];
            }
        }
        return implode(', ', $texts);
    }
}
