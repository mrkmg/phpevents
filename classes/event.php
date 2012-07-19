<?php

trait EventTemplate
{
    protected $_event_types = array();
    protected $_event_binds = array();
    protected $_event_defaults_processed = false;
    
    public function bind($type,$action)
    {
        $this->_event_check_defaults();
        return $this->_event_bind($type,$action);
    }
    
    public function unbind($type,$action)
    {
        $this->_event_check_defaults();
        if(!key_exists($action,$this->_event_binds))
            return false;
        unset($this->_event_binds[$type][array_search($action,$this->_events_binds)]);
        return true;
    }
    
    public function fire($type)
    {
        $this->_event_check_defaults();
        $this->_event_fire($type);
    }
    
    private function _event_bind($type,$action)
    {
        if(!key_exists($type,$this->_event_types))
        {
            throw new Exception('Type not defined');
        }
        if(!isset($this->_event_binds[$type]) || !is_array($this->_event_binds[$type])) $this->_event_binds[$type] = array();
        $this->_event_binds[$type][] = $action;
        return true;
    }
    
    private function _event_check_defaults()
    {
        if(!$this->_event_defaults_processed) $this->_event_process_defaults();
    }
    
    private function _event_set_type($type,$class="Event")
    {
        $this->_event_types[$type] = $class;
    }
    
    private function _event_fire($type)
    {
        $event = new $this->_event_types[$type]($type,$this);
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
    
    private function _event_process_defaults()
    {
        if(isset($this->_event_default_types))
        {
            foreach($this->_event_default_types as $type=>$class)
            {
                if(is_int($type))
                {
                    $type = $class;
                    $class = "Event";
                }
                $this->_event_set_type($type,$class);
            }
        }
        if(isset($this->_event_default_binds))
        {
            foreach($this->_event_default_binds as $event=>$methods)
            {
                foreach($methods as $method)
                {
                    $this->_event_bind($event,function($event) use($method){$this->{$method}($event);});
                }
            }
        }
        $this->_event_defaults_processed = true;
    }
}

class Event
{
    public $type;
    public $object;
    public $microtime;
    public $backtrace;
    
    const PRINT_HTML = 0;
    const PRINT_CMD = 1;
    
    public function __construct($type,&$object)
    {
        $this->type = $type;
        $this->object = &$object;
        $this->microtime = microtime(true);
        
        $backtrace = debug_backtrace();
        array_shift($backtrace);
        array_shift($backtrace);
        $this->backtrace = $backtrace;
    }
    
    /**
     * Bill Getas
     * http://www.php.net/manual/en/function.debug-backtrace.php#101498
    */
    public function print_backtrace($type = self::PRINT_HTML)
    {
        switch($type)
        {
        case 0:
            array_walk( $this->backtrace,function($a,$b) {print "<br /><b>". basename( $a['file'] ). "</b> &nbsp; <font color=\"red\">{$a['line']}</font> &nbsp; <font color=\"green\">{$a['function']}()</font> &nbsp; -- ". dirname( $a['file'] ). "/";}); 
            break;
        case 1:
            array_walk( $this->backtrace,function($a,$b) {print "\n".basename( $a['file'] )."\t{$a['line']}\t{$a['function']}()\t".dirname( $a['file'] ). "/";}); 
            break;
        default:
            throw new Exception('Could not understand type.');
        }
    }
}

?>