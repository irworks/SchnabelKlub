<?
function db_open_connection(){
	global $mysqli;
	$mysqli = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
	$mysqli->set_charset('utf8');
	if ($mysqli->connect_errno) {
		return false;
	}
	else{
		return true;
	}
}

function db_query($query, $procedure_call=false, $multi_query=false){
	global $mysqli, $last_sql_query, $last_sql_error;
	
	$out = false;
	
	if(!$mysqli){ 
		if(!db_open_connection()){
			return false;
		}
	}
	
	
	$mysqli->set_charset('utf8');
	
	if ($multi_query){
		$out = $mysqli->multi_query($query);
	}
	else{
		$out = $mysqli->query($query);
	}
	
	$last_sql_query = $query;
	if(!$out){
		$last_sql_error = $mysqli->error;
		//add_debug('db_query error for'.$query.$last_sql_error);
		if(isUserSuperAdmin()) {
			echo('db_query error for'.$query.$last_sql_error);
		}
	}
	
	if($procedure_call){
		while ($mysqli->next_result()) {
			//free each result.
			$result = $mysqli->use_result();
			if ($result instanceof mysqli_result) {
				$result->free();
			}
		}
	}
	
	return $out;
}

function db_start_transaction(){
	global $mysqli;
	if(!$mysqli){ 
		if(!db_open_connection()){
			return false;
		}
	}
	return $mysqli->autocommit(FALSE);
}

function db_commit(){
	global $mysqli;
	if(!$mysqli){ 
		if(!db_open_connection()){
			return false;
		}
	}
	return $mysqli->commit();
}

function db_rollback(){
	global $mysqli;
	if(!$mysqli){ 
		if(!db_open_connection()){
			return false;
		}
	}
	return $mysqli->rollback();
}

function db_end_transaction(){
	global $mysqli;
	if(!$mysqli){ 
		if(!db_open_connection()){
			return false;
		}
	}
	return $mysqli->autocommit(TRUE);
}

function db_affected_rows(){
	global $mysqli;
	return (isset($mysqli)?$mysqli->affected_rows:-1);
}

function db_insert_id(){
	global $mysqli;
	return (isset($mysqli)?$mysqli->insert_id:-1);
}

function db_last_error(){
	global $last_sql_error;
	return $last_sql_error;
}

function cl($data){ // Schützt vor SQL injection bei Variablen
	return (is_null($data)) ? 'NULL' : '\''. addslashes($data) .'\'';
}

function clf($data){ // Schützt vor SQL injection bei Spaltennamen
	return (is_null($data)) ? 'NULL' : '`'. addslashes(str_replace('`', '', $data)) .'`';
}

function db_implode($glue, $pieces){
	$rvalue = '';
	if(is_array($pieces)){
		foreach($pieces as $value){
			if($value != ''){
				$rvalue .= cl($value).$glue;
			}
		}
		if(strlen($rvalue) > 0){
			$rvalue = substr($rvalue, 0, strlen($glue)*-1);
		}
	}
	return $rvalue;
}
?>