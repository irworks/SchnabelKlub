<?php 

require "/var/www/virtual/irworks/betaschnabel.irworks.de/twitter-framework/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

function sendNewTweet($message) {

	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['ACCOUNT']['oauth_token'], $_SESSION['ACCOUNT']['oauth_token_secret']);
	$content = $connection->post("statuses/update", array("status" => $message));
	
	return $content;
	
}

function sendNewQuestApproveTweet($message) {

	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, "BLAH", "CRAP");
	$content = $connection->post("statuses/update", array("status" => $message));
	
	return $content;
	
}