<?php
namespace Classes\Games\Battleship;

/**
 * Created by PhpStorm.
 * User: kcavi
 * Date: 14.03.2019
 * Time: 1:34
 */
class BattleShip
{
    protected $map = array();
    protected $totalTargets = 0;
    protected $shots = 0;
    protected $shipPositions = array();

    static $ships = [];
    static $spaces = [];
    static $orientation = array('horizontal', 'vertical');
    static $verticalDirection = array('left', 'right');
    static $horizontalDirection = array('up', 'down');
    static $MAP_X;
    static $MAP_Y;
    const LEFT = 'left';
    const RIGHT = 'right';
    const HORIZONTAL = 'horizontal';
    const VERTICAL = 'vertical';
    const UP = 'up';
    const DOWN = 'down';

    /**
     * Generate a new map, calculate the targets on the map
     * and populate the map with targets
     */
    public function __construct($ships = []) {

        // Set value of X and Y coordinates
        static::$MAP_X = config('map_x');
        static::$MAP_Y = config('map_y');

        $this
            ->setShips($ships)
            ->calculateMaxTargets()
            ->generateMap()
            ->populateMap();
    }

    /**
     * Map::map accessor
     * @return array The map matrix
     */
    public function getMatrix() {
        return $this->map;
    }

    /**
     * Map::totalTargets accessor
     * @return integer Amount of remaining targets on the map
     */
    public function getTargetCount() {
        return $this->totalTargets;
    }

    /**
     * @param array $ships
     * @return $this
     * Set ships with sizes
     */
    public function setShips($ships = [])
    {
        self::$ships = $ships;
        return $this;
    }

    /**
     * @return $this
     * Calculate max number of targets based on sizes of ships
     */
    public function calculateMaxTargets() {
        foreach(self::$ships as $shipSize)
            $this->totalTargets += $shipSize;
        return $this;
    }

    /**
     * @return $this
     * Generate 10x10 board matrix
     */
    public function generateMap() {
        for($y = 0; $y < static::$MAP_Y; $y++) {
            for($x = 0; $x < static::$MAP_X; $x++) {
                $this->map[$y][$x] = 0;
            }
        }

        return $this;
    }

    /**
     * @return $this
     * Populate matrix set ship squares to 1
     */
    public function populateMap() {
        foreach(static::$ships as $shipSize)
            $this->addToMap($shipSize);
        return $this;
    }

    /**
     * @param $shipSize
     * @return int
     * If ship size is less than 5 it will minus 1 from coordinates else it will minus 2. If it is an L ship
     * then we need to minus 2 otherwise ship will go out of board.
     */
    public function minusFromCoordinate($shipSize)
    {
        return ($shipSize <= 4) ? 1 : 2;
    }

    /**
     * @param $shipSize
     * @return bool
     * Place ship on board matrix and return true if placed
     */
    public function addToMap($shipSize) {
        while(true) {
            $minusFromCoorfinate = $this->minusFromCoordinate($shipSize);
            $position = $this->getRandomEmptyCoordinate($minusFromCoorfinate);
            $orientation = $this->getRandomOrientation();
            $direction = $this->getRandomDirection($orientation);
            if($this->canPositionShipAt($shipSize, $position, $direction)) {
                $this->positionShipAt($shipSize, $position, $direction);
                return true;
            }
        }
    }

    /**
     * @param $shipSize
     * @param array $position
     * @param $direction
     * @return bool
     * Check if a ship can be placed at a position
     */
    public function canPositionShipAt($shipSize, Array $position, $direction) {
        list($y, $x) = $position;
        $minusFromCoordinate = $this->minusFromCoordinate($shipSize);
        for($i = 0; $i < $shipSize; $i++) {
            switch($direction) {
                case self::LEFT:
                    if($this->isOccupiedCoordinate($y, $x - $i, $minusFromCoordinate)) return false;
                    break;
                case self::RIGHT:
                    if($this->isOccupiedCoordinate($y, $x + $i, $minusFromCoordinate)) return false;
                    break;
                case self::UP:
                    if($this->isOccupiedCoordinate($y - $i, $x, $minusFromCoordinate)) return false;
                    break;
                case self::DOWN:
                    if($this->isOccupiedCoordinate($y + $i, $x, $minusFromCoordinate)) return false;
            }
        }
        return true;
    }

    /**
     * Fills an array of positions based on ship size, starting coordinate
     * and direction
     * @param  integer $shipSize  The size of the ship
     * @param  Array   $position  Contains coordinates (usually random generated)
     * @param  string  $direction One of four directions (left, right, up, down)
     * @return boolean            Always return true, automatically assuming the
     *                            positions were available
     */
    public function positionShipAt($shipSize, Array $position, $direction) {
        list($y, $x) = $position;
        $shipId = sizeof($this->shipPositions);

        for($i = 0; $i < $shipSize; $i++) {
            switch($direction) {
                case self::LEFT:
                    $newY = $y; $newX = $x - $i;
                    if($shipSize >= 5 && $i==4)
                    {
                        $newY = $y+1;
                        $newX = $x-$i+1;
                    }
                    break;
                case self::RIGHT:
                    $newY = $y; $newX = $x + $i;
                    if($shipSize >= 5 && $i==4)
                    {
                        $newY = $y+1;
                        $newX = $x+$i-1;
                    }
                    break;
                case self::UP:
                    $newY = $y - $i; $newX = $x;
                    if($shipSize >= 5 && $i==4)
                    {
                        $newX = $x+1;
                        $newY = $y-$i+1;
                    }
                    break;
                case self::DOWN:
                    $newY = $y + $i; $newX = $x;
                    if($shipSize >= 5 && $i==4)
                    {
                        $newX = $x+1;
                        $newY = $y+$i-1;
                    }

            }
            $this->fillCoordinate($newY, $newX);
            $this->fillSpaces($newY, $newX);
            $this->shipPositions[$shipId][] = array($newY, $newX);
        }
        return true;
    }

