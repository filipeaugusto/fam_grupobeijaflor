<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderStatus[]|\Cake\Collection\CollectionInterface $orderStatus
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('active') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($orderStatus as $orderStatus) : ?>
            <tr>
                <td><?= $this->Text->truncate($orderStatus->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td><?= $orderStatus->has('parent_order_status') ? $this->Html->link($orderStatus->parent_order_status->name, ['controller' => 'OrderStatus', 'action' => 'view', $orderStatus->parent_order_status->id]) : '' ?></td>
                <td><?= $this->Backoffice->orderStatus($orderStatus) ?></td>
                <td><?= h($orderStatus->active ? __('Yes') : __('No')) ?></td>
                <td><?= h($orderStatus->created) ?></td>
                <td><?= h($orderStatus->modified) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $orderStatus, 'move' => true]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
