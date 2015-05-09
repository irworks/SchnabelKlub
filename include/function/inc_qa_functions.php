<?php
function getAllQAs($queryStr = '%') {
	$rvalue 	= array();
	
	$i = 0;
	
	$minAccesslevel = 1;
	
	if(isUserSuperAdmin()) {
		$minAccesslevel = -1;
	}
	
	$query_cont = 	'SELECT
				 qaID,title,details,answer,keywords,activationlevel,askUID, username 
				 	FROM ' . FAQTABLE . ' as qa JOIN ' . USERTABLE . ' as user WHERE ' . 
				 'qa.activationlevel >= ' . cl($minAccesslevel) . ' AND qa.keywords LIKE ' . cl($queryStr) . ' AND qa.askUID = user.userID';
				 	
	$result = db_query($query_cont);
	
	while ($result && $row = $result->fetch_assoc()) {
		
		$rvalue[$i]['qaID'] 	  		= $row['qaID'];
		$rvalue[$i]['title'] 	  		= $row['title'];
		$rvalue[$i]['details'] 	   		= $row['details'];
		$rvalue[$i]['answer'] 	  	    = $row['answer'];
		$rvalue[$i]['keywords']    		= $row['keywords'];
		$rvalue[$i]['activationlevel']  = $row['activationlevel'];
		
		$rvalue[$i]['username']  		= $row['username'];
		
		$i++;
		
	}
	
	return $rvalue;
}


function submitNewQ($sarray = array()) {
	$rvalue = false;
	
	$questionTitle	  		  = $sarray['title'];
	$questionDetails  		  = $sarray['details'];
	$questionKeywords 		  = $sarray['keywords'];
	$questionUserID  	      = $sarray['userID'];
	$questionActivationLevel  = $sarray['activationlevel'];
	
	$query_cont = 	'INSERT INTO '. FAQTABLE . 
				'(title,details,keywords,askUID,activationlevel)
				 	VALUES
				 (' . cl($questionTitle) . ',' . cl($questionDetails) . ',' . cl($questionKeywords) . ',' . cl($questionUserID) . ',' . cl($questionActivationLevel) . ')';

	$result = db_query($query_cont);
	
	if($result) {
		$rvalue = true;
	}
	
	return $rvalue;

}

function editQ($sarray = array()) {
	$rvalue = false;
	
	$questionID	  		 	  = $sarray['qaID'];
	$questionTitle	  		  = $sarray['title'];
	$questionDetails  		  = $sarray['details'];
	$questionKeywords 		  = $sarray['keywords'];
	$questionAnswer 		  = $sarray['answer'];
	$questionActivationLevel  = $sarray['activationlevel'];
	
	$query_cont = 	'UPDATE '. FAQTABLE . QNL . 'SET' . QNL;
	
	if($questionTitle != '' && $questionDetails != '' && $questionKeywords != '' && $questionAnswer != '') {
		$query_cont  .= '
				title     		= ' . cl($questionTitle) . ',
				details   		= ' . cl($questionDetails) . ',
				keywords  		= ' . cl($questionKeywords) . ',
				answer  		= ' . cl($questionAnswer) . ',
				activationlevel = ' . cl($questionActivationLevel) . QNL;
	}else{
		$query_cont  .= '
				activationlevel = ' . cl($questionActivationLevel) . QNL; 
	}
	
	$query_cont  .= '
				 	WHERE
				qaID = ' . cl($questionID);

	$result = db_query($query_cont);
	
	if($result) {
		$rvalue = true;
	}
	
	return $rvalue;

}

function deleteQ($qaID) {
	$rvalue = false;
	
	$query_cont = 	'DELETE FROM '.
						 FAQTABLE . QNL .
					 'WHERE' . QNL . 
					 	'qaID = ' . cl($qaID);

	$result = db_query($query_cont);
	
	if($result) {
		$rvalue = true;
	}
	
	return $rvalue;

}

?>
