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
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageFlowEvent;
use Rock\Components\Flow\Input\IInput as IFlowInput;

class DemoController extends Controller
{
    /**
     * @Route("/index", name="rock_demo_default")
     * @Route("/index/{state}", name="rock_demo_default_state")
     * @Template()
	 * @Flow("Default", route="rock_demo_default_state", directionOnRoute="direction", stateOnRoute="state", onInit="onTestInit", onPageFirst="onFirstOnTest", cleanUrl=true)
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

	public function onTestInit(IPageFlowEvent $event)
	{
		// Get Flow Instance.
	    $flow = $event->getFlow();

		// Add Step into Flow
		$flow
		    ->setEntryPoint('first')
		    ->addNext('second', array($this, 'doSecondOnTest'))
		    ->addNext('third', array($this, 'doThirdOnTest'))
			->end()
		;
	}

	public function onFirstOnTest(IPageFlowEvent $event)
	{
	    $event->getFlow()->set('name', 'first');
	}

	public function doSecondOnTest(IFlowInput $input)
	{
		$this->getFlow()->set('name', 'second');
	}
	public function doThirdOnTest(IFlowInput $input)
	{
		$this->getFlow()->set('name', 'end');
	}
}
