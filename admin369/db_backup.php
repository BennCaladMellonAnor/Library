<?php
    require_once("SQF.php");
    $sqf = new SQF();


    $connection = $sqf->__get("conn");
    $result = $connection->query("SHOW TABLES");
    //Aqui pega quais tabelas tenho no banco de dados
    $tables = [];
    while($row = $result->fetch_row()){
        $tables[] = $row;
    }

    $tmp_line = "";

    //Aqui conta quantas tabelas são no total
        //Embora eu sei que esse processo podia ter sido feito junto com a query "SHOW TABLES" usando algo como $result->num_rows
    foreach($tables as $value){
        $sqf->queryAll($value[0], true);
        $columns = $sqf->__get("tmp_result");
            // $columns = $connection->query( "SELECT * FROM `" . $value[0] . "`;");
        $columns_num = mysqli_num_fields($columns);
        
        //DROP TABLE IF EXISTS, caso já existe a tabela, para ele sobrescrever
        $tmp_line .= "DROP TABLE IF EXISTS `" . $value[0] . "`; ";

        //Pesquisa como a coluna é criada, como deve ser criada a tabela?
        $search_create_column = "SHOW CREATE TABLE `" . $value[0] . "`; ";
        $result = $connection->query($search_create_column);
        $row_result = $result->fetch_row();
            //var_dump($row_result);
            //Escreve na linha
            $tmp_line .= "\n\n" . $row_result[1] . ";\n\n";
                //echo $tmp_line;
            
            //Percorrer o array de colunas, e fazer um fetch nas linhas
            for($i = 0; $i < $columns_num; $i++){
                //Ler o tipo de cada coluna no DB
                    //var_dump($columns->fetch_row());
                    //echo "<br>";
                while($row_type_column = $columns->fetch_row()){
                    //var_dump($row_type_column);
                   
                    //Cria a instrução de quais valores vão ser inseridos de acordo com o que tem no banco
                    $tmp_line .= "INSERT INTO `" . $value[0] . "` VALUES(";  
                    
                    //Ler/pegar as linhas/dados de cada tabela
                    for($j = 0; $j < $columns_num; $j ++){
                        $row_type_column[$j] = addslashes($row_type_column[$j]);
                        $row_type_column[$j] = str_replace("\n", "\\n", $row_type_column[$j]);

                        if(isset($row_type_column[$j])){
                            $tmp_line .= "`" . $row_type_column[$j] . "`";
                        }else{
                            $tmp_line .= '""';
                        }

                        if($j < $columns_num - 1){
                            $tmp_line .= ',';
                        }
                    }
                    //Fechando a instrução
                    $tmp_line .= ");\n";
                }
                //Fechando a linha
                $tmp_line .= "\n\n";
                    //echo $tmp_line;
            }
    }

    //Usar o diretório de Backup
    $dir = 'backup/';
    if(!is_dir($dir)){
        mkdir($dir, 0777, true);
        chmod($dir, 0777);
    }
    //Nome do arquivo de backup
    $data = date('Y-m-d-h-i-s');
    $file_name = $dir. "sql_backup_" . $data;

    //Iniciar o arquivo e escrever nele
    $file = fopen($file_name . '.sql', 'w+');
    fwrite($file, $tmp_line);
    fclose($file);

    //Montagem do link do arquivos
    $download = $file_name . ".sql";

    // if(file_exists($download)){
    //     header("Pragma: public");
    //     header("Expires: 0");
    //     header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //     header("Cache-Control: private", false);
    //     header("Content-Type: application/force-download");
    //     header("Content-Disposition: attachment; filename=\"" . basename($download) . "\";");
    //     header("Content-Transfer-Encoding: binary");
    //     header("Content-Length: " . filesize($download));
    //     readfile($download);
    // }else{

    // }
    header("Location:index.php");
    
?>