<?php


require_once("./include/header.php");

require_once("./template/content_pre.php");

if(!isUser()) {
	require('login.php');
        require_once("./template/content_post.php");
	exit;
}

?>

<link rel="stylesheet" type="text/css" href="./template/css/admin.css">

<div id='mainContainer'>
    <div id='mainContent'>
        <form class='newsForm' action="./ajax/publishNews" method="post">
            <input type="text" name="newsTitle" placeholder="newsTitle" class="newsInput newsTitleForm" autocomplete="off"> <br>
            <textarea name="newsContent" rows="8" cols="40" class="newsInput newsContentForm" placeholder="newsContent"></textarea> <br>
            <input type="submit" value="publish" class="submitButton">
        </form>
    </div>
</div>
