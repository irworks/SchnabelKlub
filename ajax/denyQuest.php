<?php

require("../include/header.php");

$error 				   = false;
$errorStr			   = '';

$questID		 	   = isset($_POST['questID'])    	   ? 	$_POST['questID']  	 : -1;
$userID			 	   = isset($_POST['userID'])      	   ? 	$_POST['userID'] 	 : 0;

$rvalue 		 	   = array();

if(!isUserSuperAdmin()) {
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

$res			 = denyQuest($questID, $userID);

if($res) {
	$error = false;
	
	$tweetApproveMessage = "@" . getTwitterNameByID($userID) . " Deine Quest im #SchnabelKlub wurde leider abgelehnt, noch ein Versuch?";

	sendNewQuestApproveTweet($tweetApproveMessage);
}

$rvalue['error'] = false;
$errorStr = "200: Query okay.";

echo(json_encode($rvalue));

?>