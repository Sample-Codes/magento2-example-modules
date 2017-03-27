<?php


namespace ProjectEight\ToDo\Model\ResourceModel\Task;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'ProjectEight\ToDo\Model\Task',
            'ProjectEight\ToDo\Model\ResourceModel\Task'
        );
    }
}
