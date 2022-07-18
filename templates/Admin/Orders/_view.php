<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="orders view large-9 medium-8 columns content">
    <h3><?= $this->Backoffice->truncate($order->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($order->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Company') ?></th>
                <td><?= $order->has('company') ? $this->Html->link($order->company->name, ['controller' => 'Companies', 'action' => 'view', $order->company->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Partner') ?></th>
                <td><?= $order->has('partner') ? $this->Html->link($order->partner->name, ['controller' => 'Partners', 'action' => 'view', $order->partner->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('User') ?></th>
                <td><?= $order->has('user') ? $this->Html->link($order->user->name, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Order Status') ?></th>
                <td><?= $order->has('order_status') ? $this->Html->link($order->order_status->name, ['controller' => 'OrderStatus', 'action' => 'view', $order->order_status->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Address') ?></th>
                <td><?= $order->has('address') ? $this->Html->link($order->address->name, ['controller' => 'Addresses', 'action' => 'view', $order->address->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Billing') ?></th>
                <td><?= $order->has('billing') ? $this->Html->link($order->billing->id, ['controller' => 'Billings', 'action' => 'view', $order->billing->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Delivery Date') ?></th>
                <td><?= h($order->delivery_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Observations') ?></th>
                <td><?= h($order->observations) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($order->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($order->modified) ?></td>
            </tr>
        </table>
    </div>

    <div class="related">
        <?php if (!empty($order->order_evolutions)): ?>
            <h4><?= __('Related Order Evolutions') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('User Id') ?></th>
                        <th scope="col"><?= __('Order Id') ?></th>
                        <th scope="col"><?= __('Order Status Id') ?></th>
                        <th scope="col"><?= __('Date Start') ?></th>
                        <th scope="col"><?= __('Date End') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($order->order_evolutions as $orderEvolutions): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($orderEvolutions->id) ?></td>
                        <td><?= $this->Backoffice->truncate($orderEvolutions->user_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orderEvolutions->order_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orderEvolutions->order_status_id) ?></td>
                        <td><?= h($orderEvolutions->date_start) ?></td>
                        <td><?= h($orderEvolutions->date_end) ?></td>
                        <td><?= h($orderEvolutions->created) ?></td>
                        <td><?= h($orderEvolutions->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'OrderEvolutions', 'data' => $orderEvolutions]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($order->order_products)): ?>
            <h4><?= __('Related Order Products') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Order Id') ?></th>
                        <th scope="col"><?= __('Product Id') ?></th>
                        <th scope="col"><?= __('Sale Price') ?></th>
                        <th scope="col"><?= __('Sale Unit') ?></th>
                        <th scope="col"><?= __('Amount') ?></th>
                        <th scope="col"><?= __('Removed') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($order->order_products as $orderProducts): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($orderProducts->id) ?></td>
                        <td><?= $this->Backoffice->truncate($orderProducts->order_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orderProducts->product_id) ?></td>
                        <td><?= h($orderProducts->sale_price) ?></td>
                        <td><?= h($orderProducts->sale_unit) ?></td>
                        <td><?= h($orderProducts->amount) ?></td>
                        <td><?= h($orderProducts->removed) ?></td>
                        <td><?= h($orderProducts->created) ?></td>
                        <td><?= h($orderProducts->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'OrderProducts', 'data' => $orderProducts]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
