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

class DirectionResolver
  implements
    IDirectionResolver
{
	
	/**
	 *
	 */
	public function getKey()
	{
	}
	
	/**
	 *
	 */
	public function setKey()
	{
	}
	
	/**
	 *
	 */
	public function resolveFromRequest(Request $request)
	{
		return $request->get($this->getKey(), Directions::CURRENT);
	}
}
