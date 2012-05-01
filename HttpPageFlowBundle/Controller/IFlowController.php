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
 *  This file is part of the $project$ package.
 *
 *  Copyright (c) 2009, 44services.jp. Inc. All rights reserved.
 *  For the full copyright and license information, please read LICENSE file
 *  that was distributed w/ source code.
 *
 *  Contact Us : Yoshi Aoki <yoshi@44services.jp>
 *
 ************************************************************************************/
namespace Rock\OnSymfony\HttpPageFlowBundle\Controller;

// <Use> : Flow Component
use Rock\Component\Flow\IFlow;
/**
 *
 */
interface IFlowController
{
	/**
	 *
	 */
	public function setFlow(IFlow $flow);

	/**
	 *
	 */
	public function getFlow();
}
