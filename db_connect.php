<?php
// mysql -u vagrant -p -- localhost / 127.0.0.1
// DSN - Data Source normalizer_is_normalized
// 1. Driver. mysql
// 2. Host. 127.0.0.1 or localhost
// 3. Database name. employees
// 4. username: vagrant
// 5. password: vagrant

// To connect to a MySQL database we'll use a PDO oci_fetch_object
// The PDO object will need a DSN
// require __DIR__ . '/constants.php'; //Don't forget the forward slash at the beginning, when using __DIR__
require __DIR__ . '/constants.php';

try {
  $connection = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
    DB_USER,
    DB_PASSWORD
);

$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// This is optional, we just want to show some output to confirm the connection was successful
// echo $connection->getAttribute(PDO::ATTR_CONNECTION_STATUS), PHP_EOL;
} catch (PDOException $e) {
    echo $e->getMessage(), PHP_EOL;
}


 ?>
