<form action="<?= LINK_TO_MODIFY_PROCESS ?>" method="post" class="profilModify" enctype="multipart/form-data">
    <a href="<?= returnURL()?>" class="quitButton" > <i class=""></i> QUIT </a>

    <label for="userPicture" class="userPicture">
        <div class="iconAddPicture">
            <i class="icon-image-plus"></i>
        </div>
        <img src="/private/treatment/indexProcess/export.php?pictureId=<?php echo $_SESSION['userId']; ?>" alt="user Picture">
        <input type="file" name="userPicture" id="userPicture">
    </label>

    <label class="Disabled"> <span>Nom d'utilisateur : </span>
        <input type="text" name="userName" id="userName" value="<?= $_SESSION['userName'] ?>" class="Disabled" disabled>
    </label>
    <label for="userPassWord"> <span>Mot de passe :</span>
        <input type="password" name="userPassword" id="userPassword" value="" placeholder="taper un nouveau mot de passe">
    </label>
    <label for="userFirstName"> <span>Prénom :</span>
        <input type="text" name="userFirstName" id="userFirstName" value="<?= $_SESSION['userFirstName'] ?>">
    </label>
    <label for="userLastName"> <span>Nom :</span>
        <input type="text" name="userLastName" id="userLastName" value="<?= $_SESSION['userLastName'] ?>">
    </label>
    <label for="userPosition" class=" <?= addDisabled() ?>"> <span>Poste :</span>
        <input type="text" name="userPosition" id="userPosition" value="<?= $_SESSION['userPosition'] ?>" <?= disableInput()?> class="<?= addDisabled() ?>">
    </label>
    <label for="userMail"> <span>Adresse mail :</span>
        <input type="text" name="userMail" id="userMail" value="<?= $_SESSION['userMail'] ?>">
    </label>
    <label for="userPhone"> <span>Numéro de téléphone :</span>
        <input type="text" name="userPhone" id="userPhone" value="<?= $_SESSION['userPhone'] ?>">
    </label>
    <span>
        <input type="submit" name="valider" value="Enregistrer">
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
            return "/public/profil.php?onglet=personal&display=view&add=false";
        }
        else{
            return "/public/profil.php?onglet=personal&display=view";
        }
    }
?>