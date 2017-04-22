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

namespace ProjectEight\AddNewApiMethod\Api;

use ProjectEight\AddNewApiMethod\Api\Data\PointInterface;

interface CalculatorInterface
{
    /**
     * Add two numbers together
     *
     * @param int $numberOne
     * @param int $numberTwo
     *
     * @return int
     */
    public function add($numberOne, $numberTwo);

    /**
     * Sum an array of numbers.
     *
     * @param float[] $numbers The array of numbers to sum.
     *
     * @return float The sum of the numbers.
     */
    public function sum($numbers);

    /**
     * Compute mid-point between two points.
     * Note: Do not import these class names, or Magento 2 will not be able to work out which class to use
     *
     * @param ProjectEight\AddNewApiMethod\Api\Data\PointInterface $pointOne The first point.
     * @param ProjectEight\AddNewApiMethod\Api\Data\PointInterface $pointTwo The second point.
     *
     * @return ProjectEight\AddNewApiMethod\Api\Data\PointInterface The mid-point.
     */
    public function midPoint($pointOne, $pointTwo);
}