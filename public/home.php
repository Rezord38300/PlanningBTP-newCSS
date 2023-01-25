<?php
    session_start();
    include_once dirname(__FILE__,2). "/private/class/InputSecurityClass.php";
    include_once dirname(__FILE__,2). "/private/constant/constant.php";
?>

<!DOCTYPE html>
<html lang="fr">

<!-- variables declaration -->
<?php 
$title = TITLE_PAGE_HOME;

include_once dirname(__FILE__,2)."/private/constant/page/head.php";
?>

<body>
    <div class="layout">
        <?php include_once dirname(__FILE__,2). "/private/constant/page/header.php" ?>
        <?php include_once dirname(__FILE__,2). "/private/constant/page/aside.php" ?>
            <main>
                
            </main>
    </div>
</body>
</html>