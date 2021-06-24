<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator\Test\Client\ClientFactory;

use Laminas\ServiceManager\ServiceManager;
use MarcelStrahl\LaminasTemporaryEmailValidator\Client\ClientFactory\Factory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use TemporaryEmailDetection\ClientFactory;

final class FactoryTest extends TestCase
{
    private ContainerInterface $container;

    public function setUp(): void
    {
        parent::setUp();

        $this->container = new ServiceManager();
    }

    /**
     * @test
     */
    public function canCreateClientFactory(): void
    {
        $factory = new Factory();

        $clientFactory = $factory($this->container);

        $this->assertInstanceOf(ClientFactory::class, $clientFactory);
    }
}
