<?php use App\Model\Table\OrderStatusTable;

$this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<?php echo $this->element('Shop/sub-menu-actions', ['shoppingCart' => $order, 'partner' => $order->partner, 'disabled' => 'disabled']); ?>

<div class="shoppingCarts view large-9 medium-8 columns content">
    <div class="row">
        <div class="col-sm-12 col-md-4 mb-3">
            <div class="card border-0">
                <div class="card-header card-2">
                    <p class="card-text text-muted mt-md-4 mb-2 space">CHECKOUT <span class=" small text-muted ml-2 cursor-pointer">SHIPPING DETAILS</span> </p>
                    <hr class="my-2">
                    <?= $this->Backoffice->orderStatus($order->order_status) ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-auto mt-0">
                            <p><b><?= h($order->partner->name); ?></b></p>
                        </div>
                        <div class="col-auto">
                            <p><b><?= $this->Backoffice->document($order->partner->document); ?></b> </p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <p class="text-muted mb-2">PAYMENT DETAILS</p>
                            <hr class="mt-0">
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-auto mt-0">
                            <p><b><?= __('Quantity products'); ?></b></p>
                        </div>
                        <div class="col-auto">
                            <p><b><?= h($order->quantity_products); ?></b> </p>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-auto mt-0">
                            <p><b><?= __('Quantity items'); ?></b></p>
                        </div>
                        <div class="col-auto">
                            <p><b><?= h($order->quantity_items); ?></b> </p>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-auto mt-0">
                            <p><b><?= __('Total order'); ?></b></p>
                        </div>
                        <div class="col-auto">
                            <p><b><?= $this->Backoffice->currency($order->total_order); ?></b> </p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <p class="text-muted mb-2">BILLING INFORMATION</p>
                            <hr class="mt-0">
                        </div>
                    </div>
                    <?= $order->has('billing') ? $this->Html->link(__('VIEW BILLING'), ['controller' => 'Billings', 'action' => 'view', $order->billing->id], ['class' => 'btn btn-lg btn-block btn-info']) : '' ?>

                    <?php if (is_null($order->billing_id)) { ?>
                        <?= $this->Form->postLink(__('GENERATE BILLING'), ['controller' => 'Orders',  'action' => 'generateBilling', $order->id], ['confirm' => __('Are you sure you want to prev # {0}?', $order->id), 'title' => __('Activate'), 'class' => __('btn btn-lg btn-block {0}', $order->move_next === false && $order->order_status->type !== OrderStatusTable::TYPE_CANCEL ? 'btn-outline-info' : 'btn-outline-danger disabled'), 'escape' => false]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8 mb-3">
            <h3><?= $this->Backoffice->truncate($order->id) ?></h3>
            <div class="table-responsive">
                <table class="table table-hover">
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
                        <th scope="row"><?= __('Address') ?></th>
                        <td><?= $order->has('address') ? $this->Html->link($order->address->name, ['controller' => 'Addresses', 'action' => 'view', $order->address->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Delivery Date') ?></th>
                        <td><?= h($order->delivery_date) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($order->created) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="related">
        <div class="card border-0">
            <div class="card-header">
                <p class="card-text text-muted mt-md-4 mb-2 space">YOUR ORDER <span class=" small text-muted ml-2 cursor-pointer">EDIT SHOPPING BAG</span> </p>
                <hr class="my-2">
            </div>
        </div>

        <?php if (!empty($order->order_products)): ?>
            <div class="table-responsives">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Image') ?></th>
                        <th scope="col"><?= __('Product') ?></th>
                        <th scope="col"><?= __('Amount') ?></th>
                        <th scope="col"><?= __('Sale Price') ?></th>
                        <th scope="col"><?= __('Price Total') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($order->order_products as $orderProducts): ?>
                    <tr class="<?= $orderProducts->removed ? 'table-danger' : null ?>">
                        <td>
                            <?= $this->Backoffice->archive($orderProducts->product->image, ['folder' => 'products', 'alt' => $orderProducts->product->name, 'title' => $orderProducts->product->name, 'width' => '45px']) ?>
                        </td>
                        <td><?= $this->Backoffice->truncate($orderProducts->product->name) ?></td>
                        <td><?= h($orderProducts->amount) ?></td>
                        <td><?= $this->Backoffice->currency($orderProducts->sale_price) ?></td>
                        <td><?= $this->Backoffice->currency($orderProducts->total_amount) ?></td>
                        <td class="actions">
                            <?php if($order->billing_id === null && $order->move_next === true && $order->order_status->type !== OrderStatusTable::TYPE_CANCEL) { ?>
                                <?php if(!$orderProducts->removed) { ?>
                                    <?= $this->Form->postLink(__('{0} Disable', '<i class="bi bi-x-circle"></i>'), ['controller' => 'OrderProducts',  'action' => 'disable', $orderProducts->id], ['confirm' => __('Are you sure you want to disable # {0}?', $order->id), 'title' => __('Disable'), 'class' => __('btn btn-danger {0}', $orderProducts->removed ? 'disabled' : null), 'escape' => false]) ?>
                                <?php } else { ?>
                                    <?= $this->Form->postLink(__('{0} Activate', '<i class="bi bi-arrow-counterclockwise"></i>'), ['controller' => 'OrderProducts',  'action' => 'activate', $orderProducts->id], ['confirm' => __('Are you sure you want to activate # {0}?', $order->id), 'title' => __('Activate'), 'class' => __('btn btn-success {0}', $orderProducts->removed ? null : 'disabled'), 'escape' => false]) ?>
                                <?php } ?>
                            <?php } else { ?>
                                <?php if(!$orderProducts->removed) { ?>
                                    <?= $this->Form->postLink(__('{0} Disable', '<i class="bi bi-x-circle"></i>'), 'javascript:void(0)', ['confirm' => __('Are you sure you want to disable # {0}?', $order->id), 'title' => __('Disable'), 'class' => __('btn btn-secondary disabled'), 'escape' => false]) ?>
                                <?php } else { ?>
                                    <?= $this->Form->postLink(__('{0} Activate', '<i class="bi bi-arrow-counterclockwise"></i>'), 'javascript:void(0)', ['confirm' => __('Are you sure you want to activate # {0}?', $order->id), 'title' => __('Activate'), 'class' => __('btn btn-secondary disabled'), 'escape' => false]) ?>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <?php if(is_null($order->billing_id)) { ?>
        <?= $this->Form->postLink(__('{0} Prev', '<i class="bi bi-arrow-left-circle"></i>'), ['controller' => 'Orders',  'action' => 'previous', $order->id], ['confirm' => __('Are you sure you want to prev # {0}?', $order->id), 'title' => __('Anterior'), 'class' => __('btn {0}', $order->move_previous ? 'btn-success' : 'btn-secondary disabled'), 'escape' => false]) ?>
        <?= $this->Form->postLink(__('Next {0}', '<i class="bi bi-arrow-right-circle"></i>'), ['controller' => 'Orders',  'action' => 'next', $order->id], ['confirm' => __('Are you sure you want to next # {0}?', $order->id), 'title' => __('Próxima'), 'class' => __('btn {0}', $order->move_next ? 'btn-success' : 'btn-secondary disabled'), 'escape' => false]) ?>
    <?php } ?>

    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
