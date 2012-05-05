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
namespace Rock\OnSymfony\HttpPageFlowBundle\Annotation;
// @interface
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;

/**
 * 
 * e.x.
 *    @FlowVars({"foo"="foo", "bar"="bar"})
 *
 * @Annotation
 */
class FlowVars
  implements
    ConfigurationInterface
{
	protected $values  = array();
	/**
	 *
	 */
	public function __construct(array $values)
	{
		$this->values  = array();

		// 
		foreach($values as $k => $v)
		{
			if(method_exists($this, $method='set'.ucfirst($k)))
			{
				$this->$method($v);
			}
			else
			{
				throw new \RuntimeException(sprintf('Unknown key "%s" is given for Annotation Class "%s".', $k, get_class($this)));
			}
		}
	}

	/**
	 * @param void
	 * @return void
	 */
	public function getAliasName()
	{
		return 'FlowHandler';
	}

	/**
	 * @param void
	 * @return void
	 */
	public function setValue($value)
	{
		if(is_array($value))
		{
			$this->values  = $value;
		}
		else
		{
			$this->values  = array($value);
		}
	}
	/**
	 * @param void
	 * @return void
	 */
	public function getValues()
	{
		return $this->values;
	}
}
