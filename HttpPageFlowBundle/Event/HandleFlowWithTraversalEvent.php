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
