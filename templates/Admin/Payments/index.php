<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('pay_when') ?></th>
            <th scope="col"><?= $this->Paginator->sort('repeat_value') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $payment) : ?>
            <tr>
                <td class=""><?= $this->Text->truncate($payment->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td><?= h($payment->name) ?></td>
                <td><?= $this->Number->format($payment->pay_when) ?></td>
                <td><?= h($payment->repeat_value ? __('Yes') : __('No')) ?></td>
                <td><?= h($payment->created) ?></td>
                <td><?= h($payment->modified) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $payment]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->Form->postLink(__('Generate payments {0}', '<i class="bi bi-credit-card"></i>'), ['action' => 'generate'], ['confirm' => __('Do you really want to create payments for the period # {0}?', date('F/Y')), 'escape' => false, 'class' => 'btn btn-success float-right', 'title' => __('Generate')]) ?>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>

