<?php 
    ini_set("display_errors", 1);
	require_once("SQF.php");
	$SQF = new SQF();
	$result = $SQF->queryAll("who-access");
	foreach ($result as $key => $value){
	  $id = intval($result[$key]["book"]);
	  $result[$key]["book"] = $SQF->accessQueryBookName($id);
	  $result[$key]["json-resp"] = json_decode($result[$key]["json-resp"]);
	}
    $result = array_reverse($result, true);
?>
<!DOCTYPE html>
<html>
<head>
	<title>ACESS | ADM</title>
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
	<div class="d-flex flex-column">
		<div>
			<table class="table table-sm table-hover table-bordered">
				<thead class="table-danger text-center">
					<tr>
					    <th>ID</th>
						<th>REGISTER</th>
						<th>INTERNET PROTOCOL</th>
						<th>BOOK</th>
						<th>REGION</th>
						<th>CITY</th>
						<th>LATITUDE</th>
						<th>LONGITUDE</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($result as $key => $value): ?>
						<tr>
						    <td><?= $key+1 ?></td>
    						<td><?= $result[$key]["register"] ?></td>
    						<td><?= $result[$key]["address"] ?></td>
    						<td><?= $result[$key]["book"]["name"]?></td>
    						<td><?= $result[$key]["json-resp"]->region_name ?></td>
    						<td><?= $result[$key]["json-resp"]->city ?></td>
    						<td><?= $result[$key]["json-resp"]->latitude ?></td>
    						<td><?= $result[$key]["json-resp"]->longitude ?></td>
    					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>