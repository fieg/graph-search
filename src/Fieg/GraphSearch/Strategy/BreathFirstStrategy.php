<?php

/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\GraphSearch\Strategy;

class BreathFirstStrategy implements StrategyInterface
{
    public function selectPath(array &$frontier)
    {
        return array_shift($frontier);
    }
}
