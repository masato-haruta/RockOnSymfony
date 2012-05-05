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
	// 
	const TYPE_CLASS  = 'class';
	const TYPE_STRING = 'string';

	// @var FormFactoryInterface
	protected $formTypeType;
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
		$this->formOptions  = array();
		$this->formTypeType = false;
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

		if(!($session = $this->getSession()))
			throw new \Exception('Session is not specified on Execution.');
		$this->getSession()->set('form_data', $data);
	}

	/**
	 *
	 */
	public function getFormData()
	{
		if(!$this->formData)
		{
			if($this->getSession()->has('form_data'))
			{
				$this->formData = $this->getSession()->get('form_data');
			}
		}
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
			switch($this->getFormTypeType())
			{
			case self::TYPE_CLASS:
				$this->formType = new $type();
				break;
			case self::TYPE_STRING:
				$this->formType = $type;
				break;
			default:
				$this->formType = class_exists($type) ? new $type() : $type;
				break;
			}

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

	public function setFormTypeType($type)
	{
		$this->formTypeType = $type;
	}
	public function getFormTypeType()
	{
		return $this->formTypeType;
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
		  $this->getFormFactory()->create($type, $data, $options) :
		  $this->createFormBuilder($data, $options)->getForm() ;
	}

	/**
	 *
	 */
	public function getFormOptions(array $options = array())
	{
		return array_merge($this->formOptions, $options, array('csrf_protection' => false));
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
			if($input->has('form_type_type'))
				$this->setFormTypeType($input->get('form_type_type'));
			if($input->has('form_type'))
			{
				$this->setFormType($input->get('form_type'));
			}
		}
	}
}
