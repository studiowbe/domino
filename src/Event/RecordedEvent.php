<?php

namespace Studiow\Domino\Event;

use DateTimeImmutable;
use DateTimeZone;

class RecordedEvent
{
    public function __construct(
        public readonly string $aggregateRootId,
        public readonly DateTimeImmutable $recordedAt,
        public readonly object $event
    ) {
    }

    public static function now(string $aggregateRootId, object $event):static
    {
        return  new static(
            $aggregateRootId,
            new DateTimeImmutable('now', new DateTimeZone('UTC')),
            $event
        );
    }
}
