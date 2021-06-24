<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator\Client;

use Psr\Container\ContainerInterface;
use TemporaryEmailDetection\Client;
use TemporaryEmailDetection\ClientFactory;

final class Factory
{
    public function __invoke(ContainerInterface $container): Client
    {
        /** @var ClientFactory $clientFactory */
        $clientFactory = $container->get(ClientFactoryInterface::class);

        return $clientFactory->factorize();
    }
}
