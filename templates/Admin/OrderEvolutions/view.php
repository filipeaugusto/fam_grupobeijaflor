<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderEvolution $orderEvolution
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="orderEvolutions view large-9 medium-8 columns content">
    <h3><?= $this->Backoffice->truncate($orderEvolution->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($orderEvolution->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('User') ?></th>
                <td><?= $orderEvolution->has('user') ? $this->Html->link($orderEvolution->user->name, ['controller' => 'Users', 'action' => 'view', $orderEvolution->user->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Order') ?></th>
                <td><?= $orderEvolution->has('order') ? $this->Html->link($orderEvolution->order->id, ['controller' => 'Orders', 'action' => 'view', $orderEvolution->order->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Order Status') ?></th>
                <td><?= $orderEvolution->has('order_status') ? $this->Html->link($orderEvolution->order_status->name, ['controller' => 'OrderStatus', 'action' => 'view', $orderEvolution->order_status->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Date Start') ?></th>
                <td><?= h($orderEvolution->date_start) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Date End') ?></th>
                <td><?= h($orderEvolution->date_end) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($orderEvolution->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($orderEvolution->modified) ?></td>
            </tr>
        </table>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
