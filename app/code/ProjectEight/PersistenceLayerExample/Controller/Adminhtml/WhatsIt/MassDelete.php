<?php

namespace ProjectEight\PersistenceLayerExample\Controller\Adminhtml\WhatsIt;

use Magento\Backend\App\Action\Context;
use ProjectEight\PersistenceLayerExample\Model\ResourceModel\WhatsIt\CollectionFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\Component\MassAction\Filter;
use ProjectEight\PersistenceLayerExample\Api\WhatsItRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassDelete
 */
class MassDelete extends AbstractMassAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'ProjectEight_PersistenceLayerExample::WhatsIt_delete';

    /**
     * WhatsIt Repository Interface
     *
     * @var WhatsItRepositoryInterface
     */
    protected $whatsItRepository;

    /**
     * Constructor
     *
     * @param Context                    $context
     * @param Filter                     $filter
     * @param CollectionFactory          $collectionFactory
     * @param WhatsItRepositoryInterface $whatsItRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        WhatsItRepositoryInterface $whatsItRepository
    ) {
        parent::__construct($context, $filter, $collectionFactory);
        $this->whatsItRepository = $whatsItRepository;
    }

    /**
     * Perform Mass Action
     *
     * @param AbstractCollection $collection
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    protected function massAction(AbstractCollection $collection)
    {
        $whatsitsDeleted = 0;
        foreach ($collection->getAllIds() as $whatsitId) {
            $this->whatsItRepository->deleteById($whatsitId);
            $whatsitsDeleted++;
        }

        if ($whatsitsDeleted) {
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) were deleted.', $whatsitsDeleted));
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->getComponentRefererUrl());

        return $resultRedirect;
    }
}
