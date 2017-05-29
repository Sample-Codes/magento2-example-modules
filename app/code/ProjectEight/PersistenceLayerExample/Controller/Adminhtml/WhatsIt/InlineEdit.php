<?php


namespace ProjectEight\PersistenceLayerExample\Controller\Adminhtml\WhatsIt;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'ProjectEight_PersistenceLayerExample::WhatsIt_update';

    /**
     * JSON Factory
     *
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context              $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Inline edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error      = false;
        $messages   = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error      = true;
            } else {
                foreach (array_keys($postItems) as $modelid) {
                    /** @var \Magento\Cms\Model\Block $block */
                    $model = $this->_objectManager->create('ProjectEight\PersistenceLayerExample\Model\WhatsIt')
                                                  ->load($modelid)
                    ;
                    try {
                        $model->setData(array_merge($model->getData(), $postItems[ $modelid ]));
                        $model->save();
                    } catch (\Exception $e) {
                        $messages[] = "[Whatsit ID: {$modelid}]  {$e->getMessage()}";
                        $error      = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error'    => $error,
        ]);
    }
}
