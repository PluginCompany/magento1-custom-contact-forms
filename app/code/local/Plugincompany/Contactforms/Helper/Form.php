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
 * Form helper
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Helper_Form
    extends Mage_Core_Helper_Abstract {
    /**
     * check if breadcrumbs can be used
     * @access public
     * @return bool
     * @author Milan Simek
     */
    public function getUseBreadcrumbs(){
        return Mage::getStoreConfigFlag('plugincompany_contactforms/form/breadcrumbs');
    }
}
