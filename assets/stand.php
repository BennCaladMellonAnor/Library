<div class="d-flex flex-row flex-wrap justify-content-start">
	<?php 
		$ebooks = $sqf->files();
		$ebooks = $sqf->getAll("stand");
		ini_set("display_errors", 0);
		
		function ord_alph($array, $key){
			usort($array, function ($v1, $v2) use ($key){
				return $v1[$key] > $v2[$key];
			});
			return $array;
		}
		
		$ebooks = ord_alph($ebooks, "name");
		$views = [];
		
		foreach($ebooks as $key => $row){
		    $views[$key] = $row["view"];
		}
		array_multisort($views, SORT_NUMERIC, $ebooks);
		$ebooks = array_reverse($ebooks);


        
		//Fazer um filtro no array caso Haja $_GET['id']
		$bool = isset($_GET["id"]);
		if ($bool) {
			$bool = $_GET["id"] == 0 ? false : true;
		}
		$filter = [];

		//Verifica se foi feito a solicitação de filtro
		if ($bool && $_GET["id"] != "") {
			//Aqui começa o filtro
			$id = intval($_GET["id"]);
			$tmp = [];
			$categoria_vazia = array(
			        "name" => "Categoria Vazia",
			        "img" => "uncategorized.jfif",
			        "file_id" => ""
			    );
			foreach ($ebooks as $key => $value) {
				if ($ebooks[$key]["category"]) {
					//Verifica se no Json tem o id solicitado pelo $_GET
					$tmp = json_decode($ebooks[$key]["category"]);
					foreach ($tmp as $chave => $value) {
						//O JSON tem o ID?
						if ($tmp->$chave == $id) {
							//Se sim, guarda
							$filter[] = $ebooks[$key];
						}else{
                            //Tem que arrumar o filtro
                            //Se a categoria estiver vazia não exibir
						}
					}
				}
			}
		}

		//Operação ternário para aplicar ou não o filtro
		$ebooks = sizeof($filter) > 0 ? $filter : $ebooks;
		
		if(isset($_SESSION["adm_mode"])){
		    if($_SESSION["adm_mode"]){
		        $show = true;
		    }
		}else{
		    $show = false;
		}
	?>
	<div class="d-flex book-stand-div">
		<?php foreach ($ebooks as $key => $value): ?>
			<div class="card text-center m-2 book-stand">
				<div class="card-head p-2 border-bottom">
					<span class="" style="font-weight:bold;">
						<?= $ebooks[$key]["name"] ?>
					</span>
				</div>
				<div class="card-body text-start bg-light p-1">
				    <?php if($show): ?>
				        <span class="bg-warning p-2 rounded-bottom position-absolute"><?= $ebooks[$key]["view"]?> Views</span>
				    <?php endif ?>
					<a  onclick="view(event, this)" href="<?php
					        $path = "./assets/files/bookstand/";
					        echo  $filter[0]["file_id"] == "" ? "#" : $sqf->getPath($ebooks[$key]["file_id"]);
					    ?>">
						<img src="./assets/files/bookimgs/<?= $ebooks[$key]["img"]?>">
					</a>
					<div style="display: none;">
						<form method="post" action="./assets/view.php">
							<input type="text" name="link" id="input-link" value="./files/bookstand/<?= $sqf->getPath($ebooks[$key]["file_id"])?>">
							<input type="text" name="id" value="<?= $ebooks[$key]["id"]?>">
						</form>
					</div>
					<div class="border-top mt-2 pt-2 book-category">
						<?php 
							$json = json_decode($ebooks[$key]["category"]);				
						?>
						<?php foreach ($json as $key => $value): ?>
							<a href="./?id=<?=$value?>" class="p-1 btn btn-sm btn-dark mx-2 mb-2 btn-category"><?= $key ?></a>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>
