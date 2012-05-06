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
namespace Rock\OnSymfony\HttpPageFlowBundle\Flow\Template;
// @extends
use Rock\OnSymfony\HttpPageFlowBundle\Flow\PageFlow;

/**
 *
 */
abstract class AbstractDeleteFlow extends PageFlow
{
	/**
	 * @var mixin Data
	 */
	protected $data;

	/**
	 * @param
	 * @return
	 */
	public function setData($data)
	{
		$this->data = $data;
	}

	/**
	 * @param
	 * @return
	 */
	public function getData()
	{
		return $this->data;
	}

}
