<?php

/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

use Fieg\GraphSearch\Node;
use Fieg\GraphSearch\Graph;
use Fieg\GraphSearch\Strategy\DepthFirstStrategy;
use Fieg\GraphSearch\Strategy\BreathFirstStrategy;
use Fieg\GraphSearch\Strategy\LowestCostFirstStrategy;

class GraphTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $graph = new \Fieg\GraphSearch\Graph(new DepthFirstStrategy());

        $this->assertInstanceOf('\Fieg\GraphSearch\Graph', $graph);
    }

    public function graphProvider()
    {
        return array(
            array(
                new Graph(new BreathFirstStrategy()),
            ),
            array(
                new Graph(new DepthFirstStrategy()),
            ),
            array(
                new Graph(new LowestCostFirstStrategy()),
            ),
        );
    }

    /**
     * @param Graph $graph
     * @dataProvider graphProvider
     */
    public function testSearch($graph)
    {
        $goalNode = new Node("some value");
        $node2 = new Node("n2");
        $node3 = new Node("n3");
        $node4 = new Node("n4");
        $node5 = new Node("n5");
        $node6 = new Node("n6");
        $node7 = new Node("n7");
        $node8 = new Node("n8");
        $node9 = new Node("n9");

        $rootNode = new Node('root');
        $rootNode
            ->addNode($node2, rand(1,4))
                ->addNode($node5, rand(1,4))
                    ->addNode($node7, rand(1,4))->end()
                    ->addNode($node8, rand(1,4))->end()
                    ->addNode($node9, rand(1,4))->end()
                    ->addNode($node7, rand(1,4))->end()
                    ->addNode($node3, rand(1,4))->end()
                ->end()
                ->addNode($node6, rand(1,4))->end()
            ->end()
            ->addNode($node3, rand(1,4))
                ->addNode($node4, rand(1,4))
                    ->addNode($goalNode, rand(1,4))->end()
                ->end()
            ->end()
        ;

        $graph->setRoot($rootNode);

        $goal = function (Node $n) use ($graph) {
            return ('some value' === $n->getValue());
        };

        $path = $graph->search($goal);

        $this->assertEquals(
            array(
                $rootNode,
                $node3,
                $node4,
                $goalNode
            ),
            $path
        );
    }
}
