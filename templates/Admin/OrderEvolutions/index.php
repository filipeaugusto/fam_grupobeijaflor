<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderEvolution[]|\Cake\Collection\CollectionInterface $orderEvolutions
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('order_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('order_status_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('date_start') ?></th>
            <th scope="col"><?= $this->Paginator->sort('date_end') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($orderEvolutions as $orderEvolution) : ?>
            <tr>
                <td><?= $this->Text->truncate($orderEvolution->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td><?= $orderEvolution->has('user') ? $this->Html->link($orderEvolution->user->name, ['controller' => 'Users', 'action' => 'view', $orderEvolution->user->id]) : '' ?></td>
                <td><?= $orderEvolution->has('order') ? $this->Html->link($orderEvolution->order->id, ['controller' => 'Orders', 'action' => 'view', $orderEvolution->order->id]) : '' ?></td>
                <td><?= $orderEvolution->has('order_status') ? $this->Html->link($orderEvolution->order_status->name, ['controller' => 'OrderStatus', 'action' => 'view', $orderEvolution->order_status->id]) : '' ?></td>
                <td><?= h($orderEvolution->date_start) ?></td>
                <td><?= h($orderEvolution->date_end) ?></td>
                <td><?= h($orderEvolution->created) ?></td>
                <td><?= h($orderEvolution->modified) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $orderEvolution]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
