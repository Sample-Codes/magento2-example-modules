<?php


namespace ProjectEight\PersistenceLayerExample\Controller\Adminhtml;

use ProjectEight\PersistenceLayerExample\Controller\RegistryConstants;

abstract class WhatsIt extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'ProjectEight_PersistenceLayerExample::top_level';

    /**
     * Core Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * WhatsIt Repository
     *
     * @var \ProjectEight\PersistenceLayerExample\Api\WhatsItRepositoryInterface
     */
    protected $whatsItRepository;

    /**
     * Result Page Factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context                                  $context
     * @param \Magento\Framework\Registry                                          $coreRegistry
     * @param \ProjectEight\PersistenceLayerExample\Api\WhatsItRepositoryInterface $whatsItRepository
     * @param \Magento\Framework\View\Result\PageFactory                           $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \ProjectEight\PersistenceLayerExample\Api\WhatsItRepositoryInterface $whatsItRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->coreRegistry      = $coreRegistry;
        $this->whatsItRepository = $whatsItRepository;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * WhatsIt initialisation
     *
     * @return string WhatsIt ID
     */
    protected function initCurrentWhatsIt()
    {
        $whatsItId = (int)$this->getRequest()->getParam('whatsit_id');

        if ($whatsItId) {
            $this->coreRegistry->register(RegistryConstants::CURRENT_WHATSIT_ID, $whatsItId);
        }

        return $whatsItId;
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Experius_Test::top_level')
                   ->addBreadcrumb(__('ProjectEight'), __('ProjectEight'))
                   ->addBreadcrumb(__('Whatsit'), __('Whatsit'))
        ;

        return $resultPage;
    }
}
