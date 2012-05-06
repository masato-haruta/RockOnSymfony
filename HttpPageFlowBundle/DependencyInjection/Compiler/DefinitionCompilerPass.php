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
namespace Rock\OnSymfony\HttpPageFlowBundle\DependencyInjection\Compiler;
// <Interface>
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class DefinitionCompilerPass 
  implements 
    CompilerPassInterface
{
	/** 
	 *
	 */
	public function process(ContainerBuilder $container)
	{
		// Get Factory Definition
		if(false === $container->hasDefinition('rock.page_flow.container'))
		{
			return;
		}
		$definition = $container->getDefinition('rock.page_flow.container');

		// Add types into Factory
		foreach($container->findTaggedServiceIds('rock.page_flow.definition') as $id => $attributes)
		{
			$definition->addMethodCall('addDefinition', array(new Reference($id)));
		}
	}
}

