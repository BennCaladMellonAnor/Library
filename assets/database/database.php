<?php 
	/**
	 * STAND QUERY FAST
	 * IF YOU WANNA GO FASTER
	 */
	class SQF{
		private $conn;
		function __construct(){
			// $this->__set("conn",new mysqli("127.0.0.1:3360", "root", "", "library"));

			$iniPath = realpath(dirname(__FILE__, 3))."/config.ini";
			$iniFile = parse_ini_file($iniPath);
			$this->__set("conn", new mysqli(
				$iniFile['host'],
				$iniFile['username'],
				$iniFile['password'],
				$iniFile['database'],
				$iniFile['port']
			));
			
		}
		public function getGeo($ip){
            $url = "https://api.ipbase.com/json/$ip?apikey=KMsRy8hgbfHq2hXi0wsKFSDcCpeetEeZWxfvjOPc";
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
		public function whoInsert(...$array){
		    $conn = $this->__get("conn");
		    $sql = "INSERT INTO `who-access` (address, book, register, `json-resp`) VALUES(?, ?, ?, ?)";
		    $stmt = $conn->prepare($sql);
			
		    $stmt->bind_param("siss", ...$array);
;
		    $stmt->execute();
		}
		public function array_debug($array){
		    foreach($array as $key => $value){
		        echo "$key: ";
		        echo "$value";
		        echo "<br>";
		    }
		}
		public function click($id){
			$connection = $this->__get("conn");
			$id = intval($id);
			$sql = "SELECT view FROM stand WHERE id = $id";
			$view = current($connection->query($sql)->fetch_assoc());
			$view++;
			$connection->query("UPDATE stand SET view = $view WHERE stand . id = $id");
			return $connection->error ? false : true;
		}

		public function getPath($id) {
			$connection = $this->__get("conn");
			$sql = "SELECT name FROM files WHERE id = $id";
			$result = $connection->query($sql);
			return $result->fetch_assoc()["name"];
		}

		public function getAll($table, $bool = false){
			$connection = $this->__get("conn");
			$sql = "SELECT * FROM $table";
			$result = $connection->query($sql);
			$tmp = [];
			while ($row = $result->fetch_assoc()) {
				if ($bool) {
					$tmp[] = $row["name"];
				}else{
					$tmp[] = $row;
				}
			}
			return $tmp;
		}

		//Verificar se O banco está com os mesmos arquivos que a pasta
		//Se não adiciona ao banco a diferença
		public function scanFiles(){
			$filesDB = $this->getAll("files", true);
			$filesDir = $this->files();

			if($filesDB != $filesDir){
				$sizeDir = sizeof($filesDir);
				$sizeDB = sizeof($filesDB);
				$newFiles = [];
				$bool = false;
				for ($i=0; $i < $sizeDir; $i++) { 
					for ($j=0; $j < $sizeDB ; $j++) { 
						if ($filesDir[$i] == $filesDB[$j]) {
							$bool = true;
						}	
					}
					if (!$bool) {
							$newFiles[] = $filesDir[$i];
					}
				}

				$connection = $this->__get("conn");
				foreach ($newFiles as $key => $value) {
					$sql = "INSERT INTO files (`name`) VALUES ('$value')";
					//$result = $connection->query($sql);
					if ($connection->error) {
						echo$connection->error;
					}
				}
			}

		}

		public function files(){
			$dir = dir('./assets/files/bookstand');
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

		public function category(){
			$connection = $this->__get("conn");
			$sql = "SELECT * FROM categorias";
			$result = $connection->query($sql);

			$tmp =[];

			while ($row = $result->fetch_assoc()) {
				$tmp[] = $row;
			}

			return $tmp;
		}

		function __set($name, $connection){
			$this->$name = $connection;
		}
		function __get($name){
			return $this->$name;
		}

		function close(){
			$this->conn->close();
		}
	}

?>