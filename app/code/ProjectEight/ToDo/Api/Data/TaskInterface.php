<?php


namespace ProjectEight\ToDo\Api\Data;

interface TaskInterface
{

    const NAME = 'Name';
    const DESCRIPTION = 'Description';
    const STATUS = 'Status';
    const TASK_ID = 'task_id';


    /**
     * Get task_id
     * @return string|null
     */
    
    public function getTaskId();

    /**
     * Set task_id
     * @param string $task_id
     * @return ProjectEight\ToDo\Api\Data\TaskInterface
     */
    
    public function setTaskId($taskId);

    /**
     * Get Name
     * @return string|null
     */
    
    public function getName();

    /**
     * Set Name
     * @param string $Name
     * @return ProjectEight\ToDo\Api\Data\TaskInterface
     */
    
    public function setName($Name);

    /**
     * Get Description
     * @return string|null
     */
    
    public function getDescription();

    /**
     * Set Description
     * @param string $Description
     * @return ProjectEight\ToDo\Api\Data\TaskInterface
     */
    
    public function setDescription($Description);

    /**
     * Get Status
     * @return string|null
     */
    
    public function getStatus();

    /**
     * Set Status
     * @param string $Status
     * @return ProjectEight\ToDo\Api\Data\TaskInterface
     */
    
    public function setStatus($Status);
}
