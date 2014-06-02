<?php

/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\GraphSearch\Strategy;

class DepthFirstStrategy implements StrategyInterface
{
    public function selectPath(array &$frontier)
    {
        return array_pop($frontier);
    }
}
