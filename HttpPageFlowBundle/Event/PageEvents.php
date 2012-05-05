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

namespace Rock\OnSymfony\HttpPageFlowBundle\Event;
class PageEvents
{
	const ON_INIT         = 'page_flow.init';
	const ON_INIT_PATH    = 'page_flow.init_path';
	const ON_SHUTDOWN     = 'page_flow.shutdown';
	const ON_PAGE         = 'page_flow.page';
	const ON_HANDLE_INPUT = 'page_flow.handle_input';

	const ON_RECOVER_STATE= 'page_flow.recover';
	// 
	const ON_PAGE_PREFIX  = 'page';
	const EVENT_PREFIX    = 'page_flow';

	/**
	 *
	 */
	static public function page($name)
	{
		return sprintf('%s.%s.%s', self::EVENT_PREFIX, self::ON_PAGE_PREFIX, strtolower($name));
	}
}
