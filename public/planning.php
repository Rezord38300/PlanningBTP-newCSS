<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">

<!-- variables declaration -->
<?php

    include_once dirname(__FILE__,2). "/private/dataBase/dataBaseConnection.php";
    include_once dirname(__FILE__,2). "/private/class/URLManagementClass.php";
    include_once dirname(__FILE__,2). "/private/constant/constant.php";

    $title = TITLE_PAGE_PLANNING;
    include_once dirname(__FILE__,2)."/private/constant/page/head.php";
?>

<body>
    <div class="layout">
        <?php include_once dirname(__FILE__,2). "/private/constant/page/header.php" ?>
        <?php include_once dirname(__FILE__,2). "/private/constant/page/aside.php" ?>
        <main>
            <?php
                if($_SESSION['userFonction'] == 'administrator'){
                    include_once dirname(__FILE__,2). "/private/selectTab.php";
                }
            ?>
            <div class="tabContent">
                <?php
                    $dayView = dirname(__FILE__,2). "/private/planning/dayView.php";
                    $weekView = dirname(__FILE__,2). "/private/planning/weekView.php";
                    $monthView = dirname(__FILE__,2). "/private/planning/monthView.php";


                    switch($_GET["onglet"]){
                        case PARAM_MISSION_ONGLET:
                                switch($_GET["display"]){
                                    case PARAM_DAY_DISPLAY:
                                        include_once $dayView;
                                    break;
                                    case PARAM_WEEK_DISPLAY:
                                        include_once $weekView;
                                    break;
                                    case PARAM_MONTH_DISPLAY:
                                        include_once $monthView;
                                    break;
                                }
                            break;
                        case PARAM_EMPLOYEE_ONGLET:
                                switch($_GET["display"]){
                                    case PARAM_DAY_DISPLAY:
                                        include_once $dayView;
                                    break;
                                    case PARAM_WEEK_DISPLAY:
                                        include_once $weekView;
                                    break;
                                    case PARAM_MONTH_DISPLAY:
                                        include_once $monthView;
                                    break;
                                }
                            break;
                        case PARAM_VEHICLES_ONGLET:
                                switch($_GET["display"]){
                                    case PARAM_DAY_DISPLAY:
                                        include_once $dayView;
                                    break;
                                    case PARAM_WEEK_DISPLAY:
                                        include_once $weekView;
                                    break;
                                    case PARAM_MONTH_DISPLAY:
                                        include_once $monthView;
                                    break;
                                }
                            break;
                        case PARAM_MATERIAL_ONGLET:
                                switch($_GET["display"]){
                                    case PARAM_DAY_DISPLAY:
                                        include_once $dayView;
                                    break;
                                    case PARAM_WEEK_DISPLAY:
                                        include_once $weekView;
                                    break;
                                    case PARAM_MONTH_DISPLAY:
                                        include_once $monthView;
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