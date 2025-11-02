<?php

namespace Ecommerce\Common\Services;

use Ecommerce\Common\Exceptions\PulsarException;
use Illuminate\Support\Facades\Log;
use Pulsar\Authentication\Basic;
use Pulsar\Authentication\Jwt;
use Pulsar\Compression\Compression;
use Pulsar\Producer;
use Pulsar\ProducerOptions;
use Pulsar\MessageOptions;
use Pulsar\Consumer;
use Pulsar\ConsumerOptions;
use Pulsar\SubscriptionType;
use Pulsar\Proto\CommandSubscribe\InitialPosition;

class PulsarService
{
    private string $url;
    private string $topic;
    private ?string $authType;
    private array $authCredentials;
    const CONNECT_TIMEOUT = 5;

    public function __construct(string $url, string $topic, ?string $authType = null, array $authCredentials = [])
    {
        $this->url = $url;
        $this->topic = $topic;
        $this->authType = $authType;
        $this->authCredentials = $authCredentials;
    }

    public function createProducer(): ?Producer {
        $producer = null;

        try {
            $options = new ProducerOptions();
            $options->setConnectTimeout(self::CONNECT_TIMEOUT);
            $options->setTopic($this->topic);

            // Configuração da autenticação
            $this->setAuthentication($options);

            $producer = new Producer($this->url, $options);
            $producer->connect();

            return $producer;
        } catch(\Throwable) {
            $producer?->close();

            return null;
        }
    }

    public function produceMessage(string $message): void {
        $producer = null;

        try {
            $producer = $this->createProducer();

            if ($producer) {
                $producer->send($message);
            }

            $producer?->close();
        } catch(\Throwable) {
            $producer?->close();

            throw new PulsarException('=============== ERROR ON PRODUCE MESSAGE IN PULSAR ===============');
        }
    }

    public function consumeMessages(callable $consumerHandler): void {
        $consumer = null;

        try {
            $options = new ConsumerOptions();

            $this->setAuthentication($options);

            $options->setConnectTimeout(self::CONNECT_TIMEOUT);
            $options->setTopic($this->topic);
            $options->setSubscription(config('app.name'));
            $options->setSubscriptionType(SubscriptionType::Exclusive);

            $consumer = new Consumer($this->url, $options);
            $consumer->connect();

            while (true) {
                $message = null;

                try {
                    $message = $consumer->receive();

                    if ($message) {
                        $consumerHandler($message);

                        // confirm message was read if not occurs errors
                        $consumer->ack($message);
                    }
                } catch (\Throwable $e) {
                    // confirm message was not read if occurs error
                    $consumer->nack($message);

                    Log::error('=============== ERROR ON CONSUME MESSAGE IN PULSAR ===============');
                    Log::error($e->getMessage());
                    sleep(1);
                }
            }
        } finally {
            $consumer?->close();
        }
    }

    private function setAuthentication(ProducerOptions | ConsumerOptions $options): void {
        if ($this->authType === 'jwt' && isset($this->authCredentials['token'])) {
            $options->setAuthentication(new Jwt($this->authCredentials['token']));
        } elseif ($this->authType === 'basic' && isset($this->authCredentials['user'], $this->authCredentials['password'])) {
            $options->setAuthentication(new Basic($this->authCredentials['user'], $this->authCredentials['password']));
        }
    }
}
