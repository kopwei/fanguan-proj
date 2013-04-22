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

function send_mail($infoArray)
{
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
    $name = $infoArray['name'];
    $email = $infoArray['email'];
    $phone = $infoArray['phone'];
    $amount = $infoArray['amount'];
    $message = $infoArray['message'];
    $mail->Body = "<html> 
        This is a test mail
        <p>name: $name  </p>
        <p>email: $email  </p>
        <p>phone: $phone </p>
        <p>amount of people: $amount </p>
        <p>message: $message </p>
        </html>";
    $mail->IsHTML(true);
    $mail->AddAddress("fanguan.youxiang@gmail.com", 'fanguan');

    if(!$mail->Send()) {        
        echo "Mailer Error: " . $mail->ErrorInfo;        
    } else {        
        echo "Message sent!";        
    }
}

function update_db($infoArray)
{
    $host = '127.0.0.1';
    $username = 'root';
    $password = 'root';
    $dbname = 'fanguan';


    $db = new mysqli($host, $username, $password, $dbname);
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $name = $infoArray['name'];
    $email = $infoArray['email'];
    $phone = $infoArray['phone'];
    $amount = $infoArray['amount'];
    $message = $infoArray['message'];

    $sql = "INSERT INTO orders (`name`, `email`, `phone`, `number_of_people`, `time`, `message`) VALUES ('$name', '$email', '$phone', '$amount', NOW(), '$message')";
    $result = $db->query($sql) or die($db->error);
    mysqli_close($db);

}

update_db($infoArray);
send_mail($infoArray);
