<?php
require __DIR__ . '/parks_migration.php';

$deleteRecords = 'TRUNCATE national_parks';
$connection->exec($deleteRecords);


$parks = [
    ['name' => 'Acadia',   'location' => 'Maine', 'date_established' => '1919-02-26', 'area_in_acres' => '48995.91', 'description' => 'park description goes here'],
    ['name' => 'Arches',   'location' => 'Utah', 'date_established' => '1988-10-31', 'area_in_acres' => '8256.67', 'description' => 'park description goes here'],
    ['name' => 'Badlands',   'location' => 'South Dakota', 'date_established' => '1978-11-10', 'area_in_acres' => '242755.94', 'description' => 'park description goes here'],
    ['name' => 'Big Bend',   'location' => 'Texas', 'date_established' => '1944-06-12', 'area_in_acres' => '801163.21', 'description' => 'park description goes here'],
    ['name' => 'Biscayne',   'location' => 'Florida', 'date_established' => '1980-06-28', 'area_in_acres' => '172971.11', 'description' => 'park description goes here'],
    ['name' => 'Canyonlands',   'location' => 'Utah', 'date_established' => '1964-09-12', 'area_in_acres' => '337597.83', 'description' => 'park description goes here'],
    ['name' => 'Congaree',   'location' => 'South Carolina', 'date_established' => '1003-11-10', 'area_in_acres' => '26275.82', 'description' => 'park description goes here'],
    ['name' => 'Death Valley',   'location' => 'California, Nevada', 'date_established' => '1994-10-31', 'area_in_acres' => '3373063.14', 'description' => 'park description goes here'],
    ['name' => 'Denali',   'location' => 'Alaska', 'date_established' => '1917-02-26', 'area_in_acres' => '4740911.16', 'description' => 'park description goes here'],
    ['name' => 'Everglades',   'location' => 'Florida', 'date_established' => '1934-05-30', 'area_in_acres' => '1508975.57', 'description' => 'park description goes here']
];

$statement = $connection->prepare('INSERT INTO national_parks (name, location, date_established, area_in_acres, description) VALUES (:name, :location, :date_established, :area_in_acres, :description)');


foreach ($parks as $park) {
  $statement->bindValue(':name', $park['name'], PDO::PARAM_STR);
  $statement->bindValue(':location',  $park['location'],  PDO::PARAM_STR);
  $statement->bindValue(':date_established',  $park['date_established'],  PDO::PARAM_STR);
  $statement->bindValue(':area_in_acres',  $park['area_in_acres'],  PDO::PARAM_STR);
  $statement->bindValue(':description',  $park['description'],  PDO::PARAM_STR);

    $statement->execute();
}


 ?>
