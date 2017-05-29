<?php


namespace ProjectEight\PersistenceLayerExample\Model\ResourceModel;

class WhatsIt extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('projecteight_whatsit', 'whatsit_id');
    }
}
