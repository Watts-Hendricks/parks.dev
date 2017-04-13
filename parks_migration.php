<?php

require __DIR__ . '/db_connect.php';

$query = 'DROP TABLE IF EXISTS national_parks;';
$connection->exec($query);

$createParksTable = 'CREATE TABLE national_parks (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(100),
  location varchar(100),
  date_established DATE,
  area_in_acres DOUBLE UNSIGNED,
  description TEXT,
  PRIMARY KEY (id)
)';
$connection->exec($createParksTable);
 ?>
