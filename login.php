<?php
session_start();
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

    <title>DTV | Login en registreren</title>
</head>
<body>
<?php include('shared/nav.php') ?>

<div class="container marginBottom">
    <div class="row">
        <div class="col-md-6">
            <div class="loginEnRegistreerPaneel">
                <h5>Login</h5>
                <form method="post" action="actions/inloggen.php">
                    <div class="row d-flex justify-content-center">
                        <?php if (isset($_GET["email"]) && $_GET["email"] != "" || isset($_GET["ledenNmr"]) && $_GET["ledenNmr"] != "") { //als de gets gezet zijn dan moet hij de 'login' form disablen?>
                            <div class="col-md-8">
                                <input type="email" placeholder="E-mailadres" class="form-control" name="email" required disabled>
                            </div>
                            <div class="col-md-8">
                                <input type="password" placeholder="Wachtwoord" class="form-control" name="wachtwoord" required disabled>
                                <a href="wachtwoord-vergeten.php">Wachtwoord vergeten?</a>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-8">
                                <input type="email" placeholder="E-mailadres" class="form-control" name="email" required>
                            </div>
                            <div class="col-md-8">
                                <input type="password" placeholder="Wachtwoord" class="form-control" name="wachtwoord" required>
                                <a href="wachtwoord-vergeten.php">Wachtwoord vergeten?</a>
                            </div>
                        <?php } ?>

                    </div>
                    <?php if (isset($_GET["email"]) && $_GET["email"] != "" || isset($_GET["ledenNmr"]) && $_GET["ledenNmr"] != "") { //als de gets gezet zijn dan moet hij de knop 'login' disablen?>
                        <button class="btn btn-primary" type="submit" disabled>Login</button>
                    <?php } else {?>
                        <button class="btn btn-primary" type="submit">Login</button>
                    <?php } ?>
                </form>
            </div>

            <?php
            if(isset($_SESSION["status1"]) && $_SESSION["status1"] != "") { //gebruik ik voor mijn meldingen
                ?>
                <div class="melding  <?php echo $_SESSION["statusCode"]; ?>">
                    <h6><?php echo $_SESSION["status1"]; ?></h6>
                </div>

                <?php
                unset($_SESSION["status1"]);
            }
            ?>
        </div>
        <div class="col-md-6">
            <div class="loginEnRegistreerPaneel">
                <h5>Registreer</h5>
                <form action="actions/registreren.php" method="post">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                            <?php if (isset($_GET["email"]) && $_GET["email"] != "") { //als de get gezet is dan moet hij je email laten zien uit de url ?>
                                <input type="email" placeholder="E-mailadres" class="form-control" value="<?php echo $_GET["email"]?>" name="email" required>
                            <?php } else { ?>
                                 <input type="email" placeholder="E-mailadres" class="form-control" name="email" required>
                            <?php }  ?>
                        </div>
                        <div class="col-md-8">
                            <input type="password" placeholder="Wachtwoord" class="form-control" name="wachtwoord" required>
                        </div>
                        <div class="col-md-8">
                            <?php if (isset($_GET["ledenNmr"]) && $_GET["ledenNmr"] != "") { //als de get gezet is dan moet hij je ledenNmr laten zien uit de url  ?>
                                <input type="number" placeholder="Leden nummer*" class="form-control" value="<?php echo $_GET["ledenNmr"]; ?>" name="ledenNmr" required>
                                <span style="font-size:0.8em;">*Vul hier je leden nummer in om te verifiëren dat je lid bij ons bent.
                                Deze heb je in onze mail ontvangen</span>
                            <?php } else { ?>
                                <input type="number" placeholder="Leden nummer*" class="form-control" name="ledenNmr" required min="0">
                                <span style="font-size:0.8em;">*Vul hier je leden nummer in om te verifiëren dat je lid bij ons bent.
                                Deze heb je in onze mail ontvangen</span>
                            <?php }  ?>
                        </div>
                    </div>

                    <button class="btn btn-primary">Registreer</button>
            </div>
            <?php
            if(isset($_SESSION["status"]) && $_SESSION["status"] != "") { //gebruik ik voor mijn meldingen
                ?>
                <div class="melding inlogEnRegistreerMelding  <?php echo $_SESSION["statusCode"]; ?>">
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
