<?php

error_reporting(0);

require "include/db.php";

define("SCL_SETUP_VERSION",	'1');
define("SCL_SETUP_SIG",		'tmp/SCL_INSTALLED');
define("SCL_SETUP_HASH", 	md5(DB_HOST . DB_USER . DB_DATABASE . SCL_SETUP_VERSION));

$functions = array(
	"json_encode",
	"array_key_exists",
	"file_put_contents",
	"file_get_contents",
	"property_exists",
);

$classes = array(
	"mysqli" => array(
		"query",
		"prepare",
		"close"
	),
	"mysqli_stmt" => array(
		"bind_param",
		"execute",
		"bind_result",
		"fetch"
	),
	"mysqli_result" => array(
		"fetch_assoc"
	)
);

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
					Please fix the errors above and <a href="setup.php">try again</a>.</div>
				 </div>');

define("OUTPUT_STEP", 		'<div class="page">
					<h2>%s</h2>
					<div class="products">%s</div>
				 </div>');


define("MESSAGE_OK", 		'OK.');
define("MESSAGE_DB_CONN", 	'Database connection failed. Check your settings in <code>include/db.php</code>.');
define("MESSAGE_DB_TABLES", 	'Error: could not create the required tables. Contact your system administrator.');
define("MESSAGE_TMP_DIR",	'Error: cannot write to <code>tmp/</code> directory. Check that the folder exits
				 and has correct permissions.');
define('MESSAGE_PHP',		'%s
				 <a target="_blank" href="http://php.net/manual-lookup.php?pattern=%2$s">%2$s</a>
				 is not available.<br>');
define('MESSAGE_COMPAT',	'<br>Due to compatibility errors, SCL setup cannot be continued.
				 Please fix the errors above and <a href="setup.php">try again</a>.');




$err = false;
$output = OUTPUT_HEADER;

/*****************************************************************************/
/* Check PHP compatibility. If this step fails, the setup cannot continue.   */
/*****************************************************************************/
$title = "PHP compatibility";
$message = '';
foreach ($functions as $function) {
	if (!function_exists($function)) {
		$message .= sprintf(MESSAGE_PHP, 'Function', $function);
		$err = true;
	}
}

foreach ($classes as $class => $methods) {
	if (!class_exists($class)) {
		$message .= sprintf(MESSAGE_PHP, 'Class', $class);
		$err = true;
		continue;
	}

	foreach ($methods as $method) {
		if (!method_exists($class, $method)) {
			$message .= sprintf(MESSAGE_PHP, 'Method', $class . '::' . $method);
			$err = true;
		}
	}
}

if($err) {
	$message .= MESSAGE_COMPAT;

	$output .= sprintf(OUTPUT_STEP, $title, $message);
	$output .= OUTPUT_FOOTER;
	print($output);
	exit();
}

/*****************************************************************************/
/* Check for setup signature and quit if the system is already set up.       */
/*****************************************************************************/
$setup_hash = file_get_contents(SCL_SETUP_SIG);
if (SCL_SETUP_HASH === $setup_hash) {
	$output .= OUTPUT_SUCCESS . OUTPUT_FOOTER;
	print($output);
	exit();
}

/*****************************************************************************/
/* Check database settings.                                                  */
/*****************************************************************************/
$title = "Database connection";
$mysql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
if ($mysql->connect_errno) {
	$message = MESSAGE_DB_CONN;
	$message .= '<em class="err">[ Failed to connect to MySQL: ' . $mysql->connect_error . ' ]</em>';
	$err = true;
}
else {
	$message = MESSAGE_OK;
}
$output .= sprintf(OUTPUT_STEP, $title, $message);

/*****************************************************************************/
/* Check database tables and create them if necessary.                       */
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
	$message = MESSAGE_OK;
}
$output .= sprintf(OUTPUT_STEP, $title, $message);

/*****************************************************************************/
/* Check that the temporary folder exists and is writable.                   */
/*****************************************************************************/
$title = "Temporary folder";
if (!is_writable("tmp/")) {
	$message = MESSAGE_TMP_DIR;
	$err = true;
}
else {
	$message = MESSAGE_OK;
}
$output .= sprintf(OUTPUT_STEP, $title, $message);

/*****************************************************************************/
/* Print the result and create the setup signature if successful.            */
/*****************************************************************************/
if ($err) {
	$output .= OUTPUT_FAIL;
}
else {
	file_put_contents(SCL_SETUP_SIG, SCL_SETUP_HASH);
	$output .= OUTPUT_SUCCESS;
}

$output .= OUTPUT_FOOTER;
print($output);

?>
