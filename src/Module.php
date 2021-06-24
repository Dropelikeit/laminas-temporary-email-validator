<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator;

final class Module
{
    /**
     * @psalm-return array{
     *     service_manager: array{
     *          aliases: array<class-string, class-string>,
     *          factories: array<class-string, class-string>
     *     },
     *     validators: array{factories: array<class-string, class-string>}
     * }
     */
    public function getConfig(): array
    {
        $provider = new ConfigProvider();

        return [
            'service_manager' => $provider->getDependencyConfig(),
            'validators'      => $provider->getValidatorConfig(),
        ];
    }
}
