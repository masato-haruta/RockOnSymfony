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
