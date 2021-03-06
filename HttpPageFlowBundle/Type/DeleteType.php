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
use Rock\OnSymfony\HttpPageFlowBundle\Type\BaseType;

/**
 *
 */
class DeleteType extends BaseType 
{
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct('rock.form.template.delete');

		$this->class = '\\Rock\\OnSymfony\\HttpPageFlowBundle\\Flow\\Template\\DeleteFlow';
		$this->setAlias('Delete');
	}
	/**
	 *
	 */
	protected function configure()
	{
		// Definine Page Flow
		$this
		    ->addState('init', array($this->getReference(), 'doInitializeData'))
			->addPage('confirm', array($this->getReference(), 'doConfirm'))
			->addState('delete', array($this->getReference(), 'doDelete'))
			->addPage('complete', array($this->getReference(), 'doComplete'))
		;
	}
}


