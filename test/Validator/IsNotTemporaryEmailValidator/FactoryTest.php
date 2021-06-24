<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator\Test\Validator\IsNotTemporaryEmailValidator;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Config;
use Laminas\ServiceManager\ServiceManager;
use MarcelStrahl\LaminasTemporaryEmailValidator\ConfigProvider;
use MarcelStrahl\LaminasTemporaryEmailValidator\Validator\IsNotTemporaryEmailValidator;
use MarcelStrahl\LaminasTemporaryEmailValidator\Validator\IsNotTemporaryEmailValidator\Factory;
use PHPUnit\Framework\TestCase;

final class FactoryTest extends TestCase
{
    private ContainerInterface $container;

    public function setUp(): void
    {
        parent::setUp();

        $config = new ConfigProvider();

        $this->container = new ServiceManager();
        (new Config((array) $config()['dependencies']))->configureServiceManager($this->container);

        $this->container->setService('config', $config);
    }

    /**
     * @test
     */
    public function canCreateValidator(): void
    {
        $validatorFactory = new Factory();
        $validator        = $validatorFactory($this->container, IsNotTemporaryEmailValidator::class, []);

        $this->assertInstanceOf(IsNotTemporaryEmailValidator::class, $validator);
    }
}
