<?php
/****
 *
 * Description:
 *      
 * 
 * $Date$
 * Rev    : see git
 * Author : Yoshi Aoki <yoshi@44services.jp>
 * 
 *  This file is part of the Rock package.
 *
 * For the full copyright and license information, 
 * please read the LICENSE file that is distributed with the source code.
 *
 ****/

// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Traversal;
// <Interface>
use Rock\OnSymfony\HttpPageFlowBundle\Traversal\ITraversalStack;
// <Use> : Flow State
use Rock\Component\Flow\Traversal\ITraversalState;
/**
 *
 */
class TraversalStack
  implements
    ITraversalStack
{
	protected $traversals;
	
	public function __construct()
	{
		$this->traversals  = array();
	}
	public function top()
	{
		return $this->traversals[count($this->traversals) - 1];
	}

	public function push(ITraversalState $traversal)
	{
		array_push($this->traversals, $traversal);
	}

	public function pop()
	{
		return array_pop($this->traversals);
	}

	public function count()
	{
		return count($this->traversals);
	}
}
