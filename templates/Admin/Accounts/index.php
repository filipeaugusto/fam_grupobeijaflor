<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Account[]|\Cake\Collection\CollectionInterface $accounts
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('bank') ?></th>
            <th scope="col"><?= $this->Paginator->sort('agency') ?></th>
            <th scope="col"><?= $this->Paginator->sort('account') ?></th>
            <th scope="col"><?= $this->Paginator->sort('balance') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($accounts as $account) : ?>
            <tr class="<?= $account->balance < 0 ? 'text-dangers' : null; ?>">
                <td>
                    <?= $this->Html->tag('i', null, ['class' => $account->status_emoji]) ?>
                    <?= $this->Text->truncate($account->id, 8, ['ellipsis' => '', 'exact' => true]) ?>
                </td>
                <td><?= $account->has('company') ? $this->Html->link($account->company->name, ['controller' => 'Companies', 'action' => 'view', $account->company->id]) : '' ?></td>
                <td><?= h($account->bank) ?></td>
                <td><?= h($account->agency) ?></td>
                <td><?= h($account->account) ?></td>
                <td><span class="<?= $account->balance < 0 ? 'text-danger' : null; ?>"><?= $this->Backoffice->currency($account->balance) ?></span></td>
                <td><?= h($account->modified) ?></td>
                <td class="actions">
                    <?php
                    echo $this->Html->link(__('{0} Transfer', '<i class="bi bi-wallet2"></i>'),
                        '#modalBackoffice',
                        [
                            'escape' => false,
                            'class' => $account->balance <= 0 ? 'btn btn-secondary' : 'btn btn-success',
                            'title' => __('Realizar transferência'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modalBackoffice',
                            'data-remote' => $this->Url->build(['action' => 'transfer', $account->id]),
                        ]
                    );
                    ?>
                    <?php echo $this->Html->link(__('{0} Extract', '<i class="bi bi-graph-up"></i>'), ['action' => 'extract', $account->id], ['escape' => false, 'class' => 'btn btn-info']); ?>
                    <?php echo $this->element('table-actions', ['data' => $account]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
