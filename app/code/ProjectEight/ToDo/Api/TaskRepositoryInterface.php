<?php


namespace ProjectEight\ToDo\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface TaskRepositoryInterface
{


    /**
     * Save Task
     * @param \ProjectEight\ToDo\Api\Data\TaskInterface $task
     * @return \ProjectEight\ToDo\Api\Data\TaskInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function save(
        \ProjectEight\ToDo\Api\Data\TaskInterface $task
    );

    /**
     * Retrieve Task
     * @param string $taskId
     * @return \ProjectEight\ToDo\Api\Data\TaskInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getById($taskId);

    /**
     * Retrieve Task matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \ProjectEight\ToDo\Api\Data\TaskSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Task
     * @param \ProjectEight\ToDo\Api\Data\TaskInterface $task
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function delete(
        \ProjectEight\ToDo\Api\Data\TaskInterface $task
    );

    /**
     * Delete Task by ID
     * @param string $taskId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function deleteById($taskId);
}
