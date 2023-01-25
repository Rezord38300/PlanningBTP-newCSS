<?php 
    session_start();
    include_once dirname(__FILE__,2). "/private/class/URLManagementClass.php";
    include_once dirname(__FILE__,2). "/private/dataBase/dataBaseConnection.php";
    include_once dirname(__FILE__,2). "/private/constant/constant.php";
    // include_once dirname(__FILE__)."/Modules/classGwendal/vehiculeClass.php"; 
    // include_once dirname(__FILE__)."/Modules/tokenGenerator.php";

    // $_SESSION['token'] = generateToken(10);
?>
<!DOCTYPE html>
<html lang="fr">
<?php 
    $title = TITLE_PAGE_VEHICLE; 
    include_once dirname(__FILE__,2)."/private/constant/page/head.php";
?>

<body>
    <?php include_once dirname(__FILE__,2)."/private/constant/page/header.php"; ?>

    <div class="layout">
        <?php include_once dirname(__FILE__,2)."/private/constant/page/aside.php";?>

        <main>

            <div class="vehicleList">
                <?php 
                    $stat = $PDO->prepare("select v.vehicleLicensePlate, v.vehicleModel, v.vehicleMaxPassenger, v.vehicleDriverLicense from Vehicle v join DriverLicense d on v.vehicleDriverLicense = d.driverLicenseName");

                    $stat->execute();
                    $results = $stat->fetchAll();
                    foreach($results as $res){
                        $veh = new Vehicule($res->vehicleLicensePlate, $res->vehicleModel, $res->vehicleMaxPassenger, $res->vehicleDriverLicense);
                        echo $veh->display($_SESSION['token']);
                    }
                ?>
            </div>

            <form action="/Modules/classGwendal/newVehicle.php" method="post">
                <label for="plate">Immatriculation</label>
                <input type="search" name="plate" id="plate">

                <label for="model">Model de véhicule</label>
                <input type="text" name="model" id="model">

                <label for="license">Permis nécessaire</label>
                <select name="license" id="license" list="licenses">
                <!-- <datalist id="licenses"> -->
                    <option value="">-- Choix du Permis --</option>
                    <?php 
                    $stat = $PDO->prepare("select driverLicenseName from DriverLicense;");
                    
                    $stat->execute();
                    $results = $stat->fetchAll();
                    foreach($results as $res){
                        echo "<option>". $res->driverLicenseName;
                    }
                    ?>
                <!-- </datalist> -->
                </select>

                <label for="maxPassenger">Nombre de passager maximal</label>
                <input type="number" name="maxPassenger" id="maxPassenger" min="1" max="9" step="1">

                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">

                <span>
                    <input type="submit" value="Valider">
                    <input type="reset" value="Annuler">
                </span>
            </form>
            
        </main>
    </div>
</body>
</html>