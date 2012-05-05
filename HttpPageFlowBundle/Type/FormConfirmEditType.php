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
namespace Rock\OnSymfony\HttpPageFlowBundle\Type;
// @extends
use Rock\OnSymfony\HttpPageFlowBundle\Type\AbstractFormConfirmType;

/**
 *
 */
class FormConfirmEditType extends AbstractFormConfirmType
{
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct('rock.form.template.form.confirm.edit');

		$this->setAlias('FormConfirmEdit');
	}
}

