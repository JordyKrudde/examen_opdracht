<?php
include('../db/dbconfig.php');

$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

$lidID = $_GET['lid_id'];

$deleteQuery = $con->prepare("DELETE FROM lid WHERE lid_id = :lid_id");
$deleteQuery->bindParam(":lid_id", $lidID);
$deleteQuery->execute();

header ("Location: ../dashboard/index.php")
?>