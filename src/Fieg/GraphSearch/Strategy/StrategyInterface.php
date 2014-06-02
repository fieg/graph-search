<?php

/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\GraphSearch\Strategy;

use Fieg\GraphSearch\Node;

interface StrategyInterface
{
    /**
     * @param array $frontier
     * @return Node[]
     */
    public function selectPath(array &$frontier);
}
