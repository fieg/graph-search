<?php

/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\GraphSearch;

use Fieg\GraphSearch\Dumper\GraphDumper;
use Fieg\GraphSearch\Strategy\StrategyInterface;

class Graph
{
    /**
     * @var Node
     */
    protected $root;

    /**
     * @var array
     */
    protected $frontier;

    /**
     * @var Strategy\StrategyInterface
     */
    protected $strategy;

    /**
     * Constructor.
     *
     * @param StrategyInterface $strategy
     */
    public function __construct(StrategyInterface $strategy)
    {
        $this->frontier = array();
        $this->strategy = $strategy;
    }

    /**
     * Sets root node
     *
     * @param  Node  $node
     * @return Graph
     */
    public function setRoot(Node $node)
    {
        $this->root = $node;

        return $this;
    }

    /**
     * Returns root node
     *
     * @return Node
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Searches until all solutions are found
     *
     * @param  callable $goal
     * @return array
     */
    public function searchAll($goal)
    {
        $results = array();

        $frontier = null;

        while (null !== $result = $this->search($goal, $frontier)) {
            $results[] = $result;
        }

        return $results;
    }

    /**
     * Searches for the first solution
     *
     * @param  callable   $goal
     * @param  null|array $frontier
     * @return null|array
     */
    public function search($goal, &$frontier = null)
    {
        if (null === $frontier) {
            $frontier = array(
                array($this->root),
            );
        }

        while (!empty($frontier)) {
            $path = $this->strategy->selectPath($frontier);

            /** @var Node $node */
            $node = end($path);

            if ($goal($node)) {
                return $path;
            }

            $neighbors = $node->getNodes();

            foreach ($neighbors as $neighbor) {
                $newPath = $path;
                array_push($newPath, $neighbor);

                $frontier[] = $newPath;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $dumper = new GraphDumper($this);

        return $dumper->dump();
    }
}
