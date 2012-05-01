<?php
/****
 *
 * Description:
 *      
 * $Id$
 * $Date$
 * $Rev$
 * $Author$
 * 
 *  This file is part of the $Project$ package.
 *
 * $Copyrights$
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
