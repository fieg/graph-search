<?php

/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\GraphSearch\Strategy;

/**
 * Strategy that sorts the frontier by cost, then picks the
 * lowest costing node first
 */
class LowestCostFirstStrategy implements StrategyInterface
{
    public function selectPath(array &$frontier)
    {
        $pathCost = function ($path) {
            $cost = 0;
            $n1 = array_shift($path);

            while($n2 = array_shift($path)) {
                $arc = $n1->getArc($n2);
                $cost += $arc->getCost();

                $n1 = $n2;
            }

            return $cost;
        };

        usort(
            $frontier,
            function ($path1, $path2) use ($pathCost) {
                return $pathCost($path1) > $pathCost($path2);
            }
        );

        return array_shift($frontier);
    }
}
