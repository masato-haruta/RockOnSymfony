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
use Rock\OnSymfony\HttpPageFlowBundle\Event\IFlowEvent;

class DemoController extends Controller
{
    /**
     * @Route("/", name="rock_demo_default")
     * @Route("/{state}", name="rock_demo_default_state")
     * @Template()
	 * @Flow("Form", route="rock_demo_default", onInit="onIndexInit")
     */
    public function indexAction()
    {
        return array('name' => 'hello');
    }

	public function onIndexInit(IFlowEvent $event)
	{
		// Get Flow Instance.
	    $flow = $event->getFlow();

		// Add Step into Flow
		$flow
		    ->setEntryPoint('first', array($this, 'doFirstOnIndex'))
		    ->addNext('second', array($this, 'doSecondOnIndex'))
		;
	}

	public function doFirstOnIndex(IFlowEvent $event)
	{
			throw new \Exception('Here');
	    $event->output->setParameter('name', 'first');
	}

	public function doSecondOnIndex(IFlowEvent $event)
	{
		$event->output->setParameter('name', 'second');
		// FlowController provide simple access to the output 
	    //$this->output['name']  = 'second';
	}
}
