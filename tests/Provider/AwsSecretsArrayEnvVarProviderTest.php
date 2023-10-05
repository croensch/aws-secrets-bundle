<?php
/**
 * This file belongs to Casechek. All rights reserved
 */

namespace Tests\AwsSecretsBundle\Provider;

use AwsSecretsBundle\Provider\AwsSecretsArrayEnvVarProvider;
use AwsSecretsBundle\Provider\AwsSecretsEnvVarProviderInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class AwsSecretsArrayEnvVarProviderTest extends TestCase
{
    use ProphecyTrait;

    private $decorated;
    private $provider;

    protected function setUp(): void
    {
        $this->decorated = $this->prophesize(AwsSecretsEnvVarProviderInterface::class);
        $this->provider = new AwsSecretsArrayEnvVarProvider($this->decorated->reveal());
    }

    /** @test */
    public function it_returns_decorated_value(): void
    {
        $this->decorated->get('key')->shouldBeCalledTimes(1)->willReturn('value');
        $result = $this->provider->get('key');
        $this->assertEquals('value', $result);
    }

    /** @test */
    public function it_returns_cached_value_on_second_call(): void
    {
        $this->decorated->get('key')->shouldBeCalledTimes(1)->willReturn('value');
        $this->provider->get('key');
        $result = $this->provider->get('key');
        $this->assertEquals('value', $result);
    }
}
