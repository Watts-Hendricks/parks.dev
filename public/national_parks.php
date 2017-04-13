<?php

// connnect to db, present db connection as $connection variable

require __DIR__ . "/../db_connect.php";

// Input is talking to the request superglobal

require_once '../Input.php';

$page = Input::get('page', 1);
$limit = 4;
$offset = $limit * ($page - 1);
$totalParks = $connection->query("SELECT count (*) FROM national_parks")->fetchColumn();

if($_POST) {
  $userInput = "INSERT into national_parks (name, location, date_established, area_in_acres, description)
              VALUES (:name, :location, :date_established, :area_in_acres, :description)";

    $statement = $connection->prepare($userInput);
    $statement->bindValue(':name', Input::get("nameInput"), PDO::PARAM_STR);
    $statement->bindValue(':location', Input::get("locationInput"), PDO::PARAM_STR);
    $statement->bindValue(':date_established', Input::get("dateInput"), PDO::PARAM_STR);
    $statement->bindValue(':area_in_acres', Input::get("areaInput"), PDO::PARAM_STR);
    $statement->bindValue(':description', Input::get("descInput"), PDO::PARAM_STR);

    $statement->execute();
    header('location: national_parks.php');
}

// protect from looking at blank pages past the number of results

$maxPage = ($totalParks / $limit) - 1;

// get all parks with a limit per page
//
// $query = "SELECT * FROM national_parks LIMIT {$limit} OFFSET {$offset}";
// $statement = $connection->query($query);
// $parks = [];

// get all parks with a limit per page using prepare statments
$statement = $connection->prepare("SELECT * FROM national_parks LIMIT :limit OFFSET :offset");
$statement->bindValue(':limit', $limit, PDO::PARAM_INT);
$statement->bindValue(':offset', $offset, PDO::PARAM_INT);

$statement->execute();

while ($park = $statement->fetch(PDO::FETCH_ASSOC))
{
$parks[] = $park;
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!-- Custom font-family  -->
    <link href="https://fonts.googleapis.com/css?family=PT+Mono" rel="stylesheet">
    <!-- latest compiled and minified CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- custom CSS -->
    <link rel="stylesheet" href="/css/national_parks.css">

    <title>National Parks</title>
</head>

<body>
    <main class="container">
        <h1>National Parks</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Date Established</th>
                        <th>Area in Acres</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <?php foreach($parks as $park): ?>
                <tbody>
                    <tr>
                        <td>
                            <?= $park['name'] ?>
                        </td>
                        <td>
                            <?= $park['location'] ?>
                        </td>
                        <td>
                            <?= $park['date_established'] ?>
                        </td>
                        <td>
                            <?= $park['area_in_acres'] ?>
                        </td>
                        <td>
                            <?= $park['description'] ?>
                        </td>
                    </tr>
                </tbody>
                <?php endforeach; ?>
            </table>
        </div>

              <?php $page = 1;
                  for ($i = 1; $i <= $totalParks; $i+=$limit) { ?>
                      <a href="national_parks.php?page=<?=$page?>">
                          <div class="btn btn-primary">
                              <?=$page++?>
                          </div>
                      </a>
              <?php } ?>
              <h2>Add a Park</h2>
              <div class = "container">
                <div class = "row">
                  <div class = "col-md-8 col-md-offset-4">
                    <form method="POST">
                      <div class="form-group">
                        <label class ="formBoxTitle" for="nameInput">Name</label>
                          <input type="text" class="form-control" id="nameInput" name="nameInput" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label class ="formBoxTitle" for="locationInput">Location</label>
                        <input type="text" class="form-control" id="locationInput" name="locationInput" placeholder="Location">
                      </div>
                      <div class="form-group">
                        <label class ="formBoxTitle" for="dateInput">Date Established</label>
                        <input type="text" class="form-control" id="dateInput" name="dateInput" placeholder="YYYY-MM-DD">
                      </div>
                      <div class="form-group">
                        <label class ="formBoxTitle" for="areaInput">Area in Acres</label>
                        <input type="text" class="form-control" id="areaInput" name="areaInput" placeholder="1111.11">
                      </div>
                      <div class="form-group">
                        <label class ="formBoxTitle" for="descInput">Description</label>
                        <input type="text" class="form-control" id="descInput" name="descInput" placeholder="Description">
                      </div>
                      <div class="col-md-4 text-center">
                      <button type="submit" class="btn btn-primary">
                        <i class="icon-user icon-white"></i> Submit
                      </button>
                    </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </main>
</body>

</html>
