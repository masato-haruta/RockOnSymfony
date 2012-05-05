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

// Namespace
namespace Rock\OnSymfony\HttpPageFlowBundle\Controller;

// <Base>
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// <Interface> 
use Rock\Component\Flow\IFlowContainable;
// <Use> : Flow Component
use Rock\Component\Flow\IFlow;

abstract class FlowController extends Controller
  implements
    IFlowContainable
{
	protected
		$flow;
	
	/**
	 *
	 */
	public function setFlow(IFlow $flow)
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
