<?php
/**
 * @copyright 2018 Hostnet B.V.
 */
declare(strict_types=1);

namespace Hostnet\Component\Resolver\Plugin;

use Hostnet\Component\Resolver\Builder\AbstractBuildStep;
use Hostnet\Component\Resolver\Builder\Step\CssFontRewriteStep;
use Hostnet\Component\Resolver\Builder\Step\IdentityBuildStep;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @covers \Hostnet\Component\Resolver\Plugin\CssFontRewritePlugin
 */
class CssFontRewritePluginTest extends TestCase
{
    use ProphecyTrait;

    public function testActivate(): void
    {
        $css_font_rewite_plugin = new CssFontRewritePlugin();

        $plugin_api = $this->prophesize(PluginApi::class);
        $plugin_api->addBuildStep(Argument::type(CssFontRewriteStep::class))->shouldBeCalled();
        $plugin_api->addBuildStep(Argument::that(function (AbstractBuildStep $step) {
            return $step instanceof IdentityBuildStep
                && \in_array($step->acceptedExtension(), ['.otf', '.ttf', '.woff', '.woff2', '.eot', '.svg'], true);
        }))->shouldBeCalled();

        $css_font_rewite_plugin->activate($plugin_api->reveal());
    }
}
