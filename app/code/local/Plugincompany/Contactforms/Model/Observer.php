<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */
class Plugincompany_Contactforms_Model_Observer {

    public function pcContactformsFormSubmitBefore(Varien_Event_Observer $observer){
//        $form = $observer->getEvent()->getForm();
//        $params = $observer->getEvent()->getParams();
//        $params->setStopProcessing(true);
    }

    public function plugincompanyContactformsEntrySaveBefore(Varien_Event_Observer $observer){
//        $entry = $observer->getEvent()->getEntry();
    }
}