<?php
include 'db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';
function generateRandomCode($length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $randomChar = $characters[rand(0, strlen($characters) - 1)];
        $code .= $randomChar;
    }

    return $code;
}

if(isset($_GET['email']) && $_GET['email'] != ''){
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kpajarillo_20ln1974@psu.edu.ph';
    $mail->Password = 'fcbwganrzzcjrapp';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('kpajarillo_20ln1974@psu.edu.ph');
    $mail->addAddress($_GET['email']);
    $mail->isHTML(true);
    $mail->Subject = "Code Verification";

    $code1 = generateRandomCode(100);
    $code2 = generateRandomCode(100);
    $code3 = generateRandomCode(100);
    $code4 = generateRandomCode(100);
    $code5 = generateRandomCode(100);
    $code = $code1.''.$code2.''.$code3.''.$code4.''.$code5;

    $mail->Body = 'This is your code: '.$code;
    $row = $conn->query('SELECT * from users where email="'.$_GET['email'].'"')->fetch_row();

    if($row > 0){
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            $conn->query('UPDATE users  SET reset_code="'.$code.'" WHERE email="'.$_GET['email'].'"');
            echo 'Message has been sent';
        }
    } else {
        echo 'Email is not registered!';
    }
} else {
    echo 'Please enter a valid email';
}