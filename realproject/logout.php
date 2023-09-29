<?php
session_start();
$_SESSION['id'] = '';
$_SESSION['name'] = '';
header("Location: register.php");
?>