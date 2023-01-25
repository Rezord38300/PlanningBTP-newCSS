<?php
session_start();
include_once __DIR__."/dataBase/dataBaseConnection.php";

if(!empty($_POST['id']) && !empty($_POST['idName']) && !empty($_POST['table']) && !empty($_POST['token']) && !empty($_SESSION['token'])){
    if($_POST['token'] == $_SESSION['token']){
               
        $stat = $PDO->prepare("DELETE FROM {$_POST['table']} WHERE {$_POST['idName']} = :id");

        $stat->execute([
            'id' => $_POST['id']
        ]);
    }
}
header("Location:".$_SERVER['HTTP_REFERER']);