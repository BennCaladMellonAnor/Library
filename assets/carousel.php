<?php 
	$category = $sqf->category();
	$max = 8;
	$key = 0;
	$size = sizeof($category);
	$ceil = ceil($size/$max);
?>

<div class="bg-secondary carousel-father">
	<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
		<div class="carousel-indicators" style="margin-bottom:0; display: flex;">
			<?php for ($i=0; $i < $ceil; $i++):?>
				<button type="button" class="<?php if($i == 0){echo("active");} ?>" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $i ?>"></button>
			<?php endfor ?>
		</div>
		<div class="carousel-inner">
			<?php for ($i=0; $i < $ceil ; $i++): ?>
				<div class="carousel-item <?php 
						if($i == 0){ echo("active");}
					 ?>">
					<?php for ($j= 0; $j < $max; $j++):?>
						<?php if ($key < $size): ?>
							<a class="bg-dark text-light btn-category" href="./?id=<?= $category[$key]["id"]?>"><?= $category[$key]["name"] ?></a>
							<?php
								$key++;
							?>
						<?php endif ?>
					<?php endfor ?>
				</div>
			<?php endfor ?>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
		</button>
	</div>
</div>