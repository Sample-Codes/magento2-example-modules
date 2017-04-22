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
use ProjectEight\AddNewApiMethod\Api\Data\PointInterface;
use ProjectEight\AddNewApiMethod\Api\Data\PointInterfaceFactory;

class Calculator implements CalculatorInterface
{
    /**
     * Factory for creating new Point instances. This code will be automatically
     * generated because the type ends in "Factory".
     *
     * @var PointInterfaceFactory
     */
    private $pointFactory;

    /**
     * Constructor.
     *
     * @param PointInterfaceFactory $pointFactory Factory for creating new Point instances.
     */
    public function __construct(PointInterfaceFactory $pointFactory)
    {
        $this->pointFactory = $pointFactory;
    }

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

    /**
     * Sum an array of numbers.
     *
     * @param float[] $numbers The array of numbers to sum.
     *
     * @return float The sum of the numbers.
     */
    public function sum($numbers)
    {
        $total = 0.0;
        foreach ($numbers as $number) {
            $total += $number;
        }

        return $total;
    }

    /**
     * Compute mid-point between two points.
     *
     * @param PointInterface $pointOne The first point.
     * @param PointInterface $pointTwo The second point.
     *
     * @return PointInterface The mid-point.
     */
    public function midPoint($pointOne, $pointTwo)
    {
        $point = $this->pointFactory->create();
        $point->setX(($pointOne->getX() + $pointTwo->getX()) / 2.0);
        $point->setY(($pointOne->getY() + $pointTwo->getY()) / 2.0);

        return $point;
    }
}