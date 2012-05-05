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
namespace Rock\OnSymfony\HttpPageFlowBundle\Event;

//
use Rock\Component\Flow\IFlow;
use Rock\Component\Flow\Traversal\ITraversalState;
/**
 *
 */
class HandleFlowWithTraversalEvent extends HandleFlowEvent
{
	protected $traversal;

	public function __construct(IFlow $flow, ITraversalState $traversal)
	{
		parent::__construct($flow);

		$this->traversal  = $traversal;
	}

	public function getTraversal()
	{
		return $this->traversal;
	}
}
