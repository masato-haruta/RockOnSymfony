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
