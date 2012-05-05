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

// @namespace
namespace Rock\OnSymfony\HttpPageFlowBundle\Event;
// @extend
use Symfony\Component\EventDispatcher\Event;
// @use
use Rock\Component\Flow\Builder\IFlowBuilder;

/** 
 *
 */
class FlowBuildEvent extends Event
  implements
    IConstructEvent
{
	/**
	 *
	 */
	protected $builder;

	/**
	 *
	 */
	public function __construct(IFlowBuilder $builder)
	{
		$this->builder  = $builder;
	}
	/**
	 *
	 */
	public function getBuilder()
	{
		return $this->builder;
	}
}
