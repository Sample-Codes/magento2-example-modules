<?php


namespace ProjectEight\PersistenceLayerExample\Model\WhatsIt;

use ProjectEight\PersistenceLayerExample\Model\ResourceModel\WhatsIt\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * WhatsIt Collection
     *
     * @var \ProjectEight\PersistenceLayerExample\Model\ResourceModel\WhatsIt\Collection
     */
    protected $collection;

    /**
     * Data Persister
     *
     * @var DataPersistorInterface
     */
    protected $dataPersister;

    /**
     * Loaded Data
     *
     * @var \ProjectEight\PersistenceLayerExample\Model\WhatsIt[]
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string                 $name
     * @param string                 $primaryFieldName
     * @param string                 $requestFieldName
     * @param CollectionFactory      $blockCollectionFactory
     * @param DataPersistorInterface $dataPersister
     * @param array[]                $meta
     * @param string[]               $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blockCollectionFactory,
        DataPersistorInterface $dataPersister,
        $meta = [],
        $data = []
    ) {
        $this->collection    = $blockCollectionFactory->create();
        $this->dataPersister = $dataPersister;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return \ProjectEight\PersistenceLayerExample\Model\WhatsIt[]
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[ $model->getId() ] = $model->getData();
        }
        $data = $this->dataPersister->get('projecteight_persistencelayerexample_whatsit');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[ $model->getId() ] = $model->getData();
            $this->dataPersister->clear('projecteight_persistencelayerexample_whatsit');
        }

        return $this->loadedData;
    }
}
