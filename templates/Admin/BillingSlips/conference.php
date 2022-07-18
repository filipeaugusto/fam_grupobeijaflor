<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Billing[]|\Cake\Collection\CollectionInterface $billingSlips
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
            <th scope="col" class="actions text-center" colspan="2"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($billingSlips as $billingSlip) : ?>
            <tr id="<?= h($billingSlip->id) ?>" title="<?= h($billingSlip->has('account') ? $billingSlip->account->details : $billingSlip->description) ?>">
                <td><?= __('<i class="bi bi-arrows-collapse text-info"></i>') ?></td>
                <td>
                    <?= $this->Backoffice->orderFilterBy($billingSlip->company) ?>
                    <?= $billingSlip->has('company') ? $this->Html->link($billingSlip->company->name, ['controller' => 'Companies', 'action' => 'view', $billingSlip->company->id]) : '' ?>
                </td>
                <td>
                    <?php
                    if ($billingSlip->has('partner')) {
                        echo $this->Backoffice->orderFilterBy($billingSlip->partner);
                        echo $this->Html->link($billingSlip->partner->name, ['controller' => 'partners', 'action' => 'view', $billingSlip->partner_id]);
                    }
                    if ($billingSlip->has('user')) {
                        echo $this->Backoffice->orderFilterBy($billingSlip->user);
                        echo $this->Html->link($billingSlip->user->name, ['controller' => 'users', 'action' => 'view', $billingSlip->user_id]);
                    }
                    ?>
                </td>
                <td><?= $this->Backoffice->truncate($billingSlip->description, 62); ?></td>
                <td><?= h($billingSlip->deadline) ?></td>
                <td><?= $this->Backoffice->currency($billingSlip->value) ?></td>
                <td><?= h($billingSlip->created) ?></td>
                <td style="padding-left: 0px; padding-right: 0px"><?= $this->Backoffice->archive($billingSlip->archive) ?></td>
                <td class="actions">
                    <?= $this->Form->postLink('<i class="bi bi-check-all"></i>', ['action' => 'conference_final', $billingSlip->id], ['escape' => false, 'class' => __('btn {0}', $billingSlip->conference_final ? 'btn-success' : 'btn-outline-info'), 'confirm' => 'Deseja confirmar essa ação?', 'title' => __('Conference')]) ?>
                    <?php // echo $this->element('table-actions', ['data' => $billingSlip]); ?>
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
