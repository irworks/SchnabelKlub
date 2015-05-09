<?

function getCurrentQuestForUser($userID = -1) {

	$rvalue = array();
	
	$query_cont = 'SELECT questName,questDescription,questScore,questShowTweetBtn,questEnabled
					 FROM ' . QUESTTABLE . ' JOIN ' . USERTABLE . ' 
				 WHERE 
				 	currentQuest = questID AND userID = ' . cl($userID);
				 	
	$result = db_query($query_cont);

	if ($result) {
		$row = $result->fetch_assoc();
		$rvalue['title'] 	     = $row['questName'];
		$rvalue['description']   = $row['questDescription'];
		$rvalue['score']	     = $row['questScore'];
		$rvalue['showTweetBtn']	 = $row['questShowTweetBtn'];
		$rvalue['enabled']		 = $row['questEnabled'];
	}

	return $rvalue;
	
}

function getCurrentQuestIDForUser($userID = -1) {

	$rvalue = array();
	
	$query_cont = 'SELECT questID
					 FROM ' . QUESTTABLE . ' JOIN ' . USERTABLE . ' 
				 WHERE 
				 	currentQuest = questID AND userID = ' . cl($userID);
				 	
	$result = db_query($query_cont);

	if ($result) {
		$row = $result->fetch_assoc();
		$rvalue = $row['questID'];
	}

	return $rvalue;
	
}

function getDoneQuestsForUser($userID = -1) {

	$rvalue = array();
	
	$query_cont = 'SELECT questName,questLogMessage,questScore,questLogTimestamp
					 FROM ' . QUESTTABLE . ' JOIN ' . QUESTLOGTABLE . ' 
				 WHERE 
				 	questID = questIdConnection AND questLogUserID = ' . cl($userID) . ' AND questReviewed = 1';
				 	
	$result = db_query($query_cont);
	
	$i = 0;

	while ($result && $row = $result->fetch_assoc()) {
	
		$rvalue[$i]['title'] 	     = $row['questName'];
		$rvalue[$i]['message']   	 = $row['questLogMessage'];
		$rvalue[$i]['score']	     = $row['questScore'];
		$rvalue[$i]['timestamp']	 = $row['questLogTimestamp'];
		
		$i++;
	}

	return $rvalue;
	
}

function getPedningQuests() {

	$rvalue = array();
	
	$query_cont = 'SELECT questName,questLogMessage,questScore,questLogTimestamp,displayName,username,questLogID,userID
					 FROM ' . QUESTTABLE . ' JOIN ' . QUESTLOGTABLE . ' JOIN ' . USERTABLE . ' 
				 WHERE 
				 	questID = questIdConnection AND questLogUserID = userID AND questReviewed = 0';
				 	
	$result = db_query($query_cont);
	
	$i = 0;

	while ($result && $row = $result->fetch_assoc()) {
	
		$rvalue[$i]['ID'] 	 	     = $row['questLogID'];
		$rvalue[$i]['title'] 	     = $row['questName'];
		$rvalue[$i]['message']   	 = $row['questLogMessage'];
		$rvalue[$i]['score']	     = $row['questScore'];
		$rvalue[$i]['timestamp']	 = $row['questLogTimestamp'];
		
		$rvalue[$i]['userID']	 	 = $row['userID'];
		$rvalue[$i]['username']	 	 = $row['username'];
		$rvalue[$i]['displayName']	 = $row['displayName'];
		
		$i++;
	}

	return $rvalue;
	
}

function submitNewQuest($twitterURL = '') {
	
	$rvalue = false;
	
	$query_cont = 'INSERT INTO ' . QUESTLOGTABLE . ' 
				   		(questLogUserID,questLogMessage,questLogTimestamp,questIdConnection)' . QNL .
				   'VALUES(' . QNL .
				   		cl(getUserID()) . ',' . cl($twitterURL) . ',' . cl(time()) . ',' . getCurrentQuestIDForUser(getUserID()) . ')';
	
	$result = db_query($query_cont);
	
	if($result) {
		$rvalue = toggleQuestEnabledStatusForUser(getUserID(), 0);	
	}
	
	return $rvalue;	
}

function withdrawQuest() {
	
	$rvalue = false;
	
	$userID = getUserID();
	
	$query_cont = 'DELETE FROM ' . QUESTLOGTABLE . QNL . 
				   'WHERE questLogUserID = ' . cl($userID) . ' AND questReviewed = 0';
	
	$result = db_query($query_cont);
	
	if($result) {
		$rvalue = toggleQuestEnabledStatusForUser($userID, 1, 0);	
	}
	
	return $rvalue;	
}

function denyQuest($questLogID = -1, $userID = -1) {
	
	$rvalue = false;
	
	$query_cont = 'DELETE FROM ' . QUESTLOGTABLE . QNL . 
				   'WHERE questLogID = ' . cl($questLogID);
	
	$result = db_query($query_cont);
	
	if($result) {
		$rvalue = toggleQuestEnabledStatusForUser($userID, 1, 0);	
	}
	
	return $rvalue;	
}

function approveQuest($questLogID = -1, $score = 0, $userID = -1) {
	
	$rvalue = false;
	
	$query_cont = 'UPDATE ' . QUESTLOGTABLE . ' 
				   		SET questReviewed = 1' . QNL .
				   'WHERE questLogID = ' . cl($questLogID);
	
	$result = db_query($query_cont);
	
	if($result) {
		$rvalue = toggleQuestEnabledStatusForUser($userID, 1, $score);	
	}
	
	return $rvalue;	
}

function checkCurrentRankStatus($userID = -1) {
	
	$result = false;
	
	$query_cont = 'SELECT currentRank,currentScore,rankMinScore
					 FROM ' . USERTABLE . ' JOIN ' . RANKTABLE . QNL . ' 
				 WHERE 
				 	rankID = currentRank + 1 AND userID = ' . cl($userID);
				 	
	$result = db_query($query_cont);

	if ($result) {
	
		$row = $result->fetch_assoc();
	
		$currentScore  = $row['currentScore'];
		$rankMinScore  = $row['rankMinScore'];
		
		$_SESSION['ACCOUNT']['currentScore'] = $currentScore;
		
		if($currentScore >= $rankMinScore) {
			
			increaseUserRank($userID);
			
		}
	}

	return $result;
}

function increaseUserRank($userID = -1) {
	
	$result = false;
	
	$query_cont = 'UPDATE ' . USERTABLE . ' 
				   		SET' . QNL .
				   'currentRank = currentRank + 1' . QNL . 
				   	   'WHERE userID = ' . cl($userID);
	
	$result = db_query($query_cont);
	
	return $result;
	
}

function toggleQuestEnabledStatusForUser($userID = -1, $stat = 0, $score = 0) {
	$rvalue = false;
	
	$query_cont = 'UPDATE ' . USERTABLE . ' 
				   		SET' . QNL .
				   'questEnabled = ' . cl($stat) . QNL . ',' . QNL .
				   'currentScore = currentScore + ' . cl($score) . QNL;
				   
	if($score > 0 ){
		$query_cont .= 	',currentQuest = currentQuest + 1' . QNL;
	}
	
	$query_cont .= 	   'WHERE userID = ' . cl($userID);
	
	$result = db_query($query_cont);
	
	$rvalue = $result;
	
	if($result) {
		checkCurrentRankStatus($userID);
	}
	
	return $rvalue;	
}


?>