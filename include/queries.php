<?php

define("SQL_PRODUCT_LIST",		"SELECT p.name, p.id, p.active, r.version
					 FROM scl_products AS p
					 LEFT JOIN scl_releases AS r ON p.id = r.product_id
					 LEFT JOIN scl_releases AS r2 ON (r.product_id = r2.product_id AND r2.id > r.id)
					 WHERE r2.id IS NULL");

define("SQL_ADD_CHANGE", 		"INSERT INTO scl_changes (id, date, message, is_bug)
					 VALUES (NULL, CURDATE(), ?, ?)");

define("SQL_APPEND_CHANGELOG",		"INSERT INTO scl_changelog (id, change_id, release_id, product_id)
					 VALUES (NULL, ?, NULL, ?)");

define("SQL_GET_PRODUCT_NAME",		"SELECT name FROM scl_products WHERE id = ?");

define("SQL_GET_CHANGELOG",		"SELECT c.date, c.message, c.is_bug, r.version, r.date
					 FROM scl_changelog AS cl
					 INNER JOIN scl_changes AS c ON cl.change_id = c.id
					 LEFT JOIN scl_releases AS r on cl.release_id = r.id
					 WHERE cl.product_id = ?
					 ORDER BY c.id DESC");

define("SQL_ADD_RELEASE", 		"INSERT INTO scl_releases (id, product_id, version, date)
			   		 VALUES (NULL, ?, ?, CURDATE())");

define("SQL_UPDATE_RELEASE_IDS",	"UPDATE scl_changelog SET release_id = ?
					 WHERE release_id IS NULL AND product_id = ?");

define("SQL_ADD_PRODUCT", 		"INSERT INTO scl_products (id, name, active)
					 VALUES (NULL, ?, 1)");

define("SQL_ACTIVATE_ALL_PRODUCTS", 	"UPDATE scl_products SET active = 1");

define("SQL_DEACTIVATE_PRODUCT", 	"UPDATE scl_products SET active = 0 WHERE id = ?");

?>
