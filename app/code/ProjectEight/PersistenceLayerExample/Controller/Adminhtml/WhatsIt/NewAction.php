<?php


namespace ProjectEight\PersistenceLayerExample\Controller\Adminhtml\WhatsIt;

class NewAction extends \ProjectEight\PersistenceLayerExample\Controller\Adminhtml\WhatsIt
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'ProjectEight_PersistenceLayerExample::WhatsIt_edit';

    /**
     * New action
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();

        return $resultForward->forward('edit');
    }
}
