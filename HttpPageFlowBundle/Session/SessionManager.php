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
// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Session;
// <Base>
use Rock\Components\Http\Flow\Session\SessionManager as BaseManager;

// <Use> : Symfony Session
use Symfony\Component\HttpFoundation\Session;

/**
 *
 */
class SessionManager extends BaseManager
{
	const SESS_KEY = 'rock.page_flow';
	/**
	 *
	 */
	protected $session;

	/**
	 *
	 */
	public function __construct(Session $session)
	{
		$this->session  = $session;

		$this->load();
	}

	public function load()
	{
		$this->sessions = array();

		$values = $this->session->get(self::SESS_KEY);
		if($values && is_array($values))
		{
		    foreach($values as $key => $value)
		    {
		    	// 
		    	$this->sessions[$key] = $this->createSession($value);
		    }
		}
	}

	protected function doMount(array $sessions)
	{
		$this->session->set(self::SESS_KEY, $sessions);
	}
	protected function doUnmount()
	{
		$this->session->remove(self::SESS_KEY);
	}
}

