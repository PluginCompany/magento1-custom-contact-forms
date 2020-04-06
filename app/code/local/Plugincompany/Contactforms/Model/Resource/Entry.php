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
 * Form Entry resource model
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Model_Resource_Entry
    extends Mage_Core_Model_Mysql4_Abstract {
    /**
     * constructor
     * @access public
     * @author Milan Simek
     */
    public function _construct(){
        $this->_init('plugincompany_contactforms/entry', 'entity_id');
    }
}
