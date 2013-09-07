<?php

error_reporting(0);

require "include/db.php";

define("SCL_SETUP_VERSION",	'1');
define("SCL_SETUP_SIG",		'tmp/SCL_INSTALLED');
define("SCL_SETUP_HASH", 	md5($db_host . $db_user . $db_database . SCL_SETUP_VERSION));


$tables = array(
	'scl_changelog' =>	"CREATE TABLE IF NOT EXISTS `scl_changelog` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`product_id` int(11) NOT NULL,
					`change_id` int(11) NOT NULL,
					`release_id` int(11) DEFAULT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;",

	'scl_changes' =>	"CREATE TABLE IF NOT EXISTS `scl_changes` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`date` date NOT NULL,
					`message` varchar(256) NOT NULL,
					`is_bug` tinyint(1) DEFAULT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;",

	'scl_products' =>	"CREATE TABLE IF NOT EXISTS `scl_products` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(64) NOT NULL,
					`active` tinyint(1) NOT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;",

	'scl_releases' =>	"CREATE TABLE IF NOT EXISTS `scl_releases` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`product_id` int(11) NOT NULL,
					`version` varchar(32) NOT NULL,
					`date` date NOT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;"
);

define("OUTPUT_HEADER",		'<!DOCTYPE html>
				 <html lang="en-GB">
				 <head>
					<meta charset="UTF-8">
					<title>SCL Setup</title>
					<link rel="icon" type="image/png" href="favicon.png">
					<link href="css/scl.css" media="screen" rel="stylesheet" type="text/css">
					<style type="text/css">
						a { text-decoration: none; color: #e12b55;}
						h1 {
							width: 800px;
							margin: auto;
							padding: 10px;
							font-size: 1.4em;
							font-weight: bold;
							text-decoration: none;
							margin-bottom: 0px;
							color: #4f4b3f;
							outline: none;
							color: #e12b55;
						}
						.page {margin-bottom: 10px;}
						.err {display: block; margin-top: 5px; color: #aaa;}
					</style>
				 </head>
				 <body>
				 <h1>SuperChangelog setup</h1>');

define("OUTPUT_FOOTER",		'</body>
				 </html>');


define("OUTPUT_SUCCESS",	'<div class="page">
					<h2>Congratulations!</h2>
					<div class="products">SuperChangelog has been set up correctly.
					<a href="./">Check it out!</a></div>
				 </div>');

define("OUTPUT_FAIL",		'<div class="page">
					<h2>Setup failed!</h2>
					<div class="products">SuperChangelog was not set up correctly.
					Fix the errors above and <a href="setup.php">try again</a>.</div>
				 </div>');

define("OUTPUT_STEP", 		'<div class="page">
					<h2>%s</h2>
					<div class="products">%s</div>
				 </div>');


define("MESSAGE_DB_CONN", 	'Database connection failed. Check your settings in <code>include/db.php</code>.');
define("MESSAGE_DB_TABLES", 	'Error: could not create the required tables. Contact your system administrator.');
define("MESSAGE_TMP_DIR",	'Error: directory <code>tmp/</code> is not writable.');



$err = false;
$output = OUTPUT_HEADER;

/*****************************************************************************/

$setup_hash = file_get_contents(SCL_SETUP_SIG);
if (SCL_SETUP_HASH === $setup_hash) {
	$output .= OUTPUT_SUCCESS . OUTPUT_FOOTER;
	print($output);
	exit();
}

/*****************************************************************************/

$title = "Database connection";
$mysql = new mysqli($db_host, $db_user, $db_pass, $db_database);
if ($mysql->connect_errno) {
	$message = MESSAGE_DB_CONN;
	$message .= '<em class="err">[ Failed to connect to MySQL: ' . $mysql->connect_error . ' ]</em>';
	$err = true;
}
else {
	$message = 'OK.';
}
$output .= sprintf(OUTPUT_STEP, $title, $message);

/*****************************************************************************/

$err2 = false;
$title = "Database structure";
foreach ($tables as $table => $query) {
	$res = $mysql->query('SHOW TABLES IN ' . $db_database . ' LIKE "' . $table . '"');

	if ($res->num_rows > 0)
		continue;
	else if ($mysql->query($query) !== TRUE)
		$err2 = true;
}

if ($err2) {
	$err = true;
	$message = MESSAGE_DB_TABLES;
}
else {
	$message = 'OK.';
}
$output .= sprintf(OUTPUT_STEP, $title, $message);

/*****************************************************************************/

$title = "Temporary folder";
if (!is_writable("tmp/")) {
	$message = MESSAGE_TMP_DIR;
	$err = true;
}
else {
	$message = 'OK.';
}
$output .= sprintf(OUTPUT_STEP, $title, $message);

/*****************************************************************************/

if ($err) {
	$output .= OUTPUT_FAIL;
}
else {
	file_put_contents(SCL_SETUP_SIG, SCL_SETUP_HASH);
	$output .= OUTPUT_SUCCESS;
}

/*****************************************************************************/

$output .= OUTPUT_FOOTER;
print($output);

?>
