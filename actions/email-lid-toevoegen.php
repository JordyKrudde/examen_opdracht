<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

function lidToevoegenMail($ledenNmr, $lidEmail) {
    $url = "http://" . $_SERVER["HTTP_HOST"]. "/examen-project/login.php?email=$lidEmail&&ledenNmr=$ledenNmr";

    $message = file_get_contents('../mail-templates/lid-toevoegen.html');
    $message = str_replace('$ledenNmr', $ledenNmr, $message);
    $message = str_replace('$url', $url, $message);

//Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'mail.cafr.nl';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'mailtest@cafr.nl';                     //SMTP username
        $mail->Password = 'MailTestCaFr.nl';                               //SMTP password
        $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
//        $mail->SMTPDebug = SMTP::DEBUG_CONNECTION; //hiermee kan je je connectie debuggen. Handig als er iets mis mee is. Eventuele link naar meer info: https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting
//SSL kan niet door de servers van school 😢 dus dat gaat helaas niet.
        //Recipients
        $mail->setFrom('mailtest@cafr.nl', 'Doetinchemse tennis vereniging');
        $mail->addAddress($lidEmail);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Je bent lid geworden van de Doetinchemse tennis vereniging!';
        $mail->Body = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}