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

namespace ProjectEight\PersistenceLayerExample\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface WhatsItRepositoryInterface
{
    /**
     * Save WhatsIt
     *
     * @param \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface $whatsIt
     *
     * @return \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface $whatsIt
    );

    /**
     * Retrieve WhatsIt
     *
     * @param string $whatsitId
     *
     * @return \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($whatsitId);

    /**
     * Retrieve WhatsIt matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete WhatsIt
     *
     * @param \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface $whatsIt
     *
     * @return bool True on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface $whatsIt
    );

    /**
     * Delete WhatsIt by ID
     *
     * @param string $whatsitId
     *
     * @return bool True on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($whatsitId);
}
