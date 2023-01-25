<?php
session_start();
include_once dirname(__FILE__,2). "/private/constant/constant.php";
include_once dirname(__FILE__,2). "/private/dataBase/dataBaseConnection.php";
?>

<!DOCTYPE html>
<html lang="fr">

<!-- variables declaration -->
<?php 
$title = TITLE_PAGE_SCHEDULE;

include_once dirname(__FILE__,2)."/private/constant/page/head.php";
?>

<body>
    <?php include_once dirname(__FILE__,2). "/private/constant/page/header.php"; ?>

    <div class="layout">
        <?php include_once dirname(__FILE__,2). "/private/constant/page/aside.php"; ?>

        <main>
            <?php 
            
            function affichage($totalHours){
                //Heures au format (hh:mm:ss) la plus grande puis la plus petite

                $tab = explode(":", $totalHours);

                $h = $tab[0]; // récupère la partie heures endTime
                $m = $tab[1]; // récupère la partie minutes endTime
                if (strlen($h) == 1) { // si il s'agit d'un seul caractère on lui met un 0 devant (Ex: 09:00)
                    $h = "0" . $h;
                }
                if (strlen($m) == 1) {
                    $m = "0" . $m;
                }
                return $h . ":" . $m; // on affiche
            }
            // $statement = $PDO->prepare("select sec_to_time(sum(time_to_sec(workTimeTotalHours))) as totalHours from WorkTime;");
            // $schedule = $statement->fetchAll();

            // temporaire 
            $sql  = "select sec_to_time(sum(time_to_sec(workTimeTotalHours))) as totalHours from WorkTime;";
            foreach($PDO->query($sql) as $row){
               if($row->totalHours != null){
                    $diff = $row->totalHours;
               }
            }

            // var_dump($schedule);
            // $dsn = 'mysql:host=iutbg-lamp.univ-lyon1.fr:3306;dbname=p2107521';
            // $user = 'p2107521';
            // $password = '12107521';
            // $conn = new PDO($dsn, $user, $password);
            // $sql = ("select sec_to_time(sum(time_to_sec(workTimeTotalHours))) as totalHours from WorkTime;");
            // //$sql = ("select workTimeTotalHours as totalHours from WorkTime;");
            // foreach ($conn->query($sql) as $row) {
            //     //echo $row['totalHours'] . "<br>";
            //     if ($row['totalHours'] !== null) {
            //         //$diff = date("H:i", strtotime($row['totalHours']));
            //         $diff = $row['totalHours'];
            //         // var_dump($diff);
            //     }
            // }
            if (!isset($diff)) {
                echo "<br>" . "Les heures effectuées cette semaine: 0:00";
            } else {
                echo "<br>" . "Les heures effectuées cette semaine: " . affichage($diff);
            } ?>
            <form action="/private/treatment/scheduleProcess.php" method="post">
                <label for="weekInput"> Semaine : </label>
                <input type="number" name="weekInput" id="weekInput" max="52">
                <label for="plate">Heure d'arrivée <input type="time" name="startTime" id="plate"></label>

                <label for="type">Heure de départ <input type="time" name="endTime" id="type"></label>

                <input type="submit" value="Valider">
                <input type="reset" value="Annuler">
            </form>

        </main>
    </div>
</body>

</html>