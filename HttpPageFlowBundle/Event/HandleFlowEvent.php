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
// <Base>
use Symfony\Component\EventDispatcher\Event;

// <Use> :Flow 
use Rock\Component\Flow\IFlow;
/**
 *
 */
class HandleFlowEvent extends Event
  implements
    IPageFlowEvent
{
	/**
	 *
	 */
	protected $flow;

	/**
	 *
	 */
	public function __construct(IFlow $flow)
	{
		$this->flow  = $flow;
	}
	/**
	 *
	 */
	public function getFlow()
	{
		return $this->flow;
	}
}
