<?php


namespace Lobster\Events;


use Lobster\Events\ListenerProvider;
use Lobster\Events\ErrorFactoryInterface as Factory;
use Psr\EventDispatcher\StoppableEventInterface as Stoppable;


/**
 * Class Dispatcher
 * @package Lobster\Events
 */
class ImmutableDispatcher extends Dispatcher
{
    public function __clone()
    {
        foreach ($this->providers as $name => $provider)
        {
            $this->providers[$name] = clone $provider;
        }
    }

    /**
     * @param string $name
     * @return EventDispatcher
     */
    public function detach(string $name) : EventDispatcher
    {
        unset(($dispatcher = clone $this)->providers[$name]);
        return $dispatcher;
    }
    
    /**
     * @param ListenerProvider $provider
     * @return EventDispatcher
     */
    public function attach(ListenerProvider $provider) : EventDispatcher 
    {
        ($dispatcher = clone $this)->providers[$provider->getName()] = $provider;
        return $dispatcher;
    }
}