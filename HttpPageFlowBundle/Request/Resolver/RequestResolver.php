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

// <Use> : Symfony Http Request
use Symfony\Component\HttpFoundation\Request;
// <Use> : Flow HttpInput
use Rock\Components\Http\Flow\Input\Input as FlowInput;

use Rock\Components\Flow\Directions;
/**
 *
 */
class RequestResolver
{
	const DIRECTION_KEY = 'd';
	protected $directionKey;

	/**
	 *
	 */
	public function __construct()
	{
		$this->directionKey = self::DIRECTION_KEY;
	}
	/**
	 *
	 */
	public function getDirectionKey()
	{
		return $this->directionKey;
	}
	/**
	 *
	 */
	public function setDirectionKey($key)
	{
		$this->directionKey  = $key;
	}
	/**
	 *
	 */
	public function resolve(Request $request)
	{
		return new FlowInput(
			$request->get($this->getDirectionKey(), Directions::STAY), 
			$request->query->all()
		);
	}
}
