<?php
class Message//
{
	public $id; 
	public $text;
    public $data;
    public $time;
    public $id_anketa; 
    public $docs = array();
	
	function __construct($i, $t, $dt, $a, $d)
	{
        $this->id = $i;
        $this->text = $t;
        $datetimeArray = explode(' ', $dt);
        $this->data = $datetimeArray[0];
        $this->time = $datetimeArray[1];
        $this->id_anketa = $a;
        $this->docs = $d;
	}
}
?>