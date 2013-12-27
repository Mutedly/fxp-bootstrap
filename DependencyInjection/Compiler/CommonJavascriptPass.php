<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\BootstrapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Adds all services with the tags "sonatra_bootstrap.javascript.common" as arguments
 * of the "sonatra_bootstrap.assetic.common_javascripts_resource" service.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class CommonJavascriptPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sonatra_bootstrap.assetic.common_javascripts_resource')) {
            return;
        }

        $resources = array();

        foreach ($container->findTaggedServiceIds('sonatra_bootstrap.javascript.common') as $serviceId => $tag) {
            $resources[] = $serviceId;
        }

        $container->getDefinition('sonatra_bootstrap.assetic.common_javascripts_resource')->replaceArgument(5, $resources);
    }
}