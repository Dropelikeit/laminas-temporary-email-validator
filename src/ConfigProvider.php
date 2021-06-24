<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator;

use MarcelStrahl\LaminasTemporaryEmailValidator\Client\ClientFactory\Factory;
use MarcelStrahl\LaminasTemporaryEmailValidator\Client\ClientFactoryInterface;
use MarcelStrahl\LaminasTemporaryEmailValidator\Client\ClientInterface;
use MarcelStrahl\LaminasTemporaryEmailValidator\Validator\IsNotTemporaryEmailValidator;
use TemporaryEmailDetection\Client;
use TemporaryEmailDetection\ClientFactory;

final class ConfigProvider
{
    /**
     * Return configuration for this component.
     *
     * @return array{
     *     dependencies: array{
     *          aliases: array<class-string, class-string>,
     *          factories: array<class-string, class-string>
     *     },
     *     validators: array{factories: array<class-string, class-string>}
     * }
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
            'validators'   => $this->getValidatorConfig(),
        ];
    }

    /**
     * @psalm-return array{
     *     aliases: array<class-string, class-string>,
     *     factories: array<class-string, class-string>
     * }
     */
    public function getDependencyConfig(): array
    {
        return [
            'aliases'   => [
                ClientFactoryInterface::class => ClientFactory::class,
                ClientInterface::class        => Client::class,
            ],
            'factories' => [
                ClientFactory::class => Factory::class,
                Client::class        => \MarcelStrahl\LaminasTemporaryEmailValidator\Client\Factory::class,
            ],
        ];
    }

    /**
     * @psalm-return array{factories: array<class-string, class-string>}
     */
    public function getValidatorConfig(): array
    {
        return [
            'factories' => [
                IsNotTemporaryEmailValidator::class => IsNotTemporaryEmailValidator\Factory::class,
            ],
        ];
    }
}
