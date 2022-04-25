<?php
session_start();
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use phpmailer\PHPMailer\PHPMailer;
use phpmailer\PHPMailer\SMTP;
use phpmailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

require '../db/dbconfig.php';
$con = new Dbh();
$con = $con->connect(); //hier zorg ik ervoor dat mijn object connect

if(isset($_POST["email"])) {
    $emailTo = $_POST["email"];

    $checkOfMailBestaat = $sql = $con->prepare("SELECT lid_email FROM lid WHERE lid_email = :lidEmail");
    $checkOfMailBestaat->bindParam(":lidEmail", $emailTo);
    $checkOfMailBestaat->execute();
    $result = $checkOfMailBestaat->rowCount();

    if ($result == 1) { //als je mail-adres bij ons in het systeem staat stuur hij een mail anders niet
        $code = uniqid(true); //met uniqid kan je allemaal unieke ids maken

        $url = "http://" . $_SERVER["HTTP_HOST"] . "/examen-project/wachtwoord-resetten.php?code=$code";

        $message = file_get_contents('../mail-templates/wachtwoord-vergeten.html');
        $message = str_replace('$url', $url, $message);

        $sql = $con->prepare("INSERT INTO resetwachtwoord(reset_email, reset_code) VALUES(:emailTo, :uniqCode)");
        $sql->bindParam(":emailTo", $emailTo);
        $sql->bindParam(":uniqCode", $code);
        $sql->execute();

        $mail = new PHPMailer(true);    // Instantiation and passing `true` enables exceptions

        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'mail.cafr.nl';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'mailtest@cafr.nl';                     //SMTP username
            $mail->Password = 'MailTestCaFr.nl';                               //SMTP password
            $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //$mail->SMTPDebug = SMTP::DEBUG_CONNECTION; //hiermee kan je je connectie debuggen. Handig als er iets mis mee is. Eventuele link naar meer info: https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting
            //SSL kan niet door de servers van school 😢 dus dat gaat helaas niet.
            //Recipients
            $mail->setFrom('mailtest@cafr.nl', 'DTV | Wachtwoord vergeten');
            $mail->addAddress($emailTo);     //Add a recipient


            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'DTV | Wachtwoord resetten';
            $mail->Body = $message;

            $mail->send();

            $_SESSION["status"] = "Wachtwoord reset is gestuurd naar uw email.";
            $_SESSION["statusCode"] = "success";
            header("Location: ../wachtwoord-vergeten.php");
        } catch (Exception $e) {
            $_SESSION["status"] = "Er is een fout opgetreden, probeer het later opnieuw.";
            $_SESSION["statusCode"] = "error";
            header("Location: ../wachtwoord-vergeten.php");
        }
        exit();

    } else {
        $_SESSION["status"] = "E-mailadres is niet bekend in ons systeem.";
        $_SESSION["statusCode"] = "error";
        header("Location: ../wachtwoord-vergeten.php");
    }
}





