<?php session_start(); ?>
<?php
require_once ("db/dbconfig.php");
$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

if(!isset($_GET["code"])) { //als de code niet in je url staat dan mag hij de pagina niet zien
    exit("Can`t find page");
}

$code = $_GET["code"];

//selecteert hier je gegevens dmv je code
$sql = $con->prepare("SELECT reset_email FROM resetwachtwoord WHERE reset_code = :uniqCode");
$sql->bindParam(":uniqCode", $code);
$sql->execute();

$searchCode = $sql->rowCount();

//als je code niet gevonden is dan mag je niet op de pagina komen
if($searchCode == 0) {
    exit("Can`t find page");
}

//als je wachtwoord hetzelfde is als je herhaalde wachtwoord is hij goed
if(isset($_POST["wachtwoord"]) && $_POST["wachtwoord"] === $_POST["wachtwoordHerhaling"]) {

    $wachtwoord = $_POST["wachtwoord"];
    $saltPass = $wachtwoord . "examen"; // ik gebruik salt voor extra beveiliging.
    $passwordHash = password_hash($saltPass, PASSWORD_DEFAULT);

    $row = $sql->fetch();
    $email = $row["reset_email"];

    //update hier je huidige wachtwoord naar een nieuw veranderd wachtwoord
    $sqlUpdate = $con->prepare("UPDATE lid SET lid_wachtwoord = :lidWachtwoord WHERE lid_email = :lidEmail");
    $sqlUpdate->bindParam(":lidWachtwoord", $passwordHash);
    $sqlUpdate->bindParam("lidEmail", $email);

    if($sqlUpdate->execute()) {
        //als hij geupdate is dan moet de code automatisch uit de database worden gehaald zodat je niet meerdere keren iets kan resetten
        $sqlDelete = $con->prepare("DELETE FROM resetwachtwoord WHERE reset_code = :uniqCode");
        $sqlDelete->bindParam(":uniqCode", $code);
        $sqlDelete->execute();

        $_SESSION["status"] = "Wachtwoord is succesvol gewijzigd.";
        $_SESSION["statusCode"] = "success";
    } else {
        $_SESSION["status"] = "Er is iets fout gegaan.";
        $_SESSION["statusCode"] = "error";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/melding.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> <!-- Jquery for the mobile nav -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet"/>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>  <!-- Custom icons from BoxIcons.com CSS -->

    <title>DTV | Wachtwoord resetten</title>
</head>
<body>
<?php include('shared/nav.php') ?>

<div class="container marginBottom">
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="loginEnRegistreerPaneel">
                <h5>Wachtwoord resetten</h5>
                <p>Hier kunt u een nieuw wachtwoord invullen</p>
                <form method="post">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                            <input type="password" placeholder="Nieuw wachtwoord" class="form-control" name="wachtwoord" required>
                            <input type="password" placeholder="Wachtwoord herhalen" class="form-control" name="wachtwoordHerhaling" required>
                        </div>
                    </div>
                    <button class="btn btn-primary">Wachtwoord veranderen</button>
                </form>
            </div>
            <?php
            if(isset($_SESSION["status"]) && $_SESSION["status"] != "") { //gebruik ik voor mijn meldingen
                ?>
                <div class="melding <?php echo $_SESSION["statusCode"]; ?>">
                    <h6><?php echo $_SESSION["status"]; ?></h6>
                </div>

                <?php
                unset($_SESSION["status"]);
            }
            ?>
        </div>
    </div>
</div>


<?php include('shared/footer.php') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
</body>
</html>
