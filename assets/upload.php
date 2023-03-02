<?php 
	//print_r($_FILES);

	$path = dirname(__DIR__) . "/assets/files/bookstand";

	$file = $_FILES["ebook"]["tmp_name"];
	$name = $_FILES["ebook"]["name"];

	//Usar isso aqui para filtrar o que é PDF e oque não é!!!
	$pathInfo = pathinfo($_FILES["ebook"]["name"]);

	copy($file, $path ."/". $name);
	header("Location: ../index.php");
	exit();
	
	$debug = false;
	
	if($debug){
	    $array = [
	          "PATH" => $path,
	          "NAME" => $name,
	          "PATH INFO" => $pathInfo,
	          "FILES" => $_FILES
	        ];
	    foreach($array as $key => $value){
	        echo "<b style='border-bottom:1px solid black;'>$key: </b>";
	       echo "<span style='border-bottom:1px solid black;'>" . var_dump($array[$key]) . "</span>";
	        echo"<br>";
	    }
	}

?>