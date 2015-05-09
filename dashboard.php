<?php


require_once("./include/header.php");

require_once("./template/content_pre.php");

if(!isUser()) {
    require('login.php');
    require_once("./template/content_post.php");
    exit;
}

?>

<link rel="stylesheet" href="./template/css/dashboard.css" type="text/css">

<? 

updateLastTweet();

$userContent = getUser(getUsername());

$userAccData = $_SESSION['ACCOUNT']['twitterInfo'];

$imageURL	 = $userAccData->profile_image_url_https;
$imageURL	 = str_replace('_normal', '', $imageURL);

$currentRank = getRank($_SESSION['ACCOUNT']['currentRank']);

$lastTweet   = $userAccData->status->text;

$contains	 = strpos($lastTweet, "Schnabeltier");

$currPoints	 = isset($_SESSION['ACCOUNT']['currentScore'])    ? 	$_SESSION['ACCOUNT']['currentScore']  	 : 'n/a';
$currLoc	 = $userAccData->location;
$newPoints   = getScoreToNextRank();


if($currLoc == '' || $currLoc == null) {
    $currLoc =  'einem NichtBekannt1en Ort';
}

if($currentRank == '' || $currentRank == null){
    $currentRank = 'Fehler in der Matrix (Kein Rang)';
}

$currentQuest	 = array();
$currentQuest	 = getCurrentQuestForUser(getUserID());

$questEnabled    = false;

if($currentQuest['title'] == '') {
    $currentQuest['title'] 	     = 'FehlerKlub';
    $currentQuest['description'] = 'Schenke dem Team gescheite Programmierer, denn irgendwie hast du keine Quest.';
}

?>

<div id="mainContainer">

    <div id="mainContent">

        <h1 class="page-title">Dashboard - Willkommen, <?=$userAccData->name;?>!</h1><br/>
        <h2 class="bio-box"><?=$userContent[0]['displayBio'];?></h2>
        <div id="pageCont">

            <br/>
            <div class="profile-picture" style="background-image: url(<?=$imageURL;?>);"> </div>

            <div class="dash-inner-cont">

                <p>Hier sieht du eine Übersicht über deine aktuellen Punkte, die bis zum nächsten Rang.</p>

                <div class="overview-box">
                    <p><b>Deine Punktübersicht:</b></p>
                    <hr>
                    <b class="p-left"><?=$currPoints;?></b>
                    <b class="p-right"><?=$newPoints;?></b>
                    <p class="t-bottom"><small>Aktuelle Punkte / Bis zum nächsten Rang</small></p>
                </div>

                <p>Aktuell bist du ein <b><?=$currentRank;?></b>.</p>
                <p>Deine nächste Quest ist folgende <b><a href="./quest.php">"<?=$currentQuest['title'];?>"</a></b>.</p>

                <p>Und, wie ist das <b>Wetter so</b> in <?=$currLoc;?>?</p>


                <div class="mini-box">
                    <p><i id="tweet-cont">"<?=$userAccData->status->text;?>" </i>- @<?=$userAccData->screen_name;?></p>
                </div>

                <? if($contains === false) { ?>
                <p id="schnabel-check">Dein letzter Tweet enthält <b>kein</b> Schnabeltier. :( </p>
                <button class="green-button" id="new-tweet">Ändere dies <b>jetzt!</b></button>
                <?
}else{ ?>
                <p id="schnabel-check">Dein letzter Tweet ist <b>super</b>! <3</p>
                    <button class="green-button" id="new-tweet" style="display: none;">Ändere dies <b>jetzt!</b></button>
                    <? } ?>

                    <? //=var_dump($userAccData);?>

            </div>
        </div>

    </div>
    <?php
require_once("./template/content_post.php");
    ?>