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
namespace Rock\OnSymfony\HttpPageFlowBundle\Aware;
// @use Logger
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 *
 */
interface IContainerAware
{
	function setContainer(ContainerInterface $container);
}

