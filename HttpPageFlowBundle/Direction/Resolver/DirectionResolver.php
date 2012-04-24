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
