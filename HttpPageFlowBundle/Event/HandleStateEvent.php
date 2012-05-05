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
// <Interface>
use Rock\OnSymfony\HttpPageFlowBundle\Event\IStateEvent;

// <Use>
use Rock\Component\Flow\IFlow;
use Rock\Component\Flow\Graph\State\IState;

/**
 *
 */
class HandleStateEvent extends HandleFlowEvent
  implements
    IStateEvent
{
	protected $state;
	/**
	 *
	 */
	public function __construct(IFlow $flow, IState $state)
	{
		parent::__construct($flow);

		$this->state = $state;
	}

	/**
	 *
	 */
	public function getState()
	{
		return $this->state;
	}
}
