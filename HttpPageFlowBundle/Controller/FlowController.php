<?php
/************************************************************************************
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
 ************************************************************************************/
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
