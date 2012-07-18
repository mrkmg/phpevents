phpevents
=========
***phpevents is a simple trait and class to add events into PHP (5.4+).***

Concept
-------

Each class that you wish to enable events on "uses" the EventTemplate trait. That trait includes all the methods needed to set event types, bind functions the events, and fire those events. A class defines its own events. When an event is fired, the function(s) tied to that event are ran and passed an Event Object. The Event Object contains 3 public properties: $type (Name of the type of event), $object (the object that the event was fired on), $microtime (A float representation of the microtime the event occured)

Usage
-----

Using phpevents is quite simple.

1. Include events.php
2. Put "use EventTemplate;" in each class you wish to enable events on
3. Somewhere in the class (usually __construct), set the available event types with the private method _event_set_type()
4. Bind functions to the that objects event via the public method bind()
5. Use the public method fire to fire an event, causing all bound functions to be ran.


Examples
--------

There are currently 4 examples/tests. They are are in the tests folder. Here is a simple breakdown of what each on is.

[defineInConstruct](https://github.com/mrkmg/phpevents/blob/master/tests/defineInConstruct/index.php)

This example/test shows how to define the event types and bind internal methods of that class to those events.

[simple](https://github.com/mrkmg/phpevents/blob/master/tests/simple/index.php)

This example/test shows how to bind both a global function and an anonymous function to an objects events.

[useOtherPrivate](https://github.com/mrkmg/phpevents/blob/master/tests/useOtherPrivate/index.php)

This example/test shows how to bind one objects events to another objects private methods

[logging](https://github.com/mrkmg/phpevents/blob/master/tests/logging/index.php)

This is a practical example of how these events could be used. This is a **very** simple example of how logging could be tied to a model object. 


Future
------

Everything conceptual right now, and anything and everything could be changed.