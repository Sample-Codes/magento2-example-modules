<?php


namespace ProjectEight\PersistenceLayerExample\Controller\Adminhtml;

abstract class WhatsIt extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'ProjectEight_PersistenceLayerExample::top_level';

    /**
     * Core Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry         $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
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
