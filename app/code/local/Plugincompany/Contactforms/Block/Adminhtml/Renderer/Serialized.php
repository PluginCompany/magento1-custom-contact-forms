<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */
class Plugincompany_Contactforms_Block_Adminhtml_Renderer_Serialized
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        $values = unserialize($value);
        $skinUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);
        $table = '<table class="data" cellspacing="0">'
            . '<thead>'
            . '<tr class="headings" style="background:url(' . $skinUrl . 'adminhtml/default/default/images/sort_row_bg.gif) 0 50% repeat-x">'
            . '<th style="width:100px"><span>Field ID</span></th>'
            . '<th><span>Value</span></th>'
            . '</tr>'
            . '</thead>';
        $i = 0;
        foreach($values as $k => $v){
            if(!$v) continue;
            if($k == 'upload_dir') continue;

            $v = utf8_decode($v);

            $color = '#f7f7f7';
            if($i % 2 == 0){
                $color = '#fff';
            }
            $val = nl2br(htmlspecialchars($v, ENT_COMPAT));
            $table .= "<tr style='background-color:$color'><td>$k</td><td>$val</td></tr>";
            $i++;
        }
        $table .= '</table>';

        $html = "<div class='grid' style='min-width:350px;background:white;padding:6px;border:1px solid #ccc;'>" . $table . '</div>';
        return $html;
    }
}