phpevents Tutorial
==================

Include event.php
-----------------

This should be self explanatory

    <?php
    include('event.php');
    ?>

Enable events on a class
------------------------

To add enable events on any class, use the EventTemplate trait.

    <?php
    include('event.php');
    
    class SomeClass
    {
        use EventTemplate;
        
        //properties and methods
    }
    
    ?>
    
Set Default Event Types for a Class
-------------------------------------

To set the default event types for a class, set the $_event_default_types property.

    <?php
    include('event.php');
    
    class SomeClass
    {
        use EventTemplate;
        
        public $_event_default_types = array(
            'event_type1',
            'event_type2',
            //ETC
        );
        
        //More properties and methods
    }
    
    ?>
    
Set Default Internal Binds for a Class
-----------------------------

To set the default event binds for a class, set the $_event_default_binds property. Binds set via this way can only trigger methods of this class.

    <?php
    include('event.php');

    class SomeClass
    {
        use EventTemplate;
        
        public $_event_default_types = array(
            'event_type1',
            'event_type2'
        );
        
        public $_event_default_binds = array(
            'event_type1'=>array(
                'method1',
                'method2'
            ),
            'event_type2'=>array('method3')
        );
        
        //More properties
        
        public function method1($event)
        {
            //Do something
        }
        
        public function method2($event)
        {
            //Do something
        }
        
        public function method3($event)
        {
            //Do something
        }
        
        //More Methods
    }
    
    ?>

Fire an event!
--------------

To fire an event, call the fire() method of a class.

    <?php
    include('event.php');
    
    $obj = new SomeClass;
    $obj->fire('event_type1'); //method1 and method2 will run
    $obj->fire('event_type2'); //method3 will run
    
    
    
    class SomeClass
    {
        use EventTemplate;
        
        public $_event_default_types = array(
            'event_type1',
            'event_type2'
        );
        
        public $_event_default_binds = array(
            'event_type1'=>array(
                'method1',
                'method2'
            ),
            'event_type2'=>array('method3')
        );
        
        //More properties
        
        public function method1($event)
        {
            //Do something
        }
        
        public function method2($event)
        {
            //Do something
        }
        
        public function method3($event)
        {
            //Do something
        }
        
        //More Methods   
    }
    
    ?>
    

Do More!
--------

There is quite a bit more that events can do. [See the Examples](https://github.com/mrkmg/phpevents/tree/master/tests) to learn what else events can do.