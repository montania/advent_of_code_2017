<?php
require_once 'lib.php';

$input = 325489;

$number         = 1;
$steps          = 1;
$direction      = new Direction();
$position       = new Position();
$navigator      = new Navigator($input);
$incrementSteps = false;

$position->addListener([$navigator, 'calculateNeighbors']);

while ($number < $input) {
    //Sväng
    $direction->turn();

    //Gå $steps steg
    $position->move($direction, $steps);
    $number += $steps;

    printf('Number %d is at (%d,%d)' . PHP_EOL, $number, $position->getX(), $position->getY());

    if ($incrementSteps) {
        $steps++;
    }

    $incrementSteps = !$incrementSteps;
}

$tooLong = $number - $input;
$position->move($direction, -1 * $tooLong);

printf('Number %d is at (%d,%d)' . PHP_EOL, $input, $position->getX(), $position->getY());

printf('Distance to access port: %d steps', $position->getDistanceToAccessPort());