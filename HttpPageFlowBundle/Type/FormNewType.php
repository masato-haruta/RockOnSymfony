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
namespace Rock\OnSymfony\HttpPageFlowBundle\Type;
// @extends
use Rock\OnSymfony\HttpPageFlowBundle\Type\AbstractFormType;

/**
 *
 */
class FormNewType extends AbstractFormType
{
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct('rock.form.template.form.new');

		$this->setAlias('FormNew');
	}
}
