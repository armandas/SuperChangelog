<?php

error_reporting(E_ALL);

require "include/db.php";
require "include/queries.php";
require "include/raintpl/rain.tpl.class.php";
include "tpl/template_functions.php";

raintpl::configure('tpl_ext', 'tpl');

$tpl = new raintpl();

$mysql = new mysqli($db_host, $db_user, $db_pass, $db_database);

if ($mysql->connect_errno) {
	print("Failed to connect to MySQL: " . $mysql->connect_error);
}



if (isset($_GET['product_list'])) {
	$products = array();

	$res = $mysql->query(SQL_PRODUCT_LIST);
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

if (isset($_POST['download'])) {
	$releases = array();

	$statement = $mysql->prepare(SQL_GET_PRODUCT_NAME);
	$statement->bind_param('i', $_POST['download']);
	$statement->execute();
	$statement->bind_result($product);
	$statement->fetch();
	$statement->close();

	$statement = $mysql->prepare(SQL_GET_CHANGELOG);
	$statement->bind_param('i', $_POST['download']);
	$statement->execute();
	$res = $statement->get_result();

	while ($row = $res->fetch_assoc()) {
		if (array_key_exists($row['version'], $releases)) {
			array_push($releases[$row['version']]['changes'], $row['message']);
		}
		else {
			$tmp = $releases[$row['version']] = array(
				'date' => $row['date'],
				'changes' => array($row['message'])
			);
		}
	}

	$tpl->assign('product', $product);
	$tpl->assign('releases', $releases);
	$output = $tpl->draw('changelog', $return_string = true);

	if (isset($_POST['view'])) {
		print($output);
	}
	else {
		header("Content-type: text/plain");
		header('Content-disposition: attachment; filename="' . $product . '_CHANGELOG.txt"');
		print($output);
	}
}

if (isset($_POST['log']) && isset($_POST['change'])) {
	$statement = $mysql->prepare(SQL_ADD_CHANGE);
	$statement->bind_param('si', $_POST['change'], $_POST['is_bug_fix']);
	$statement->execute();
	$change_id = $mysql->insert_id;

	$statement = $mysql->prepare(SQL_APPEND_CHANGELOG);
	$statement->bind_param('iii', $change_id, $product, $product);

	foreach ($_POST['log'] as $product) {
		$statement->execute();
	}

	$statement->close();

	header('Location: ' . $_SERVER['HTTP_REFERER'] . '#log');
}

if (isset($_POST['release']) && isset($_POST['new_version'])) {
	$statement = $mysql->prepare(SQL_ADD_RELEASE);
	$statement->bind_param('is', $_POST['release'], $_POST['new_version']);
	$statement->execute();
	$statement->close();

	header('Location: ' . $_SERVER['HTTP_REFERER'] . '#release');
}

if (isset($_POST['new_product'])) {
	$statement = $mysql->prepare(SQL_ADD_PRODUCT);
	$statement->bind_param('s', $_POST['new_product']);
	$statement->execute();
	$statement->close();

	header('Location: ' . $_SERVER['HTTP_REFERER'] . '#admin');
}

if (isset($_POST['deactivate'])) {
	$mysql->query(SQL_ACTIVATE_ALL_PRODUCTS);

	$statement = $mysql->prepare(SQL_DEACTIVATE_PRODUCT);
	$statement->bind_param('i', $product);

	foreach ($_POST['admin'] as $product) {
		$statement->execute();
	}

	header('Location: ' . $_SERVER['HTTP_REFERER'] . '#admin');
}

$mysql->close();

?>
