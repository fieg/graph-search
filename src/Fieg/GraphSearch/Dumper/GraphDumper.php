<?php
/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\GraphSearch\Dumper;

use Fieg\GraphSearch\Graph;
use Fieg\GraphSearch\Node;

class GraphDumper
{
    /**
     * @var Graph
     */
    protected $graph;

    /**
     * Constructor.
     *
     * @param Graph $graph
     */
    public function __construct(Graph $graph)
    {
        $this->graph = $graph;
    }

    /**
     * Dumps graph
     *
     * @param  null|Node $node
     * @return string
     */
    public function dump($node = null)
    {
        if (null === $node) {
            $node = $this->graph->getRoot();
        }

        return $this->doDump($node);
    }

    /**
     * @param  Node   $parent
     * @param  int    $padding
     * @param  bool   $omega
     * @param  string $prefix
     * @return string
     */
    protected function doDump(Node $parent, $padding = 0, $omega = false, $prefix = '')
    {
        $retval = '';

        $xprefix = $prefix;

        if ($omega) {
            $prefix =  $prefix . '└──';
        } else {
            if ($padding > 0) {
                $prefix =  $prefix . '├──';
            }
        }

        $retval .= sprintf("%s%s\n", $prefix ? $prefix . ' ': '', (string) $parent);

        $prefix = $xprefix; // reset

        $children = $parent->getNodes();
        $count = count($children);

        if ($padding > 0) {
            if ($omega) {
                $prefix = $prefix . '    ';
            } else {
                $prefix = $prefix . '│   ';
            }
        }

        foreach ($children as $n => $node) {
            $omega = (($count - 1) === $n);

            $retval .= $this->doDump($node, $padding + 1, $omega, $prefix);
        }

        return $retval;
    }
}
