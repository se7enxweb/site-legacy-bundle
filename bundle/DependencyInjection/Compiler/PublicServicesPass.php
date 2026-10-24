<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\DependencyInjection\Compiler;

use eZ\Publish\SPI\Persistence\Handler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Makes the services required by the ngsymfonytools and ezplatformsearch legacy extensions public.
 */
class PublicServicesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ($container->has('router')) {
            $container->findDefinition('router')
                ->setPublic(true);
        }

        if ($container->has('fragment.handler')) {
            $container->findDefinition('fragment.handler')
                ->setPublic(true);
        }

        if ($container->has('security.authorization_checker')) {
            $container->findDefinition('security.authorization_checker')
                ->setPublic(true);
        }

        if ($container->has('ezpublish.api.repository')) {
            $container->findDefinition('ezpublish.api.repository')
                ->setPublic(true);
        }

        if ($container->has(Handler::class)) {
            $container->findDefinition(Handler::class)
                ->setPublic(true);
        }

        // The ezplatformsearch legacy search plugin (1.2, the eZ namespace release) fetches
        // these from the container when the legacy kernel searches or indexes content.
        foreach (['ezpublish.spi.search', 'ezpublish.api.storage_engine'] as $serviceId) {
            if ($container->has($serviceId)) {
                $container->findDefinition($serviceId)
                    ->setPublic(true);
            }
        }
    }
}
