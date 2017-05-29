<?php
/**
 * ProjectEight
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact ProjectEight for more information.
 *
 * @category    AddNewApiMethod
 * @package     webapi.xml
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\PersistenceLayerExample\Api\Data;

interface WhatsItSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get WhatsIt list.
     *
     * @return \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface[]
     */
    public function getItems();

    /**
     * Set Title list.
     *
     * @param \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
