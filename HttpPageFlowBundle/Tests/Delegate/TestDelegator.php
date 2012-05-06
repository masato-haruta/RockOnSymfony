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
// @namespace
namespace Rock\OnSymfony\HttpPageFlowBundle\Tests\Delegate;
// @extends
use Rock\Component\Flow\Delegate\AbstractStateDelegator;
// @use Flow Input
use Rock\Component\Flow\Input\IInput;
// @use 
use Symfony\Component\HttpKernel\Log\LoggerInterface;
// @use Aware Interface
use Rock\OnSymfony\HttpPageFlowBundle\Aware\ILoggerAware;

/**
 *
 */
class TestDelegator extends AbstractStateDelegator
  implements
    ILoggerAware
{
	protected $logger;
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function setLogger(LoggerInterface $logger)
	{
		$this->logger  = $logger;
	}
	/**
	 *
	 */
	protected function doDelete(IInput $input)
	{
		// 
		// 
		if($this->logger)
			$this->logger->info('Deleted');
		
	}
	/**
	 *
	 */
	protected function doSave(IInput $input)
	{
		// 
		if($this->logger)
			$this->logger->info(sprintf('Saved with %s', $this->getParameterBag()));
	}
}



