<?

require "./twitter-framework//autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

$access_token = $connection->oauth("oauth/request_token", array());

$url = 'https://api.twitter.com/oauth/authorize?oauth_token=' . $access_token['oauth_token'];

$loggedInStr = isset($_SESSION['ACCOUNT']) ? "Angemeldet als <b> @" . $_SESSION['ACCOUNT']['username'] . "</b> | <a href='logout.php'>Abmelden</a>" : "<a href='$url'><button class='bar-button' ><i class='fa fa-twitr fa-4'></i> Einloggen mit Twitter</button></a>";

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<title><?=$PAGENAME?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name='theme-color' content='rgb(0, 187, 184)'>

		<link rel='icon' type='image/png' href='./template/img/PerryLogo.png'>

		<link rel="stylesheet" href="./template/css/style.css" type="text/css">
		<link rel="stylesheet" href="./template/css/jquery-ui.css">
		<link rel="stylesheet" href="./template/css/color.css">

		<link rel="stylesheet" href="./font-awesome-4.3.0/css/font-awesome.min.css">

		<script src="./js/jquery.min.js"></script>
		<script src="./js/inc.js"></script>
		<? if(isUserSuperAdmin()) { ?> <script src="./js/inc-adm.js"></script>	 <? } ?>
	</head>

<body>

	<!--
	
	Herzlichen Glückwunsch, du hast ein Schnabliges EasterEgg gefunden. YAY!
	 __      _                 _          _ _   _           
	/ _\ ___| |__  _ __   __ _| |__   ___| | |_(_) ___ _ __ 
	\ \ / __| '_ \| '_ \ / _` | '_ \ / _ \ | __| |/ _ \ '__|
	_\ \ (__| | | | | | | (_| | |_) |  __/ | |_| |  __/ |   
	\__/\___|_| |_|_| |_|\__,_|_.__/ \___|_|\__|_|\___|_|   
	                                                        
	Version 0.1
	
	 -->

	<div class="mainheader">

		<ul id="nav">

			<li><img id="logo" src="./template/img/PerryLogo.png"></li>
			<li id="pageName"><?=$PAGENAME?></li>
			<li id="mobileMenu"><?=$PAGENAME?> - Menü <i class="fa fa-bars"></i></li>

			<div id="navinner">
				<li class="navitem" id="nav_1"><a class="blacklnk" href="./">Home</a></li>
				<li class="navitem" id="nav_news"><a class="blacklnk" href="./news">News</a></li>
				<? if(isUser()) { ?><li class="navitem" id="nav_dashboard"><a class="blacklnk" href="./dashboard">Dashboard</a></li> <? } ?>
				<li class="navitem" id="nav_top"><a class="blacklnk" href="./top">Topliste</a></li>
				<? if(isUserSuperAdmin()) { ?><li class="navitem" id="nav_adm-quests-review"><a class="blacklnk" href="./adm-quests-review">Review[ADM]</a></li> <? } ?>
				<!-- Ja, copyright ist doof. :( <li class="navitem" id="nav_6"><a class="blacklnk" target="_blank" href="http://schnabelklub.spreadshirt.de/">Shop</a></li> -->
				<noscript><li class="navitem warning red">Please activate JavaScript</li> </noscript>
			</div>

			<li id="login"><?=$loggedInStr?></li>



		</ul>

	</div>

	<div class="mainMobileHeader">

		<div id="nav-pages-mobile">
				<li class="navitem" id="nav_1"><a class="" href="./">Home</a></li>
				<li class="navitem" id="nav_2"><a class="" href="./news">News</a></li>
				<? if(isUser()) { ?><li class="navitem" id="nav_3"><a class="" href="./dashboard">Dashboard</a></li> <? } ?>
				<li class="navitem" id="nav_4"><a class="" href="./top">Topliste</a></li>
				<? if(isUserSuperAdmin()) { ?><li class="navitem" id="nav_5"><a class="" href="./adm-quests-review">Review [ADM]</a></li> <? } ?>
				<!-- <li class="navitem" id="nav_6"><a class="" target="_blank" href="http://schnabelklub.spreadshirt.de/">Shop</a></li> -->
				<li id="login-menu-mobile"><?=$loggedInStr?></li>
		</div>

	</div>

	<div class="container">
		<div class="popup_overlay" id="popup_overlayhandler">
			<div class="popup" id="popup_content">
				<div class="alert">
					<h3 id="alert-title"></h3>
					<button class='blue-button' id='close-dialog'>OK</button>
				</div>

				<div class="tweet-window">
					<h3 id="tweet-window-title">Tweet veröffentlichen</h3>
					<textarea class="textArea" id="tweetTextField" placeholder="Ein Schnabliger Tweet" maxlength="140"></textarea> <br><br>
					<? // <input class="textField" id="tweetTextField" type="text" placeholder="Ein Schnabliger Tweet" maxlength="140"> <br> <br> ?>
					<button class='button' id='close-tweet-dialog'>Abbrechen</button>
					<button class='blue-button' id='submit-tweet-dialog'>Losschnabeln!</button>
				</div>
			</div>
		</div>
