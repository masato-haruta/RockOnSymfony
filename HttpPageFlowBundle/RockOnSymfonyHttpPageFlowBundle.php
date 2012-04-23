<?php
// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle;
// <Base> : 
use Symfony\Component\HttpKernel\Bundle\Bundle;
// <Use> : DI Container Builder
use Symfony\Component\DependencyInjection\ContainerBuilder;
// <Use> : FlowType Compiler
use Rock\OnSymfony\HttpPageFlowBundle\DependencyInjection\Compiler\FlowTypeCompilerPass;

/**
 *
 */
class RockOnSymfonyHttpPageFlowBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);

		$container->addCompilerPass(new FlowTypeCompilerPass());
	}
}
