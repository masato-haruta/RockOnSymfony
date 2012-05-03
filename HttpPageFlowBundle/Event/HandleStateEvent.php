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
