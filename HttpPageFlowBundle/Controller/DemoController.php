<?php
// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Controller;

// <Base>
use Rock\OnSymfony\HttpPageFlowBundle\Controller\FlowController as Controller;

// <Use> : Annotation
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Flow;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\FlowDelegate;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\FlowHandler;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\FlowVars;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

// @use Flow Handler Events 
use Rock\OnSymfony\HttpPageFlowBundle\Event\IStateEvent;
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageFlowEvent;
use Rock\OnSymfony\HttpPageFlowBundle\Event\IConstructEvent as IFlowConstructEvent;
use Rock\OnSymfony\HttpPageFlowBundle\Event\PageFlowOutputFilterEvent;
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
	 * @Route("/partial", name="rock_demo_pertial")
	 * @Route("/pertial/{state}", name="rock_demo_pertial_state")
	 * @Template("RockOnSymfonyHttpPageFlowBundle:Demo:test/{state}.html.twig")
	 * @Flow("Default", route="rock_demo_test_state", directionOnRoute="direction", stateOnRoute="state", cleanUrl=true)
	 */
	public function partialAction()
	{
		return array('name' => 'default');
	}
	
    /**
     * @Route("/basic", name="rock_flow_demo_basic")
     * @Route("/basic/{state}", name="rock_flow_demo_basic_state")
     * @Template("RockOnSymfonyHttpPageFlowBundle:Demo:basic/{state}.html.twig")
	 * @Flow("Demo", route="rock_demo_basic_state", directionOnRoute="direction", stateOnRoute="state", cleanUrl=true)
     */
    public function basicAction()
    {
        return array('name' => 'default');
    }

    /**
     * @Route("/delete", name="rock_demo_default_delete")
     * @Route("/delete/{state}", name="rock_demo_default_delete_state")
     * @Template("RockOnSymfonyHttpPageFlowBundle:Demo:delete/{state}.html.twig")
	 * @Flow("Delete", route="rock_demo_default_delete_state", method="post")
	 * @FlowHandler("onStateInit", method="onStateInitForDelete")
	 * @FlowDelegate("delete", delegator="TestDelegator", method="doDelete")
     */
	public function deleteAction()
	{
		// Do Any action for all page in flow 
		return array();
	}
	public function onStateInitForDelete(IStateEvent $event)
	{
	}
    /**
     * @Route("/form", name="rock_demo_default_form")
     * @Route("/form/{state}", name="rock_demo_default_form_state")
     * @Template("RockOnSymfonyHttpPageFlowBundle:Demo:form/{state}.html.twig")
	 * @Flow("FormConfirm", route="rock_demo_default_form_state", method="post")
	 * @FlowVars({"form_type_type"="class", "form_type"="Rock\OnSymfony\HttpPageFlowBundle\Tests\Form\TestFormType"})
	 * @FlowHandler("onPageConfirmFilterOutput")
	 * @FlowHandler("onStateInit", method="onStateInitForForm")
	 * @FlowDelegate("save", delegator="TestDelegator", method="doInsert", vars={"EntityManager"="default"})
     */
	public function formAction()
	{
		// Do Any action for all page in flow 
		return array();
	}
	public function onStateInitForForm(IStateEvent $event)
	{
		//throw new \Exception('init');
	}

	public function onPageConfirmFilterOutput(PageFlowOutputFilterEvent $event)
	{
		$output = $event->getOutput();
		
		$formData   = $output->get('form');
		
		$formData['sample'] = 'Confirm Filter["'.$formData['sample'].'"]';
		$output->set('form', $formData);
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
	 * Sample Code of Lazy Insertion of Flow-Page
	 */
	public function onInitIndexFlow(IPageFlowEvent $event)
	{
		// Add Step into Flow
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
	public function onIndexFirst(IStateEvent $event)
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
