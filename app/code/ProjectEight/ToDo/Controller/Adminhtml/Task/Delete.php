<?php


namespace ProjectEight\ToDo\Controller\Adminhtml\Task;

class Delete extends \ProjectEight\ToDo\Controller\Adminhtml\Task
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('task_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('ProjectEight\ToDo\Model\Task');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('You deleted the Task.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['task_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a Task to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
