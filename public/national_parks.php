<?php


// connnect to db, present db connection as $connection variable

require __DIR__ . "/../Park.php";

// Input is talking to the request superglobal

require __DIR__ . '/../Input.php';

$page = Input::get('page', 1);
$limit = 4;
$offset = $limit * ($page - 1);
$totalParks = Park::count();
$parks = Park::paginate(4, $offset);
$errors = [];

if(!empty($_POST)) {

	$park = new Park();

	try {
		$park->name = Input::getString('name');
	} catch (Exception $e) {
		$errors[] = $e->getMessage();
	}

	try {
		$park->location = Input::getString('location');
	} catch (Exception $e) {
		$errors[] = $e->getMessage();
	}

	try {
		$park->dateEstablished = Input::getDate('date_established');
	} catch (Exception $e) {
		$errors[] = $e->getMessage();
	}

	try {
		$park->areaInAcres = Input::getNumber('area_in_acres');
	} catch (Exception $e) {
		$errors[] = $e->getMessage();
	}

	try {
		$park->description = Input::getString('description');
	} catch (Exception $e) {
		$errors[] = $e->getMessage();
	}
	if(empty($errors)) {
		$park->insert();
	}
}
// protect from looking at blank pages past the number of results
$maxPage = ($totalParks / $limit) - 1;
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
    <link rel="stylesheet" href="/national_parks.css">

    <title>National Parks</title>
</head>

<body>
    <main class="container">
			<?php if(!empty($errors)) : ?><?php echo "<script type='text/javascript'> alert('".implode('\n', $errors)."') </script>"; ?> <?php endif; ?>
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
                          <input type="text" class="form-control" id="nameInput" name="name" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label class ="formBoxTitle" for="locationInput">Location</label>
                        <input type="text" class="form-control" id="locationInput" name="location" placeholder="Location">
                      </div>
                      <div class="form-group">
                        <label class ="formBoxTitle" for="dateInput">Date Established</label>
                        <input type="text" class="form-control" id="dateInput" name="date_established" placeholder="YYYY/MM/DD">
                      </div>
                      <div class="form-group">
                        <label class ="formBoxTitle" for="areaInput">Area in Acres</label>
                        <input type="text" class="form-control" id="area_in_acres" name="area_in_acres" placeholder="1111.11">
                      </div>
                      <div class="form-group">
                        <label class ="formBoxTitle" for="descInput">Description</label>
                        <input type="text" class="form-control" id="descInput" name="description" placeholder="Description">
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
