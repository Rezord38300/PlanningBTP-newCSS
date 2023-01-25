<?php
include_once dirname(__FILE__,3). "/constant/constant.php";
include_once dirname(__FILE__,3). "/dataBase/dataBaseConnection.php";
include_once dirname(__FILE__,3). "/class/InputSecurityClass.php";

$userName = InputSecurity::isEmpty($_POST['userName']);
$userPassword = InputSecurity::isEmpty($_POST['userPassWord']);
$userPassword = sha1($userPassword);

$statement = $PDO->prepare("select * from User where userId = (select userId from Login where loginUsername= :userName and loginUserPassword = :userPassword)");
$statement->bindParam('userName' , $userName);
$statement->bindParam('userPassword' , $userPassword);
$statement->execute();

$statementUserName = $PDO->prepare("select loginUsername from Login where loginUsername= :userName");
$statementUserName->bindParam('userName' , $_POST['userName']);
$statementUserName->execute();

$user = $statement->fetch();
$loginUsername = $statementUserName->fetch();

$req = $PDO->prepare("select * from Picture where pictureId=$user->userId limit 1");
$req->setFetchMode(PDO::FETCH_ASSOC);
$req->execute();
$tab=$req->fetchAll();
// var_dump($tab);

if(isset($user->userId) && isset($loginUsername->loginUsername)){
    session_start();
    //include_once 'translateDate.php';
    /** session existence test variables */
    $_SESSION['sessionOpen'] = true;
    /** date variables */
    $_SESSION['dateToday'] = 0;//translateDate();
    /** user variables */

    foreach(PARAM_SESSION_TYPE as $key => $userFonction){
        if($key === $user->userPosition){
            $_SESSION['userFonction'] = PARAM_SESSION_TYPE[$key];
        }
    };

    $_SESSION['userId'] = $user->userId; //user id in data base
    $_SESSION['userName'] = $loginUsername->loginUsername; //  connection ID

    if($tab == null){
        $_SESSION['userPicture'] = dirname(__FILE__,3)."/private/img/defaultPP.png";
    }
    else{
        $_SESSION['userPicture'] = $tab[0]["pictureBin"];
    }
    
    $_SESSION['userFirstName'] = $user->userFirstName; // first name of user
    $_SESSION['userLastName'] = $user->userLastName; // name of user 
    $_SESSION['userPosition'] = $user->userPosition; // position in the company
    $_SESSION['userPhone'] = $user->userPhone; // user phone number 
    $_SESSION['userMail'] = $user->userMail; // user mail address

    $_SESSION['schedule'] = '7h 18h'; // user schedule of day for the user
    // include_once dirname(__FILE__,4). "/public/home.php";
    $host = $_SERVER['HTTP_HOST'];
    $path = "/public/home.php";
    header("Location: http://$host$path");
    Exit();
}
?>