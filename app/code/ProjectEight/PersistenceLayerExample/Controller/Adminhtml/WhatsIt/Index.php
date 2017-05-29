<?php


namespace ProjectEight\PersistenceLayerExample\Controller\Adminhtml\WhatsIt;

class Index extends \Magento\Backend\App\Action
{
//    /**
//     * Authorization level of a basic admin session
//     *
//     * @see _isAllowed()
//     */
//    const ADMIN_RESOURCE = 'ProjectEight_PersistenceLayerExample::WhatsIt_view';

    /**
     * Result Page Factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__("WhatsIt"));

        return $resultPage;
    }
}
