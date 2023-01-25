<?php 
session_start();
include_once __DIR__."/dataBase/dataBaseConnection.php";

if( !empty($_POST['plate']) && !empty($_POST['model']) && !empty($_POST['license']) && !empty($_POST['maxPassenger']) && !empty($_POST['token']) && !empty($_SESSION['token'])){
    if($_POST['token'] == $_SESSION['token']){
        $stat = $PDO->prepare("insert into Vehicle values(:plate, :model, :license, :max, true);");

        $stat->execute([
            'plate' => $_POST['plate'],
            'model' => $_POST['model'],
            'license' => $_POST['license'],
            'max' => $_POST['maxPassenger'],
        ]);
    }
    unset($_SESSION['token']);
    header("Location:".$_SERVER['HTTP_REFERER']);
}
else{
    header("Location:".__DIR__."/vehicle.php");
}