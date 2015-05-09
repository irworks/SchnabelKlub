<?php
/*
	File name: header.php
	Access: Public
	Description: Head of site,
	Creator: ~Ilja Rozhko, irworks. 26.11.2014~
	Version: 0.1
*/


//error_reporting(E_ALL);
//ini_set('display_errors', 1);

session_start(); //Start the sessions to handle login

require_once("incl_config.php"); //Get DB Names, passes and Tables
require_once("incl_db.php"); //Get Page URL
require_once("inc_function.php");

header('Content-Type: text/html; charset=utf-8'); //Set Encoding to UTF-8

?>
