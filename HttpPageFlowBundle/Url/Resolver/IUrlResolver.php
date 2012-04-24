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
namespace Rock\OnSymfony\HttpPageFlowBundle\Url\Resolver;

// <Use> : Symfony Request
use Symfony\Component\HttpFoundation\Request;

interface IUrlResolver
{
	public function resolveDirectionFromRequest(Request $request);
}
