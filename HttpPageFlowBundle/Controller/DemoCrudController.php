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
namespace Rock\OnSymfony\HttpPageFlowBundle\Controller;
// @extends
use Rock\OnSymfony\HttpPageFlowBundle\Controller\FlowController as Controller;
// @use Annotation
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
// @use HttpResponse
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Conceptual Demo CRUD with PageFlow
 *
 * CAUTION:
 *   This Controller is not worked proper.
 *  
 */
class DemoCrudController extends Controller
{
	/**
	 * Index Action
	 *
	 * @Route("/");
	 * @Template()
	 */
	public function indexAction()
	{
		// Your Code Here 
		return array();
	}
	
	/**
	 * Index Action
	 *
	 * @Route("/{id}");
	 * @Template()
	 */
	public function detailAction()
	{
		// Your Code Here 
		return array();
	}

	/**
	 * Create Actions
	 * 
	 * @Route("/new", name="demo_new");
	 * @Route("/new/{state}", name="demo_new_state");
	 * @Template("Bundle:Controller:create/{state}.html.twig")
	 * @Flow("FormConfirm", route="demo_new_state")
	 * @FlowVars({"form_type" = "Path\To\Form\Type"})
	 * @FlowDelegate("save", delegator="DoctrineDelegator", method="doInsert")
	 */
	public function createAction()
	{
		return array();
	}

	/**
	 * Edit Actions
	 * 
	 * @Route("/edit", name="demo_edit");
	 * @Route("/edit/{state}", name="demo_edit_state");
	 * @Template("Bundle:Controller:edit/{state}.html.twig")
	 * @Flow("FormConfirm", route="demo_edit_state")
	 * @FlowVars({"form_type" = "Path\To\Form\Type"})
	 * @FlowHandler("onStateInit", method="onInitTargetData")
	 * @FlowDelegate("save", delegator="DoctrineDelegator", method="doUpdate")
	 */
	public function editAction()
	{
		return array();
	}
	
	/**
	 * Delete Actions
	 * 
	 * @Route("/delete", name="demo_delete");
	 * @Route("/delete/{state}", name="demo_delete_state");
	 * @Template("Bundle:Controller:delete/{state}.html.twig")
	 * @Flow("DataConfirm", route="demo_delete_state")
	 * @FlowHandler("onStateInit", method="onInitTargetData")
	 * @FlowDelegate("confirmed", delegator="DoctrineDelegator", method="doDelete")
	 */
	public function deleteAction()
	{
		return array();
	}

	/**
	 * Handler on State "init" for Edit and Delete
	 */
	public function onInitTargetData(IStateEvent $state)
	{
		$flow  = $state->getFlow();
		// 
		if(!($request = $state->getInput()->getHttpRequest()))
		{
			throw new FlowRuntimeException('HttpRequest is required, but not given', $flow);
		}

		// Hope, either one of below code can get your id. 
		$id   = $request->query->get('your_get_id');
		$id   = $request->request->get('your_post_id')

		// E.x) get repository
		$em     = $this->getEntityManager();
		$repos  = $em->getRepository('Bundle:Entity');
		if(!($entity = $repos->findOneById($id)))
		{
			throw new FlowRuntimeException('Target Data is not exists.', $flow);
		}

		// 
		if($flow instanceof IFormFlow)
		{
			// Set entity into your Form data.
			$flow->setFormData($entity);
		}
		else if($flow instanceof IDataFlow)
		{
			$flow->setData($entity);
		}
		else
		{
			// Do not anything with this data.
		}
	}
}

