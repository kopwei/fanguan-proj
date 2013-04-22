<?php
//session_start();

//$file = '/tmp/test';
//$handle = fopen($file, 'w');

//fwrite($handle, $_POST['name']);
//fclose($handle);
//

require_once 'PHPMailer/class.phpmailer.php';
$infoArray = array(
'name' => $_POST['name'],
'email' => $_POST['email'],
'phone' => $_POST['phone'],
'amount' => $_POST['amount'],
'message' => $_POST['message']
);

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->CharSet = 'utf8';

$mail->Username = 'fanguan.youxiang@gmail.com';
$mail->Password = 'passworD';
$mail->From = $infoArray['email'];
$mail->FromName = $infoArray['name'];


$mail->Subject = 'Fanguan mail test';
$mail->Body = "This is a test mail";
$mail->IsHTML(true);
$mail->AddAddress("fanguan.youxiang@gmail.com", 'fanguan');

if(!$mail->Send()) {        
    echo "Mailer Error: " . $mail->ErrorInfo;        
} else {        
    echo "Message sent!";        
}
//echo json_encode($infoArray);

