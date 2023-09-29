<?php
class Uchastnik //Класс Участник
{
    public $id;
    public $name; //Имя
	public $last_name; //Фамилия
	public $role; // Роль
	public $logo; //Фото 

    function __construct($i, $n, $l, $r, $photo)
	{
        $this->id = $i;
        $this->name = $n;
        $this->last_name = $l;
        $this->role = $r;
        $this->logo = $photo;
	}
}
?>