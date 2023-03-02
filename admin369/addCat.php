<?php 
	require_once("SQF.php");

	$sqf = new SQF;

	$name = strval($_POST["name"]);

	$connection = $sqf->__get("conn");

	$stmt = $connection->prepare("INSERT INTO categorias(`name`) VALUES(?)");

	$stmt->bind_param("s", $name);

	if ($stmt->execute()) {
		header("Location: index.php");
		exit();
	}
?>