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
namespace Rock\OnSymfony\HttpPageFlowBundle\Event;
class PageEvents
{
	const ON_INIT      = 'onInit';
	const ON_INIT_PATH = 'onInitPath';
	const ON_SHUTDOWN  = 'onShutdown';

	const ON_PAGE      = 'onPage';

	static public function page($name)
	{
		return sprintf('%s.%s',self::ON_PAGE, $name);
	}
	static public function fromOnName($name)
	{
		if(preg_match('/^onPage(?<name>.*)$/', $name, $match))
		{
			$name  = self::page($match['name']);
		}

		return $name;
	}
}
