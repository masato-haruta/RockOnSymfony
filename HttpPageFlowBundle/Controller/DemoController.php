<?php
// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Controller;

// <Base>
use Rock\OnSymfony\HttpPageFlowBundle\Controller\FlowController as Controller;

// <Use> : Annotation
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Flow;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\FlowHandler;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\FlowVars;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

// @use Flow Handler Events 
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageEvent;
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageFlowEvent;
use Rock\OnSymfony\HttpPageFlowBundle\Event\IConstructEvent as IFlowConstructEvent;
// @use Flow Input 
use Rock\Component\Flow\Input\IInput as IFlowInput;
// @use Page for Lazy Insertion Sample
use Rock\OnSymfony\HttpPageFlowBundle\Flow\Page;
use Rock\Component\Automaton\Condition\Condition;

use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 *
 */
class DemoController extends Controller
{
	/**
	 * @Route("clear", name="rock_clear_sess")
	 */
	public function clearAction()
	{
		$this->get('session')->remove('rock.page_flow');
		return new RedirectResponse('default_index');
	}

    /**
     * @Route("/index", name="rock_demo_default")
     * @Route("/index/{state}", name="rock_demo_default_state")
     * @Template()
	 * @Flow("Default", route="rock_demo_default_state", directionOnRoute="direction", stateOnRoute="state", cleanUrl=true)
	 * @FlowHandler("onFlowInit", method="onInitIndexFlow")
	 * @FlowHandler("onPageFirst", method="onIndexFirst")
     */
    public function indexAction()
    {
        return array('name' => 'default');
    }
	
    /**
     * @Route("/test", name="rock_demo_test")
     * @Route("/test/{state}", name="rock_demo_test_state")
     * @Template("RockOnSymfonyHttpPageFlowBundle:Demo:test/{state}.html.twig")
	 * @Flow("Demo", route="rock_demo_test_state", directionOnRoute="direction", stateOnRoute="state", cleanUrl=true)
     */
    public function testAction()
    {
        return array('name' => 'default');
    }

    /**
     * @Route("/form", name="rock_demo_default_form")
     * @Route("/form/{state}", name="rock_demo_default_form_state")
     * @Template("RockOnSymfonyHttpPageFlowBundle:Demo:form/{state}.html.twig")
	 * @Flow("FormConfirmNew", route="rock_demo_default_form_state", method="post")
	 * @FlowVars({"form_type" = "Type"})
     */
	public function formAction()
	{
		return array();
	}

	/**
	 * Sample Code of Lazy Insertion of Flow-Page
	 */
	public function onInitIndexFlow(IPageFlowEvent $event)
	{
		// Add Stp into Flow
		$flow = $event->getFlow();
		$path = $flow->getPath();
		$path->addVertex($first = new Page($path, 'first'));
		$path->addVertex($second = new Page($path, 'second', array($this, 'doSecond')));
		$path->addEdge(new Condition($first, $second, array($this, 'doValidateFirst')));
	}

	/**
	 *
	 */
	public function doValidateFirst(IFlowInput $input)
	{
		return true;
	}

	/**
	 * Handler insterted by Annotation
	 */
	public function onIndexFirst(IPageEvent $event)
	{
	    $event->getFlow()->set('name', 'first');
	}

	/**
	 * Handler registed by Page
	 */
	public function doSecond(IFlowInput $input)
	{
		$this->getFlow()->set('name', 'second');
	}
}
