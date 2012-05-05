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

// @namespace
namespace Rock\OnSymfony\HttpPageFlowBundle\Event;

/**
 *
 */
class PageFlowEvents
{
	// 
	const EVENT_PREFIX    = 'page_flow';
	// 
	const PAGE            = 'page';
	const STATE           = 'state';
	const FLOW            = 'flow';
	const BUILDER         = 'builder';

	/**
	 *
	 */
	static public function on($name)
	{
		return sprintf('%s.%s', self::EVENT_PREFIX, $name);
	}
	/**
	 *
	 */
	static public function onFlow($name)
	{
		return self::on(sprintf('%s.%s', self::FLOW, $name));
	}

	/**
	 *
	 */
	static public function onPage($name)
	{
		return self::on(sprintf('%s.%s', self::PAGE, $name));
	}

	/**
	 *
	 */
	static public function onState($name)
	{
		return self::on(sprintf('%s.%s', self::STATE, $name));
	}

	/**
	 *
	 */
	static public function onBuilder($name)
	{
		return self::on(sprintf('%s.%s', self::BUILDER, $name));
	}
}
