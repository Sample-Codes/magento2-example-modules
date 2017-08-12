<?php

namespace ProjectEight\AddNewCmsBlockExample\Setup;

use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

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
     * Constructor
     *
     * @param BlockFactory            $blockFactory
     * @param BlockRepositoryInterface $blockRepository
     */
    public function __construct(BlockFactory $blockFactory, BlockRepositoryInterface $blockRepository)
    {
        $this->blockFactory    = $blockFactory;
        $this->blockRepository = $blockRepository;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
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
            BlockInterface::TITLE           => 'Example CMS block',
            // Must be unique
            BlockInterface::IDENTIFIER      => 'example-cms-block',
            BlockInterface::CONTENT         => $exampleBlockContent,
            BlockInterface::IS_ACTIVE       => 1,
            // Either 0 for all sites or an array of store IDs
            'stores'                       => [\Magento\Store\Model\Store::DEFAULT_STORE_ID],
        ];

        $exampleBlockModel = $this->blockFactory->create();
        $exampleBlockModel->setData($exampleBlockData);
        $this->blockRepository->save($exampleBlockModel);

        $setup->endSetup();
    }
}
