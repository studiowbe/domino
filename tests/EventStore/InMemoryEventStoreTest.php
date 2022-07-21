<?php

namespace Studiow\Domino\Test\EventStore;

use PHPUnit\Framework\TestCase;
use Studiow\Domino\AggregateRootIdNotFoundException;
use Studiow\Domino\Event\EventStream;
use Studiow\Domino\Event\RecordedEvent;
use Studiow\Domino\EventStore\InMemoryEventStore;

class InMemoryEventStoreTest extends TestCase
{
    public function test_it_stores_and_retrieves()
    {
        $storage = new InMemoryEventStore();
        $id = 'my-test-id';

        $events = new EventStream([
            RecordedEvent::now($id, new \stdClass()),
        ]);

        $storage->store($events);
        $this->assertEquals($events, $storage->retrieve($id));
    }

    public function test_it_throws_exception_for_missing_id()
    {
        $storage = new InMemoryEventStore();
        $id = 'my-test-id';

        $this->expectException(AggregateRootIdNotFoundException::class);
        $this->expectExceptionMessage("Aggregate root {$id} not found");
        $storage->retrieve($id);
    }
}
