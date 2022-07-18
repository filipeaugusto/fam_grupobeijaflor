<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderProduct[]|\Cake\Collection\CollectionInterface $orderProducts
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('order_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('product_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('sale_price') ?></th>
            <th scope="col"><?= $this->Paginator->sort('sale_unit') ?></th>
            <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
            <th scope="col"><?= $this->Paginator->sort('removed') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($orderProducts as $orderProduct) : ?>
            <tr>
                <td><?= $this->Text->truncate($orderProduct->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td><?= $orderProduct->has('order') ? $this->Html->link($orderProduct->order->id, ['controller' => 'Orders', 'action' => 'view', $orderProduct->order->id]) : '' ?></td>
                <td><?= $orderProduct->has('product') ? $this->Html->link($orderProduct->product->name, ['controller' => 'Products', 'action' => 'view', $orderProduct->product->id]) : '' ?></td>
                <td><?= $this->Backoffice->currency($orderProduct->sale_price) ?></td>
                <td><?= h($orderProduct->sale_unit) ?></td>
                <td><?= h($orderProduct->amount) ?></td>
                <td><?= h($orderProduct->removed) ?></td>
                <td><?= h($orderProduct->created) ?></td>
                <td><?= h($orderProduct->modified) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $orderProduct]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
