<?php
include('../../classes/event.php');
date_default_timezone_set('UTC');

class Test {
    use EventTemplate;
    
    public $_event_default_types = array(
        'event0',
        'event1'=>'CustomEvent'
    );
    
    public function __construct()
    {
        $this->_event_set_type('event2');
        $this->_event_set_type('event3','CustomEvent');
    }
    
    public function getYmdHis()
    {
        return date('Ymd His');
    }
    
}

class CustomEvent extends Event
{
    public $ftime;
    
    public function __construct($type,&$object)
    {
        parent::__construct($type,$object);
        $this->ftime = $object->getYmdHis();
    }
}

function defaultEventHandler($event)
{
    echo $event->type.' Fired'."<br />\n";
}

function customEventHandler($event)
{
    echo $event->type.' Fired at '.$event->ftime."<br />\n";
}

$test = new Test;
$test->bind('event0','defaultEventHandler');
$test->bind('event1','customEventHandler');
$test->bind('event2','defaultEventHandler');
$test->bind('event3','customEventHandler');


$test->fire('event0');
$test->fire('event1');
$test->fire('event2');
$test->fire('event3');
?>