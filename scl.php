<?php

error_reporting(E_ALL);

require_once('include/db.php');

$mysql = new mysqli($db_host, $db_user, $db_pass, $db_database);

if ($mysql->connect_errno) {
	print("Failed to connect to MySQL: " . $mysql->connect_error);
}

$product_list_query = "SELECT p.name, p.id, r.version
		       FROM products AS p
		       LEFT JOIN releases as r ON p.id = r.product_id
		       LEFT JOIN releases AS r2 ON (r.product_id = r2.product_id AND r2.date > r.date)
		       WHERE r2.date IS NULL";

if (isset($_GET['product_list'])) {
	$products = array();

	$res = $mysql->query($product_list_query);
	while ($row = $res->fetch_assoc()) {
		$products[] = array(
			"id" => $row['id'],
			"name" => $row['name'],
			"release" => $row['version']
		);
	}

	print(json_encode($products));
}

?>