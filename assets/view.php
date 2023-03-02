<?php 
	require_once("database/database.php");

	$SQF = new SQF();
	$link = $_POST["link"];
	echo "FECHADO TEMPORÁRIAMENTE PARA MANUTENÇÃO <br>";
	
	//$SQF->array_debug($_SERVER);
	//$ip = filter_input(INPUT_SERVER, REMOTE_ADDR, FILTER_VALIDATE_IP);
    //echo $ip;
	//$SQF->array_debug($_HTTP_SERVER_VARS);
	

	date_default_timezone_set("America/Sao_Paulo");

	//Obtem o tipo de host. 0 - Local | 1 - Externo
	$host_type = $_SERVER['HTTP_HOST'] == "localhost" || "127.0.0.1" ? 0 : 1;

	//Obtem o IP do usuário se for Local não tem como ai fica o padrã0	
	$ADDR = !$host_type ? "127.0.0.1" : $_SERVER['REMOTE_ADDR'];


	//$address = filter_input(INPUT_SERVER, REMOTE_ADDR, FILTER_VALIDATE_IP);
	$address = $host_type ? filter_input(INPUT_SERVER, $ADDR, FILTER_VALIDATE_IP) : '127.0.0.1';
	$id = intval($_POST["id"]);
	$date = new DateTime();
    $register = strval($date->format("d/m/Y H:i:s A"));
    $json = $SQF->getGeo($address);
    $SQF->whoInsert($address, $id, $register, $json);
	
	
	if ($SQF->click($_POST["id"])) {
		header("Location: $link");
		exit();
	}else{
		header("Location: ./");
		exit();
	}
?>