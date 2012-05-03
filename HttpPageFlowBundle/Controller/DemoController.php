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
// <Use> : Rock Flow 
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageEvent;
use Rock\OnSymfony\HttpPageFlowBundle\Event\IConstructEvent as IFlowConstructEvent;
use Rock\Component\Flow\Input\IInput as IFlowInput;

use Symfony\Component\HttpFoundation\RedirectResponse;
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
	 * @FlowHandler("onFlowInit", method="onTestInit")
	 * @FlowHandler("onPageFirst", method="onFirstOnTest")
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
