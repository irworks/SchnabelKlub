<?php

require("../include/header.php");

$error 				   = false;
$errorStr			   = '';

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
	$errorStr = "200: Login okay.";
}

$res			 = withdrawQuest();

if($res) {
	$error = false;
}

$rvalue['error'] = false;
$errorStr = "200: Query okay.";

echo(json_encode($rvalue));

?>