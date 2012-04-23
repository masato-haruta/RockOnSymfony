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
	const ON_INIT         = 'page_flow.onInit';
	const ON_INIT_PATH    = 'page_flow.onInitPath';
	const ON_SHUTDOWN     = 'page_flow.onShutdown';
	const ON_PAGE         = 'page_flow.onPage';
	const ON_HANDLE_INPUT = 'page_flow.onHandleInput';
	// 
	const ON_PAGE_PREFIX  = 'onPage';
	const EVENT_PREFIX    = 'page_flow';

	/**
	 *
	 */
	static public function page($name)
	{
		return sprintf('%s.%s.%s', self::EVENT_PREFIX, self::ON_PAGE_PREFIX, strtolower($name));
	}
	/**
	 *
	 */
	static public function fromOnName($name)
	{
		if(preg_match('/^onPage(?P<name>.*)$/', $name, $match))
		{
			return self::page($match['name']);
		}
		else
		{
			return sprintf('%s.%s', self::EVENT_PREFIX, $name);
		}
	}
}
