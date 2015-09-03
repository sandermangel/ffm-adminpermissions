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
 * Observer model
 *
 * @category    Ffm
 * @package     Ffm_Adminpermissions
 * @author      Sander Mangel <sander@sandermangel.nl>
 */
class Ffm_Adminpermissions_Model_Observer
{
    public function coreBlockAbstractPrepareLayoutAfter($o)
    {
        $this->_addDuplicateButton($o);
        return $this;
    }

    protected function _addDuplicateButton($o)
    {
        $container = $o->getBlock();
        if(null !== $container && $container->getType() == 'adminhtml/permissions_buttons') {

            $duplicateBlock = $container->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('catalog')->__('Duplicate'),
                    'onclick' => 'setLocation(\'' . $this->_getDuplicateUrl($container) . '\')',
                    'class' => 'add'
                ));

            $saveChild = $container->getChild('saveButton');
            $saveChild->setAfterHtml($duplicateBlock->toHtml());
        }
        return $this;
    }

    protected function _getDuplicateUrl($container)
    {
        return $container->getUrl('adminhtml/adminpermissions_duplicate', array('_current' => true));
    }
}