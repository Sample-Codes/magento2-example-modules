<?php

namespace ProjectEight\ToDo\Model\Task\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var \ProjectEight\ToDo\Model\Task
     */
    protected $task;

    /**
     * Constructor
     *
     * @param \ProjectEight\ToDo\Model\Task $task
     */
    public function __construct(\ProjectEight\ToDo\Model\Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->task->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
