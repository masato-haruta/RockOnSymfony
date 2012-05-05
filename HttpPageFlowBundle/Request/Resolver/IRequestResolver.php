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
