<?php

namespace Studiow\Domino\EventStore;

use Studiow\Domino\AggregateRootIdNotFoundException;
use Studiow\Domino\Event\EventStream;

interface EventStore
{
    /**
     * @param EventStream $events
     * @return $this
     */
    public function store(EventStream $events):static;

    /**
     * @param string $aggregateRootId
     * @return EventStream
     * @throws AggregateRootIdNotFoundException
     */
    public function retrieve(string $aggregateRootId):EventStream;
}
