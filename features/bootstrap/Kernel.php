<?php declare(strict_types=1);
/**
 * This file belongs to Bandit. All rights reserved
 */

use AwsSecretsBundle\AwsSecretsBundle;
use FriendsOfBehat\SymfonyExtension\Bundle\FriendsOfBehatSymfonyExtensionBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * Class Kernel
 * @author  Joe Mizzi <themizzi@me.com>
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * Returns an array of bundles to register.
     *
     * @return iterable|\Symfony\Component\HttpKernel\Bundle\BundleInterface An iterable of bundle instances
     */
    public function registerBundles(): iterable
    {
        return [new FrameworkBundle(), new AwsSecretsBundle(), new FriendsOfBehatSymfonyExtensionBundle()];
    }

    /**
     * Configures the container.
     *
     * You can register extensions:
     *
     * $c->loadFromExtension('framework', array(
     *     'secret' => '%secret%'
     * ));
     *
     * Or services:
     *
     * $c->register('halloween', 'FooBundle\HalloweenProvider');
     *
     * Or parameters:
     *
     * $c->setParameter('halloween', 'lot of fun');
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $c
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    protected function configureContainer(
        \Symfony\Component\DependencyInjection\ContainerBuilder $c,
        \Symfony\Component\Config\Loader\LoaderInterface $loader
    ): void {
        $c->loadFromExtension('framework', [
            'cache' => true
        ]);

        $c->loadFromExtension('aws_secrets', [
            'client_config' => [
                'region' => 'region',
                'credentials' => [
                    'key' => 'key',
                    'secret' => 'secret'
                ]
            ]
        ]);

        $c->setParameter('kernel.secret', 'S3CR3T');
        $c->setParameter('aws_secret', '%env(aws:AWS_SECRET)%');
        $c->setParameter('aws_secret_int', '%env(int:aws:AWS_SECRET)%');
    }

    public function getLogDir(): string
    {
        return __DIR__.'/../../var/log/'.$this->getEnvironment();
    }

    public function getCacheDir(): string
    {
        return __DIR__.'/../../var/cache/'.$this->getEnvironment();
    }
}
