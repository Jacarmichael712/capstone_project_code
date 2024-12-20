<?php 
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function genToken() {
    return bin2hex(random_bytes(32));
}

if(isset($_POST["send"])){
    try {
        $mail = new PHPMAILER(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sifteam05@gmail.com';
        $mail->Password = 'xkrtmgkywajoyqtt';
        /*$mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );*/
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->SMTPDebug = 0;

        $mail->setFrom('sifteam05@gmail.com');

        $mail->addAddress($_POST["email"]);
        $addr = $_POST["email"];
        $mail->isHTML(true);

        $mail->Subject = "Password Reset";
        $token = genToken();
        $_SESSION['token'] = $token;
        $mail->Body = "Click the following link to reset your password: <a href='http://team05sif.cpsc4911.com/S24-Team05/account/reset_password.php?token=$token'>Reset Password</a>";
        $mail->send();
        echo
            "
            <script>
            alert('Sent Successfully');
            document.location.href = 'credentials.php';
            </script>
            ";      
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>