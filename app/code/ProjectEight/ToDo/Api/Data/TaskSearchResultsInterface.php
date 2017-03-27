<?php


namespace ProjectEight\ToDo\Api\Data;

interface TaskSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Task list.
     * @return \ProjectEight\ToDo\Api\Data\TaskInterface[]
     */
    
    public function getItems();

    /**
     * Set Name list.
     * @param \ProjectEight\ToDo\Api\Data\TaskInterface[] $items
     * @return $this
     */
    
    public function setItems(array $items);
}
