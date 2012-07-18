<?php
include('../../classes/event.php');

class Person {
    use EventTemplate;
    
    private $data = array();
    private $inited = false;
    
    public function __construct()
    {
        $this->_event_set_type('get_data');
        $this->_event_set_type('save_data');
        $this->_event_set_type('write_property');
        $this->_event_set_type('delete_data');
    }
    
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }
    
    public function __set($name,$value)
    {
        if (array_key_exists($name, $this->data)) {
            $this->data[$name] = $value;
            $this->fire('write_property');
            return true;
        }
        return false;
    }
    
    public function get($id)
    {
        //GET info from database
        $this->data = array(
            'name'=>'Test Person',
            'email'=>'test@demo.com',
            'username'=>'tperson'
        );
        $this->inited = true;
        
        //Fire the get_data event
        $this->fire('get_data');
        
        return true;
    }
    
    public function save()
    {
        //send data to database
        
        //Fire update_data event
        $this->fire('save_data');
    }
    
    public function delete()
    {
        //remove data from database
        
        //Fire delete_data event
        $this->fire('delete_data');
    }

}

function logEv($event)
{
    echo 'Event: '.$event->type.' for user: '.$event->object->username.'<br />';
}

//make a new person
$person = new Person;

//Bind events to logEv function
$person->bind('get_data','logEv');
$person->bind('save_data','logEv');
$person->bind('delete_data','logEv');
$person->bind('write_property','logEv');


//Load an existing user from db
$person->get('id_of_person');

//Change the users users email
$person->email = 'tperson@domain.com';

//Save the user to the db
$person->save();

//Change the users users username
$person->username = 'testp';

//Save the user to the db
$person->save();

//Delete the user from the db
$person->delete();



?>