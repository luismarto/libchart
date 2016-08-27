<?php
/* Libchart - PHP chart library
 * Copyright (C) 2005-2011 Jean-Marc Tr�meaux (jm.tremeaux at gmail.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace Libchart\Model;

use Libchart\Color\ColorHex;

/**
 * Point of coordinates (X,Y).
 * The value of X isn't really of interest, but X is used as a label to display on the horizontal axis.
 *
 * @author Jean-Marc Tr�meaux (jm.tremeaux at gmail.com)
 */
class Point
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @var ColorHex|null
     */
    private $color = null;

    /**
     * Creates a new sampling point of coordinates (x, y)
     *
     * @param integer $x coordinate (label)
     * @param integer $y coordinate (value)
     * @param string|null $hexColor Specific color for this point
     */
    public function __construct($x, $y, $hexColor = null)
    {
        $this->x = $x;
        $this->y = $y;
        if (!is_null($hexColor)) {
            $this->color = new ColorHex($hexColor);
        }
    }

    /**
     * Gets the x coordinate (label).
     *
     * @return integer x coordinate (label)
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Gets the y coordinate (value).
     *
     * @return integer y coordinate (value)
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Returns the specific color for this point
     * @return ColorHex|null
     */
    public function getColor()
    {
        return $this->color;
    }
}