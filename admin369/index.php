<?php session_start(); ?>
<?php
    flush();
    ini_set("display_errors", 0);
    
	require_once("SQF.php");
	$sqf = new SQF();
	$sqf->scan();
	$files = $sqf->searchBook();
	$category = $sqf->queryAll("categorias");
	$ebooks = $sqf->book_table();

	$sqf->queryColumns("*", "files");


?>
<!DOCTYPE html>
<html>
<head>
	<title>ADMIN AREA</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
<body>
	<?php 

	ini_set("display_errors", 1);
	    $ip = filter_input(INPUT_SERVER, FILTER_VALIDATE_IP);
		if (isset($_GET["id"])) {
			include 'get.php';
		}
	?>
	<a href="../" class="return btn btn-success m-1">← | RETURN</a>
	<?php if(isset($_SESSION["adm_mode"])): ?>
	    <a href="admin_mode.php" class="btn-toggle bg-green">ADM Mode Toggle (ON)</a>
	    <a href="access.php" class="btn-toggle">ACCESS REPORT</a>
		<a href="db_backup.php" class="btn-toggle">BACKUP</a>
	<?php endif ?>
	<?php if(!isset($_SESSION["adm_mode"])): ?>
	    <a href="admin_mode.php" class="btn-toggle bg-red">ADM Mode Toggle (OFF)</a>
	<?php endif ?>
	<h1>ADMIN AREA</h1>
	<div>
	    <ul>
	        <li>
	           <a onclick="catalog()" href="#" class="btn-toggle">CATALOG</a>
	           <a onclick="edit()" href="#" class="btn-toggle">EDIT</a>
	           <a onclick="access()" href="#" class="btn-toggle">ACCESS</a>
	           <?php if(!isset($_SESSION["adm_mode"])): ?>
	                <!--Poe algo aqui que só o ADM_MODE pode acessar-->
	           <?php endif ?>
	        </li>
	    </ul>
	</div>
	<div class="flex hide" id="access">
	    <div class="item">
	        <?php include("access.php") ?>
	    </div>
	</div>
	<div class="flex hide" id="edit">
	    <div class="item">
	        <table>
    	        <thead class="text-center">
    	            <tr>
    	                <th>Name</th>
    	                <th>ID</th>
    	                <th>Categories</th>
    	                <th>Views</th>
    	                <th>File_ID</th>
    	                <th>Action</th>
    	                <th></th>
    	            </tr>
    	        </thead>
    	        <tbody>
    	            <?php foreach ($ebooks as $key => $value): ?>
    	                <tr>
                            <td><?= $ebooks[$key]["name"]?></td>
                            <td><?= $ebooks[$key]["id"]?></td>
                            <td><?= $ebooks[$key]["category"]?></td>
                            <td class="bg-warning text-center"><?= $ebooks[$key]["view"]?>x</td>
                            <td class="text-center"><?= $ebooks[$key]["file_id"]?></td>
                            <td>
								<a href="?delete=<?= $ebooks[$key]["id"]?>" class="text-danger btn m-1 btn-sm">DELETE</a> |
								<a href="?edit=<?= $ebooks[$key]["id"]?>" class="text-primary btn m-1 btn-sm">EDIT</a>
                            </td>
                            <td></td>
    	                </tr>
    	            <?php endforeach ?>
    	        </tbody>
    	    </table>
	    </div>
	</div>
	<div class="flex hide" id="catalog">
		<div class="item">
			<table>
				<thead class="text-center">
					<tr>
						<th>ID</th>
						<th>NAME</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($files as $key => $value): ?>
						<tr>
							<td><?= $files[$key]["id"] ?></td>
							
							<td>
								<a href="../assets/files/bookstand/<?= $files[$key]["name"] ?>">
									<?= $files[$key]["name"] ?>
							    </a>
							</td>
							<td class="text-center">
								<a href="./?id=<?= $files[$key]["id"] ?>" >ADD</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
		<div class="item">
			<div>
				<span>Categoria</span>
			</div>
			<form action="addCat.php" method="post">
				<input type="text" name="name">
				<button>Registrar Categoria</button>
			</form>
			<table class="table table-sm">
				<thead>
					<tr>
						<th>ID</th>
						<th>NAME</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($category as $key => $value): ?>
						<tr>
							<td><?= $category[$key]["id"] ?></td>
							<td><?= $category[$key]["name"] ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
	<footer>
		<script type="text/javascript" src="./toggler.js"></script>
	</footer>
</body>
</html>
