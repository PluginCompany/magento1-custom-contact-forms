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
class Varien_Data_Form_Element_Pchtml extends Varien_Data_Form_Element_Abstract
{
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
    }

    public function getElementHtml()
    {
        if(!$this->getValue()){
            $this->setValue('No value set');
        }
        if($this->getHtmlSafe()){

            $uId = uniqid('pciframe');

            $html =
                "<div style='min-width:350px;background:white;padding:0px;font-size:12px;font-family:arial,helvetica,sans-serif'>"
                . $this->getEscapedValue()
                . '<style type="text/css">body {margin:0px;padding:0px;}</style>'
                . '</div>';

            $html = $this->getResizeScript()
            . '<iframe id="' . $uId . '" onload="autoResize(\'' . $uId . '\')" frameborder="0" style="min-width:400px;border:1px solid #ccc;background:white;padding:6px;" srcdoc="' . $html . '"></iframe>';
        }else{
            $html = "<div style='min-width:350px;background:white;padding:6px;border:1px solid #ccc;'>" . $this->getEscapedValue() . '</div>';
        }
        return $html;

    }

    public function getResizeScript(){
        $script  = "
        var autoResize = function(id){
            var newheight;
            var newwidth;

            if(document.getElementById){
                newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
                newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
            }

            document.getElementById(id).height= (newheight) + 'px';
            document.getElementById(id).width= (newwidth) + 'px';
        }";
        $script = "<script type='text/javascript'>$script</script>";
        return $script;
    }

    public function getHtmlAttributes()
    {
        return array('type', 'title', 'class', 'style', 'onclick', 'onchange', 'onkeyup', 'disabled', 'readonly', 'maxlength', 'tabindex');
    }
}
