<?php
    include_once dirname(__FILE__,2). "/dataBase/dataBaseConnection.php";
    include_once dirname(__FILE__,2). "/class/InputSecurityClass.php";
    $userID = InputSecurity::validateWithoutLetter($_GET['employee']);
    var_dump($userID);
    $statement = $PDO->prepare("select * from User where userId =".$userID);
    $statement->execute();
    $results = $statement->fetch();
?>

<form action="<?= LINK_TO_MODIFY_PROCESS ?>" method="post" class="profilModify">
    <a href="<?= returnURL()?>" class="quitButton" > <i class=""></i> QUIT </a>

    <label for="userPicture" class="userPicture">
        <div class="iconAddPicture">
            <i class="icon-image-plus"></i>
        </div>
        <img src="/private/treatment/indexProcess/export.php?pictureId=1" alt="user Picture">
        <input type="file" name="userPicture" id="userPicture">
    </label>

    <label class="Disabled"> <span>Nom d'utilisateur : </span>
        <input type="text" name="userName" id="userName" value="<?= $results->userLastName ?>" class="Disabled" disabled>
    </label>
    <label for="userPassWord"> <span>Mot de passe :</span>
        <input type="password" name="userPassword" id="userPassword" value="" placeholder="taper un nouveau mot de passe">
    </label>
    <label for="userFirstName"> <span>Prénom :</span>
        <input type="text" name="userFirstName" id="userFirstName" value="<?= $results->userFirstName ?>">
    </label>
    <label for="userLastName"> <span>Nom :</span>
        <input type="text" name="userLastName" id="userLastName" value="<?= $results->userLastName ?>">
    </label>
    <label for="userPosition" class=" <?= addDisabled() ?>"> <span>Poste :</span>
        <input type="text" name="userPosition" id="userPosition" value="<?= $results->userPosition ?>" <?= disableInput()?> class="<?= addDisabled() ?>">
    </label>
    <label for="userMail"> <span>Adresse mail :</span>
        <input type="text" name="userMail" id="userMail" value="<?= $results->userMail ?>">
    </label>
    <label for="userPhone"> <span>Numéro de téléphone :</span>
        <input type="text" name="userPhone" id="userPhone" value="<?= $results->userPhone ?>">
    </label>
    <span>
        <input type="submit" value="Enregistrer">
        <input type="reset" value="Annuler">
    </span>
</form>

<?php 
    function disableInput(){
        if($_SESSION['userFonction'] == "administrator"){
            return "";
        }
        else{
            return "disabled";
        }
    }

    function addDisabled(){
        if($_SESSION['userFonction'] == "administrator"){
            return "";
        }
        else{
            return "Disabled";
        }
    }

    function returnURL(){
        if($_SESSION['userFonction'] == "administrator"){
            switch($_GET['onglet']){
                case "personal":
                        return "/public/profil.php?onglet=personal&display=view&add=false";
                    break;
                case "employees":
                        return "/public/profil.php?onglet=employees&display=view&add=false";
                    break;
            }
        }
        else{
            return "/public/profil.php?onglet=personal&display=view";
        }
    }
?>