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
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageEvent;

// <Use>
use Rock\Component\Flow\IFlow;
use Rock\Component\Http\Flow\IPage;

/**
 *
 */
class HandlePageEvent extends HandleStateEvent
  implements
    IPageEvent
{
	/**
	 *
	 */
	public function __construct(IFlow $flow, IPage $page)
	{
		parent::__construct($flow, $page);
	}

	/**
	 *
	 */
	public function getPage()
	{
		return $this->getState();
	}
}
