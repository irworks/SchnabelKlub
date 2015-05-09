<?php

require("../include/header.php");



$error 				   = false;
$errorStr			   = '';

$message		 	   = isset($_POST['message'])    	   ? 	$_POST['message']  	 : '';

$rvalue 		 	   = array();

if(!isUser()) {
	$error    = true;
	$errorStr = "403: Not authorized.";
	
	$rvalue['error']    = $error;
	$rvalue['errorStr'] = $errorStr;
	
	echo(json_encode($rvalue));
	exit(0);
}else{
	$error    = false;
	$errorStr = "200: Query okay.";
}

$rvalue['error']  	   = $error;
$rvalue['errorStr']	   = $errorStr;
$rvalue['callback']    = sendNewTweet($message);

echo(json_encode($rvalue));

?>