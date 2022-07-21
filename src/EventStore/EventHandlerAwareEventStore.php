<?php

namespace Studiow\Domino\EventStore;

use Studiow\Domino\AggregateRootIdNotFoundException;
use Studiow\Domino\Event\EventHandler;
use Studiow\Domino\Event\EventStream;
use Studiow\Domino\Event\RecordedEvent;

class EventHandlerAwareEventStore implements EventStore
{
    public function __construct(
        protected readonly EventHandler $eventHandler,
        protected readonly EventStore $storage
    ) {
    }

    /**
     * @param EventStream $events
     * @return $this
     */
    public function store(EventStream $events): static
    {
        array_map(function (RecordedEvent $event) {
            $this->eventHandler->handle($event);
        }, $events->toArray());

        $this->storage->store($events);

        return $this;
    }

    /**
     * @param string $aggregateRootId
     * @return EventStream
     * @throws AggregateRootIdNotFoundException
     */
    public function retrieve(string $aggregateRootId): EventStream
    {
        return $this->storage->retrieve($aggregateRootId);
    }
}
