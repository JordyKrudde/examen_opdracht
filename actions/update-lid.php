<?php
session_start();

include('../db/dbconfig.php');

$dbh = new Dbh();
$pdo = $dbh->connect();
$id = $_GET['id'];

if (isset($_POST['opslaan'])) {
    $nieuwVnaam = "lid_vnaam=:vnaam";
    $nieuwTvoegsel = "lid_tvoegsel=:tvoegsel";
    $nieuwAnaam = "lid_anaam=:anaam";
    $nieuwEmail = "lid_email=:email";
    $nieuwWachtwoord = "lid_wachtwoord=:wachtwoord";
    $nieuwLidnr = "lid_nr=:lidnr";
    $nieuwLidrol = "lid_rol=:lidrol";

    //Wachtwoord hash voor het formulier veld "wachtwoord", salt: "examen", default hash if algo = empty
    $wachtwoordMetSaltEncrypt = password_hash($_POST["wachtwoord"] . "examen", PASSWORD_DEFAULT);

    $query = $pdo->prepare("UPDATE lid SET $nieuwVnaam, $nieuwAnaam, $nieuwEmail, $nieuwLidnr, $nieuwLidrol WHERE lid_id=$id");

    $query->bindParam(':vnaam', $_POST['vnaam']);
    $query->bindParam(':anaam', $_POST['anaam']);
    $query->bindParam(':email', $_POST['email']);
    $query->bindParam(':lidnr', $_POST['lidnr']);
    $query->bindParam(':lidrol', $_POST['lidrol']);

    $query_exec = $query->execute();

    if (isset($_POST["wachtwoord"]) && !empty($_POST["wachtwoord"])) {
        $query = $pdo->prepare("UPDATE lid SET $nieuwWachtwoord WHERE lid_id=$id");
        $query->bindParam(':wachtwoord', $wachtwoordMetSaltEncrypt);
        $query_exec = $query->execute();
    }

    if (isset($_POST["tvoegsel"]) && !empty($_POST["tvoegsel"])) {
        $query = $pdo->prepare("UPDATE lid SET $nieuwTvoegsel WHERE lid_id=$id");
        $query->bindParam(':tvoegsel', $_POST['tvoegsel']);
        $query_exec = $query->execute();
    }

    if($query_exec) {
            $_SESSION["status"] = "De gegevens zijn ge-update";
            $_SESSION["statusCode"] = "success";
            header("Location: ../dashboard/leden-wijzigen.php?id=".$id);
    } else {
        $_SESSION["status"] = "De gegevens zijn niet ge-update";
        $_SESSION["statusCode"] = "error";
        header("Location: ../dashboard/leden-wijzigen.php?id=".$id);
    }
}
?>