<?php
session_start();
include_once __DIR__."/dataBase/dataBaseConnection.php";

if( !empty($_POST['designation']) && !empty($_POST['total']) && !empty($_POST['token']) && !empty($_SESSION['token']) ){
    if($_POST['token'] == $_SESSION['token']){
        $stat = $PDO->prepare("INSERT INTO Equipment VALUES(:designation, :tt, :tt)");
        $stat->execute([
            'designation' => $_POST['designation'],
            'tt' => $_POST['total']
        ]);
    }
    unset($_SESSION['token']);
    header("Location:".$_SERVER['HTTP_REFERER']);
}
header("Location:material.php");