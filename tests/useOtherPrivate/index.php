<?php
include('../../classes/event.php');

class Test {
    use EventTemplate;
    
    public $count = 0;
    
    public function __construct()
    {
        $this->_event_set_type('event1');
        $this->_event_set_type('event2');
    }
}

class Work {
    
    public function bindTo($obj)
    {
        $obj->bind('event1',function($event){$this->event1($event);});
        $obj->bind('event2',function($event){$this->event2($event);});
    }
    
    private function event1($event)
    {
        echo 'Hello ';
    }
    
    private function event2($event)
    {
        echo 'World ';
    }
    
}

$one = new Test;

$two = new Work;
$two->bindTo($one);

$one->fire('event1'); //Outputs Hello
$one->fire('event2'); //Outputs World

?>