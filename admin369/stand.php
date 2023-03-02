<?php 
	require_once("SQF.php");
	$sqf = new SQF;

	//Preparando o $_POST
	$categorias = [];
	$passou = false;
	for ($i=0; $i < sizeof($_POST) - 1 ; $i++) { 
		if (key($_POST) == "file_id") {
			$passou = true;
		}
		if($passou){
			next($_POST);
			$categorias[key($_POST)] = current($_POST);
		}else{
			next($_POST);
		}
	}

	$json = strval(json_encode($categorias));
	$params = [];
	$params[] = $_POST["title"];
	$params[] = $json;
	$params[] = intval($_POST["file_id"]);

	//Fazer a copia do arquivo enviado pelo $_FILE
		//Diretório
	$ebookPath = realpath(dirname(__DIR__)) . "/assets/files/bookimgs";

		//Obtendo a Extensão do arquivo
	$extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
		//Operação ternário para atribuir o nome da cópia
	$fileName = $_POST["photo-name"] == "" ? $_POST["title"] : $_POST["photo-name"];

		//Fazendo a Cópia
	copy($_FILES["photo"]["tmp_name"], $ebookPath."/".$fileName.".".$extension);

		//Separando Array para salvar no Banco de Dados
	$params[] = $fileName . "." . $extension;

	//Pegar a conexão com o Banco e inserir na tabela "Stand"
		//Query SQL para inserir no Banco usando Statement
	$sql = "INSERT INTO stand(name, category, file_id, img) VALUES(?, ?, ?, ?)";
		//Conexão com DB
	$conncetion = $sqf->__get("conn");

		//Prepara o SQL para passar pelo Statement
	$stmt = $conncetion->prepare($sql);
		//Seta os parametros, tipo e valores
			//Operador Rest
	$stmt->bind_param("ssss", ...$params);

		//Verificar se é possivel executar
	if ($stmt->execute()) {
		//Se sim, volta pra index
		header("Location: index.php");
		exit();
	}else{
		//Se não continua aqui para exibir o erro
	}

?>