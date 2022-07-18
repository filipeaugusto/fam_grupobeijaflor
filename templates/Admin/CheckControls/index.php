<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CheckControl[]|\Cake\Collection\CollectionInterface $checkControls
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="row mt-5 mb-5">
    <div class="col-md-12">
        <?php echo $this->element('Dashboard/billings', ['data' => $dashboard]); ?>
    </div>
</div>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('partner_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('document') ?></th>
            <th scope="col"><?= $this->Paginator->sort('bank') ?></th>
            <th scope="col"><?= $this->Paginator->sort('number') ?></th>
            <th scope="col"><?= $this->Paginator->sort('value') ?></th>
            <th scope="col"><?= $this->Paginator->sort('deadline') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($checkControls as $checkControl) : ?>
            <tr id="<?= h($checkControl->id) ?>">
                <td>
                    <?= $this->Html->tag('i', null, ['class' => $checkControl->status_emoji]) ?>
                    <?= $this->Text->truncate($checkControl->id, 8, ['ellipsis' => '', 'exact' => true]) ?>
                </td>
                <td>
                    <?= $this->Backoffice->orderFilterBy($checkControl->company) ?>
                    <?= $checkControl->has('company') ? $this->Html->link($checkControl->company->name, ['controller' => 'Companies', 'action' => 'view', $checkControl->company->id]) : '' ?>
                </td>
                <td>
                    <?php
                        if ($checkControl->has('partner')) {
                            echo $this->Backoffice->orderFilterBy($checkControl->partner);
                            echo $this->Html->link($checkControl->partner->name, ['controller' => 'Partners', 'action' => 'view', $checkControl->partner->id]);
                        }
                    ?>
                </td>
                <td><?= $this->Backoffice->document($checkControl->document) ?></td>
                <td><?= h($checkControl->bank) ?></td>
                <td><?= h($checkControl->number) ?></td>
                <td><?= $this->Backoffice->currency($checkControl->value) ?></td>
                <td><?= h($checkControl->deadline) ?></td>
                <td><?= h($checkControl->created) ?></td>
                <td><?= h($checkControl->modified) ?></td>
                <td class="actions">
                    <?php if (!$checkControl->confirmation) { ?>
                        <?= $this->Form->postLink('<i class="bi bi-clipboard"></i>', ['action' => 'confirmation', $checkControl->id], ['escape' => false, 'class' => 'btn btn-outline-secondary', 'title' => __('Pending confirmation')]) ?>
                        <?= $this->Form->postLink('<i class="bi bi-wallet2"></i>', '', ['escape' => false, 'class' => 'btn btn-outline-secondary disabled', 'title' => __('Deposit')]) ?>
                    <?php } else { ?>
                        <?= $this->Form->postLink('<i class="bi bi-clipboard-check"></i>', ['action' => 'confirmation', $checkControl->id], ['escape' => false, 'class' => 'btn btn-success', 'title' => __('Confirmation')]) ?>
                        <?php
                        echo !$checkControl->destination ? $this->Html->link('<i class="bi bi-wallet"></i>',
                            '#modalBackoffice',
                            [
                                'escape' => false,
                                'class' => 'btn btn-danger',
                                'title' => __('Deposit'),
                                'data-toggle' => 'modal',
                                'data-target' => '#modalBackoffice',
                                'data-remote' => $this->Url->build(['action' => 'deposit', $checkControl->id]),
                            ]
                        ) : $this->Form->postLink('<i class="bi bi-wallet2"></i>', '', ['escape' => false, 'class' => 'btn btn-success disabled', 'title' => __('Deposit')]);
                        ?>
                    <?php } ?>

                    <?php echo $this->element('table-actions', ['data' => $checkControl]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
