<?php

declare(strict_types=1);

namespace MarcelStrahl\LaminasTemporaryEmailValidator\Test\Validator;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use MarcelStrahl\LaminasTemporaryEmailValidator\Validator\IsNotTemporaryEmailValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TemporaryEmailDetection\Client;
use Webmozart\Assert\Assert;

use function json_encode;
use function sprintf;

final class IsNotTemporaryEmailValidatorTest extends TestCase
{
    private const REQUEST_METHOD = 'GET';

    private const API_URL = 'https://api.temporary-email-detection.de/detect/%s';

    private Client $client;

    /** @psalm-var ClientInterface&MockObject */
    private ClientInterface $guzzleClient;

    public function setUp(): void
    {
        parent::setUp();
        $this->guzzleClient = $this->createMock(ClientInterface::class);
        $this->client       = new Client($this->guzzleClient);
    }

    /**
     * Ensures that the validator follows expected behavior
     *
     * @dataProvider basicDataProvider
     */
    public function testBasic(string $email, string $content, bool $expected): void
    {
        if ($content !== '') {
            $this->guzzleClient
                ->expects(self::once())
                ->method('request')
                ->with(self::REQUEST_METHOD, sprintf(self::API_URL, $email))
                ->willReturn(new Response(200, [], $content));
        }

        $validator = new IsNotTemporaryEmailValidator($this->client, []);
        $this->assertSame($expected, $validator->isValid($email));
    }

    /**
     * @psalm-return array<string, array{
     *     0: string,
     *     1: string,
     *     2: bool
     * }>
     */
    public function basicDataProvider(): array
    {
        $temporaryEmailAddressAnswer = json_encode([
            'temporary' => true,
        ]);
        Assert::stringNotEmpty($temporaryEmailAddressAnswer);

        $nonTemporaryEmailAddressAnswer = json_encode([
            'temporary' => false,
        ]);
        Assert::stringNotEmpty($nonTemporaryEmailAddressAnswer);

        return [
            'invalid; empty string'            => [
                '',
                '',
                false,
            ],
            'invalid; non email address'       => [
                'info',
                '',
                false,
            ],
            'invalid; temporary email address' => [
                'mail@0815.ru',
                $temporaryEmailAddressAnswer,
                false,
            ],
            'valid'                            => [
                'info@marcel-strahl.de',
                $nonTemporaryEmailAddressAnswer,
                true,
            ],
        ];
    }

    public function canHandleNonStringTypes(): void
    {
        $validator = new IsNotTemporaryEmailValidator($this->client, []);
        $this->assertFalse($validator->isValid(0.01));
    }

    /**
     * @test
     */
    public function canValidatorHandleException(): void
    {
        $this->guzzleClient
            ->expects(self::once())
            ->method('request')
            ->with(self::REQUEST_METHOD, sprintf(self::API_URL, $email = 'info@marcel-strahl.de'))
            ->willReturn(new Response(200, [], 'some text'));

        $validator = new IsNotTemporaryEmailValidator($this->client, []);
        self::assertTrue($validator->isValid($email));
    }

    /**
     * @test
     */
    public function canReadMessageErrorFromTemporaryEmailAddress(): void
    {
        $temporaryEmailAddressAnswer = json_encode([
            'temporary' => true,
        ]);
        Assert::stringNotEmpty($temporaryEmailAddressAnswer);

        $this->guzzleClient
            ->expects(self::once())
            ->method('request')
            ->with(self::REQUEST_METHOD, sprintf(self::API_URL, $email = 'mail@0815.ru'))
            ->willReturn(new Response(200, [], $temporaryEmailAddressAnswer));

        $validator = new IsNotTemporaryEmailValidator($this->client, []);
        $this->assertFalse($validator->isValid($email));

        $messages = $validator->getMessages();

        $key = 'is_temporary_email';
        $this->assertArrayHasKey($key, $messages);
        $message = $messages[$key];

        $this->assertSame(
            'The e-mail provided is a temporary e-mail address and therefore not valid.',
            $message
        );
    }

    /**
     * @test
     */
    public function canReadMessageErrorFromInvalidEmailAddress(): void
    {
        $email = 'no-email';

        $validator = new IsNotTemporaryEmailValidator($this->client, []);
        $this->assertFalse($validator->isValid($email));

        $messages = $validator->getMessages();

        $key = 'is_not_temporary_email_invalid';
        $this->assertArrayHasKey($key, $messages);
        $message = $messages[$key];

        $this->assertSame(
            'Please check your input, the input does not contain a valid email address.',
            $message
        );
    }

    /**
     * @test
     */
    public function hasNoMessagesIfEmailIsValid(): void
    {
        $email = 'info@marcel-strahl.de';

        $temporaryEmailAddressAnswer = json_encode([
            'temporary' => false,
        ]);
        Assert::stringNotEmpty($temporaryEmailAddressAnswer);

        $this->guzzleClient
            ->expects(self::once())
            ->method('request')
            ->with(self::REQUEST_METHOD, sprintf(self::API_URL, $email))
            ->willReturn(new Response(200, [], $temporaryEmailAddressAnswer));

        $validator = new IsNotTemporaryEmailValidator($this->client, []);
        $this->assertTrue($validator->isValid($email));

        $this->assertEmpty($validator->getMessages());
    }
}
