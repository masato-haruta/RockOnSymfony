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
// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Flow\Template;
// <Base>
use Rock\OnSymfony\HttpPageFlowBundle\Flow\PageFlow;

/**
 *
 */
abstract class AbstractFormFlow extends PageFlow
{
	
	/**
	 * Set form.factory from ServiceContainer
	 */
	public function setFormFactory($factory)
	{
		$this->formFactory = $factory;
	}
	/**
	 *
	 */
	public function getFormFactory()
	{
		return $this->formFactory();
	}

	/**
	 *
	 */
	public function setFormData($data)
	{
		$this->formData  = $data;
	}
	/**
	 *
	 */
	public function getFormData()
	{
		return $this->formData;
	}
	/**
	 *
	 */
	public function setFormType($type)
	{
		$this->formType  = $type;
	}
	/**
	 *
	 */
	public function getFormType()
	{
		return $this->formType;
	}

	/**
	 *
	 */
	public function createFormBuilder($data = null, array $options = array())
	{
		return $this->getFormFactory()->createBuidler(
				'form',
				$data,
				$options
			);
	}

	/** 
	 * Get Form
	 */
	public function createForm($type = null, $data = null, array $options = array())
	{
		return $type ? 
		  $this->createFormBuilder($data, $options)->getForm() :
		  $this->createFormFactory()->createForm($type, $data, $options);
	}

	/**
	 *
	 */
	public function getFormBuilder()
	{
		return $this->formBuilder ?
		  $this->formBuilder :
		  ($this->formBuilder = $this->createFormBuilder($this->getFormData(), $this->getFormOptions()))
		;
	}
	/**
	 *
	 */
	public function getForm()
	{
		return $this->form ?
		  $this->form :
		  ($this->form = $this->createForm($this->getFormType(), $this->getFormData(), $this->getFormOptions()))
		;
	}
}
