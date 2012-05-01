<?php
// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Controller;

// <Base>
use Rock\OnSymfony\HttpPageFlowBundle\Controller\FlowController as Controller;

// <Use> : Annotation
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Flow;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// <Use> : Rock Flow 
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageEvent;
use Rock\OnSymfony\HttpPageFlowBundle\Event\IConstructEvent as IFlowConstructEvent;
use Rock\Component\Flow\Input\IInput as IFlowInput;

class DemoController extends Controller
{
    /**
     * @Route("/index", name="rock_demo_default")
     * @Route("/index/{state}", name="rock_demo_default_state")
     * @Template()
	 * @Flow("Default", route="rock_demo_default_state", directionOnRoute="direction", stateOnRoute="state", onFlowInit="onTestInit", onPageFirst="onFirstOnTest", cleanUrl=true)
     */
    public function indexAction()
    {
        return array('name' => 'default');
    }

    /**
     * @Route("/form", name="rock_demo_default_form")
     * @Route("/form/{state}", name="rock_demo_default_form_state")
     * @Template()
	 * @Flow("Form", route="rock_demo_default_form_state")
     */
	public function formAction()
	{
		return array();
	}

	/**
	 *
	 */
	public function onTestInit(IPageFlowEvent $event)
	{
		throw new \Exception();
		// Add Stp into Flow
		$flow = $event->getForm();
		$flow
		    ->addPage('first')
			->addCondition(array($this, 'doValidateFirst'))
		    ->addPage('second', array($this, 'doSecondOnTest'))
		    ->addPage('third', array($this, 'doThirdOnTest'))
		;
	}

	/**
	 *
	 */
	public function doValidateFirst(IFlowInput $input)
	{
			throw new \Exception('baa');
		return 'string';
	}

	/**
	 *
	 */
	public function onFirstOnTest(IPageEvent $event)
	{
	    $event->getFlow()->set('name', 'first');
	}

	/**
	 *
	 */
	public function doSecondOnTest(IFlowInput $input)
	{
		$this->getFlow()->set('name', 'second');
	}
	/**
	 *
	 */
	public function doThirdOnTest(IFlowInput $input)
	{
		$this->getFlow()->set('name', 'end');
	}
}
