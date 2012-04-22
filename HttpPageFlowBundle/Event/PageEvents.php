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
	const ON_INIT      = 'flow.onInit';
	const ON_INIT_PATH = 'flow.onInitPath';
	const ON_SHUTDOWN  = 'flow.onShutdown';

	const ON_PAGE      = 'flow.onPage';

	static public function page($name)
	{
		return sprintf('%s.%s',self::ON_PAGE, $name);
	}
}
