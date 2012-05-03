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
// @namespace
namespace Rock\OnSymfony\HttpPageFlowBundle\Event;

/**
 *
 */
interface IStateEvent extends IPageFlowEvent
{
	/**
	 *
	 */
	function getState();
}


