<?php
/**
 * This file belongs to Casechek. All rights reserved
 */

namespace Tests\AwsSecretsBundle\Provider;

use Aws\SecretsManager\SecretsManagerClient;
use AwsSecretsBundle\DependencyInjection\SecretsManagerClientFactory;
use PHPUnit\Framework\TestCase;

class SecretsManagerClientFactoryTest extends TestCase
{
    /** @test */
    public function it_throws_exception_when_no_secret_but_key_provided(): void
    {
        $this->expectExceptionMessage('Both key and secret must be provided or neither');
        $factory = new SecretsManagerClientFactory();
        $factory->createClient(
            'region',
            'latest',
            'key',
            null
        );
    }

    /** @test */
    public function it_throws_exception_when_no_key_but_secret_provided(): void
    {
        $this->expectExceptionMessage('Both key and secret must be provided or neither');
        $factory = new SecretsManagerClientFactory();
        $factory->createClient(
            'region',
            'latest',
            null,
            'secret'
        );
    }

    /** @test */
    public function it_builds_client_without_key_or_secret(): void
    {
        $factory = new SecretsManagerClientFactory();
        $client = $factory->createClient(
            'region',
            'latest',
            null,
            null
        );
        $this->assertInstanceOf(SecretsManagerClient::class, $client);
    }

    /** @test */
    public function it_builds_client_with_key_and_secret(): void
    {
        $factory = new SecretsManagerClientFactory();
        $client = $factory->createClient(
            'region',
            'latest',
            'key',
            'secret'
        );
        $this->assertInstanceOf(SecretsManagerClient::class, $client);
    }
}
