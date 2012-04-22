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
namespace Rock\OnSymfony\HttpPageFlowBundle\EventDispatcher;
// <Base>
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
/**
 *
 */
interface IEventDispatcherAware extends EventDispatcherInterface
{
	function setEventDispatcher(EventDispatcherInterface $dispatcher);
	function getEventDispatcher();
}
