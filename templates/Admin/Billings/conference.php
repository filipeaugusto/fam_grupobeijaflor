<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Billing[]|\Cake\Collection\CollectionInterface $billings
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('type') ?></th>
            <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('id', 'Parceiro / Usuário') ?></th>
            <th scope="col"><?= $this->Paginator->sort('descricao', __('Descrição')) ?></th>
            <th scope="col"><?= $this->Paginator->sort('deadline') ?></th>
            <th scope="col"><?= $this->Paginator->sort('value') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col" class="actions"><?= $this->Paginator->sort('conference_final', __('Actions')) ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($billings as $billing) : ?>
            <tr id="<?= h($billing->id) ?>" title="<?= h($billing->has('account') ? $billing->account->details : $billing->description) ?>">
                <td><?= __($billing->type == 'input' ? '<i class="bi bi-arrow-bar-up text-success"></i>' : '<i class="bi bi-arrow-bar-down text-danger"></i>') ?></td>
                <td>
                    <?= $this->Backoffice->orderFilterBy($billing->company) ?>
                    <?= $billing->has('company') ? $this->Html->link($billing->company->name, ['controller' => 'Companies', 'action' => 'view', $billing->company->id]) : '' ?>
                </td>
                <td>
                    <?php
                    if ($billing->has('partner')) {
                        echo $this->Backoffice->orderFilterBy($billing->partner);
                        echo $this->Html->link($billing->partner->name, ['controller' => 'partners', 'action' => 'view', $billing->partner_id]);
                    }
                    if ($billing->has('user')) {
                        echo $this->Backoffice->orderFilterBy($billing->user);
                        echo $this->Html->link($billing->user->name, ['controller' => 'users', 'action' => 'view', $billing->user_id]);
                    }
                    ?>
                </td>
                <td><?= $this->Backoffice->truncate($billing->description, 62); ?></td>
                <td><?= h($billing->deadline) ?></td>
                <td><?= $this->Backoffice->currency($billing->value) ?></td>
                <td><?= h($billing->created) ?></td>
                <td class="actions">
                    <?= $this->Form->postLink('<i class="bi bi-check-all"></i>', ['action' => 'conference_final', $billing->id], ['escape' => false, 'class' => __('btn {0}', $billing->conference_final ? 'btn-success' : 'btn-outline-info'), 'confirm' => 'Deseja confirmar essa ação?', 'title' => __('Conference')]) ?>
                    <?php // echo $this->element('table-actions', ['data' => $billing]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>


<style>
    form.form-filter div.form-group {
        margin-left: 5px;
        min-width: 200px;
    }
</style>
