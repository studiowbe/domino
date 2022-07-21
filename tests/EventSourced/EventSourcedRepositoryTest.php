<?php

namespace Studiow\Domino\Test\EventSourced;

use PHPUnit\Framework\TestCase;
use Studiow\Domino\Event\EventStream;
use Studiow\Domino\Event\RecordedEvent;
use Studiow\Domino\EventSourced\AggregateRoot;
use Studiow\Domino\EventSourced\AggregateRootFactory;
use Studiow\Domino\EventSourced\EventSourcedRepository;
use Studiow\Domino\EventStore\EventStore;

class EventSourcedRepositoryTest extends TestCase
{
    public function test_it_stores()
    {
        $eventStore = $this->createMock(EventStore::class);
        $factory = $this->createMock(AggregateRootFactory::class);
        $root = $this->createMock(AggregateRoot::class);

        $stream = new EventStream([
            RecordedEvent::now('my-test-id', new \stdClass()),
        ]);

        $root->expects($this->once())->method('getRecordedEvents')->willReturn($stream);
        $eventStore->expects($this->once())->method('store')->with($stream);

        $repository = new EventSourcedRepository(
            $eventStore,
            $factory
        );

        $repository->store($root);
    }
}
