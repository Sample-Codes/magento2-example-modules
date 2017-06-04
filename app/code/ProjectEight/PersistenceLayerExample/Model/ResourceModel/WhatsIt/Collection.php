<?php


namespace ProjectEight\PersistenceLayerExample\Model\ResourceModel\WhatsIt;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Primary Key
     *
     * @var string
     */
    protected $_idFieldName = 'whatsit_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'ProjectEight\PersistenceLayerExample\Model\WhatsIt',
            'ProjectEight\PersistenceLayerExample\Model\ResourceModel\WhatsIt'
        );
    }
}
