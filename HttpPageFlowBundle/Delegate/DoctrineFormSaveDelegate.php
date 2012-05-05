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
namespace Rock\OnSymfony\HttpPageFlowBundle\Delegate;


class DoctrineFormSaveDelegator extends AbstractFlowStateDelegator
{
	protected function doDelegate(IInput $input)
	{
		$em      = $this->getEntityManager();
		$invoker = $this->getInvoker();

		// 
		$form    = $invoker->getForm();
		$data    = $form->getData();
		$em->persist($data);
		$em->flush();
	}
}
