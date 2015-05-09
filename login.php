<div class="background-img"></div>
<link rel="stylesheet" href="./template/css/start.css" type="text/css">
<?php

$oauth_token  		= isset($_GET['oauth_token']) 		? 		$_GET['oauth_token'] 		:		 '';
$oauth_verifier		= isset($_GET['oauth_verifier']) 	? 		$_GET['oauth_verifier'] 	:		 '';


if($oauth_token != '') {
	
	$_SESSION['ACCOUNT']['oauth_token']    = $oauth_token;
	$_SESSION['ACCOUNT']['oauth_verifier'] = $oauth_verifier;

	
	$access_data 		= $connection->oauth("oauth/access_token", array("oauth_token" => $oauth_token, "oauth_verifier" => $oauth_verifier));
	
	$consumerKey 		= $access_data['oauth_token'];
	$consumerKeySecret  = $access_data['oauth_token_secret'];
	
	$_SESSION['ACCOUNT']['oauth_token'] 	   = $consumerKey;
	$_SESSION['ACCOUNT']['oauth_token_secret'] = $consumerKeySecret;
	$_SESSION['ACCOUNT']['username']		   = $access_data['screen_name'];
	$_SESSION['ACCOUNT']['twitterID']		   = $access_data['user_id'];
	
	$loginRes = loginUser($access_data['screen_name']);
	
	$_SESSION['ACCOUNT']['userID']			   = $loginRes['userID'];
	
	$_SESSION['ACCOUNT']['currentRank']		   = $loginRes['currentRank'];
	$_SESSION['ACCOUNT']['currentScore']	   = $loginRes['currentScore'];
	$_SESSION['ACCOUNT']['twitterInfo']		   = $loginRes['twitterInfo'];

	
	//var_dump($access_token);
	
	//$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $oauth_verifier);
	//$content = $connection->get("account/verify_credentials");
	
	//var_dump($_SESSION['ACCOUNT']);
	
	header('Location: ./');
}


?>
<div class="loginBox">
	<h3 id="form-title">SchnabelKlub</h4>
		<img id="login-logo-box" src="./template/img/PerryLogo.png">
		<p>Mehr Schnabel, weniger Sinn.</p>
		<a href="<?=$url;?>"><button class='button' ><i class='fa fa-twitr fa-4'></i> Einloggen mit Twitter</button></a>
</div>
        