<?php

namespace Studiow\Domino\EventStore;

use Studiow\Domino\AggregateRootIdNotFoundException;
use Studiow\Domino\Event\EventStream;
use Studiow\Domino\Event\RecordedEvent;

class InMemoryEventStore implements EventStore
{
    private array $storage = [];

    /**
     * @param EventStream $events
     * @return $this
     */
    public function store(EventStream $events): static
    {
        array_map(function (RecordedEvent $event) {
            $this->storage[$event->aggregateRootId][] = $event;
        }, $events->toArray());

        return $this;
    }

    /**
     * @param string $aggregateRootId
     * @return EventStream
     * @throws AggregateRootIdNotFoundException
     */
    public function retrieve(string $aggregateRootId): EventStream
    {
        if (! array_key_exists($aggregateRootId, $this->storage)) {
            throw new AggregateRootIdNotFoundException(
                vsprintf(
                    'Aggregate root %s not found', [$aggregateRootId]
                )
            );
        }

        return new EventStream($this->storage[$aggregateRootId]);
    }
}
