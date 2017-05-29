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
 * @package     Point.php
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\AddNewApiMethod\Model;

use ProjectEight\AddNewApiMethod\Api\Data\PointInterface;

/**
 * Defines a data structure representing a point, to demonstrating passing
 * more complex types in and out of a function call.
 */
class Point implements PointInterface
{
    /**
     * The X co-ordinate
     *
     * @var float
     */
    private $x;

    /**
     * The Y co-ordinate
     *
     * @var float
     */
    private $y;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->x = 0.0;
        $this->y = 0.0;
    }

    /**
     * Get the x coordinate.
     *
     * @api
     * @return float The x coordinate.
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set the x coordinate.
     *
     *
     * @param float $value The new x coordinate.
     *
     * @api
     * @return void
     */
    public function setX($value)
    {
        $this->x = $value;
    }

    /**
     * Get the y coordinate.
     *
     * @api
     * @return float The y coordinate.
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set the y coordinate.
     *
     *
     * @param float $value The new y coordinate.
     *
     * @api
     * @return void
     */
    public function setY($value)
    {
        $this->y = $value;
    }
}