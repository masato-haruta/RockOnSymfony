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
// @extends
use Rock\OnSymfony\HttpPageFlowBundle\Flow\PageFlow;
// @use Form Factory
use Symfony\Component\Form\FormFactoryInterface;
// @use Form Type
use Symfony\Component\Form\FormTypeInterface;
// @use Aware Interface to Inject FormFactory on Container
use Rock\OnSymfony\HttpPageFlowBundle\Aware\IFormFactoryAware;
// @use Flow Traversal
use Rock\Component\Flow\Traversal\ITraversalState;

/**
 *
 */
abstract class AbstractFormFlow extends PageFlow
  implements
    IFormFactoryAware
{
	// @var FormFactoryInterface
	protected $formFactory;
	protected $form;
	protected $formType;
	protected $formOptions;
	protected $formData;

	public function __construct()
	{
		parent::__construct();

		$this->form     = null;
		$this->formType = null;
		$this->formData = null;
		$this->formOptions = array();
	}
	
	/**
	 * Set form.factory from ServiceContainer
	 */
	public function setFormFactory(FormFactoryInterface $factory)
	{
		$this->formFactory = $factory;
	}
	
	/**
	 *
	 */
	public function getFormFactory()
	{
		return $this->formFactory;
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
		if($type instanceof FormTypeInterface)
		{
			$this->formType = $type;
		}
		else if(is_string($type))
		{
			$this->formType = class_exists($type) ? new $type() : $type;
		}
		else
		{
			throw new \Exception('Invalid Form Type is given.');
		}
	}

	/**
	 *
	 */
	public function getFormType()
	{
		if(!$this->formType)
			throw new \Exception('FormType is not specified.');
		return $this->formType;
	}

	/**
	 *
	 */
	public function createFormBuilder($data = null, array $options = array())
	{
		return $this->getFormFactory()->createBuilder(
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
		  $this->getFormFactory()->create($type, $data, $options);
	}

	/**
	 *
	 */
	public function getFormOptions(array $options = array())
	{
		return array_merge($this->formOptions, $options);
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


	/**
	 *
	 */
	protected function doInit(ITraversalState $traversal)
	{
		parent::doInit($traversal);

		// Get Form Parameters from Input
		$input  = $traversal->getInput();
		if($input)
		{
			if($input->has('form_type'))
			{
				$this->setFormType($input->get('form_type'));
			}
		}
	}
}
