<?php

namespace Studiow\Domino\EventSourced;

use Studiow\Domino\EventStore\EventStore;

class EventSourcedRepository implements AggregateRootRepository
{
    public function __construct(
        protected readonly EventStore $eventStore,
        protected readonly AggregateRootFactory $aggregateRootFactory
    ) {
    }

    /**
     * @param AggregateRoot $aggregateRoot
     * @return $this
     */
    public function store(AggregateRoot $aggregateRoot): static
    {
        $this->eventStore->store($aggregateRoot->getRecordedEvents());

        return $this;
    }

    /**
     * @param string $id
     * @return AggregateRoot
     * @throws \Studiow\Domino\AggregateRootIdNotFoundException
     */
    public function fromId(string $id): AggregateRoot
    {
        return $this->aggregateRootFactory->create(
            $id, $this->eventStore->retrieve($id)
        );
    }
}
