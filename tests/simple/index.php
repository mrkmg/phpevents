<?php
include('../../classes/event.php');

class Test {
    use EventTemplate;
    
    public function __construct()
    {
        $this->_event_set_type('event');
    }
    
}

function love($event)
{
    echo 'Hello ';
}

$one = new Test;
$one->bind('event','love');
$one->bind('event',function($event){ echo 'World';});


$one->fire('event');



?>