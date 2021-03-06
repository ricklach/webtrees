<?php use Fisharebest\Webtrees\I18N; ?>

<?= view('components/breadcrumbs', ['links' => [route('admin-control-panel') => I18N::translate('Control panel'), $title]]) ?>

<h1><?= $title ?></h1>

<p>
	<?= I18N::translate('Files marked with %s are required for proper operation and cannot be removed.', view('icons/ban')) ?>
</p>

<form method="post">
	<input type="hidden" value="admin-clean-data">
	<?= csrf_field() ?>
	<ul class="fa-ul">
		<?php
		foreach ($entries as $entry) {
			if (in_array($entry, $protected)) {
				echo '<li><span class="fa-li">' . view('icons/ban') . '</span>', e($entry), '</li>';
			} else {
				echo '<li><span class="fa-li">' . view('icons/delete') . '</span>';
				echo '<label>';
				echo '<input type="checkbox" name="to_delete[]" value="', e($entry), '"> ';
				echo e($entry);
				echo '</label></li>';
			}
		}
		?>
	</ul>

	<button class="btn btn-danger" type="submit">
      <?= view('icons/delete') ?>
		<?= /* I18N: A button label. */ I18N::translate('delete') ?>
	</button>
</form>
