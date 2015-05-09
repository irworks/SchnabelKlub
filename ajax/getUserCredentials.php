<?php
	/**
	 * Created by PhpStorm.
	 * User: abenet
	 * Date: 4/25/15
	 * Time: 9:33 PM
	 */

	require("../include/header.php");

	$error = false;
	$errorStr = '';

	$message = isset($_POST['message']) ? $_POST['message'] : '';

	$rvalue = array();

	if (!isUser()) {
		$error = true;
		$errorStr = "403: Not authorized.";

		$rvalue['error'] = $error;
		$rvalue['errorStr'] = $errorStr;

		echo(json_encode($rvalue));
		exit(0);
	} else {
		$error = false;
		$errorStr = "200: Query okay.";
	}

	$userCont = getUser(getUsername());


	$queryCont = 'SELECT username, displayName, displayBio, currentQuest, currentRank, currentScore
					FROM ' . USERTABLE . '
					WHERE username = \'' . $userCont[0]['username'] . '\'';

	$result = db_query($queryCont);

	$i = 0;

	while($result && $row = $result->fetch_assoc()) {
		$rvalue[$i]['username'] = $row['username'];
		$rvalue[$i]['displayName'] = $row['displayName'];
		$rvalue[$i]['displayBio'] = $row['displayBio'];
		$rvalue[$i]['currentQuest'] = $row['currentQuest'];
		$rvalue[$i]['currentRank'] = $row['currentRank'];
		$rvalue[$i]['currentScore'] = $row['currentScore'];
		$i++;
	}

	$rvalue['error']  	   = $error;
	$rvalue['errorStr']	   = $errorStr;

	echo json_encode($rvalue);

?>

