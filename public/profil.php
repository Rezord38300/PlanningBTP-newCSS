<?php
    session_start();
    include_once dirname(__FILE__,2). "/private/constant/constant.php";
    include_once dirname(__FILE__,2). "/private/class/InputSecurityClass.php";
    include_once dirname(__FILE__,2). "/private/class/URLManagementClass.php";
    //var_dump($_SESSION['ERROR']);
    // if(isset($_SESSION['MESSAGE'])){
    //     var_dump($_SESSION['MESSAGE']);
    // }
?>
<!DOCTYPE html>
<html lang="fr">

<?php 
    $title = TITLE_PAGE_PROFIL;
    include_once dirname(__FILE__,2)."/private/constant/page/head.php";
?>

<body>
    <div class="layout">
        <?php include_once dirname(__FILE__,2)."/private/constant/page/header.php"; ?>
        <?php include_once dirname(__FILE__,2)."/private/constant/page/aside.php"; ?>
        <main>
            <?php
                if($_SESSION['userFonction'] == 'administrator'){
                    include_once dirname(__FILE__,2). "/private/selectTab.php";
                }
            ?>
            <div class="profilContent">
                <?php 
                    switch ($_GET["onglet"]) {
                        case PARAM_PERSONAL_ONGLET:
                            switch($_GET["display"]){
                                case PARAM_VIEW_DISPLAY:
                                    include_once dirname(__FILE__,2). "/private/profil/profilView.php";
                                break;
                                case PARAM_MODIFY_DISPLAY:
                                    include_once dirname(__FILE__,2). "/private/profil/profilModify.php";
                            break;
                            }
                        break;
                        case PARAM_EMPLOYEE_ONGLET:
                            switch($_GET["display"]){
                                case PARAM_VIEW_DISPLAY:
                                    include_once dirname(__FILE__,2). "/private/profil/profilViewAdmin.php";
                                break;
                                case PARAM_MODIFY_DISPLAY:
                                    include_once dirname(__FILE__,2). "/private/profil/modifyEmployee.php";
                                break;
                            }
                        break;
                    }
                ?>
            </div>
        </main>
    </div>
</body>

</html>