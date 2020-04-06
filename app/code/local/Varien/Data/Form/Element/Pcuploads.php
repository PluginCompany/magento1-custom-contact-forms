<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Varien
 * @package    Varien_Data
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Form text element
 *
 * @category   Varien
 * @package    Varien_Data
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Varien_Data_Form_Element_Pcuploads extends Varien_Data_Form_Element_Abstract
{
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
    }

    public function getElementHtml()
    {
        if(!Mage::registry('current_entry')){
            return 'error loading form submission details';
        }

        $fields = unserialize(Mage::registry('current_entry')->getFields());


        if(!isset($fields['upload_dir']) || !$fields['upload_dir']){
            return 'No upload directory set';
        }

        $uploadDir = Mage::getBaseDir() . $fields['upload_dir'];

        $files = array();
        
        try{
            foreach(scandir($uploadDir) as $file){
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $files[] = $file;
            }
        }catch(Exception $e){};

        if(!count($files)){
            return 'No uploaded files';
        }

        $table = '<table class="data" cellspacing="0">'
                    . '<thead>'
                        . '<tr class="headings">'
                            . '<th><span>File</span></th>'
                            . '<th><span>Size (KB)</span></th>'
                        . '</tr>'
                    . '</thead>';
        $i = 0;
        foreach($files as $v){
            if(!$v) continue;

            $file = $uploadDir . DS . $v;

            $url = Mage::helper('adminhtml')->getUrl('*/*/downloadfile', array('file' => base64_encode($file)));

            $size = number_format(filesize($file) / 1024,2);

            $class = 'odd';
            if($i % 2 == 0){
                $class = 'even';
            }
            $table .= "<tr class='$class'><td><a href='$url'>$v</a></td><td>$size</td></tr>";
            $i++;
        }
        $table .= '</table>';

        $html = "<div class='grid' style='min-width:350px;background:white;padding:6px;border:1px solid #ccc;'>" . $table . '</div>';
        return $html;
    }

    public function getHtmlAttributes()
    {
        return array('type', 'title', 'class', 'style', 'onclick', 'onchange', 'onkeyup', 'disabled', 'readonly', 'maxlength', 'tabindex');
    }
}
