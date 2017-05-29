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

namespace ProjectEight\PersistenceLayerExample\Block\Adminhtml\WhatsIt\Edit;

use Magento\Backend\Block\Widget\Context;

abstract class GenericButton
{
    /**
     * Context
     *
     * @var Context
     */
    protected $context;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     */
    public function __construct(\Magento\Backend\Block\Widget\Context $context)
    {
        $this->context = $context;
    }

    /**
     * Return model ID
     *
     * @return int
     */
    public function getModelId()
    {
        return $this->context->getRequest()->getParam('whatsit_id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string   $route
     * @param   string[] $params
     *
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
