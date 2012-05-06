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
