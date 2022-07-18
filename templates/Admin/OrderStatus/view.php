<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderStatus $orderStatus
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="orderStatus view large-9 medium-8 columns content">
    <h3><?= h($orderStatus->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($orderStatus->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Parent Order Status') ?></th>
                <td><?= $orderStatus->has('parent_order_status') ? $this->Html->link($orderStatus->parent_order_status->name, ['controlle' => 'OrderStatus', 'action' => 'view', $orderStatus->parent_order_status->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= $this->Backoffice->orderStatus($orderStatus) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Background Color') ?></th>
                <td><?= h($orderStatus->background_color) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Font Color') ?></th>
                <td><?= h($orderStatus->font_color) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Lft') ?></th>
                <td><?= h($orderStatus->lft) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Rght') ?></th>
                <td><?= h($orderStatus->rght) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($orderStatus->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($orderStatus->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Active') ?></th>
                <td><?= $orderStatus->active ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <?php if (!empty($orderStatus->order_evolutions)): ?>
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
                    <?php foreach ($orderStatus->order_evolutions as $orderEvolutions): ?>
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
        <?php if (!empty($orderStatus->child_order_status)): ?>
            <h4><?= __('Related Order Status') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Parent Id') ?></th>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Background Color') ?></th>
                        <th scope="col"><?= __('Font Color') ?></th>
                        <th scope="col"><?= __('Active') ?></th>
                        <th scope="col"><?= __('Lft') ?></th>
                        <th scope="col"><?= __('Rght') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($orderStatus->child_order_status as $childOrderStatus): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($childOrderStatus->id) ?></td>
                        <td><?= $this->Backoffice->truncate($childOrderStatus->parent_id) ?></td>
                        <td><?= h($childOrderStatus->name) ?></td>
                        <td><?= h($childOrderStatus->background_color) ?></td>
                        <td><?= h($childOrderStatus->font_color) ?></td>
                        <td><?= h($childOrderStatus->active) ?></td>
                        <td><?= h($childOrderStatus->lft) ?></td>
                        <td><?= h($childOrderStatus->rght) ?></td>
                        <td><?= h($childOrderStatus->created) ?></td>
                        <td><?= h($childOrderStatus->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'OrderStatus', 'data' => $childOrderStatus]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($orderStatus->orders)): ?>
            <h4><?= __('Related Orders') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('Partner Id') ?></th>
                        <th scope="col"><?= __('User Id') ?></th>
                        <th scope="col"><?= __('Order Status Id') ?></th>
                        <th scope="col"><?= __('Address Id') ?></th>
                        <th scope="col"><?= __('Billing Id') ?></th>
                        <th scope="col"><?= __('Delivery Date') ?></th>
                        <th scope="col"><?= __('Observations') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($orderStatus->orders as $orders): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($orders->id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->company_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->partner_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->user_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->order_status_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->address_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->billing_id) ?></td>
                        <td><?= h($orders->delivery_date) ?></td>
                        <td><?= h($orders->observations) ?></td>
                        <td><?= h($orders->created) ?></td>
                        <td><?= h($orders->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'Orders', 'data' => $orders]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
