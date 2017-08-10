<?php

namespace ProjectEight\AddNewWidgetExample\Setup;

use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Widget\Model\ResourceModel\Widget\Instance\CollectionFactory;
use Magento\Widget\Model\Widget\InstanceFactory;

class InstallData implements InstallDataInterface
{
    /**
     * Block Factory
     *
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * Block Repository
     *
     * @var BlockRepositoryInterface
     */
    private $blockRepository;
    /**
     * @var CollectionFactory
     */
    private $appCollectionFactory;
    /**
     * @var InstanceFactory
     */
    private $widgetFactory;

    /**
     * Constructor
     *
     * @param BlockFactory             $blockFactory
     * @param BlockRepositoryInterface $blockRepository
     * @param CollectionFactory        $appCollectionFactory
     * @param InstanceFactory          $widgetFactory
     */
    public function __construct(
        BlockFactory $blockFactory,
        BlockRepositoryInterface $blockRepository,
        CollectionFactory $appCollectionFactory,
        InstanceFactory $widgetFactory
    ) {
        $this->blockFactory         = $blockFactory;
        $this->blockRepository      = $blockRepository;
        $this->appCollectionFactory = $appCollectionFactory;
        $this->widgetFactory        = $widgetFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Check the widget doesn't exist already
         */

        /** @var \Magento\Widget\Model\ResourceModel\Widget\Instance\Collection $instanceCollection */
        $instanceCollection = $this->appCollectionFactory->create();
        $instanceCollection->addFilter('title', $row['title']);
        if ($instanceCollection->count() > 0) {
            $skip = true;
        }

        /** @var \Magento\Cms\Model\Block $block */
        $block = $this->blockFactory->create()->load($row['block_identifier'], 'identifier');
        if (!$block) {
            $skip = true;
        }
        $widgetInstance = $this->widgetFactory->create();

        /**
         * Code can be one of:
         *  cms_page_link
         *  cms_static_block
         *  catalog_category_link
         *  new_products
         *  catalog_product_link
         *  products_list
         *  sales_widget_guestfrom
         *  recently_compared
         *  recently_viewed
         */
        $code = 'cms_static_block';

        $themePath = 'frontend/Magento/luma';
        $themeId = $this->themeCollectionFactory->create()->getThemeByFullPath($themePath)->getId();
        $type = $widgetInstance->getWidgetReference('code', $code, 'type');
        $pageGroup = [];
        $group = $row['page_group'];
        $pageGroup['page_group'] = $group;
        $pageGroup[$group] = array_merge($pageGroupConfig[$group], unserialize($row['group_data']));
        if (!empty($pageGroup[$group]['entities'])) {
            $pageGroup[$group]['entities'] = $this->getCategoryByUrlKey(
                $pageGroup[$group]['entities']
            )->getId();
        }

        $widgetInstance->setType($type)->setCode($code)->setThemeId($themeId);
        $widgetInstance->setTitle($row['title'])
                       ->setStoreIds([\Magento\Store\Model\Store::DEFAULT_STORE_ID])
                       ->setWidgetParameters(['block_id' => $block->getId()])
                       ->setPageGroups([$pageGroup]);
        $widgetInstance->save();

        /**
         * Basic example to add a new block
         */
        $exampleBlockContent = <<<EOD
<div class="example-block cms-content">
    <div class="message info">
        <span>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer 
            took a galley of type and scrambled it to make a type specimen book. 
        </span>
        <span>
            It has survived not only five centuries, but also the leap into electronic typesetting, 
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets 
            containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker 
            including versions of Lorem Ipsum.
        </span>
    </div>
</div>
EOD;

        /**
         * The full list of data keys can be found in \Magento\Cms\Api\Data\BlockInterface
         */
        $exampleBlockData = [
            BlockInterface::TITLE      => 'Example CMS block',
            // Must be unique
            BlockInterface::IDENTIFIER => 'example-cms-block',
            BlockInterface::CONTENT    => $exampleBlockContent,
            BlockInterface::IS_ACTIVE  => 1,
            // Either 0 for all sites or an array of store IDs
            'stores'                   => [0],
        ];

        $exampleBlockModel = $this->blockFactory->create();
        $exampleBlockModel->setData($exampleBlockData);
        $this->blockRepository->save($exampleBlockModel);

        $setup->endSetup();
    }
}
