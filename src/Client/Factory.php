<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator\Client;

use Psr\Container\ContainerInterface;
use TemporaryEmailDetection\ClientFactoryInterface;
use TemporaryEmailDetection\ClientInterface;

final class Factory
{
    public function __invoke(ContainerInterface $container): ClientInterface
    {
        /** @var ClientFactoryInterface $clientFactory */
        $clientFactory = $container->get(ClientFactoryInterface::class);

        return $clientFactory->factorize();
    }
}
