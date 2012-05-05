<?php
/****
 *
 * Description:
 *      
 * 
 * $Date$
 * Rev    : see git
 * Author : Yoshi Aoki <yoshi@44services.jp>
 * 
 *  This file is part of the Rock package.
 *
 * For the full copyright and license information, 
 * please read the LICENSE file that is distributed with the source code.
 *
 ****/

// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Session;
// <Base>
use Rock\Component\Http\Flow\Session\SessionManager as BaseManager;

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

