<?php
	require_once("./include/header.php");

	require_once("./template/content_pre.php");
	
?>


<div id="mainContainer">

	<div id="mainContent">

	<h1 class="page-title">Spenden</h1>
		<div id="pageCont">
			<p>Du findest Projekt so bescheuert, dass du <b>wirklich</b> echtes Geld hierein investieren <b>möchtest</b>?</p>
			<p>Hier hast du die ultimative möglichkeit ein wenig Geld in die Merch-Kasse zu werfen, ungelogen, wir würden von dem Geld die "eigenen Shirts" aus dem Shop kaufen!</p>
		
		
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="V44GAQ68LZVRW">
				<input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
				<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
			</form>


		</div>
		
	</div>
	
<?php
	require_once("./template/content_post.php");
?>