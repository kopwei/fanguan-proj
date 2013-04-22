<?php

if(!$_POST) exit;

if(isset($_POST['submit']) || isset($_POST['submit_x'])){
  $email = $_POST['email'];

  //$error[] = preg_match('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $_POST['email']) ? '' : 'INVALID EMAIL ADDRESS';
  if(!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*" ."@"."([a-z0-9]+([\.-][a-z0-9]+)*)+"."\\.[a-z]{2,}"."$",$email )){
	$error.="Invalid email address entered";
	echo $error;
  }else{
	$values = array('name','email','message');
	$required = array('name','email','message');
	 
	$your_email = "james@example.com";
	$email_subject = "New Reservation: ".$_POST['amount']." seats";
	$email_content = "new message:\n";
	
	foreach($values as $key => $value){
	  if(in_array($value,$required)){
		if ($key != 'amount' && $key != 'phone') {
		  if( empty($_POST[$value]) ) { echo 'PLEASE FILL IN REQUIRED FIELDS'; exit; }
		}
		$email_content .= $value.': '.$_POST[$value]."\n";
	  }
	}
	 
	if(@mail($your_email,$email_subject,$email_content)) {
		echo 'Message sent!'; 
	} else {
		echo 'ERROR!';
	}
  }
}
?>