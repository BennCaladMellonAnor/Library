<?php 
	require_once("database/database.php");
	$sqf = new SQF;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Library of Us All</title>
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="./assets/css/media.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/stand.css">
	 <link rel="icon" type="image/x-icon" href="./assets/files/ebook.png">
</head>
<body>
	<?php 
		require('nav.php');
		require('carousel.php');
		$sqf->files();
		require('stand.php');
	?>
	<script type="text/javascript" src="./assets/upload.js"></script>
	<script type="text/javascript"></script>
</body>
</html>