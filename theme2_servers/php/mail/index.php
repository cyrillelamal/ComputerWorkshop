<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once './vendor/autoload.php';

echo <<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPMailer</title>
</head>
<body>
    <form action="/index.php" method="post">
        <div>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <input type="submit" value="subscribe">
        </div>
    </form>
</body>
</html>
EOT;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_REQUEST['email'];

    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "ssl://smtp.gmail.com";
    $mail->Port = 587; // or 465

    $mail->IsHTML(true);
    $mail->Username = "cyril2lambda@gmail.com";
    $mail->Password = getenv('GMAIL_PASSWORD');
    $mail->SetFrom("cyril2lambda@gmail.com", 'Cyrille');
    $mail->Subject = "Test";
    $mail->Body = "hello";
    $mail->AddAddress($email);

    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo '<pre>';
        echo "Message has been sent";
    }

}
