<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\Templating\Twig;

use eZ\Publish\Core\MVC\Legacy\Templating\Twig\Environment as BaseEnvironment;
use Netgen\Bundle\SiteBundle\Templating\Twig\DebugTemplate;
use Netgen\Bundle\SiteBundle\Templating\Twig\LegacyDebugTemplate;
use ReflectionMethod;
use Twig\Source;
use Twig\Template;

use function sprintf;
use function str_replace;

final class Environment extends BaseEnvironment
{
    public function compileSource(Source $source): string
    {
        $compiledSource = parent::compileSource($source);

        if (!$this->isDebug()) {
            return $compiledSource;
        }

        // Twig before 3.12 (the PHP 7.4 line) declares Template::getTemplateName() without a return type, and the
        // debug template has to match it; the site bundle ships a debug template for each.
        $className = DebugTemplate::class;
        if (!(new ReflectionMethod(Template::class, 'getTemplateName'))->hasReturnType()) {
            $className = LegacyDebugTemplate::class;
        }

        return str_replace(
            ' extends Template',
            sprintf(' extends %s', $className),
            $compiledSource,
        );
    }
}
