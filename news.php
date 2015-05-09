<?php
	/**
	 * Created by PhpStorm.
	 * User: abenet
	 * Date: 4/21/15
	 * Time: 11:21 AM
	 */

	require_once("./include/header.php");

	require_once("./template/content_pre.php");

	$allNews = array();
	$allNews = getAllNews();

?>

	<link rel="stylesheet" href="./template/css/news.css" type="text/css">

	<div id="mainContainer">

	<div id="mainContent">

		<h1 class="page-title">News</h1>

		<div id="pageCont">

			<div class="news">
				<hr width="95%">

				<?

					for ($i = 0; $i < count($allNews); $i++) {
						?>
						<div class="news-element" id="news-element_<?= $i; ?>">
							<h2 class='news-title'><?= $allNews[$i]['newsTitle'];?></h2>

							<p class='news-content news-inner'><?=$allNews[$i]['newsContent']; ?></p>
							<? $formatedDate = date("d.m.Y", $allNews[$i]['newsTimestamp']); ?>
							<small class="news-inner">Veröffentlicht am <b><?= $formatedDate; ?></b> von <a href="./user.php?u=<?=$allNews[$i]['username'];?>"><b><?=$allNews[$i]['displayName']; ?></a></b></small>
							<br>
						</div>

					<?

					}

				?>
			</div>

		</div>

	</div>

<?php
	require_once("./template/content_post.php");
?>