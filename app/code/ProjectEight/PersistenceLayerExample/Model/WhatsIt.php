<?php


namespace ProjectEight\PersistenceLayerExample\Model;

use ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface;

class WhatsIt extends \Magento\Framework\Model\AbstractModel implements WhatsItInterface
{

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ProjectEight\PersistenceLayerExample\Model\ResourceModel\WhatsIt');
    }

    /**
     * Get whatsit_id
     *
     * @return string
     */
    public function getWhatsitId()
    {
        return $this->getData(self::WHATSIT_ID);
    }

    /**
     * Set whatsit_id
     *
     * @param string $whatsitId
     *
     * @return \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface
     */
    public function setWhatsitId($whatsitId)
    {
        return $this->setData(self::WHATSIT_ID, $whatsitId);
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set Title
     *
     * @param string $title
     *
     * @return \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }
}
