<?php 
session_start();

include('../db/dbconfig.php');

$dbh = new Dbh();
$pdo = $dbh->connect();

if (isset($_POST['toevoegen'])) {
    $nieuwToernooiNaam = ":toernooiNaam";
    $nieuwToernooiDeelnemers = ":toernooiDeelnemers";
    $nieuwToernooiBeginTijd = ":toernooiBeginTijd";
    $nieuwToernooiEindTijd =":toernooiEindTijd";
    $nieuwToernooiDatum = ":toernooiDatum";
    $nieuwToernooiDeadline = ":toernooiDeadline";

    //query voorbereiden
    $query = $pdo->prepare("INSERT INTO toernooien (toernooi_naam, toernooi_begintijd, toernooi_eindtijd, toernooi_datum, toernooi_deadline)VALUES ($nieuwToernooiNaam, $nieuwToernooiBeginTijd, $nieuwToernooiEindTijd, $nieuwToernooiDatum, $nieuwToernooiDeadline)");

    //bindparam tegen sql injection
    $query->bindParam(':toernooiNaam', $_POST['toernooi_naam']);
    $query->bindParam(':toernooiBeginTijd', $_POST['toernooi_begin_tijd']);
    $query->bindParam(':toernooiEindTijd', $_POST['toernooi_eind_tijd']);
    $query->bindParam(':toernooiDatum', $_POST['toernooi_datum']);
    $query->bindParam(':toernooiDeadline', $_POST['toernooi_deadline']);

    $query_exec = $query->execute();//uitvoeren query

    //melding of update gelukt is of niet
    if($query_exec) {
            $_SESSION["status"] = "De gegevens zijn ge-update";
            $_SESSION["statusCode"] = "success";
            header("Location: ../dashboard/toernooi-toevoegen.php");
    } else {
        $_SESSION["status"] = "De gegevens zijn niet ge-update";
        $_SESSION["statusCode"] = "error";
        header("Location: ../dashboard/toernooi-toevoegen.php");
    }
}
?>