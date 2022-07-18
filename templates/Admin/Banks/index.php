<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bank[]|\Cake\Collection\CollectionInterface $banks
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('code') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($banks as $bank) : ?>
            <tr>
                <td><?= $this->Text->truncate($bank->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td><?= h($bank->code) ?></td>
                <td><?= h($bank->name) ?></td>
                <td><?= h($bank->created) ?></td>
                <td><?= h($bank->modified) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $bank]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
