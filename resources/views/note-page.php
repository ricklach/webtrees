<?php use Fisharebest\Webtrees\Auth; ?>
<?php use Fisharebest\Webtrees\Bootstrap4; ?>
<?php use Fisharebest\Webtrees\FontAwesome; ?>
<?php use Fisharebest\Webtrees\Functions\FunctionsPrint; ?>
<?php use Fisharebest\Webtrees\Functions\FunctionsPrintFacts; ?>
<?php use Fisharebest\Webtrees\Functions\FunctionsPrintLists; ?>
<?php use Fisharebest\Webtrees\I18N; ?>

<?php if ($note->isPendingDeletion()): ?>
	<?php if (Auth::isModerator($note->getTree())): ?>
		<?= view('alerts/warning-dissmissible', ['alert' => /* I18N: %1$s is “accept”, %2$s is “reject”. These are links. */ I18N::translate('This note has been deleted. You should review the deletion and then %1$s or %2$s it.', '<a href="#" class="alert-link" onclick="accept_changes(\'' . $note->getXref() . '\');">' . I18N::translateContext('You should review the deletion and then accept or reject it.', 'accept') . '</a>', '<a href="#" class="alert-link" onclick="reject_changes(\'' . $note->getXref() . '\');">' . I18N::translateContext('You should review the deletion and then accept or reject it.', 'reject') . '</a>') . ' ' . FunctionsPrint::helpLink('pending_changes')]) ?>
	<?php elseif (Auth::isEditor($note->getTree())): ?>
		<?= view('alerts/warning-dissmissible', ['alert' => I18N::translate('This note has been deleted. The deletion will need to be reviewed by a moderator.') . ' ' . FunctionsPrint::helpLink('pending_changes')]) ?>
	<?php endif ?>
<?php elseif ($note->isPendingAddition()): ?>
	<?php if (Auth::isModerator($note->getTree())): ?>
		<?= view('alerts/warning-dissmissible', ['alert' => /* I18N: %1$s is “accept”, %2$s is “reject”. These are links. */ I18N::translate('This note has been edited. You should review the changes and then %1$s or %2$s them.', '<a href="#" class="alert-link" onclick="accept_changes(\'' . $note->getXref() . '\');">' . I18N::translateContext('You should review the changes and then accept or reject them.', 'accept') . '</a>', '<a href="#" class="alert-link" onclick="reject_changes(\'' . $note->getXref() . '\');">' . I18N::translateContext('You should review the changes and then accept or reject them.', 'reject') . '</a>') . ' ' . FunctionsPrint::helpLink('pending_changes')]) ?>
	<?php elseif (Auth::isEditor($note->getTree())): ?>
		<?= view('alerts/warning-dissmissible', ['alert' => I18N::translate('This note has been edited. The changes need to be reviewed by a moderator.') . ' ' . FunctionsPrint::helpLink('pending_changes')]) ?>
	<?php endif ?>
<?php endif ?>

<div class="d-flex mb-4">
	<h2 class="wt-page-title mx-auto">
		<?= $note->getFullName() ?>
	</h2>
	<?php if ($note->canEdit() && !$note->isPendingDeletion()): ?>
		<?= view('note-page-menu', ['record' => $note]) ?>
	<?php endif ?>
</div>

<div class="wt-page-content">
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" role="tab" href="#details">
				<?= I18N::translate('Details') ?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link<?= empty($individuals) ? ' text-muted' : '' ?>" data-toggle="tab" role="tab" href="#individuals">
				<?= I18N::translate('Individuals') ?>
				<?= Bootstrap4::badgeCount($individuals) ?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link<?= empty($families) ? ' text-muted' : '' ?>" data-toggle="tab" role="tab" href="#families">
				<?= I18N::translate('Families') ?>
				<?= Bootstrap4::badgeCount($families) ?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link<?= empty($media_objects) ? ' text-muted' : '' ?>" data-toggle="tab" role="tab" href="#media">
				<?= I18N::translate('Media objects') ?>
				<?= Bootstrap4::badgeCount($media_objects) ?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link<?= empty($sources) ? ' text-muted' : '' ?>" data-toggle="tab" role="tab" href="#sources">
				<?= I18N::translate('Sources') ?>
				<?= Bootstrap4::badgeCount($sources) ?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link<?= empty($notes) ? ' text-muted' : '' ?>" data-toggle="tab" role="tab" href="#notes">
				<?= I18N::translate('Notes') ?>
				<?= Bootstrap4::badgeCount($notes) ?>
			</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active fade show" role="tabpanel" id="details">
			<table class="table wt-facts-table">
				<tr>
					<th scope="row">
						<?= I18N::translate('Shared note') ?>
						<?php if (Auth::isEditor($note->getTree())): ?>
							<div class="editfacts">
								<?= FontAwesome::linkIcon('edit', I18N::translate('Edit'), ['class' => 'btn btn-link', 'href' => 'edit_interface.php?action=editnote&ged=' . $note->getTree()->getNameUrl() . '&xref=' . $note->getXref()]) ?>
							</div>
						<?php endif ?>
					</th>
					<td><?= $text ?></td>
				</tr>
				<?php foreach ($facts as $fact): ?>
					<?php FunctionsPrintFacts::printFact($fact, $note) ?>
				<?php endforeach ?>

				<?php if ($note->canEdit()): ?>
					<?php FunctionsPrint::printAddNewFact($note->getXref(), $facts, 'NOTE') ?>
				<?php endif ?>
			</table>
		</div>

		<div class="tab-pane fade" role="tabpanel" id="individuals">
			<?= FunctionsPrintLists::individualTable($individuals) ?>
		</div>

		<div class="tab-pane fade" role="tabpanel" id="families">
			<?= FunctionsPrintLists::familyTable($families) ?>
		</div>

		<div class="tab-pane fade" role="tabpanel" id="media">
			<?= FunctionsPrintLists::mediaTable($media_objects) ?>
		</div>

		<div class="tab-pane fade" role="tabpanel" id="sources">
			<?= FunctionsPrintLists::sourceTable($sources) ?>
		</div>

		<div class="tab-pane fade" role="tabpanel" id="notes">
			<?= FunctionsPrintLists::noteTable($notes) ?>
		</div>
	</div>
</div>

<?= view('modals/ajax') ?>