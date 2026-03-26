<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\DependencyInjection\Compiler;

use eZ\Bundle\EzPublishCoreBundle\Imagine\VariationPathGenerator\OriginalDirectoryVariationPathGenerator;
use eZ\Bundle\EzPublishCoreBundle\Imagine\VariationPurger\ImageFileVariationPurger;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ImageVariationPass implements CompilerPassInterface
{
    /**
     * Overrides built in Ibexa image variation purgers and path generators
     * to use ones specific for legacy.
     */
    public function process(ContainerBuilder $container): void
    {
        $container->setAlias(
            'ezpublish.image_alias.variation_purger',
            ImageFileVariationPurger::class,
        );

        $container->setAlias(
            'ezpublish.image_alias.variation_path_generator',
            OriginalDirectoryVariationPathGenerator::class,
        );
    }
}
