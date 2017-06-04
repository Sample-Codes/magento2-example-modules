<?php

namespace ProjectEight\PersistenceLayerExample\Controller\Adminhtml\WhatsIt;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use ProjectEight\PersistenceLayerExample\Model\ResourceModel\WhatsIt\CollectionFactory;

abstract class AbstractMassAction extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'ProjectEight_PersistenceLayerExample::WhatsIt';

    /**
     * Redirect URL
     *
     * @var string
     */
    protected $redirectUrl = 'projecteight_persistencelayerexample/whatsit/index';

    /**
     * Filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * Collection Factory
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            return $this->massAction($collection);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath($this->redirectUrl);
        }
    }

    /**
     * Return component referer url
     *
     * @todo: Technical dept referer url should be implement as a part of Action configuration in an appropriate way
     *
     * @return null|string
     */
    protected function getComponentRefererUrl()
    {
        return $this->filter->getComponentRefererUrl()?: 'projecteight_persistencelayerexample/whatsit/index';
    }

    /**
     * Execute action to collection items
     *
     * @param AbstractCollection $collection
     * @return ResponseInterface|ResultInterface|\Magento\Backend\Model\View\Result\Redirect
     */
    abstract protected function massAction(AbstractCollection $collection);
}