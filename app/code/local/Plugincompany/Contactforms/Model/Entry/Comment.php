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
 * Form Entry model
 *
 * @category    Plugincompany
 * @package     Plugincompany_Contactforms
 * @author      Milan Simek
 */
class Plugincompany_Contactforms_Model_Entry_Comment
    extends Mage_Core_Model_Abstract {
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'plugincompany_contactforms_entry_comment';
    const CACHE_TAG = 'plugincompany_contactforms_entry_comment';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'plugincompany_contactforms_entry_comment';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'comment';
    /**
     * constructor
     * @access public
     * @return void
     * @author Milan Simek
     */
    public function _construct(){
        parent::_construct();
        $this->_init('plugincompany_contactforms/entry_comment');
    }
}
