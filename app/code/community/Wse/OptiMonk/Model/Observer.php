<?php
/**
 * OptiMonk plugin for Magento 1.7+
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * For a copy of the GNU General Public License, see <http://www.gnu.org/licenses/>.
 *
 * @package     Wse_OptiMonk
 * @copyright   Copyright (c) 2016 Webshop Marketing Kft (www.optimonk.com)
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * @author      Tibor Berna
 */
class Wse_OptiMonk_Model_Observer
{
    /**
     * Listen to the event core_block_abstract_to_html_after
     *
     * @parameter Varien_Event_Observer $observer
     * @return $this
     */
    public function coreBlockAbstractToHtmlAfter($observer)
    {
        if ($this->getModuleHelper()->isEnabled() == false) {
            return $this;
        }

        $block = $observer->getEvent()->getBlock();
        if($block->getNameInLayout() == 'root') {

            $transport = $observer->getEvent()->getTransport();
            $html = $transport->getHtml();

            $script = Mage::helper('optimonk')->getHeaderScript();

            if (empty($script)) {
                return $this;
            }

            $html = preg_replace('/\<body([^\>]+)\>/', '\0'.$script, $html);

            $transport->setHtml($html);
        }

        return $this;
    }

    /**
     * @return Wse_Optimonk_Helper_Data
     */
    protected function getModuleHelper()
    {
        return Mage::helper('optimonk');
    }
}
