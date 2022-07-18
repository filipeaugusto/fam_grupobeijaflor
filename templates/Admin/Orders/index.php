<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
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
            <th scope="col"><?= $this->Paginator->sort('partner_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
            <th scope="col" colspan="2"><?= $this->Paginator->sort('order_status_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('total_order', __('Valor')) ?></th>
            <th scope="col"><?= $this->Paginator->sort('delivery_date') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col" class="actions text-center" colspan="2"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) : ?>
            <tr>
                <td><?= $this->Text->truncate($order->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td>
                    <?= $this->Backoffice->orderFilterBy($order->company) ?>
                    <?= $order->has('company') ? $this->Html->link($order->company->name, ['controller' => 'Companies', 'action' => 'view', $order->company->id]) : '' ?>
                </td>
                <td>
                    <?= $this->Backoffice->orderFilterBy($order->partner) ?>
                    <?= $order->has('partner') ? $this->Html->link($order->partner->name, ['controller' => 'Partners', 'action' => 'view', $order->partner->id]) : '' ?>
                </td>
                <td>
                    <?= $this->Backoffice->orderFilterBy($order->user) ?>
                    <?= $order->has('user') ? $this->Html->link($order->user->first_name, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?>
                </td>
                <td class="text-right row-no-padding" style="padding-left: 0px; padding-right: 0px">
                    <?= $this->Backoffice->orderFilterBy($order->order_status) ?>
                </td>
                <td class="text-left">
                    <?= $this->Backoffice->orderStatus($order->order_status) ?>
                </td>
                <td>
                    <?= $order->has('billing') ? $this->Html->link($this->Backoffice->currency($order->total_order), ['controller' => 'billings', 'action' => 'view', $order->billing->id], ['target' => '_blank']) : $this->Backoffice->currency($order->total_order) ?>
                </td>
                <td><?= h($order->delivery_date) ?></td>
                <td><?= h($order->created) ?></td>
                <td style="padding-left: 0px; padding-right: 0px"><?= $this->Backoffice->archive($order->archive) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $order]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
