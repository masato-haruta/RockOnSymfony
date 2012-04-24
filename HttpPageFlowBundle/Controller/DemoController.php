<?php
// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Controller;

// <Base>
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rock\OnSymfony\HttpPageFlowBundle\Controller\FlowController as Controller;

// <Use> : Annotation
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Flow;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// <Use> : Rock Flow 
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageFlowEvent;

class DemoController extends Controller
{
    /**
     * @Route("/index", name="rock_demo_default")
     * @Route("/index/{state}", name="rock_demo_default_state")
     * @Template()
	 * @Flow("Default", route="rock_demo_default_state", onInit="onTestInit", onPageFirst="onFirstOnTest")
     */
    public function indexAction()
    {
        return array('name' => 'hello');
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
