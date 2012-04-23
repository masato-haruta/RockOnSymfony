<?php
// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Controller;

// <Base>
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rock\OnSymfony\HttpPageFlowBundle\Controller\FlowController as Controller;

// <Use> : Annotation
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Flow;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Route;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Template;
// <Use> : Rock Flow 
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageFlowEvent;

class DemoController extends Controller
{
    /**
     * @Route("/index", name="rock_demo_default")
     * @Route("/index/{state}", name="rock_demo_default_state")
     * @Template()
	 * @Flow("Form", route="rock_demo_default")
     */
    public function indexAction()
    {
        return array('name' => 'hello');
    }
    /**
     * @Route("/test", name="rock_demo_default_test")
     * @Route("/test/{state}", name="rock_demo_default_test_state")
     * @Template()
	 * @Flow("Default", route="rock_demo_default", onInit="onTestInit", onPageFirst="onFirstOnTest")
     */
	public function testAction()
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
		;

		
	}

	public function onFirstOnTest(IPageFlowEvent $event)
	{
	    $event->getFlow()->set('state', 'first');
	}

	public function doSecondOnTest(IAutomatonInput $input)
	{
		$input->getFlow()->set('state', 'second');
	}
}
