<?php

/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\GraphSearch;

/**
 * Path/bridge between two nodes with an optionally cost
 */
class Arc
{
    /**
     * @var Node
     */
    protected $leftNode;

    /**
     * @var Node
     */
    protected $rightNode;

    /**
     * @var callable|int
     */
    protected $cost;

    /**
     * Constructor.
     *
     * @param Node $leftNode
     * @param Node $rightNode
     * @param int|callable $cost
     */
    public function __construct(Node $leftNode, Node $rightNode, $cost = 0)
    {
        $this->leftNode = $leftNode;
        $this->rightNode = $rightNode;
        $this->cost = $cost;
    }

    /**
     * @return Node
     */
    public function getLeftNode()
    {
        return $this->leftNode;
    }

    /**
     * @return Node
     */
    public function getRightNode()
    {
        return $this->rightNode;
    }

    /**
     * @return int
     */
    public function getCost()
    {
        if (is_callable($this->cost)) {
            return $this->cost($this->leftNode, $this->rightNode);
        }

        return $this->cost;
    }
}
