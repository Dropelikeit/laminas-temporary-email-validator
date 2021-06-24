<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator\Client\ClientFactory;

use Psr\Container\ContainerInterface;
use TemporaryEmailDetection\ClientFactory;

final class Factory
{
    public function __invoke(ContainerInterface $container): ClientFactory
    {
        return new ClientFactory();
    }
}
