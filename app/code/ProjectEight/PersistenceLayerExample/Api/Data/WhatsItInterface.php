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
 * @category    PersistenceLayerExample
 * @package     WhatsItInterface
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\PersistenceLayerExample\Api\Data;

interface WhatsItInterface
{
    const TITLE = 'Title';
    const WHATSIT_ID = 'whatsit_id';

    /**
     * Get whatsit_id
     *
     * @return string
     */
    public function getWhatsitId();

    /**
     * Set whatsit_id
     *
     * @param string $whatsitId
     *
     * @return \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface
     */
    public function setWhatsitId($whatsitId);

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set Title
     *
     * @param string $title
     *
     * @return \ProjectEight\PersistenceLayerExample\Api\Data\WhatsItInterface
     */
    public function setTitle($title);
}
