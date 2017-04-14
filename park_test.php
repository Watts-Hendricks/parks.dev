<?php

require 'Park.php';

// print_r (Park::all());

// print_r(Park::paginate(4, 0));
//
$park = new Park();
$park->name = 'John';
$park->location = 'Maine';
$park->areaInAcres = 48995.91;
$park->dateEstablished = '1919-02-26';

$park->insert();
//
// echo $park->id;


?>
