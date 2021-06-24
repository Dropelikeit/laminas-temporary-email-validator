<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator\Validator;

use Exception;
use Laminas\Validator\AbstractValidator;
use TemporaryEmailDetection\Client;

use function filter_var;
use function is_string;

use const FILTER_VALIDATE_EMAIL;

final class IsNotTemporaryEmailValidator extends AbstractValidator
{
    private Client $client;

    private const ERROR_INVALID_EMAIL   = 'is_not_temporary_email_invalid';
    private const ERROR_TEMPORARY_EMAIL = 'is_temporary_email';

    protected array $messageTemplates = [
        self::ERROR_INVALID_EMAIL   => 'Please check your input, the input does not contain a valid email address.',
        self::ERROR_TEMPORARY_EMAIL => 'The e-mail provided is a temporary e-mail address and therefore not valid.',
    ];

    public function __construct(Client $client, ?array $options = null)
    {
        parent::__construct($options);
        $this->client = $client;
    }

    public function isValid($value): bool
    {
        $this->setValue($value);

        if (! is_string($value) || ! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->error(self::ERROR_INVALID_EMAIL);
            return false;
        }

        try {
            $isValid = $this->client->isTemporary($value);
        } catch (Exception) {
            return true;
        }

        if ($isValid) {
            $this->error(self::ERROR_TEMPORARY_EMAIL);
            return false;
        }

        return true;
    }
}
