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
 * @package     PointInterface.php
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\AddNewApiMethod\Api\Data;

/**
 * Defines a data structure representing a point, to demonstrating passing
 * more complex types in and out of a function call.
 */
interface PointInterface
{
    /**
     * Get the x coordinate.
     *
     * @return float The x coordinate.
     */
    public function getX();

    /**
     * Set the x coordinate.
     *
     * @param $value float The new x coordinate.
     *
     * @return null
     */
    public function setX($value);

    /**
     * Get the y coordinate.
     *
     * @return float The y coordinate.
     */
    public function getY();

    /**
     * Set the y coordinate.
     *
     * @param $value float The new y coordinate.
     *
     * @return null
     */
    public function setY($value);
}