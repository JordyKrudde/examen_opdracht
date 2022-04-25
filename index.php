<?php 
// hier start een session
session_start() 
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/main.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> <!-- Jquery for the mobile nav -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet"/>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>  <!-- Custom icons from BoxIcons.com CSS -->
    <title>DTV | Home</title>
</head>
<body>
<?php include('shared/nav.php') ?>

<div class="hero-image">
  <div class="hero-text">
    <h1>Doetinchemse tennisvereniging</h1>
    <p>tennisvereniging in doetinchem. supermooi en hier kan je erg fijn tennissen</p>
      <?php if(isset($_SESSION["lidID"]) && $_SESSION["lidID"] != "") { ?>
          <a class="heroBtn" href="actions/uitloggen.php">Log uit</a>
      <?php } else { ?>
          <a class="heroBtn" href="login.php">Log in</a>
      <?php } ?>
  </div>
</div>

<div class="content">
  <div class="row row-content">
    <div class="col-lg-4 col-sm-6">
      <h2>Tennissen op onze mooie buiten banen</h2>
      <p>bij de Doetinchemse tennisvereniging kunt u op 5 buiten banen tennisen</p>
    </div>
    <div class="col-lg-8 col-sm-6">
      <img class="article-image" src="img/tennisfoto2.jpg" alt="article-image">
    </div>
  </div>

  <div class="row row-content">
    <div class="col-lg-4 col-sm-6">
      <h2>Squashen</h2>
      <p>bij de Doetinchemse tennisvereniging kunt u ook squashen en heeft u toegang tot 2 squashbanen</p>
    </div>
    <div class="col-lg-8 col-sm-6">
      <img class="article-image" src="img/tennisfoto3.jpg" alt="article-image">
    </div>
  </div>

</div>
    <?php include('shared/footer.php') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
</body>
</html>
