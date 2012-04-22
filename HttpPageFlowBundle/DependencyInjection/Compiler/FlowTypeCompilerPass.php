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
namespace Rock\OnSymfony\HttpPageFlowBundle\DependencyInjection\Compiler;
// <Interface>
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class FlowTypeCompilerPass 
  implements 
    CompilerPassInterface
{
	public function process(ContainerBuilder $container)
	{
		if(false === $container->hasDefinition('rock.page_flow.factory'))
		{
			return;
		}
		$definition = $container->getDefinition('rock.page_flow.factory');

		foreach($container->findTaggedServiceIds('rock.page_flow.type') as $id => $attributes)
		{
			$definition->addMethodCall('addType', array(new Reference($id)));
		}
	}
}
