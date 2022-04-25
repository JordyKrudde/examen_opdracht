<?php
session_start();
require_once ("db/dbconfig.php");
$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect
$lidID = $_SESSION["lidID"];

if(isset($_SESSION["lidID"]) && !empty($_SESSION["lidID"])) { //als de gebruiker gezet is mag hij hier komen
//selecteert hier alle gegevens van het lid
$sql = $con->prepare("SELECT * FROM lid WHERE lid_id = :lidID");
$sql->bindParam(":lidID", $lidID);
$sql->execute();
$result = $sql->fetch();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/profiel.css">
    <link rel="stylesheet" href="css/melding.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> <!-- Jquery for the mobile nav -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet"/>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>  <!-- Custom icons from BoxIcons.com CSS -->

    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet"> <!-- Datatables bootstrapp 5 theme-->

    <title>DTV | Profiel gegevens</title>
</head>
<body>
    <?php include('shared/nav.php') ?>

    <div class="container">
      <form class="editGegevens" method="post" action="actions/update-gegevens.php">
        <div class="row d-flex justify-content-center">
          <div class="col-md-4">
            <div class="menu-lijst">
              <div>
                  <ul>
                      <li><a href="profiel-gegevens.php">Profielgegevens</a></li>
                      <li><a href="overzicht-toernooien.php">Overzicht toernooien</a></li>
                      <li><a href="gereserveerd-door-mij.php">Gereserveerd door mij</a></li>
                      <li><a href="actions/uitloggen.php">Uitloggen</a></li>
                  </ul>
              </div>
            </div>
          </div>
          <div class="col-md-8" style="padding-top: 20px;">
            <h4>Profiel gegevens</h4>

              <?php //als het telefoonnummer nog mist dan komt er ook niks te staan
              if ($result["lid_tel"] == null) {
                  $lidTel = "";
              } else {
                  $lidTel = $result["lid_tel"];
              }
              ?>

                <input type="text" placeholder="Voornaam..." value="<?php echo $result["lid_vnaam"] ?>" name="edit-naam" class="form-control">
                <input type="text" placeholder="Tussenvoegsel..." value="<?php echo $result["lid_tvoegsel"] ?>" name="edit-tusv" class="form-control">
                <input type="text" placeholder="Achternaam..." value="<?php echo $result["lid_anaam"] ?>" name="edit-achternaam" class="form-control">
                <input type="email" placeholder="Email..." value="<?php echo $result["lid_email"] ?>" name="edit-email" class="form-control">
                <input type="tel" placeholder="Telefoonnummer..." value="<?php echo $lidTel ?>" name="edit-tel" class="form-control">
                <input type="password" placeholder="Wachtwoord..." value="" name="edit-password" class="form-control">

                <button class="btn btn-primary" type="submit">Bijwerken</button>

              <?php
              if(isset($_SESSION["status"]) && $_SESSION["status"] != "") { //gebruik ik voor mijn meldingen
                  ?>
                  <div class="melding <?php echo $_SESSION["statusCode"]; ?>" style="width: 100%;">
                      <h6><?php echo $_SESSION["status"]; ?></h6>
                  </div>

                  <?php
                  unset($_SESSION["status"]);
              }
              ?>
          </div>
        </div>
      </form>
    </div>


    <?php
    } else {
        header ("Location: login.php");
    }

    include('shared/footer.php')
    ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
