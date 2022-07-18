<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Attachment[]|\Cake\Collection\CollectionInterface $attachments
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('archive') ?></th>
            <th scope="col"><?= $this->Paginator->sort('model') ?></th>
            <th scope="col"><?= $this->Paginator->sort('foreing_key') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($attachments as $attachment) : ?>
            <tr>
                <td><?= $this->Text->truncate($attachment->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td><?= $this->Backoffice->archive($attachment->archive, ['alt' => $attachment->model, 'title' => $attachment->model, 'width' => '100px']) ?></td>
                <td><?= h($attachment->model) ?></td>
                <td><?= h($attachment->foreing_key) ?></td>
                <td><?= h($attachment->created) ?></td>
                <td><?= h($attachment->modified) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $attachment]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
