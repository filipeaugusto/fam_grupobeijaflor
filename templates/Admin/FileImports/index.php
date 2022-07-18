<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FileImport[]|\Cake\Collection\CollectionInterface $fileImports
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('finished') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions text-center" colspan="2"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($fileImports as $fileImport) : ?>
            <tr>
                <td><?= $this->Text->truncate($fileImport->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td>
                    <?= $this->Backoffice->orderFilterBy($fileImport->company) ?>
                    <?= $fileImport->has('company') ? $this->Html->link($fileImport->company->name, ['controller' => 'Companies', 'action' => 'view', $fileImport->company->id]) : '' ?>
                </td>
                <td><?= h($fileImport->finished ? __('Yes') : __('No')) ?></td>
                <td><?= h($fileImport->created) ?></td>
                <td><?= h($fileImport->modified) ?></td>
                <td style="padding-left: 0px; padding-right: 0px"><?= $this->Backoffice->archive($fileImport->archive) ?></td>
                <td class="actions">
                    <?php
                        echo $this->Form->postLink('<i class="bi bi-cash-coin"></i>', ['action' => 'process', $fileImport->id], ['escape' => false, 'class' => $fileImport->finished ? 'btn btn-secondary disabled' : 'btn btn-success', 'title' => __('Process file')]);
                        echo $this->element('table-actions', ['data' => $fileImport]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
