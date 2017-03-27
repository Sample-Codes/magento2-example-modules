<?php


namespace ProjectEight\ToDo\Model;

use ProjectEight\ToDo\Model\ResourceModel\Task\CollectionFactory as TaskCollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SortOrder;
use Magento\Store\Model\StoreManagerInterface;
use ProjectEight\ToDo\Model\ResourceModel\Task as ResourceTask;
use ProjectEight\ToDo\Api\TaskRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\DataObjectHelper;
use ProjectEight\ToDo\Api\Data\TaskInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use ProjectEight\ToDo\Api\Data\TaskSearchResultsInterfaceFactory;

class TaskRepository implements TaskRepositoryInterface
{

    protected $TaskCollectionFactory;

    protected $TaskFactory;

    protected $dataObjectHelper;

    protected $searchResultsFactory;

    protected $dataObjectProcessor;

    protected $resource;

    protected $dataTaskFactory;

    private $storeManager;


    /**
     * @param ResourceTask $resource
     * @param TaskFactory $taskFactory
     * @param TaskInterfaceFactory $dataTaskFactory
     * @param TaskCollectionFactory $taskCollectionFactory
     * @param TaskSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceTask $resource,
        TaskFactory $taskFactory,
        TaskInterfaceFactory $dataTaskFactory,
        TaskCollectionFactory $taskCollectionFactory,
        TaskSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->taskFactory = $taskFactory;
        $this->taskCollectionFactory = $taskCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataTaskFactory = $dataTaskFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \ProjectEight\ToDo\Api\Data\TaskInterface $task
    ) {
        /* if (empty($task->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $task->setStoreId($storeId);
        } */
        try {
            $this->resource->save($task);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the task: %1',
                $exception->getMessage()
            ));
        }
        return $task;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($taskId)
    {
        $task = $this->taskFactory->create();
        $task->load($taskId);
        if (!$task->getId()) {
            throw new NoSuchEntityException(__('Task with id "%1" does not exist.', $taskId));
        }
        return $task;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $collection = $this->taskCollectionFactory->create();
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
        
        foreach ($collection as $taskModel) {
            $taskData = $this->dataTaskFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $taskData,
                $taskModel->getData(),
                'ProjectEight\ToDo\Api\Data\TaskInterface'
            );
            $items[] = $this->dataObjectProcessor->buildOutputDataArray(
                $taskData,
                'ProjectEight\ToDo\Api\Data\TaskInterface'
            );
        }
        $searchResults->setItems($items);
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \ProjectEight\ToDo\Api\Data\TaskInterface $task
    ) {
        try {
            $this->resource->delete($task);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Task: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($taskId)
    {
        return $this->delete($this->getById($taskId));
    }
}
