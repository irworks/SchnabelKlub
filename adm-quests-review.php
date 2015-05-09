<?php

	require_once("./include/header.php");

	require_once("./template/content_pre.php");
	
	$access = false;
	
	$quests = array();
	if(isUserSuperAdmin()) {
		$access  = true;
		$quests  = getPedningQuests();	
	}
	

?>

	<link rel="stylesheet" href="./template/css/news.css" type="text/css">

	<div id="mainContainer">

	<div id="mainContent">

		<h1 class="page-title">Pending Quests</h1>

		<div id="pageCont">
		
		<?
		if(!$access) {
			echo('<h2>Auf diese Seite hast du leider keinen Zugriff.</h2> Diese ist intern. <br><br>');
			require_once("./template/content_post.php");
			exit(0);
		}
		?>

		<div class="user-inner-cont">
		<? for($i=0; $i < count($quests); $i++) { ?>
			<div class="mini-box" id="quest-box_<?=$quests[$i]['ID'];?>">
				<? $formatedDate = date("d.m.Y", $quests[$i]['timestamp']); ?>
				<p id="quest-error_<?=$quests[$i]['ID'];?>"></p>
				<b><?=$formatedDate;?>:</b> <?=$quests[$i]['title'];?> - <a target="_blank" href="<?=$quests[$i]['message'];?>"><b>HIER</b> Eingereichte Lösung von <?=$quests[$i]['displayName'];?> (@<?=$quests[$i]['username'];?>)</a>
				<br>
				<button id="accept-quest_<?=$quests[$i]['ID'];?>" class="green-button accept-quest" data-id="<?=$quests[$i]['ID'];?>"><?=$quests[$i]['score'];?> Punkte geben</button> <br>
				<div id="quest-score_<?=$quests[$i]['ID'];?>" style="display: none;"><?=$quests[$i]['score'];?></div>
				<div id="quest-userid_<?=$quests[$i]['ID'];?>" style="display: none;"><?=$quests[$i]['userID'];?></div>
				<button class="red-button pre-delete-quest" id="pre-delete-quest_<?=$quests[$i]['ID'];?>" data-id="<?=$quests[$i]['ID'];?>">Quest ablehnen und löschen</button>
				<button style="display: none;" class="red-button real-delete-quest" id="real-delete-quest_<?=$quests[$i]['ID'];?>" data-id="<?=$quests[$i]['ID'];?>"><b>Quest löschen bestätigen</b></button>  				<br>
			</div>
			<br>
		<? } ?>
		</div>

		</div>

	</div>

<?php
	require_once("./template/content_post.php");
?>