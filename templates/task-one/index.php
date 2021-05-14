<?php

/**
 * @var string $title
 * @var null|string $error
 * @var null|string $result
 */

?>
<h1 class="h3"><?= $title ?></h1>


<form method="post" enctype="multipart/form-data" class="row mt-3 g-3 needs-validation" novalidate>

	<div class="col-md-4">
		<div class="form-check px-0">
			<input type="file" name="file" class="form-control" accept=".txt" required>
			<div class="invalid-feedback">Файл не выбран</div>
		</div>
	</div>

	<div class="col-12">
		<button class="btn btn-primary" type="submit">Submit form</button>
	</div>
</form>

<div class="row mt-4">
	<div class="col">
		<?php if (null !== $result): ?>
			<div class="alert alert-success" role="alert">
				 Файл удачно загружен.
			</div>
			<?php foreach ($result as $line): ?>
			<p><?= $line ?></p>
			<?php endforeach; ?>
		<?php elseif (null !== $error): ?>
			<div class="alert alert-danger" role="alert">
				<?= $error ?>
			</div>
		<?php endif; ?>
	</div>
</div>

