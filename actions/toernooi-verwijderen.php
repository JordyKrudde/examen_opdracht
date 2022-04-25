<?php
include('../db/dbconfig.php');

$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

$toernooiID = $_GET['toernooi_id'];//Toernooi ID ophalen via get en in variabele zetten

$deleteQuery = $con->prepare("DELETE FROM toernooien WHERE toernooi_id = :toernooi_id");//query voorbereiden
$deleteQuery->bindParam(":toernooi_id", $toernooiID);//bindparam voor sql injection 
$deleteQuery->execute();//query uitvoeren

header ("Location: ../dashboard/toernooi-overzicht.php");// terug naar toernooi overzicht
?>