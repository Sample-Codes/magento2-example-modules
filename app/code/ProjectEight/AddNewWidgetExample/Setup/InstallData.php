<?php

namespace ProjectEight\AddNewWidgetExample\Setup;

use Magento\Cms\Model\BlockFactory;
use Magento\Framework\App\State;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Theme\Model\ResourceModel\Theme\CollectionFactory as ThemeCollectionFactory;
use Magento\Widget\Model\ResourceModel\Widget\Instance\CollectionFactory;
use Magento\Widget\Model\Widget\InstanceFactory;

class InstallData implements InstallDataInterface
{
    /**
     * Application State
     *
     * @var State
     */
    private $appState;

    /**
     * Block Factory
     *
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * Widget Instance Collection Factory
     *
     * @var CollectionFactory
     */
    private $appCollectionFactory;

    /**
     * Widget Instance Factory
     *
     * @var InstanceFactory
     */
    private $widgetFactory;

    /**
     * Theme Collection Factory
     *
     * @var ThemeCollectionFactory
     */
    private $themeCollectionFactory;

    /**
     * Constructor
     *
     * @param State                  $appState
     * @param BlockFactory           $blockFactory
     * @param CollectionFactory      $appCollectionFactory
     * @param InstanceFactory        $widgetFactory
     * @param ThemeCollectionFactory $themeCollectionFactory
     */
    public function __construct(
        State $appState,
        BlockFactory $blockFactory,
        CollectionFactory $appCollectionFactory,
        InstanceFactory $widgetFactory,
        ThemeCollectionFactory $themeCollectionFactory
    ) {
        try {
            $appState->getAreaCode();
        } catch (\Magento\Framework\Exception\LocalizedException $exception) {
            $appState->setAreaCode(\Magento\Framework\App\Area::AREA_ADMIN);
        }

        $this->appState               = $appState;
        $this->blockFactory           = $blockFactory;
        $this->appCollectionFactory   = $appCollectionFactory;
        $this->widgetFactory          = $widgetFactory;
        $this->themeCollectionFactory = $themeCollectionFactory;
    }

    /**
     * This example adds a widget to all pages
     *
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Check the widget doesn't exist already
         */

        $title              = 'Example Widget Title';
        $blockToUseInWidget = 'contact-us-info';

        $widgetExistsAlready = false;
        /** @var \Magento\Widget\Model\ResourceModel\Widget\Instance\Collection $instanceCollection */
        $instanceCollection = $this->appCollectionFactory->create();
        $instanceCollection->addFilter('title', $title);
        if ($instanceCollection->count() > 0) {
            $widgetExistsAlready = true;
        }

        $blockDoesNotExist = false;
        /** @var \Magento\Cms\Model\Block $block */
        $block = $this->blockFactory->create()->load($blockToUseInWidget, 'identifier');
        if (!$block) {
            $blockDoesNotExist = true;
        }

        if ($widgetExistsAlready || $blockDoesNotExist) {
            $setup->endSetup();

            return;
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

        /**
         * Group can be one of:
         *  anchor_categories
         *  notanchor_categories
         *  all_products
         *  simple_products
         *  virtual_products
         *  bundle_products
         *  downloadable_products
         *  grouped_products
         *  configurable_products
         *  all_pages
         *  pages
         *  page_layouts
         */
        $group = 'all_pages';

        $themeId = $this->themeCollectionFactory->create()
                        ->getThemeByFullPath('frontend/Magento/luma')
                        ->getId()
        ;
        $type                        = $widgetInstance->getWidgetReference('code', $code, 'type');
        $pageGroupData[$group]       = [
            'block'         => 'before.body.end',
            'for'           => 'all',
            'layout_handle' => 'default',
            'template'      => 'widget/static_block/default.phtml',
            'page_id'       => '',
        ];
        $pageGroupData['page_group'] = $group;

        $widgetInstance->setType($type)
                       ->setCode($code)
                       ->setThemeId($themeId)
        ;
        $widgetInstance->setTitle($title)
                       ->setStoreIds([\Magento\Store\Model\Store::DEFAULT_STORE_ID])
                       ->setWidgetParameters(['block_id' => $block->getId()])
                       ->setPageGroups([$pageGroupData])
        ;
        // There is no repository available for saving widgets (as of 2.1.8), so use the old method instead
        $widgetInstance->save();

        $setup->endSetup();
    }
}
