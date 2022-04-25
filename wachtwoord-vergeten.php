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

    <title>DTV | Wachtwoord vergeten</title>
</head>
<body>
<?php include('shared/nav.php') ?>

<div class="container marginBottom">
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="loginEnRegistreerPaneel">
                <h5>Wachtwoord vergeten</h5>
                <p>U krijgt een mail waar u uw wachtwoord kan resetten</p>
                <form action="actions/wachtwoordResetRequest.php" method="post">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                            <input type="email" placeholder="E-mailadres" class="form-control" required name="email">
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Mail sturen</button>
                </form>
            </div>

            <?php
            if(isset($_SESSION["status"]) && $_SESSION["status"] != "") { // gebruik ik voor mijn meldingen
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
