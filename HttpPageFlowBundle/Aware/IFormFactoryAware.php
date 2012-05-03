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
// @use
use Symfony\Component\Form\FormFactoryInterface;

/**
 *
 */
interface IFormFactoryAware
{
	/**
	 *
	 */
	function setFormFactory(FormFactoryInterface $factory);
}
