<?php

require_once("./include/header.php");

require_once("./template/content_pre.php");

if(!isUser()) {
	require('login.php');
	require_once("./template/content_post.php");
	exit;
}

header("Location: ./dashboard.php");

?>

<?php
require_once("./template/content_post.php");
?>