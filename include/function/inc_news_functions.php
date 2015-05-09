<?
	function getAllNews($newsID = -1) {
		$rvalue = array();

		$i = 0;

		$query_cont = 'SELECT
				  newsTitle,newsContent,newsAuthorID,newsTimestamp,username,displayName
				 	FROM ' . NEWSTABLE . QNL . 
				 	'JOIN' . QNL . USERTABLE . QNL . 
				 	'WHERE
				  newsAuthorID = userID';
				 	
		if($newsID != -1) {
			$query_cont .= 'AND newsID = ' . cl($newsID);
		}

		$result = db_query($query_cont);

		while ($result && $row = $result->fetch_assoc()) {

			$rvalue[$i]['newsTitle']		= $row['newsTitle'];
			$rvalue[$i]['newsContent'] 		= $row['newsContent'];
			$rvalue[$i]['newsAuthorID'] 	= $row['newsAuthorID'];
			$rvalue[$i]['newsTimestamp'] 	= $row['newsTimestamp'];
			
			$rvalue[$i]['username'] 		= $row['username'];
			$rvalue[$i]['displayName'] 		= $row['displayName'];

			$i++;

		}

		return $rvalue;
	}
	
?>