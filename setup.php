<!DOCTYPE html>

<html lang="en-GB">
<head>
	<meta charset="UTF-8">
	<title>SCL Setup</title>
	<link rel="icon" type="image/png" href="favicon.png">
	<link href="css/scl.css" media="screen" rel="stylesheet" type="text/css">
	<script src="js/jquery-2.0.3.min.js" type="text/javascript"></script>
	<script src="js/jquery_extensions.js" type="text/javascript"></script>
	<script src="js/scl.js" type="text/javascript"></script>
	<script src="js/scl_handlers.js" type="text/javascript"></script>
</head>

<body>

<pre>
<?php

require "include/db.php";

$mysql = new mysqli($db_host, $db_user, $db_pass, $db_database);

$err = false;

print("Connecting to the database...\n");
if ($mysql->connect_errno) {
	print("Failed to connect to MySQL: " . $mysql->connect_error);
	$err = true;
}
else {
	print("OK.\n\n");
}

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

print("Checking tables...\n");
foreach ($tables as $table => $query) {
	$res = $mysql->query('SHOW TABLES IN ' . $db_database . ' LIKE "' . $table . '"');

	if ($res->num_rows == 0) {
		printf("\tCreating table %s:\t", $table);
		if ($mysql->query($query) === TRUE) {
			print("OK.\n");
		}
		else {
			print(ERR);
			$err = true;
		}
	}
	else {
		printf("\t%s:\t%s", $table, "OK.\n");
	}
}
print("\n");

print("Checking temporary folder...\n");
if (!is_writable("tmp/")) {
	print("ERROR. Check permissions for tmp/.\n\n");
	$err = true;
}
else {
	print("OK.\n\n");
}

if ($err) {
	print("Setup failed.");
}
else {
	print("SuperChangelog has been set up correctly.");
}

?>
</pre>

</body>
</html>
