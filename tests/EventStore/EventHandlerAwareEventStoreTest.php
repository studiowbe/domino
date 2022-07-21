<?php

namespace Studiow\Domino\Test\EventStore;

use PHPUnit\Framework\TestCase;
use Studiow\Domino\Event\EventHandler;
use Studiow\Domino\Event\EventStream;
use Studiow\Domino\Event\RecordedEvent;
use Studiow\Domino\EventStore\EventHandlerAwareEventStore;
use Studiow\Domino\EventStore\EventStore;

class EventHandlerAwareEventStoreTest extends TestCase
{
    public function test_it_handles_and_stores_events()
    {
        $id = 'my-test-id';
        $event = RecordedEvent::now($id, new \stdClass());

        $stream = new EventStream([
            $event,
        ]);
        $handler = $this->createMock(EventHandler::class);
        $handler->expects($this->once())->method('handle')->with($event);

        $storage = $this->createMock(EventStore::class);
        $storage->expects($this->once())->method('store')->with($stream);

        $storage = new EventHandlerAwareEventStore(
            $handler,
            $storage
        );

        $storage->store($stream);
    }
}
