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
namespace Rock\OnSymfony\HttpPageFlowBundle\Delegate;
// @extends
use Rock\Component\Flow\Delegate\AbstractStateDelegator;
// @interface
use Rock\OnSymfony\HttpPageFlowBundle\Aware\IEntityManagerCollectionAware;
use Rock\OnSymfony\HttpPageFlowBundle\Aware\IContainerAware;
// @use Flow input
use Rock\Component\Flow\Input\IInput;
// @use Symfony Container
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 */
class DoctrineDelegator extends AbstractStateDelegator
  implements
	IEntityManagerCollectionAware,
	IContainerAware
{
	protected $ems= array();
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		$this->ems  = array();
	}

	public function setEntityManagerCollection(array $ems)
	{
		$this->ems  = $ems;
	}

	public function setContainer(ContainerInterface $container)
	{
		$this->container  = $container;
	}
	/**
	 *
	 */
	public function getEntityManager()
	{
		$name  = $this->getParameterBag()->get('EntityManager', 'default');

		if(!array_key_exists($name, $this->ems))
			throw new \Exception(sprintf('EntityManager "%s" is not Defined.', $name));

		return $this->container->get($this->ems[$name]);
	}

	/**
	 *
	 */
	protected function doSave(IInput $input)
	{
		$em      = $this->getEntityManager();
		$invoker = $this->getInvoker();

		// 
		$form    = $invoker->getFlow()->getForm();
		$data    = $form->getData();
		$em->persist($data);
		$em->flush();
	}
	/**
	 *
	 */
	protected function doDelete(IInput $input)
	{
		$em      = $this->getEntityManager();
		$invoker = $this->getInvoker();

throw new \Exception(get_class($em));
		// 
		$data    = $form->getData();
		$em->remove($data);
		$em->flush();
	}
}


