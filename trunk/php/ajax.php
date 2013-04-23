<?php
//session_start();

//$file = '/tmp/test';
//$handle = fopen($file, 'w');

//fwrite($handle, $_POST['name']);
//fclose($handle);
//

require_once 'PHPMailer/class.phpmailer.php';

$infoArray = array(
    'name' => trim(rtrim($_POST['name'])),
    'email' => trim(rtrim($_POST['email'])),
    'phone' => trim(rtrim($_POST['phone'])),
    'amount' => trim(rtrim($_POST['amount'])),
    'message' => clean(trim(rtrim($_POST['message'])))
);

// Prevent SQL injection
function clean($str)
{
    if (!is_string($str))
    {
        return 'None';
    }
    $str = addslashes($str);
    $str = str_replace("_", "\_", $str);
    $str = str_replace("%", "\%", $str);
    return $str;
}

function validateInfo($infoArray)
{
    if ($infoArray['name'] == '' || $infoArray['email'] == '' ||
        $infoArray['amount'] == '')
    {
        return false;
    }
    $name_pattern = '/^\w+[\w\s]+\w+$/';
    $email_pattern = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
    $phone_pattern = '/^(\(\d{3,4}-)|\d{3.4}-)?\d{7,8}$/';
    $amount_pattern = '/^\+?[1-9][0-9]*$/';
    
    $name_match = preg_match($name_pattern, $infoArray['name']);
    $email_match = preg_match($email_pattern, $infoArray['email']);
    //$phone_match = preg_match($phone_pattern, $infoArray['phone']);
    $amount_match = preg_match($amount_pattern, $infoArray['amount']);

    if (1 !== $name_match || 1 !== $email_match ||
       /* 1 !== $phone_match ||*/ 1 !== $amount_match)
    {
        return false;
    }


    return true;
}

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
        returnFailure ("Mailer Error: " . $mail->ErrorInfo);        
    } else {        
        returnSuccess("Message sent!");        
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
    $amount = intval($infoArray['amount']);
    $message = $infoArray['message'];

    $sql = "INSERT INTO orders (`name`, `email`, `phone`, `number_of_people`, `time`, `message`) VALUES ('$name', '$email', '$phone', $amount, NOW(), '$message')";
    $result = $db->query($sql) or returnFailure($db->error);
    mysqli_close($db);

}

function returnFailure($message)
{
    $returnArr = array('stat' => 'fail', 'message' =>$message);
    echo json_encode($returnArr);
    exit();
}

function returnSuccess($message)
{
    $returnArr = array('stat' => 'succeed', 'message' =>$message);
    echo json_encode($returnArr);
    exit();
}

$validationResult = validateInfo($infoArray);
if (!$validationResult)
{
    returnFailure('Error in input');
}

update_db($infoArray);
send_mail($infoArray);
