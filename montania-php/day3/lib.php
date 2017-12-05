<?php

class Direction
{
    private $direction = 3;

    const RIGHT = 0;
    const UP = 1;
    const LEFT = 2;
    const DOWN = 3;

    public function turn()
    {
        $this->direction++;
    }

    public function getDirection()
    {
        return $this->direction % 4;
    }
}

class Position
{
    private $x = 0;
    private $y = 0;
    private $listeners = [];

    public function addListener(callable $callback)
    {
        $this->listeners[] = $callback;
    }

    private function notify()
    {
        foreach ($this->listeners as $listener) {
            call_user_func($listener, $this);
        }
    }

    public function move(Direction $direction, $offset)
    {
        for ($stepsTaken = 0; $stepsTaken < $offset; $stepsTaken++) {
            switch ($direction->getDirection()) {
                case Direction::RIGHT:
                    $this->x += 1;
                    break;

                case Direction::UP:
                    $this->y += 1;
                    break;

                case Direction::LEFT:
                    $this->x -= 1;
                    break;

                case Direction::DOWN:
                    $this->y -= 1;
                    break;
            }
            $this->notify();
        }

    }

    public function getDistanceToAccessPort()
    {
        return abs($this->x) + abs($this->y);
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }
}

class Navigator
{
    private $map = ['0,0' => 1];
    private $input;

    public function __construct($input)
    {
        $this->input = $input;

    }

    public function calculateNeighbors(Position $position)
    {
        $sum = 0;
        for($x = -1; $x <= 1; $x++){
            for($y = -1; $y <= 1; $y++){
                $index = ($position->getX() + $x) .',' . ($position->getY() + $y);
                $sum += intval($this->map[$index]);
            }
        }
        $myIndex = ($position->getX()) .',' . ($position->getY());
        $this->map[$myIndex] = $sum;
    }


}