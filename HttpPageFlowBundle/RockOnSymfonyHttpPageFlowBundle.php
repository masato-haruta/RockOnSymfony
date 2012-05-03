<?php
// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle;
// <Base> : 
use Symfony\Component\HttpKernel\Bundle\Bundle;
// <Use> : DI Container Builder
use Symfony\Component\DependencyInjection\ContainerBuilder;
// <Use> : FlowType Compiler
use Rock\OnSymfony\HttpPageFlowBundle\DependencyInjection\Compiler\FlowTypeCompilerPass;
use Rock\OnSymfony\HttpPageFlowBundle\DependencyInjection\Compiler\ContainerFilterCompilerPass;

/**
 *
 */
class RockOnSymfonyHttpPageFlowBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);

		$container->addCompilerPass(new FlowTypeCompilerPass());
		$container->addCompilerPass(new ContainerFilterCompilerPass());
	}
}
