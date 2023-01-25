<?php
    session_start();
    include_once dirname(__FILE__,4). "/private/class/InputSecurityClass.php";
    include_once dirname(__FILE__,4). "/private/dataBase/dataBaseConnection.php";

    $mail = InputSecurity::validateMail($_POST['userMail']);

    // test FirstName
    $firstName = InputSecurity::validateWithoutNumber($_POST['userFirstName']);

    // test LastName
    $lastName = InputSecurity::validateWithoutNumber($_POST['userLastName']);

    // test Position
    $position = InputSecurity::validateWithoutNumber($_POST['userPosition']);

    // test phone number
    echo $_POST['userPhone'];
    $phoneNumber = InputSecurity::validateWithoutLetter($_POST['userPhone'] , "phoneNumber");
    echo $phoneNumber;

    $picture = $_SESSION['userPicture'];
    $userId = $_SESSION['userId'];

    //var_dump($picture);

    if(isset($_POST["valider"])){
        $pdo = new PDO('mysql:host=iutbg-lamp.univ-lyon1.fr:3306;dbname=p2107521', 'p2107521', '12107521' , [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_OBJ);
        // var_dump($_FILES["userPicture"]["name"]!="");
        // var_dump($_FILES["userPicture"]["name"]);
        if($_FILES["userPicture"]["name"]!=""){
            $test = $pdo->prepare("select pictureId from Picture where userId = $userId");
            $test->execute();
            $test = $test->fetch();
            //var_dump($test->pictureId);
            if(empty($test->pictureId)){
                $req = $pdo->prepare("insert into Picture(pictureId, pictureName, pictureSize, pictureType, pictureBin, userId) values ($userId, ?, ?, ?, ?, $userId)");
                //echo "if";
            }else{
                $req = $pdo->prepare("update Picture set pictureId = $userId, pictureName = ?, pictureSize = ?, pictureType = ?, pictureBin = ?, userId = userId");
                //echo "else";
            }
            $req->execute(array($_FILES["userPicture"]["name"], $_FILES["userPicture"]["size"], $_FILES["userPicture"]["type"], file_get_contents($_FILES["userPicture"]["tmp_name"])));
        }

        $sql = $pdo->prepare("select * from Picture");
        $sql->execute();

        $result = $sql->fetchAll();

        //var_dump($result);

    }

    

    $statement = $PDO->prepare('update User  set userFirstName = :FName , userLastName = :LName, userMail = :MAIL , userPhone = :PHONE, pictureId = :ID , userPosition = :POSITION where userId = :ID');
    $statement->bindParam("FName", $firstName);
    $statement->bindParam("LName", $lastName);
    $statement->bindParam("MAIL", $mail);
    $statement->bindParam("PHONE", $phoneNumber);
    $statement->bindParam("POSITION", $position);
    $statement->bindParam("ID", $userId);
    $statement->execute();

    $getUser = $PDO->prepare("select * from User where userId = :userId ");
    $getUser->bindParam("userId" , $_SESSION['userId']);
    $getUser->execute();

    $getUser = $getUser->fetch();


    $password = InputSecurity::validatePassWord($_POST['userPassword']);

    /**
     * message to disconnect the user
     */
    InputSecurity::returnMessage("you will be disconnected");

    // faire le system de mise a jour du login 

    // var_dump($_SESSION['ERROR']);
    // InputSecurity::destroyError();
    // var_dump($_SESSION['ERROR']);

    // $_SESSION['userId'] = $getUser->userId; //user id in data base
    // $_SESSION['userName'] = $loginUsername->loginUsername; //  connection ID
    //$_SESSION['userPicture'] = $getUser->userPicture; // profile picture 
    $_SESSION['userFirstName'] = $getUser->userFirstName; // first name of user
    $_SESSION['userLastName'] = $getUser->userLastName; // name of user 
    $_SESSION['userPosition'] = $getUser->userPosition; // position in the company
    $_SESSION['userPhone'] = $getUser->userPhone; // user phone number 
    $_SESSION['userMail'] = $getUser->userMail; // user mail address
    header('Location:' .dirname(__FILE__,4)."/public/profil.php"."?&onglet='.'Personal'.'&display='.'View'");
    Exit();
?>
