<?php
include('../../classes/event.php');

class Test {
    use EventTemplate;
    
    public $count = 0;
    
    /**
     * Sets two events types: event1 and event2
    */
    private $_event_default_types = array('event1','event2');
    
    /**
     * Binds the internal methods eventWelcome and eventHello to the event "event1"
     * Binds the internal method eventWorld to the event "event2"
    */
    private $_event_default_binds = array(
        'event1'=>array(
            'eventWelcome',
            'eventHello'
        ),
        'event2'=>array(
            'eventWorld'
        )
    );
    
    private function eventWelcome($event)
    {
        echo 'Welcome and ';
    }
    
    private function eventHello($event)
    {
        echo 'Hello ';
    }
    
    private function eventWorld($event)
    {
        echo 'World ';
    }
    
}

$one = new Test;
$one->fire('event1'); //Outputs Welcome and Hello
$one->fire('event2'); //Outputs World

?>