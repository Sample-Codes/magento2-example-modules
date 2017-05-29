<?php
/**
 * ProjectEight
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact ProjectEight for more information.
 *
 * @category    AddNewApiMethod
 * @package     webapi.xml
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\PersistenceLayerExample\Controller\Adminhtml\WhatsIt;

class Delete extends \ProjectEight\PersistenceLayerExample\Controller\Adminhtml\WhatsIt
{
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('whatsit_id');
        if ($id) {
            try {
                // init model and delete
                /**
                 * @todo Should we be using the object manager here?
                 */
                $model = $this->_objectManager->create('ProjectEight\PersistenceLayerExample\Model\WhatsIt');
                /**
                 * @todo Refactor load() to use repository method
                 */
                $model->load($id);
                /**
                 * @todo Refactor delete() to use repository method
                 */
                $model->delete();
                // display success message
                /**
                 * @todo Refactor this to not use a deprecated method
                 */
                $this->messageManager->addSuccess(__('You deleted the Whatsit.'));

                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                /**
                 * @todo Refactor this to not use a deprecated method
                 */
                $this->messageManager->addError($e->getMessage());

                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['whatsit_id' => $id]);
            }
        }
        // display error message
        /**
         * @todo Refactor this to not use a deprecated method
         */
        $this->messageManager->addError(__('We can\'t find a Whatsit to delete.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
