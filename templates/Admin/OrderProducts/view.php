<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderProduct $orderProduct
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="orderProducts view large-9 medium-8 columns content">
    <h3><?= $this->Backoffice->truncate($orderProduct->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($orderProduct->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Order') ?></th>
                <td><?= $orderProduct->has('order') ? $this->Html->link($orderProduct->order->id, ['controller' => 'Orders', 'action' => 'view', $orderProduct->order->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product') ?></th>
                <td><?= $orderProduct->has('product') ? $this->Html->link($orderProduct->product->name, ['controller' => 'Products', 'action' => 'view', $orderProduct->product->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Sale Price') ?></th>
                <td><?= $this->Backoffice->currency($orderProduct->sale_price) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Sale Unit') ?></th>
                <td><?= h($orderProduct->sale_unit) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Amount') ?></th>
                <td><?= h($orderProduct->amount) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Removed') ?></th>
                <td><?= $orderProduct->removed ? __('Yes') : __('No'); ?></td>
            </tr>            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($orderProduct->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($orderProduct->modified) ?></td>
            </tr>
        </table>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
