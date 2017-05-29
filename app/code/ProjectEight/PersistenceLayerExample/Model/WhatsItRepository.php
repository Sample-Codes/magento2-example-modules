<?php


namespace ProjectEight\PersistenceLayerExample\Model;

use ProjectEight\PersistenceLayerExample\Api\WhatsItRepositoryInterface;
use ProjectEight\PersistenceLayerExample\Api\Data\WhatsItSearchResultsInterfaceFactory;
use ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use ProjectEight\PersistenceLayerExample\Model\ResourceModel\WhatsIt as ResourceWhatsIt;
use ProjectEight\PersistenceLayerExample\Model\ResourceModel\WhatsIt\CollectionFactory as WhatsItCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class WhatsItRepository implements WhatsItRepositoryInterface
{
    /**
     * @var ResourceWhatsIt
     */
    protected $resource;

    /**
     * @var WhatsItFactory
     */
    protected $whatsItFactory;

    /**
     * @var \ProjectEight\PersistenceLayerExample\Model\ResourceModel\WhatsIt\CollectionFactory
     */
    protected $whatsItCollectionFactory;

    /**
     * @var \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper;
     */
    protected $dataObjectHelper;

    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterfaceFactory
     */
    protected $dataWhatsItFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;


    /**
     * Constructor
     *
     * @param ResourceWhatsIt                      $resource
     * @param WhatsItFactory                       $whatsItFactory
     * @param WhatsItInterfaceFactory              $dataWhatsItFactory
     * @param WhatsItCollectionFactory             $whatsItCollectionFactory
     * @param WhatsItSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper                     $dataObjectHelper
     * @param DataObjectProcessor                  $dataObjectProcessor
     * @param StoreManagerInterface                $storeManager
     */
    public function __construct(
        ResourceWhatsIt $resource,
        WhatsItFactory $whatsItFactory,
        WhatsItInterfaceFactory $dataWhatsItFactory,
        WhatsItCollectionFactory $whatsItCollectionFactory,
        WhatsItSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource                 = $resource;
        $this->whatsItFactory           = $whatsItFactory;
        $this->whatsItCollectionFactory = $whatsItCollectionFactory;
        $this->searchResultsFactory     = $searchResultsFactory;
        $this->dataObjectHelper         = $dataObjectHelper;
        $this->dataWhatsItFactory       = $dataWhatsItFactory;
        $this->dataObjectProcessor      = $dataObjectProcessor;
        $this->storeManager             = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface $whatsIt
    ) {
        try {
            $this->resource->save($whatsIt);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the WhatsIt: %1',
                $exception->getMessage()
            ));
        }

        return $whatsIt;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($whatsItId)
    {
        $whatsIt = $this->whatsItFactory->create();
        /**
         * @todo Refactor this to use repository
         */
        $whatsIt->load($whatsItId);
        if (!$whatsIt->getId()) {
            throw new NoSuchEntityException(__('WhatsIt with id "%1" does not exist.', $whatsItId));
        }

        return $whatsIt;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->whatsItCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $items = [];

        foreach ($collection as $whatsItModel) {
            $whatsItData = $this->dataWhatsItFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $whatsItData,
                $whatsItModel->getData(),
                'ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface'
            );
            $items[] = $this->dataObjectProcessor->buildOutputDataArray(
                $whatsItData,
                'ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface'
            );
        }
        $searchResults->setItems($items);

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface $whatsIt
    ) {
        try {
            $this->resource->delete($whatsIt);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the WhatsIt: %1',
                $exception->getMessage()
            ));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($whatsItId)
    {
        return $this->delete($this->getById($whatsItId));
    }
}
