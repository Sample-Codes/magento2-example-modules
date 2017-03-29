<?php


namespace ProjectEight\ToDo\Model;

use ProjectEight\ToDo\Api\Data\TaskInterface;

class Task extends \Magento\Framework\Model\AbstractModel implements TaskInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ProjectEight\ToDo\Model\ResourceModel\Task');
    }

    /**
     * Get task_id
     * @return string
     */
    public function getTaskId()
    {
        return $this->getData(self::TASK_ID);
    }

    /**
     * Set task_id
     * @param string $taskId
     * @return ProjectEight\ToDo\Api\Data\TaskInterface
     */
    public function setTaskId($taskId)
    {
        return $this->setData(self::TASK_ID, $taskId);
    }

    /**
     * Get Name
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set Name
     * @param string $Name
     * @return ProjectEight\ToDo\Api\Data\TaskInterface
     */
    public function setName($Name)
    {
        return $this->setData(self::NAME, $Name);
    }

    /**
     * Get Description
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Set Description
     * @param string $Description
     * @return ProjectEight\ToDo\Api\Data\TaskInterface
     */
    public function setDescription($Description)
    {
        return $this->setData(self::DESCRIPTION, $Description);
    }

    /**
     * Get Status
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set Status
     * @param string $Status
     * @return ProjectEight\ToDo\Api\Data\TaskInterface
     */
    public function setStatus($Status)
    {
        return $this->setData(self::STATUS, $Status);
    }

    /**
     * Get Task Status
     * @return string
     */
    public function getTaskStatus()
    {
        return $this->getData(self::ENABLED);
    }

    /**
     * Set Task Status
     * @param string $Status
     * @return ProjectEight\ToDo\Api\Data\TaskInterface
     */
    public function setTaskStatus($Status)
    {
        return $this->setData(self::DISABLED, $Status);
    }

    /**
     * Prepare tasks's statuses.
     * Available event cms_page_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::ENABLED => __('Enabled'), self::DISABLED => __('Disabled')];
    }
}
