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
 * @category    m2-example-modules.localhost.com
 * @package     AbstractTemplate.php
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\AddCustomerAttributeExample\Plugin\Magento\Email\Model;

class AbstractTemplate
{
    /**
     * Inject custom attributes of customer into email template variables array.
     * You can then use the attributes in transactional emails like so:
     * <p class="greeting">{{var projecteight_nickname}}</p>
     *
     * Or to include the attribute in a translated string:
     * <p class="greeting">{{trans "Hello %projecteight_nickname," projecteight_nickname=$projecteight_nickname}}</p>
     *
     * @param \Magento\Email\Model\AbstractTemplate $subject
     * @param string[]                              $variables
     *
     * @return string[]
     */
    public function beforeGetProcessedTemplate(
        \Magento\Email\Model\AbstractTemplate $subject,
        array $variables = []
    ) {
        if(array_key_exists('customer', $variables)) {

            $customer = $variables['customer'];
            foreach ($customer->getCustomAttributes() as $customAttribute) {
                $variables[$customAttribute['attribute_code']] = $customAttribute['value'];
            }
        }

        return [$variables];
    }
}