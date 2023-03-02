<div class="container-fluid d-flex bg-dark text-light flex-around">
	<div class="col d-flex align-items-center">
		<h1 class="fs-1 title">Library of Us All</h1 class="fs-1">
	</div>
	<div class="p-2">
		<!--
			*
			* 
			UPLOAD PATH HERE
			*
			* 
		-->	
		<button class="btn btn-light" onclick="uploadEbook(event, this)">Upload Book</button>
		<form action="./assets/upload.php" method="post" enctype="multipart/form-data">
			<input type="file" name="ebook" style="display: none;" id="inputHidden">
		</form>
	</div>
</div>