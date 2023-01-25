<?php
    $host = $_SERVER['HTTP_HOST'];
    $path = "/index.php";
    if(isset($_SESSION['sessionOpen'])){
        $_SESSION = array();
        session_destroy();
        header("Location: http://$host$path");
        Exit();
    }
    else{
        header("Location: http://$host$path");
        Exit();
    }
?>