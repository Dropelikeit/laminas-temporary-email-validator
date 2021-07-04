<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator\Test\Client;

use Laminas\ServiceManager\Config;
use Laminas\ServiceManager\ServiceManager;
use MarcelStrahl\LaminasTemporaryEmailValidator\Client\ClientFactory\Factory;
use MarcelStrahl\LaminasTemporaryEmailValidator\Client\Factory as LaminasClientFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use TemporaryEmailDetection\Client;
use TemporaryEmailDetection\ClientFactory;
use TemporaryEmailDetection\ClientFactoryInterface;

final class FactoryTest extends TestCase
{
    private ContainerInterface $container;

    public function setUp(): void
    {
        parent::setUp();

        $config = [
            'dependencies' => [
                'factories' => [
                    ClientFactory::class => Factory::class,
                ],
                'aliases'   => [
                    ClientFactoryInterface::class => ClientFactory::class,
                ],
            ],
        ];

        $this->container = new ServiceManager();
        (new Config($config['dependencies']))->configureServiceManager($this->container);

        $this->container->setService('config', $config);
    }

    /**
     * @test
     */
    public function canCreateClientFactory(): void
    {
        $factory = new LaminasClientFactory();

        $client = $factory($this->container);

        $this->assertInstanceOf(Client::class, $client);
    }
}
