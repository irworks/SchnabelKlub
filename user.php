<?php

	require_once("./include/header.php");

	require_once("./template/content_pre.php");
	
	$username		 	   = isset($_GET['u'])    	   ? 	$_GET['u']  	 : '';
	
	$notFound 			   = false; 
	
	$userBIO			   = '';
	
	$quests = array();
	
	if($username != '') {
		$user 	   = array();
		$user 	   = getUser($username);	
		if(count($user) < 1) {
			$notFound = true;
		}else{
			 $quests  = getDoneQuestsForUser($user[0]['userID']);
			 
			 $userBIO = $user[0]['displayBio'];
			 
			 if($userBIO == '') {
				 $userBIO = 'Ich habe leider keine Biografie.';
			 }
			 
		}
	}else{
		$notFound = true;
		$username = 'einem nicht gefunden Nutzer...';
	}
	

?>

	<link rel="stylesheet" href="./template/css/news.css" type="text/css">

	<div id="mainContainer">

	<div id="mainContent">

		<h1 class="page-title">Profil von @<?=$username; if(!$notFound){?> - Ein echtes <?=$user[0]['rankName'];}?></h1>

		<div id="pageCont">
		
		<?
		if($notFound) {
			echo('<h2>Diesen Nutzer gibt es bei uns leider nicht.</h2> Dieser ist wohl nicht Schnabeltier genug. :( <br><br>');
			require_once("./template/content_post.php");
			exit(0);
		}
		?>
		
			<div class="profile-picture" style="background-image: <? if($user[0]['currentRank'] >= 7) {echo('url(./template/img/TeamBadge.png),');} ?> url(<?=$user[0]['displayProfileImage'];?>);"> </div> 
			
				<div class="user-inner-cont">
					<h2><?=$user[0]['displayName'];?></h2>
			
					<i>"<?=$userBIO;?>"</i> <br>
					
					<div class="user-box">
						<p><b><?=$user[0]['displayName'];?>s Punktübersicht:</b></p>
						<hr>
						<h2><?=$user[0]['currentScore'];?></h2>
						<p>Punkte</p> 
					</div>
					
					<br>
					
				</div>
				
				<? if(count($quests) > 0 ) { ?>
				
				<div class="questlog mini-box">
				
				<b>Erledigte Quests:</b>
					<hr>
					
					<? for($i=0; $i < count($quests); $i++) { ?>
						<? $formatedDate = date("d.m.Y", $quests[$i]['timestamp']); ?>
						<b><?=$formatedDate;?>:</b> <?=$quests[$i]['title'];?> - <a target="_blank" href="<?=$quests[$i]['message'];?>">Lösung von <?=$user[0]['displayName'];?></a> // +<?=$quests[$i]['score'];?> Punkte!
						<hr>
					<? } ?>
				</div>
				
				<? } ?>
		</div>

	</div>

<?php
	require_once("./template/content_post.php");
?>