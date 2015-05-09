<?php

	require_once("./include/header.php");

	require_once("./template/content_pre.php");
	
	$currentQuest	 = array();
	$currentQuest	 = getCurrentQuestForUser(getUserID());
	
	$questEnabled    = false;
	
	if($currentQuest['title'] == '') {
		$currentQuest['title'] 	     = 'FehlerKlub';
		$currentQuest['description'] = 'Schenke dem Team gescheite Programmierer, denn irgendwie hast du keine Quest.';
	}
	
	if($currentQuest['enabled'] == 1) {
		$questEnabled = true;
	}

?>

	<link rel="stylesheet" href="./template/css/news.css" type="text/css">

	<div id="mainContainer">

	<div id="mainContent">
	
		<? if(!$questEnabled) { ?>
			<h2>Deine aktuelle Quest wird noch geprüft</h2> Bitte warte so lange, dann kannst du die nächste in Angriff nehmen! <br>
			Sollte etwas mit der alten Quest nicht stimmen, kannst du Sie hier zurückziehen:<br>
			
			<button class="green-button" id="withdraw-entry">Deine alte Quest zurückziehen</button>
			
		<?
		 	require_once("./template/content_post.php");
			exit(0);	
		}
		?>

		<h1 class="page-title"><?=$currentQuest['title'];?></h1>

		<div id="pageCont">
			<h2><?=$currentQuest['description'];?><br><br>
			<? if($currentQuest['showTweetBtn'] == 1) { ?>
				<button class="green-button" id="new-tweet"><b>Jetzt</b> twittern!</button>
				<div id="tweetToQuestEnabled"></div>
			<? }else{ ?>
				<div id="linkToQuestEnabled"></div>
				<input type="text" class="textField" id="new-entry-text" placeholder="Ein Link zu deinem Ergebnis. Bsp. http://irworks.de/tolle/url/"> <br> <br>
				<button class="green-button" id="new-entry"><b>Jetzt</b> einreichen!</button>
			
			<? } ?>
		</div>

	</div>

<?php
	require_once("./template/content_post.php");
?>