<?
	$mysqli = null;
	$last_sql_query = '';
	$last_sql_error = '';

	define('DBHOST', 'localhost');
	define('DBUSER', 'irworks');
	define('DBPASSWORD', 'pass');
	define('DBDATABASE', 'name');

	define('CONSUMER_KEY', 'YOUR-KEY');
	define('CONSUMER_SECRET', 'YOUR-SEC-KEY');

	define('USERTABLE', 'user');
	define('QUESTTABLE', 'quest');
	define('QUESTLOGTABLE', 'questlog');
	define('RANKTABLE', 'rank');
	define('NEWSTABLE', 'news');

	define('QNL', "\n");

	define('SCHNABELVER', '0.1ß');

	/* -------------------------------- */

	$PAGENAME = 'SchnabelKlub';
	$PAGESLOGAN = 'YO';
	$PAGESEPARATOR = ' | ';

	$PAGENAVURL = 'schnabelklub.de';

	$PAGECOPYRIGHT = 'Copyright &copy; ' . date('Y') . ', IRgend ein Dev Team, welches kein Leben hat.';

?>