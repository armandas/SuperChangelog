<?php

error_reporting(E_ALL);

require_once('include/db.php');

$mysql = new mysqli($db_host, $db_user, $db_pass, $db_database);

if ($mysql->connect_errno) {
	print("Failed to connect to MySQL: " . $mysql->connect_error);
}

$product_list_query = "SELECT p.name, p.id, p.active, r.version
		       FROM products AS p
		       LEFT JOIN releases as r ON p.id = r.product_id
		       LEFT JOIN releases AS r2 ON (r.product_id = r2.product_id AND r2.date > r.date)
		       WHERE r2.date IS NULL";

$add_release_query = "INSERT INTO releases (id, product_id, version, date)
		      VALUES (NULL, ?, ?, CURDATE())";

$add_product_query = "INSERT INTO products (id, name, active)
		      VALUES (NULL, ?, 1)";

if (isset($_GET['product_list'])) {
	$products = array();

	$res = $mysql->query($product_list_query);
	while ($row = $res->fetch_assoc()) {
		$products[] = array(
			"id" => $row['id'],
			"name" => $row['name'],
			"release" => $row['version'],
			"active" => $row['active']
		);
	}

	print(json_encode($products));
}

if (isset($_POST['release']) && isset($_POST['new_version'])) {
	$statement = $mysql->prepare($add_release_query);
	$statement->bind_param('is', $_POST['release'], $_POST['new_version']);
	$statement->execute();
	$statement->close();

	header('Location: ' . $_SERVER['HTTP_REFERER'] . '#release');
}

if (isset($_POST['new_product']))
{
	$statement = $mysql->prepare($add_product_query);
	$statement->bind_param('s', $_POST['new_product']);
	$statement->execute();
	$statement->close();

	header('Location: ' . $_SERVER['HTTP_REFERER'] . '#admin');
}

$mysql->close();

?>
