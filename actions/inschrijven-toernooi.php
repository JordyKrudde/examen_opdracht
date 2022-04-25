<?php 
session_start();

include('../db/dbconfig.php');

$dbh = new Dbh();
$pdo = $dbh->connect();
$toernooiID = $_GET['id'];
$lid_id = $_SESSION["lidID"];


$select = $pdo->prepare("SELECT lid_id, toernooi_id FROM inschrijvingen WHERE lid_id = :lidID AND toernooi_id = :toernooiID");
$select->bindParam(':lidID', $lid_id);
$select->bindParam(':toernooiID', $toernooiID);
$select->execute();
$count = $select->rowCount();

$select2 = $pdo->prepare("SELECT toernooi_id FROM inschrijvingen WHERE toernooi_id = :toernooiID");
$select2->bindParam(':toernooiID', $toernooiID);
$select2->execute();
$toernooiCount = $select2->rowCount();
$data = $select->fetchAll(PDO::FETCH_ASSOC);

$select3 = $pdo->prepare("SELECT toernooi_deelnemers FROM toernooien WHERE toernooi_id = :toernooiID");
$select3->bindParam(':toernooiID', $toernooiID);
$select3->execute();
$deelnemers = $select3->fetch();
$toernooiIncrease = $deelnemers['toernooi_deelnemers'] +=1;

if($count < 1) {
    if($toernooiCount <= 31) {
        $sth = $pdo->prepare("INSERT INTO inschrijvingen (lid_id, toernooi_id)values(:lidID ,:toernooiID)");
        $sth->bindParam(':lidID', $lid_id);
        $sth->bindParam(':toernooiID', $toernooiID);
        $execute = $sth->execute();

        $sth2 = $pdo->prepare("UPDATE toernooien SET toernooi_deelnemers = :toernooiDeelnemers WHERE toernooi_id = :toernooiID");
        $sth2->bindParam(':toernooiID', $toernooiID);
        $sth2->bindParam(':toernooiDeelnemers', $toernooiIncrease);
        $execute2 = $sth2->execute();

        $_SESSION["status"] = "Je bent ingeschreven voor dit toernooi!";
        $_SESSION["statusCode"] = "success";
        header("Location: ../inschrijven-toernooien.php");
    } else {
        $_SESSION["status"] = "Sorry, dit toernooi is vol.";
        $_SESSION["statusCode"] = "error";
        header("Location: ../inschrijven-toernooien.php");
    }
} else {
    $_SESSION["status"] = "Je bent al ingeschreven voor dit toernooi.";
    $_SESSION["statusCode"] = "error";
    header("Location: ../inschrijven-toernooien.php");
}
?>