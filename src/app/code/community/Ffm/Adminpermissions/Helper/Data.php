<?php
/**
 * Ffm_Adminpermissions extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @category       Ffm
 * @package        Ffm_Adminpermissions
 * @copyright      Copyright (c) FitForMe B.V. 2015
 * @license        http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */
/**
 * Helper
 *
 * @category    Ffm
 * @package     Ffm_Adminpermissions
 * @author      Sander Mangel <sander@sandermangel.nl>
 */
class Ffm_Adminpermissions_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function isEE()
    {
        return Mage::getConfig ()->getModuleConfig ('Enterprise_AdminGws');
    }
}
