<div style="display: flex; position: absolute; background: lightgrey; padding:50px; max-width:800px; z-index: 1; flex-wrap: wrap;">
	<div style="max-width:70%;">
		<form method="post" enctype="multipart/form-data" action="stand.php">
			<div style="display: flex; flex-direction: column;">
				<input type="file" name="photo">
				<label>Photo Name</label>
				<input type="text" name="photo-name">
				<label>Title</label>
				<input type="text" name="title">
				<input type="hidden" name="file_id" value="<?= $_GET["id"]?>">
				<label>Category</label>
				<div style="border: 1px solid black">
					<?php foreach ($category as $key => $value): ?>
						<label><?= $category[$key]["name"]?></label>
						<input type="checkbox" name="<?= $category[$key]["name"]?>" value="<?= $category[$key]["id"]?>" >|
					<?php endforeach ?>
				</div>
			</div>
				<button style="margin:10px;">send</button>
		</form>
	</div>
</div>