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

use Magento\Framework\Controller\ResultFactory;

class Delete extends \ProjectEight\PersistenceLayerExample\Controller\Adminhtml\WhatsIt
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'ProjectEight_PersistenceLayerExample::WhatsIt_delete';

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /**
         * @todo Refactor this to pass the form_key
         * @todo Refactor this to use POST instead of GET
         */
//        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
//        $resultRedirect = $this->resultRedirectFactory->create();

//        $formKeyIsValid = $this->_formKeyValidator->validate($this->getRequest());
//        $isPost = $this->getRequest()->isPost();
//        if (!$formKeyIsValid || !$isPost) {
//            $this->messageManager->addError(__('WhatsIt could not be deleted.'));
//            return $resultRedirect->setPath('*/*');
//        }

        $whatsItId = $this->initCurrentWhatsIt();
        if (!empty($whatsItId)) {
            try {
                $this->whatsItRepository->deleteById($whatsItId);
                $this->messageManager->addSuccessMessage(__('You deleted the WhatsIt.'));
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*');
    }
}
