<?php

function isUser() {
	if(isset($_SESSION['ACCOUNT'])) {
		 return true;
	 }else{
		 return false;
	 }
}


function isUserSuperAdmin() {
	if(isset($_SESSION['ACCOUNT']) && $_SESSION['ACCOUNT']['currentRank'] >= 7) {
		 return true;
	 }else{
		 return false;
	 }
}

include('function/inc_acc_functions.php');

include('function/inc_news_functions.php');

include('function/inc_tweet_functions.php');

include('function/inc_quest_functions.php');


?>