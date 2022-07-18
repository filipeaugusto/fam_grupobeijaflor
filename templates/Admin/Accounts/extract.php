<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Billing[]|\Cake\Collection\CollectionInterface $billings
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<h3><?= h($account->details) ?></h3>

<div class="row mt-5 mb-5">
    <div class="col-md-12">
        <?php echo $this->element('Dashboard/billings', ['data' => $dashboard]); ?>
    </div>
</div>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('type') ?></th>
            <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('foreing_key', __('Information')) ?></th>
            <th scope="col"><?= $this->Paginator->sort('deadline') ?></th>
            <th scope="col"><?= $this->Paginator->sort('value') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($billings as $billing) : ?>
            <tr id="<?= h($billing->id) ?>" title="<?= h($billing->description) ?>">
                <td><?= __($billing->type == 'input' ? '<i class="bi bi-arrow-bar-up text-success"></i>' : '<i class="bi bi-arrow-bar-down text-danger"></i>') ?></td>
                <td>
                    <?= $billing->has('company') ? $this->Html->link($billing->company->name, ['controller' => 'Companies', 'action' => 'view', $billing->company->id]) : '' ?>
                </td>
                <td><?= $this->Backoffice->truncate($billing->description, 72) ?></td>
                <td><?= h($billing->deadline) ?></td>
                <td><?= $this->Backoffice->currency($billing->value) ?></td>
                <td><?= h($billing->created) ?></td>
                <td><?= h($billing->modified) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
