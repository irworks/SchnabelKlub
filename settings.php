<?php
	/**
	 * Created by PhpStorm.
	 * User: abenet
	 * Date: 4/23/15
	 * Time: 11:39 AM
	 */

	require_once("./include/header.php");

	require_once("./template/content_pre.php");

	if (!isUser()) {
		require('login.php');
		require_once("./template/content_post.php");
		exit;
	}
	$cont = getUser(getUsername());

?>

<link rel="stylesheet" href="./template/css/dashboard.css" type="text/css">
<link rel="stylesheet" href="./template/css/settings.css" type="text/css">

<div class='userContent'>
	<div class='userContentBio'>
		<p class='useContentDescription'>User Bio -- <a onclick='editBio()' id='accessToggle'>Edit</a> </p>
		<textarea readonly class='textArea'><?=$cont[0]['displayBio'] ?></textarea>
	</div>
</div>