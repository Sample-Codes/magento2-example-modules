<?php


namespace ProjectEight\PersistenceLayerExample\Model\ResourceModel\WhatsIt;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
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
