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

namespace Rock\OnSymfony\CoreBundle\HttpKernel\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle as BaseBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Bundle extends BaseBundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);

		$container->register('rock.core', 'Rock\\OnSymfony\\CoreBundle\\Rock');
	}
}
