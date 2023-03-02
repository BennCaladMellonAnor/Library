<?php 
	/**
	 * STAND QUERY FAST
	 */
	class SQF{
		private $conn;
		private $tmp_result;
		function __construct(){
			$iniPath = realpath(dirname(__DIR__))."/config.ini";
			$iniFile = parse_ini_file($iniPath);
			$this->__set("conn", new mysqli(
				$iniFile['host'],
				$iniFile['username'],
				$iniFile['password'],
				$iniFile['database'],
				$iniFile['port']
			));
			
		}
		public function ord_alph($array, $key){
			usort($array, function ($v1, $v2) use ($key){
				return $v1[$key] > $v2[$key];
			});
			return $array;
		}
		
		public function book_table(){
		    $ebooks = $this->queryAll("stand");
		    $ebooks = $this->ord_alph($ebooks, "name");
		    return $ebooks;
		}
		
		public function accessQueryBookName($id){
		    $connection = $this->__get("conn");
		    $sql = "SELECT name FROM stand WHERE id = $id";
		    $result = $connection->query($sql);
		    return $result->fetch_assoc();
		}
        public function getGeo($ip){
            $url = "https://api.ipbase.com/json/8.8.8.8?apikey=KMsRy8hgbfHq2hXi0wsKFSDcCpeetEeZWxfvjOPc";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }

		public function scan(){
			//Este metodo está com um bug! e essa linha é para "segurar" o bug
				//A metodologia usada no metodo dever ser diferente!
				//O scan tem que saber quis livros tem no servidor
				//Comprar o titulo e ver quais estão ou não no banco
				//O Scan deve Inserir ou Deletar do Banco
				//Sem que seja necessário rodar o TRUNCATE toda vez.
			$this->conn->query("TRUNCATE TABLE `library`.`files`");
				//O scan
					//Ou ele faz um Query para cada FileDIR
						//Perguntando se tem no DB "FILES"
					//Ou ele Pega dois arrays e separada a diferença
						//Separando de FilesDIR para FilesDB

			//Escaneia os Ebooks que não foram para Files na DB
			$filesDB = $this->queryAll("files");
			$filesDir = $this->bookStandList();

			

			$bool = false;
			$tmp = [];
			$tst = [];
			//Verifica quais nomes tem no banco
			foreach ($filesDir as $key => $value) {
				// . < : 
				foreach ($filesDB as $keyDB => $valueDB) {
						//Verifica de tem arquivos com o mesmo nome
					if ($filesDir[$key] == $filesDB[$keyDB]["name"]) {
							//Se tiver ele da set True
						$bool = true;
					}
				}
					//Verifica se o Bool achou alguem com o mesmo nome
				if (!$bool) {
						//caso não ache aquivos com o mesmo nome
						//Guarda em $tmp para eu saber quem é
					$tmp[] = $filesDir[$key];
				}else{
					//Bool achou com o mesmo
					//Precisa resetar para começar uma nova busca
					$bool = false;
				}
			}

			//Verifica se tem coisa no temp
				//Tmp é array vazio? E tamanho de tmp é > 0?
			if ($tmp != [] && sizeof($tmp) > 0) {
				$connection = $this->__get("conn");
					//Caso de Debbug
					//$count = 0;



				foreach ($tmp as $key => $value) {
					$sql = "INSERT INTO files (`name`) VALUES ('$value')";
					$result = $connection->query($sql);
					//Linha para Debbug do SQL
						//echo $count, " - ", $sql, "<br>";
						//$count++;
					if ($connection->error) {
						echo $connection->error;
					}
				}
			}
		}

		public function bookStandList(){
			$dir = dir('../assets/files/bookstand');
			$list = [];
			$count = 0;
			while($arq = $dir->read()){
				if ($arq != ".." && $arq != ".") {
					$list[] = $arq;
				}
			}
			$dir->close();
			return $list;
		}

		public function queryAll($table, $db_result = false){
			$connection = $this->__get("conn");
			$sql = "SELECT * FROM `$table`";
			$result = $connection->query($sql);

			//Caso eu queria o Objeto gerado da query
			if($db_result){
				$this->__set("tmp_result", $result);
			}else{
				//Ele não pode fazer o fetch no result se eu for usar objeto!!!
				$tmp = [];
				while ($row = $result->fetch_assoc()) {
					$tmp[] = $row;
				}
				
				return $tmp;
			}

			
		}
		public function queryColumns($columns, $table){
			$connection = $this->__get("conn");
			$sql = "SELECT $columns FROM $table";
			$result = $connection->query($sql);
			$tmp = [];
			while($row = $result->fetch_assoc()){

				$tmp[] = $row;
			}
			return $tmp;
		}
		public function queryOne($table, $column, $value){
			$connection = $this->__get("conn");
			$sql = "SELECT * FROM '$table' WHERE '$column' = '$value'";
			$result = $connection->query($sql);
			
			$row = $result->fetch_assoc();
			return $row;
		}

		public function searchBook(){
			//Procura o Ebook que não foi catalogado
			$DB = $this->queryColumns("*","files");
			$connection = $this->__get("conn");
			$debug = false;

			$size = sizeof($DB);
			$tmp = [];
			foreach ($DB as $key => $value) {
				$id = $value["id"];
				$sql = "SELECT id FROM stand WHERE file_id = $id";
				$result = $connection->query($sql);
				if ($result->num_rows == 0) {
					$tmp[] = $DB[$key];
				}
				if($debug){
					//echo "Var DB:<br>";
					//print_r($DB);
					echo "<br>";
					echo "<br>ID: $id <br>";
					echo "SQL: $sql <br>";
					echo "RESULT: <br>";
					print_r($result);
					echo "<br>";
					echo "NUM_ROWS: ";
					print_r($result->num_rows);
					echo "<br>";
					echo "FETCH_ASSOC: ";
					print_r($result->fetch_assoc());
					echo "<br>";
					echo "Not Added: ";
					print_r($tmp);
				}
			}
			return $tmp;
		}

		function __set($name, $value){
			$this->$name = $value;
		}

		function __get($name){
			return $this->$name;
		}
	}

?>