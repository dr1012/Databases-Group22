


<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function send_email($emails, $subjects, $messages){

echo '<script type="text/javascript"> console.log("email function called"); </script>';


//Load composer's autoloader
require '/autoload.php';
require '/phpmailer/phpmailer/src/Exception.php';
require '/phpmailer/phpmailer/src/PHPMailer.php';
require '/phpmailer/phpmailer/src/SMTP.php';
require '/league/oauth2-google/src/Provider/Google.php';
require '/league/oauth2-google/src/Provider/GoogleUser.php';

$mail = new PHPMailer(true);   
  
for($x = 0; $x<sizeof($emails); $x++){  
    echo '<script type="text/javascript"> console.log("for loop called"); </script>';
try {

    

    echo '<script type="text/javascript"> console.log("PHPMailer object created"); </script>';
    //Server settings
    $mail->SMTPDebug = 4;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = ' smtp.live.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'dadarudolf@hotmail.fr';                 // SMTP username
    $mail->Password = 'DaRu9121994';                        // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to


    //Recipients
    $mail->setFrom('dadarudolf@hotmail.fr', 'Mailer');
    $mail->addAddress($emails[$x]);               // Name is optional


    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subjects[$x];
    $mail->Body    = $messages[$x];
   


    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}


}

}

?>
