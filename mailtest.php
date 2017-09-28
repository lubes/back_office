<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'quartzb2b-com.mail.protection.outlook.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    //$mail->Username = 'registration@quartzevents.com';                 // SMTP username
    //$mail->Password = 'Soqa2697';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 25;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('registration@quartzevents.com', 'Mailer');
    $mail->addAddress('lizbormida@quartzb2b.com');     // Add a recipient
    $mail->addAddress('john.chimmy@eatsleepwork.com');               // Name is optional

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if($mail->send()){
            echo 'Message has been sent';

    } else {
        echo "error";
    }
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>
<html>
<head>

    </head>
    <body>
     <h1>Hello</h1>
    </body>
</html>