<?php

trait EventTemplate
{
    private $_event_types = array();
    private $_event_binds = array();
    
    public function bind($type,$action)
    {
        if(!in_array($type,$this->_event_types))
        {
            throw new Exception('Type not defined');
        }
        if(!isset($this->_event_binds[$type]) || !is_array($this->_event_binds[$type])) $this->_event_binds[$type] = array();
        $this->_event_binds[$type][] = $action;
        return true;
    }
    
    public function unbind($type,$action)
    {
        if(!in_array($action,$this->_event_binds[$type]))
            return false;
        unset($this->_event_binds[$type][array_search($action,$this->_events_binds)]);
        return true;
    }
    
    public function fire($type)
    {
        $this->_event_fire($type);
    }
    
    private function _event_set_type($type)
    {
        $this->_event_types[] = $type;
    }
    
    private function _event_fire($type)
    {
        $event = new Event($type,$this);
        foreach($this->_event_binds[$type] as $bind)
        {
            if(is_callable($bind))
                $this->_event_fire_closure($bind,$event);
            elseif(is_string($bind))
                $this->_event_fire_string($bind,$event);
        }
    }
    
    private function _event_fire_string($string,&$event)
    {
        call_user_func($string,$event);
    }
    
    private function _event_fire_closure($closure,&$event)
    {
        $closure($event);
    }
}

class Event
{
    public $type;
    public $object;
    public $microtime;
    
    public function __construct($type,&$object)
    {
        $this->type = $type;
        $this->object = &$object;
        $this->microtime = microtime(true);
    }
}

?>