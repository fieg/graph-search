<?php

/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\GraphSearch;

class Node
{
    /**
     * @var Node[]
     */
    protected $nodes;

    /**
     * @var Arc[]
     */
    protected $arcs;

    /**
     * @var Node
     */
    protected $parent;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * Constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->nodes = array();
        $this->arcs = array();
        $this->value = $value;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param  Node $parent
     * @return Node
     */
    protected function setParent(Node $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Node
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get the nodes' parents
     *
     * @return Node[]
     */
    public function getPath()
    {
        $path = array($this);
        $parent = $this->parent;

        while ($parent) {
            $path[] = $parent;
            $parent = $parent->getParent();
        }

        return array_reverse($path);
    }

    /**
     * @return Node[]
     */
    public function getNodes()
    {
        return array_map(
            function (Arc $arc) {
                return $arc->getRightNode();
            },
            $this->arcs
        );
    }

    /**
     * @return Arc[]
     */
    public function getArcs()
    {
        return $this->arcs;
    }

    /**
     * Get the arc between this node and a child node
     *
     * @param  Node     $rightNode
     * @return Arc|null
     */
    public function getArc(Node $rightNode)
    {
        foreach ($this->arcs as $arc) {
            if ($rightNode === $arc->getRightNode()) {
                return $arc;
            }
        }

        return null;
    }

    /**
     * Add a node
     *
     * @param  Node         $node
     * @param  int|callable $cost
     * @return Node
     */
    public function addNode(Node $node, $cost = 0)
    {
        $arc = new Arc($this, $node, $cost);

        $this->arcs[] = $arc;

        $node->setParent($this);

        $this->nodes[] = $node;

        return $node;
    }

    /**
     * Helper for fluent interface
     *
     * @return Node
     */
    public function end()
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $value = $this->value;

        if (is_array($value)) {
            $value = implode(',', array_map('strval', $value));
        }

        return (string) $value;
    }
}
