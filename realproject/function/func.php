<?php
require_once('../model/data.php');
$method = $_POST['method'];//получаем метод по ключу
switch ($method) 
{
    case "reg"://Если регистрация, получаем данные по из массива
    {
        /*$name = $_POST['name'];
        $fam = $_POST['fam'];
        $mail = $_POST['mail'];
        $pass = $_POST['pass'];
        $role = $_POST['role'];

        print_r($_POST);
*/
        $id = setProfile($_POST);//Вызываем функцию для создания профиля
        echo $id;
    }
    break;
    
    case "log"://Если вход, получаем данные по ключам
    {
        $mail = $_POST['mail'];
        $pass = $_POST['pass'];

        $id = login($mail, $pass);//Вызываем функцию для поиска профиля
        echo $id;
    }
    break;        
        
    case "project"://Если Заказчик хочет добавить проект
    {
        session_start();
        $id=$_SESSION['id'];
        //echo $_FILES['photo']['name'];
        //print_r($_POST);
        $id = setProject($_POST,$id);
        echo $id;
    }
    break;
    
    case "update"://Если пришли данные для обновления профиля
    {
        session_start();
        $id=$_SESSION['id'];
        echo updateProfile($_POST,$id);
    }
    break;

    case "set_uchastnik"://Если пришли данные для обновления профиля
    {
        session_start();
        $id=$_SESSION;
        echo setUchastnik($_POST['id_pr'],$id);
    }
    break;
    

    case "mess":
    {
        session_start();
        $id=$_SESSION['id'];
        setMessage($_POST,$id, date('Y-m-d H:i:s'));
    }
    break;
}

?>