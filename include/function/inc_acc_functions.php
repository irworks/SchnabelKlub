<?php

require "/var/www/virtual/irworks/betaschnabel.irworks.de/twitter-framework/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

function loginUser($username) {

	$rvalue = array();

	$query_cont = 'SELECT
		 userID,username,currentRank,currentScore
		 	FROM ' . USERTABLE . '
		 	WHERE
		 username = ' . cl($username);

	$result = db_query($query_cont);

	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['ACCOUNT']['oauth_token'], $_SESSION['ACCOUNT']['oauth_token_secret']);
	$content = $connection->get("users/show", array("user_id" => $_SESSION['ACCOUNT']['twitterID']));

	if ($result) {
		$row = $result->fetch_assoc();
		$rvalue['lstat'] 	    = true;
		$rvalue['error'] 	    = 'Login okay.';
		$rvalue['userID'] 	    = $row['userID'];
		$rvalue['username']     = $row['username'];
		$rvalue['currentRank']  = $row['currentRank'];
		$rvalue['currentScore'] = $row['currentScore']; 
		$rvalue['twitterInfo']  = $content;

		if ($rvalue['username'] == null || $rvalue['username'] == '') {
		
			createUser($rvalue);
			$rvalue = loginUser($username);
		} else {
			updateUserOnLogin($rvalue['userID'], $content);
		}
	}

	return $rvalue;


}

function createUser($userInfo) {

	$username = $_SESSION['ACCOUNT']['username'];

	$twitterID = $_SESSION['ACCOUNT']['twitterID'];
	$twitterInfo = $userInfo['twitterInfo'];

	$imageURL = $twitterInfo->profile_image_url_https;
	$imageURL = str_replace('_normal', '', $imageURL);

	$token = $_SESSION['ACCOUNT']['oauth_token'];
	$token_secret = $_SESSION['ACCOUNT']['oauth_token_secret'];
	
	//var_dump($userInfo);

	$query_cont =
	'INSERT INTO ' . USERTABLE .
		'(twitterID,username,displayname,displayBio,displayProfileImage,oauthToken,oauthTokenSecret,firstLogin)
	VALUES 
(' . cl($twitterID) . ',' . cl($username) . ',' . cl($twitterInfo->name) . ',' . cl($twitterInfo->description) . ',' . cl($imageURL) . ',' . cl($token) . ',' . cl($token_secret) . ',' . cl(time()) . ')';

	$result = db_query($query_cont);

	return $result;

}

function getUsername() {
	if (isset($_SESSION['ACCOUNT']['username'])) {
		return $_SESSION['ACCOUNT']['username'];
	} else {
		return '';
	}
}

function getUserID() {
	if (isset($_SESSION['ACCOUNT']['userID'])) {
		return $_SESSION['ACCOUNT']['userID'];
	} else {
		return '';
	}
}

function getUserLevel() {
	if (isset($_SESSION['ACCOUNT']['accesslevel'])) {
		return $_SESSION['ACCOUNT']['accesslevel'];
	} else {
		return -1;
	}
}

function updateUserOnLogin($uaID, $content) {

	$_SESSION['ACCOUNT']['userID'] = $uaID;

	$username 		= $content->screen_name;
	$displayName	= $content->name;

	$imageURL = $content->profile_image_url_https;
	$imgURL = str_replace('_normal', '', $imageURL);
	
	$query_cont = 
				'UPDATE '. USERTABLE . ' 
					SET
				username 			= ' . cl($username) . ',
				displayName 		= ' . cl($displayName) . ', 
				displayProfileImage = ' . cl($imgURL) . ',
				lastLogin			= ' . cl(time()) .'
					WHERE 
				userID 				= ' . cl($uaID);
					
	$result = db_query($query_cont);

	return $result;
}

function updateLastTweet() {

	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['ACCOUNT']['oauth_token'], $_SESSION['ACCOUNT']['oauth_token_secret']);
	$content 	= $connection->get("users/show", array("user_id" => $_SESSION['ACCOUNT']['twitterID']));

	$userAccData 						= $_SESSION['ACCOUNT']['twitterInfo'];
	
	$userAccData->status->text		 	= $content->status->text;
	
	$_SESSION['ACCOUNT']['twitterInfo'] = $userAccData;
	
	return true;
}

function getUser($username) {

	$rvalue = array();

	$query_cont =
					'SELECT username,displayName,displayBio,displayProfileImage,currentScore,rankName,userID,currentRank
						FROM ' . USERTABLE . ' JOIN ' . RANKTABLE . ' 
						 WHERE username = ' . cl($username). ' AND currentRank = rankID';

	$result =  db_query($query_cont);

	$i = 0;

	while ($result && $row = $result->fetch_assoc()) {

		$rvalue[$i]['userID']				= $row['userID'];

		$rvalue[$i]['username']				= $row['username'];
		$rvalue[$i]['displayName'] 			= $row['displayName'];
		$rvalue[$i]['displayBio'] 			= $row['displayBio'];
		$rvalue[$i]['displayProfileImage'] 	= $row['displayProfileImage'];
		$rvalue[$i]['currentScore'] 		= $row['currentScore'];
		$rvalue[$i]['currentRank']			= $row['currentRank'];
		
		$rvalue[$i]['rankName'] 			= $row['rankName'];

		$i++;

	}

	return $rvalue;
}

function getTopUsers($limit = 20) {

	$rvalue = array();
	
	$query_cont =
					'SELECT username,displayName,displayProfileImage,currentScore,rankName,currentRank
						FROM ' . USERTABLE . ' JOIN ' . RANKTABLE . ' 
						 WHERE currentRank = rankID ORDER BY currentScore DESC LIMIT ' . $limit;

	$result =  db_query($query_cont);

	$i = 0;

	while ($result && $row = $result->fetch_assoc()) {

		$rvalue[$i]['username']				= $row['username'];
		$rvalue[$i]['displayName'] 			= $row['displayName'];
		$rvalue[$i]['displayProfileImage'] 	= $row['displayProfileImage'];
		$rvalue[$i]['currentScore'] 		= $row['currentScore'];
		$rvalue[$i]['currentRank']			= $row['currentRank'];
		
		$rvalue[$i]['rankName'] 			= $row['rankName'];

		$i++;

	}

	return $rvalue;
	
}

function getRank($id) {

	$query_cont =
					'SELECT rankName
						FROM ' . RANKTABLE . ' 
						 WHERE rankID = ' . cl($id);

	$result =  db_query($query_cont);

	$i = 0;

	while ($result && $row = $result->fetch_assoc()) {

		$rvalue	= $row['rankName'];

	}

	return $rvalue;
}

function getTwitterNameByID($id) {

	$query_cont =
					'SELECT username
						FROM ' . USERTABLE . ' 
						 WHERE userID = ' . cl($id);

	$result =  db_query($query_cont);

	$i = 0;

	while ($result && $row = $result->fetch_assoc()) {

		$rvalue	= $row['username'];

	}

	return $rvalue;
}

function getScoreToNextRank() {
	
	$rvalue = 0;
	
	$query_cont = 'SELECT currentRank,currentScore,rankMinScore
					 FROM ' . USERTABLE . ' JOIN ' . RANKTABLE . QNL . ' 
				 WHERE 
				 	rankID = currentRank + 1 AND userID = ' . cl(getUserID());
				 	
	$result = db_query($query_cont);

	if ($result) {
	
		$row = $result->fetch_assoc();
	
		$currentScore  = $row['currentScore'];
		$rankMinScore  = $row['rankMinScore'];
		
		$rvalue		   = $rankMinScore - $currentScore;
	}

	return $rvalue;
}
?>