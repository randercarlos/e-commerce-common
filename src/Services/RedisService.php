<?php

namespace Ecommerce\Common\Services;

use Carbon\Carbon;
use Ecommerce\Common\Events\Event;
use Illuminate\Support\Facades\Redis;

abstract class RedisService
{
    public const ALL_EVENTS_KEY = 'events';
    public const PROCESSED_EVENTS_KEY = 'processed-events';

    abstract public function getServiceName(): string;

    public function publish(Event $event): void
    {
        Redis::xadd(self::ALL_EVENTS_KEY, '*', [
            'event' => $event->toJson(),
            'service' => $this->getServiceName(),
            'createdAt' => now()->format('Y-m-d H:i:s')
        ]);
    }

    public function getUnprocessedEvents(): array
    {
        $fromTimestamp = $this->getLastProcessedEventId();

        $allEvents = $this->getEventsAfter($fromTimestamp);

        return $this->parseEvents($allEvents);
    }

    private function getLastProcessedEventId(): string
    {
        $lastId = Redis::lindex(
            $this->getServiceName() . '-' . self::PROCESSED_EVENTS_KEY,
            -1,
        );

        return empty($lastId)
            ? (string) Carbon::now()->subYears(10)->valueOf()
            : $lastId;
    }

    public function addProcessedEvent(array $event): void
    {
        /** @phpstan-ignore-next-line */
        Redis::rpush(
            $this->getServiceName() . '-' . self::PROCESSED_EVENTS_KEY,
            $event['id'],
        );
    }

    protected function getEventsAfter(string $start): array
    {
        /** @phpstan-ignore-next-line */
        $events = Redis::xRange(
            self::ALL_EVENTS_KEY,
            $start,
            (int) Carbon::now()->valueOf()
        );

        if (!$events) {
            return [];
        }

        unset($events[$start]);

        return $events;
    }

    /**
     * @return array{type: string, data: array, id: string}
     */
    protected function parseEvents(array $eventsFromRedis): array
    {
        return collect($eventsFromRedis)
            ->map(function (array $item, string $id) {
                return array_merge(
                    json_decode($item['event'], true),
                    ['id' => $id]
                );
            })->all();
    }
}
