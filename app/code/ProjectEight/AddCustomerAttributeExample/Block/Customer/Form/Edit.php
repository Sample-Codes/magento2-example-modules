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
 * @package     ProjectEight_AddCustomerAttributeExample
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\AddCustomerAttributeExample\Block\Customer\Form;

/**
 * Class Edit
 *
 * Add the attribute to the My Account > Account Information > Edit Account Information form
 */
class Edit extends \Magento\Customer\Block\Form\Edit
{
    /**
     * Return the customer nickname field, if set
     *
     * @return string
     */
    public function getNickname()
    {
        $nickname = '';
        $nicknameAttribute = $this->getCustomer()->getCustomAttribute('projecteight_nickname');
        if($nicknameAttribute) {
            $nickname = $nicknameAttribute->getValue();
        }
        return $nickname;
    }
}