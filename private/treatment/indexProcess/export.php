<?php session_start();
$id = $_SESSION['userId'];
$pdo = new PDO('mysql:host=iutbg-lamp.univ-lyon1.fr:3306;dbname=p2107521', 'p2107521', '12107521' , [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_OBJ);
        $req = $pdo->prepare("select * from Picture where pictureId=$id limit 1");
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute(array($_GET["pictureId"]));
        $tab=$req->fetchAll();
        echo $tab[0]["pictureBin"];
        