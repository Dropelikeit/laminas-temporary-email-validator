<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator\Client\ClientFactory;

use Psr\Container\ContainerInterface;
use TemporaryEmailDetection\ClientFactory;
use TemporaryEmailDetection\ClientFactoryInterface;

final class Factory
{
    public function __invoke(ContainerInterface $container): ClientFactoryInterface
    {
        return new ClientFactory();
    }
}
