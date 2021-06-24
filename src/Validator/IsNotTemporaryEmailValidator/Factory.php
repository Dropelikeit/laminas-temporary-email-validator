<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator\Validator\IsNotTemporaryEmailValidator;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use MarcelStrahl\LaminasTemporaryEmailValidator\Client\ClientInterface;
use MarcelStrahl\LaminasTemporaryEmailValidator\Validator\IsNotTemporaryEmailValidator;
use TemporaryEmailDetection\Client;

final class Factory implements FactoryInterface
{
    /**
     * @param string $requestedName
     * @param array|null $options
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): IsNotTemporaryEmailValidator {
        /** @var Client $client */
        $client = $container->get(ClientInterface::class);

        return new IsNotTemporaryEmailValidator($client, $options);
    }
}