    /**
     * Checks if a certain coordinate is available
     * @param  integer  $y The Y coordinate
     * @param  integer  $x The X Coordinate
     * @return boolean     If the position equals 0, return true
     */
    public function isOccupiedCoordinate($y, $x, $minus) {
        if(($x < 0 || $x > self::$MAP_X - $minus || $y < 0 || $y > self::$MAP_Y - $minus) &&
            (
                isset(self::$spaces[$y][$x])
                || isset(self::$spaces[$y][$x-1])
                || isset(self::$spaces[$y][$x+1])

                || isset(self::$spaces[$y-1][$x])
                || isset(self::$spaces[$y-1][$x+1])
                || isset(self::$spaces[$y-1][$x-1])

                || isset(self::$spaces[$y+1][$x])
                || isset(self::$spaces[$y+1][$x-1])
                || isset(self::$spaces[$y+1][$x+1])
            )
        )
            return true;
        return 0 !== $this->map[$y][$x];
    }

    /**
     * Change the value of certain coordinate to 1
     * @param  integer  $y The Y coordinate
     * @param  integer  $x The X Coordinate
     * @return integer     Always return 1
     */
    public function fillCoordinate($y, $x) {
        return $this->map[$y][$x] = 1;
    }

    /**
     * @param $y
     * @param $x
     * Fill spaces around a ship
     */
    public function fillSpaces($y, $x) {
        self::$spaces[$y][$x] = 3;
        self::$spaces[$y][$x-1] = 3;
        self::$spaces[$y][$x+1] = 3;

        self::$spaces[$y-1][$x] = 3;
        self::$spaces[$y-1][$x-1] = 3;
        self::$spaces[$y-1][$x+1] = 3;

        self::$spaces[$y+1][$x] = 3;
        self::$spaces[$y+1][$x-1] = 3;
        self::$spaces[$y+1][$x+1] = 3;


    }

    /**
     * Returns a random direction based on orientation, being it
     * either vertical or horizontal
     * @param  string $orientation vertical|horizontal
     * @return string              left|right for horizontal, up|down for vertical
     */
    public function getRandomDirection($orientation)
    {
        if(self::HORIZONTAL === $orientation)
            return self::$horizontalDirection[rand(0,1)];
        return self::$verticalDirection[rand(0,1)];
    }

    /**
     * Picks an orientation randomly
     * @return string horizontal|vertical
     */
    public function getRandomOrientation() {
        return self::$orientation[rand(0,1)];
    }

    /**
     * Coorindate generator
     * @return array  X/Y coordinate container of a spot that equals 0
     */
    public function getRandomEmptyCoordinate($minus) {
        while(true) {

            $randX = rand(0, static::$MAP_X - $minus);
            $randY = rand(0, static::$MAP_Y - $minus);

            if(
                $this->map[$randX][$randY] === 0
                && !isset(self::$spaces[$randY][$randX])
                && !isset(self::$spaces[$randY][$randX-1])
                && !isset(self::$spaces[$randY][$randX+1])

                && !isset(self::$spaces[$randY-1][$randX])
                && !isset(self::$spaces[$randY-1][$randX+1])
                && !isset(self::$spaces[$randY-1][$randX-1])

                && !isset(self::$spaces[$randY+1][$randX])
                && !isset(self::$spaces[$randY+1][$randX-1])
                && !isset(self::$spaces[$randY+1][$randX+1])
            )
            {
                return array($randY, $randX);
            }
        }
    }

    /**
     * Shoot at a X/Y coordinate by increasing its value with 2
     * @param  integer  $y The Y coordinate
     * @param  integer  $x The X Coordinate
     * @return mixed 	   Returns on of the following values, based on result
     *                       2 - shot went thru, missed a target
     *                       3 - shot went thru, hit a target
     *                       4 - shot went thru, sank a ship
     *                       false - location has been shot at already
     *                       true - game over, all targets are down
     */
    public function shoot($y, $x) {
        $state = (int) $this->map[$y][$x];
        $shipSunk = false;
        switch($state) {
            case 0:
                $this->shots++;
                break;
            case 1:
                $this->shots++;
                $this->totalTargets--;
                $shipSunk = $this->sunkShip($y, $x);
                break;
            case 2:
            case 3:
                return false;
        }
        $newState = $this->map[$y][$x] += 2;
        $newState = true === $shipSunk ? 4 : $newState;
        if(0 === $this->totalTargets)
            return true;
        return $newState;
    }

    /**
     * Checks if a ship has sank
     * @param  integer  $y The Y coordinate
     * @param  integer  $x The X Coordinate
     * @return boolean     True if the ship has sank, false otherwise
     */
    public function sunkShip($y, $x) {
        //var_export($this->shipPositions); die;
        foreach($this->shipPositions as $shipId => $shipPosition) {
            // skip ships that have already sunk
            if(0 === sizeof($shipPosition))
                continue;
            foreach($shipPosition as $positionId => $position) {
                list($shipY, $shipX) = $position;
                if($shipY == $y && $shipX == $x) {
                    unset($this->shipPositions[$shipId][$positionId]);
                    return 0 === sizeof($this->shipPositions[$shipId]);
                }
            }
        }
        return false;
    }

    /**
     * Map::$shots accessor
     * @return integer Amount of shots spent in the game
     */
    public function getShotCount() {
        return $this->shots;
    }
}