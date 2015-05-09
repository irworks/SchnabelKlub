<?php

	require_once("./include/header.php");

	require_once("./template/content_pre.php");
	
	$user 	   = array();
	$user 	   = getTopUsers(20);	

?>

	<link rel="stylesheet" href="./template/css/news.css" type="text/css">

	<div id="mainContainer">

	<div id="mainContent">

		<h1 class="page-title">Die Top <?=count($user);?> Schnabeltiere!</h1>

		<div id="pageCont">
		
			<?
			
				for($i = 0; $i < count($user); $i++) {
					?>	
					<div class="mini-box">
					
						<div class="mini-profile-picture" style="background-image:<? if($user[$i]['currentRank'] >= 7) {echo(' url(./template/img/TeamBadgeBig.png),');} ?> url(<?=$user[$i]['displayProfileImage'];?>);"> </div> 
					
						<b>#<?=$i+1;?> - <?=$user[$i]['displayName'];?></b> <small>aka. <a href="./user.php?u=<?=$user[$i]['username'];?>">@<?=$user[$i]['username'];?></a></small>
						<hr>
						Ein <?=$user[$i]['rankName'];?> mit <b><?=$user[$i]['currentScore'];?> Punkten</b>
					</div>
					
					<br>
					<?
				}
			
			?>
		
		
		</div>

	</div>

<?php
	require_once("./template/content_post.php");
?>