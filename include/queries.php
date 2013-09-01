<?php

define("SQL_PRODUCT_LIST",		"SELECT p.name, p.id, p.active, r.version
					 FROM products AS p
					 LEFT JOIN releases AS r ON p.id = r.product_id
					 LEFT JOIN releases AS r2 ON (r.product_id = r2.product_id AND r2.date > r.date)
					 WHERE r2.date IS NULL");

define("SQL_ADD_CHANGE", 		"INSERT INTO changes (id, message, is_bug)
					 VALUES (NULL, ?, ?)");

define("SQL_APPEND_CHANGELOG",		"INSERT INTO changelog (id, change_id, release_id, product_id)
					 SELECT NULL, ?, id, ?
					 FROM releases
					 WHERE product_id = ?
					 ORDER BY date DESC
					 LIMIT 1");

define("SQL_GET_PRODUCT_NAME",		"SELECT name FROM products WHERE id = ?");

define("SQL_GET_CHANGELOG",		"SELECT c.message, r.version, r.date
					 FROM changelog AS cl
					 INNER JOIN changes AS c ON cl.change_id = c.id
					 INNER JOIN releases AS r on cl.release_id = r.id
					 WHERE cl.product_id = ?
					 ORDER BY c.id DESC");

define("SQL_ADD_RELEASE", 		"INSERT INTO releases (id, product_id, version, date)
			   		 VALUES (NULL, ?, ?, CURDATE())");

define("SQL_ADD_PRODUCT", 		"INSERT INTO products (id, name, active)
					 VALUES (NULL, ?, 1)");

define("SQL_ACTIVATE_ALL_PRODUCTS", 	"UPDATE products SET active = 1");

define("SQL_DEACTIVATE_PRODUCT", 	"UPDATE products SET active = 0 WHERE id = ?");

?>
