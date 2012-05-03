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
use Rock\OnSymfony\HttpPageFlowBundle\Type\AbstractFormConfirmType;

/**
 *
 */
class FormConfirmNewType extends AbstractFormConfirmType
{
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct('rock.form.template.form.confirm.new');

		$this->setAlias('FormConfirmNew');
	}
}
