<form action="/private/treatment/profileProcess/addProcess.php" method="post" class="profilModify" enctype="multipart/form-data">

    <a href="<?= returnURL()?>" class="quitButton" > <i class=""></i> QUIT </a>

    <label for="userPicture" class="userPicture">
        <div class="iconAddPicture">
            <i class="icon-image-plus"></i>
        </div>
        <img src="/private/img/defaultPP.png" alt="user Picture">
        <input type="file" name="userPicture" id="userPicture">
    </label>

    <label class="Disabled"> <span>Nom d'utilisateur : </span>
        <input type="text" name="userName" id="userName" value="" class="Disabled" disabled>
    </label>
    <label for="userPassWord"> <span>Mot de passe :</span>
        <input type="password" name="userPassword" id="userPassword" value="" placeholder="taper un nouveau mot de passe">
    </label>
    <label for="userFirstName"> <span>Prénom :</span>
        <input type="text" name="userFirstName" id="userFirstName" value="" placeholder="taper un prénom">
    </label>
    <label for="userLastName"> <span>Nom :</span>
        <input type="text" name="userLastName" id="userLastName" value="" placeholder="taper un nom">
    </label>
    <label for="userPosition" class=" <?= addDisabled() ?>"> <span>Poste :</span>
        <input type="text" name="userPosition" id="userPosition" value="" <?= disableInput()?> class="<?= addDisabled() ?>" placeholder="indiquer le poste">
    </label>
    <label for="userMail"> <span>Adresse mail :</span>
        <input type="text" name="userMail" id="userMail" value="" placeholder="exemple@exemple.fr">
    </label>
    <label for="userPhone"> <span>Numéro de téléphone :</span>
        <input type="text" name="userPhone" id="userPhone" value="" placeholder="taper un numero de téléphone">
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
            return "/public/profil.php?onglet=employees&display=view&add=false";
        }
        else{
            return "/public/profil.php?onglet=employees&display=view&add=false";
        }
    }
?>