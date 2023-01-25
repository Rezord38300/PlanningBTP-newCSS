<?php 
    session_start();
    include_once dirname(__FILE__,2). "/private/class/URLManagementClass.php";
    include_once dirname(__FILE__,2). "/private/dataBase/dataBaseConnection.php";
    include_once dirname(__FILE__,2). "/private/constant/constant.php"
    // include_once dirname(__FILE__)."/Modules/classGwendal/materialClass.php"; 
    // include_once dirname(__FILE__)."/Modules/tokenGenerator.php";

    // $_SESSION['token'] = generateToken(10);
?>
<!DOCTYPE html>
<html lang="fr">
<?php 
    $title = TITLE_PAGE_MATERIAL; 
    include_once dirname(__FILE__,2)."/private/constant/page/head.php";
?>

<body>
    <?php include_once dirname(__FILE__,2)."/private/constant/page/header.php"; ?>

    <div class="layout">
        <?php include_once dirname(__FILE__,2)."/private/constant/page/aside.php"; ?>

        <main>

                <div class="materialList">
                    <?php 
                        $stat = $PDO->prepare("SELECT * FROM Equipment");
                        $stat->execute();
                        $results = $stat->fetchAll();
                        foreach($results as $res){
                            $mat = new Material($res->equipmentName, $res->equipmentTotalQuantity, $res->equipmentAvailableQuantity);
                            echo $mat->display($_SESSION['token']);
                        }
                    ?>
                </div>

                <form action="newMaterial.php" method="post">
                    <label for="designation">Nom de l'équipement</label>
                    <input type="text" name="designation" id="designation">

                    <label for="total">Quantité du nouvelle équipement</label>
                    <input type="number" name="total" id="total" min="0" max="2000000000" step="1">

                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">

                    <button type="submit">Valider</button>
                    <button type="reset">Annuler</button>
                </form>

        </main>
    </div>
</body>
</html>