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
// <Use> : Flow Traversal
use Rock\Component\Flow\Traversal\ITraversalState;
/**
 *
 */
interface ITraversalStack
{
	/** 
	 *
	 */
	public function top();

	/** 
	 *
	 */
	public function push(ITraversalState $traversal);

	/** 
	 *
	 */
	public function pop();
}
