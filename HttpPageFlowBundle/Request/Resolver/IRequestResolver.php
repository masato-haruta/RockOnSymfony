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
namespace Rock\OnSymfony\HttpPageFlowBundle\Request\Resolver;
// <Use>
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
interface IRequestResolver
{
	/**
	 *
	 */
	public function resolveInput(Request $request);

	/**
	 *
	 */
	public function resolveRequestQuery();
}
