<?php
session_start();
include_once dirname(__FILE__,4)."/PlanningBTP/dataBase/dataBaseConnection.php";

// $statement = $PDO->prepare("insert into Event values(0, :varLocation, :varDescription , :varDate , :varStartTime , :varEndTime);");

// $statement->bindParam('varLocation' , $_POST['eventLocation']);
// $statement->bindParam('varDescription' , $_POST['eventDescription']);
// $statement->bindParam('varDescription' , $_POST['eventDate']);
// $statement->bindParam('varStartTime' , $_POST['eventStartTime']);
// $statement->bindParam('varEndTime' , $_POST['eventEndTime']);

$statement = $PDO->prepare("insert into Event values(0, :varLocation, :varDescription , :varStartTime , :varEndTime);");
$statement->bindParam('varLocation' , $_POST['eventLocation']);
$statement->bindParam('varDescription' , $_POST['eventDescription']);
$statement->bindParam('varStartTime' , $_POST['eventStartTime']);
$statement->bindParam('varEndTime' , $_POST['eventEndTime']);

$statement->execute();

header('Location: ../../../planning.php?userRole='.$_SESSION['userRole'].'&onglet=Missions&display=month&month=11&year=2022');
Exit();

//AJOUTER DATE A LA BASE !

?>