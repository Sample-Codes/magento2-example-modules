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
 * @package     Info.php
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\AddCustomerAttributeExample\Block\Customer\Account\Dashboard\Info;

/**
 * Class Info
 *
 * Display the attribute in the My Account > Dashboard > Account Information block
 */
class Nickname extends \Magento\Customer\Block\Account\Dashboard\Info
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