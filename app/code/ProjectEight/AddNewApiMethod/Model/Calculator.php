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
 * @package     Calculator.php
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\AddNewApiMethod\Model;

use ProjectEight\AddNewApiMethod\Api\CalculatorInterface;

class Calculator implements CalculatorInterface
{
    /**
     * Add two numbers together
     *
     * @param int $numberOne
     * @param int $numberTwo
     *
     * @return int
     */
    public function add($numberOne, $numberTwo)
    {
        $sum = $numberOne + $numberTwo;

        return $sum;
    }
}