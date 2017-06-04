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

class Edit extends \ProjectEight\PersistenceLayerExample\Controller\Adminhtml\WhatsIt
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'ProjectEight_PersistenceLayerExample::WhatsIt_edit';

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id    = $this->getRequest()->getParam('whatsit_id');
        $model = $this->_objectManager->create('ProjectEight\PersistenceLayerExample\Model\WhatsIt');

        // 2. Initial checking
        if ($id) {
            /**
             * @todo Refactor load() to use repository method
             */
            $model->load($id);
            if (!$model->getId()) {
                /**
                 * @todo Refactor this to not use a deprecated method
                 */
                $this->messageManager->addError(__('This Whatsit no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('projecteight_persistencelayerexample_whatsit', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Whatsit') : __('New Whatsit'),
            $id ? __('Edit Whatsit') : __('New Whatsit')
        )
        ;
        $resultPage->getConfig()->getTitle()->prepend(__('Whatsits'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Whatsit'));

        return $resultPage;
    }
}
