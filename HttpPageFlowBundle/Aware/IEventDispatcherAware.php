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
namespace Rock\OnSymfony\HttpPageFlowBundle\Aware;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
/**
 *
 */
interface IEventDispatcherAware
{
	function setEventDispatcher(EventDispatcherInterface $dispatcher);
}
