<?php


namespace ProjectEight\PersistenceLayerExample\Controller\Adminhtml\WhatsIt;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Data Persistor
     *
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersister;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context                   $context
     * @param \Magento\Framework\Registry                           $coreRegistry
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersister
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersister
    ) {
        $this->dataPersister = $dataPersister;
        /**
         * @todo Test this without the coreRegistry argument
         */
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data           = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('whatsit_id');
            /**
             * @todo Should we be using the object manager here?
             */
            $model = $this->_objectManager->create('ProjectEight\PersistenceLayerExample\Model\WhatsIt')->load($id);
            if (!$model->getId() && $id) {
                /**
                 * @todo Refactor this to not use a deprecated method
                 */
                $this->messageManager->addError(__('This Whatsit no longer exists.'));

                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {

                /**
                 * @todo Refactor save() to use repository method
                 */
                $model->save();
                /**
                 * @todo Refactor this to not use a deprecated method
                 */
                $this->messageManager->addSuccess(__('You saved the Whatsit.'));
                $this->dataPersister->clear('projecteight_persistencelayerexample_whatsit');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['whatsit_id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                /**
                 * @todo Refactor this to not use a deprecated method
                 */
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                /**
                 * @todo Refactor this to not use a deprecated method
                 */
                $this->messageManager->addException($e, __('Something went wrong while saving the Whatsit.'));
            }

            $this->dataPersister->set('projecteight_persistencelayerexample_whatsit', $data);

            return $resultRedirect->setPath(
                '*/*/edit',
                    [
                        'whatsit_id' => $this->getRequest()->getParam('whatsit_id')
                    ]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }
}
