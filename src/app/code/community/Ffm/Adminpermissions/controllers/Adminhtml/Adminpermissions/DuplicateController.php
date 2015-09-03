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
 * Duplicate admin controller
 *
 * @category    Ffm
 * @package     Ffm_Adminpermissions
 * @author      Sander Mangel <sander@sandermangel.nl>
 */
class Ffm_Adminpermissions_Adminhtml_Adminpermissions_DuplicateController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Initialize role model by passed parameter in request
     *
     * @return Mage_Admin_Model_Roles
     */
    protected function _initRole($requestVariable = 'rid')
    {
        $this->_title($this->__('System'))
            ->_title($this->__('Permissions'))
            ->_title($this->__('Roles'));

        $role = Mage::getModel('admin/roles')->load($this->getRequest()->getParam($requestVariable));
        // preventing edit of relation role
        if ($role->getId() && $role->getRoleType() != 'G') {
            $role->unsetData($role->getIdFieldName());
        }

        Mage::register('current_role', $role);
        return Mage::registry('current_role');
    }

    /**
     * Handle role duplication request
     *
     * @access public
     * @author Sander Mangel
     */
    public function indexAction()
    {
        try {
            $role = $this->_initRole();
            if (!$role->getId()) {
                throw new Exception(Mage::helper('ffm_adminpermissions')->__('Role not found'));
            }

            $ruleCollection = Mage::getModel('admin/rules')->getCollection()
                ->addFieldToSelect('resource_id')
                ->addFieldToFilter('role_id',$role->getId());

            if (!$ruleCollection->getSize()) {
                throw new Exception(Mage::helper('ffm_adminpermissions')->__('Role has no rules'));
            }

            $newRole = Mage::getModel('admin/roles');
            $newRole->setName("{$role->getRoleName()} [DUPLICATE]")
                ->setPid($newRole->getParentId())
                ->setRoleType('G');

            if (Mage::helper('ffm_adminpermissions')->isEE()) {
                $newRole->setGwsIsAll($role->getGwsIsAll());
                if (!$role->getGwsIsAll()) {
                    $newRole->setGwsWebsites($role->getGwsWebsites());
                    $newRole->setGwsStoreGroups($role->getGwsStoreGroups());
                }
            }

            $newRole->save();

            Mage::getModel('admin/rules')
                ->setRoleId($newRole->getId())
                ->setResources($ruleCollection->getColumnValues('resource_id'))
                ->saveRel();

            $rid = $newRole->getId();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The role has been successfully duplicated.'));

            $this->_redirect('adminhtml/permissions_role/editrole', array('rid' => $rid));
            return;
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this role: ' . $e->getMessage()));
        }

        $this->_redirectReferer();
        return;
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Sander Mangel
     */
    protected function _isAllowed()
    {
        return true;
    }
}
